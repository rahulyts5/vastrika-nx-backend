<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Customer\ProductController as CustomerProductController;
use App\Http\Controllers\Api\Customer\CategoryController;
use App\Http\Controllers\Api\Customer\CartController;
use App\Http\Controllers\Api\Customer\OrderController;
use App\Http\Controllers\Api\Customer\AddressController;
use App\Http\Controllers\Api\Customer\ReviewController;
use App\Http\Controllers\Api\Customer\WishlistController;
use App\Http\Controllers\Api\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Api\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Api\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Api\Admin\CustomerController;
use App\Http\Controllers\Api\Admin\DashboardController;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'me']);
});

Route::prefix('customer')->group(function () {
    Route::get('products', [CustomerProductController::class, 'index']);
    Route::get('products/featured', [CustomerProductController::class, 'featured']);
    Route::get('products/trending', [CustomerProductController::class, 'trending']);
    Route::get('products/latest', [CustomerProductController::class, 'latest']);
    Route::get('products/{id}', [CustomerProductController::class, 'show']);
    Route::get('products/{id}/related', [CustomerProductController::class, 'related']);
    Route::get('categories', [CategoryController::class, 'index']);
    Route::get('categories/{slug}', [CategoryController::class, 'show']);
    Route::get('category/{categoryId}/products', [CustomerProductController::class, 'byCategory']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::prefix('cart')->group(function () {
            Route::get('/', [CartController::class, 'index']);
            Route::post('add', [CartController::class, 'add']);
            Route::put('items/{itemId}', [CartController::class, 'update']);
            Route::delete('items/{itemId}', [CartController::class, 'remove']);
            Route::delete('clear', [CartController::class, 'clear']);
        });

        Route::prefix('orders')->group(function () {
            Route::get('/', [OrderController::class, 'index']);
            Route::get('{id}', [OrderController::class, 'show']);
            Route::post('create', [OrderController::class, 'store']);
            Route::delete('{id}/cancel', [OrderController::class, 'cancel']);
        });

        Route::prefix('addresses')->group(function () {
            Route::get('/', [AddressController::class, 'index']);
            Route::post('create', [AddressController::class, 'store']);
            Route::put('{id}', [AddressController::class, 'update']);
            Route::delete('{id}', [AddressController::class, 'destroy']);
            Route::post('{id}/set-default', [AddressController::class, 'setDefault']);
        });

        Route::prefix('reviews')->group(function () {
            Route::post('create', [ReviewController::class, 'store']);
            Route::get('product/{productId}', [ReviewController::class, 'index']);
        });

        Route::prefix('wishlist')->group(function () {
            Route::get('/', [WishlistController::class, 'index']);
            Route::post('{productId}/add', [WishlistController::class, 'add']);
            Route::delete('{productId}/remove', [WishlistController::class, 'remove']);
            Route::get('{productId}/check', [WishlistController::class, 'check']);
        });
    });
});

Route::prefix('admin')->middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('dashboard/stats', [DashboardController::class, 'stats']);

    Route::prefix('products')->group(function () {
        Route::get('/', [AdminProductController::class, 'index']);
        Route::post('create', [AdminProductController::class, 'store']);
        Route::get('{id}', [AdminProductController::class, 'show']);
        Route::put('{id}', [AdminProductController::class, 'update']);
        Route::delete('{id}', [AdminProductController::class, 'destroy']);
    });

    Route::prefix('categories')->group(function () {
        Route::get('/', [AdminCategoryController::class, 'index']);
        Route::post('create', [AdminCategoryController::class, 'store']);
        Route::get('{id}', [AdminCategoryController::class, 'show']);
        Route::put('{id}', [AdminCategoryController::class, 'update']);
        Route::delete('{id}', [AdminCategoryController::class, 'destroy']);
    });

    Route::prefix('orders')->group(function () {
        Route::get('/', [AdminOrderController::class, 'index']);
        Route::get('{id}', [AdminOrderController::class, 'show']);
        Route::put('{id}/status', [AdminOrderController::class, 'updateStatus']);
    });

    Route::prefix('customers')->group(function () {
        Route::get('/', [CustomerController::class, 'index']);
        Route::get('{id}', [CustomerController::class, 'show']);
        Route::put('{id}/status', [CustomerController::class, 'updateStatus']);
    });
});
