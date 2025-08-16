@extends('layouts.dashboard')

@section('title', 'Notifications')

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold">Notifications</h1>
                    <p class="text-text-secondary mt-2">Stay updated with your project activities.</p>
                </div>
                @if(Auth::user()->unreadNotifications->count() > 0)
                    <form method="POST" action="{{ route('notifications.markAllAsRead') }}" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="bg-accent-green hover:bg-accent-green-hover text-white px-4 py-2 rounded-lg font-medium transition-colors">
                            Mark All as Read
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <!-- Notifications List -->
        <div class="space-y-4">
            @forelse ($notifications as $notification)
                <div class="bg-card-dark border border-border-custom rounded-xl p-6 {{ $notification->read_at ? 'opacity-75' : '' }}">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            @if(!$notification->read_at)
                                <div class="w-2 h-2 bg-accent-green rounded-full mb-2"></div>
                            @endif
                            
                            <div class="flex items-center mb-2">
                                <h3 class="font-semibold text-lg">{{ $notification->data['message'] ?? 'New notification' }}</h3>
                                <span class="ml-2 text-sm text-text-muted">{{ $notification->created_at->diffForHumans() }}</span>
                            </div>
                            
                            @if(isset($notification->data['project_title']))
                                <p class="text-text-secondary mb-2">
                                    <strong>Project:</strong> {{ $notification->data['project_title'] }}
                                </p>
                            @endif
                            
                            @if(isset($notification->data['developer_name']))
                                <p class="text-text-secondary mb-2">
                                    <strong>Developer:</strong> {{ $notification->data['developer_name'] }}
                                </p>
                            @endif
                            
                            @if(isset($notification->data['bid_amount']))
                                <p class="text-text-secondary mb-2">
                                    <strong>Bid Amount:</strong> ${{ number_format($notification->data['bid_amount'], 2) }}
                                </p>
                            @endif
                            
                            @if(!$notification->read_at)
                                <form method="POST" action="{{ route('notifications.markAsRead', $notification->id) }}" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="text-accent-green hover:text-accent-green-hover text-sm font-medium">
                                        Mark as Read
                                    </button>
                                </form>
                            @endif
                        </div>
                        
                        <div class="ml-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-accent-green to-accent-green-hover rounded-lg flex items-center justify-center">
                                <i class="fas fa-bell text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-card-dark border border-border-custom rounded-xl p-8 text-center">
                    <div class="w-16 h-16 bg-secondary-dark rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-bell text-text-muted text-2xl"></i>
                    </div>
                    <h2 class="text-xl font-semibold mb-2">No Notifications</h2>
                    <p class="text-text-secondary">You're all caught up! No new notifications at the moment.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($notifications->hasPages())
            <div class="mt-8">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>
@endsection

