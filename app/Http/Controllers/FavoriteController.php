<?php

namespace App\Http\Controllers;

use App\Models\MarketerProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Save a marketer to favorites.
     */
    public function store($marketerId)
    {
        $user = Auth::user();
        $marketer = MarketerProfile::findOrFail($marketerId);

        // Prevent saving your own profile
        if ($user->marketerProfile && $user->marketerProfile->id === $marketer->id) {
            return back()->with('error', 'You cannot save your own profile.');
        }

        // Attach only if not already saved
        if (! $user->favorites()->where('marketer_profiles.id', $marketerId)->exists()) {
            $user->favorites()->attach($marketerId);
        }

        return back()->with('success', 'Marketer saved to favorites!');
    }

    /**
     * Remove a marketer from favorites.
     */
    public function destroy($marketerId)
    {
        $user = Auth::user();
        // Only detach if the user has this marketer as favorite
        if ($user->favorites()->where('marketer_profiles.id', $marketerId)->exists()) {
            $user->favorites()->detach($marketerId);
            return back()->with('success', 'Marketer removed from favorites.');
        }
        return back()->with('error', 'You can only remove marketers you have favorited.');
    }

    /**
     * Show all favorites for the logged-in user.
     */
    public function index()
    {
        $user = Auth::user();

        $favorites = $user->favorites()
            ->with('user') // load marketer's owner
            ->paginate(10);

        return view('favorites.index', compact('favorites'));
    }
}
