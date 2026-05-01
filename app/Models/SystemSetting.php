<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    use HasFactory;

    // Allow these columns to be mass assigned by our scraper and controller
    protected $fillable = [
        'key',
        'value',
        'description',
    ];
}