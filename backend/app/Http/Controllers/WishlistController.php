<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        return response()->json(
            Wishlist::with('book')->latest()->get()
        );
    }

    public function store(Request $request)
    {
        $wishlist = Wishlist::firstOrCreate([
            'book_id' => $request->book_id,
        ]);

        return response()->json([
            'message' => 'Buku ditambahkan ke wishlist',
            'data' => $wishlist->load('book')
        ]);
    }

    public function destroy($id)
    {
        Wishlist::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Wishlist dihapus'
        ]);
    }
}