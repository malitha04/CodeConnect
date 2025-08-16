@extends('layouts.dashboard')

@section('title', 'Client Dashboard')

@section('content')
    <!-- Header -->
    <section class="mb-8">
        <h1 class="text-3xl font-bold">Welcome back, {{ Auth::user()->name }}!</h1>
        <p class="text-text-secondary mt-2">Here's a summary of your recent activity.</p>
    </section>

    <!-- Stats Cards -->
    <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-card-dark border border-border-custom rounded-xl p-6">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-text-secondary text-sm">Total Projects</p>
                    <p class="text-2xl font-bold text-accent-green">{{ $myProjectsCount }}</p>
                </div>
                <div class="w-12 h-12 bg-accent-green/20 rounded-full flex items-center justify-center">
                    <i class="fas fa-folder-open text-accent-green"></i>
                </div>
            </div>
        </div>
        <div class="bg-card-dark border border-border-custom rounded-xl p-6">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-text-secondary text-sm">Open Projects</p>
                    <p class="text-2xl font-bold text-blue-500">{{ $openProjectsCount }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-500/20 rounded-full flex items-center justify-center">
                    <i class="fas fa-clock text-blue-500"></i>
                </div>
            </div>
        </div>
        <div class="bg-card-dark border border-border-custom rounded-xl p-6">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-text-secondary text-sm">Active Hires</p>
                    <p class="text-2xl font-bold text-orange-500">{{ $inProgressHires }}</p>
                </div>
                <div class="w-12 h-12 bg-orange-500/20 rounded-full flex items-center justify-center">
                    <i class="fas fa-user-tie text-orange-500"></i>
                </div>
            </div>
        </div>
        <div class="bg-card-dark border border-border-custom rounded-xl p-6">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-text-secondary text-sm">This Month Spent</p>
                    <p class="text-2xl font-bold text-purple-500">${{ number_format($thisMonthSpending, 2) }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-500/20 rounded-full flex items-center justify-center">
                    <i class="fas fa-dollar-sign text-purple-500"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content Grid -->
    <section class="grid lg:grid-cols-3 gap-8">
        <!-- Left Column -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Recent Projects -->
            <div class="bg-card-dark border border-border-custom rounded-xl p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold">Recent Projects</h2>
                    <a href="{{ route('projects.index') }}" class="text-accent-green hover:text-accent-green-hover text-sm">View All</a>
                </div>
                <div class="space-y-4">
                    @forelse ($projects as $project)
                        <div class="border border-border-custom rounded-lg p-4 hover:border-accent-green transition-colors">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h3 class="font-semibold mb-2">{{ $project->title }}</h3>
                                    <p class="text-text-secondary text-sm mb-3">{{ Str::limit($project->description, 120) }}</p>
                                    <div class="flex items-center text-sm text-text-muted">
                                        <span class="mr-4"><i class="fas fa-calendar mr-1"></i>Posted {{ $project->created_at->format('M d, Y') }}</span>
                                        <span class="mr-4"><i class="fas fa-dollar-sign mr-1"></i>${{ number_format($project->budget, 2) }}</span>
                                        @switch($project->status)
                                            @case('open')
                                                <span class="bg-blue-500/20 text-blue-500 px-2 py-1 rounded-full text-xs">Open</span>
                                                @break
                                            @case('in_progress')
                                                <span class="bg-orange-500/20 text-orange-500 px-2 py-1 rounded-full text-xs">In Progress</span>
                                                @break
                                            @case('review')
                                                <span class="bg-yellow-500/20 text-yellow-500 px-2 py-1 rounded-full text-xs">Review</span>
                                                @break
                                            @case('completed')
                                                <span class="bg-green-500/20 text-green-500 px-2 py-1 rounded-full text-xs">Completed</span>
                                                @break
                                            @default
                                                <span class="bg-gray-500/20 text-gray-500 px-2 py-1 rounded-full text-xs">{{ ucfirst(str_replace('_', ' ', $project->status)) }}</span>
                                        @endswitch
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <a href="{{ route('projects.show', $project) }}" class="text-accent-green hover:text-accent-green-hover">
                                        <i class="fas fa-eye text-lg"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-text-secondary py-8">
                            <p>You haven't posted any projects yet.</p>
                            <a href="{{ route('projects.create') }}" class="mt-4 inline-block bg-accent-green hover:bg-accent-green-hover text-white px-4 py-2 rounded-lg font-medium transition-colors">
                                Post Your First Project
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Active Hires -->
            <div class="bg-card-dark border border-border-custom rounded-xl p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold">Active Hires</h2>
                    <a href="{{ route('hires.index') }}" class="text-accent-green hover:text-accent-green-hover text-sm">View All</a>
                </div>
                <div class="space-y-4">
                    @forelse ($activeHires as $project)
                        @php
                            $acceptedProposal = $project->proposals->first();
                            $developer = $acceptedProposal->user;
                            $deliveries = $project->deliveries ?? collect();
                        @endphp
                        <div class="border border-border-custom rounded-lg p-4 hover:border-accent-green transition-colors">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h3 class="font-semibold mb-2">{{ $project->title }}</h3>
                                    <p class="text-text-secondary text-sm mb-3">Developer: {{ $developer->name }}</p>
                                    <div class="flex items-center text-sm text-text-muted mb-3">
                                        <span class="mr-4"><i class="fas fa-calendar mr-1"></i>Due: {{ $project->deadline ? $project->deadline->format('M d, Y') : 'No deadline' }}</span>
                                        <span class="mr-4"><i class="fas fa-dollar-sign mr-1"></i>${{ number_format($acceptedProposal->bid_amount, 2) }}</span>
                                        @switch($project->status)
                                            @case('in_progress')
                                                <span class="bg-orange-500/20 text-orange-500 px-2 py-1 rounded-full text-xs">In Progress</span>
                                                @break
                                            @case('review')
                                                <span class="bg-yellow-500/20 text-yellow-500 px-2 py-1 rounded-full text-xs">Review</span>
                                                @break
                                            @case('completed')
                                                <span class="bg-green-500/20 text-green-500 px-2 py-1 rounded-full text-xs">Completed</span>
                                                @break
                                            @default
                                                <span class="bg-gray-500/20 text-gray-500 px-2 py-1 rounded-full text-xs">{{ ucfirst(str_replace('_', ' ', $project->status)) }}</span>
                                        @endswitch
                                    </div>
                                    @if($deliveries->count() > 0)
                                        <div class="flex items-center space-x-2">
                                            <span class="text-xs text-accent-green bg-accent-green/10 px-2 py-1 rounded">
                                                <i class="fas fa-box mr-1"></i>{{ $deliveries->count() }} Delivery{{ $deliveries->count() > 1 ? 'ies' : 'y' }}
                                            </span>
                                            <a href="{{ route('deliveries.show', $deliveries->first()) }}" class="text-xs text-blue-500 hover:text-blue-400">
                                                <i class="fas fa-eye mr-1"></i>View Latest
                                            </a>
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-4 flex flex-col space-y-2">
                                    <a href="{{ route('projects.show', $project) }}" class="text-accent-green hover:text-accent-green-hover">
                                        <i class="fas fa-eye text-lg"></i>
                                    </a>
                                    @if($deliveries->count() > 0)
                                        <a href="{{ route('deliveries.show', $deliveries->first()) }}" class="text-blue-500 hover:text-blue-400">
                                            <i class="fas fa-download text-lg"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-text-secondary py-8">
                            <p>No active hires yet.</p>
                            <a href="{{ route('projects.create') }}" class="mt-4 inline-block bg-accent-green hover:bg-accent-green-hover text-white px-4 py-2 rounded-lg font-medium transition-colors">
                                Post a Project
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Recent Proposals -->
            <div class="bg-card-dark border border-border-custom rounded-xl p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-semibold">Recent Proposals</h2>
                    <a href="{{ route('projects.index') }}" class="text-accent-green hover:text-accent-green-hover text-sm">View All</a>
                </div>
                <div class="space-y-4">
                    @forelse ($recentProposals as $proposal)
                        <div class="border border-border-custom rounded-lg p-4">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h3 class="font-semibold mb-2">{{ $proposal->project->title }}</h3>
                                    <p class="text-text-secondary text-sm mb-3">Developer: {{ $proposal->user->name }}</p>
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
                                <div class="ml-4">
                                    <a href="{{ route('projects.show', $proposal->project) }}" class="text-accent-green hover:text-accent-green-hover">
                                        <i class="fas fa-eye text-lg"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-text-secondary py-8">
                            <p>No proposals received yet.</p>
                            <a href="{{ route('projects.create') }}" class="mt-4 inline-block bg-accent-green hover:bg-accent-green-hover text-white px-4 py-2 rounded-lg font-medium transition-colors">
                                Post a Project
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
                    <a href="{{ route('projects.create') }}" class="block bg-accent-green hover:bg-accent-green-hover text-white px-4 py-3 rounded-lg font-medium transition-colors text-center">
                        <i class="fas fa-plus mr-2"></i>Post New Project
                    </a>
                    <a href="{{ route('hires.index') }}" class="block bg-secondary-dark hover:bg-card-dark text-text-primary px-4 py-3 rounded-lg font-medium transition-colors border border-border-custom text-center">
                        <i class="fas fa-briefcase mr-2"></i>Manage Hires
                    </a>
                    <a href="{{ route('projects.index') }}" class="block bg-secondary-dark hover:bg-card-dark text-text-primary px-4 py-3 rounded-lg font-medium transition-colors border border-border-custom text-center">
                        <i class="fas fa-folder-open mr-2"></i>View All Projects
                    </a>
                    <a href="{{ route('reviews.my-reviews') }}" class="block bg-secondary-dark hover:bg-card-dark text-text-primary px-4 py-3 rounded-lg font-medium transition-colors border border-border-custom text-center">
                        <i class="fas fa-star mr-2"></i>My Reviews
                    </a>
                    <a href="{{ route('payments.my-payments') }}" class="block bg-secondary-dark hover:bg-card-dark text-text-primary px-4 py-3 rounded-lg font-medium transition-colors border border-border-custom text-center">
                        <i class="fas fa-credit-card mr-2"></i>My Payments
                    </a>
                    @if(isset($recentDeliveries) && $recentDeliveries->count() > 0)
                        <a href="{{ route('deliveries.show', $recentDeliveries->first()) }}" class="block bg-accent-orange hover:bg-orange-600 text-white px-4 py-3 rounded-lg font-medium transition-colors text-center">
                            <i class="fas fa-download mr-2"></i>View Deliveries
                        </a>
                    @endif
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

            <!-- Pending Payments -->
            <div class="bg-card-dark border border-border-custom rounded-xl p-6">
                <h2 class="text-xl font-semibold mb-6">Pending Payments</h2>
                <div class="space-y-4">
                    @forelse ($pendingPayments as $payment)
                        <div class="flex items-center space-x-3 p-3 rounded-lg bg-yellow-500/10 border border-yellow-500/20">
                            <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                            <div class="flex-1">
                                <p class="font-medium text-sm">{{ $payment->project->title }}</p>
                                <p class="text-text-secondary text-xs">${{ number_format($payment->amount, 2) }} to {{ $payment->developer->name }}</p>
                            </div>
                            <a href="{{ route('payments.show', $payment) }}" class="text-accent-green hover:text-accent-green-hover text-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    @empty
                        <div class="text-center text-text-secondary py-4">
                            <p class="text-sm">No pending payments</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Projects Needing Attention -->
            <div class="bg-card-dark border border-border-custom rounded-xl p-6">
                <h2 class="text-xl font-semibold mb-6">Needs Attention</h2>
                <div class="space-y-4">
                    @forelse ($projectsNeedingAttention as $project)
                        @php
                            $proposalCount = $project->proposals->count();
                            $daysUntilDeadline = $project->deadline ? now()->diffInDays($project->deadline, false) : null;
                        @endphp
                        <div class="flex items-center space-x-3 p-3 rounded-lg {{ $daysUntilDeadline && $daysUntilDeadline <= 3 ? 'bg-red-500/10 border-red-500/20' : 'bg-blue-500/10 border-blue-500/20' }}">
                            <div class="w-3 h-3 {{ $daysUntilDeadline && $daysUntilDeadline <= 3 ? 'bg-red-500' : 'bg-blue-500' }} rounded-full"></div>
                            <div class="flex-1">
                                <p class="font-medium text-sm">{{ $project->title }}</p>
                                <p class="text-text-secondary text-xs">
                                    @if($project->status === 'open')
                                        {{ $proposalCount }} new proposal{{ $proposalCount !== 1 ? 's' : '' }}
                                    @elseif($daysUntilDeadline)
                                        Due in {{ $daysUntilDeadline }} days
                                    @endif
                                </p>
                            </div>
                            <a href="{{ route('projects.show', $project) }}" class="text-accent-green hover:text-accent-green-hover text-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    @empty
                        <div class="text-center text-text-secondary py-4">
                            <p class="text-sm">All projects are up to date</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
@endsection
