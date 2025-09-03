<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MarketerProfile;
use App\Models\Product;
use App\Models\User;
use App\Models\Message; // 👈 Add this
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function admin()
    {
        // Total users
        $totalUsers = User::count();

        // Total marketers (those who have a profile)
        $totalMarketers = MarketerProfile::count();

        // Total products
        $totalProducts = Product::count();

        // Latest messages (paginate 5)
        $messages = Message::latest()->paginate(5);


        return view('dashboard.admin', compact('totalUsers', 'totalMarketers', 'totalProducts', 'messages'));
    }

    public function showMessage($id)
    {
        $message = Message::findOrFail($id);
        return view('admin.messages.show', compact('message'));
    }

    public function markResolved($id)
    {
        $message = Message::findOrFail($id);
        $message->update(['status' => 'resolved']);
        $message->save();

        return redirect()->route('admin.messages.index')->with('success', 'Message marked as resolved.');
    }

public function listMessages()
{
    // Separate pending and resolved messages
    $pendingMessages  = Message::where('status', 'pending')->latest()->paginate(10);
    $resolvedMessages = Message::where('status', 'resolved')->latest('updated_at')->paginate(10);

    return view('admin.messages.index', compact('pendingMessages', 'resolvedMessages'));
}
}
