<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\Request;
use Symfony\Component\VarDumper\Caster\RedisCaster;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::paginate(12);
        return view('products.index', compact('products'));
    }

    /**
     * Display a listing of the products filtered by category.
     */
    public function category(string $categorySlug)
    {
        $category = Category::where('slug', $categorySlug)->firstOrFail();
        $products = $category->products()->paginate(12);
        return view('products.index', ['title' => $category->name, 'products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category' => 'required|exists:categories,id'
        ]);

        $path = $request->image->store('images', 'public');
        $image = Image::create([
            'alt' => $request->name,
            'src' => $path
        ]);

        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'image_id' => $image->id,
            'category_id' => $request->category,
        ]);

        return redirect()->route('products.index')->with('success', 'Proizvod kreiran uspiješno.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|min:0',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'category' => 'required|exists:categories,id'
        ]);

        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->description = $request->input('description');
        $product->category_id = $request->input('category');

        if ($request->hasFile('image')) {
            $path = $request->image->store('images', 'public');
            $image = Image::create([
                'alt' => $request->name,
                'src' => $path
            ]);
            $product->image_id = $image->id;
        }

        $product->save();
        return redirect()->route('products.index')->with('success', 'Proizvod uređen uspiješno.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Proizvod izbrisan.');
    }
}
