<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'subject',
        'message',
        'status',
        'admin_reply',
        'replied_at'
    ];

    protected $casts = [
        'replied_at' => 'datetime',
    ];

    /**
     * Get the status badge class for display
     */
    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            'unread' => 'bg-red-500/20 text-red-500',
            'read' => 'bg-yellow-500/20 text-yellow-500',
            'replied' => 'bg-green-500/20 text-green-500',
            default => 'bg-gray-500/20 text-gray-500',
        };
    }

    /**
     * Get the status display name
     */
    public function getStatusDisplayAttribute()
    {
        return match($this->status) {
            'unread' => 'Unread',
            'read' => 'Read',
            'replied' => 'Replied',
            default => 'Unknown',
        };
    }

    /**
     * Scope to get only unread messages
     */
    public function scopeUnread($query)
    {
        return $query->where('status', 'unread');
    }

    /**
     * Scope to get only read messages
     */
    public function scopeRead($query)
    {
        return $query->where('status', 'read');
    }

    /**
     * Scope to get only replied messages
     */
    public function scopeReplied($query)
    {
        return $query->where('status', 'replied');
    }
}
