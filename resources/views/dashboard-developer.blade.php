@extends('layouts.dashboard')

@section('title', 'Developer Dashboard')

@section('content')
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold">Welcome back, {{ Auth::user()->name }}!</h1>
        <p class="text-text-secondary mt-2">Here's what's happening with your freelance business today.</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-card-dark border border-border-custom rounded-xl p-6">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-text-secondary text-sm">Active Projects</p>
                    <p class="text-2xl font-bold text-accent-green">{{ $activeProjects->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-accent-green/20 rounded-full flex items-center justify-center">
                    <i class="fas fa-code text-accent-green"></i>
                </div>
            </div>
        </div>
        <div class="bg-card-dark border border-border-custom rounded-xl p-6">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-text-secondary text-sm">Pending Proposals</p>
                    <p class="text-2xl font-bold text-accent-orange">{{ $proposalsCount - $acceptedProposalsCount }}</p>
                </div>
                <div class="w-12 h-12 bg-accent-orange/20 rounded-full flex items-center justify-center">
                    <i class="fas fa-clock text-accent-orange"></i>
                </div>
            </div>
        </div>
        <div class="bg-card-dark border border-border-custom rounded-xl p-6">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-text-secondary text-sm">This Month Earnings</p>
                    <p class="text-2xl font-bold text-text-primary">${{ number_format($thisMonthEarnings, 2) }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-500/20 rounded-full flex items-center justify-center">
                    <i class="fas fa-dollar-sign text-blue-500"></i>
                </div>
            </div>
        </div>
        <div class="bg-card-dark border border-border-custom rounded-xl p-6">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-text-secondary text-sm">Rating</p>
                    <p class="text-2xl font-bold text-yellow-400">{{ number_format($averageRating, 1) }}</p>
                </div>
                <div class="w-12 h-12 bg-yellow-400/20 rounded-full flex items-center justify-center">
                    <i class="fas fa-star text-yellow-400"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid lg:grid-cols-3 gap-8">
        <!-- Left Column -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Active Projects -->
            <div class="bg-card-dark border border-border-custom rounded-xl p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-semibold">Active Projects</h2>
                    <a href="{{ route('proposals.index_developer') }}" class="text-accent-green hover:text-accent-green-hover text-sm">View All</a>
                </div>
                <div class="space-y-4">
                    @forelse ($activeProjects as $project)
                        <div class="border border-border-custom rounded-lg p-4 hover:border-accent-green transition-colors">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h3 class="font-semibold mb-2">{{ $project->title }}</h3>
                                    <p class="text-text-secondary text-sm mb-3">{{ Str::limit($project->description, 120) }}</p>
                                    <div class="flex items-center text-sm text-text-muted">
                                        <span class="mr-4"><i class="fas fa-calendar mr-1"></i>Due: {{ $project->deadline ? $project->deadline->format('M d, Y') : 'No deadline' }}</span>
                                        <span class="mr-4"><i class="fas fa-dollar-sign mr-1"></i>${{ number_format($project->proposals->first()->bid_amount ?? 0, 2) }}</span>
                                        <span class="bg-accent-green/20 text-accent-green px-2 py-1 rounded-full text-xs">{{ ucfirst(str_replace('_', ' ', $project->status)) }}</span>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="w-16 h-16 bg-gradient-to-br from-accent-green to-accent-green-hover rounded-lg flex items-center justify-center">
                                        <i class="fas fa-code text-white"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-text-secondary py-8">
                            <p>No active projects yet.</p>
                            <a href="{{ route('projects.browse') }}" class="mt-4 inline-block bg-accent-green hover:bg-accent-green-hover text-white px-4 py-2 rounded-lg font-medium transition-colors">
                                Browse Projects
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Recent Proposals -->
            <div class="bg-card-dark border border-border-custom rounded-xl p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-semibold">Recent Proposals</h2>
                    <a href="{{ route('proposals.index_developer') }}" class="text-accent-green hover:text-accent-green-hover text-sm">View All</a>
                </div>
                <div class="space-y-4">
                    @forelse ($recentProposals as $proposal)
                        <div class="border border-border-custom rounded-lg p-4">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h3 class="font-semibold mb-2">{{ $proposal->project->title }}</h3>
                                    <p class="text-text-secondary text-sm mb-3">{{ Str::limit($proposal->project->description, 100) }}</p>
                                    <div class="flex items-center text-sm text-text-muted">
                                        <span class="mr-4"><i class="fas fa-clock mr-1"></i>Submitted {{ $proposal->created_at->diffForHumans() }}</span>
                                        <span class="mr-4"><i class="fas fa-dollar-sign mr-1"></i>${{ number_format($proposal->bid_amount, 2) }}</span>
                                        @switch($proposal->status)
                                            @case('pending')
                                                <span class="bg-blue-500/20 text-blue-500 px-2 py-1 rounded-full text-xs">Pending</span>
                                                @break
                                            @case('accepted')
                                                <span class="bg-green-500/20 text-green-500 px-2 py-1 rounded-full text-xs">Accepted</span>
                                                @break
                                            @case('rejected')
                                                <span class="bg-red-500/20 text-red-500 px-2 py-1 rounded-full text-xs">Rejected</span>
                                                @break
                                            @default
                                                <span class="bg-gray-500/20 text-gray-500 px-2 py-1 rounded-full text-xs">{{ ucfirst($proposal->status) }}</span>
                                        @endswitch
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-text-secondary py-8">
                            <p>No proposals submitted yet.</p>
                            <a href="{{ route('projects.browse') }}" class="mt-4 inline-block bg-accent-green hover:bg-accent-green-hover text-white px-4 py-2 rounded-lg font-medium transition-colors">
                                Browse Projects
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="space-y-8">
            <!-- Quick Actions -->
            <div class="bg-card-dark border border-border-custom rounded-xl p-6">
                <h2 class="text-xl font-semibold mb-6">Quick Actions</h2>
                <div class="space-y-3">
                    <a href="{{ route('projects.browse') }}" class="w-full bg-accent-green hover:bg-accent-green-hover text-white px-4 py-3 rounded-lg font-medium transition-colors block text-center">
                        <i class="fas fa-search mr-2"></i>Browse New Projects
                    </a>
                    <a href="{{ route('settings.index') }}" class="w-full bg-secondary-dark hover:bg-card-dark text-text-primary px-4 py-3 rounded-lg font-medium transition-colors border border-border-custom block text-center">
                        <i class="fas fa-edit mr-2"></i>Update Profile
                    </a>
                    <a href="{{ route('deliveries.index') }}" class="w-full bg-secondary-dark hover:bg-card-dark text-text-primary px-4 py-3 rounded-lg font-medium transition-colors border border-border-custom block text-center">
                        <i class="fas fa-box-open mr-2"></i>My Deliveries
                    </a>
                    @if($activeProjects->count() > 0)
                        @php
                            $firstActiveProject = $activeProjects->first();
                        @endphp
                        <a href="{{ route('deliveries.create', $firstActiveProject) }}" class="w-full bg-accent-orange hover:bg-orange-600 text-white px-4 py-3 rounded-lg font-medium transition-colors block text-center">
                            <i class="fas fa-upload mr-2"></i>Upload Delivery
                        </a>
                    @endif
                    <a href="{{ route('reviews.received') }}" class="w-full bg-secondary-dark hover:bg-card-dark text-text-primary px-4 py-3 rounded-lg font-medium transition-colors border border-border-custom block text-center">
                        <i class="fas fa-star mr-2"></i>My Reviews
                    </a>
                    <a href="{{ route('payments.received') }}" class="w-full bg-secondary-dark hover:bg-card-dark text-text-primary px-4 py-3 rounded-lg font-medium transition-colors border border-border-custom block text-center">
                        <i class="fas fa-credit-card mr-2"></i>Received Payments
                    </a>
                </div>
            </div>

            <!-- Recent Messages -->
            <div class="bg-card-dark border border-border-custom rounded-xl p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-semibold">Recent Messages</h2>
                    <a href="{{ route('inbox.index') }}" class="text-accent-green hover:text-accent-green-hover text-sm">View All</a>
                </div>
                <div class="space-y-4">
                    @forelse ($recentMessages as $conversation)
                        @php
                            $otherUser = $conversation->user_one == Auth::id() ? $conversation->userTwo : $conversation->userOne;
                            $latestMessage = $conversation->messages->first();
                        @endphp
                        <div class="flex items-center space-x-3 p-3 rounded-lg hover:bg-secondary-dark transition-colors">
                            <div class="w-10 h-10 rounded-full overflow-hidden">
                                @if($otherUser->avatar_url)
                                    <img src="{{ $otherUser->avatar_url }}" alt="{{ $otherUser->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-accent-green flex items-center justify-center text-white font-bold text-lg">
                                        {{ $otherUser->initial }}
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <p class="font-medium text-sm">{{ $otherUser->name }}</p>
                                <p class="text-text-secondary text-xs">{{ Str::limit($latestMessage->body ?? 'No messages yet', 30) }}</p>
                            </div>
                            <div class="text-xs text-text-muted">{{ $latestMessage ? $latestMessage->created_at->diffForHumans() : '' }}</div>
                        </div>
                    @empty
                        <div class="text-center text-text-secondary py-4">
                            <p class="text-sm">No recent messages</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Upcoming Deadlines -->
            <div class="bg-card-dark border border-border-custom rounded-xl p-6">
                <h2 class="text-xl font-semibold mb-6">Upcoming Deadlines</h2>
                <div class="space-y-4">
                    @forelse ($upcomingDeadlines as $project)
                        @php
                            $daysLeft = now()->diffInDays($project->deadline, false);
                            $colorClass = $daysLeft <= 3 ? 'bg-red-500' : ($daysLeft <= 7 ? 'bg-yellow-400' : 'bg-green-500');
                            $bgClass = $daysLeft <= 3 ? 'bg-red-500/10 border-red-500/20' : ($daysLeft <= 7 ? 'bg-yellow-400/10 border-yellow-400/20' : 'bg-green-500/10 border-green-500/20');
                        @endphp
                        <div class="flex items-center space-x-3 p-3 rounded-lg {{ $bgClass }}">
                            <div class="w-3 h-3 {{ $colorClass }} rounded-full"></div>
                            <div class="flex-1">
                                <p class="font-medium text-sm">{{ $project->title }}</p>
                                <p class="text-text-secondary text-xs">Due in {{ $daysLeft }} days</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-text-secondary py-4">
                            <p class="text-sm">No upcoming deadlines</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
