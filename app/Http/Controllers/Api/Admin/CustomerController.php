<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $perPage = $request->query('per_page', 15);

        $customers = User::where('role', 'customer')
            ->orderBy('created_at', 'DESC')
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => UserResource::collection($customers),
            'pagination' => [
                'total' => $customers->total(),
                'per_page' => $customers->perPage(),
                'current_page' => $customers->currentPage(),
                'last_page' => $customers->lastPage(),
            ],
        ]);
    }

    public function show($id): JsonResponse
    {
        $customer = User::where('role', 'customer')->find($id);

        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Customer not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new UserResource($customer),
        ]);
    }

    public function updateStatus($id, Request $request): JsonResponse
    {
        $customer = User::where('role', 'customer')->find($id);

        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Customer not found',
            ], 404);
        }

        $validated = $request->validate([
            'status' => ['required', 'boolean'],
        ]);

        $customer->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Customer status updated',
            'data' => new UserResource($customer),
        ]);
    }
}
