<?php

namespace App\Domain\Repositories;

interface CartRepositoryInterface
{
    public function getCartItems(string $sessionId): array;

    public function addCart(array $cart): void;

    public function removeProductFromCart(int $productId): array;

    public function deleteCart(string $sessionId): void;
}