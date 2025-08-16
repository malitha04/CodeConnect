@extends('layouts.dashboard')

@section('title', 'My Projects')

@section('content')
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex justify-between items-center mb-8 pb-6 border-b border-border-custom">
            <h1 class="text-4xl font-extrabold text-text-primary">My Projects</h1>
            <a href="{{ route('projects.create') }}" class="bg-accent-green hover:bg-accent-green-hover text-white font-medium px-6 py-3 rounded-lg transition-colors flex items-center">
                <i class="fas fa-plus-circle mr-2"></i>Post a New Project
            </a>
        </div>

        @if ($projects->isEmpty())
            <div class="bg-card-dark border border-border-custom rounded-xl p-6 text-center">
                <p class="text-text-secondary text-xl">You haven't posted any projects yet.</p>
                <p class="text-text-muted mt-2">Get started by posting your first project!</p>
            </div>
        @else
            <div class="grid grid-cols-1 gap-6">
                @foreach ($projects as $project)
                    <div class="bg-card-dark border border-border-custom rounded-xl shadow-lg p-6">
                        <div class="flex flex-col md:flex-row justify-between md:items-center">
                            <div class="mb-4 md:mb-0">
                                <h3 class="text-2xl font-semibold text-accent-green mb-1">{{ $project->title }}</h3>
                                <p class="text-text-secondary text-sm">Posted on: {{ $project->created_at->format('M d, Y') }}</p>
                            </div>
                            <div class="flex flex-col space-y-2">
                                <span class="bg-accent-orange text-white text-xs font-semibold px-2.5 py-1 rounded-full">
                                    Budget: ${{ number_format((float) $project->budget) }}
                                </span>
                                <span class="bg-secondary-dark text-text-primary text-xs font-semibold px-2.5 py-1 rounded-full">
                                    Deadline: 
                                    @if ($project->deadline)
                                        {{ $project->deadline->format('M d, Y') }}
                                    @else
                                        N/A
                                    @endif
                                </span>
                            </div>
                        </div>
                        <div class="mt-4 text-text-secondary text-base leading-relaxed">
                            <p>{{ Str::limit($project->description, 150) }}</p>
                        </div>
                        <div class="mt-6 flex justify-end space-x-2">
                            {{-- View Proposals Button --}}
                            <a href="{{ route('projects.proposals.index', $project) }}" class="bg-accent-green hover:bg-accent-green-hover text-white font-medium px-5 py-2 rounded-lg transition-colors flex items-center justify-center min-w-[150px]"> {{-- Added justify-center and min-w --}}
                                <i class="fas fa-search-plus mr-2 text-lg"></i>
                                View Proposals
                            </a>
                            {{-- Edit Button --}}
                            <a href="{{ route('projects.edit', $project) }}" class="bg-accent-green hover:bg-accent-green-hover text-white font-medium px-5 py-2 rounded-lg transition-colors flex items-center justify-center min-w-[150px]"> {{-- Added justify-center and min-w --}}
                                <i class="fas fa-edit mr-2 text-lg"></i> {{-- Added text-lg for consistent icon size --}}
                                Edit
                            </a>
                            {{-- Delete Button --}}
                            <form action="{{ route('projects.destroy', $project) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this project?');" class="flex items-center">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-medium px-5 py-2 rounded-lg transition-colors flex items-center justify-center min-w-[150px]"> {{-- Added justify-center and min-w --}}
                                    <i class="fas fa-trash-alt mr-2 text-lg"></i> {{-- Added text-lg for consistent icon size --}}
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination Links --}}
            <div class="mt-8">
                {{ $projects->links() }}
            </div>
        @endif
    </div>
@endsection
