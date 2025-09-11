<?php

namespace App\Http\Controllers;

use App\Models\MarketerProfile;
use App\Models\SearchHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
   public function marketer()
{
    $user = Auth::user(); // logged in marketer

    // dd($user->products()->get()); 

    // Count products created by this marketer
    $activeProducts = $user->products()->count();

     $favoriteCount = 0;
    if ($user->marketerProfile) {
        $favoriteCount = $user->marketerProfile->favoritedBy()->count();
    }
    
    $marketers = MarketerProfile::with('user')->latest()->take(9)->get();

    return view('dashboard.marketer', compact('marketers', 'activeProducts', 'favoriteCount'));
}


    public function buyer()
{
    $user = Auth::user();

    // Get marketer IDs the user has already favorited
    $userFavorites = $user->favorites()->pluck('marketer_profiles.id')->toArray();

    // Count of marketers followed
    $followedCount = count($userFavorites);

    // Recommended marketers (exclude already favorited + the user’s own profile if marketer)
    $recommendedMarketers = MarketerProfile::whereNotIn('id', $userFavorites)
        ->when($user->marketerProfile, function ($query) use ($user) {
            $query->where('id', '!=', $user->marketerProfile->id);
        })
        ->with('user') // so you can show marketer's name
        ->take(2) // show 6 recommended marketers
        ->get();

     $lastFavorite = $user->favorites()
        ->with('user') // marketer's owner
        ->latest('favorites.created_at')
        ->first();


$lastSearch = null;
if (Auth::check()) {
    $lastSearch = \App\Models\SearchHistory::with('category')
                   ->where('user_id', Auth::id())
                   ->latest('updated_at')
                   ->first();
}


    return view('dashboard.user', compact('followedCount', 'recommendedMarketers', 'userFavorites', 'lastFavorite', 'lastSearch'));
}

}
