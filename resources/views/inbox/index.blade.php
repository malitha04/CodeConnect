@extends('layouts.dashboard')

@section('title', 'Inbox')

@section('content')
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex justify-between items-center mb-8 pb-6 border-b border-border-custom">
            <h1 class="text-4xl font-extrabold text-text-primary">Inbox</h1>
            <div class="flex items-center space-x-4">
                <span class="text-text-secondary text-sm">
                    <i class="fas fa-envelope mr-2"></i>
                    {{ $conversations->sum('unreadCount') }} unread messages
                </span>
            </div>
        </div>

        @if (session('status'))
            <div class="mb-6 p-4 bg-green-600/20 border border-green-500/50 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                    <p class="text-green-500">{{ session('status') }}</p>
                </div>
            </div>
        @endif

        @if ($conversations->isEmpty())
            <div class="bg-card-dark border border-border-custom rounded-xl p-8 text-center">
                <i class="fas fa-inbox text-4xl text-text-muted mb-4"></i>
                <p class="text-text-secondary text-xl">You have no messages yet.</p>
                <p class="text-text-muted mt-2">Start conversations with developers or clients to collaborate on projects.</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach ($conversations as $conversation)
                    @php
                        $otherUser = $conversation->otherUser;
                        $lastMessage = $conversation->lastMessage;
                        $unreadCount = $conversation->unreadCount;
                    @endphp
                    
                    <a href="{{ route('inbox.show', $conversation) }}" class="block">
                        <div class="bg-card-dark border border-border-custom rounded-2xl p-6 hover:border-accent-green hover:shadow-lg transition-all duration-300 cursor-pointer group">
                            <div class="flex items-center space-x-4">
                                <!-- User Avatar -->
                                <div class="relative">
                                    <div class="w-12 h-12 rounded-full overflow-hidden shadow-md">
                                        @if($otherUser->avatar_url)
                                            <img src="{{ $otherUser->avatar_url }}" alt="{{ $otherUser->name }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full bg-gradient-to-br from-accent-green to-accent-green-hover flex items-center justify-center text-white font-bold text-xl">
                                                {{ $otherUser->initial }}
                                            </div>
                                        @endif
                                    </div>
                                    @if($unreadCount > 0)
                                        <div class="absolute -top-1 -right-1 bg-gradient-to-r from-red-500 to-red-600 text-white text-xs rounded-full w-6 h-6 flex items-center justify-center font-bold shadow-lg animate-pulse">
                                            {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                                        </div>
                                    @endif
                                </div>

                                <!-- Conversation Info -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between mb-2">
                                        <h3 class="text-lg font-semibold text-text-primary group-hover:text-accent-green transition-colors">
                                            {{ $otherUser->name }}
                                        </h3>
                                        @if($lastMessage)
                                            <span class="text-xs text-text-muted whitespace-nowrap">
                                                {{ $lastMessage->created_at->diffForHumans() }}
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <div class="flex items-center space-x-3 mb-2">
                                        <span class="text-xs px-3 py-1 rounded-full font-medium
                                            @if($otherUser->hasRole('Developer')) bg-blue-500/20 text-blue-500
                                            @else bg-green-500/20 text-green-500
                                            @endif">
                                            {{ $otherUser->hasRole('Developer') ? 'Developer' : 'Client' }}
                                        </span>
                                        @if($unreadCount > 0)
                                            <span class="text-xs text-accent-green font-medium">
                                                {{ $unreadCount }} new message{{ $unreadCount > 1 ? 's' : '' }}
                                            </span>
                                        @endif
                                    </div>

                                    @if($lastMessage)
                                        <p class="text-sm text-text-secondary truncate">
                                            <span class="font-medium">{{ $lastMessage->sender->name }}:</span>
                                            {{ Str::limit($lastMessage->body, 80) }}
                                        </p>
                                    @else
                                        <p class="text-sm text-text-muted italic">No messages yet</p>
                                    @endif
                                </div>

                                <!-- Action Icons -->
                                <div class="flex items-center space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <i class="fas fa-chevron-right text-text-muted"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
@endsection
