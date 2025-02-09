<?php

namespace App\Application\UseCases\Cart;

class AddProductToCartUseCase
{
    public function addToCart(int $productId, $quantity): array
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId] += $quantity;
        } else {
            $cart[$productId] = $quantity;
        }

        session()->put('cart', $cart);

        return [
            'success' => true,
            'message' => 'Produto adicionado ao carrinho!',
            'cart' => $cart,
        ];
    }
}