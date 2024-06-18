<?php

namespace App\View\Components\Layout;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class MiniCart extends Component
{
    public $cart;
    public $total;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->cart = session()->get('cart', []);
        $this->total = 0;
        foreach ($this->cart as $cartItem) {
            $this->total += $cartItem['price'] * $cartItem['quantity'];
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layout.mini-cart');
    }
}
