@extends('layouts.dashboard')

@section('title', 'Edit Project: ' . $project->title)

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6 pb-6 border-b border-border-custom">
            <h1 class="text-3xl font-bold text-text-primary">Edit Project</h1>
            <p class="text-text-secondary mt-2">You are editing the project: <span class="text-accent-green">{{ $project->title }}</span></p>
        </div>

        <form method="POST" action="{{ route('projects.update', $project) }}" class="space-y-6 bg-card-dark border border-border-custom rounded-xl p-6">
            @csrf
            @method('PATCH') {{-- Use PATCH method for updates --}}

            <div>
                <label for="title" class="block text-sm font-medium mb-2 text-text-primary">Project Title</label>
                <input type="text" id="title" name="title" value="{{ old('title', $project->title) }}" required autofocus class="w-full bg-secondary-dark border border-border-custom text-text-primary rounded-lg px-4 py-3 placeholder-text-muted focus:ring-2 focus:ring-accent-green focus:outline-none">
                @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium mb-2 text-text-primary">Project Description</label>
                <textarea id="description" name="description" rows="10" required class="w-full bg-secondary-dark border border-border-custom text-text-primary rounded-lg px-4 py-3 placeholder-text-muted focus:ring-2 focus:ring-accent-green focus:outline-none">{{ old('description', $project->description) }}</textarea>
                @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="category" class="block text-sm font-medium mb-2 text-text-primary">Category</label>
                <input type="text" id="category" name="category" value="{{ old('category', $project->category) }}" required class="w-full bg-secondary-dark border border-border-custom text-text-primary rounded-lg px-4 py-3 placeholder-text-muted focus:ring-2 focus:ring-accent-green focus:outline-none">
                @error('category')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="budget" class="block text-sm font-medium mb-2 text-text-primary">Budget (USD)</label>
                <input type="number" id="budget" name="budget" value="{{ old('budget', (float) $project->budget) }}" required min="1" step="0.01" class="w-full md:w-1/2 bg-secondary-dark border border-border-custom text-text-primary rounded-lg px-4 py-3 placeholder-text-muted focus:ring-2 focus:ring-accent-green focus:outline-none">
                @error('budget')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="duration" class="block text-sm font-medium mb-2 text-text-primary">Duration (e.g., 2 weeks, 1 month)</label>
                <input type="text" id="duration" name="duration" value="{{ old('duration', $project->duration) }}" required class="w-full md:w-1/2 bg-secondary-dark border border-border-custom text-text-primary rounded-lg px-4 py-3 placeholder-text-muted focus:ring-2 focus:ring-accent-green focus:outline-none">
                @error('duration')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="skills" class="block text-sm font-medium mb-2 text-text-primary">Required Skills (comma-separated)</label>
                <input type="text" id="skills" name="skills" value="{{ old('skills', $project->skills) }}" required placeholder="e.g., PHP, Laravel, Tailwind CSS" class="w-full bg-secondary-dark border border-border-custom text-text-primary rounded-lg px-4 py-3 placeholder-text-muted focus:ring-2 focus:ring-accent-green focus:outline-none">
                @error('skills')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="deadline" class="block text-sm font-medium mb-2 text-text-primary">Deadline</label>
                <input type="date" id="deadline" name="deadline" value="{{ old('deadline', $project->deadline ? $project->deadline->format('Y-m-d') : '') }}" required class="w-full md:w-1/2 bg-secondary-dark border border-border-custom text-text-primary rounded-lg px-4 py-3 placeholder-text-muted focus:ring-2 focus:ring-accent-green focus:outline-none">
                @error('deadline')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="pt-4 flex justify-end">
                <button type="submit" class="bg-accent-green hover:bg-accent-green-hover text-white font-medium px-6 py-3 rounded-lg transition">
                    <i class="fas fa-save mr-2"></i>Update Project
                </button>
            </div>
        </form>
    </div>
@endsection
