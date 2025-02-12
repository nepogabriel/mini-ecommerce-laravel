<?php

namespace Tests\App\Application\UseCases\Payment;

use App\Application\UseCases\Payment\CalculateDiscountUseCase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class CalculateDiscountUseCaseTest extends TestCase
{
    #[DataProvider('valueToCalculateDiscount')]
    public function testCalculateDiscountPix(float $price, float $expected)
    {
        $calculateDiscountUseCase = new CalculateDiscountUseCase();
        $valueDiscount = $calculateDiscountUseCase->calculateDiscount($price);

        $this->assertEquals($expected, $valueDiscount);
    }

    public static function valueToCalculateDiscount(): array
    {
        return [
            [100.00, 90.00],
            [899.90, 809.91],
            [257.23, 231.51],
        ];
    }
}