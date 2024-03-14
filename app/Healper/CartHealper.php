<?php
namespace App\Healper;

use App\Http\Resources\product\ProductResource;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class CartHealper
{
    public static function getCartItemsCount():int {
        $request = \request();
        $user = Auth::user();
        // $user = $request->user(); //$user = Auth::user();
        if ($user) {
            return Cart::where('user_id', $user->id)->sum('quantity');
        } else {
            $cartItems = self::getCookieCartItems();

            dd('cartData', $cartItems);

            return array_reduce(
                $cartItems,
                fn($carry, $item) => $carry + $item['quantity'],
                0
            );
        }
    }

    public static function getCookieCartItems()
    {
        $request = \request();
        return json_decode($request->cookie('cart_items', '[]'), true);
    }

    public static function getCountFromItems($cartItems)
    {
        return array_reduce(
            $cartItems,
            fn($carry, $item) => $carry + $item['quantity'],
            0
        );
    }

    public static function getProductsAndCartItems():array {
        $cartItems = self::getCartItems();
        $ids = Arr::pluck($cartItems, 'product_id');
        $products = Product::query()->whereIn('id', $ids)->get();
        // $products = ProductResource::collection($productIds);
        $cartItems = Arr::keyBy($cartItems, 'product_id');

        $mergedArray = $products->map(function ($product) use ($cartItems) {
            return array_merge($product->toArray(), $cartItems[$product->id]);
        });

        return [$mergedArray];
    }

  
    public static function getCartItems()
    {
        $request = \request();
        $user =  Auth::user(); // Auth::user();
        if ($user) {
            return Cart::where('user_id', $user->id)->get()->map(
                fn($item) => ['product_id' => $item->product_id, 'quantity' => $item->quantity]
            );
        } else {
            return self::getCookieCartItems();
        }
    }

}