<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>User Details - CodeConnect</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
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
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-3xl font-bold">User Details</h1>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.users.edit', $user) }}" class="px-4 py-2 font-medium transition-colors rounded-lg bg-accent-orange hover:bg-orange-600 text-text-primary">
                        <i class="mr-2 fas fa-pencil-alt"></i>Edit User
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="px-4 py-2 font-medium transition-colors rounded-lg bg-secondary-dark hover:bg-card-dark text-text-primary">
                        <i class="mr-2 fas fa-arrow-left"></i>Back to Users
                    </a>
                </div>
            </div>

            <!-- User Information -->
            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                <!-- User Profile Card -->
                <div class="lg:col-span-1">
                    <div class="p-6 border bg-card-dark border-border-custom rounded-xl">
                        <div class="text-center">
                            <div class="w-24 h-24 mx-auto mb-4 overflow-hidden border-4 border-accent-green rounded-full">
                                @if($user->profile_picture_url)
                    <img src="{{ $user->profile_picture_url }}" class="w-full h-full object-cover" alt="{{ $user->name }}">
                @else
                    <div class="w-full h-full bg-accent-green flex items-center justify-center text-white font-bold text-4xl">
                        {{ $user->initial }}
                    </div>
                @endif
                            </div>
                            <h2 class="mb-2 text-2xl font-bold">{{ $user->name }}</h2>
                            <p class="mb-4 text-text-secondary">{{ $user->email }}</p>
                            
                            @if($user->hasRole('Admin'))
                                <span class="px-3 py-1 text-sm font-medium rounded-full bg-accent-red/20 text-accent-red">Admin</span>
                            @elseif($user->hasRole('Developer'))
                                <span class="px-3 py-1 text-sm font-medium rounded-full bg-accent-green/20 text-accent-green">Developer</span>
                            @elseif($user->hasRole('Client'))
                                <span class="px-3 py-1 text-sm font-medium rounded-full bg-accent-blue/20 text-accent-blue">Client</span>
                            @else
                                <span class="px-3 py-1 text-sm font-medium rounded-full bg-gray-500/20 text-gray-500">No Role</span>
                            @endif
                            
                            <div class="mt-4 pt-4 border-t border-border-custom">
                                <p class="text-sm text-text-secondary">Member since</p>
                                <p class="font-medium">{{ $user->created_at->format('F j, Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Statistics -->
                <div class="lg:col-span-2">
                    <div class="grid grid-cols-2 gap-4 mb-6 md:grid-cols-4">
                        <div class="p-4 border bg-card-dark border-border-custom rounded-xl">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-text-secondary">Projects</p>
                                    <p class="text-2xl font-bold text-accent-blue">{{ $user->projects->count() }}</p>
                                </div>
                                <div class="text-2xl opacity-50 text-accent-blue">
                                    <i class="fas fa-briefcase"></i>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 border bg-card-dark border-border-custom rounded-xl">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-text-secondary">Proposals</p>
                                    <p class="text-2xl font-bold text-accent-green">{{ $user->proposals->count() }}</p>
                                </div>
                                <div class="text-2xl opacity-50 text-accent-green">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 border bg-card-dark border-border-custom rounded-xl">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-text-secondary">Reviews</p>
                                    <p class="text-2xl font-bold text-accent-orange">{{ $user->reviewsWritten->count() + $user->reviewsReceived->count() }}</p>
                                </div>
                                <div class="text-2xl opacity-50 text-accent-orange">
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                        </div>
                        <div class="p-4 border bg-card-dark border-border-custom rounded-xl">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-text-secondary">Payments</p>
                                    <p class="text-2xl font-bold text-accent-green">{{ $user->paymentsMade->count() + $user->paymentsReceived->count() }}</p>
                                </div>
                                <div class="text-2xl opacity-50 text-accent-green">
                                    <i class="fas fa-dollar-sign"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="p-6 border bg-card-dark border-border-custom rounded-xl">
                        <h3 class="mb-4 text-xl font-semibold">Recent Activity</h3>
                        <div class="space-y-4">
                            @if($user->projects->count() > 0)
                                <div class="flex items-start">
                                    <div class="flex items-center justify-center w-10 h-10 mr-3 text-sm rounded-full bg-accent-blue/20 text-accent-blue">
                                        <i class="fas fa-briefcase"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium">Latest project: <span class="text-text-primary">{{ $user->projects->first()->title }}</span></p>
                                        <p class="text-xs text-text-muted">{{ $user->projects->first()->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @endif
                            
                            @if($user->proposals->count() > 0)
                                <div class="flex items-start">
                                    <div class="flex items-center justify-center w-10 h-10 mr-3 text-sm rounded-full bg-accent-green/20 text-accent-green">
                                        <i class="fas fa-file-alt"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium">Latest proposal submitted</p>
                                        <p class="text-xs text-text-muted">{{ $user->proposals->first()->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @endif
                            
                            @if($user->reviewsWritten->count() > 0)
                                <div class="flex items-start">
                                    <div class="flex items-center justify-center w-10 h-10 mr-3 text-sm rounded-full bg-accent-orange/20 text-accent-orange">
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium">Latest review written</p>
                                        <p class="text-xs text-text-muted">{{ $user->reviewsWritten->first()->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            @endif
                            
                            @if($user->projects->count() == 0 && $user->proposals->count() == 0 && $user->reviewsWritten->count() == 0)
                                <div class="text-center text-text-muted py-4">
                                    <i class="text-2xl mb-2 fas fa-info-circle"></i>
                                    <p>No recent activity</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Projects -->
            @if($user->projects->count() > 0)
                <div class="mt-6">
                    <h3 class="mb-4 text-xl font-semibold">User Projects</h3>
                    <div class="overflow-x-auto border bg-card-dark border-border-custom rounded-xl">
                        <table class="w-full text-left whitespace-nowrap">
                            <thead class="bg-secondary-dark">
                                <tr>
                                    <th class="p-4 text-text-muted">Project</th>
                                    <th class="p-4 text-text-muted">Budget</th>
                                    <th class="p-4 text-text-muted">Status</th>
                                    <th class="p-4 text-text-muted">Created</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user->projects->take(5) as $project)
                                    <tr class="border-b border-border-custom">
                                        <td class="p-4 font-medium">{{ $project->title }}</td>
                                        <td class="p-4 text-text-secondary">${{ number_format($project->budget, 2) }}</td>
                                        <td class="p-4">
                                            @switch($project->status)
                                                @case('open')
                                                    <span class="px-2 py-1 text-sm font-medium rounded-full bg-accent-blue/20 text-accent-blue">Open</span>
                                                    @break
                                                @case('in_progress')
                                                    <span class="px-2 py-1 text-sm font-medium rounded-full bg-accent-green/20 text-accent-green">In Progress</span>
                                                    @break
                                                @case('review')
                                                    <span class="px-2 py-1 text-sm font-medium rounded-full bg-accent-orange/20 text-accent-orange">Review</span>
                                                    @break
                                                @case('completed')
                                                    <span class="px-2 py-1 text-sm font-medium rounded-full bg-green-500/20 text-green-500">Completed</span>
                                                    @break
                                                @default
                                                    <span class="px-2 py-1 text-sm font-medium rounded-full bg-gray-500/20 text-gray-500">{{ ucfirst(str_replace('_', ' ', $project->status)) }}</span>
                                            @endswitch
                                        </td>
                                        <td class="p-4 text-text-secondary">{{ $project->created_at->format('Y-m-d') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </main>
    </div>

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
</body>
</html>
