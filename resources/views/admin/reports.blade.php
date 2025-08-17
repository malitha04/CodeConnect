<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Reports - CodeConnect</title>
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
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8 pb-6 border-b border-border-custom">
            <div>
                <h1 class="text-4xl font-extrabold text-text-primary">Reports & Analytics</h1>
                <p class="text-text-secondary mt-2">System performance and financial insights</p>
            </div>
            <div class="flex items-center space-x-4">
                <span class="text-text-secondary text-sm">
                    <i class="fas fa-chart-line mr-2"></i>
                    Data for {{ date('Y') }}
                </span>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Revenue Chart -->
            <div class="bg-card-dark border border-border-custom rounded-xl p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-semibold text-text-primary">Monthly Revenue</h2>
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 bg-accent-green rounded-full"></div>
                        <span class="text-sm text-text-secondary">Revenue ($)</span>
                    </div>
                </div>
                <div class="relative h-64">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>

            <!-- User Registrations Chart -->
            <div class="bg-card-dark border border-border-custom rounded-xl p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-semibold text-text-primary">User Registrations</h2>
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                        <span class="text-sm text-text-secondary">New Users</span>
                    </div>
                </div>
                <div class="relative h-64">
                    <canvas id="usersChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Recent Transactions Table -->
        <div class="bg-card-dark border border-border-custom rounded-xl overflow-hidden">
            <div class="p-6 border-b border-border-custom flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-text-primary">Recent Transactions</h2>
                    <p class="text-text-secondary mt-1">Latest completed payments</p>
                </div>
                <a href="{{ route('admin.reports.transactions.export') }}" class="px-4 py-2 font-medium transition-colors rounded-lg bg-accent-green hover:bg-accent-green-hover text-white">
                    <i class="mr-2 fas fa-download"></i>Export CSV
                </a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-border-custom">
                    <thead class="bg-secondary-dark">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-text-muted uppercase tracking-wider">
                                Transaction ID
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-text-muted uppercase tracking-wider">
                                Project
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-text-muted uppercase tracking-wider">
                                Client
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-text-muted uppercase tracking-wider">
                                Developer
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-text-muted uppercase tracking-wider">
                                Amount
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-text-muted uppercase tracking-wider">
                                Date
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-text-muted uppercase tracking-wider">
                                Status
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-card-dark divide-y divide-border-custom">
                        @forelse($recentTransactions as $transaction)
                            <tr class="hover:bg-secondary-dark/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-text-primary">
                                    #{{ str_pad($transaction->id, 6, '0', STR_PAD_LEFT) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-text-primary">
                                        {{ Str::limit($transaction->project->title ?? 'N/A', 30) }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 rounded-full bg-accent-green flex items-center justify-center text-white text-xs font-bold mr-3">
                                            {{ $transaction->client->initial ?? 'N' }}
                                        </div>
                                        <div class="text-sm text-text-primary">
                                            {{ $transaction->client->name ?? 'N/A' }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white text-xs font-bold mr-3">
                                            {{ $transaction->developer->initial ?? 'N' }}
                                        </div>
                                        <div class="text-sm text-text-primary">
                                            {{ $transaction->developer->name ?? 'N/A' }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-accent-green">
                                    ${{ number_format($transaction->amount, 2) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-text-secondary">
                                    {{ $transaction->created_at->format('M j, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-500/20 text-green-500">
                                        <i class="fas fa-check-circle mr-1"></i>
                                        Completed
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="text-text-muted">
                                        <i class="fas fa-receipt text-4xl mb-4"></i>
                                        <p class="text-lg">No transactions found</p>
                                        <p class="text-sm">Completed payments will appear here</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
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

            // Initialize Charts
            const revenueCtx = document.getElementById('revenueChart').getContext('2d');
            new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($revenueData['labels']) !!},
                    datasets: [{
                        label: 'Monthly Revenue',
                        data: {!! json_encode($revenueData['data']) !!},
                        borderColor: '#1dbf73',
                        backgroundColor: 'rgba(29, 191, 115, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { labels: { color: '#b5b6ba' } }
                    },
                    scales: {
                        y: { 
                            ticks: { color: '#b5b6ba' },
                            grid: { color: '#404145' }
                        },
                        x: { 
                            ticks: { color: '#b5b6ba' },
                            grid: { color: '#404145' }
                        }
                    }
                }
            });

            const usersCtx = document.getElementById('usersChart').getContext('2d');
            new Chart(usersCtx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($usersData['labels']) !!},
                    datasets: [{
                        label: 'New Users',
                        data: {!! json_encode($usersData['data']) !!},
                        backgroundColor: '#3b82f6',
                        borderColor: '#3b82f6',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { labels: { color: '#b5b6ba' } }
                    },
                    scales: {
                        y: { 
                            ticks: { color: '#b5b6ba' },
                            grid: { color: '#404145' }
                        },
                        x: { 
                            ticks: { color: '#b5b6ba' },
                            grid: { color: '#404145' }
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>
