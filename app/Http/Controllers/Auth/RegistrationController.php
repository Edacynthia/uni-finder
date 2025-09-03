<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\MarketerProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class RegistrationController extends Controller
{
    /**
     * Show registration form
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle registration
     */
    public function store(Request $request)
{
    $accountType = $request->input('account_type', 'user');

    // ✅ Validation
    $rules = [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'confirmed', 'min:8'],
    ];

    if ($accountType === 'marketer') {
        $rules = array_merge($rules, [
            'business_name' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'instagram' => ['nullable', 'string', 'max:255'],
            'whatsapp_country_code' => ['nullable', 'digits_between:1,3'],
            'whatsapp_number' => ['nullable', 'digits_between:6,12'],
            'profile_image' => ['nullable', 'image', 'max:2048'],
        ]);
    }

    $validated = $request->validate($rules);
    $validated['email'] = strtolower($validated['email']);

    // ✅ Create User
    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
    ]);

    // ✅ Assign Role
    if ($accountType === 'marketer') {
        $user->assignRole('marketer');
    } else {
        $user->assignRole('user');
    }

    // ✅ Create Marketer Profile if needed
    if ($accountType === 'marketer') {
        $whatsappFull = null;
        if ($request->whatsapp_country_code && $request->whatsapp_number) {
            $whatsappFull = preg_replace('/\D/', '', $request->whatsapp_country_code . $request->whatsapp_number);
        }

        $profileData = [
            'user_id' => $user->id,
            'business_name' => $request->input('business_name'),
            'phone' => $request->input('phone'),
            'bio' => $request->input('bio'),
            'instagram' => $request->input('instagram'),
            'whatsapp' => $whatsappFull,
        ];

        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profiles', 'public');
            $profileData['profile_image'] = $path;
        }

        MarketerProfile::create($profileData);
    }

    // ✅ Log user in immediately
    Auth::login($user);

    // ✅ Redirect based on role
    if ($user->hasRole('admin')) {
        return redirect()->route('dashboard.admin')->with('success', 'Welcome Admin!');
    } elseif ($user->hasRole('marketer')) {
        return redirect()->route('dashboard.marketer')->with('success', 'Welcome Marketer!');
    } else {
        return redirect()->route('dashboard.user')->with('success', 'Welcome User!');
    }
}
}