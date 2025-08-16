@extends('layouts.dashboard')

@section('title', 'Proposals for ' . $project->title)

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-text-primary">Proposals for: {{ $project->title }}</h1>
            <a href="{{ route('projects.index') }}" class="btn-secondary">
                <i class="fas fa-arrow-left mr-2"></i>Back to My Projects
            </a>
        </div>

        @if ($project->proposals->isEmpty())
            <div class="bg-card-dark border border-border-custom rounded-xl p-6 text-center">
                <p class="text-text-secondary text-lg">No proposals have been submitted for this project yet.</p>
                <p class="text-text-muted mt-2">Check back later or share the project with your network!</p>
            </div>
        @else
            <div class="space-y-6">
                @foreach ($project->proposals as $proposal)
                    <div class="bg-card-dark border border-border-custom rounded-xl shadow-lg p-6">
                        <div class="flex items-center justify-between mb-4">
                            {{-- CORRECTED: The relationship is 'user', not 'developer'. --}}
                            <h3 class="text-xl font-semibold text-text-primary">{{ $proposal->user ? $proposal->user->name : 'N/A' }}</h3>
                            <span class="py-1 px-3 rounded-full text-xs font-semibold
                                @if ($proposal->status === 'accepted') bg-green-500/20 text-green-400
                                @elseif ($proposal->status === 'rejected') bg-red-500/20 text-red-400
                                @else bg-yellow-500/20 text-yellow-400 @endif">
                                {{ ucfirst($proposal->status) }}
                            </span>
                        </div>
                        <p class="text-text-secondary mb-4">{{ $proposal->message }}</p>
                        <p class="text-sm font-medium text-text-muted">Proposed Budget: ${{ number_format($proposal->budget, 0) }}</p>

                        {{-- Show action buttons only if the proposal is pending and the project is open --}}
                        @if ($proposal->status === 'pending' && $project->status === 'open')
                            <div class="flex space-x-4 mt-6">
                                <form action="{{ route('proposals.accept', ['project' => $project->id, 'proposal' => $proposal->id]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-primary">Accept Proposal</button>
                                </form>
                                <form action="{{ route('proposals.reject', ['project' => $project->id, 'proposal' => $proposal->id]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-danger">Reject</button>
                                </form>
                            </div>
                        @elseif ($proposal->status === 'accepted' && $project->status === 'in_progress')
                            <div class="mt-6 text-green-500 font-semibold">
                                This proposal has been accepted. Project is in progress.
                            </div>
                        @elseif ($proposal->status === 'accepted' && $project->status === 'completed')
                            <div class="mt-6 text-green-500 font-semibold">
                                This proposal was accepted. Project is completed.
                            </div>
                        @elseif ($project->status !== 'open')
                            <div class="mt-6 text-red-500 font-semibold">
                                This project is no longer open for new proposals.
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection