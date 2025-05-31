<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use CrudTrait;
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'orders';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    protected static function booted()
    {
        static::saved(function ($order) {
            $productQuantities = [];
            foreach (request()->all() as $key => $value) {
                if (str_starts_with($key, 'product_quantity_') && is_numeric($value) && $value > 0) {
                    $productId = str_replace('product_quantity_', '', $key);
                    $productQuantities[$productId] = (int) $value;
                }
            }

            foreach ($productQuantities as $productId => $quantity) {
                OrderDetail::updateOrCreate(
                    ['order_id' => $order->id, 'product_id' => $productId],
                    ['quantity' => $quantity]
                );
            }
            $order->price = $order->orderDetails->sum(function ($detail) {
                return $detail->product->price * $detail->quantity;
            });

            $order->withoutEvents(function () use ($order) {
                $order->save();
            });
        });

        static::deleting(function ($order) {
            $order->orderDetails()->delete();
        });
    }


    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function table()
    {
        return $this->belongsTo(Table::class, 'table_id');
    }


    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function products() : BelongsToMany {
        return $this->belongsToMany(Product::class, 'order_details')->withPivot('product_id');
    }


    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
