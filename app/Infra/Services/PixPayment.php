<?php

namespace App\Infra\Services;

use App\Domain\Services\PaymentMethodInterface;

class PixPayment implements PaymentMethodInterface
{
    public function processPayment(float $amount, int|null $installments = 1): array
    {
        return [
            'success' => true,
            'message' => 'Pagamento via Pix processado com sucesso!',
            'amount' => $amount,
        ];
    }
}