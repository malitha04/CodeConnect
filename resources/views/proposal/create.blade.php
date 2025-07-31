@extends('layouts.dashboard')

@section('title', 'Submit Proposal')

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="mb-6 pb-6 border-b border-border-custom">
            <h1 class="text-3xl font-bold text-text-primary">Submit a Proposal</h1>
            <p class="text-text-secondary mt-2">You are submitting a proposal for the project:</p>
            <h2 class="text-xl font-semibold text-accent-green mt-1">{{ $project->title }}</h2>
        </div>

        <form method="POST" action="{{ route('proposals.store', $project) }}" class="space-y-6 bg-card-dark border border-border-custom rounded-xl p-6">
            @csrf

            <div>
                <label for="bid_amount" class="block text-sm font-medium mb-2">Your Bid Amount (USD)</label>
                <input type="number" id="bid_amount" name="bid_amount" value="{{ old('bid_amount') }}" required placeholder="e.g. 4500" class="w-full md:w-1/2 bg-secondary-dark border border-border-custom text-text-primary rounded-lg px-4 py-3 placeholder-text-muted focus:ring-2 focus:ring-accent-green focus:outline-none">
                @error('bid_amount')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="cover_letter" class="block text-sm font-medium mb-2">Cover Letter</label>
                <textarea id="cover_letter" name="cover_letter" rows="10" required placeholder="Introduce yourself and explain why you're a great fit for this project..." class="w-full bg-secondary-dark border border-border-custom text-text-primary rounded-lg px-4 py-3 placeholder-text-muted focus:ring-2 focus:ring-accent-green focus:outline-none">{{ old('cover_letter') }}</textarea>
                @error('cover_letter')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="pt-4">
                <button type="submit" class="bg-accent-green hover:bg-accent-green-hover text-white font-medium px-6 py-3 rounded-lg transition">
                    <i class="fas fa-paper-plane mr-2"></i>Submit Proposal
                </button>
            </div>
        </form>
    </div>
@endsection
