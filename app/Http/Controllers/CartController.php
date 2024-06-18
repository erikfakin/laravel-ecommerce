<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $cart = session()->get('cart', []);
        $id = $request->input('id');
        $product = Product::findOrFail($id);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += 1;
        } else {
            $cart[$id] = $product;
            $cart[$id]['quantity'] = 1;
        }

        session()->put('cart', $cart);

        return back()->with('success', 'Uspiješno ste dodali proizvod u košaricu');
    }

    public function remove(Request $request)
    {
        $cart = session()->get('cart', []);
        $id = $request->input('id');

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }


        return back()->with('success', 'Uspiješno ste izbrisali proizvod iz košarice');
    }

    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        foreach ($cart as $cartItem) {
            $total += $cartItem['price'] * $cartItem['quantity'];
        }


        return view('cart.index', compact('cart', 'total'));
    }
}
