<?php

namespace App\Infra\Repositories;

use App\Domain\Repositories\CartRepositoryInterface;

class CartRepository implements CartRepositoryInterface
{
    public function getCartItems(string $sessionId): array
    {
        return session()->get($sessionId, []);
    }

    public function addCart(array $cart): void
    {
        session()->put('cart', $cart);
    }

    public function removeProductFromCart(int $productId): array
    {
        $cart = $this->getCartItems('cart');
        unset($cart[$productId]);

        return $cart;
    }

    public function deleteCart(string $sessionId): void
    {
        session()->forget($sessionId);
    }
}