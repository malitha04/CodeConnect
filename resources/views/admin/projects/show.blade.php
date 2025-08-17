@extends('layouts.admin')

@section('content')
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-3xl font-bold">Project Details</h1>
                <div class="flex items-center space-x-4">
                    <form method="POST" action="{{ route('admin.projects.delete', $project) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this project? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 font-medium transition-colors rounded-lg bg-accent-red hover:bg-red-600 text-text-primary">
                            <i class="mr-2 fas fa-trash-alt"></i>Delete Project
                        </button>
                    </form>
                    <a href="{{ route('admin.projects.index') }}" class="px-4 py-2 font-medium transition-colors rounded-lg bg-secondary-dark hover:bg-card-dark text-text-primary">
                        <i class="mr-2 fas fa-arrow-left"></i>Back to Projects
                    </a>
                </div>
            </div>

            <!-- Project Information -->
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                <!-- Project Details -->
                <div class="lg:col-span-2">
                    <div class="p-6 border bg-card-dark border-border-custom rounded-xl">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <h2 class="text-2xl font-bold">{{ $project->title }}</h2>
                                <p class="text-text-secondary">Posted by {{ $project->user->name }}</p>
                            </div>
                            <div class="text-right">
                                @switch($project->status)
                                    @case('open')
                                        <span class="px-3 py-1 text-sm font-medium rounded-full bg-accent-blue/20 text-accent-blue">Open</span>
                                        @break
                                    @case('in_progress')
                                        <span class="px-3 py-1 text-sm font-medium rounded-full bg-accent-green/20 text-accent-green">In Progress</span>
                                        @break
                                    @case('review')
                                        <span class="px-3 py-1 text-sm font-medium rounded-full bg-accent-orange/20 text-accent-orange">Review</span>
                                        @break
                                    @case('completed')
                                        <span class="px-3 py-1 text-sm font-medium rounded-full bg-green-500/20 text-green-500">Completed</span>
                                        @break
                                    @case('cancelled')
                                        <span class="px-3 py-1 text-sm font-medium rounded-full bg-accent-red/20 text-accent-red">Cancelled</span>
                                        @break
                                    @default
                                        <span class="px-3 py-1 text-sm font-medium rounded-full bg-gray-500/20 text-gray-500">{{ ucfirst(str_replace('_', ' ', $project->status)) }}</span>
                                @endswitch
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-4 mb-6 md:grid-cols-3">
                            <div class="p-4 border border-border-custom rounded-lg bg-secondary-dark">
                                <p class="text-sm text-text-secondary">Budget</p>
                                <p class="text-xl font-bold text-accent-green">${{ number_format($project->budget, 2) }}</p>
                            </div>
                            <div class="p-4 border border-border-custom rounded-lg bg-secondary-dark">
                                <p class="text-sm text-text-secondary">Proposals</p>
                                <p class="text-xl font-bold text-accent-blue">{{ $project->proposals->count() }}</p>
                            </div>
                            <div class="p-4 border border-border-custom rounded-lg bg-secondary-dark">
                                <p class="text-sm text-text-secondary">Posted</p>
                                <p class="text-lg font-bold text-text-primary">{{ $project->created_at->format('M j, Y') }}</p>
                            </div>
                        </div>

                        <div class="mb-6">
                            <h3 class="mb-3 text-lg font-semibold">Description</h3>
                            <p class="text-text-secondary leading-relaxed">{{ $project->description }}</p>
                        </div>

                        @if($project->deadline)
                            <div class="mb-6">
                                <h3 class="mb-3 text-lg font-semibold">Deadline</h3>
                                <p class="text-text-secondary">{{ $project->deadline->format('F j, Y') }}</p>
                            </div>
                        @endif

                        @if($project->requirements)
                            <div class="mb-6">
                                <h3 class="mb-3 text-lg font-semibold">Requirements</h3>
                                <p class="text-text-secondary leading-relaxed">{{ $project->requirements }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Project Statistics -->
                <div class="lg:col-span-1">
                    <div class="p-6 border bg-card-dark border-border-custom rounded-xl">
                        <h3 class="mb-4 text-xl font-semibold">Project Statistics</h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-text-secondary">Total Proposals</span>
                                <span class="font-bold text-accent-blue">{{ $project->proposals->count() }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-text-secondary">Accepted Proposals</span>
                                <span class="font-bold text-accent-green">{{ $project->proposals->where('status', 'accepted')->count() }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-text-secondary">Reviews</span>
                                <span class="font-bold text-accent-orange">{{ $project->reviews->count() }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-text-secondary">Payments</span>
                                <span class="font-bold text-accent-green">{{ $project->payments->count() }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Client Information -->
                    <div class="p-6 mt-6 border bg-card-dark border-border-custom rounded-xl">
                        <h3 class="mb-4 text-xl font-semibold">Client Information</h3>
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 mr-4 overflow-hidden border-2 border-accent-green rounded-full">
                                <img src="https://placehold.co/48x48/1dbf73/ffffff?text={{ strtoupper(substr($project->user->name, 0, 1)) }}" class="w-full h-full object-cover" alt="{{ $project->user->name }}">
                            </div>
                            <div>
                                <p class="font-medium">{{ $project->user->name }}</p>
                                <p class="text-sm text-text-secondary">{{ $project->user->email }}</p>
                            </div>
                        </div>
                        <a href="{{ route('admin.users.show', $project->user) }}" class="block w-full px-4 py-2 text-center transition-colors rounded-lg bg-secondary-dark hover:bg-card-dark text-text-primary">
                            View Client Profile
                        </a>
                    </div>
                </div>
            </div>

            <!-- Proposals Section -->
            @if($project->proposals->count() > 0)
                <div class="mt-6">
                    <h3 class="mb-4 text-xl font-semibold">Project Proposals</h3>
                    <div class="overflow-x-auto border bg-card-dark border-border-custom rounded-xl">
                        <table class="w-full text-left whitespace-nowrap">
                            <thead class="bg-secondary-dark">
                                <tr>
                                    <th class="p-4 text-text-muted">Developer</th>
                                    <th class="p-4 text-text-muted">Proposal Amount</th>
                                    <th class="p-4 text-text-muted">Status</th>
                                    <th class="p-4 text-text-muted">Submitted</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($project->proposals as $proposal)
                                    <tr class="border-b border-border-custom">
                                        <td class="p-4">
                                            <div class="flex items-center">
                                                <div class="w-8 h-8 mr-3 overflow-hidden border border-border-custom rounded-full">
                                                    <img src="{{ $proposal->user->avatar_url }}" class="w-full h-full object-cover" alt="{{ $proposal->user->name }}">
                                                </div>
                                                <div>
                                                    <p class="font-medium">{{ $proposal->user->name }}</p>
                                                    <p class="text-sm text-text-secondary">{{ $proposal->user->email }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="p-4 text-text-secondary">${{ number_format($proposal->amount, 2) }}</td>
                                        <td class="p-4">
                                            @switch($proposal->status)
                                                @case('pending')
                                                    <span class="px-2 py-1 text-sm font-medium rounded-full bg-yellow-500/20 text-yellow-500">Pending</span>
                                                    @break
                                                @case('accepted')
                                                    <span class="px-2 py-1 text-sm font-medium rounded-full bg-accent-green/20 text-accent-green">Accepted</span>
                                                    @break
                                                @case('rejected')
                                                    <span class="px-2 py-1 text-sm font-medium rounded-full bg-accent-red/20 text-accent-red">Rejected</span>
                                                    @break
                                                @default
                                                    <span class="px-2 py-1 text-sm font-medium rounded-full bg-gray-500/20 text-gray-500">{{ ucfirst($proposal->status) }}</span>
                                            @endswitch
                                        </td>
                                        <td class="p-4 text-text-secondary">{{ $proposal->created_at->format('Y-m-d') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            <!-- Reviews Section -->
            @if($project->reviews->count() > 0)
                <div class="mt-6">
                    <h3 class="mb-4 text-xl font-semibold">Project Reviews</h3>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        @foreach($project->reviews as $review)
                            <div class="p-4 border bg-card-dark border-border-custom rounded-xl">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 mr-3 overflow-hidden border border-border-custom rounded-full">
                                            <img src="{{ $review->client->avatar_url }}" class="w-full h-full object-cover" alt="{{ $review->client->name }}">
                                        </div>
                                        <div>
                                            <p class="font-medium">{{ $review->client->name }}</p>
                                            <p class="text-sm text-text-secondary">{{ $review->created_at->format('M j, Y') }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-500' }}"></i>
                                        @endfor
                                    </div>
                                </div>
                                <p class="text-text-secondary">{{ $review->comment }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
@endsection
