<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Events\MessageSent;
use App\Models\Conversation;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        $conversations = Conversation::where('user_one_id', $userId)
            ->orWhere('user_two_id', $userId)
            ->with(['userOne', 'userTwo'])
            ->get();

        $users = User::where('id', '!=', $userId)->get();

        return view('conversations.index', compact('conversations', 'users'));
    }

    public function show($userId)
{
    $currentUserId = auth()->id();

    // If trying to chat with yourself, abort
    if ($currentUserId == $userId) {
        abort(403, 'You cannot chat with yourself');
    }

    // Find the other user
    $otherUser = User::findOrFail($userId);

    // Try to find an existing conversation
    $conversation = Conversation::where(function ($query) use ($currentUserId, $userId) {
        $query->where('user_one_id', min($currentUserId, $userId))
              ->where('user_two_id', max($currentUserId, $userId));
    })->first();

    // If no conversation exists, create a new one
    if (!$conversation) {
        $conversation = Conversation::create([
            'user_one_id' => min($currentUserId, $userId),
            'user_two_id' => max($currentUserId, $userId)
        ]);
    }

    // Get messages for this conversation
    $messages = $conversation->messages()->with('sender')->get();

    return view('conversations.show', compact('conversation', 'messages', 'otherUser'));
}

    public function store(Request $request)
    {
        $request->validate([
            'recipient_id' => 'required|exists:users,id',
            'message' => 'required|string'
        ]);

        $currentUserId = auth()->id();
        $recipientId = $request->recipient_id;

        // Find or create conversation
        $conversation = Conversation::firstOrCreate(
            [
                'user_one_id' => min($currentUserId, $recipientId),
                'user_two_id' => max($currentUserId, $recipientId)
            ]
        );

        // Create message
        $message = Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $currentUserId,
            'message' => $request->message
        ]);

        // Broadcast message
        event(new MessageSent($message));

        return response()->json(['status' => 'Message Sent']);
    }
}
