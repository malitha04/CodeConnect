<!DOCTYPE html>
<html lang="en" style="background:#0f0f0f;">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title') - CodeConnect</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: {
              dark: '#1a1a1a',
              darker: '#0f0f0f'
            },
            secondary: {
              dark: '#2a2a2a'
            },
            card: {
              dark: '#333333'
            },
            accent: {
              green: '#1dbf73',
              'green-hover': '#19a463',
              orange: '#ff7640'
            },
            text: {
              primary: '#ffffff',
              secondary: '#b5b6ba',
              muted: '#8a8a8a'
            },
            border: {
              custom: '#404145'
            }
          },
          fontFamily: {
            'inter': ['Inter', 'sans-serif']
          }
        }
      }
    }
  </script>
  <style>
    html { background: #0f0f0f; }
    /* Fallback to prevent flash before Tailwind/Vite CSS applies */
    body { background: #0f0f0f; color: #ffffff; }
    /* Turbo progress bar - match dark theme */
    .turbo-progress-bar { background: #1dbf73; height: 3px; }
  </style>
  <!-- Hotwire Turbo for SPA-like navigation -->
  <script src="https://cdn.jsdelivr.net/npm/@hotwired/turbo@7.3.0/dist/turbo.min.js" data-turbo-track="reload"></script>
  <style>
    /* Smooth fade for main content during Turbo visits */
    #dashboard-content { transition: opacity 150ms ease; }
    .turbo-loading #dashboard-content { opacity: 0; }
  </style>
</head>
<body class="font-inter bg-primary-dark text-text-primary" style="background:#0f0f0f;color:#ffffff;">

  <!-- Top Navigation -->
  <nav id="dashboard-topnav" data-turbo-permanent class="bg-primary-darker border-b border-border-custom">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center h-16">
        <div class="flex items-center">
          <a href="{{ route('home') }}" class="text-2xl font-bold text-accent-green">
            <i class="fas fa-code mr-2"></i>Code<span class="text-text-primary">Connect</span>
          </a>
        </div>
        <!-- Right section: notification + avatar dropdown aligned to far right -->
        <div class="hidden md:flex items-center gap-6 ms-auto">
          <x-notifications-dropdown />

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
              <x-dropdown-link :href="route('settings.index')">
                {{ __('Settings') }}
              </x-dropdown-link>
              <x-dropdown-link :href="route('profile.edit')">
                {{ __('Profile') }}
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

  <div class="flex">
    <!-- Sidebar -->
    <div id="dashboard-sidebar" data-turbo-permanent class="w-64 bg-secondary-dark border-r border-border-custom min-h-screen">
      <div class="p-4">
        <nav class="space-y-2">
          <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 rounded-lg transition-colors text-text-secondary hover:text-text-primary hover:bg-card-dark {{ request()->routeIs('dashboard') ? 'text-accent-green bg-card-dark' : '' }}">
            <i class="fas fa-tachometer-alt mr-3"></i>Dashboard
          </a>

          {{-- Conditional Sidebar for Clients --}}
          @if (Auth::user()->hasRole('Client'))
            <a href="{{ route('projects.create') }}" class="flex items-center px-4 py-3 rounded-lg transition-colors text-text-secondary hover:text-text-primary hover:bg-card-dark {{ request()->routeIs('projects.create') ? 'text-accent-green bg-card-dark' : '' }}">
              <i class="fas fa-plus mr-3"></i>Post a Project
            </a>
            <a href="{{ route('projects.index') }}" class="flex items-center px-4 py-3 rounded-lg transition-colors text-text-secondary hover:text-text-primary hover:bg-card-dark {{ request()->routeIs('projects.index') ? 'text-accent-green bg-card-dark' : '' }}">
              <i class="fas fa-briefcase mr-3"></i>My Projects
            </a>
            <a href="{{ route('hires.index') }}" class="flex items-center px-4 py-3 rounded-lg transition-colors text-text-secondary hover:text-text-primary hover:bg-card-dark {{ request()->routeIs('hires.index') ? 'text-accent-green bg-card-dark' : '' }}">
              <i class="fas fa-user-tie mr-3"></i>Hires
            </a>
          @endif

          {{-- Conditional Sidebar for Developers --}}
          @if (Auth::user()->hasRole('Developer'))
            <a href="{{ route('projects.browse') }}" class="flex items-center px-4 py-3 rounded-lg transition-colors text-text-secondary hover:text-text-primary hover:bg-card-dark {{ request()->routeIs('projects.browse') ? 'text-accent-green bg-card-dark' : '' }}">
              <i class="fas fa-search mr-3"></i>Browse Projects
            </a>
            <a href="{{ route('proposals.index_developer') }}" class="flex items-center px-4 py-3 rounded-lg transition-colors text-text-secondary hover:text-text-primary hover:bg-card-dark {{ request()->routeIs('proposals.index_developer') ? 'text-accent-green bg-card-dark' : '' }}">
              <i class="fas fa-file-alt mr-3"></i>My Proposals
            </a>
          @endif

          {{-- Links for both roles --}}
          <a href="{{ route('inbox.index') }}" class="flex items-center px-4 py-3 rounded-lg transition-colors text-text-secondary hover:text-text-primary hover:bg-card-dark {{ request()->routeIs('inbox.*') ? 'text-accent-green bg-card-dark' : '' }}">
            <i class="fas fa-envelope mr-3"></i>Messages
          </a>
          @if (Auth::user()->hasRole('Developer'))
            <a href="{{ route('reviews.received') }}" class="flex items-center px-4 py-3 rounded-lg transition-colors text-text-secondary hover:text-text-primary hover:bg-card-dark {{ request()->routeIs('reviews.received') ? 'text-accent-green bg-card-dark' : '' }}">
              <i class="fas fa-star mr-3"></i>Reviews
            </a>
          @elseif (Auth::user()->hasRole('Client'))
            <a href="{{ route('reviews.my-reviews') }}" class="flex items-center px-4 py-3 rounded-lg transition-colors text-text-secondary hover:text-text-primary hover:bg-card-dark {{ request()->routeIs('reviews.my-reviews') ? 'text-accent-green bg-card-dark' : '' }}">
              <i class="fas fa-star mr-3"></i>Reviews
            </a>
          @else
            <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 rounded-lg transition-colors text-text-secondary hover:text-text-primary hover:bg-card-dark {{ request()->routeIs('reviews.*') ? 'text-accent-green bg-card-dark' : '' }}">
              <i class="fas fa-star mr-3"></i>Reviews
            </a>
          @endif
          @if (Auth::user()->hasRole('Developer'))
            <a href="{{ route('payments.received') }}" class="flex items-center px-4 py-3 rounded-lg transition-colors text-text-secondary hover:text-text-primary hover:bg-card-dark {{ request()->routeIs('payments.received') ? 'text-accent-green bg-card-dark' : '' }}">
              <i class="fas fa-wallet mr-3"></i>Payments
            </a>
          @elseif (Auth::user()->hasRole('Client'))
            <a href="{{ route('payments.my-payments') }}" class="flex items-center px-4 py-3 rounded-lg transition-colors text-text-secondary hover:text-text-primary hover:bg-card-dark {{ request()->routeIs('payments.my-payments') ? 'text-accent-green bg-card-dark' : '' }}">
              <i class="fas fa-wallet mr-3"></i>Payments
            </a>
          @else
            <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 rounded-lg transition-colors text-text-secondary hover:text-text-primary hover:bg-card-dark {{ request()->routeIs('payments.*') ? 'text-accent-green bg-card-dark' : '' }}">
              <i class="fas fa-wallet mr-3"></i>Payments
            </a>
          @endif
          <a href="{{ route('settings.index') }}" class="flex items-center px-4 py-3 rounded-lg transition-colors text-text-secondary hover:text-text-primary hover:bg-card-dark {{ request()->routeIs('settings.*') ? 'text-accent-green bg-card-dark' : '' }}">
            <i class="fas fa-cog mr-3"></i>Settings
          </a>
        </nav>
      </div>
    </div>

    <!-- Main Content -->
    <div id="dashboard-content" class="flex-1 p-8">
      @yield('content')
    </div>
  </div>

  <script>
    // Toggle a class to fade content during Turbo visits
    document.addEventListener('turbo:visit', () => {
      document.documentElement.classList.add('turbo-loading');
    });
    document.addEventListener('turbo:load', () => {
      document.documentElement.classList.remove('turbo-loading');
    });
  </script>
  @stack('scripts')
</body>
</html>
