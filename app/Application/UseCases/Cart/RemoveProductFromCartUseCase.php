<?php

namespace App\Application\UseCases\Cart;

use App\Domain\Repositories\CartRepositoryInterface;

class RemoveProductFromCartUseCase
{
    public function __construct(
        private CartRepositoryInterface $cartRepository
    ){
        //
    }


    public function removeProductFromCart(int $productId)
    {
        $cart = $this->cartRepository->getCartItems('cart');

        if (!isset($cart[$productId])) {
            return [
                'success'=> false,
                'message' => 'Produto não encontrado no carrinho.',
            ];
        }

        $cartAtualizado = $this->cartRepository->removeProductFromCart($productId);
        $this->cartRepository->addCart($cartAtualizado);

        return [
            'success' => true,
            'message' => 'Produto removido com sucesso!',
        ];
    }
}