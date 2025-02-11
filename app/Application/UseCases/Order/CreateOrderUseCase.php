<?php

namespace App\Application\UseCases\Order;

use App\Domain\Repositories\OrderRepositoryInterface;
use App\Models\Order;

class CreateOrderUseCase
{
    public function __construct(
        private OrderRepositoryInterface $orderRepository
    ) {}

    public function createOrder(float $total, string $paymentMethod, int|null $installments = 1): Order
    {
        return $this->orderRepository->createOrder($total, $paymentMethod, $installments);
    }
}