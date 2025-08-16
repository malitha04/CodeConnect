<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard - CodeConnect</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        
        .page-content { display: none; }
        .page-content.active { display: block; }
        
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
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center text-2xl font-bold text-accent-green">
                        <i class="mr-2 fas fa-code"></i>Code<span class="text-text-primary">Connect</span>
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
            <!-- Dashboard Content -->
            <section id="dashboard" class="page-content active">
                <h1 class="mb-6 text-3xl font-bold">Dashboard</h1>
                <!-- Summary cards -->
                <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-2 lg:grid-cols-4">
                    <div class="p-6 border bg-card-dark border-border-custom rounded-xl">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-text-secondary">Total Users</p>
                                <p class="mt-1 text-3xl font-bold">{{ number_format($totalUsers) }}</p>
                                <p class="text-xs text-text-muted mt-1">
                                    {{ $clientsCount }} Clients • {{ $developersCount }} Developers • {{ $adminsCount }} Admins
                                </p>
                            </div>
                            <div class="text-3xl opacity-50 text-accent-green">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 border bg-card-dark border-border-custom rounded-xl">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-text-secondary">Active Projects</p>
                                <p class="mt-1 text-3xl font-bold">{{ number_format($activeProjects) }}</p>
                                <p class="text-xs text-text-muted mt-1">
                                    {{ $completedProjects }} Completed
                                </p>
                            </div>
                            <div class="text-3xl opacity-50 text-accent-blue">
                                <i class="fas fa-project-diagram"></i>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 border bg-card-dark border-border-custom rounded-xl">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-text-secondary">Total Projects</p>
                                <p class="mt-1 text-3xl font-bold">{{ number_format($totalProjects) }}</p>
                                <p class="text-xs text-text-muted mt-1">
                                    All time projects
                                </p>
                            </div>
                            <div class="text-3xl opacity-50 text-accent-orange">
                                <i class="fas fa-briefcase"></i>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 border bg-card-dark border-border-custom rounded-xl">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-text-secondary">Total Revenue</p>
                                <p class="mt-1 text-3xl font-bold">${{ number_format($totalRevenue, 2) }}</p>
                                <p class="text-xs text-text-muted mt-1">
                                    From completed payments
                                </p>
                            </div>
                            <div class="text-3xl opacity-50 text-accent-green">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity & System Status -->
                <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                    <div class="p-6 border bg-card-dark border-border-custom rounded-xl">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-xl font-semibold">Recent Activity</h2>
                            <a href="#reports" class="text-sm transition text-text-secondary hover:text-accent-green">View All <i class="ml-1 fas fa-arrow-right"></i></a>
                        </div>
                        <ul class="space-y-4">
                            @forelse ($recentActivity->take(5) as $activity)
                                <li class="flex items-start">
                                    <div class="flex items-center justify-center w-10 h-10 mr-3 text-sm rounded-full bg-{{ $activity['color'] }}/20 text-{{ $activity['color'] }}">
                                        <i class="{{ $activity['icon'] }}"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium">{{ $activity['title'] }}</p>
                                        <p class="text-xs text-text-muted">{{ $activity['time'] }}</p>
                                    </div>
                                </li>
                            @empty
                                <li class="text-center text-text-muted py-4">
                                    <p>No recent activity</p>
                                </li>
                            @endforelse
                        </ul>
                    </div>
                    <div class="p-6 border bg-card-dark border-border-custom rounded-xl">
                        <h2 class="mb-4 text-xl font-semibold">System Status</h2>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between text-sm">
                                <p class="text-text-secondary">API Status</p>
                                <p class="font-medium text-green-400">● Operational</p>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <p class="text-text-secondary">Payment Gateway</p>
                                <p class="font-medium text-green-400">● Operational</p>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <p class="text-text-secondary">Database</p>
                                <p class="font-medium text-green-400">● Operational</p>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <p class="text-text-secondary">Total Users</p>
                                <p class="font-medium text-accent-green">{{ number_format($totalUsers) }}</p>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <p class="text-text-secondary">Active Projects</p>
                                <p class="font-medium text-accent-blue">{{ number_format($activeProjects) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
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
