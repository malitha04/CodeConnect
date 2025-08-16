@extends('layouts.dashboard')

@section('title', 'Received Reviews')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-text-primary">Reviews I've Received</h1>
        <p class="text-text-secondary mt-2">See what clients have said about your work.</p>
    </div>

    <!-- Summary Stats -->
    <div class="bg-card-dark border border-border-custom rounded-xl p-6 mb-8">
        <div class="grid md:grid-cols-3 gap-6">
            <div class="text-center">
                <div class="flex items-center justify-center space-x-1 mb-2">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= Auth::user()->average_rating)
                            <i class="fas fa-star text-yellow-400 text-xl"></i>
                        @else
                            <i class="far fa-star text-gray-300 text-xl"></i>
                        @endif
                    @endfor
                </div>
                <p class="text-2xl font-bold text-text-primary">{{ number_format(Auth::user()->average_rating, 1) }}</p>
                <p class="text-sm text-text-secondary">Average Rating</p>
            </div>
            <div class="text-center">
                <p class="text-2xl font-bold text-text-primary">{{ Auth::user()->total_reviews }}</p>
                <p class="text-sm text-text-secondary">Total Reviews</p>
            </div>
            <div class="text-center">
                <p class="text-2xl font-bold text-accent-green">{{ Auth::user()->reviewsReceived()->published()->where('rating', '>=', 4)->count() }}</p>
                <p class="text-sm text-text-secondary">Positive Reviews (4+ stars)</p>
            </div>
        </div>
    </div>

    @if($reviews->count() > 0)
        <div class="space-y-6">
            @foreach($reviews as $review)
                <div class="bg-card-dark border border-border-custom rounded-xl p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <div class="flex items-center space-x-3 mb-2">
                                <h3 class="font-medium text-text-primary">{{ $review->client->name }}</h3>
                                <span class="text-text-secondary text-sm">{{ $review->created_at->format('M d, Y') }}</span>
                            </div>
                            <div class="flex items-center space-x-1 mb-2">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating)
                                        <i class="fas fa-star text-yellow-400"></i>
                                    @else
                                        <i class="far fa-star text-gray-300"></i>
                                    @endif
                                @endfor
                                <span class="ml-2 text-sm text-text-secondary">{{ $review->rating_text }}</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $review->project->category }}
                            </span>
                        </div>
                    </div>

                    @if($review->comment)
                        <div class="mb-4">
                            <p class="text-text-secondary leading-relaxed">{{ $review->comment }}</p>
                        </div>
                    @endif

                    <div class="pt-4 border-t border-border-custom">
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-text-secondary">
                                <span class="font-medium text-text-primary">Project:</span> {{ $review->project->title }}
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ route('reviews.show', $review) }}" 
                                   class="text-accent-green hover:text-accent-green-hover text-sm">
                                    <i class="fas fa-eye mr-1"></i>View Details
                                </a>
                                <a href="{{ route('projects.show', $review->project) }}" 
                                   class="text-blue-500 hover:text-blue-600 text-sm">
                                    <i class="fas fa-folder mr-1"></i>View Project
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $reviews->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <div class="w-24 h-24 bg-secondary-dark rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-star text-4xl text-text-secondary"></i>
            </div>
            <h3 class="text-xl font-medium text-text-primary mb-2">No Reviews Yet</h3>
            <p class="text-text-secondary mb-6">You haven't received any reviews yet.</p>
            <div class="text-sm text-text-secondary">
                <p>Reviews will appear here once clients complete projects and leave feedback for your work.</p>
            </div>
        </div>
    @endif
</div>
@endsection
