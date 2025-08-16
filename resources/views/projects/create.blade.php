@extends('layouts.dashboard')

@section('title', 'Post a New Project')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-card-dark border border-border-custom rounded-xl shadow-lg p-6 md:p-8">
            <div class="flex items-center justify-between mb-8">
                <h1 class="text-3xl font-extrabold text-text-primary">Post a New Project</h1>
                <a href="{{ route('projects.index') }}" class="text-text-secondary hover:text-text-primary transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i> Back to My Projects
                </a>
            </div>

            {{-- Display All Validation Errors --}}
            @if ($errors->any())
                <div class="bg-red-500/20 border border-red-500 text-red-300 rounded-lg p-4 mb-6">
                    <div class="font-bold mb-2">Please correct the following errors:</div>
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('projects.store') }}" method="POST" class="space-y-6">
                @csrf
                {{-- Project Title --}}
                <div>
                    <label for="title" class="block text-text-primary text-sm font-medium mb-2">Project Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required
                           class="w-full p-3 bg-secondary-dark border border-border-custom rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-green text-text-primary placeholder-text-muted transition-colors">
                    @error('title')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Description --}}
                <div>
                    <label for="description" class="block text-text-primary text-sm font-medium mb-2">Project Description</label>
                    <textarea name="description" id="description" rows="6" required
                              class="w-full p-3 bg-secondary-dark border border-border-custom rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-green text-text-primary placeholder-text-muted transition-colors">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Category --}}
                <div>
                    <label for="category" class="block text-text-primary text-sm font-medium mb-2">Category</label>
                    <select name="category" id="category" required
                            class="w-full p-3 bg-secondary-dark border border-border-custom rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-green text-text-primary transition-colors">
                        <option value="" disabled {{ old('category') == '' ? 'selected' : '' }}>Select a category</option>
                        <option value="Web Development" {{ old('category') == 'Web Development' ? 'selected' : '' }}>Web Development</option>
                        <option value="Mobile Development" {{ old('category') == 'Mobile Development' ? 'selected' : '' }}>Mobile Development</option>
                        <option value="UI/UX Design" {{ old('category') == 'UI/UX Design' ? 'selected' : '' }}>UI/UX Design</option>
                        <option value="Graphic Design" {{ old('category') == 'Graphic Design' ? 'selected' : '' }}>Graphic Design</option>
                        <option value="Writing & Translation" {{ old('category') == 'Writing & Translation' ? 'selected' : '' }}>Writing & Translation</option>
                        <option value="Data Science" {{ old('category') == 'Data Science' ? 'selected' : '' }}>Data Science</option>
                    </select>
                    @error('category')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Duration --}}
                <div>
                    <label for="duration" class="block text-text-primary text-sm font-medium mb-2">Duration (in weeks)</label>
                    <input type="number" name="duration" id="duration" value="{{ old('duration') }}" required min="1"
                           class="w-full p-3 bg-secondary-dark border border-border-custom rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-green text-text-primary placeholder-text-muted transition-colors">
                    @error('duration')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Skills --}}
                <div>
                    <label for="skills" class="block text-text-primary text-sm font-medium mb-2">Required Skills (comma-separated)</label>
                    <input type="text" name="skills" id="skills" value="{{ old('skills') }}" required
                           class="w-full p-3 bg-secondary-dark border border-border-custom rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-green text-text-primary placeholder-text-muted transition-colors">
                    <p class="text-text-muted text-sm mt-1">e.g., HTML, CSS, JavaScript, React, Tailwind CSS</p>
                    @error('skills')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Budget --}}
                <div>
                    <label for="budget" class="block text-text-primary text-sm font-medium mb-2">Budget ($)</label>
                    <input type="number" name="budget" id="budget" value="{{ old('budget') }}" required min="1"
                           class="w-full p-3 bg-secondary-dark border border-border-custom rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-green text-text-primary placeholder-text-muted transition-colors">
                    @error('budget')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Deadline --}}
                <div>
                    <label for="deadline" class="block text-text-primary text-sm font-medium mb-2">Deadline</label>
                    <input type="date" name="deadline" id="deadline" value="{{ old('deadline') }}" required
                           class="w-full p-3 bg-secondary-dark border border-border-custom rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-green text-text-primary placeholder-text-muted transition-colors">
                    @error('deadline')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit Button --}}
                <div class="flex justify-end">
                    <button type="submit" class="bg-accent-green hover:bg-accent-green-hover text-white font-semibold py-3 px-6 rounded-lg transition-colors">
                        Post Project
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
