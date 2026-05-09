<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(private ProductService $productService) {}

    public function index(Request $request): JsonResponse
    {
        $perPage = $request->query('per_page', 12);
        $page = $request->query('page', 1);

        $filter = [
            'category' => $request->query('category'),
            'search' => $request->query('search'),
            'price_min' => $request->query('price_min'),
            'price_max' => $request->query('price_max'),
            'fabric' => $request->query('fabric'),
            'color' => $request->query('color'),
            'occasion' => $request->query('occasion'),
            'sort' => $request->query('sort'),
        ];

        $products = $this->productService->getProducts($filter)
            ->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'success' => true,
            'data' => ProductResource::collection($products),
            'pagination' => [
                'total' => $products->total(),
                'per_page' => $products->perPage(),
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'from' => $products->firstItem(),
                'to' => $products->lastItem(),
            ],
        ]);
    }

    public function featured(): JsonResponse
    {
        $products = $this->productService->getFeaturedProducts();

        return response()->json([
            'success' => true,
            'data' => ProductResource::collection($products),
        ]);
    }

    public function trending(): JsonResponse
    {
        $products = $this->productService->getTrendingProducts();

        return response()->json([
            'success' => true,
            'data' => ProductResource::collection($products),
        ]);
    }

    public function latest(Request $request): JsonResponse
    {
        $limit = $request->query('limit', 8);
        $products = $this->productService->getLatestProducts($limit);

        return response()->json([
            'success' => true,
            'data' => ProductResource::collection($products),
        ]);
    }

    public function show($id): JsonResponse
    {
        $product = \App\Models\Product::with('category', 'images', 'reviews.user')
            ->find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new ProductResource($product),
        ]);
    }

    public function related($id, Request $request): JsonResponse
    {
        $limit = $request->query('limit', 4);
        $products = $this->productService->getRelatedProducts($id, $limit);

        return response()->json([
            'success' => true,
            'data' => ProductResource::collection($products),
        ]);
    }

    public function byCategory($categoryId, Request $request): JsonResponse
    {
        $perPage = $request->query('per_page', 12);
        $products = $this->productService->getCategoryProducts($categoryId)
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => ProductResource::collection($products),
            'pagination' => [
                'total' => $products->total(),
                'per_page' => $products->perPage(),
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
            ],
        ]);
    }
}
