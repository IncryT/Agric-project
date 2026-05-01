<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgriculturalService extends Model
{
    protected $fillable = [
        'name',
        'type',
        'description',
        'latitude',
        'longitude',
        'contact_phone',
        'contact_email',
        'address',
        'services_offered',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8',
            'services_offered' => 'array',
        ];
    }
}
