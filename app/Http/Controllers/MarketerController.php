<?php

namespace App\Http\Controllers;

use App\Models\MarketerProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MarketerController extends Controller
{
    /**
     * Show all marketers.
     */
    public function index(Request $request)
    {
        // Paginate all marketers with their user data
        $query = MarketerProfile::with('user');

         if ($request->filled('search')) {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->whereHas('user', function ($sub) use ($search) {
                $sub->where('name', 'like', "%{$search}%");
            })
            ->orWhere('business_name', 'like', "%{$search}%")
            ->orWhere('bio', 'like', "%{$search}%");
        });
    }

    $marketers = $query->paginate(9)->appends(['search' => $request->search]);

     // Get array of marketer IDs that the current logged in user has saved
    $userFavorites = [];
    if (Auth::check()) {
        // favorites() is the belongsToMany on User -> MarketerProfile
       $userFavorites = Auth::user()
    ->favorites()
    ->pluck('marketer_profiles.id')
    ->toArray();
    }
       
        return view('marketer.index', compact('marketers', 'userFavorites'));
    }

    /**
     * Show a single marketer profile.
     */
    public function show($id)
    {
        $marketer = MarketerProfile::with('user')->findOrFail($id);

        // Get all products for this marketer
        $products = $marketer->products()->latest()->get();

        return view('marketer.show', compact('marketer', 'products'));
    }

    // MarketerController.php
public function showProfile($id)
{
    $user = User::with('marketerProfile')->findOrFail($id);

    return view('marketer.profile.show', compact('user'));
}

 public function editProfile()
    {
        $profile = MarketerProfile::firstOrNew(['user_id' => Auth::id()]);
        return view('marketer.profile.edit', compact('profile'));
    }

    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'business_name'  => 'nullable|string|max:255',
            'phone'          => 'nullable|string|max:20',
            'whatsapp'       => 'nullable|string|max:20',
            'instagram'        => 'nullable|string|max:255',
            'bio'            => 'nullable|string|max:1000',
            'profile_image'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $profile = MarketerProfile::firstOrNew(['user_id' => Auth::id()]);

        // Fill other fields
        $profile->fill($validated);

        // Handle image upload
        if ($request->hasFile('profile_image')) {
            // Delete old image if it exists
            if ($profile->profile_image && Storage::disk('public')->exists($profile->profile_image)) {
                Storage::disk('public')->delete($profile->profile_image);
            }

            // Store new image
            $path = $request->file('profile_image')->store('marketer_profiles', 'public');
            $profile->profile_image = $path;
        }

        $profile->save();

        return redirect()->route('marketer.profile.edit')->with('success', 'Profile updated successfully!');
    }
}
