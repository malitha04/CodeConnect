<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Settings - CodeConnect</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
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
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 font-medium rounded-lg nav-link text-text-secondary hover:text-text-primary hover:bg-card-dark">
                        <i class="mr-3 fas fa-tachometer-alt fa-fw"></i>Dashboard
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-3 transition rounded-lg nav-link text-text-secondary hover:text-text-primary hover:bg-card-dark">
                        <i class="mr-3 fas fa-users fa-fw"></i>Manage Users
                    </a>
                    <a href="{{ route('admin.projects.index') }}" class="flex items-center px-4 py-3 transition rounded-lg nav-link text-text-secondary hover:text-text-primary hover:bg-card-dark">
                        <i class="mr-3 fas fa-briefcase fa-fw"></i>Manage Projects
                    </a>
                    <a href="{{ route('admin.reports') }}" class="flex items-center px-4 py-3 transition rounded-lg nav-link text-text-secondary hover:text-text-primary hover:bg-card-dark">
                        <i class="mr-3 fas fa-chart-line fa-fw"></i>Reports
                    </a>
                    <a href="{{ route('admin.contacts.index') }}" class="flex items-center px-4 py-3 transition rounded-lg nav-link text-text-secondary hover:text-text-primary hover:bg-card-dark {{ request()->routeIs('admin.contacts.*') ? 'text-accent-green bg-card-dark' : '' }}">
                        <i class="mr-3 fas fa-envelope fa-fw"></i>Contact Messages
                    </a>
                    <a href="{{ route('admin.settings') }}" class="flex items-center px-4 py-3 transition rounded-lg nav-link text-accent-green bg-card-dark">
                        <i class="mr-3 fas fa-cog fa-fw"></i>Settings
                    </a>
                </nav>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 p-6 overflow-x-hidden">
            <div class="max-w-4xl mx-auto">
                <h1 class="mb-6 text-3xl font-bold">Admin Settings</h1>
                
                <!-- Settings Sections -->
                <div class="space-y-6">
                    <!-- System Configuration -->
                    <div class="p-6 border bg-card-dark border-border-custom rounded-xl">
                        <h2 class="text-xl font-semibold mb-4">System Configuration</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-text-secondary mb-2">Site Name</label>
                                <input type="text" value="CodeConnect" class="w-full px-3 py-2 bg-secondary-dark border border-border-custom rounded-lg text-text-primary focus:outline-none focus:ring-1 focus:ring-accent-green">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-text-secondary mb-2">Site URL</label>
                                <input type="url" value="{{ config('app.url') }}" class="w-full px-3 py-2 bg-secondary-dark border border-border-custom rounded-lg text-text-primary focus:outline-none focus:ring-1 focus:ring-accent-green">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-text-secondary mb-2">Admin Email</label>
                                <input type="email" value="{{ Auth::user()->email }}" class="w-full px-3 py-2 bg-secondary-dark border border-border-custom rounded-lg text-text-primary focus:outline-none focus:ring-1 focus:ring-accent-green">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-text-secondary mb-2">Timezone</label>
                                <select class="w-full px-3 py-2 bg-secondary-dark border border-border-custom rounded-lg text-text-primary focus:outline-none focus:ring-1 focus:ring-accent-green">
                                    <option>UTC</option>
                                    <option selected>Asia/Kolkata</option>
                                    <option>America/New_York</option>
                                    <option>Europe/London</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Settings -->
                    <div class="p-6 border bg-card-dark border-border-custom rounded-xl">
                        <h2 class="text-xl font-semibold mb-4">Payment Settings</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-text-secondary mb-2">Commission Rate (%)</label>
                                <input type="number" value="10" min="0" max="100" class="w-full px-3 py-2 bg-secondary-dark border border-border-custom rounded-lg text-text-primary focus:outline-none focus:ring-1 focus:ring-accent-green">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-text-secondary mb-2">Minimum Withdrawal</label>
                                <input type="number" value="50" min="1" class="w-full px-3 py-2 bg-secondary-dark border border-border-custom rounded-lg text-text-primary focus:outline-none focus:ring-1 focus:ring-accent-green">
                            </div>
                            <div class="md:col-span-2">
                                <label class="flex items-center">
                                    <input type="checkbox" checked class="mr-2 text-accent-green bg-secondary-dark border-border-custom rounded focus:ring-accent-green">
                                    <span class="text-text-secondary">Enable Stripe Payments</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Email Settings -->
                    <div class="p-6 border bg-card-dark border-border-custom rounded-xl">
                        <h2 class="text-xl font-semibold mb-4">Email Settings</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-text-secondary mb-2">SMTP Host</label>
                                <input type="text" placeholder="smtp.gmail.com" class="w-full px-3 py-2 bg-secondary-dark border border-border-custom rounded-lg text-text-primary focus:outline-none focus:ring-1 focus:ring-accent-green">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-text-secondary mb-2">SMTP Port</label>
                                <input type="number" value="587" class="w-full px-3 py-2 bg-secondary-dark border border-border-custom rounded-lg text-text-primary focus:outline-none focus:ring-1 focus:ring-accent-green">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-text-secondary mb-2">SMTP Username</label>
                                <input type="email" placeholder="your-email@gmail.com" class="w-full px-3 py-2 bg-secondary-dark border border-border-custom rounded-lg text-text-primary focus:outline-none focus:ring-1 focus:ring-accent-green">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-text-secondary mb-2">SMTP Password</label>
                                <input type="password" placeholder="••••••••" class="w-full px-3 py-2 bg-secondary-dark border border-border-custom rounded-lg text-text-primary focus:outline-none focus:ring-1 focus:ring-accent-green">
                            </div>
                        </div>
                    </div>

                    <!-- Security Settings -->
                    <div class="p-6 border bg-card-dark border-border-custom rounded-xl">
                        <h2 class="text-xl font-semibold mb-4">Security Settings</h2>
                        <div class="space-y-4">
                            <label class="flex items-center">
                                <input type="checkbox" checked class="mr-2 text-accent-green bg-secondary-dark border-border-custom rounded focus:ring-accent-green">
                                <span class="text-text-secondary">Require email verification for new users</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" class="mr-2 text-accent-green bg-secondary-dark border-border-custom rounded focus:ring-accent-green">
                                <span class="text-text-secondary">Enable two-factor authentication</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" checked class="mr-2 text-accent-green bg-secondary-dark border-border-custom rounded focus:ring-accent-green">
                                <span class="text-text-secondary">Log admin activities</span>
                            </label>
                        </div>
                    </div>

                    <!-- Save Button -->
                    <div class="flex justify-end">
                        <button type="button" class="px-6 py-3 bg-accent-green hover:bg-accent-green-hover text-white font-medium rounded-lg transition-colors">
                            <i class="fas fa-save mr-2"></i>Save Settings
                        </button>
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
        });
    </script>
</body>
</html>
