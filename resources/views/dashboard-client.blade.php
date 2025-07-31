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
        {{-- This data can be made dynamic later --}}
        <div class="bg-card-dark border border-border-custom rounded-xl p-6">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-text-secondary text-sm">Total Projects</p>
                    <p class="text-2xl font-bold text-accent-green">{{ count(Auth::user()->projects) }}</p>
                </div>
                <div class="w-12 h-12 bg-accent-green/20 rounded-full flex items-center justify-center">
                    <i class="fas fa-folder-open text-accent-green"></i>
                </div>
            </div>
        </div>
        {{-- Other stat cards --}}
    </section>

    <!-- Recent Projects and Actions -->
    <section class="grid lg:grid-cols-3 gap-8">
        <!-- Recent Projects -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-card-dark border border-border-custom rounded-xl p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold">Recent Projects</h2>
                    <a href="#" class="text-accent-green hover:text-accent-green-hover text-sm">View All</a>
                </div>
                <div class="space-y-4">
                    {{-- Loop through projects passed from the controller --}}
                    @forelse ($projects as $project)
                        <div class="border border-border-custom rounded-lg p-4 hover:border-accent-green transition-colors">
                            <h3 class="font-medium mb-1">{{ $project->title }}</h3>
                            <p class="text-sm text-text-secondary">{{ Str::limit($project->description, 120) }}</p>
                            <div class="text-sm text-text-muted mt-2">
                                <i class="fas fa-calendar-alt mr-1"></i> Posted on {{ $project->created_at->format('M d, Y') }}
                            </div>
                        </div>
                    @empty
                        {{-- Show this message if there are no projects --}}
                        <div class="text-center text-text-secondary py-8">
                            <p>You haven't posted any projects yet.</p>
                            <a href="{{ route('projects.create') }}" class="mt-4 inline-block bg-accent-green hover:bg-accent-green-hover text-white px-4 py-2 rounded-lg font-medium transition-colors">
                                Post Your First Project
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="space-y-6">
            <div class="bg-card-dark border border-border-custom rounded-xl p-6">
                <h2 class="text-xl font-semibold mb-4">Quick Actions</h2>
                <div class="space-y-3">
                    <a href="{{ route('projects.create') }}" class="block bg-accent-green hover:bg-accent-green-hover text-white px-4 py-3 rounded-lg font-medium transition-colors">
                        <i class="fas fa-plus mr-2"></i>Post New Project
                    </a>
                    <a href="#" class="block bg-secondary-dark hover:bg-card-dark text-text-primary px-4 py-3 rounded-lg font-medium transition-colors border border-border-custom">
                        <i class="fas fa-briefcase mr-2"></i>Manage Hires
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
