<?php

namespace App;

use App\ProductCategory;
use App\ProductPrice;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'image', 'category_id',
    ];

    public function prices()
    {
        return $this->hasMany(ProductPrice::class);
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class);
    }
}
