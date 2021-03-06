<?php

namespace App;

use App\Order;
use App\Product;
use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id', 'name', 'description', 'product_id', 'quantity', 'price', 'total',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
