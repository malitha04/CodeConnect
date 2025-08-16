@extends('layouts.dashboard')

@section('title', 'Upload Project Delivery')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-text-primary">Upload Project Delivery</h1>
            <p class="text-text-secondary mt-2">Submit your completed project for client review.</p>
        </div>

        <div class="bg-card-dark border border-border-custom rounded-xl p-6">
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-text-primary mb-2">Project Details</h2>
                <div class="bg-secondary-dark rounded-lg p-4">
                    <h3 class="font-medium text-text-primary">{{ $project->title }}</h3>
                    <p class="text-text-secondary text-sm mt-1">{{ $project->description }}</p>
                    <div class="flex items-center mt-2 text-sm text-text-secondary">
                        <span class="mr-4"><i class="fas fa-user mr-1"></i>Client: {{ $project->user->name }}</span>
                        <span><i class="fas fa-dollar-sign mr-1"></i>Budget: ${{ number_format($project->budget) }}</span>
                    </div>
                </div>
            </div>

            <form action="{{ route('deliveries.store', $project) }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="space-y-6">
                    <!-- Delivery Type -->
                    <div>
                        <label for="delivery_type" class="block text-sm font-medium text-text-primary mb-2">
                            Delivery Type *
                        </label>
                        <select id="delivery_type" name="delivery_type" 
                                class="w-full px-3 py-2 bg-secondary-dark border border-border-custom rounded-lg text-text-primary focus:outline-none focus:ring-2 focus:ring-accent-green focus:border-transparent"
                                required>
                            <option value="">Select delivery type</option>
                            <option value="file" {{ old('delivery_type') === 'file' ? 'selected' : '' }}>Upload File</option>
                            <option value="github" {{ old('delivery_type') === 'github' ? 'selected' : '' }}>GitHub Repository</option>
                            <option value="other" {{ old('delivery_type') === 'other' ? 'selected' : '' }}>Other Link</option>
                        </select>
                        @error('delivery_type')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- File Upload Section -->
                    <div id="file-section" class="hidden">
                        <label for="project_file" class="block text-sm font-medium text-text-primary mb-2">
                            Project File *
                        </label>
                        <div class="border-2 border-dashed border-border-custom rounded-lg p-6 text-center hover:border-accent-green transition-colors">
                            <input type="file" id="project_file" name="project_file" 
                                   class="hidden" accept=".zip,.rar,.7z,.tar,.gz">
                            <label for="project_file" class="cursor-pointer">
                                <i class="fas fa-cloud-upload-alt text-4xl text-text-secondary mb-4"></i>
                                <p class="text-text-primary font-medium">Click to upload or drag and drop</p>
                                <p class="text-text-secondary text-sm mt-1">ZIP, RAR, 7Z, TAR, GZ files (max 10MB)</p>
                            </label>
                        </div>
                        @error('project_file')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- GitHub Link Section -->
                    <div id="github-section" class="hidden">
                        <label for="github_link" class="block text-sm font-medium text-text-primary mb-2">
                            GitHub Repository URL *
                        </label>
                        <input type="url" id="github_link" name="github_link" 
                               value="{{ old('github_link') }}"
                               placeholder="https://github.com/username/repository"
                               class="w-full px-3 py-2 bg-secondary-dark border border-border-custom rounded-lg text-text-primary focus:outline-none focus:ring-2 focus:ring-accent-green focus:border-transparent">
                        @error('github_link')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Other Link Section -->
                    <div id="other-section" class="hidden">
                        <label for="other_link" class="block text-sm font-medium text-text-primary mb-2">
                            Project Link *
                        </label>
                        <input type="url" id="other_link" name="other_link" 
                               value="{{ old('other_link') }}"
                               placeholder="https://example.com/project"
                               class="w-full px-3 py-2 bg-secondary-dark border border-border-custom rounded-lg text-text-primary focus:outline-none focus:ring-2 focus:ring-accent-green focus:border-transparent">
                        @error('other_link')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-text-primary mb-2">
                            Project Description *
                        </label>
                        <textarea id="description" name="description" rows="4" 
                                  placeholder="Describe your project, features implemented, technologies used, and any special instructions for the client..."
                                  class="w-full px-3 py-2 bg-secondary-dark border border-border-custom rounded-lg text-text-primary focus:outline-none focus:ring-2 focus:ring-accent-green focus:border-transparent"
                                  required>{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('deliveries.index') }}" 
                           class="px-6 py-2 border border-border-custom text-text-primary rounded-lg hover:bg-secondary-dark transition-colors">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="px-6 py-2 bg-accent-green hover:bg-accent-green-hover text-white rounded-lg transition-colors">
                            <i class="fas fa-upload mr-2"></i>Submit Delivery
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const deliveryType = document.getElementById('delivery_type');
    const fileSection = document.getElementById('file-section');
    const githubSection = document.getElementById('github-section');
    const otherSection = document.getElementById('other-section');

    function toggleSections() {
        const selectedType = deliveryType.value;
        
        // Hide all sections
        fileSection.classList.add('hidden');
        githubSection.classList.add('hidden');
        otherSection.classList.add('hidden');
        
        // Show selected section
        if (selectedType === 'file') {
            fileSection.classList.remove('hidden');
        } else if (selectedType === 'github') {
            githubSection.classList.remove('hidden');
        } else if (selectedType === 'other') {
            otherSection.classList.remove('hidden');
        }
    }

    deliveryType.addEventListener('change', toggleSections);
    
    // Initialize on page load
    toggleSections();
});
</script>
@endsection
