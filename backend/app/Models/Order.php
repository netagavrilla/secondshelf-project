<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_name',
        'phone',
        'address',
        'payment_method',
        'note',
        'total_price',
        'status',
        'external_id',
        'xendit_invoice_id',
        'xendit_invoice_url',
        'payment_status',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}