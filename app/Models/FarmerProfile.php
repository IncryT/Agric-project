<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FarmerProfile extends Model
{
    protected $fillable = [
        'user_id',
        'farm_name',
        'farm_address',
        'farm_phone',
        'total_land_size',
        'land_unit',
        'crop_varieties',
        'other_crops',
        'irrigation_type',
        'soil_type',
        'farming_experience_years',
        'main_market',
        'cooperative_name',
        'business_type',
        'expected_annual_yield',
    ];

    protected $casts = [
        'crop_varieties' => 'array',
        'total_land_size' => 'decimal:2',
        'expected_annual_yield' => 'decimal:2',
        'farming_experience_years' => 'integer',
    ];

    /**
     * Get the user that owns the farmer profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
