<?php

namespace App\Domain\Repositories;

interface CartRepositoryInterface
{
    public function getCartItems(string $sessionId): array;
}