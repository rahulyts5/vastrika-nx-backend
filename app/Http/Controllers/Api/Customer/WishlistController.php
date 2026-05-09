<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Services\WishlistService;
use Illuminate\Http\JsonResponse;

class WishlistController extends Controller
{
    public function __construct(private WishlistService $wishlistService) {}

    public function index(): JsonResponse
    {
        $wishlistItems = auth()->user()->wishlistItems()
            ->with('product.category', 'product.images')
            ->get();

        return response()->json([
            'success' => true,
            'data' => ProductResource::collection($wishlistItems->pluck('product')),
            'count' => $wishlistItems->count(),
        ]);
    }

    public function add($productId): JsonResponse
    {
        $this->wishlistService->addToWishlist(auth()->id(), $productId);

        return response()->json([
            'success' => true,
            'message' => 'Product added to wishlist',
        ]);
    }

    public function remove($productId): JsonResponse
    {
        $this->wishlistService->removeFromWishlist(auth()->id(), $productId);

        return response()->json([
            'success' => true,
            'message' => 'Product removed from wishlist',
        ]);
    }

    public function check($productId): JsonResponse
    {
        $inWishlist = auth()->user()->wishlistItems()
            ->where('product_id', $productId)
            ->exists();

        return response()->json([
            'success' => true,
            'inWishlist' => $inWishlist,
        ]);
    }
}
