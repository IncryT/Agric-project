<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the farmer login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Display the admin login view.
     */
    public function createAdmin(): View
    {
        return view('auth.admin-login');
    }

    /**
     * Handle an incoming authentication request.
     * Determines redirect based on user type selection and actual role.
     */
    public function processLogin(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Get the selected user type from the form
        $userType = $request->input('user_type', 'farmer');
        $user = $request->user();

        // Redirect based on user type selection and actual role
        if ($userType === 'admin' && $user->role === 'admin') {
            return redirect()->intended(route('admin.dashboard'));
        } elseif ($userType === 'farmer' && $user->role === 'farmer') {
            return redirect()->intended(route('farmer.dashboard'));
        } else {
            // If there's a mismatch, log out and show error
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            if ($userType === 'admin' && $user->role !== 'admin') {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'user_type' => __('This account does not have administrator privileges.'),
                ]);
            } elseif ($userType === 'farmer' && $user->role !== 'farmer') {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'user_type' => __('This account is not registered as a farmer.'),
                ]);
            } else {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'user_type' => __('Invalid account type selected.'),
                ]);
            }
        }
    }

    /**
     * Handle an incoming authentication request for admins (legacy).
     * Verifies the user has admin role after authentication.
     */
    public function storeAdmin(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        // Ensure the authenticated user has admin role
        if ($request->user()->role !== 'admin') {
            Auth::logout();
            throw \Illuminate\Validation\ValidationException::withMessages([
                'email' => __('This account does not have administrator privileges.'),
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'));
    }

    /**
     * Handle an incoming authentication request for farmers (legacy).
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('farmer.dashboard'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
