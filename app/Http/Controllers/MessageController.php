<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\MessageReceived;

class MessageController extends Controller
{
    // Display all messages for the logged-in user
    public function conversation()
    {
        // Fetch all other users as contacts
        $contacts = User::where('id', '!=', auth()->id())->get();
        return view('messages.conversation', compact('contacts'));
    }

    public function send(Request $request)
    {
        // Validate the request
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string|max:255',
        ]);

        // Create a new message
        $message = new Message();
        $message->sender_id = Auth::id(); // Current logged-in user
        $message->receiver_id = $request->receiver_id; // Receiver of the message
        $message->message = $request->message;
        $message->save();

        // Send email notification (optional)
        $receiver = User::find($request->receiver_id);
        $sender = Auth::user(); // Get the sender (current user)
        $messageContent = $request->message; // The actual message content

        // Now pass all three arguments to the MessageReceived mailable
        Mail::to($receiver->email)->send(new MessageReceived($receiver, $sender, $messageContent));

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Message sent successfully!');
    }
    // Fetch messages for a particular conversation
    public function fetchMessages(Request $request)
    {
        $receiverId = $request->receiver_id;
        $messages = Message::where(function ($query) use ($receiverId) {
                $query->where('sender_id', Auth::id())
                      ->orWhere('receiver_id', Auth::id());
            })
            ->where(function ($query) use ($receiverId) {
                $query->where('sender_id', $receiverId)
                      ->orWhere('receiver_id', $receiverId);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($messages);
    }

    // Send a new message
  

    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string'
        ]);
    
        Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);
    
        return redirect()->route('messages.show', $request->receiver_id)->with('success', 'Message sent!');
    }
    
public function showConversation($contact_id)
{
    $user = auth()->user();
    
    // Get the selected contact
    $contact = User::findOrFail($contact_id);
    
    // Retrieve messages between the authenticated user and the selected contact
    $messages = Message::where(function($query) use ($user, $contact) {
        $query->where('sender_id', $user->id)
              ->where('receiver_id', $contact->id);
    })->orWhere(function($query) use ($user, $contact) {
        $query->where('sender_id', $contact->id)
              ->where('receiver_id', $user->id);
    })->orderBy('created_at', 'asc')->get();

    return view('messages.conversation', compact('messages', 'contact'));
}
public function show($id)
{
    $contacts = User::where('id', '!=', auth()->id())->get();
    $contact = User::findOrFail($id);
    $messages = Message::where(function($query) use ($id) {
            $query->where('sender_id', auth()->id())->where('receiver_id', $id);
        })
        ->orWhere(function($query) use ($id) {
            $query->where('sender_id', $id)->where('receiver_id', auth()->id());
        })
        ->get();

    return view('messages.conversation', compact('contacts', 'contact', 'messages'));
}


}
