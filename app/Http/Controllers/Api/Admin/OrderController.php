<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->query('per_page', 15);
        $status = $request->query('status');

        $query = Order::with('items.product', 'address', 'user')
            ->orderBy('created_at', 'DESC');

        if ($status) {
            $query->where('order_status', $status);
        }

        $orders = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => OrderResource::collection($orders),
            'pagination' => [
                'total' => $orders->total(),
                'per_page' => $orders->perPage(),
                'current_page' => $orders->currentPage(),
                'last_page' => $orders->lastPage(),
            ],
        ]);
    }

    public function show($id): JsonResponse
    {
        $order = Order::with('items.product', 'address', 'user')->find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new OrderResource($order),
        ]);
    }

    public function updateStatus($id, Request $request): JsonResponse
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found',
            ], 404);
        }

        $validated = $request->validate([
            'order_status' => ['required', 'in:pending,confirmed,shipped,delivered,cancelled'],
        ]);

        $order->update($validated);

        if ($validated['order_status'] === 'shipped') {
            $order->update(['shipped_at' => now()]);
        } elseif ($validated['order_status'] === 'delivered') {
            $order->update(['delivered_at' => now()]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Order status updated',
            'data' => new OrderResource($order),
        ]);
    }
}
