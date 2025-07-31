@extends('layouts.dashboard')

@section('title', 'Inbox')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Inbox</h1>

    <div class="space-y-4">
        @forelse ($conversations as $conversation)
            @php
                // Determine the other user in the conversation
                $otherUser = $conversation->user_one === Auth::id() ? $conversation->userTwo : $conversation->userOne;
                $lastMessage = $conversation->messages->last();
            @endphp
            <div class="flex items-center space-x-4 p-4 bg-card-dark border border-border-custom rounded-lg hover:border-accent-green transition cursor-pointer">
                <img src="https://images.unsplash.com/photo-1494790108755-2616b332c1cf?w=40&h=40&fit=crop&crop=face" class="w-10 h-10 rounded-full" alt="User Avatar">
                <div class="flex-1">
                    <p class="font-medium">{{ $otherUser->name }} 
                        <span class="text-text-muted text-sm">• {{ $otherUser->hasRole('Developer') ? 'Developer' : 'Client' }}</span>
                    </p>
                    @if($lastMessage)
                        <p class="text-sm text-text-secondary">{{ Str::limit($lastMessage->body, 60) }}</p>
                    @endif
                </div>
                @if($lastMessage)
                    <span class="text-xs text-text-muted whitespace-nowrap">{{ $lastMessage->created_at->diffForHumans() }}</span>
                @endif
            </div>
        @empty
            <div class="text-center text-text-secondary py-8">
                <p>You have no messages yet.</p>
            </div>
        @endforelse
    </div>
@endsection
