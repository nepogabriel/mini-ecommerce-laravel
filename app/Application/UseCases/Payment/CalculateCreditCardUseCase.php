<?php

namespace App\Application\UseCases\Payment;

class CalculateCreditCardUseCase
{
    private const INTEREST_RATE = 0.10;

    public function calculateCreditCard(float $price,  int $installments): float
    {
        if ($installments == 1) {
            return $price;
        }

        return  round($price * pow((1 + self::INTEREST_RATE), $installments));
    }
}