<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isEmpty;

class OrderController extends Controller
{
    /**
     * Show the form for creating a new order.
     * 
     */
    public function create()
    {
        return view('orders.create');
    }

    /**
     * Store a newly created order
     *
     */
    public function store(Request $request)
    {

        $products = session()->get('cart', []);

        if (!$products) {
            return redirect()->route('products.index')->with('error', "Ne možemo izvršiti narudžbu jer je vaša košarica prazna!");
        }
        $request->validate([
            'buyerName' => 'required|string|max:255',
            'buyerAddress' => 'required|string|max:255',
            'buyerEmail' => 'required|email|max:255',
            'buyerPhone' => 'required|string|max:20',
        ]);



        $total = 0;
        foreach ($products as $product) {
            $total += $product['price'] * $product['quantity'];
        }

        $order = Order::create([
            'user_id' => Auth::id(),
            'total' => $total,
            'buyer_name' => $request->buyerName,
            'buyer_address' => $request->buyerAddress,
            'buyer_email' => $request->buyerEmail,
            'buyer_phone' => $request->buyerPhone,

        ]);



        foreach ($products as $product) {
            $order->products()->attach($product['id'], ['quantity' => $product['quantity']]);
        }

        session()->put('cart', []);

        // Redirect to a payment form
        return view('orders.thankyou', ['order' => $order]);
    }


    /**
     * Display the specified order.
     *
     */
    public function show(Order $order)
    {
        return view('orders.show', compact('order'));
    }
}
