<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AgriculturalServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\AgriculturalService::create([
            'name' => 'Green Valley Agronomics',
            'type' => 'agronomist',
            'description' => 'Expert advice on crop management and soil health.',
            'latitude' => -17.8292,
            'longitude' => 31.0522,
            'contact_phone' => '+263 123 456 789',
            'contact_email' => 'info@greenvalley.co.zw',
            'address' => '123 Farm Road, Harare',
            'services_offered' => ['Crop Consulting', 'Soil Testing', 'Fertilizer Recommendations']
        ]);

        \App\Models\AgriculturalService::create([
            'name' => 'Harare Vet Clinic',
            'type' => 'veterinarian',
            'description' => 'Comprehensive veterinary services for livestock.',
            'latitude' => -17.8639,
            'longitude' => 31.0297,
            'contact_phone' => '+263 987 654 321',
            'contact_email' => 'contact@hararevet.zw',
            'address' => '45 Veterinary Street, Harare',
            'services_offered' => ['Livestock Health', 'Vaccinations', 'Emergency Care']
        ]);

        \App\Models\AgriculturalService::create([
            'name' => 'FarmTech Rentals',
            'type' => 'equipment_rental',
            'description' => 'Rent tractors, harvesters, and farming equipment.',
            'latitude' => -17.8292,
            'longitude' => 31.0522,
            'contact_phone' => '+263 555 123 456',
            'contact_email' => 'rentals@farmtech.zw',
            'address' => '78 Industrial Park, Harare',
            'services_offered' => ['Tractor Rental', 'Harvester Rental', 'Maintenance Services']
        ]);

        \App\Models\AgriculturalService::create([
            'name' => 'Seed Masters',
            'type' => 'seed_supplier',
            'description' => 'Quality seeds for various crops.',
            'latitude' => -17.8639,
            'longitude' => 31.0297,
            'contact_phone' => '+263 444 789 012',
            'contact_email' => 'sales@seedmasters.zw',
            'address' => '90 Seed Avenue, Harare',
            'services_offered' => ['Seed Sales', 'Crop Variety Advice', 'Bulk Orders']
        ]);
    }
}
