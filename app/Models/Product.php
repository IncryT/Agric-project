<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    // Add this line to allow mass assignment for these specific columns
    protected $fillable = [
        'name',
        'unit_of_measure',
    ];

    // Your existing relationships
    public function marketPrices() {
        return $this->hasMany(MarketPrice::class);
    }

    public function subscriptions() {
        return $this->hasMany(Subscription::class);
    }
}
