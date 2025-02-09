<?php

namespace App\Infra\Repositories;

use App\Domain\Repositories\CartRepositoryInterface;

class CartRepository implements CartRepositoryInterface
{
    public function getCartItems(string $sessionId): array
    {
        return session()->get($sessionId, []);
    }
}