<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $credentials['email'] = strtolower($credentials['email']);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            return $this->authenticated($request, Auth::user());
        }

        return back()->withErrors([
            'email' => 'Invalid login credentials.',
        ]);
    }

    protected function authenticated(Request $request, $user)
    {
        // If user came with a search query (either from home or redirected login), go to search
        if ($request->has('q')) {
            return redirect()->route('search.index', ['q' => $request->q]);
        }

        // If they were on /search?q=... and got redirected to login
        if (session()->has('intended_url')) {
            $url = session()->pull('intended_url');
            return redirect($url);
        }

        // Otherwise redirect by role
        if ($user->hasRole('admin')) {
            return redirect()->route('dashboard.admin');
        } elseif ($user->hasRole('marketer')) {
            return redirect()->route('dashboard.marketer');
        } else {
            return redirect()->route('dashboard.user');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
