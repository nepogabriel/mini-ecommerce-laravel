<?php

namespace App\Http\Controllers;

use App\Application\UseCases\Checkout\CheckoutUseCase;
use App\Infra\Services\CreditCardPayment;
use App\Infra\Services\PixPayment;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __construct(
        private CheckoutUseCase $checkoutUseCase
    ) {}

    public function index()
    {
        return view('checkout.index');
    }

    public function processCheckout(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|string|in:pix,credit_card',
            'installments' => 'nullable|integer|min:1|max:12'
        ]);

        $paymentMethodType = $request->input('payment_method');
        $installments = $request->input('installments', 1);

        // Define dinamicamente a classe de pagamento correta
        $paymentMethod = match ($paymentMethodType) {
            'pix' => new PixPayment(),
            'credit_card' => new CreditCardPayment(),
            default => throw new \InvalidArgumentException('Método de pagamento inválido')
        };

        $checkoutData = $this->checkoutUseCase->executeCheckout($paymentMethod, $paymentMethodType, $installments);

        return response()->json($checkoutData);
    }
}
