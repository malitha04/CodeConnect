@extends('layouts.dashboard')

@section('title', 'Post a New Project')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Post a New Project</h1>

    <form method="POST" action="{{ route('projects.store') }}" class="space-y-6 bg-card-dark border border-border-custom rounded-xl p-6 max-w-4xl">
        @csrf

        <!-- Project Title -->
        <div>
            <label for="title" class="block text-sm font-medium mb-2">Project Title</label>
            <input type="text" id="title" name="title" value="{{ old('title') }}" required placeholder="e.g. Build a React SaaS Dashboard" class="w-full bg-secondary-dark border border-border-custom text-text-primary rounded-lg px-4 py-3 placeholder-text-muted focus:ring-2 focus:ring-accent-green focus:outline-none">
            @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <!-- Description -->
        <div>
            <label for="description" class="block text-sm font-medium mb-2">Project Description</label>
            <textarea id="description" name="description" rows="6" required placeholder="Describe the scope, features, expectations..." class="w-full bg-secondary-dark border border-border-custom text-text-primary rounded-lg px-4 py-3 placeholder-text-muted focus:ring-2 focus:ring-accent-green focus:outline-none">{{ old('description') }}</textarea>
            @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <!-- Category -->
        <div>
            <label for="category" class="block text-sm font-medium mb-2">Category</label>
            <select id="category" name="category" required class="w-full bg-secondary-dark border border-border-custom text-text-primary rounded-lg px-4 py-3 focus:ring-2 focus:ring-accent-green focus:outline-none">
                <option value="">Select a category</option>
                <option @if(old('category') == 'Web Development') selected @endif>Web Development</option>
                <option @if(old('category') == 'Mobile Development') selected @endif>Mobile Development</option>
                <option @if(old('category') == 'UI/UX Design') selected @endif>UI/UX Design</option>
                <option @if(old('category') == 'AI & Machine Learning') selected @endif>AI & Machine Learning</option>
                <option @if(old('category') == 'DevOps') selected @endif>DevOps</option>
                <option @if(old('category') == 'Data Science') selected @endif>Data Science</option>
            </select>
            @error('category')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <!-- Budget & Duration -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="budget" class="block text-sm font-medium mb-2">Budget Range (USD)</label>
                <input type="text" id="budget" name="budget" value="{{ old('budget') }}" required placeholder="e.g. $1000 - $3000" class="w-full bg-secondary-dark border border-border-custom text-text-primary rounded-lg px-4 py-3 placeholder-text-muted focus:ring-2 focus:ring-accent-green focus:outline-none">
                @error('budget')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="duration" class="block text-sm font-medium mb-2">Estimated Duration</label>
                <input type="text" id="duration" name="duration" value="{{ old('duration') }}" required placeholder="e.g. 4-6 weeks" class="w-full bg-secondary-dark border border-border-custom text-text-primary rounded-lg px-4 py-3 placeholder-text-muted focus:ring-2 focus:ring-accent-green focus:outline-none">
                @error('duration')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <!-- Skills -->
        <div>
            <label for="skills" class="block text-sm font-medium mb-2">Required Skills (Optional)</label>
            <input type="text" id="skills" name="skills" value="{{ old('skills') }}" placeholder="e.g. React, Node.js, MongoDB" class="w-full bg-secondary-dark border border-border-custom text-text-primary rounded-lg px-4 py-3 placeholder-text-muted focus:ring-2 focus:ring-accent-green focus:outline-none">
            <p class="text-xs text-text-muted mt-1">Separate skills with commas</p>
            @error('skills')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <!-- Submit -->
        <div class="pt-4">
            <button type="submit" class="bg-accent-green hover:bg-accent-green-hover text-white font-medium px-6 py-3 rounded-lg transition">
                <i class="fas fa-paper-plane mr-2"></i>Post Project
            </button>
        </div>
    </form>
@endsection
