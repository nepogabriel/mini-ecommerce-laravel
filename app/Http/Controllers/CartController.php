<?php

namespace App\Http\Controllers;

use App\Application\UseCases\Cart\AddProductToCartUseCase;
use App\Application\UseCases\Cart\CalculateCartTotalUseCase;
use App\Application\UseCases\Cart\GetCartUseCase;
use App\Application\UseCases\Cart\RemoveProductFromCartUseCase;
use Illuminate\Http\Request;

class CartController extends Controller
{
    
    public function __construct(
        private AddProductToCartUseCase $addProductToCartUseCase,
        private GetCartUseCase $getCartUseCase,
        private CalculateCartTotalUseCase $calculateCartTotalUseCase
    )
    {}

    public function index()
    {
        $cartItems = $this->getCartUseCase->getCart();

        return view('cart.index')
            ->with('cartItems', $cartItems);
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ]);

        $result = $this->addProductToCartUseCase->addToCart($request->product_id, $request->quantity);

        return response()->json($result);
    }

    public function getTotal()
    {
        $result = $this->calculateCartTotalUseCase->calculateCartToTotal('cart');

        return response()->json($result);
    }

    public function removeProduct(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
        ]);

        $productId = $request->product_id;

        if (!$productId) {
            return response()->json(['success' => false, 'message' => 'ID do produto inválido'], 400);
        }

        // Executa o caso de uso
        $useCase = app(RemoveProductFromCartUseCase::class);
        $result = $useCase->removeProductFromCart($productId);

        return response()->json($result);
    }
}
