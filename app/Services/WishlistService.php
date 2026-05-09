<?php

namespace App\Services;

use App\Models\Wishlist;

class WishlistService
{
    public function addToWishlist($userId, $productId)
    {
        return Wishlist::firstOrCreate([
            'user_id' => $userId,
            'product_id' => $productId,
        ]);
    }

    public function removeFromWishlist($userId, $productId)
    {
        return Wishlist::where('user_id', $userId)
            ->where('product_id', $productId)
            ->delete();
    }

    public function moveToCart($userId, $productId, $cartService)
    {
        $this->removeFromWishlist($userId, $productId);

        $cart = $cartService->getOrCreateCart($userId);
        return $cartService->addToCart($cart, $productId, 1);
    }
}
