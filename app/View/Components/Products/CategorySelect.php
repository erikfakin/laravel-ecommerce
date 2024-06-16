<?php

namespace App\View\Components\Products;

use App\Models\Category;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CategorySelect extends Component
{

    public $categories;
    public $name;
    public $id;

    public $selected;
    /**
     * Create a new component instance.
     */
    public function __construct($name = "category", $id = "category", $selected = null)
    {
        $this->name = $name;
        $this->id = $id;
        $this->selected = $selected;
        $this->categories = Category::orderBy('name')->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.products.category-select');
    }
}
