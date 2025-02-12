<?php

namespace Tests\App\Application\UseCases\Checkout;

use App\Application\UseCases\Checkout\CalculateFinalAmountUseCase;
use App\Application\UseCases\Payment\CalculateCreditCardUseCase;
use App\Application\UseCases\Payment\CalculateDiscountUseCase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class CalculateFinalAmountUseCaseTest extends TestCase
{
    #[DataProvider('providePayment')]
    public function testCalculateFinalAmount(float $total, string $paymentMethodType, int|null $installments, float $mockReturn,  float $expected): void{
        $calculatePixDiscountUseCase = $this->createMock(CalculateDiscountUseCase::class);
        $calculateCreditCardUseCase = $this->createMock(CalculateCreditCardUseCase::class);

        $calculateFinalAmountUseCase = new CalculateFinalAmountUseCase(
            $calculatePixDiscountUseCase, 
            $calculateCreditCardUseCase
        );

        if ($paymentMethodType === 'pix') {
            $calculatePixDiscountUseCase
                ->method('calculateDiscount')
                ->with($total)
                ->willReturn($mockReturn);
        }

        if ($paymentMethodType === 'credit_card') {
            $calculateCreditCardUseCase
                ->method('calculateCreditCard')
                ->with($total)
                ->willReturn($mockReturn);
        }


        $result = $calculateFinalAmountUseCase->calculateFinalAumont($total, $paymentMethodType, $installments);

        $this->assertEquals($expected, $result);
    }

    public static function providePayment(): array
    {
        return [
            'pix'         => [100.00, 'pix', null, 90.00, 90.00],
            'credit_card' => [150.00, 'credit_card', 1, 150.00, 150.00],
            'empty'       => [200.00, 'empty', null, 200.00, 200.00],
        ];
    }
}