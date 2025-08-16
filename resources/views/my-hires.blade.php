@extends('layouts.dashboard')

@section('title', 'My Hires')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold text-text-primary mb-6">My Hires</h1>

        @if (session('status'))
            <div class="mb-6 p-4 bg-green-600/20 border border-green-500/50 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                    <p class="text-green-500">{{ session('status') }}</p>
                </div>
            </div>
        @endif

        @if ($hires->isEmpty())
            <div class="bg-card-dark border border-border-custom rounded-xl p-6 text-center">
                <p class="text-text-secondary text-xl">You don't have any active hires yet.</p>
                <p class="text-text-muted mt-2">When you accept a proposal, it will appear here.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($hires as $hire)
                    <div class="bg-card-dark border border-border-custom rounded-xl p-6 shadow-lg hover:shadow-2xl transition-shadow duration-300 ease-in-out">
                        <!-- Project Header -->
                        <div class="flex items-center space-x-4 mb-4">
                            <div class="w-12 h-12 bg-accent-green/20 rounded-full flex items-center justify-center">
                                <i class="fas fa-project-diagram text-accent-green text-lg"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold text-text-primary">{{ $hire->project_title }}</h3>
                                <p class="text-text-secondary text-sm">Hired: {{ $hire->proposal_accepted_at->format('M d, Y') }}</p>
                            </div>
                        </div>

                        <!-- Project Details -->
                        <div class="space-y-3 mb-4">
                            <div class="flex justify-between items-center">
                                <p class="text-text-secondary text-sm">Developer:</p>
                                <p class="font-medium text-text-primary">{{ $hire->developer_name }}</p>
                            </div>

                            <div class="flex justify-between items-center">
                                <p class="text-text-secondary text-sm">Project Budget:</p>
                                <p class="font-medium text-accent-green">${{ number_format($hire->project_budget, 2) }}</p>
                            </div>

                            <div class="flex justify-between items-center">
                                <p class="text-text-secondary text-sm">Accepted Bid:</p>
                                <p class="font-medium text-accent-green">${{ number_format($hire->proposal_bid, 2) }}</p>
                            </div>

                            @if ($hire->project_deadline)
                                <div class="flex justify-between items-center">
                                    <p class="text-text-secondary text-sm">Deadline:</p>
                                    <p class="font-medium text-sm">{{ \Carbon\Carbon::parse($hire->project_deadline)->format('M d, Y') }}</p>
                                </div>
                            @endif
                        </div>

                        <!-- Project Status -->
                        <div class="mb-4">
                            <div class="flex justify-between items-center">
                                <p class="text-text-secondary text-sm">Project Status:</p>
                                @php
                                    $statusColor = '';
                                    $statusText = '';
                                    switch ($hire->project_status) {
                                        case 'in-progress':
                                            $statusColor = 'bg-yellow-500/20 text-yellow-500';
                                            $statusText = 'In Progress';
                                            break;
                                        case 'completed':
                                            $statusColor = 'bg-green-500/20 text-green-500';
                                            $statusText = 'Completed';
                                            break;
                                        default:
                                            $statusColor = 'bg-gray-500/20 text-gray-400';
                                            $statusText = ucfirst($hire->project_status);
                                            break;
                                    }
                                @endphp
                                <span class="{{ $statusColor }} px-3 py-1 rounded-full text-xs font-semibold capitalize">
                                    {{ $statusText }}
                                </span>
                            </div>
                        </div>

                        <!-- Deliveries Section -->
                        @php
                            $project = \App\Models\Project::find($hire->project_id);
                            $deliveries = $project ? $project->deliveries : collect();
                        @endphp
                        @if($deliveries->count() > 0)
                            <div class="mb-4 p-3 bg-accent-green/10 border border-accent-green/20 rounded-lg">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm font-medium text-accent-green">
                                        <i class="fas fa-box mr-1"></i>{{ $deliveries->count() }} Delivery{{ $deliveries->count() > 1 ? 'ies' : 'y' }} Submitted
                                    </span>
                                </div>
                                <div class="flex space-x-2">
                                    <a href="{{ route('deliveries.show', $deliveries->first()) }}" class="text-xs bg-accent-green hover:bg-accent-green-hover text-white px-3 py-1 rounded">
                                        <i class="fas fa-eye mr-1"></i>View Latest
                                    </a>
                                    @if($deliveries->first()->delivery_type === 'file')
                                        <a href="{{ route('deliveries.download', $deliveries->first()) }}" class="text-xs bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded">
                                            <i class="fas fa-download mr-1"></i>Download
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <!-- Action Buttons -->
                        <div class="flex flex-col space-y-2 pt-4 border-t border-border-custom">
                            @if ($hire->project_status === 'in-progress')
                                <form action="{{ route('hires.markAsCompleted', ['project' => $hire->project_id]) }}" method="POST" class="w-full">
                                    @csrf
                                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                                        <i class="fas fa-check mr-2"></i>Mark as Completed
                                    </button>
                                </form>
                            @elseif ($hire->project_status === 'completed')
                                @php
                                    $existingReview = $project ? $project->reviewByClient(Auth::id()) : null;
                                    $hasPayment = $project ? $project->payment : null;
                                @endphp
                                
                                @if(!$hasPayment)
                                    <a href="{{ route('payments.create', ['project' => $hire->project_id]) }}" class="w-full bg-accent-green hover:bg-accent-green-hover text-white px-4 py-2 rounded-lg font-medium transition-colors text-center mb-2">
                                        <i class="fas fa-credit-card mr-2"></i>Make Payment
                                    </a>
                                @else
                                    <a href="{{ route('payments.show', $hasPayment) }}" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors text-center mb-2">
                                        <i class="fas fa-eye mr-2"></i>View Payment
                                    </a>
                                @endif
                                
                                @if($existingReview)
                                    <a href="{{ route('reviews.edit', $existingReview) }}" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors text-center">
                                        <i class="fas fa-edit mr-2"></i>Edit Review
                                    </a>
                                @else
                                    <a href="{{ route('reviews.create', ['project' => $hire->project_id]) }}" class="w-full bg-accent-green hover:bg-accent-green-hover text-white px-4 py-2 rounded-lg font-medium transition-colors text-center">
                                        <i class="fas fa-star mr-2"></i>Leave a Review
                                    </a>
                                @endif
                            @endif
                            
                            <div class="flex space-x-2">
                                <a href="{{ route('projects.show', $hire->project_id) }}" class="flex-1 bg-secondary-dark hover:bg-card-dark text-text-primary px-4 py-2 rounded-lg font-medium transition-colors border border-border-custom text-center">
                                    <i class="fas fa-eye mr-2"></i>View Project
                                </a>

                                <form action="{{ route('inbox.start') }}" method="POST" class="flex-1">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ $hire->developer_id }}">
                                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                                        <i class="fas fa-envelope mr-2"></i>Message
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
