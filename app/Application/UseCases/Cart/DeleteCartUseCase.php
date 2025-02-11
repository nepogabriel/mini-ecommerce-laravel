<?php

namespace App\Application\UseCases\Cart;

use App\Domain\Repositories\CartRepositoryInterface;

class DeleteCartUseCase
{

    public function __construct(
        private CartRepositoryInterface $cartRepository
    ) {}

    public function deleteCart(string $sessionId): void
    {
        $this->cartRepository->deleteCart($sessionId);
    }
}