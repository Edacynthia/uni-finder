<?php

namespace App\Http\Controllers;

use App\Models\MarketerProfile;
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

    $marketers = MarketerProfile::with('user')->latest()->take(9)->get();

    return view('dashboard.marketer', compact('marketers', 'activeProducts'));
}
    public function buyer()
    {
        return view('dashboard.user');
    }
}
