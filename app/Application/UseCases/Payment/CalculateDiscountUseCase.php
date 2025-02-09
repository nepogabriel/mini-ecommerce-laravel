<?php

namespace App\Application\UseCases\Payment;

class CalculateDiscountUseCase
{
    private const DISCOUNT = 0.10;

    public function calculateDiscount(float $price): float
    {
        return round($price * (1 - self::DISCOUNT), 2);
    }
}