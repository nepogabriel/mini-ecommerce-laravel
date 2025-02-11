<?php

namespace App\Application\UseCases\Checkout;

use App\Application\UseCases\Cart\CalculateCartTotalUseCase;
use App\Application\UseCases\Cart\DeleteCartUseCase;
use App\Application\UseCases\Order\CreateOrderUseCase;
use App\Application\UseCases\Payment\ProcessPaymentUseCase;
use App\Domain\Services\PaymentMethodInterface;

class CheckoutUseCase
{
    public function __construct(
        private CalculateCartTotalUseCase $calculateCartTotalUseCase,
        private CalculateFinalAumontUseCase $calculateFinalAumontUseCase,
        private CreateOrderUseCase $createOrderUseCase,
        private DeleteCartUseCase $deleteCartUseCase
    ) {}

    public function executeCheckout(PaymentMethodInterface $paymentMethod, string $paymentMethodType, int|null $installments = 1): array
    {
        $totais = $this->calculateCartTotalUseCase->calculateCartToTotal('cart');
        $finalTotal = $this->calculateFinalAumontUseCase->calculateFinalAumont($totais['total'], $paymentMethodType, $installments);

        $processPaymentUseCase = new ProcessPaymentUseCase($paymentMethod);
        $paymentResult = $processPaymentUseCase->processPayment($finalTotal, $installments);

        $order = $this->createOrderUseCase->createOrder($finalTotal, $paymentMethodType);

        if (isset($paymentResult['success']) && $order) {
            $this->deleteCartUseCase->deleteCart('cart');
        }

        return [
            'order' => $order,
            'payment' => $paymentResult,
        ];
    }
}