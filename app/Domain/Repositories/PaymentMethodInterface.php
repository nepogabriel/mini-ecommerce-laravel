<?php

namespace App\Domain\Repositories;

interface PaymentMethodInterface
{
    public function processPayment(float $amount, int|null $installments = 1): array;
}