<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        
        // Update user fields
        $user->fill($request->only(['name', 'email', 'phone_number', 'district', 'latitude', 'longitude']));

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // Prepare farmer profile data
        $profileData = $request->only([
            'farm_name', 'farm_address', 'farm_phone', 'total_land_size', 'land_unit',
            'crop_varieties', 'other_crops', 'irrigation_type', 'soil_type',
            'farming_experience_years', 'main_market', 'cooperative_name',
            'business_type', 'expected_annual_yield'
        ]);

        // Handle crop_varieties: convert empty array to null
        if (isset($profileData['crop_varieties']) && is_array($profileData['crop_varieties'])) {
            $profileData['crop_varieties'] = empty($profileData['crop_varieties']) ? null : $profileData['crop_varieties'];
        }

        if (!empty($profileData)) {
            $user->farmerProfile()->updateOrCreate(
                ['user_id' => $user->id],
                $profileData
            );
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
