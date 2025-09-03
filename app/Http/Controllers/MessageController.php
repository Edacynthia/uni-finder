<?php
namespace App\Http\Controllers;

use App\Mail\ReplyToUserMail;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MessageController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string|min:10',
        ]);

        Message::create([
            'user_id' => Auth::id(),
            'name'    => $validated['name'],
            'email'   => $validated['email'],
            'message' => $validated['message'],
            'status'  => 'pending', 
        ]);

        return back()->with('success', 'Your message has been submitted successfully!');
    }

    

    public function reply(Request $request, $id)
{
    $request->validate([
        'replyMessage' => 'required|string',
    ]);

    $message = Message::findOrFail($id);

    Mail::to($message->email)->send(
        new ReplyToUserMail($message->name, $request->replyMessage)
    );

    return back()->with('success', 'Reply email sent successfully!');
}

public function destroy($id)
{
    $message = Message::findOrFail($id);
    $message->delete();

    return redirect()->back()->with('success', 'Message deleted successfully!');
}


}
