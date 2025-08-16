@extends('layouts.dashboard')

@section('title', 'My Hires')

@section('content')
  <div class="mb-8">
    <h1 class="text-3xl font-bold">My Hires</h1>
    <p class="text-text-secondary mt-2">Manage the freelancers you've hired for your projects.</p>
  </div>

  {{-- Check if there are any hires to display --}}
  @if ($hires->isEmpty())
    <div class="bg-card-dark border border-border-custom rounded-xl p-6 text-center">
        <p class="text-text-secondary text-xl">You haven't hired anyone yet.</p>
        <p class="text-text-muted mt-2">Post a project and accept a proposal to get started!</p>
    </div>
  @else
    <div class="space-y-6">
      {{-- Loop through the collection of accepted proposals (hires) passed from the controller --}}
      @foreach ($hires as $hire)
        <div class="bg-card-dark border border-border-custom rounded-xl p-6">
          <div class="flex flex-col md:flex-row items-start justify-between">
            <div class="flex items-start space-x-4">
              {{-- Display developer's profile picture --}}
              <div class="w-12 h-12 rounded-full overflow-hidden">
                @if($hire->developer->avatar_url)
                    <img src="{{ $hire->developer->avatar_url }}" class="w-full h-full object-cover" alt="{{ $hire->developer->name }}'s profile picture">
                @else
                    <div class="w-full h-full bg-accent-green flex items-center justify-center text-white font-bold text-xl">
                        {{ $hire->developer->initial }}
                    </div>
                @endif
              </div>
              <div>
                {{-- Display the developer's name --}}
                <h2 class="text-lg font-medium">{{ $hire->developer->name }}</h2>
                {{-- Use a placeholder for the role since it's not in the proposal model --}}
                <p class="text-text-muted text-sm">Developer</p>
                {{-- Display the project title from the related project model --}}
                <p class="text-sm mt-2"><i class="fas fa-folder mr-1"></i>{{ $hire->project->title }}</p>
                <div class="flex flex-wrap items-center gap-4 mt-2 text-sm text-text-muted">
                  {{-- Display the bid amount from the proposal --}}
                  <span><i class="fas fa-dollar-sign mr-1"></i>${{ number_format($hire->bid_amount, 2) }}</span>
                  {{-- Display the hire date (proposal creation date) --}}
                  <span><i class="fas fa-calendar-alt mr-1"></i>Hired: {{ $hire->created_at->format('M d, Y') }}</span>
                  {{-- Display the status with a dynamic class based on its value --}}
                  <span class="px-2 py-1 rounded-full text-xs font-semibold
                    @if($hire->status === 'accepted') bg-green-500/20 text-green-400
                    @elseif($hire->status === 'in-progress') bg-blue-500/20 text-blue-400
                    @else bg-gray-500/20 text-gray-400 @endif">
                    {{ ucfirst($hire->status) }}
                  </span>
                </div>
              </div>
            </div>
            <div class="flex flex-col items-end space-y-2 text-sm mt-4 md:mt-0">
              <a href="{{ route('inbox.index') }}" class="px-4 py-2 border border-border-custom rounded-lg hover:bg-secondary-dark text-text-primary">
                <i class="fas fa-comment mr-2"></i>Message
              </a>
              <a href="{{ route('deliveries.project', $hire->project) }}" class="px-4 py-2 border border-border-custom rounded-lg hover:bg-secondary-dark text-text-primary">
                <i class="fas fa-box-open mr-2"></i>View Deliveries
              </a>
              
              @if ($hire->project->status === 'in-progress')
                <form action="{{ route('hires.markAsCompleted', $hire->project) }}" method="POST" class="w-full">
                  @csrf
                  <button type="submit" class="w-full px-4 py-2 bg-accent-green hover:bg-accent-green-hover text-white rounded-lg transition-colors">
                    <i class="fas fa-check mr-2"></i>Mark as Completed
                  </button>
                </form>
              @elseif ($hire->project->status === 'completed')
                @if($hire->project->reviewByClient(Auth::id()))
                  <a href="{{ route('reviews.edit', $hire->project->reviewByClient(Auth::id())) }}" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg">
                    <i class="fas fa-edit mr-2"></i>Edit Review
                  </a>
                @else
                  <a href="{{ route('reviews.create', $hire->project) }}" class="px-4 py-2 bg-accent-green hover:bg-accent-green-hover text-white rounded-lg">
                    <i class="fas fa-star mr-2"></i>Leave a Review
                  </a>
                @endif
              @endif
            </div>
          </div>
        </div>
      @endforeach
    </div>
  @endif
@endsection
