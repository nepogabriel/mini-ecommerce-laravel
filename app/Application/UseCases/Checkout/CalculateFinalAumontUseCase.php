<?php

namespace App\Application\UseCases\Checkout;

use App\Application\UseCases\Payment\CalculateCreditCardUseCase;
use App\Application\UseCases\Payment\CalculateDiscountUseCase;

class CalculateFinalAumontUseCase
{
    public function __construct(
        private CalculateDiscountUseCase $calculatePixDiscountUseCase,
        private CalculateCreditCardUseCase $calculateCreditCardUseCase
    ) {}

    public function calculateFinalAumont(float $total, string $paymentMethodType, int|null $installments = 1): float
    {
        return match ($paymentMethodType) {
            'pix' => $this->calculatePixDiscountUseCase->calculateDiscount($total),
            'credit_card' => $this->calculateCreditCardUseCase->calculateCreditCard($total, $installments),
            default => $total
        };
    }
}