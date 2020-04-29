<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'phone', 'delivery_address', 'locality', 'customer_id', 'total_quantity', 'total_amount', 'tax', 'payable_amount',
    ];
}
