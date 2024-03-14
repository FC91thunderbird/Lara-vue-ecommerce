<?php

namespace App\Http\Controllers;

use App\Healper\CartHealper;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{
    public function index()
    {
        [$cartItems] = CartHealper::getProductsAndCartItems();
        $total = 0;

        foreach ($cartItems as $product) {
            $total += $product['price'] * $product['quantity'];
        }

        $data = [
            'cartItems' => $cartItems, 
            'total' => $total
        ];

        return $this->response(true, $data, "Cart Data fetched");
    }


    public function store(Request $request, Product $product)
    {
        $user = auth()->user();
        $quantity = 1;
        $totalQuantity = 0;

        if ($user) {
            $cartItem = Cart::where(['user_id' => $user->id, 'product_id' => $product->id])->first();
            if ($cartItem) {
                $cartItem->quantity += $quantity;
                $cartItem->update();
                $totalQuantity = $cartItem->quantity + $quantity;
            } else {
                $data = [
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                ];

                Cart::create($data);
                $totalQuantity = $quantity;
            }
            $data = [ 'count' => CartHealper::getCartItemsCount() ];

            return $this->response(true, $data, "Item Added to cart");
        } else {
            $cartItems = json_decode($request->cookie('cart_items', '[]'), true);
            $productFound = false;
            foreach ($cartItems as &$item) {
                if ($item['product_id'] === $product->id) {
                    $item['quantity'] += $quantity;
                    $totalQuantity = $item['quantity'] + $quantity;
                    $productFound = true;
                    break;
                }
            }
            if (!$productFound) {
                $cartItems[] = [
                    'user_id' => null,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $product->price
                ];
                $totalQuantity = $quantity;
            }

            Cookie::queue('cart_items', json_encode($cartItems), 60 * 24 * 30);
            $data = [ 'count' => CartHealper::getCountFromItems($cartItems) ];

            return $this->response(true, $data, "Item Added to cart");
        }

        if ($product->quantity !== null && $product->quantity < $totalQuantity) {
            return response([
                'message' => match ( $product->quantity ) {
                    0 => 'The product is out of stock',
                    1 => 'There is only one item left',
                    default => 'There are only ' . $product->quantity . ' items left'
                }
            ], 422);
        }
        
    }

    function update(Request $request, Product $cart)
    {
        $quantity = (int)$request->post('quantity');

        $user = auth()->user();

        if ($cart->quantity !== null && $cart->quantity < $quantity) {
            return response([
                'message' => match ( $cart->quantity ) {
                    0 => 'The product is out of stock',
                    1 => 'There is only one item left',
                    default => 'There are only ' . $cart->quantity . ' items left'
                }
            ], 422);
        }

        if ($user) {
            Cart::where(['user_id' => $user->id, 'product_id' => $cart->id])->update(['quantity' => $quantity]);

            $data = [
                'count' => CartHealper::getCartItemsCount()
            ];

            return $this->response(true, $data, "Cart update");
        } else {
            $cartItems = json_decode($request->cookie('cart_items', '[]'), true);
            foreach ($cartItems as &$item) {
                if ($item['product_id'] === $cart->id) {
                    $item['quantity'] = $quantity;
                    break;
                }
            }

            Cookie::queue('cart_items', json_encode($cartItems), 60 * 24 * 30);

            $data = [ 
                'count' => CartHealper::getCountFromItems($cartItems)
             ];

            return $this->response(true, $data, "Cart Update");
        }
    }


    public function destroy(Request $request, Product $product)
    {
        // dd($request->route()->parameters());
        $user = auth()->user();
        if ($user) {
            $cartItem = Cart::query()->where(['user_id' => $user->id, 'product_id' => $product->id])->first();
            if ($cartItem) {
                $cartItem->delete();
            }

            $data = [
                'count' => CartHealper::getCartItemsCount()
            ];

            return $this->response(true, $data, "Item Remove from cart");
        } else {
            $cartItems = json_decode($request->cookie('cart_items', '[]'), true);

            foreach ($cartItems as $i => &$item) {
                if ($item['product_id'] === $product->id) {
                    array_splice($cartItems, $i, 1);
                    break;
                }
            }
            Cookie::queue('cart_items', json_encode($cartItems), 60 * 24 * 30);

            $data = [
                'count' => CartHealper::getCountFromItems($cartItems)
            ];

            return $this->response(true, $data, "Item Remove from Cart");
        }
    }
}
