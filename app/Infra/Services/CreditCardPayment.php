<?php

namespace App\Infra\Services;

use App\Domain\Services\PaymentMethodInterface;

class CreditCardPayment implements PaymentMethodInterface
{
    public function processPayment(float $amount, int|null $installments = 1): array
    {
        return [
            'success' => true,
            'message' => "Pagamento via cartão processado em {$installments}x!",
            'amount' => $amount,
            'installments' => $installments,
        ];
    }
}