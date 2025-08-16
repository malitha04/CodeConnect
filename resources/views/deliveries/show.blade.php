@extends('layouts.dashboard')

@section('title', 'Delivery Details')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-text-primary">Delivery Details</h1>
                    <p class="text-text-secondary mt-2">Project delivery information and status.</p>
                </div>
                <a href="{{ route('deliveries.index') }}" 
                   class="px-4 py-2 border border-border-custom text-text-primary rounded-lg hover:bg-secondary-dark transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Deliveries
                </a>
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
                <!-- Project Information -->
                <div class="bg-card-dark border border-border-custom rounded-xl p-6">
                    <h2 class="text-xl font-semibold text-text-primary mb-4">Project Information</h2>
                    <div class="space-y-4">
                        <div>
                            <h3 class="font-medium text-text-primary text-lg">{{ $delivery->project->title }}</h3>
                            <p class="text-text-secondary mt-1">{{ $delivery->project->description }}</p>
                        </div>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-text-secondary">Client:</span>
                                <span class="text-text-primary font-medium">{{ $delivery->project->user->name }}</span>
                            </div>
                            <div>
                                <span class="text-text-secondary">Budget:</span>
                                <span class="text-text-primary font-medium">${{ number_format($delivery->project->budget) }}</span>
                            </div>
                            <div>
                                <span class="text-text-secondary">Category:</span>
                                <span class="text-text-primary font-medium">{{ $delivery->project->category }}</span>
                            </div>
                            <div>
                                <span class="text-text-secondary">Duration:</span>
                                <span class="text-text-primary font-medium">{{ $delivery->project->duration }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Delivery Information -->
                <div class="bg-card-dark border border-border-custom rounded-xl p-6">
                    <h2 class="text-xl font-semibold text-text-primary mb-4">Delivery Information</h2>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-text-secondary">Delivery Type:</span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ml-2
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
                            </div>
                            <div>
                                <span class="text-text-secondary">Status:</span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ml-2
                                    @if($delivery->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($delivery->status === 'approved') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    {{ ucfirst($delivery->status) }}
                                </span>
                            </div>
                        </div>

                        @if($delivery->delivery_type === 'file' && $delivery->file_path)
                            <div class="bg-secondary-dark rounded-lg p-4">
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
                            <div class="bg-secondary-dark rounded-lg p-4">
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
                            <div class="bg-secondary-dark rounded-lg p-4">
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

                        <div>
                            <h4 class="font-medium text-text-primary mb-2">Description</h4>
                            <p class="text-text-secondary">{{ $delivery->description }}</p>
                        </div>
                    </div>
                </div>

                @if($delivery->client_feedback)
                    <div class="bg-card-dark border border-border-custom rounded-xl p-6">
                        <h2 class="text-xl font-semibold text-text-primary mb-4">Client Feedback</h2>
                        <div class="bg-secondary-dark rounded-lg p-4">
                            <p class="text-text-secondary">{{ $delivery->client_feedback }}</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Delivery Status -->
                <div class="bg-card-dark border border-border-custom rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-text-primary mb-4">Delivery Status</h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-text-secondary">Submitted:</span>
                            <span class="text-text-primary">{{ $delivery->created_at->format('M d, Y') }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-text-secondary">Last Updated:</span>
                            <span class="text-text-primary">{{ $delivery->updated_at->format('M d, Y') }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-text-secondary">Developer:</span>
                            <span class="text-text-primary">{{ $delivery->developer->name }}</span>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                @if(Auth::id() === $delivery->project->user_id && $delivery->status === 'pending')
                    <div class="bg-card-dark border border-border-custom rounded-xl p-6">
                        <h3 class="text-lg font-semibold text-text-primary mb-4">Review Delivery</h3>
                        <form action="{{ route('deliveries.updateStatus', $delivery) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="space-y-4">
                                <div>
                                    <label for="client_feedback" class="block text-sm font-medium text-text-primary mb-2">
                                        Feedback (Optional)
                                    </label>
                                    <textarea id="client_feedback" name="client_feedback" rows="3"
                                              placeholder="Provide feedback about the delivery..."
                                              class="w-full px-3 py-2 bg-secondary-dark border border-border-custom rounded-lg text-text-primary focus:outline-none focus:ring-2 focus:ring-accent-green focus:border-transparent"></textarea>
                                </div>
                                <div class="flex space-x-3">
                                    <button type="submit" name="status" value="approved"
                                            class="flex-1 px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg transition-colors">
                                        <i class="fas fa-check mr-2"></i>Approve
                                    </button>
                                    <button type="submit" name="status" value="rejected"
                                            class="flex-1 px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg transition-colors">
                                        <i class="fas fa-times mr-2"></i>Reject
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
