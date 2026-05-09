<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public function stats(): JsonResponse
    {
        $totalOrders = \App\Models\Order::count();
        $totalCustomers = \App\Models\User::where('role', 'customer')->count();
        $totalProducts = \App\Models\Product::count();
        $totalRevenue = \App\Models\Order::where('order_status', 'delivered')
            ->sum('total');

        $monthlyRevenue = \DB::table('orders')
            ->selectRaw('MONTH(created_at) as month, SUM(total) as total')
            ->whereYear('created_at', now()->year)
            ->where('order_status', 'delivered')
            ->groupBy('month')
            ->get();

        $topProducts = \App\Models\Product::withCount('orderItems')
            ->orderBy('order_items_count', 'DESC')
            ->limit(5)
            ->get();

        $recentOrders = \App\Models\Order::with('user')
            ->orderBy('created_at', 'DESC')
            ->limit(10)
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'total_orders' => $totalOrders,
                'total_customers' => $totalCustomers,
                'total_products' => $totalProducts,
                'total_revenue' => (float) $totalRevenue,
                'monthly_revenue' => $monthlyRevenue,
                'top_products' => $topProducts,
                'recent_orders' => $recentOrders,
            ],
        ]);
    }
}
