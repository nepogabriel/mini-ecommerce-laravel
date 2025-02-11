<?php

namespace App\Domain\Services;

interface PaymentMethodInterface
{
    public function processPayment(float $amount, int|null $installments = 1): array;
}