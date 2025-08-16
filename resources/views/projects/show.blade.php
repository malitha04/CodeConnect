@extends('layouts.dashboard')

@section('title', $project->title)

@section('content')
    <div class="bg-card-dark border border-border-custom rounded-xl p-6 lg:p-8 max-w-4xl mx-auto">
        <!-- Error Messages -->
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-600/20 border border-red-500/50 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle text-red-500 mr-3"></i>
                    <div>
                        @foreach ($errors->all() as $error)
                            <p class="text-red-500 text-sm">{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row justify-between items-start mb-6 pb-6 border-b border-border-custom">
            <div>
                <h1 class="text-3xl font-bold text-text-primary">{{ $project->title }}</h1>
                <div class="flex items-center text-sm text-text-muted mt-2 flex-wrap gap-x-4 gap-y-2">
                    <span><i class="fas fa-layer-group mr-1"></i> {{ $project->category }}</span>
                    <span><i class="fas fa-calendar-alt mr-1"></i> Posted {{ $project->created_at->diffForHumans() }}</span>
                </div>
            </div>
            <a href="{{ url()->previous() }}" class="text-text-secondary hover:text-text-primary mt-4 sm:mt-0 whitespace-nowrap">&larr; Back</a>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Left Column: Description and Skills -->
            <div class="md:col-span-2">
                <h2 class="text-xl font-semibold mb-2 text-text-primary">Project Description</h2>
                <p class="text-text-secondary whitespace-pre-wrap leading-relaxed">{{ $project->description }}</p>

                <h2 class="text-xl font-semibold mt-8 mb-3 text-text-primary">Required Skills</h2>
                <div class="flex flex-wrap gap-2">
                    @if($project->skills)
                        @foreach(explode(',', $project->skills) as $skill)
                            <span class="bg-secondary-dark text-text-secondary text-sm font-medium px-3 py-1 rounded-full">{{ trim($skill) }}</span>
                        @endforeach
                    @else
                        <p class="text-text-secondary text-sm">No specific skills listed.</p>
                    @endif
                </div>
            </div>

            <!-- Right Column: Details and Actions -->
            <div class="md:col-span-1 space-y-6">
                <div class="bg-secondary-dark border border-border-custom rounded-lg p-4 space-y-4">
                    <div>
                        <h3 class="text-sm font-medium text-text-muted">Budget</h3>
                        <p class="text-lg font-semibold text-accent-green">{{ $project->budget }}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-text-muted">Estimated Duration</h3>
                        <p class="text-lg font-semibold">{{ $project->duration }}</p>
                    </div>
                     <div>
                        <h3 class="text-sm font-medium text-text-muted">Status</h3>
                        <p class="text-lg font-semibold capitalize">{{ $project->status }}</p>
                    </div>
                </div>

                {{-- Action buttons will differ based on user role --}}
                @if(Auth::user()->hasRole('Developer'))
                    {{-- Check if user already has a proposal for this project --}}
                    @if(!$project->proposals()->where('user_id', Auth::id())->exists())
                        <a href="{{ route('proposals.create', $project) }}" class="w-full text-center bg-accent-green hover:bg-accent-green-hover text-white px-4 py-3 rounded-lg font-medium transition-colors block">
                            Submit a Proposal
                        </a>
                    @else
                        <div class="w-full text-center bg-secondary-dark text-text-secondary px-4 py-3 rounded-lg font-medium border border-border-custom">
                            Proposal Already Submitted
                        </div>
                    @endif
                @elseif(Auth::user()->id === $project->user_id)
                    <a href="{{ route('projects.edit', $project) }}" class="w-full text-center bg-secondary-dark hover:bg-card-dark text-text-primary px-4 py-3 rounded-lg font-medium border border-border-custom block">
                        Edit Project
                    </a>
                @endif

                {{-- Message button for all authenticated users (except project owner) --}}
                @if(Auth::id() !== $project->user_id)
                    <form action="{{ route('inbox.start') }}" method="POST" class="w-full">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $project->user_id }}">
                        <button type="submit" class="w-full text-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-lg font-medium transition-colors">
                            <i class="fas fa-envelope mr-2"></i>Message {{ $project->user->name }}
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection
