<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
    ];

    protected static function booted()
    {
        static::saving(function ($orderDetail) {
            // Example: Ensure quantity is always positive
            if ($orderDetail->quantity < 0) {
                $orderDetail->quantity = 0;
            }
        });

        static::deleting(function ($orderDetail) {
            // Example: Perform cleanup if needed
            // No specific logic here, but you can add custom behavior.
        });
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
