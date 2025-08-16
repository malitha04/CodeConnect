@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold text-text-primary mb-6">Hello, {{ Auth::user()->name }}!</h1>

        @if (Auth::user()->hasRole('Client'))
            {{-- Client Dashboard --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                {{-- Total Projects Card --}}
                <a href="{{ route('projects.index') }}" class="block bg-card-dark border border-border-custom rounded-xl shadow-lg p-6 hover:bg-secondary-dark transition-colors duration-200">
                    <div class="flex items-center justify-between mb-4">
                        <i class="fas fa-folder-open text-3xl text-accent-green"></i>
                        <span class="text-text-secondary text-sm">Total Projects</span>
                    </div>
                    <p class="text-4xl font-bold text-text-primary">{{ $myProjectsCount }}</p>
                </a>

                {{-- Open Projects Card --}}
                <a href="{{ route('projects.index') }}?status=open" class="block bg-card-dark border border-border-custom rounded-xl shadow-lg p-6 hover:bg-secondary-dark transition-colors duration-200">
                    <div class="flex items-center justify-between mb-4">
                        <i class="fas fa-bullhorn text-3xl text-yellow-500"></i>
                        <span class="text-text-secondary text-sm">Open for Proposals</span>
                    </div>
                    <p class="text-4xl font-bold text-text-primary">{{ $openProjectsCount }}</p>
                </a>

                {{-- In Progress Hires Card --}}
                <a href="{{ route('hires.index') }}" class="block bg-card-dark border border-border-custom rounded-xl shadow-lg p-6 hover:bg-secondary-dark transition-colors duration-200">
                    <div class="flex items-center justify-between mb-4">
                        <i class="fas fa-user-tie text-3xl text-blue-500"></i>
                        <span class="text-text-secondary text-sm">Active Hires</span>
                    </div>
                    <p class="text-4xl font-bold text-text-primary">{{ $inProgressHires }}</p>
                </a>
            </div>
        @elseif (Auth::user()->hasRole('Developer'))
            {{-- Developer Dashboard --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                {{-- Total Proposals Card --}}
                <a href="{{ route('proposals.index_developer') }}" class="block bg-card-dark border border-border-custom rounded-xl shadow-lg p-6 hover:bg-secondary-dark transition-colors duration-200">
                    <div class="flex items-center justify-between mb-4">
                        <i class="fas fa-file-signature text-3xl text-purple-500"></i>
                        <span class="text-text-secondary text-sm">Total Proposals</span>
                    </div>
                    <p class="text-4xl font-bold text-text-primary">{{ $proposalsCount }}</p>
                </a>

                {{-- Accepted Proposals Card --}}
                <a href="{{ route('proposals.index_developer') }}?status=accepted" class="block bg-card-dark border border-border-custom rounded-xl shadow-lg p-6 hover:bg-secondary-dark transition-colors duration-200">
                    <div class="flex items-center justify-between mb-4">
                        <i class="fas fa-check-circle text-3xl text-green-500"></i>
                        <span class="text-text-secondary text-sm">Accepted Proposals</span>
                    </div>
                    <p class="text-4xl font-bold text-text-primary">{{ $acceptedProposalsCount }}</p>
                </a>

                {{-- Browse Projects Link --}}
                <a href="{{ route('projects.browse') }}" class="block bg-card-dark border border-border-custom rounded-xl shadow-lg p-6 hover:bg-secondary-dark transition-colors duration-200">
                    <div class="flex items-center justify-between mb-4">
                        <i class="fas fa-search text-3xl text-accent-blue"></i>
                        <span class="text-text-secondary text-sm">Browse New Projects</span>
                    </div>
                    <p class="text-xl font-bold text-text-primary mt-2">Find a new gig</p>
                </a>
            </div>
        @else
            {{-- Default view for other roles (or no role) --}}
            <div class="bg-card-dark border border-border-custom rounded-xl p-6 text-center">
                <p class="text-text-secondary text-xl">Welcome to CodeConnect!</p>
                <p class="text-text-muted mt-2">Your dashboard is currently empty. Please ensure your user account has an assigned role.</p>
            </div>
        @endif
    </div>
@endsection
