<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard - CodeConnect')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: { dark: '#1a1a1a', darker: '#0f0f0f' },
                        secondary: { dark: '#2a2a2a' },
                        card: { dark: '#333333' },
                        accent: {
                            green: '#1dbf73',
                            'green-hover': '#19a463',
                            orange: '#ff7640',
                            blue: '#3b82f6',
                            red: '#ef4444'
                        },
                        text: {
                            primary: '#ffffff',
                            secondary: '#b5b6ba',
                            muted: '#8a8a8a'
                        },
                        border: { custom: '#404145' }
                    },
                    fontFamily: { inter: ['Inter', 'sans-serif'] }
                }
            }
        }
    </script>
    <style>
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #1a1a1a; }
        ::-webkit-scrollbar-thumb { background: #404145; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #555; }
        
        #mobile-menu-btn { display: block; }
        
        @media (min-width: 768px) {
            #sidebar {
                display: block !important;
                transform: translateX(0) !important;
                position: sticky !important;
                top: 64px !important;
            }
            #mobile-menu-btn { display: none; }
        }
        
        #sidebar.mobile-open {
            display: block;
            transform: translateX(0);
        }
    </style>
</head>
<body class="font-inter bg-primary-dark text-text-primary">

    <!-- Top Navigation -->
    <nav class="sticky top-0 z-30 border-b bg-primary-darker border-border-custom">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center">
                    <button id="mobile-menu-btn" class="mr-4 text-text-primary md:hidden">
                        <i class="text-xl fas fa-bars"></i>
                    </button>
                    <a href="{{ route('home') }}" class="flex items-center text-2xl font-bold text-accent-green">
                        <i class="mr-2 fas fa-code"></i>Code<span class="text-text-primary">Connect</span>
                    </a>
                </div>
                    <div class="hidden md:flex items-center gap-6 ms-auto">
                    @if(session('success'))
                        <div class="px-3 py-1 text-sm bg-green-500/20 text-green-400 rounded-lg">
                            {{ session('success') }}
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="px-3 py-1 text-sm bg-red-500/20 text-red-400 rounded-lg">
                            {{ session('error') }}
                        </div>
                    @endif

                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center border border-transparent rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300">
                                @php($avatar = Auth::user()->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name))
                                <img src="{{ $avatar }}" alt="{{ Auth::user()->name }}" class="h-8 w-8 rounded-full object-cover" />
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="px-4 py-2 text-sm text-gray-700">
                                <div class="font-medium">{{ Auth::user()->name }}</div>
                                <div class="text-gray-500">{{ __('Profile Type') }}: {{ Auth::user()->getRoleNames()->first() }}</div>
                            </div>
                            <x-dropdown-link :href="route('admin.settings')">
                                {{ __('Settings') }}
                            </x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>
        </div>
    </nav>

    <div class="relative flex min-h-screen">
        <!-- Sidebar -->
        <aside id="sidebar" class="w-64 bg-secondary-dark border-r border-border-custom min-h-screen fixed md:sticky top-16 left-0 transform -translate-x-full transition-transform z-20 md:translate-x-0 md:min-h-[calc(100vh-64px)] overflow-y-auto">
            <div class="p-4">
                <nav class="space-y-2">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 font-medium rounded-lg nav-link text-text-secondary hover:text-text-primary hover:bg-card-dark {{ request()->routeIs('admin.dashboard') ? 'text-accent-green bg-card-dark' : '' }}">
                        <i class="mr-3 fas fa-tachometer-alt fa-fw"></i>Dashboard
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-3 transition rounded-lg nav-link text-text-secondary hover:text-text-primary hover:bg-card-dark {{ request()->routeIs('admin.users.*') ? 'text-accent-green bg-card-dark' : '' }}">
                        <i class="mr-3 fas fa-users fa-fw"></i>Manage Users
                    </a>
                    <a href="{{ route('admin.projects.index') }}" class="flex items-center px-4 py-3 transition rounded-lg nav-link text-text-secondary hover:text-text-primary hover:bg-card-dark {{ request()->routeIs('admin.projects.*') ? 'text-accent-green bg-card-dark' : '' }}">
                        <i class="mr-3 fas fa-briefcase fa-fw"></i>Manage Projects
                    </a>
                    <a href="{{ route('admin.reports') }}" class="flex items-center px-4 py-3 transition rounded-lg nav-link text-text-secondary hover:text-text-primary hover:bg-card-dark {{ request()->routeIs('admin.reports') ? 'text-accent-green bg-card-dark' : '' }}">
                        <i class="mr-3 fas fa-chart-line fa-fw"></i>Reports
                    </a>
                    <a href="{{ route('admin.contacts.index') }}" class="flex items-center px-4 py-3 transition rounded-lg nav-link text-text-secondary hover:text-text-primary hover:bg-card-dark {{ request()->routeIs('admin.contacts.*') ? 'text-accent-green bg-card-dark' : '' }}">
                        <i class="mr-3 fas fa-envelope fa-fw"></i>Contact Messages
                    </a>
                    <a href="{{ route('admin.settings') }}" class="flex items-center px-4 py-3 transition rounded-lg nav-link text-text-secondary hover:text-text-primary hover:bg-card-dark {{ request()->routeIs('admin.settings') ? 'text-accent-green bg-card-dark' : '' }}">
                        <i class="mr-3 fas fa-cog fa-fw"></i>Settings
                    </a>
                </nav>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 p-6 overflow-x-hidden">
            @yield('content')
        </main>
    </div>

    <!-- Cookie Consent -->
    @include('components.cookie-consent')

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const mobileMenuBtn = document.getElementById('mobile-menu-btn');
            const sidebar = document.getElementById('sidebar');

            // Handle mobile menu toggle
            mobileMenuBtn.addEventListener('click', () => {
                sidebar.classList.toggle('mobile-open');
            });

            // Auto-hide success/error messages after 5 seconds
            setTimeout(() => {
                const messages = document.querySelectorAll('[class*="bg-green-500"], [class*="bg-red-500"]');
                messages.forEach(msg => {
                    msg.style.display = 'none';
                });
            }, 5000);
        });
    </script>
    <script src="{{ asset('js/cookie-manager.js') }}"></script>
</body>
</html>
