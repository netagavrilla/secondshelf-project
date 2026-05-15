<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        return response()->json(
            Cart::with('book')->latest()->get()
        );
    }

    public function store(Request $request)
    {
        $cart = Cart::where('book_id', $request->book_id)->first();

        if ($cart) {
            $cart->increment('quantity');
        } else {
            $cart = Cart::create([
                'book_id' => $request->book_id,
                'quantity' => 1,
            ]);
        }

        return response()->json([
            'message' => 'Buku ditambahkan ke keranjang',
            'data' => $cart->load('book')
        ]);
    }

    public function destroy($id)
    {
        Cart::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Item keranjang dihapus'
        ]);
    }
}