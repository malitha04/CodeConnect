@extends('layouts.dashboard')

@section('title', 'My Projects')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">My Projects</h1>
        <a href="{{ route('projects.create') }}" class="bg-accent-green hover:bg-accent-green-hover text-white font-medium px-5 py-2 rounded-lg transition">
            <i class="fas fa-plus mr-2"></i>New Project
        </a>
    </div>

    <!-- Project List -->
    <div class="space-y-6">

        @forelse ($projects as $project)
            <div class="bg-card-dark border border-border-custom rounded-xl p-6 hover:border-accent-green transition-colors">
                <div class="flex flex-col sm:flex-row justify-between items-start">
                    <div class="flex-1">
                        <h2 class="text-xl font-semibold mb-1">{{ $project->title }}</h2>
                        <p class="text-text-secondary text-sm mb-2">{{ Str::limit($project->description, 150) }}</p>
                        <div class="flex items-center text-sm text-text-muted flex-wrap gap-x-4 gap-y-2">
                            <span><i class="fas fa-layer-group mr-1"></i> {{ $project->category }}</span>
                            <span><i class="fas fa-dollar-sign mr-1"></i> {{ $project->budget }}</span>
                            <span><i class="fas fa-calendar-alt mr-1"></i> Posted: {{ $project->created_at->format('M d, Y') }}</span>
                            
                            @if($project->status == 'open')
                                <span class="bg-yellow-500/20 text-yellow-500 px-2 py-1 rounded-full text-xs capitalize">{{ $project->status }}</span>
                            @elseif($project->status == 'in-progress')
                                <span class="bg-green-500/20 text-green-400 px-2 py-1 rounded-full text-xs capitalize">{{ $project->status }}</span>
                            @else
                                <span class="bg-gray-500/20 text-gray-400 px-2 py-1 rounded-full text-xs capitalize">{{ $project->status }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="flex flex-col items-end gap-2 text-sm mt-4 sm:mt-0 sm:ml-4">
                        <span class="text-text-muted">0 Proposals</span> {{-- This will be dynamic later --}}
                        <div class="flex space-x-2 mt-2">
                            <a href="{{ route('projects.show', $project) }}" class="px-3 py-1 bg-secondary-dark border border-border-custom rounded hover:bg-card-dark text-text-primary">
                                <i class="fas fa-eye mr-1"></i>View
                            </a>
                            <a href="{{ route('projects.edit', $project) }}" class="px-3 py-1 bg-secondary-dark border border-border-custom rounded hover:bg-card-dark text-text-primary">
                                <i class="fas fa-edit mr-1"></i>Edit
                            </a>
                            <form action="{{ route('projects.destroy', $project) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this project?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1 bg-red-500/10 text-red-400 border border-red-500/30 rounded hover:bg-red-500/20">
                                    <i class="fas fa-trash mr-1"></i>Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-card-dark border border-border-custom rounded-xl p-8 text-center">
                <h2 class="text-xl font-semibold">No Projects Found</h2>
                <p class="text-text-secondary mt-2">You haven't posted any projects yet. Get started by posting one now!</p>
                <a href="{{ route('projects.create') }}" class="mt-4 inline-block bg-accent-green hover:bg-accent-green-hover text-white font-medium px-5 py-2 rounded-lg transition">
                    Post Your First Project
                </a>
            </div>
        @endforelse

    </div>
    
    {{-- Pagination Links --}}
    <div class="mt-8">
        {{ $projects->links() }}
    </div>
@endsection
