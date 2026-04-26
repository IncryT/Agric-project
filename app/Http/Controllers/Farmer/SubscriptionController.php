<?php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the farmer's active subscriptions and the form to add new ones.
     */
    public function index()
    {
        $products = Product::all();
        // Eager load the product details for the active subscriptions list
        $subscriptions = Subscription::with('product')
                            ->where('user_id', Auth::id())
                            ->get();

        return view('farmer.subscriptions.index', compact('products', 'subscriptions'));
    }

    /**
     * Store a newly created subscription in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'cop' => 'required|numeric|min:0',
            'profit_margin' => 'required|numeric|min:0',
            'frequency' => 'required|in:daily_summary',
        ]);

        // Create or update the subscription for this specific user and product
        Subscription::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'product_id' => $validated['product_id'],
            ],
            [
                'cop' => $validated['cop'],
                'profit_margin' => $validated['profit_margin'],
                'frequency' => $validated['frequency'],
            ]
        );

        return redirect()->route('farmer.subscriptions.index')
                         ->with('success', 'SMS alert preferences updated successfully.');
    }

    /**
     * Remove the specified subscription (Unsubscribe).
     */
    public function destroy(Subscription $subscription)
    {
        // Ensure the user owns the subscription before deleting
        if ($subscription->user_id === Auth::id()) {
            $subscription->delete();
            return redirect()->route('farmer.subscriptions.index')
                             ->with('success', 'You have successfully unsubscribed from the alert.');
        }

        abort(403, 'Unauthorized action.');
    }
}