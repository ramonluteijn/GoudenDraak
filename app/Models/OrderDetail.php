<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
    ];

    protected static function booted()
    {
        static::saving(function ($orderDetail) {
            if ($orderDetail->quantity < 0) {
                $orderDetail->quantity = 0;
            }
        });
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
