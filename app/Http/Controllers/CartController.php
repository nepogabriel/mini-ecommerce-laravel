<?php

namespace App\Http\Controllers;

use App\Application\UseCases\Cart\AddProductToCartUseCase;
use App\Application\UseCases\Cart\GetCartUseCase;
use Illuminate\Http\Request;

class CartController extends Controller
{
    
    public function __construct(
        private AddProductToCartUseCase $addProductToCartUseCase,
        private GetCartUseCase $getCartUseCase
    )
    {}

    public function index()
    {
        $cart = $this->getCartUseCase->getCart();

        return view('cart.index')
            ->with('cart', $cart);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ]);

        $result = $this->addProductToCartUseCase->addToCart($request->product_id, $request->quantity);

        return response()->json($result);
    }
}
