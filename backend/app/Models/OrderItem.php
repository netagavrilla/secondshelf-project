<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Book;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'book_id',
        'quantity',
        'price',
        'subtotal',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}