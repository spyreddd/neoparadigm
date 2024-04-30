<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Softfile extends Model
{
    protected $fillable = [
        'file',
        'product_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
