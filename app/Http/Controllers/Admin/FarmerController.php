<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class FarmerController extends Controller
{
    public function index(Request $request)
    {
        // Define pagination options
        $allowedPerPage = [10, 25, 50, 100];
        $perPage = $request->input('per_page', 10);
        
        if (!in_array($perPage, $allowedPerPage)) {
            $perPage = 10;
        }

        $search = $request->input('search');

        // Build the query: Fetch only users who are farmers
        // Adjust 'role' => 'farmer' to match how your database separates admins from farmers
        $query = User::where('role', 'farmer')->orderBy('created_at', 'desc');

        // Apply search filter for name or email
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        // Execute query with dynamic pagination
        $farmers = $query->paginate($perPage)->withQueryString();

        return view('admin.farmers.index', compact('farmers', 'perPage', 'search'));
    }

    /**
     * Show the form for creating a new farmer.
     */
    public function create()
    {
        return view('admin.farmers.create');
    }

    /**
     * Store a newly created farmer in storage.
     */
    public function store(Request $request)
    {
        // 1. Validate the form inputs
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed', // 'confirmed' looks for the password_confirmation field
            'district' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ]);

        // 2. Create the new user and hardcode their role as 'farmer'
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'farmer',
            'district' => $request->district,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        // 3. Send the admin back to the directory with a success message
        return redirect()->route('admin.farmers.index')
                         ->with('success', 'Farmer registered successfully!');
    }

    /**
     * Display the specified farmer's profile.
     */
    public function show($id)
    {
        // Fetch the farmer and return the view
        $farmer = User::findOrFail($id);
        
        return "This is where the profile view for " . $farmer->name . " will load.";
    }


    public function destroy(\App\Models\User $user)
    {
        // Ensure we are only deleting farmers, not other admins
        if ($user->role !== 'farmer') {
            return redirect()->back()->with('error', 'Only farmer accounts can be deleted.');
        }

        $user->delete();

        return redirect()->route('admin.farmers.index')->with('success', 'Farmer deleted successfully.');
    }

    public function map()
    {
        // Group farmers by district and get counts + center coordinates
        $districtData = User::where('role', 'farmer')
            ->whereNotNull('district')
            ->where('district', '!=', '')
            ->select('district')
            ->selectRaw('COUNT(*) as farmer_count')
            ->selectRaw('AVG(latitude) as avg_latitude')
            ->selectRaw('AVG(longitude) as avg_longitude')
            ->groupBy('district')
            ->get();

        // Also get individual farmers with location for fallback
        $farmers = User::where('role', 'farmer')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->where('latitude', '!=', '')
            ->where('longitude', '!=', '')
            ->get(['name', 'latitude', 'longitude', 'district']);

        return view('admin.farmers.map', compact('districtData', 'farmers'));
    }



}