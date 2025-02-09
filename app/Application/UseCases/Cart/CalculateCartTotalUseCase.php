<?php

namespace App\Application\UseCases\Cart;

use App\Application\UseCases\Payment\CalculateDiscountUseCase;
use App\Domain\Repositories\CartRepositoryInterface;
use App\Domain\Repositories\ProductRepositoryInterface;

class CalculateCartTotalUseCase
{
    public function __construct(
        private CartRepositoryInterface $cartRepository,
        private ProductRepositoryInterface $productRepository,
        private CalculateDiscountUseCase $calculateDiscountUseCase
    )
    {
        //
    }

    public function calculateCartToTotal(string $sessionId)
    {
        $cart = $this->cartRepository->getCartItems($sessionId);

        if (empty($cart)) {
            return [
                'success' => false,
                'message' => 'O carrinho está vazio!',
                'total' => 0
            ];
        }

        $productIds = array_keys($cart);
        $cartItems = $this->productRepository->findByIds($productIds);

        $subtotal = 0;
        foreach ($cartItems as $item) {
            $subtotal += $item->price * $cart[$item->id];
        }

        $total = $subtotal;

        $discountedTotal = $this->calculateDiscountUseCase->calculateDiscount($subtotal);

        return [
            'success' => true,
            'message' => 'Total calculado com sucesso!',
            'subtotal' => $subtotal, 
            'total' => $total, 
            'discountedTotal' => $discountedTotal, 
        ];
    }
}