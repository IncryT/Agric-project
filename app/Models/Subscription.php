<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'frequency',
        'cop',
        'profit_margin',
        'crop_variety',
        'land_size',
        'expected_yield_tonnes',
        'planting_season',
        'notes',
    ];

    protected $casts = [
        'cop' => 'decimal:2',
        'profit_margin' => 'decimal:2',
        'land_size' => 'decimal:2',
        'expected_yield_tonnes' => 'decimal:2',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }
}
