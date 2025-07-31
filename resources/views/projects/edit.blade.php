@extends('layouts.dashboard')

@section('title', 'Edit Project')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Edit Project: {{ $project->title }}</h1>

    <form method="POST" action="{{ route('projects.update', $project) }}" class="space-y-6 bg-card-dark border border-border-custom rounded-xl p-6 max-w-4xl">
        @csrf
        @method('PATCH')

        <!-- Project Title -->
        <div>
            <label for="title" class="block text-sm font-medium mb-2">Project Title</label>
            <input type="text" id="title" name="title" value="{{ old('title', $project->title) }}" required class="w-full bg-secondary-dark border border-border-custom text-text-primary rounded-lg px-4 py-3">
            @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <!-- Description -->
        <div>
            <label for="description" class="block text-sm font-medium mb-2">Project Description</label>
            <textarea id="description" name="description" rows="6" required class="w-full bg-secondary-dark border border-border-custom text-text-primary rounded-lg px-4 py-3">{{ old('description', $project->description) }}</textarea>
            @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <!-- Category -->
        <div>
            <label for="category" class="block text-sm font-medium mb-2">Category</label>
            <select id="category" name="category" required class="w-full bg-secondary-dark border border-border-custom text-text-primary rounded-lg px-4 py-3">
                @php $categories = ['Web Development', 'Mobile Development', 'UI/UX Design', 'AI & Machine Learning', 'DevOps', 'Data Science']; @endphp
                @foreach($categories as $category)
                    <option value="{{ $category }}" @if(old('category', $project->category) == $category) selected @endif>{{ $category }}</option>
                @endforeach
            </select>
            @error('category')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <!-- Budget & Duration -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="budget" class="block text-sm font-medium mb-2">Budget Range (USD)</label>
                <input type="text" id="budget" name="budget" value="{{ old('budget', $project->budget) }}" required class="w-full bg-secondary-dark border border-border-custom text-text-primary rounded-lg px-4 py-3">
                @error('budget')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="duration" class="block text-sm font-medium mb-2">Estimated Duration</label>
                <input type="text" id="duration" name="duration" value="{{ old('duration', $project->duration) }}" required class="w-full bg-secondary-dark border border-border-custom text-text-primary rounded-lg px-4 py-3">
                @error('duration')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <!-- Skills -->
        <div>
            <label for="skills" class="block text-sm font-medium mb-2">Required Skills (Optional)</label>
            <input type="text" id="skills" name="skills" value="{{ old('skills', $project->skills) }}" class="w-full bg-secondary-dark border border-border-custom text-text-primary rounded-lg px-4 py-3">
        </div>

        <!-- Submit -->
        <div class="pt-4">
            <button type="submit" class="bg-accent-green hover:bg-accent-green-hover text-white font-medium px-6 py-3 rounded-lg transition">
                Update Project
            </button>
        </div>
    </form>
@endsection