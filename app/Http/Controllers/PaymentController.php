<?php

namespace App\Http\Controllers;

use App\Models\{Cart, Payment};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class PaymentController extends Controller
{

    public function checkout(Request $request)
    {
        $request->validate([
            'cart_ids' => 'required|array',
            'cart_ids.*' => 'integer|exists:carts,id',
        ]);

        Stripe::setApiKey(config('services.stripe.secret'));

        $user = Auth::user();

        $cartItems = Cart::whereIn('id', $request->cart_ids)
            ->with('product:id,name,price')
            ->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'No valid cart items found.');
        }

        $lineItems = [];
        foreach ($cartItems as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $item->product->name,
                    ],
                    'unit_amount' => $item->unit_price * 100,
                ],
                'quantity' => $item->quantity,
            ];
        }

        $session = Session::create([
            'payment_method_types' => ['card'],
            'customer_email' => $user->email,
            'line_items' => $lineItems,
            'mode' => 'payment',
            'metadata' => [
                'user_id' => $user->id,
                'cart_ids' => implode(',', $request->cart_ids),
            ],
            'success_url' => route('payment.success', [$user->id], true) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('payment.cancel', [$user->id], true) . '?session_id={CHECKOUT_SESSION_ID}',
        ]);

        return redirect($session->url);
    }


    public function success(Request $request)
    {
        $sessionId = $request->query('session_id');

        Stripe::setApiKey(config('services.stripe.secret'));

        $retrive = Session::retrieve($sessionId);

        $cart = Cart::whereIn('id', explode(',', $retrive->metadata->cart_ids))->get();
        foreach ($cart as $item) {
            Payment::create([
                'user_id' => $retrive->metadata->user_id,
                'cart_id' => $item->id,
                'payment_method' => 'stripe',
                'payment_status' => $retrive->status,
                'transaction_id' => $retrive->id,
                'amount' => $item->unit_price * $item->quantity,
            ]);
        }

        return response()->json(['message' => 'Payment was success.'], 200);
    }

    public function cancel(Request $request)
    {
        $sessionId = $request->query('session_id');
        
        Stripe::setApiKey(config('services.stripe.secret'));

        $retrive = Session::retrieve($sessionId);

        $cart = Cart::whereIn('id', explode(',', $retrive->metadata->cart_ids))->get();
        foreach ($cart as $item) {
            Payment::create([
                'user_id' => $retrive->metadata->user_id,
                'cart_id' => $item->id,
                'payment_method' => 'stripe',
                'payment_status' => 'failed',
                'transaction_id' => $retrive->id,
                'amount' => $item->unit_price * $item->quantity,
            ]);
        }

        return response()->json(['message' => 'Payment was cancelled.'], 200);
    }
}
