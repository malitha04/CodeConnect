@extends('layouts.dashboard')

@section('title', 'Proposals for ' . $project->title)

@section('content')
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8 pb-6 border-b border-border-custom">
            <div>
                <h1 class="text-4xl font-extrabold text-text-primary">Proposals for {{ $project->title }}</h1>
                <p class="text-text-secondary mt-2">Review and manage developer proposals for your project</p>
            </div>
            <a href="{{ route('projects.index') }}" class="text-text-secondary hover:text-text-primary">&larr; Back to Projects</a>
        </div>

        <!-- Project Details Card -->
        <div class="bg-card-dark border border-border-custom rounded-xl p-6 mb-8">
            <h3 class="text-xl font-semibold text-text-primary mb-4">Project Details</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-text-secondary"><span class="font-medium text-text-primary">Title:</span> {{ $project->title }}</p>
                    <p class="text-text-secondary"><span class="font-medium text-text-primary">Status:</span> 
                        <span class="capitalize px-2 py-1 text-xs font-semibold rounded-full
                            @if($project->status === 'open') bg-green-500/20 text-green-500
                            @elseif($project->status === 'in-progress') bg-blue-500/20 text-blue-500
                            @else bg-gray-500/20 text-gray-500
                            @endif">
                            {{ $project->status }}
                        </span>
                    </p>
                </div>
                <div>
                    <p class="text-text-secondary"><span class="font-medium text-text-primary">Budget:</span> ${{ number_format($project->budget, 2) }}</p>
                    <p class="text-text-secondary"><span class="font-medium text-text-primary">Deadline:</span> 
                        @if($project->deadline)
                            {{ $project->deadline->format('M d, Y') }}
                        @else
                            N/A
                        @endif
                    </p>
                </div>
            </div>
            <div class="mt-4">
                <p class="text-text-secondary"><span class="font-medium text-text-primary">Description:</span></p>
                <p class="text-text-secondary mt-2">{{ $project->description }}</p>
            </div>
        </div>

        <!-- Proposals Section -->
        <div class="bg-card-dark border border-border-custom rounded-xl p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-semibold text-text-primary">Proposals ({{ $proposals->count() }})</h3>
                @if($project->status === 'open')
                    <span class="text-accent-green text-sm font-medium">Project is open for proposals</span>
                @else
                    <span class="text-text-muted text-sm">Project is no longer accepting proposals</span>
                @endif
            </div>

            @if($proposals->count() > 0)
                <div class="space-y-6">
                    @foreach($proposals as $proposal)
                        <div class="bg-secondary-dark border border-border-custom rounded-lg p-6">
                            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4">
                                <div class="mb-4 md:mb-0">
                                    <h4 class="text-xl font-semibold text-text-primary mb-2">
                                        Proposal by {{ $proposal->user->name }}
                                    </h4>
                                    <p class="text-text-secondary text-sm">
                                        Submitted on {{ $proposal->created_at->format('M d, Y') }}
                                    </p>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <span class="px-3 py-1 text-sm font-semibold rounded-full
                                        @if($proposal->status === 'accepted') bg-green-500/20 text-green-500
                                        @elseif($proposal->status === 'rejected') bg-red-500/20 text-red-500
                                        @else bg-yellow-500/20 text-yellow-500
                                        @endif">
                                        {{ ucfirst($proposal->status) }}
                                    </span>
                                    <span class="text-accent-green font-semibold text-lg">
                                        ${{ number_format($proposal->bid_amount, 2) }}
                                    </span>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <h5 class="font-medium text-text-primary mb-2">Cover Letter:</h5>
                                <p class="text-text-secondary leading-relaxed">{{ $proposal->cover_letter }}</p>
                            </div>

                            @if($project->status === 'open' && $proposal->status === 'pending')
                                <div class="flex space-x-3 pt-4 border-t border-border-custom">
                                    <form action="{{ route('proposals.accept', $proposal) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                                            <i class="fas fa-check mr-2"></i>Accept Proposal
                                        </button>
                                    </form>
                                    <form action="{{ route('proposals.reject', $proposal) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                                            <i class="fas fa-times mr-2"></i>Reject Proposal
                                        </button>
                                    </form>
                                </div>
                            @endif

                            {{-- Message button for all proposals --}}
                            <div class="pt-4 border-t border-border-custom">
                                <form action="{{ route('inbox.start') }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ $proposal->user_id }}">
                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                                        <i class="fas fa-envelope mr-2"></i>Message {{ $proposal->user->name }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-file-alt text-4xl text-text-muted mb-4"></i>
                    <p class="text-text-secondary text-xl">No proposals have been submitted for this project yet.</p>
                    <p class="text-text-muted mt-2">Developers will be able to submit proposals once they discover your project.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
