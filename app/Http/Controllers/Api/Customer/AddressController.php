<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAddressRequest;
use App\Http\Resources\AddressResource;
use App\Models\Address;
use Illuminate\Http\JsonResponse;

class AddressController extends Controller
{
    public function index(): JsonResponse
    {
        $addresses = auth()->user()->addresses;

        return response()->json([
            'success' => true,
            'data' => AddressResource::collection($addresses),
        ]);
    }

    public function store(CreateAddressRequest $request): JsonResponse
    {
        $address = auth()->user()->addresses()->create($request->validated());

        if ($request->is_default) {
            auth()->user()->addresses()
                ->where('id', '!=', $address->id)
                ->update(['is_default' => false]);
            $address->update(['is_default' => true]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Address added successfully',
            'data' => new AddressResource($address),
        ], 201);
    }

    public function update($id, CreateAddressRequest $request): JsonResponse
    {
        $address = auth()->user()->addresses()->find($id);

        if (!$address) {
            return response()->json([
                'success' => false,
                'message' => 'Address not found',
            ], 404);
        }

        $address->update($request->validated());

        if ($request->is_default) {
            auth()->user()->addresses()
                ->where('id', '!=', $address->id)
                ->update(['is_default' => false]);
            $address->update(['is_default' => true]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Address updated',
            'data' => new AddressResource($address),
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $address = auth()->user()->addresses()->find($id);

        if (!$address) {
            return response()->json([
                'success' => false,
                'message' => 'Address not found',
            ], 404);
        }

        $address->delete();

        return response()->json([
            'success' => true,
            'message' => 'Address deleted',
        ]);
    }

    public function setDefault($id): JsonResponse
    {
        $address = auth()->user()->addresses()->find($id);

        if (!$address) {
            return response()->json([
                'success' => false,
                'message' => 'Address not found',
            ], 404);
        }

        auth()->user()->addresses()->update(['is_default' => false]);
        $address->update(['is_default' => true]);

        return response()->json([
            'success' => true,
            'message' => 'Default address updated',
            'data' => new AddressResource($address),
        ]);
    }
}
