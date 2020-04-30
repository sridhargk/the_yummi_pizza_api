<?php

namespace App;

use App\Customer;
use App\OrderItems;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'phone', 'delivery_address', 'locality', 'total_quantity', 'total_amount', 'tax', 'payable_amount',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItems::class);
    }
}
