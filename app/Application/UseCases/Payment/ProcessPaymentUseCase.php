<?php

namespace App\Application\UseCases\Payment;

use App\Domain\Repositories\PaymentMethodInterface;

class ProcessPaymentUseCase
{
    public function __construct(
        private PaymentMethodInterface $paymentMethod
    ) {}

    public function processPayment(float $total, int|null $installments = 1): array
    {
        return $this->paymentMethod->processPayment($total, $installments);
    }
}