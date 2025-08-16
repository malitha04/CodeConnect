<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title') - CodeConnect</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
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
</head>
<body class="font-inter bg-primary-dark text-text-primary">

  <!-- Top Navigation -->
  <nav class="bg-primary-darker border-b border-border-custom">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-16">
        <div class="flex items-center">
          <a href="../index.html" class="text-2xl font-bold text-accent-green">
            <i class="fas fa-code mr-2"></i>Code<span class="text-text-primary">Connect</span>
          </a>
        </div>
        <div class="flex items-center space-x-4">
          <button class="text-text-secondary hover:text-text-primary relative">
            <i class="fas fa-bell text-lg"></i>
            <span class="absolute -top-2 -right-2 bg-accent-orange text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">3</span>
          </button>
          <div class="flex items-center space-x-3">
            <!-- User Name and Role -->
            <img src="{{ Auth::user()->avatar_url }}" alt="Profile" class="w-8 h-8 rounded-full">
            <div class="text-sm">
              <div class="font-medium">{{ Auth::user()->name }}</div>
              <div class="text-text-muted">{{ Auth::user()->getRoleNames()->first() }}</div>
            </div>
            <!-- Logout form -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-text-muted hover:text-accent-green transition">Sign Out</button>
            </form>
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
          <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-text-secondary hover:text-text-primary hover:bg-card-dark rounded-lg transition-colors">
            <i class="fas fa-tachometer-alt mr-3"></i>Dashboard
          </a>

          {{-- Conditional Sidebar for Clients --}}
          @if (Auth::user()->hasRole('Client'))
            <a href="{{ route('projects.create') }}" class="flex items-center px-4 py-3 text-text-secondary hover:text-text-primary hover:bg-card-dark rounded-lg transition-colors">
              <i class="fas fa-plus mr-3"></i>Post a Project
            </a>
            <a href="{{ route('projects.index') }}" class="flex items-center px-4 py-3 text-text-secondary hover:text-text-primary hover:bg-card-dark rounded-lg transition-colors">
              <i class="fas fa-briefcase mr-3"></i>My Projects
            </a>
            <a href="{{ route('hires.index') }}" class="flex items-center px-4 py-3 text-text-secondary hover:text-text-primary hover:bg-card-dark rounded-lg transition-colors">
              <i class="fas fa-user-tie mr-3"></i>Hires
            </a>
          @endif

          {{-- Conditional Sidebar for Developers --}}
          @if (Auth::user()->hasRole('Developer'))
            <a href="{{ route('projects.browse') }}" class="flex items-center px-4 py-3 text-text-secondary hover:text-text-primary hover:bg-card-dark rounded-lg transition-colors">
              <i class="fas fa-search mr-3"></i>Browse Projects
            </a>
            <a href="{{ route('proposals.index_developer') }}" class="flex items-center px-4 py-3 text-text-secondary hover:text-text-primary hover:bg-card-dark rounded-lg transition-colors">
              <i class="fas fa-file-alt mr-3"></i>My Proposals
            </a>
          @endif

          {{-- Links for both roles --}}
          <a href="{{ route('inbox.index') }}" class="flex items-center px-4 py-3 text-text-secondary hover:text-text-primary hover:bg-card-dark rounded-lg transition-colors">
            <i class="fas fa-envelope mr-3"></i>Messages
          </a>
          @if (Auth::user()->hasRole('Developer'))
            <a href="{{ route('reviews.received') }}" class="flex items-center px-4 py-3 text-text-secondary hover:text-text-primary hover:bg-card-dark rounded-lg transition-colors">
              <i class="fas fa-star mr-3"></i>Reviews
            </a>
          @elseif (Auth::user()->hasRole('Client'))
            <a href="{{ route('reviews.my-reviews') }}" class="flex items-center px-4 py-3 text-text-secondary hover:text-text-primary hover:bg-card-dark rounded-lg transition-colors">
              <i class="fas fa-star mr-3"></i>Reviews
            </a>
          @else
            <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-text-secondary hover:text-text-primary hover:bg-card-dark rounded-lg transition-colors">
              <i class="fas fa-star mr-3"></i>Reviews
            </a>
          @endif
          @if (Auth::user()->hasRole('Developer'))
            <a href="{{ route('payments.received') }}" class="flex items-center px-4 py-3 text-text-secondary hover:text-text-primary hover:bg-card-dark rounded-lg transition-colors">
              <i class="fas fa-wallet mr-3"></i>Payments
            </a>
          @elseif (Auth::user()->hasRole('Client'))
            <a href="{{ route('payments.my-payments') }}" class="flex items-center px-4 py-3 text-text-secondary hover:text-text-primary hover:bg-card-dark rounded-lg transition-colors">
              <i class="fas fa-wallet mr-3"></i>Payments
            </a>
          @else
            <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-text-secondary hover:text-text-primary hover:bg-card-dark rounded-lg transition-colors">
              <i class="fas fa-wallet mr-3"></i>Payments
            </a>
          @endif
          <a href="{{ route('settings.index') }}" class="flex items-center px-4 py-3 text-text-secondary hover:text-text-primary hover:bg-card-dark rounded-lg transition-colors">
            <i class="fas fa-cog mr-3"></i>Settings
          </a>
        </nav>
      </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 p-8">
      @yield('content')
    </div>
  </div>

  @stack('scripts')
</body>
</html>
