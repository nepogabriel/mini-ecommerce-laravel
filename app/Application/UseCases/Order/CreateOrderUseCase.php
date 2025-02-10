<?php

namespace App\Application\UseCases\Order;

use App\Models\Order;

class CreateOrderUseCase
{
    public function createOrder(float $total, string $paymentMethod, int|null $installments = 1): Order
    {
        return Order::create([
            'user_id' => 1,
            'total' => $total,
            'payment_method' => $paymentMethod,
            'status' => 'pending',
        ]);
    }
}