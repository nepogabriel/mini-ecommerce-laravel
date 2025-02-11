<?php

namespace App\Domain\Repositories;

use App\Models\Order;

interface OrderRepositoryInterface
{
    public function createOrder(float $total, string $paymentMethod, int|null $installments = 1): Order;
}