@extends('layouts.dashboard')

@section('title', 'Project Deliveries')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-text-primary">Project Deliveries</h1>
                <p class="text-text-secondary mt-2">Review project deliveries from your hired developer.</p>
            </div>
            <a href="{{ route('hires.index') }}" 
               class="px-4 py-2 border border-border-custom text-text-primary rounded-lg hover:bg-secondary-dark transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Back to Hires
            </a>
        </div>
    </div>

    <!-- Project Information -->
    <div class="bg-card-dark border border-border-custom rounded-xl p-6 mb-8">
        <h2 class="text-xl font-semibold text-text-primary mb-4">Project: {{ $project->title }}</h2>
        <div class="grid md:grid-cols-3 gap-4 text-sm">
            <div>
                <span class="text-text-secondary">Developer:</span>
                <span class="text-text-primary font-medium">
                    @if($project->proposals()->where('status', 'accepted')->first())
                        {{ $project->proposals()->where('status', 'accepted')->first()->user->name }}
                    @else
                        Not assigned
                    @endif
                </span>
            </div>
            <div>
                <span class="text-text-secondary">Budget:</span>
                <span class="text-text-primary font-medium">${{ number_format($project->budget) }}</span>
            </div>
            <div>
                <span class="text-text-secondary">Status:</span>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                    @if($project->status === 'open') bg-blue-100 text-blue-800
                    @elseif($project->status === 'in-progress') bg-yellow-100 text-yellow-800
                    @elseif($project->status === 'completed') bg-green-100 text-green-800
                    @else bg-gray-100 text-gray-800
                    @endif">
                    {{ ucfirst(str_replace('-', ' ', $project->status)) }}
                </span>
            </div>
        </div>
    </div>

    @if(session('status'))
        <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
            {{ session('status') }}
        </div>
    @endif

    @if($deliveries->count() > 0)
        <div class="space-y-6">
            @foreach($deliveries as $delivery)
                <div class="bg-card-dark border border-border-custom rounded-xl p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <div class="flex items-center space-x-3 mb-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($delivery->delivery_type === 'file') bg-blue-100 text-blue-800
                                    @elseif($delivery->delivery_type === 'github') bg-green-100 text-green-800
                                    @else bg-purple-100 text-purple-800
                                    @endif">
                                    @if($delivery->delivery_type === 'file')
                                        <i class="fas fa-file mr-1"></i>File Upload
                                    @elseif($delivery->delivery_type === 'github')
                                        <i class="fab fa-github mr-1"></i>GitHub Repository
                                    @else
                                        <i class="fas fa-link mr-1"></i>External Link
                                    @endif
                                </span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($delivery->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($delivery->status === 'approved') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    {{ ucfirst($delivery->status) }}
                                </span>
                            </div>
                            <h3 class="text-lg font-medium text-text-primary">Delivery #{{ $delivery->id }}</h3>
                            <p class="text-text-secondary text-sm">Submitted by {{ $delivery->developer->name }} on {{ $delivery->created_at->format('M d, Y \a\t g:i A') }}</p>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('deliveries.show', $delivery) }}" 
                               class="px-3 py-1 text-accent-green hover:text-accent-green-hover text-sm">
                                <i class="fas fa-eye mr-1"></i>View Details
                            </a>
                            @if($delivery->delivery_type === 'file')
                                <a href="{{ route('deliveries.download', $delivery) }}" 
                                   class="px-3 py-1 text-blue-500 hover:text-blue-600 text-sm">
                                    <i class="fas fa-download mr-1"></i>Download
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="mb-4">
                        <h4 class="font-medium text-text-primary mb-2">Description</h4>
                        <p class="text-text-secondary">{{ $delivery->description }}</p>
                    </div>

                    <!-- Delivery Content -->
                    @if($delivery->delivery_type === 'file' && $delivery->file_path)
                        <div class="bg-secondary-dark rounded-lg p-4 mb-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <i class="fas fa-file-archive text-2xl text-blue-500 mr-3"></i>
                                    <div>
                                        <p class="font-medium text-text-primary">Project File</p>
                                        <p class="text-sm text-text-secondary">{{ basename($delivery->file_path) }}</p>
                                    </div>
                                </div>
                                <a href="{{ route('deliveries.download', $delivery) }}" 
                                   class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-colors">
                                    <i class="fas fa-download mr-2"></i>Download
                                </a>
                            </div>
                        </div>
                    @endif

                    @if($delivery->delivery_type === 'github' && $delivery->github_link)
                        <div class="bg-secondary-dark rounded-lg p-4 mb-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <i class="fab fa-github text-2xl text-green-500 mr-3"></i>
                                    <div>
                                        <p class="font-medium text-text-primary">GitHub Repository</p>
                                        <p class="text-sm text-text-secondary">{{ $delivery->github_link }}</p>
                                    </div>
                                </div>
                                <a href="{{ $delivery->github_link }}" target="_blank"
                                   class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg transition-colors">
                                    <i class="fab fa-github mr-2"></i>View Repository
                                </a>
                            </div>
                        </div>
                    @endif

                    @if($delivery->delivery_type === 'other' && $delivery->other_link)
                        <div class="bg-secondary-dark rounded-lg p-4 mb-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <i class="fas fa-external-link-alt text-2xl text-purple-500 mr-3"></i>
                                    <div>
                                        <p class="font-medium text-text-primary">Project Link</p>
                                        <p class="text-sm text-text-secondary">{{ $delivery->other_link }}</p>
                                    </div>
                                </div>
                                <a href="{{ $delivery->other_link }}" target="_blank"
                                   class="px-4 py-2 bg-purple-500 hover:bg-purple-600 text-white rounded-lg transition-colors">
                                    <i class="fas fa-external-link-alt mr-2"></i>Visit Link
                                </a>
                            </div>
                        </div>
                    @endif

                    @if($delivery->client_feedback)
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <h4 class="font-medium text-yellow-800 mb-2">Your Feedback</h4>
                            <p class="text-yellow-700">{{ $delivery->client_feedback }}</p>
                        </div>
                    @endif

                    @if($delivery->status === 'pending')
                        <div class="mt-4 pt-4 border-t border-border-custom">
                            <h4 class="font-medium text-text-primary mb-3">Review This Delivery</h4>
                            <form action="{{ route('deliveries.updateStatus', $delivery) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="space-y-3">
                                    <textarea name="client_feedback" rows="3"
                                              placeholder="Provide feedback about the delivery (optional)..."
                                              class="w-full px-3 py-2 bg-secondary-dark border border-border-custom rounded-lg text-text-primary focus:outline-none focus:ring-2 focus:ring-accent-green focus:border-transparent"></textarea>
                                    <div class="flex space-x-3">
                                        <button type="submit" name="status" value="approved"
                                                class="flex-1 px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg transition-colors">
                                            <i class="fas fa-check mr-2"></i>Approve Delivery
                                        </button>
                                        <button type="submit" name="status" value="rejected"
                                                class="flex-1 px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg transition-colors">
                                            <i class="fas fa-times mr-2"></i>Request Changes
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $deliveries->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <div class="w-24 h-24 bg-secondary-dark rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-box-open text-4xl text-text-secondary"></i>
            </div>
            <h3 class="text-xl font-medium text-text-primary mb-2">No Deliveries Yet</h3>
            <p class="text-text-secondary mb-6">Your developer hasn't submitted any deliveries for this project yet.</p>
            <div class="text-sm text-text-secondary">
                <p>Once your developer completes the project, they will upload the files or provide links here.</p>
            </div>
        </div>
    @endif
</div>
@endsection
