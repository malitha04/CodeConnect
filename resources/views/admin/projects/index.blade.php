@extends('layouts.admin')

@section('content')
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-3xl font-bold">Manage Projects</h1>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.projects.export') }}" class="px-4 py-2 font-medium transition-colors rounded-lg bg-accent-green hover:bg-accent-green-hover text-white">
                        <i class="mr-2 fas fa-download"></i>Export Projects
                    </a>
                    <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 font-medium transition-colors rounded-lg bg-secondary-dark hover:bg-card-dark text-text-primary">
                        <i class="mr-2 fas fa-arrow-left"></i>Back to Dashboard
                    </a>
                </div>
            </div>

            <!-- Search and Filters -->
            <div class="flex flex-col items-center justify-between p-4 mb-6 border bg-card-dark border-border-custom rounded-xl sm:flex-row">
                <form method="GET" action="{{ route('admin.projects.index') }}" class="flex flex-col w-full gap-4 sm:flex-row sm:items-center">
                    <div class="relative flex-1">
                        <input 
                            type="text" 
                            name="search" 
                            value="{{ request('search') }}"
                            placeholder="Search projects by title or description..." 
                            class="w-full py-2 pl-10 pr-4 border rounded-lg bg-secondary-dark border-border-custom text-text-primary focus:outline-none focus:ring-1 focus:ring-accent-green"
                        >
                        <i class="absolute -translate-y-1/2 fas fa-search left-3 top-1/2 text-text-secondary"></i>
                    </div>
                    <div class="flex items-center gap-4">
                        <select name="status" class="px-3 py-2 border rounded-lg bg-secondary-dark border-border-custom text-text-primary focus:outline-none focus:ring-1 focus:ring-accent-green">
                            <option value="">All Status</option>
                            <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open</option>
                            <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="review" {{ request('status') == 'review' ? 'selected' : '' }}>Review</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        <button type="submit" class="px-4 py-2 font-medium transition-colors rounded-lg bg-accent-green hover:bg-accent-green-hover text-text-primary">
                            <i class="mr-2 fas fa-search"></i>Search
                        </button>
                        <a href="{{ route('admin.projects.index') }}" class="px-4 py-2 font-medium transition-colors rounded-lg bg-secondary-dark hover:bg-card-dark text-text-primary">
                            <i class="mr-2 fas fa-times"></i>Clear
                        </a>
                    </div>
                </form>
            </div>

            <!-- Projects Table -->
            <div class="overflow-x-auto border bg-card-dark border-border-custom rounded-xl">
                <table class="min-w-full text-left whitespace-nowrap">
                    <thead class="bg-secondary-dark">
                        <tr>
                            <th class="p-4 text-text-muted">Project ID</th>
                            <th class="p-4 text-text-muted">Project Title</th>
                            <th class="p-4 text-text-muted">Client Name</th>
                            <th class="p-4 text-text-muted">Budget</th>
                            <th class="p-4 text-text-muted">Status</th>
                            <th class="p-4 text-text-muted">Proposals</th>
                            <th class="p-4 text-text-muted">Posted On</th>
                            <th class="p-4 text-center text-text-muted">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($projects as $project)
                            <tr class="border-b border-border-custom hover:bg-secondary-dark/50">
                                <td class="p-4 text-text-muted">#{{ $project->id }}</td>
                                <td class="p-4 font-medium">{{ $project->title }}</td>
                                <td class="p-4 text-text-secondary">{{ $project->user->name }}</td>
                                <td class="p-4 text-text-secondary">${{ number_format($project->budget, 2) }}</td>
                                <td class="p-4">
                                    @switch($project->status)
                                        @case('open')
                                            <span class="px-2 py-1 text-sm font-medium rounded-full bg-accent-blue/20 text-accent-blue">Open</span>
                                            @break
                                        @case('in_progress')
                                            <span class="px-2 py-1 text-sm font-medium rounded-full bg-accent-green/20 text-accent-green">In Progress</span>
                                            @break
                                        @case('review')
                                            <span class="px-2 py-1 text-sm font-medium rounded-full bg-accent-orange/20 text-accent-orange">Review</span>
                                            @break
                                        @case('completed')
                                            <span class="px-2 py-1 text-sm font-medium rounded-full bg-green-500/20 text-green-500">Completed</span>
                                            @break
                                        @case('cancelled')
                                            <span class="px-2 py-1 text-sm font-medium rounded-full bg-accent-red/20 text-accent-red">Cancelled</span>
                                            @break
                                        @default
                                            <span class="px-2 py-1 text-sm font-medium rounded-full bg-gray-500/20 text-gray-500">{{ ucfirst(str_replace('_', ' ', $project->status)) }}</span>
                                    @endswitch
                                </td>
                                <td class="p-4 text-text-secondary">{{ $project->proposals->count() }}</td>
                                <td class="p-4 text-text-secondary">{{ $project->created_at->format('Y-m-d') }}</td>
                                <td class="p-4 text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="{{ route('admin.projects.show', $project) }}" class="p-2 text-accent-blue hover:text-blue-400" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.projects.delete', $project) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this project? This action cannot be undone.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-accent-red hover:text-red-400" title="Delete Project">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="p-8 text-center text-text-muted">
                                    <div class="flex flex-col items-center">
                                        <i class="text-4xl mb-4 fas fa-briefcase text-text-muted"></i>
                                        <p class="text-lg font-medium">No projects found</p>
                                        <p class="text-sm">Try adjusting your search criteria</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($projects->hasPages())
                <div class="flex items-center justify-between mt-6">
                    <p class="text-sm text-text-muted">
                        Showing {{ $projects->firstItem() ?? 0 }} to {{ $projects->lastItem() ?? 0 }} of {{ $projects->total() }} projects
                    </p>
                    <div class="flex items-center gap-2">
                        @if($projects->onFirstPage())
                            <span class="px-4 py-2 font-bold rounded-lg bg-secondary-dark text-text-muted cursor-not-allowed">&laquo; Prev</span>
                        @else
                            <a href="{{ $projects->previousPageUrl() }}" class="px-4 py-2 font-bold rounded-lg bg-secondary-dark hover:bg-border-custom text-text-secondary">&laquo; Prev</a>
                        @endif
                        
                        @foreach($projects->getUrlRange(1, $projects->lastPage()) as $page => $url)
                            @if($page == $projects->currentPage())
                                <span class="px-4 py-2 font-bold rounded-lg bg-accent-green text-white">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="px-4 py-2 font-bold rounded-lg bg-secondary-dark hover:bg-border-custom text-text-secondary">{{ $page }}</a>
                            @endif
                        @endforeach
                        
                        @if($projects->hasMorePages())
                            <a href="{{ $projects->nextPageUrl() }}" class="px-4 py-2 font-bold rounded-lg bg-secondary-dark hover:bg-border-custom text-text-secondary">Next &raquo;</a>
                        @else
                            <span class="px-4 py-2 font-bold rounded-lg bg-secondary-dark text-text-muted cursor-not-allowed">Next &raquo;</span>
                        @endif
                    </div>
                </div>
            @endif
@endsection
