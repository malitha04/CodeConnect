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
        /* Custom scrollbar for a better dark mode experience */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #1a1a1a; }
        ::-webkit-scrollbar-thumb { background: #404145; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #555; }
        
        /* General layout styles */
        .page-content { 
            display: none !important; 
        }
        .page-content.active { 
            display: block !important; 
        }
        
        /* Mobile menu toggle button */
        #mobile-menu-btn { display: block; }
        
        /* Sidebar responsive styles */
        @media (min-width: 768px) {
            #sidebar {
                display: block !important;
                transform: translateX(0) !important;
                position: sticky !important;
                top: 64px !important;
            }
            #mobile-menu-btn { display: none; }
        }
        
        /* Specific mobile menu transition */
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
                    <a href="{{ route('dashboard') }}" class="flex items-center text-2xl font-bold text-accent-green">
                        <i class="mr-2 fas fa-code"></i>Code<span class="text-text-primary">Connect</span>
                    </a>
                </div>
                <div class="flex items-center space-x-4">
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
                    <a href="#dashboard" class="flex items-center px-4 py-3 font-medium rounded-lg nav-link text-text-secondary hover:text-text-primary hover:bg-card-dark active">
                        <i class="mr-3 fas fa-tachometer-alt fa-fw"></i>Dashboard
                    </a>
                    <a href="#manage-users" class="flex items-center px-4 py-3 transition rounded-lg nav-link text-text-secondary hover:text-text-primary hover:bg-card-dark">
                        <i class="mr-3 fas fa-users fa-fw"></i>Manage Users
                    </a>
                    <a href="#manage-projects" class="flex items-center px-4 py-3 transition rounded-lg nav-link text-text-secondary hover:text-text-primary hover:bg-card-dark">
                        <i class="mr-3 fas fa-briefcase fa-fw"></i>Manage Projects
                    </a>
                    <a href="#reports" class="flex items-center px-4 py-3 transition rounded-lg nav-link text-text-secondary hover:text-text-primary hover:bg-card-dark">
                        <i class="mr-3 fas fa-chart-line fa-fw"></i>Reports
                    </a>
                    <a href="#contacts" class="flex items-center px-4 py-3 transition rounded-lg nav-link text-text-secondary hover:text-text-primary hover:bg-card-dark">
                        <i class="mr-3 fas fa-envelope fa-fw"></i>Contact Messages
                    </a>
                    <a href="#settings" class="flex items-center px-4 py-3 transition rounded-lg nav-link text-text-secondary hover:text-text-primary hover:bg-card-dark">
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
                                <p class="mt-1 text-xs text-text-muted">
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
                                <p class="mt-1 text-xs text-text-muted">
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
                                <p class="mt-1 text-xs text-text-muted">
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
                                <p class="mt-1 text-xs text-text-muted">
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
                                <li class="py-4 text-center text-text-muted">
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

            <!-- Manage Users Content -->
            <section id="manage-users" class="page-content">
                <h1 class="mb-6 text-3xl font-bold">Manage Users</h1>
                <!-- Search and Filters -->
                <div class="flex flex-col items-center justify-between p-4 mb-6 border bg-card-dark border-border-custom rounded-xl sm:flex-row">
                    <div class="relative w-full sm:w-1/2">
                        <input type="text" placeholder="Search users..." class="w-full py-2 pl-10 pr-4 border rounded-lg bg-secondary-dark border-border-custom text-text-primary focus:outline-none focus:ring-1 focus:ring-accent-green">
                        <i class="absolute -translate-y-1/2 fas fa-search left-3 top-1/2 text-text-secondary"></i>
                    </div>
                    <div class="mt-4 sm:mt-0 sm:ml-4">
                        <button class="px-4 py-2 font-medium transition-colors rounded-lg bg-accent-green hover:bg-accent-green-hover text-text-primary">
                            <i class="mr-2 fas fa-plus"></i>Add New User
                        </button>
                    </div>
                </div>
                <!-- User Table -->
                <div class="overflow-x-auto border bg-card-dark border-border-custom rounded-xl">
                    <table class="w-full text-left whitespace-nowrap">
                        <thead class="bg-secondary-dark">
                            <tr>
                                <th class="p-4 text-text-muted">User ID</th>
                                <th class="p-4 text-text-muted">User Name</th>
                                <th class="p-4 text-text-muted">Email</th>
                                <th class="p-4 text-text-muted">Role</th>
                                <th class="p-4 text-text-muted">Status</th>
                                <th class="p-4 text-text-muted">Registered On</th>
                                <th class="p-4 text-center text-text-muted">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentUsers as $user)
                                <tr class="border-b border-border-custom">
                                    <td class="p-4 text-text-muted">#{{ $user->id }}</td>
                                    <td class="p-4 font-medium">{{ $user->name }}</td>
                                    <td class="p-4 text-text-secondary">{{ $user->email }}</td>
                                    <td class="p-4">
                                        @if($user->hasRole('Admin'))
                                            <span class="px-2 py-1 text-sm font-medium rounded-full bg-accent-red/20 text-accent-red">Admin</span>
                                        @elseif($user->hasRole('Developer'))
                                            <span class="px-2 py-1 text-sm font-medium rounded-full bg-accent-green/20 text-accent-green">Developer</span>
                                        @elseif($user->hasRole('Client'))
                                            <span class="px-2 py-1 text-sm font-medium rounded-full bg-accent-blue/20 text-accent-blue">Client</span>
                                        @else
                                            <span class="px-2 py-1 text-sm font-medium text-gray-500 rounded-full bg-gray-500/20">No Role</span>
                                        @endif
                                    </td>
                                    <td class="p-4"><span class="text-green-500">● Active</span></td>
                                    <td class="p-4 text-text-secondary">{{ $user->created_at->format('Y-m-d') }}</td>
                                    <td class="p-4 text-center">
                                        <button class="p-2 text-accent-blue hover:text-blue-400" title="View Details"><i class="fas fa-eye"></i></button>
                                        <button class="p-2 text-accent-orange hover:text-orange-400" title="Edit User"><i class="fas fa-pencil-alt"></i></button>
                                        <button class="p-2 text-accent-red hover:text-red-400" title="Delete User"><i class="fas fa-trash-alt"></i></button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-4 text-center text-text-muted">No users found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                <div class="flex items-center justify-between mt-6">
                    <p class="text-sm text-text-muted">Showing {{ $recentUsers->count() }} of {{ $totalUsers }} users</p>
                    <div class="flex items-center gap-2">
                        <button class="px-4 py-2 font-bold rounded-lg bg-secondary-dark hover:bg-border-custom text-text-secondary">&laquo; Prev</button>
                        <button class="px-4 py-2 font-bold rounded-lg bg-secondary-dark hover:bg-border-custom text-text-secondary">Next &raquo;</button>
                    </div>
                </div>
            </section>

            <!-- Manage Projects Content -->
            <section id="manage-projects" class="page-content">
                <h1 class="mb-6 text-3xl font-bold">Manage Projects</h1>
                <!-- Search and Filters -->
                <div class="flex flex-col items-center justify-between p-4 mb-6 border bg-card-dark border-border-custom rounded-xl sm:flex-row">
                    <div class="relative w-full sm:w-1/2">
                        <input type="text" placeholder="Search projects..." class="w-full py-2 pl-10 pr-4 border rounded-lg bg-secondary-dark border-border-custom text-text-primary focus:outline-none focus:ring-1 focus:ring-accent-green">
                        <i class="absolute -translate-y-1/2 fas fa-search left-3 top-1/2 text-text-secondary"></i>
                    </div>
                </div>
                <!-- Projects Table -->
                <div class="overflow-x-auto border bg-card-dark border-border-custom rounded-xl">
                    <table class="min-w-full text-left whitespace-nowrap">
                        <thead class="bg-secondary-dark">
                            <tr>
                                <th class="p-4 text-text-muted">Project ID</th>
                                <th class="p-4 text-text-muted">Project Title</th>
                                <th class="p-4 text-text-muted">Client Name</th>
                                <th class="p-4 text-text-muted">Budget</th>
                                <th class="p-4 text-text-muted">Status</th>
                                <th class="p-4 text-text-muted">Posted On</th>
                                <th class="p-4 text-center text-text-muted">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentProjects as $project)
                                <tr class="border-b border-border-custom">
                                    <td class="p-4 text-text-muted">#{{ $project->id }}</td>
                                    <td class="p-4 font-medium">{{ $project->title }}</td>
                                    <td class="p-4 text-text-secondary">{{ $project->user->name }}</td>
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
                                                <span class="px-2 py-1 text-sm font-medium text-green-500 rounded-full bg-green-500/20">Completed</span>
                                                @break
                                            @default
                                                <span class="px-2 py-1 text-sm font-medium text-gray-500 rounded-full bg-gray-500/20">{{ ucfirst(str_replace('_', ' ', $project->status)) }}</span>
                                        @endswitch
                                    </td>
                                    <td class="p-4 text-text-secondary">{{ $project->created_at->format('Y-m-d') }}</td>
                                    <td class="p-4 text-center">
                                        <button class="p-2 text-accent-blue hover:text-blue-400" title="View Details"><i class="fas fa-eye"></i></button>
                                        <button class="p-2 text-accent-red hover:text-red-400" title="Remove Project"><i class="fas fa-trash-alt"></i></button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-4 text-center text-text-muted">No projects found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                <div class="flex items-center justify-between mt-6">
                    <p class="text-sm text-text-muted">Showing {{ $recentProjects->count() }} of {{ $totalProjects }} projects</p>
                    <div class="flex items-center gap-2">
                        <button class="px-4 py-2 font-bold rounded-lg bg-secondary-dark hover:bg-border-custom text-text-secondary">&laquo; Prev</button>
                        <button class="px-4 py-2 font-bold rounded-lg bg-secondary-dark hover:bg-border-custom text-text-secondary">Next &raquo;</button>
                    </div>
                </div>
            </section>

            <!-- Reports Content -->
            <section id="reports" class="page-content">
                <h1 class="mb-6 text-3xl font-bold">Reports</h1>
                <div class="grid grid-cols-1 gap-6 mb-6 lg:grid-cols-2">
                    <div class="p-6 border bg-card-dark border-border-custom rounded-xl">
                        <h2 class="mb-4 text-xl font-semibold">Quarterly Revenue</h2>
                        <canvas id="revenueChart"></canvas>
                    </div>
                    <div class="p-6 border bg-card-dark border-border-custom rounded-xl">
                        <h2 class="mb-4 text-xl font-semibold">User Sign-ups</h2>
                        <canvas id="usersChart"></canvas>
                    </div>
                </div>
                <!-- Transactions Table -->
                <div class="p-6 overflow-x-auto border bg-card-dark border-border-custom rounded-xl">
                    <h2 class="mb-4 text-xl font-semibold">Recent Transactions</h2>
                    <table class="min-w-full text-left whitespace-nowrap">
                        <thead class="bg-secondary-dark">
                            <tr>
                                <th class="p-4 text-text-muted">Transaction ID</th>
                                <th class="p-4 text-text-muted">Project Name</th>
                                <th class="p-4 text-text-muted">Amount</th>
                                <th class="p-4 text-text-muted">Date</th>
                                <th class="p-4 text-text-muted">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentPayments as $payment)
                                <tr class="border-b border-border-custom">
                                    <td class="p-4 text-text-muted">#{{ $payment->id }}</td>
                                    <td class="p-4 font-medium">{{ $payment->project->title }}</td>
                                    <td class="p-4 text-accent-green">+${{ number_format($payment->amount, 2) }}</td>
                                    <td class="p-4 text-text-secondary">{{ $payment->paid_at ? $payment->paid_at->format('Y-m-d') : $payment->created_at->format('Y-m-d') }}</td>
                                    <td class="p-4"><span class="px-2 py-1 text-xs font-medium text-green-500 rounded-full bg-green-600/20">{{ ucfirst($payment->status) }}</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-4 text-center text-text-muted">No transactions found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

            <!-- Contacts Content -->
            <section id="contacts" class="page-content">
                <h1 class="mb-6 text-3xl font-bold">Contact Messages</h1>
                
                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-4">
                    <div class="p-6 border bg-card-dark border-border-custom rounded-xl">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-text-secondary">Total Messages</p>
                                <p class="mt-1 text-3xl font-bold">{{ $totalContacts ?? 0 }}</p>
                            </div>
                            <div class="text-3xl opacity-50 text-accent-green">
                                <i class="fas fa-envelope"></i>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 border bg-card-dark border-border-custom rounded-xl">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-text-secondary">Unread</p>
                                <p class="mt-1 text-3xl font-bold">{{ $unreadContacts ?? 0 }}</p>
                            </div>
                            <div class="text-3xl text-red-500 opacity-50">
                                <i class="fas fa-exclamation-circle"></i>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 border bg-card-dark border-border-custom rounded-xl">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-text-secondary">Read</p>
                                <p class="mt-1 text-3xl font-bold">{{ $readContacts ?? 0 }}</p>
                            </div>
                            <div class="text-3xl text-yellow-500 opacity-50">
                                <i class="fas fa-eye"></i>
                            </div>
                        </div>
                    </div>
                    <div class="p-6 border bg-card-dark border-border-custom rounded-xl">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-text-secondary">Replied</p>
                                <p class="mt-1 text-3xl font-bold">{{ $repliedContacts ?? 0 }}</p>
                            </div>
                            <div class="text-3xl text-green-500 opacity-50">
                                <i class="fas fa-reply"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Messages Table -->
                <div class="p-6 overflow-x-auto border bg-card-dark border-border-custom rounded-xl">
                    <h2 class="mb-4 text-xl font-semibold">Recent Messages</h2>
                    <table class="min-w-full text-left whitespace-nowrap">
                        <thead class="bg-secondary-dark">
                            <tr>
                                <th class="p-4 text-text-muted">Name</th>
                                <th class="p-4 text-text-muted">Email</th>
                                <th class="p-4 text-text-muted">Subject</th>
                                <th class="p-4 text-text-muted">Status</th>
                                <th class="p-4 text-text-muted">Date</th>
                                <th class="p-4 text-text-muted">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentContacts ?? [] as $contact)
                                <tr class="border-b border-border-custom">
                                    <td class="p-4 font-medium">{{ $contact->name }}</td>
                                    <td class="p-4 text-text-secondary">{{ $contact->email }}</td>
                                    <td class="p-4">{{ Str::limit($contact->subject, 50) }}</td>
                                    <td class="p-4">
                                        <span class="px-2 py-1 text-xs font-medium rounded-full {{ $contact->status_badge_class }}">
                                            {{ $contact->status_display }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-text-secondary">{{ $contact->created_at->format('M d, Y') }}</td>
                                    <td class="p-4">
                                        <a href="{{ route('admin.contacts.show', $contact) }}" class="transition-colors text-accent-green hover:text-accent-green-hover">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-4 text-center text-text-muted">No contact messages found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    
                    @if(($recentContacts ?? collect())->count() > 0)
                        <div class="mt-4 text-center">
                            <a href="{{ route('admin.contacts.index') }}" class="text-sm text-accent-green hover:text-accent-green-hover">
                                View All Messages <i class="ml-1 fas fa-arrow-right"></i>
                            </a>
                        </div>
                    @endif
                </div>
            </section>

            <!-- Settings Content -->
            <section id="settings" class="page-content">
                <h1 class="mb-6 text-3xl font-bold">Admin Settings</h1>
                
                <!-- System Settings -->
                <div class="grid grid-cols-1 gap-6 mb-8 lg:grid-cols-2">
                    <!-- General Settings -->
                    <div class="p-6 border bg-card-dark border-border-custom rounded-xl">
                        <h2 class="mb-4 text-xl font-semibold">General Settings</h2>
                        <div class="space-y-4">
                            <div>
                                <label class="block mb-2 text-sm font-medium text-text-secondary">Site Name</label>
                                <input type="text" value="CodeConnect" class="w-full px-4 py-2 border rounded-lg bg-secondary-dark border-border-custom text-text-primary focus:outline-none focus:ring-2 focus:ring-accent-green">
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-text-secondary">Site Description</label>
                                <textarea class="w-full px-4 py-2 border rounded-lg bg-secondary-dark border-border-custom text-text-primary focus:outline-none focus:ring-2 focus:ring-accent-green" rows="3">Connect with talented developers and clients worldwide</textarea>
                            </div>
                            <div>
                                <label class="block mb-2 text-sm font-medium text-text-secondary">Contact Email</label>
                                <input type="email" value="admin@codeconnect.com" class="w-full px-4 py-2 border rounded-lg bg-secondary-dark border-border-custom text-text-primary focus:outline-none focus:ring-2 focus:ring-accent-green">
                            </div>
                        </div>
                    </div>

                    <!-- Security Settings -->
                    <div class="p-6 border bg-card-dark border-border-custom rounded-xl">
                        <h2 class="mb-4 text-xl font-semibold">Security Settings</h2>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-text-secondary">Two-Factor Authentication</span>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" class="sr-only peer" checked>
                                    <div class="w-11 h-6 bg-secondary-dark peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-accent-green/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-accent-green"></div>
                                </label>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-text-secondary">Session Timeout (minutes)</span>
                                <input type="number" value="30" min="15" max="120" class="w-20 px-3 py-2 border rounded-lg bg-secondary-dark border-border-custom text-text-primary focus:outline-none focus:ring-2 focus:ring-accent-green">
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-text-secondary">Login Attempts Limit</span>
                                <input type="number" value="5" min="3" max="10" class="w-20 px-3 py-2 border rounded-lg bg-secondary-dark border-border-custom text-text-primary focus:outline-none focus:ring-2 focus:ring-accent-green">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Management Settings -->
                <div class="p-6 mb-8 border bg-card-dark border-border-custom rounded-xl">
                    <h2 class="mb-4 text-xl font-semibold">User Management</h2>
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-text-secondary">Default User Role</label>
                            <select class="w-full px-4 py-2 border rounded-lg bg-secondary-dark border-border-custom text-text-primary focus:outline-none focus:ring-2 focus:ring-accent-green">
                                <option value="client">Client</option>
                                <option value="developer">Developer</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-text-secondary">Email Verification Required</label>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-secondary-dark peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-accent-green/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-accent-green"></div>
                            </label>
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-text-secondary">Auto-approve Users</label>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer">
                                <div class="w-11 h-6 bg-secondary-dark peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-accent-green/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-accent-green"></div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Payment Settings -->
                <div class="p-6 mb-8 border bg-card-dark border-border-custom rounded-xl">
                    <h2 class="mb-4 text-xl font-semibold">Payment & Commission</h2>
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div>
                            <label class="block mb-2 text-sm font-medium text-text-secondary">Platform Commission (%)</label>
                            <input type="number" value="10" min="0" max="25" step="0.5" class="w-full px-4 py-2 border rounded-lg bg-secondary-dark border-border-custom text-text-primary focus:outline-none focus:ring-2 focus:ring-accent-green">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-text-secondary">Minimum Withdrawal Amount</label>
                            <input type="number" value="50" min="10" step="5" class="w-full px-4 py-2 border rounded-lg bg-secondary-dark border-border-custom text-text-primary focus:outline-none focus:ring-2 focus:ring-accent-green">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-text-secondary">Payment Processing Fee (%)</label>
                            <input type="number" value="2.9" min="0" max="10" step="0.1" class="w-full px-4 py-2 border rounded-lg bg-secondary-dark border-border-custom text-text-primary focus:outline-none focus:ring-2 focus:ring-accent-green">
                        </div>
                        <div>
                            <label class="block mb-2 text-sm font-medium text-text-secondary">Auto-release Funds (days)</label>
                            <input type="number" value="14" min="1" max="30" class="w-full px-4 py-2 border rounded-lg bg-secondary-dark border-border-custom text-text-primary focus:outline-none focus:ring-2 focus:ring-accent-green">
                        </div>
                    </div>
                </div>

                <!-- Notification Settings -->
                <div class="p-6 mb-8 border bg-card-dark border-border-custom rounded-xl">
                    <h2 class="mb-4 text-xl font-semibold">Notification Preferences</h2>
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-text-secondary">New User Registrations</span>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-secondary-dark peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-accent-green/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-accent-green"></div>
                            </label>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-text-secondary">Payment Notifications</span>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-secondary-dark peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-accent-green/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-accent-green"></div>
                            </label>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-text-secondary">System Alerts</span>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-secondary-dark peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-accent-green/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-accent-green"></div>
                            </label>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-text-secondary">Weekly Reports</span>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer">
                                <div class="w-11 h-6 bg-secondary-dark peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-accent-green/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-accent-green"></div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end space-x-4">
                    <button class="px-6 py-3 font-medium transition-colors border rounded-lg bg-secondary-dark hover:bg-card-dark text-text-primary border-border-custom">
                        Reset to Defaults
                    </button>
                    <button class="px-6 py-3 font-medium text-white transition-colors rounded-lg bg-accent-green hover:bg-accent-green-hover">
                        Save Changes
                    </button>
                </div>
            </section>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            console.log('DOM loaded, initializing admin dashboard...');
            
            const navLinks = document.querySelectorAll('.nav-link');
            const pageContents = document.querySelectorAll('.page-content');
            const mobileMenuBtn = document.getElementById('mobile-menu-btn');
            const sidebar = document.getElementById('sidebar');
            
            console.log('Found nav links:', navLinks.length);
            console.log('Found page contents:', pageContents.length);
            console.log('Mobile menu button found:', !!mobileMenuBtn);
            console.log('Sidebar found:', !!sidebar);
            
            // Log all nav links for debugging
            navLinks.forEach((link, index) => {
                console.log(`Nav link ${index}:`, link.getAttribute('href'), link.textContent.trim());
            });
            
            // Log all page contents for debugging
            pageContents.forEach((content, index) => {
                console.log(`Page content ${index}:`, content.id, content.className);
            });
            
            // Test if elements exist
            alert('Found ' + navLinks.length + ' nav links and ' + pageContents.length + ' page contents');
            
            // Test if settings section exists
            const settingsSection = document.getElementById('settings');
            alert('Settings section found: ' + !!settingsSection);
            
            // Chart instances to avoid re-initialization
            let revenueChart = null;
            let usersChart = null;

            // Function to initialize charts
            function initializeCharts() {
                try {
                    console.log('initializeCharts function called');
                    const revenueCtx = document.getElementById('revenueChart');
                    const usersCtx = document.getElementById('usersChart');
                    
                    console.log('Revenue canvas found:', !!revenueCtx);
                    console.log('Users canvas found:', !!usersCtx);
                    console.log('Charts already initialized:', !!revenueChart, !!usersChart);
                    
                    if (revenueCtx && usersCtx && !revenueChart && !usersChart) {
                        console.log('Initializing new charts...');
                        const commonChartOptions = {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { display: false },
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grid: { color: 'rgba(255, 255, 255, 0.1)' },
                                    ticks: { color: 'rgba(255, 255, 255, 0.7)' }
                                },
                                x: {
                                    grid: { color: 'rgba(255, 255, 255, 0.1)' },
                                    ticks: { color: 'rgba(255, 255, 255, 0.7)' }
                                }
                            }
                        };

                        revenueChart = new Chart(revenueCtx.getContext('2d'), {
                            type: 'bar',
                            data: {
                                labels: ['Q1', 'Q2', 'Q3', 'Q4'],
                                datasets: [{
                                    label: 'Revenue',
                                    data: [1.5, 1.8, 2.1, 2.3],
                                    backgroundColor: '#1dbf73',
                                }]
                            },
                            options: commonChartOptions
                        });
                        console.log('Revenue chart initialized');

                        usersChart = new Chart(usersCtx.getContext('2d'), {
                            type: 'line',
                            data: {
                                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug'],
                                datasets: [{
                                    label: 'New Users',
                                    data: [1200, 1500, 1450, 1700, 1850, 2100, 2300, 2456],
                                    borderColor: '#3b82f6',
                                    tension: 0.1,
                                    fill: false
                                }]
                            },
                            options: commonChartOptions
                        });
                        console.log('Users chart initialized');
                    } else {
                        console.log('Charts not initialized - conditions not met');
                    }
                } catch (error) {
                    console.error('Error initializing charts:', error);
                }
            }

            // Handle navigation clicks
            navLinks.forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    
                    alert('Navigation clicked: ' + link.getAttribute('href')); // Simple test
                    console.log('Navigation clicked:', link.getAttribute('href'));
                    
                    // Remove active class from all links
                    navLinks.forEach(nav => nav.classList.remove('text-accent-green', 'bg-card-dark'));
                    
                    // Add active class to the clicked link
                    link.classList.add('text-accent-green', 'bg-card-dark');

                    // Hide all content sections
                    pageContents.forEach(content => content.classList.remove('active'));

                    // Show the target content section
                    const targetId = link.getAttribute('href').substring(1);
                    const targetSection = document.getElementById(targetId);
                    
                    console.log('Target ID:', targetId);
                    console.log('Target section found:', !!targetSection);
                    
                    if (targetSection) {
                        targetSection.classList.add('active');
                        console.log('Section activated:', targetId);
                        
                        // Initialize charts if reports section is shown
                        if (targetId === 'reports') {
                            console.log('Initializing charts for reports section');
                            // Small delay to ensure DOM is ready
                            setTimeout(() => {
                                initializeCharts();
                            }, 100);
                        }
                    } else {
                        console.error('Target section not found:', targetId);
                    }

                    // Close mobile sidebar on link click
                    if (window.innerWidth < 768) {
                        sidebar.classList.remove('mobile-open');
                    }
                });
            });

            // Handle mobile menu toggle
            mobileMenuBtn.addEventListener('click', () => {
                sidebar.classList.toggle('mobile-open');
            });
            
            // Initial check for hash in URL and display corresponding content
            const hash = window.location.hash;
            if (hash) {
                const targetId = hash.substring(1);
                const targetLink = document.querySelector(`.nav-link[href="${hash}"]`);
                if (targetLink) {
                    // Remove default active state
                    const activeLink = document.querySelector('.nav-link.active');
                    const activeContent = document.querySelector('.page-content.active');
                    
                    if (activeLink) {
                        activeLink.classList.remove('active', 'text-accent-green', 'bg-card-dark');
                    }
                    if (activeContent) {
                        activeContent.classList.remove('active');
                    }
                    
                    // Set new active state
                    targetLink.classList.add('active', 'text-accent-green', 'bg-card-dark');
                    const targetSection = document.getElementById(targetId);
                    if (targetSection) {
                        targetSection.classList.add('active');
                        
                        // Initialize charts if reports section is shown
                        if (targetId === 'reports') {
                            setTimeout(() => {
                                initializeCharts();
                            }, 100);
                        }
                    }
                }
            }

            // Initialize charts if dashboard loads with reports section active
            if (window.location.hash === '#reports') {
                setTimeout(() => {
                    initializeCharts();
                }, 100);
            }
            

        });
    </script>
</body>
</html>
