<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MarketPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'date',
        'price',
    ];

    public function product() {
        return $this->belongsTo(Product::class);
    }
}