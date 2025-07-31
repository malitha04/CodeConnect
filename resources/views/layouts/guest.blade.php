<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
        
        <script src="https://cdn.tailwindcss.com"></script>
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
                  animation: { 'fade-in-up': 'fadeInUp 0.6s ease-out forwards' },
                  keyframes: {
                    fadeInUp: {
                      '0%': { opacity: '0', transform: 'translateY(30px)' },
                      '100%': { opacity: '1', transform: 'translateY(0)' }
                    }
                  }
                }
              }
            }
        </script>
        
        {{-- THIS IS THE CRUCIAL FIX --}}
        <style>
            .account-type-btn.active {
                border-color: #1dbf73;
                background-color: rgba(29, 191, 115, 0.1);
            }
        </style>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-inter bg-primary-dark text-text-primary flex flex-col min-h-screen">
        <nav class="fixed top-0 w-full bg-primary-dark/95 backdrop-blur-md border-b border-border-custom shadow-lg z-50">
            <div class="container mx-auto px-4">
                <div class="flex items-center justify-between h-16">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-accent-green">
                        <i class="fas fa-code mr-2"></i>Code<span class="text-text-primary">Connect</span>
                    </a>
                </div>
            </div>
        </nav>

        <main class="flex-grow flex items-center justify-center py-12 px-4 mt-16">
            {{ $slot }}
        </main>

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
                  </ul>
                </div>
              </div>
              <div class="mt-8 border-t border-border-custom pt-6 text-center text-text-secondary text-sm">
                <p>&copy; {{ date('Y') }} CodeConnect. All rights reserved.</p>
              </div>
            </div>
        </footer>
    </body>
</html>
