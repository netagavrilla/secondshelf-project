<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        return response()->json(Book::all());
    }

    public function show($id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'message' => 'Book not found'
            ], 404);
        }

        return response()->json($book);
    }

    public function store(Request $request)
    {
        $coverImage = null;

        if ($request->cover_image && !$request->hasFile('cover_file')) {
            $coverImage = $request->cover_image;
        }

        if ($request->hasFile('cover_file')) {
            $file = $request->file('cover_file');

            $filename = time() . '_' . $file->getClientOriginalName();

            $file->move(public_path('uploads/books'), $filename);

            $coverImage = 'uploads/books/' . $filename;
        }

        $book = Book::create([
            'title' => $request->title,
            'author' => $request->author,
            'category' => $request->category,
            'price' => $request->price,
            'old_price' => $request->old_price,
            'condition' => $request->condition,
            'cover_image' => $coverImage,
            'description' => $request->description,
            'stock' => $request->stock,
        ]);

        return response()->json([
            'message' => 'Buku berhasil ditambahkan',
            'data' => $book
        ]);
    }
}