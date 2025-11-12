<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('products.index', [
            'products' => Product::all(),
        ]);
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
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'unique:products,slug,except,id', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'quantity' => ['required', 'integer', 'min:1'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:1024'],
            'status' => ['required', 'in:1,2'],
            'description' => ['required', 'string', 'max:500'],
        ]);

        // Handle file upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image_path'] = $path;
        }

        Product::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['slug']),
            'price' => $validated['price'],
            'stock_quantity' => $validated['quantity'],
            'image_url' => $validated['image_path'],
            'status' => $validated['status'] ?? 0,
            'description' => $validated['description'],
        ]);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
