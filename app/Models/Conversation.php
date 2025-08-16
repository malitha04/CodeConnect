<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Auth;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = ['user_one', 'user_two'];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class)->orderBy('created_at', 'asc');
    }

    public function userOne(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_one');
    }

    public function userTwo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_two');
    }

    /**
     * Get the other user in the conversation
     */
    public function getOtherUserAttribute()
    {
        $currentUserId = Auth::id();
        return $this->user_one === $currentUserId ? $this->userTwo : $this->userOne;
    }

    /**
     * Get the last message in the conversation
     */
    public function getLastMessageAttribute()
    {
        return $this->messages()->latest()->first();
    }

    /**
     * Check if the conversation has unread messages for the current user
     */
    public function hasUnreadMessages()
    {
        $currentUserId = Auth::id();
        return $this->messages()
            ->where('sender_id', '!=', $currentUserId)
            ->where('is_read', false)
            ->exists();
    }

    /**
     * Mark all messages as read for the current user
     */
    public function markAsRead()
    {
        $currentUserId = Auth::id();
        $this->messages()
            ->where('sender_id', '!=', $currentUserId)
            ->where('is_read', false)
            ->update(['is_read' => true]);
    }

    /**
     * Get unread message count for the current user
     */
    public function getUnreadCountAttribute()
    {
        $currentUserId = Auth::id();
        return $this->messages()
            ->where('sender_id', '!=', $currentUserId)
            ->where('is_read', false)
            ->count();
    }
}
