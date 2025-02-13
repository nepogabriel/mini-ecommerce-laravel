<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SuccessController extends Controller
{
    public function index()
    {
        $checkoutData = session('checkoutData');

        if (!$checkoutData)
            return to_route('product.index');

        return view('success.index')
            ->with('checkoutData', $checkoutData);
    }
}
