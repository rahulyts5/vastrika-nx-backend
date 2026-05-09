<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Coupon;
use Illuminate\Support\Str;

class OrderService
{
    public function createOrder($user, $addressId, $paymentMethod, $couponCode = null)
    {
        $cart = $user->cart;
        $cartItems = $cart->items()->with('product')->get();

        if ($cartItems->isEmpty()) {
            throw new \Exception('Cart is empty');
        }

        $subtotal = 0;
        foreach ($cartItems as $item) {
            $subtotal += $item->price * $item->quantity;
        }

        $discount = 0;
        $coupon = null;

        if ($couponCode) {
            $coupon = Coupon::where('code', $couponCode)
                ->where('status', true)
                ->where('expiry_date', '>', now())
                ->first();

            if ($coupon) {
                if ($coupon->discount_type === 'percentage') {
                    $discount = ($subtotal * $coupon->discount_value) / 100;
                } else {
                    $discount = $coupon->discount_value;
                }

                $coupon->increment('uses_count');
            }
        }

        $tax = 0;
        $shipping = 0;

        $total = $subtotal + $tax + $shipping - $discount;

        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => 'ORD-' . Str::upper(Str::random(12)),
            'address_id' => $addressId,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'shipping' => $shipping,
            'discount' => $discount,
            'total' => $total,
            'payment_method' => $paymentMethod,
            'payment_status' => $paymentMethod === 'cod' ? 'pending' : 'pending',
            'order_status' => 'pending',
            'coupon_id' => $coupon?->id,
        ]);

        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->price,
            ]);
        }

        $cart->items()->delete();

        return $order->load('items.product', 'address');
    }

    public function updateOrderStatus($orderId, $status)
    {
        $order = Order::find($orderId);
        $order->update(['order_status' => $status]);

        if ($status === 'shipped') {
            $order->update(['shipped_at' => now()]);
        } elseif ($status === 'delivered') {
            $order->update(['delivered_at' => now()]);
        }

        return $order;
    }
}
