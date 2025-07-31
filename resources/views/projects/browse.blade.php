@extends('layouts.dashboard')

@section('title', 'Browse Projects')

@section('content')
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold">Browse Projects</h1>
        <p class="text-text-secondary mt-2">Discover new opportunities and submit proposals to grow your freelance business.</p>
    </div>

    <!-- Search and Filters Form -->
    <form method="GET" action="{{ route('projects.browse') }}" id="filterForm">
        <div class="bg-card-dark border border-border-custom rounded-xl p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Search Bar -->
                <div class="lg:col-span-2">
                    <div class="relative">
                        <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-text-muted"></i>
                        <input type="text" name="search" id="searchInput" placeholder="Search projects by keyword..." value="{{ request('search') }}" class="w-full pl-10 pr-4 py-3 bg-secondary-dark border border-border-custom rounded-lg text-text-primary placeholder-text-muted focus:outline-none focus:ring-2 focus:ring-accent-green focus:border-accent-green">
                    </div>
                </div>

                <!-- Category Filter -->
                <div>
                    <select name="category" id="categoryFilter" class="w-full px-4 py-3 bg-secondary-dark border border-border-custom rounded-lg text-text-primary focus:outline-none focus:ring-2 focus:ring-accent-green focus:border-accent-green">
                        <option value="">All Categories</option>
                        <option value="Web Development" @if(request('category') == 'Web Development') selected @endif>Web Development</option>
                        <option value="Mobile Development" @if(request('category') == 'Mobile Development') selected @endif>Mobile Development</option>
                        <option value="UI/UX Design" @if(request('category') == 'UI/UX Design') selected @endif>UI/UX Design</option>
                        <option value="AI & Machine Learning" @if(request('category') == 'AI & Machine Learning') selected @endif>AI & Machine Learning</option>
                    </select>
                </div>

                <!-- Submit Button for Filters -->
                <div>
                    <button type="submit" class="w-full px-4 py-3 bg-accent-green hover:bg-accent-green-hover text-white rounded-lg font-medium transition-colors">Filter</button>
                </div>
            </div>
        </div>
    </form>

    <!-- Projects Grid -->
    <div class="grid gap-6">
        @forelse ($projects as $project)
            <div class="bg-card-dark border border-border-custom rounded-xl p-6 hover:border-accent-green transition-colors project-card">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex-1">
                        <div class="flex items-center mb-2">
                            <span class="bg-blue-500/20 text-blue-500 px-2 py-1 rounded-full text-xs mr-2">{{ $project->category }}</span>
                            <span class="text-text-muted text-sm">Posted {{ $project->created_at->diffForHumans() }}</span>
                        </div>
                        <h3 class="text-xl font-semibold mb-3">{{ $project->title }}</h3>
                        <p class="text-text-secondary mb-4">{{ Str::limit($project->description, 200) }}</p>
                        
                        @if($project->skills)
                        <div class="flex flex-wrap gap-2 mb-4">
                            @foreach(explode(',', $project->skills) as $skill)
                                <span class="px-3 py-1 bg-secondary-dark text-text-secondary rounded-full text-sm">{{ trim($skill) }}</span>
                            @endforeach
                        </div>
                        @endif
                        
                        <div class="flex items-center text-sm text-text-muted mb-4">
                            <span class="mr-6"><i class="fas fa-dollar-sign mr-1"></i>{{ $project->budget }}</span>
                            <span class="mr-6"><i class="fas fa-clock mr-1"></i>{{ $project->duration }}</span>
                        </div>
                    </div>
                    {{-- CORRECTED BUTTONS SECTION --}}
                    <div class="ml-6 flex flex-col items-end space-y-3">
                        <a href="{{ route('projects.show', $project) }}" class="w-full text-center bg-secondary-dark hover:bg-card-dark text-text-primary px-4 py-2 rounded-lg font-medium transition-colors border border-border-custom">
                            View Details
                        </a>
                        <a href="{{ route('proposals.create', $project) }}" class="w-full text-center bg-accent-green hover:bg-accent-green-hover text-white px-4 py-2 rounded-lg font-medium transition-colors">
                            Submit Proposal
                        </a>
                    </div>
                </div>
                <div class="border-t border-border-custom pt-4">
                    <div class="flex items-center">
                        <img src="https://images.unsplash.com/photo-1494790108755-2616b332c1cf?w=40&h=40&fit=crop&crop=face" alt="Client" class="w-10 h-10 rounded-full mr-3">
                        <div>
                            <p class="font-medium">{{ $project->client->name }}</p>
                            <div class="flex items-center text-sm text-text-muted">
                                <i class="fas fa-star text-yellow-400 mr-1"></i>4.9 (47 reviews)
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-card-dark border border-border-custom rounded-xl p-8 text-center">
                <h2 class="text-xl font-semibold">No Open Projects Found</h2>
                <p class="text-text-secondary mt-2">No projects matched your filters. Try broadening your search!</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination Links -->
    <div class="mt-8">
        {{ $projects->links() }}
    </div>
@endsection
