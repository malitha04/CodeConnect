@extends('layouts.dashboard')

@section('title', 'My Proposals')

@section('content')
    <div class="max-w-7xl mx-auto">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-text-primary">My Submitted Proposals</h1>
        </div>

        @if (session('status'))
            <div class="mb-4 p-4 bg-green-600 text-white rounded-lg">
                {{ session('status') }}
            </div>
        @endif

        @if ($proposals->isEmpty())
            <div class="bg-card-dark border border-border-custom rounded-xl p-8 text-center">
                <i class="fas fa-file-alt text-4xl text-text-muted mb-4"></i>
                <p class="text-text-secondary text-lg">You have not submitted any proposals yet.</p>
                <p class="text-text-muted mt-2">Start browsing projects to submit your first proposal!</p>
                <a href="{{ route('projects.browse') }}" class="inline-block mt-4 bg-accent-green hover:bg-accent-green-hover text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300">
                    Browse Projects
                </a>
            </div>
        @else
            <div class="space-y-6">
                @foreach ($proposals as $proposal)
                    <div class="bg-card-dark border border-border-custom rounded-xl p-6 shadow-lg">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-xl font-bold text-text-primary mb-2">
                                    {{ $proposal->project->title }}
                                </h3>
                                <p class="text-text-secondary text-sm">
                                    Posted by: <span class="text-accent-green">{{ $proposal->project->user->name }}</span>
                                </p>
                            </div>
                            <div class="text-right">
                                <div class="text-sm font-semibold mb-2">
                                    Status:
                                    @if($proposal->status === 'accepted')
                                        <span class="text-green-500 bg-green-500/20 px-3 py-1 rounded-full text-xs">Accepted</span>
                                    @elseif($proposal->status === 'rejected')
                                        <span class="text-red-500 bg-red-500/20 px-3 py-1 rounded-full text-xs">Rejected</span>
                                    @else
                                        <span class="text-yellow-500 bg-yellow-500/20 px-3 py-1 rounded-full text-xs">Pending</span>
                                    @endif
                                </div>
                                <div class="text-text-muted text-sm">
                                    Submitted: {{ $proposal->created_at->format('M d, Y') }}
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <p class="text-text-secondary leading-relaxed">
                                {{ Str::limit($proposal->cover_letter, 300) }}
                            </p>
                        </div>
                        
                        <div class="flex justify-between items-center pt-4 border-t border-border-custom">
                            <div class="text-text-secondary">
                                <span class="font-semibold text-text-primary">Proposed Budget:</span>
                                <span class="text-accent-green text-lg font-bold">${{ number_format($proposal->bid_amount, 2) }}</span>
                            </div>
                            <div class="flex space-x-3">
                                <a href="{{ route('projects.show', $proposal->project) }}" class="text-accent-green hover:text-accent-green-hover text-sm font-medium">
                                    View Project
                                </a>
                                @if($proposal->status === 'accepted')
                                    <a href="{{ route('deliveries.create', $proposal->project) }}" class="text-blue-500 hover:text-blue-400 text-sm font-medium">
                                        <i class="fas fa-upload mr-1"></i>Upload Delivery
                                    </a>
                                @endif
                                <form action="{{ route('inbox.start') }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ $proposal->project->user_id }}">
                                    <button type="submit" class="text-blue-500 hover:text-blue-400 text-sm font-medium">
                                        <i class="fas fa-envelope mr-1"></i>Message Client
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if ($proposals->hasPages())
                <div class="mt-8">
                    {{ $proposals->links() }}
                </div>
            @endif
        @endif
    </div>
@endsection
