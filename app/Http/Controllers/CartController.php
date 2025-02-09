<?php

namespace App\Http\Controllers;

use App\Application\UseCases\Cart\AddProductToCartUseCase;
use Illuminate\Http\Request;

class CartController extends Controller
{
    
    public function __construct(
        private AddProductToCartUseCase $addProductToCartUseCase
    )
    {
        //
    }

    public function index()
    {
        $cart = session()->get('cart', []);

        dd($cart);

        return view('cart.index');
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
