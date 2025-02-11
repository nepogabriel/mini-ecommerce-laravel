<?php

namespace App\Infra\Repositories;

use App\Domain\Repositories\OrderRepositoryInterface;
use App\Models\Order;

class OrderRepository implements OrderRepositoryInterface
{
    public function createOrder(float $total, string $paymentMethod, int|null $installments = 1): Order
    {
        return Order::create([
            'user_id' => 1,
            'total' => $total,
            'payment_method' => $paymentMethod,
            'status' => 'paid',
        ]);
    }
}