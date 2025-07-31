<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - CodeConnect</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Alpine.js for dynamic interactions -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: { dark: '#1a1a1a', darker: '#0f0f0f' },
                        secondary: { dark: '#2a2a2a' },
                        card: { dark: '#333333' },
                        accent: { green: '#1dbf73', 'green-hover': '#19a463', orange: '#ff7640' },
                        text: { primary: '#ffffff', secondary: '#b5b6ba', muted: '#8a8a8a' },
                        border: { custom: '#404145' }
                    },
                    fontFamily: { 'inter': ['Inter', 'sans-serif'] }
                }
            }
        }
    </script>
</head>
<body class="font-inter bg-primary-dark text-text-primary">

    <!-- Top Navigation -->
    <nav class="bg-primary-darker border-b border-border-custom">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-accent-green">
                        <i class="fas fa-code mr-2"></i>Code<span class="text-text-primary">Connect</span>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <button class="text-text-secondary hover:text-text-primary relative">
                        <i class="fas fa-bell text-lg"></i>
                        <span class="absolute -top-2 -right-2 bg-accent-orange text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">3</span>
                    </button>
                    <div class="flex items-center space-x-3">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=40&h=40&fit=crop&crop=face" alt="Profile" class="w-8 h-8 rounded-full">
                        <div class="text-sm">
                            <div class="font-medium">{{ Auth::user()->name }}</div>
                            <!-- Sign Out Form -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); this.closest('form').submit();"
                                   class="text-text-muted hover:text-accent-green transition">
                                    Sign Out
                                </a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 bg-secondary-dark border-r border-border-custom min-h-screen">
            <div class="p-4">
                <nav class="space-y-2">
                    @if(Auth::user()->hasRole('Developer'))
                        {{-- Developer Sidebar Links --}}
                        <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-text-secondary hover:text-text-primary hover:bg-card-dark rounded-lg transition-colors">
                            <i class="fas fa-tachometer-alt mr-3"></i>Dashboard
                        </a>
                        <a href="{{ route('projects.browse') }}" class="flex items-center px-4 py-3 text-text-secondary hover:text-text-primary hover:bg-card-dark rounded-lg transition-colors">
                            <i class="fas fa-briefcase mr-3"></i>Browse Projects
                        </a>
                        {{-- THIS IS THE NEW LINK --}}
                        <a href="#" class="flex items-center px-4 py-3 text-text-secondary hover:text-text-primary hover:bg-card-dark rounded-lg transition-colors">
                            <i class="fas fa-file-alt mr-3"></i>My Proposals
                        </a>
                    @elseif(Auth::user()->hasRole('Client'))
                        {{-- Client Sidebar Links --}}
                        <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-text-secondary hover:text-text-primary hover:bg-card-dark rounded-lg transition-colors">
                            <i class="fas fa-tachometer-alt mr-3"></i>Dashboard
                        </a>
                        <a href="{{ route('projects.create') }}" class="flex items-center px-4 py-3 text-text-secondary hover:text-text-primary hover:bg-card-dark rounded-lg transition-colors">
                            <i class="fas fa-plus-circle mr-3"></i>Post a Project
                        </a>
                        <a href="{{ route('projects.index') }}" class="flex items-center px-4 py-3 text-text-secondary hover:text-text-primary hover:bg-card-dark rounded-lg transition-colors">
                            <i class="fas fa-tasks mr-3"></i>My Projects
                        </a>
                    @endif
                     <a href="{{ route('inbox.index') }}" class="flex items-center px-4 py-3 text-text-secondary hover:text-text-primary hover:bg-card-dark rounded-lg transition-colors">
                        <i class="fas fa-envelope mr-3"></i>Messages
                    </a>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            {{-- Auto-hiding success message --}}
            @if (session('success'))
                <div x-data="{ show: true }"
                     x-init="setTimeout(() => show = false, 4000)"
                     x-show="show"
                     x-transition:leave="transition ease-in duration-300"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="bg-accent-green/20 border border-accent-green text-accent-green px-4 py-3 rounded-lg relative mb-6"
                     role="alert">
                    <strong class="font-bold">Success!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

</body>
</html>
