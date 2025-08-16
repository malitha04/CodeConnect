@extends('layouts.dashboard')

@section('title', 'Review Details')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-text-primary">Review Details</h1>
                    <p class="text-text-secondary mt-2">Review information and project details.</p>
                </div>
                <div class="flex space-x-2">
                    @if(Auth::id() === $review->client_id)
                        <a href="{{ route('reviews.edit', $review) }}" 
                           class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-colors">
                            <i class="fas fa-edit mr-2"></i>Edit Review
                        </a>
                    @endif
                    <a href="{{ route('reviews.index', $review->developer) }}" 
                       class="px-4 py-2 border border-border-custom text-text-primary rounded-lg hover:bg-secondary-dark transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Reviews
                    </a>
                </div>
            </div>
        </div>

        @if(session('status'))
            <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                {{ session('status') }}
            </div>
        @endif

        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Review Information -->
                <div class="bg-card-dark border border-border-custom rounded-xl p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h2 class="text-xl font-semibold text-text-primary">Review by {{ $review->client->name }}</h2>
                            <p class="text-text-secondary text-sm">Posted on {{ $review->created_at->format('M d, Y \a\t g:i A') }}</p>
                        </div>
                        <div class="text-right">
                            <div class="flex items-center space-x-1 mb-2">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating)
                                        <i class="fas fa-star text-yellow-400"></i>
                                    @else
                                        <i class="far fa-star text-gray-300"></i>
                                    @endif
                                @endfor
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                {{ $review->rating_text }}
                            </span>
                        </div>
                    </div>

                    @if($review->comment)
                        <div class="bg-secondary-dark rounded-lg p-4">
                            <h3 class="font-medium text-text-primary mb-2">Review Comment</h3>
                            <p class="text-text-secondary leading-relaxed">{{ $review->comment }}</p>
                        </div>
                    @else
                        <div class="bg-secondary-dark rounded-lg p-4">
                            <p class="text-text-secondary italic">No comment provided.</p>
                        </div>
                    @endif
                </div>

                <!-- Project Information -->
                <div class="bg-card-dark border border-border-custom rounded-xl p-6">
                    <h2 class="text-xl font-semibold text-text-primary mb-4">Project Information</h2>
                    <div class="space-y-4">
                        <div>
                            <h3 class="font-medium text-text-primary text-lg">{{ $review->project->title }}</h3>
                            <p class="text-text-secondary mt-1">{{ $review->project->description }}</p>
                        </div>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-text-secondary">Category:</span>
                                <span class="text-text-primary font-medium">{{ $review->project->category }}</span>
                            </div>
                            <div>
                                <span class="text-text-secondary">Budget:</span>
                                <span class="text-text-primary font-medium">${{ number_format($review->project->budget) }}</span>
                            </div>
                            <div>
                                <span class="text-text-secondary">Duration:</span>
                                <span class="text-text-primary font-medium">{{ $review->project->duration }}</span>
                            </div>
                            <div>
                                <span class="text-text-secondary">Status:</span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($review->project->status === 'completed') bg-green-100 text-green-800
                                    @elseif($review->project->status === 'in-progress') bg-yellow-100 text-yellow-800
                                    @else bg-blue-100 text-blue-800
                                    @endif">
                                    {{ ucfirst(str_replace('-', ' ', $review->project->status)) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Developer Information -->
                <div class="bg-card-dark border border-border-custom rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-text-primary mb-4">Developer</h3>
                    <div class="text-center">
                        <div class="w-20 h-20 bg-gradient-to-br from-accent-green to-accent-green-hover rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-user text-white text-2xl"></i>
                        </div>
                        <h4 class="font-medium text-text-primary">{{ $review->developer->name }}</h4>
                        <p class="text-text-secondary text-sm">{{ $review->developer->email }}</p>
                        
                        <div class="mt-4 pt-4 border-t border-border-custom">
                            <div class="flex items-center justify-center space-x-1 mb-2">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->developer->average_rating)
                                        <i class="fas fa-star text-yellow-400 text-sm"></i>
                                    @else
                                        <i class="far fa-star text-gray-300 text-sm"></i>
                                    @endif
                                @endfor
                            </div>
                            <p class="text-sm text-text-secondary">
                                {{ number_format($review->developer->average_rating, 1) }} average rating
                            </p>
                            <p class="text-sm text-text-secondary">
                                {{ $review->developer->total_reviews }} total reviews
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Review Actions -->
                @if(Auth::id() === $review->client_id)
                    <div class="bg-card-dark border border-border-custom rounded-xl p-6">
                        <h3 class="text-lg font-semibold text-text-primary mb-4">Review Actions</h3>
                        <div class="space-y-3">
                            <a href="{{ route('reviews.edit', $review) }}" 
                               class="w-full px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-colors text-center block">
                                <i class="fas fa-edit mr-2"></i>Edit Review
                            </a>
                            <form action="{{ route('reviews.destroy', $review) }}" method="POST" class="w-full">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="w-full px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg transition-colors"
                                        onclick="return confirm('Are you sure you want to delete this review?')">
                                    <i class="fas fa-trash mr-2"></i>Delete Review
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
