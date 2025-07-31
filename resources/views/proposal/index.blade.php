@extends('layouts.dashboard')

@section('title', 'View Proposals for ' . $project->title)

@section('content')
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold">Proposals for "{{ $project->title }}"</h1>
        <p class="text-text-secondary mt-2">Review the proposals submitted by developers and choose the best fit for your project.</p>
    </div>

    <!-- Proposals List -->
    <div class="bg-card-dark border border-border-custom rounded-xl">
        <div class="space-y-4 p-6">
            @forelse ($project->proposals as $proposal)
                <div class="border border-border-custom rounded-lg p-4 hover:border-accent-green transition-colors">
                    <div class="flex flex-col sm:flex-row justify-between items-start">
                        <!-- Developer Info -->
                        <div class="flex items-center mb-4 sm:mb-0">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=40&h=40&fit=crop&crop=face" class="w-12 h-12 rounded-full mr-4" alt="Developer">
                            <div>
                                <h3 class="font-semibold text-lg">{{ $proposal->developer->name }}</h3>
                                <p class="text-sm text-text-secondary">Top Rated Developer</p>
                            </div>
                        </div>
                        <!-- Bid and Actions -->
                        <div class="flex flex-col items-start sm:items-end space-y-3">
                            <p class="text-xl font-bold text-accent-green">${{ number_format($proposal->bid_amount, 2) }}</p>
                            <div class="flex space-x-2">
                                <a href="#" class="px-4 py-2 bg-secondary-dark border border-border-custom rounded-lg text-sm font-medium hover:bg-card-dark transition">View Profile</a>
                                <a href="#" class="px-4 py-2 bg-accent-green hover:bg-accent-green-hover text-white rounded-lg text-sm font-medium transition">Hire Developer</a>
                            </div>
                        </div>
                    </div>
                    <!-- Cover Letter Excerpt -->
                    <div class="mt-4 border-t border-border-custom pt-4">
                        <p class="text-text-secondary text-sm">
                            {{ Str::limit($proposal->cover_letter, 250) }}
                            <a href="#" class="text-accent-green hover:underline ml-1">Read More</a>
                        </p>
                    </div>
                </div>
            @empty
                <div class="text-center text-text-secondary py-12">
                    <p class="text-lg">No proposals have been submitted for this project yet.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
