<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'total_land_size' => $this->total_land_size ?: null,
            'land_size' => $this->land_size ?: null,
            'expected_yield_tonnes' => $this->expected_yield_tonnes ?: null,
            'farming_experience_years' => $this->farming_experience_years ?: null,
            'cop' => $this->cop ?: null,
            'profit_margin' => $this->profit_margin ?: null,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'district' => ['nullable', 'string', 'max:255'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            
            // Farmer profile fields
            'farm_name' => ['nullable', 'string', 'max:255'],
            'farm_address' => ['nullable', 'string'],
            'farm_phone' => ['nullable', 'string', 'max:20'],
            'total_land_size' => ['nullable', 'numeric', 'min:0'],
            'land_unit' => ['nullable', 'string', 'in:hectares,acres'],
            'crop_varieties' => ['nullable', 'array'],
            'crop_varieties.*' => ['string', 'max:100'],
            'other_crops' => ['nullable', 'string'],
            'irrigation_type' => ['nullable', 'string', 'in:none,drip,sprinkler,furrow,other'],
            'soil_type' => ['nullable', 'string', 'in:clay,sandy,loam,silt,other'],
            'farming_experience_years' => ['nullable', 'integer', 'min:0', 'max:100'],
            'main_market' => ['nullable', 'string', 'in:mbare,local,export,contract,other'],
            'cooperative_name' => ['nullable', 'string', 'max:255'],
            'business_type' => ['nullable', 'string', 'max:50'],
            'expected_annual_yield' => ['nullable', 'numeric', 'min:0'],
        ];
    }
}
