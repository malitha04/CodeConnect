<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;

class ConversationController extends Controller
{
    /**
     * Display the inbox with all conversations
     */
    public function index(): View
    {
        $conversations = Auth::user()->getAllConversations();
        
        // Sort conversations by latest message
        $conversations = $conversations->sortByDesc(function ($conversation) {
            return $conversation->lastMessage ? $conversation->lastMessage->created_at : $conversation->created_at;
        });

        return view('inbox.index', compact('conversations'));
    }

    /**
     * Show a specific conversation
     */
    public function show(Conversation $conversation): View
    {
        // Check if user is part of this conversation
        if ($conversation->user_one !== Auth::id() && $conversation->user_two !== Auth::id()) {
            abort(403, 'You are not authorized to view this conversation.');
        }

        // Mark messages as read
        $conversation->markAsRead();

        // Get the other user
        $otherUser = $conversation->otherUser;

        // Get messages with pagination
        $messages = $conversation->messages()->with('sender')->paginate(50);

        return view('inbox.show', compact('conversation', 'otherUser', 'messages'));
    }

    /**
     * Show the form for creating a new conversation
     */
    public function create(Request $request): View
    {
        $userId = $request->get('user_id');
        $user = null;
        
        if ($userId) {
            $user = User::find($userId);
        }
        
        return view('inbox.create', compact('user'));
    }

    /**
     * Store a new conversation
     */
    public function store(Request $request): RedirectResponse
    {
        return $this->startConversation($request);
    }

    /**
     * Start a new conversation or get existing one
     */
    public function startConversation(Request $request): RedirectResponse
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $otherUserId = $request->user_id;
        $currentUserId = Auth::id();

        // Check if conversation already exists
        $conversation = Conversation::where(function ($query) use ($currentUserId, $otherUserId) {
            $query->where('user_one', $currentUserId)
                  ->where('user_two', $otherUserId);
        })->orWhere(function ($query) use ($currentUserId, $otherUserId) {
            $query->where('user_one', $otherUserId)
                  ->where('user_two', $currentUserId);
        })->first();

        if (!$conversation) {
            // Create new conversation
            $conversation = Conversation::create([
                'user_one' => $currentUserId,
                'user_two' => $otherUserId,
            ]);
        }

        return redirect()->route('inbox.show', $conversation);
    }

    /**
     * Send a message in a conversation
     */
    public function sendMessage(Request $request, Conversation $conversation): JsonResponse
    {
        // Check if user is part of this conversation
        if ($conversation->user_one !== Auth::id() && $conversation->user_two !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        $message = $conversation->messages()->create([
            'sender_id' => Auth::id(),
            'body' => $request->body,
        ]);

        // Load the sender relationship
        $message->load('sender');

        // Update conversation timestamp
        $conversation->touch();

        return response()->json([
            'message' => $message,
            'html' => view('inbox.partials.message', compact('message'))->render(),
        ]);
    }

    /**
     * Mark a conversation as read
     */
    public function markAsRead(Conversation $conversation): JsonResponse
    {
        // Check if user is part of this conversation
        if ($conversation->user_one !== Auth::id() && $conversation->user_two !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $conversation->markAsRead();

        return response()->json(['success' => true]);
    }

    /**
     * Get unread message count for the current user
     */
    public function getUnreadCount(): JsonResponse
    {
        $conversations = Auth::user()->getAllConversations();
        $totalUnread = $conversations->sum('unreadCount');

        return response()->json(['count' => $totalUnread]);
    }

    /**
     * Delete a conversation
     */
    public function destroy(Conversation $conversation): RedirectResponse
    {
        // Check if user is part of this conversation
        if ($conversation->user_one !== Auth::id() && $conversation->user_two !== Auth::id()) {
            abort(403, 'You are not authorized to delete this conversation.');
        }

        $conversation->delete();

        return redirect()->route('inbox.index')->with('status', 'Conversation deleted successfully.');
    }
}
