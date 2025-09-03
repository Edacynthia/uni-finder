<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MarketerProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
  public function index(Request $request)
{
    $role = $request->query('role'); // ?role=buyer, marketer, admin

    $query = User::query();

    if ($role) {
        $query->whereHas('roles', function ($q) use ($role) {
            $q->where('name', $role);
        });
    }

    // 👇 Order by oldest first (ascending)
    $users = $query->orderBy('created_at', 'desc')->paginate(10);

    return view('admin.users.index', compact('users', 'role'));
}


    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
    }

    public function create()
{
    return view('admin.users.create');
}

public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:6|confirmed',
        'role' => 'required|in:user,marketer,admin',
    ]);

    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
    ]);

    $user->assignRole($validated['role']);

    // ✅ Create empty marketer profile if role = marketer
    if ($validated['role'] === 'marketer') {
        MarketerProfile::firstOrCreate(['user_id' => $user->id]);
    }

    return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
}

   public function edit(User $user)
    {
        $user->load('roles'); // Ensure roles are loaded
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|exists:roles,name',
        ]);

        // Update user details
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        // Update role using Spatie
        $user->syncRoles([$validated['role']]);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully');
    }
}
