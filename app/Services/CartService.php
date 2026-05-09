<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;

class CartService
{
    public function getOrCreateCart($userId)
    {
        return Cart::firstOrCreate(['user_id' => $userId]);
    }

    public function addToCart($cart, $productId, $quantity)
    {
        $cartItem = $cart->items()->where('product_id', $productId)->first();

        $product = \App\Models\Product::find($productId);

        if ($cartItem) {
            $cartItem->update([
                'quantity' => $cartItem->quantity + $quantity,
                'price' => $product->discount_price ?? $product->price,
            ]);
        } else {
            $cart->items()->create([
                'product_id' => $productId,
                'quantity' => $quantity,
                'price' => $product->discount_price ?? $product->price,
            ]);
        }

        return $cart->load('items.product');
    }

    public function updateCartItem($cartItemId, $quantity)
    {
        $cartItem = CartItem::find($cartItemId);
        $cartItem->update(['quantity' => $quantity]);
        return $cartItem;
    }

    public function removeCartItem($cartItemId)
    {
        CartItem::destroy($cartItemId);
        return true;
    }

    public function clearCart($cart)
    {
        $cart->items()->delete();
        return true;
    }

    public function getCartTotal($cart)
    {
        return $cart->items()->sum(\DB::raw('price * quantity'));
    }
}
