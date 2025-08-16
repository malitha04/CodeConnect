@extends('layouts.dashboard')

@section('title', 'Write a Review')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-text-primary">Write a Review</h1>
            <p class="text-text-secondary mt-2">Share your experience working with this developer.</p>
        </div>

        <div class="bg-card-dark border border-border-custom rounded-xl p-6">
            <!-- Project Information -->
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-text-primary mb-4">Project Details</h2>
                <div class="bg-secondary-dark rounded-lg p-4">
                    <h3 class="font-medium text-text-primary">{{ $project->title }}</h3>
                    <p class="text-text-secondary text-sm mt-1">{{ $project->description }}</p>
                    <div class="flex items-center mt-2 text-sm text-text-secondary">
                        <span class="mr-4"><i class="fas fa-user mr-1"></i>Developer: {{ $developer->name }}</span>
                        <span><i class="fas fa-dollar-sign mr-1"></i>Budget: ${{ number_format($project->budget) }}</span>
                    </div>
                </div>
            </div>

            <form action="{{ route('reviews.store', $project) }}" method="POST">
                @csrf
                
                <div class="space-y-6">
                    <!-- Rating -->
                    <div>
                        <label class="block text-sm font-medium text-text-primary mb-3">
                            Overall Rating *
                        </label>
                        <div class="flex items-center space-x-2">
                            @for($i = 1; $i <= 5; $i++)
                                <input type="radio" id="rating_{{ $i }}" name="rating" value="{{ $i }}" 
                                       class="hidden" {{ old('rating') == $i ? 'checked' : '' }} required>
                                <label for="rating_{{ $i }}" class="cursor-pointer text-3xl text-gray-300 hover:text-yellow-400 transition-colors">
                                    <i class="fas fa-star"></i>
                                </label>
                            @endfor
                        </div>
                        <div class="mt-2 text-sm text-text-secondary">
                            <span id="rating-text">Select a rating</span>
                        </div>
                        @error('rating')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Comment -->
                    <div>
                        <label for="comment" class="block text-sm font-medium text-text-primary mb-2">
                            Review Comment
                        </label>
                        <textarea id="comment" name="comment" rows="5" 
                                  placeholder="Share your experience working with this developer. What went well? What could be improved? Any specific feedback about communication, quality, or timeliness?"
                                  class="w-full px-3 py-2 bg-secondary-dark border border-border-custom rounded-lg text-text-primary focus:outline-none focus:ring-2 focus:ring-accent-green focus:border-transparent">{{ old('comment') }}</textarea>
                        <p class="text-sm text-text-secondary mt-1">Your review will help other clients make informed decisions.</p>
                        @error('comment')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('hires.index') }}" 
                           class="px-6 py-2 border border-border-custom text-text-primary rounded-lg hover:bg-secondary-dark transition-colors">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="px-6 py-2 bg-accent-green hover:bg-accent-green-hover text-white rounded-lg transition-colors">
                            <i class="fas fa-star mr-2"></i>Submit Review
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ratingInputs = document.querySelectorAll('input[name="rating"]');
    const ratingText = document.getElementById('rating-text');
    const starLabels = document.querySelectorAll('label[for^="rating_"]');

    function updateRating() {
        const selectedRating = document.querySelector('input[name="rating"]:checked');
        
        if (selectedRating) {
            const rating = parseInt(selectedRating.value);
            
            // Update star colors
            starLabels.forEach((label, index) => {
                const star = label.querySelector('i');
                if (index < rating) {
                    star.classList.remove('text-gray-300');
                    star.classList.add('text-yellow-400');
                } else {
                    star.classList.remove('text-yellow-400');
                    star.classList.add('text-gray-300');
                }
            });

            // Update rating text
            const ratingTexts = {
                1: 'Poor - Very dissatisfied',
                2: 'Fair - Somewhat dissatisfied',
                3: 'Good - Satisfied',
                4: 'Very Good - Very satisfied',
                5: 'Excellent - Extremely satisfied'
            };
            ratingText.textContent = ratingTexts[rating];
        }
    }

    // Add event listeners
    ratingInputs.forEach(input => {
        input.addEventListener('change', updateRating);
    });

    // Initialize rating display
    updateRating();
});
</script>
@endsection
