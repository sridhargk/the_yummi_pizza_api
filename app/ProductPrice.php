<?php

namespace App;

use App\Product;
use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'size', 'description', 'price',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
