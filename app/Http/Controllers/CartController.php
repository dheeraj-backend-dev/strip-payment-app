<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carts = Cart::where('user_id', Auth::id())->get();
        $grandTotal = $carts->sum('total_price');
        return view('cart.index', compact('carts', 'grandTotal'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        //
    }

    public function addToCart(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);
        // dd($data);

        $product = Product::where('id', $data['product_id'])
            ->first();

        $productInCart = Cart::where('user_id', Auth::id())
            ->where('product_id', $data['product_id'])
            ->first();

        if ($productInCart) {
            // Update quantity and total price if product already in cart
            $productInCart->quantity += $data['quantity'];
            $productInCart->total_price = $productInCart->quantity * $product->price;
            $productInCart->save();

            return response()->json(['message' => 'Product quantity updated in cart successfully.']);
        }

        Cart::create([
            'user_id' => Auth::id(),
            'product_id' => $data['product_id'],
            'quantity' => $data['quantity'],
            'unit_price' => $product->price,
            'total_price' => $product->price * $data['quantity'],
        ]);

        return response()->json(['message' => 'Product added to cart successfully.']);
    }
}
