<?php

namespace App\Http\Controllers;

use App\Healper\CartHealper;
use App\Http\Requests\Auth\UserdetailAdd;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CheckoutController extends Controller
{
    public function checkout(UserdetailAdd $request)
    {

        $userData = $this->userDetails($request);

        $user = $request->user();
        // $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        // $stripe = \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        // $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));

        $stripe = \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $customer = \Stripe\Customer::create(array(
            "address" => [
                "line1" => "Virani Chowk",
                "postal_code" => "411014",
                "city" => "pune",
                "state" => "Mahastra",
                "country" => "IN",
            ],
            "email" => $user->email,
            "name" => $user->name,
            "source" => $request->stripeToken
        ));

        [$cartItems] = CartHealper::getProductsAndCartItems();
        $orderItems = [];
        $lineItems = [];
        $totalPrice = 0;
        $cartItems = [];

        DB::beginTransaction();

        foreach ($cartItems as $product) {
            $quantity = $product['quantity'];
            $totalPrice += $product['price'] * $quantity;
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'INR',
                    'product_data' => [
                        'name' => $product['title'],
                        'images' => $product['image'] ? [$product['image']] : []
                    ],
                    'unit_amount' => $product['price'] * 100,
                ],
                'quantity' => $quantity,
            ];

            $cartItems[] = [
                'user_id' => $user->id,
                'product_id' => $product['id'],
                'quantity' => $quantity
            ];            

            $orderItems[] = [
                'product_id' => $product['id'],
                'quantity' => $quantity,
                'unit_price' => $product['price']
            ];

            if ($quantity !== null) {
                $this->decreaseQuantities($product['id'], $quantity);
                // $product['quantity'] -= $quantity;
                // $product->update(['quantity'=>$product['quantity'] ]);
            }
        }


        // \Stripe\Charge::create([
        //     "amount" => 100 * 100,
        //     "currency" => "usd",
        //     "customer" => $customer->id,
        //     "description" => "Test payment from itsolutionstuff.com.",
        //     "shipping" => [
        //         "name" => "Jenny Rosen",
        //         "address" => [
        //             "line1" => "510 Townsend St",
        //             "postal_code" => "98140",
        //             "city" => "San Francisco",
        //             "state" => "CA",
        //             "country" => "US",
        //         ],
        //     ]
        // ]);


        // // $session = $stripe->checkout->sessions->create([
        // $session = \Stripe\Checkout\Session::create([
        //     'line_items' =>  $lineItems,
        //     "customer" => $customer->id,
        //     'mode' => 'payment',
        //     'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
        //     'cancel_url' => route('checkout.failure', [], true),
        // ]);

        $session = \Stripe\Checkout\Session::create([
            'line_items' =>  $lineItems,
            'mode' => 'payment',
            'success_url' => route('checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.failure', [], true),
        ]);


        try {
            // cart
            if ($userData) {
                foreach ($cartItems as $cartItem) {
                    Cart::create($cartItem);
                }
                Cookie::queue(Cookie::forget('cart_items'));
            }

            // Create Order
            $orderData = [
                'total_price' => $totalPrice,
                'status' => 'Unpaid',
                'user_id' => $user->id, //$user->id
            ];
            $order = Order::create($orderData);

            // Create Order Items
            foreach ($orderItems as $orderItem) {
                $orderItem['order_id'] = $order->id;
                OrderItem::create($orderItem);
            }

            // Create Payment
            $paymentData = [
                'order_id' => $order->id,
                'amount' => $totalPrice,
                'status' => 'pending',
                'type' => 'cc',
                'created_by' => $user->id, // $user->id
                'updated_by' => $user->id,  // $user->id
                'session_id' => $session->id
            ];
            Payment::create($paymentData);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::critical(__METHOD__ . ' method does not work. ' . $e->getMessage());
            throw $e;
        }

        DB::commit();

        Cart::where(['user_id' => $user->id])->delete();
        // Cookie::queue(Cookie::forget('cart_items'));

        return response()->json([
            'stripeUrl' => $session->url,
            'session_id' => $session->id
        ]);
    }

    public function success(Request $request)
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $sessionId = $request->get('session_id');

        try {
            $session = \Stripe\Checkout\Session::retrieve($sessionId);
            if (!$session) {
                throw new NotFoundHttpException();
            }

            $payment = Payment::query()
                ->where(['session_id' => $sessionId])
                ->whereIn('status', 'pending')
                ->first();
            if (!$payment) {
                throw new NotFoundHttpException();
            }
            if ($payment->status === 'pending') {
                $this->updateOrderAndSession($payment);
            }
            $customer = \Stripe\Customer::retrieve($session->customer);

            $data = [
                'customer' => $customer,
            ];

            return $this->response(true, $data, 'Order Created Success function');

            // return view('checkout.success', compact('customer'));
        } catch (NotFoundHttpException $e) {
            return response()->json(['success' => false, 'message' => 'Throw error', 'error' => $e]);
            // throw $e;
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Payment exception Failed', 'error' => $e]);
            // return view('checkout.failure', ['message' => $e->getMessage()]);
        }
    }

    public function failure(Request $request)
    {
        return response()->json(['success' => false, 'message' => 'Payment Failed', 'error' => $request]);
        // return view('checkout.failure', ['message' => ""]);
    }

    private function updateOrderAndSession(Payment $payment)
    {
        DB::beginTransaction();
        try {
            $payment->status = 'paid'; // PaymentStatus::Paid->value;
            $payment->update();

            $order = $payment->order;

            $order->status = 'paid'; // OrderStatus::Paid->value;
            $order->update();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::critical(__METHOD__ . ' method does not work. ' . $e->getMessage());
            throw $e;
        }

        DB::commit();
    }

    protected function decreaseQuantities($productId, $quantity)
    {
        $product = Product::find($productId);
        $product->update(['quantity' => $product->quantity - $quantity]);
    }
}
