<?php

namespace Tests\App\Application\UseCases\Payment;

use App\Application\UseCases\Payment\CalculateCreditCardUseCase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class CalculateCreditCardUseCaseTest extends TestCase
{
    #[DataProvider('valueToCalculateWithoutInstallment')]
    #[DataProvider('valueToCalculateWithInstallment')]
    public function testCalculateCreditCard(float $price, int $installments, float $expected): void
    {
        $calculateCreditCard = new CalculateCreditCardUseCase();
        $valueCreditCard = $calculateCreditCard->calculateCreditCard($price, $installments);

        $this->assertEquals($expected, $valueCreditCard);
    }

    public static function valueToCalculateWithoutInstallment(): array
    {
        return [
            [150.00, 1, 150.00],
        ];
    }

    public static function valueToCalculateWithInstallment(): array
    {
        return [
            [150.00, 2, 153.02],
        ];
    }
}