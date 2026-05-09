<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddToCartRequest;
use App\Http\Resources\CartItemResource;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;

class CartController extends Controller
{
    public function __construct(private CartService $cartService) {}

    public function index(): JsonResponse
    {
        $cart = $this->cartService->getOrCreateCart(auth()->id());
        $cart->load('items.product');

        $total = $this->cartService->getCartTotal($cart);

        return response()->json([
            'success' => true,
            'items' => CartItemResource::collection($cart->items),
            'total' => (float) $total,
            'item_count' => $cart->items->count(),
        ]);
    }

    public function add(AddToCartRequest $request): JsonResponse
    {
        $cart = $this->cartService->getOrCreateCart(auth()->id());
        $cart = $this->cartService->addToCart(
            $cart,
            $request->product_id,
            $request->quantity
        );

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart',
            'items' => CartItemResource::collection($cart->items),
        ]);
    }

    public function update($itemId): JsonResponse
    {
        $quantity = request('quantity');

        $this->cartService->updateCartItem($itemId, $quantity);

        return response()->json([
            'success' => true,
            'message' => 'Cart item updated',
        ]);
    }

    public function remove($itemId): JsonResponse
    {
        $this->cartService->removeCartItem($itemId);

        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart',
        ]);
    }

    public function clear(): JsonResponse
    {
        $cart = $this->cartService->getOrCreateCart(auth()->id());
        $this->cartService->clearCart($cart);

        return response()->json([
            'success' => true,
            'message' => 'Cart cleared',
        ]);
    }
}
