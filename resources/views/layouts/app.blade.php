<!DOCTYPE html>
<html lang="en" style="background:#0f0f0f;">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'CodeConnect - Professional Developer Marketplace')</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
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
          fontFamily: { 'inter': ['Inter', 'sans-serif'] },
          animation: { 'float': 'float 6s ease-in-out infinite', 'fade-in-up': 'fadeInUp 0.6s ease-out forwards' },
          keyframes: {
            float: { '0%, 100%': { transform: 'translateY(0px)' }, '50%': { transform: 'translateY(-20px)' } },
            fadeInUp: { '0%': { opacity: '0', transform: 'translateY(30px)' },'100%': { opacity: '1', transform: 'translateY(0)' } }
          }
        }
      }
    }
  </script>
  <style>
    html { scroll-behavior: smooth; background: #0f0f0f; }
    /* Fallback to prevent flash before Tailwind/Vite CSS applies */
    body { background: #0f0f0f; color: #ffffff; }
  </style>
  <!-- Hotwire Turbo for SPA-like navigation -->
  <script src="https://cdn.jsdelivr.net/npm/@hotwired/turbo@7.3.0/dist/turbo.min.js" data-turbo-track="reload"></script>
</head>
<body class="font-inter bg-primary-dark text-text-primary leading-relaxed" style="background:#0f0f0f;color:#ffffff;">

  <!-- Navbar -->
  <nav class="fixed top-0 w-full bg-primary-dark/95 backdrop-blur-md border-b border-border-custom shadow-lg z-50">
    <div class="container mx-auto px-4">
      <div class="flex items-center justify-between h-16">
        <a href="{{ route('home') }}" class="text-2xl font-bold text-accent-green">
            <i class="fas fa-code mr-2"></i>Code<span class="text-text-primary">Connect</span>
        </a>
        <div class="hidden md:flex items-center space-x-8">
          <a href="{{ route('home') }}#categories" class="text-text-secondary hover:text-text-primary transition-colors duration-300">Categories</a>
          <a href="{{ route('home') }}#developers" class="text-text-secondary hover:text-text-primary transition-colors duration-300">Find Developers</a>
          <a href="{{ route('home') }}#projects" class="text-text-secondary hover:text-text-primary transition-colors duration-300">Browse Projects</a>
          <a href="{{ route('about') }}" class="text-text-secondary hover:text-text-primary transition-colors duration-300">About</a>
          <a href="{{ route('contact') }}" class="text-text-secondary hover:text-text-primary transition-colors duration-300">Contact</a>
        </div>
        <div class="hidden md:flex items-center space-x-4">
          {{-- THIS IS THE CORRECTED SECTION --}}
          @auth
            <a href="{{ route('dashboard') }}" class="text-text-secondary hover:text-text-primary transition-colors duration-300">Dashboard</a>
          @else
            <a href="{{ route('login') }}" class="text-text-secondary hover:text-text-primary transition-colors duration-300">Sign In</a>
            <a href="{{ route('register') }}" class="bg-accent-green hover:bg-accent-green-hover text-white px-6 py-2 rounded-lg font-semibold transition-all duration-300 hover:-translate-y-1">Join Now</a>
          @endauth
        </div>
        <button class="md:hidden text-text-primary" onclick="toggleMobileMenu()">
          <i class="fas fa-bars text-xl"></i>
        </button>
      </div>
      <div id="mobileMenu" class="md:hidden hidden bg-secondary-dark rounded-lg mt-2 p-4 border border-border-custom">
        <a href="{{ route('home') }}#categories" class="block py-2 text-text-secondary hover:text-accent-green transition-colors">Categories</a>
        <a href="{{ route('home') }}#developers" class="block py-2 text-text-secondary hover:text-accent-green transition-colors">Find Developers</a>
        <a href="{{ route('home') }}#projects" class="block py-2 text-text-secondary hover:text-accent-green transition-colors">Browse Projects</a>
        <a href="{{ route('about') }}" class="block py-2 text-text-secondary hover:text-accent-green transition-colors">About</a>
        <a href="{{ route('contact') }}" class="block py-2 text-text-secondary hover:text-accent-green transition-colors">Contact</a>
        <hr class="my-4 border-border-custom">
        {{-- THIS IS THE CORRECTED MOBILE SECTION --}}
        @auth
            <a href="{{ route('dashboard') }}" class="block py-2 text-text-secondary hover:text-accent-green transition-colors">Dashboard</a>
        @else
            <a href="{{ route('login') }}" class="block py-2 text-text-secondary hover:text-accent-green transition-colors">Sign In</a>
            <a href="{{ route('register') }}" class="block mt-2 bg-accent-green text-white px-4 py-2 rounded-lg text-center font-semibold">Join Now</a>
        @endauth
      </div>
    </div>
  </nav>

  <!-- Main Content Area -->
  <main>
    @yield('content')
  </main>

  <!-- Footer -->
  <footer class="bg-primary-darker border-t border-border-custom py-12">
    <div class="container mx-auto px-4">
      <div class="grid md:grid-cols-4 gap-8">
        <div>
          <a href="{{ route('home') }}" class="text-2xl font-bold text-accent-green"><i class="fas fa-code mr-2"></i>Code<span class="text-text-primary">Connect</span></a>
          <p class="text-text-secondary mt-4">The premier marketplace for top-tier developers.</p>
        </div>
        <div>
          <h4 class="text-lg font-semibold mb-4">For Clients</h4>
          <ul class="space-y-2 text-text-secondary">
            <li><a href="{{ route('home') }}#developers" class="hover:text-accent-green transition-colors">Find Developers</a></li>
            <li><a href="{{ route('home') }}#projects" class="hover:text-accent-green transition-colors">Post a Project</a></li>
          </ul>
        </div>
        <div>
          <h4 class="text-lg font-semibold mb-4">For Developers</h4>
          <ul class="space-y-2 text-text-secondary">
            <li><a href="{{ route('home') }}#projects" class="hover:text-accent-green transition-colors">Find Projects</a></li>
            <li><a href="{{ route('register') }}" class="hover:text-accent-green transition-colors">Create Profile</a></li>
          </ul>
        </div>
        <div>
          <h4 class="text-lg font-semibold mb-4">Company</h4>
          <ul class="space-y-2 text-text-secondary">
            <li><a href="{{ route('about') }}" class="hover:text-accent-green transition-colors">About Us</a></li>
            <li><a href="{{ route('contact') }}" class="hover:text-accent-green transition-colors">Contact</a></li>
            <li><a href="{{ route('privacy') }}" class="hover:text-accent-green transition-colors">Privacy Policy</a></li>
          </ul>
        </div>
      </div>
      <div class="mt-8 border-t border-border-custom pt-6 text-center text-text-secondary text-sm">
        <p>&copy; {{ date('Y') }} CodeConnect. All rights reserved.</p>
      </div>
    </div>
  </footer>

  <!-- Cookie Consent -->
  @include('components.cookie-consent')

  <script>
    function toggleMobileMenu() {
      document.getElementById('mobileMenu').classList.toggle('hidden');
    }
  </script>
  <script src="{{ asset('js/cookie-manager.js') }}"></script>
</body>
</html>
