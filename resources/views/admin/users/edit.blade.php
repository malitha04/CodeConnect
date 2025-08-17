<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit User - CodeConnect</title>
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
                <h1 class="text-3xl font-bold">Edit User</h1>
                <a href="{{ route('admin.users.index') }}" class="px-4 py-2 font-medium transition-colors rounded-lg bg-secondary-dark hover:bg-card-dark text-text-primary">
                    <i class="mr-2 fas fa-arrow-left"></i>Back to Users
                </a>
            </div>
                <div class="flex items-center space-x-4">
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
                    <img src="{{ Auth::user()->avatar_url }}" class="w-8 h-8 rounded-full" alt="Admin Profile">
                    <div class="hidden text-sm sm:block">
                        <div class="font-medium">{{ Auth::user()->name }}</div>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="transition text-text-muted hover:text-accent-green">Sign Out</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="relative flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-secondary-dark border-r border-border-custom min-h-screen sticky top-16">
            <div class="p-4">
                <nav class="space-y-2">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 font-medium rounded-lg text-text-secondary hover:text-text-primary hover:bg-card-dark">
                        <i class="mr-3 fas fa-tachometer-alt fa-fw"></i>Dashboard
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-3 font-medium rounded-lg text-accent-green bg-card-dark">
                        <i class="mr-3 fas fa-users fa-fw"></i>Manage Users
                    </a>
                    <a href="{{ route('admin.projects.index') }}" class="flex items-center px-4 py-3 transition rounded-lg text-text-secondary hover:text-text-primary hover:bg-card-dark">
                        <i class="mr-3 fas fa-briefcase fa-fw"></i>Manage Projects
                    </a>
                    <a href="#reports" class="flex items-center px-4 py-3 transition rounded-lg text-text-secondary hover:text-text-primary hover:bg-card-dark">
                        <i class="mr-3 fas fa-chart-line fa-fw"></i>Reports
                    </a>
                    <a href="#" class="flex items-center px-4 py-3 transition rounded-lg text-text-secondary hover:text-text-primary hover:bg-card-dark">
                        <i class="mr-3 fas fa-cog fa-fw"></i>Settings
                    </a>
                </nav>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 p-6 overflow-x-hidden">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-3xl font-bold">Edit User</h1>
                <a href="{{ route('admin.users.index') }}" class="px-4 py-2 font-medium transition-colors rounded-lg bg-secondary-dark hover:bg-card-dark text-text-primary">
                    <i class="mr-2 fas fa-arrow-left"></i>Back to Users
                </a>
            </div>

            <!-- Edit User Form -->
            <div class="max-w-2xl">
                <div class="p-6 border bg-card-dark border-border-custom rounded-xl">
                    <form method="POST" action="{{ route('admin.users.update', $user) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="space-y-6">
                            <!-- User Information -->
                            <div>
                                <h2 class="mb-4 text-xl font-semibold">User Information</h2>
                                
                                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                    <div>
                                        <label for="name" class="block mb-2 text-sm font-medium text-text-secondary">Name</label>
                                        <input 
                                            type="text" 
                                            id="name" 
                                            name="name" 
                                            value="{{ old('name', $user->name) }}"
                                            class="w-full px-3 py-2 border rounded-lg bg-secondary-dark border-border-custom text-text-primary focus:outline-none focus:ring-1 focus:ring-accent-green @error('name') border-red-500 @enderror"
                                            required
                                        >
                                        @error('name')
                                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="email" class="block mb-2 text-sm font-medium text-text-secondary">Email</label>
                                        <input 
                                            type="email" 
                                            id="email" 
                                            name="email" 
                                            value="{{ old('email', $user->email) }}"
                                            class="w-full px-3 py-2 border rounded-lg bg-secondary-dark border-border-custom text-text-primary focus:outline-none focus:ring-1 focus:ring-accent-green @error('email') border-red-500 @enderror"
                                            required
                                        >
                                        @error('email')
                                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Role Assignment -->
                            <div>
                                <h2 class="mb-4 text-xl font-semibold">Role Assignment</h2>
                                
                                <div>
                                    <label for="role" class="block mb-2 text-sm font-medium text-text-secondary">User Role</label>
                                    <select 
                                        id="role" 
                                        name="role" 
                                        class="w-full px-3 py-2 border rounded-lg bg-secondary-dark border-border-custom text-text-primary focus:outline-none focus:ring-1 focus:ring-accent-green @error('role') border-red-500 @enderror"
                                        required
                                    >
                                        <option value="">Select a role</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->name }}" {{ old('role', $user->roles->first()?->name) == $role->name ? 'selected' : '' }}>
                                                {{ ucfirst($role->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('role')
                                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Current User Warning -->
                            @if($user->id === auth()->id())
                                <div class="p-4 border border-yellow-500/20 bg-yellow-500/10 rounded-lg">
                                    <div class="flex items-center">
                                        <i class="mr-2 text-yellow-500 fas fa-exclamation-triangle"></i>
                                        <p class="text-sm text-yellow-400">
                                            <strong>Warning:</strong> You are editing your own account. Be careful with role changes as they may affect your access.
                                        </p>
                                    </div>
                                </div>
                            @endif

                            <!-- User Statistics -->
                            <div>
                                <h2 class="mb-4 text-xl font-semibold">User Statistics</h2>
                                
                                <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
                                    <div class="p-4 border border-border-custom rounded-lg bg-secondary-dark">
                                        <p class="text-sm text-text-secondary">Projects</p>
                                        <p class="text-2xl font-bold text-accent-blue">{{ $user->projects->count() }}</p>
                                    </div>
                                    <div class="p-4 border border-border-custom rounded-lg bg-secondary-dark">
                                        <p class="text-sm text-text-secondary">Proposals</p>
                                        <p class="text-2xl font-bold text-accent-green">{{ $user->proposals->count() }}</p>
                                    </div>
                                    <div class="p-4 border border-border-custom rounded-lg bg-secondary-dark">
                                        <p class="text-sm text-text-secondary">Reviews</p>
                                        <p class="text-2xl font-bold text-accent-orange">{{ $user->reviewsWritten->count() + $user->reviewsReceived->count() }}</p>
                                    </div>
                                    <div class="p-4 border border-border-custom rounded-lg bg-secondary-dark">
                                        <p class="text-sm text-text-secondary">Member Since</p>
                                        <p class="text-lg font-bold text-text-primary">{{ $user->created_at->format('M Y') }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-border-custom">
                                <a href="{{ route('admin.users.index') }}" class="px-6 py-2 font-medium transition-colors rounded-lg bg-secondary-dark hover:bg-card-dark text-text-primary">
                                    Cancel
                                </a>
                                <button type="submit" class="px-6 py-2 font-medium transition-colors rounded-lg bg-accent-green hover:bg-accent-green-hover text-text-primary">
                                    <i class="mr-2 fas fa-save"></i>Update User
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
    // Auto-hide success/error messages after 5 seconds
    setTimeout(() => {
        const messages = document.querySelectorAll('[class*="bg-green-500"], [class*="bg-red-500"]');
        messages.forEach(msg => {
            msg.style.display = 'none';
        });
    }, 5000);
</script>
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
