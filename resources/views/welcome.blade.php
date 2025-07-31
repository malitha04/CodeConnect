@extends('layouts.app')

@section('title', 'CodeConnect - Professional Developer Marketplace')

@section('content')

  <!-- Hero Section -->
  <section id="hero" class="pt-24 pb-16 bg-gradient-to-br from-primary-dark via-secondary-dark to-primary-dark relative overflow-hidden">
    <!-- Background Effects -->
    <div class="absolute inset-0 bg-gradient-radial from-accent-green/10 via-transparent to-transparent opacity-50"></div>
    <div class="absolute top-20 right-20 w-72 h-72 bg-accent-orange/5 rounded-full blur-3xl"></div>
    <div class="absolute bottom-20 left-20 w-96 h-96 bg-accent-green/5 rounded-full blur-3xl"></div>

    <div class="container mx-auto px-4 relative z-10">
      <div class="grid lg:grid-cols-2 gap-12 items-center">
        <div class="space-y-8">
          <h1 class="text-5xl lg:text-6xl font-bold leading-tight">
            Find the perfect <span class="text-accent-green">developer</span> for your project
          </h1>
          <p class="text-xl text-text-secondary max-w-2xl">
            Your marketplace for top-tier freelance developers. Get projects done, faster.
          </p>

          <!-- Search Bar -->
          <div class="bg-white rounded-xl p-2 flex flex-col sm:flex-row gap-2 shadow-2xl max-w-2xl">
            <input 
              type="text" 
              placeholder="e.g., React developer, AI chatbot..."
              class="flex-1 px-4 py-3 text-gray-800 rounded-lg outline-none"
            >
            <button class="bg-accent-green hover:bg-accent-green-hover text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 flex items-center justify-center">
              <i class="fas fa-search mr-2"></i>Search
            </button>
          </div>

          <!-- Action Buttons -->
          <div class="flex flex-col sm:flex-row gap-4">
            <a href="{{ route('register') }}" class="bg-accent-green hover:bg-accent-green-hover text-white px-8 py-4 rounded-lg font-semibold transition-all duration-300 hover:-translate-y-1 text-center">
              <i class="fas fa-user-plus mr-2"></i>Join as Developer
            </a>
            <a href="#projects" class="border-2 border-accent-green text-accent-green hover:bg-accent-green hover:text-white px-8 py-4 rounded-lg font-semibold transition-all duration-300 hover:-translate-y-1 text-center">
              <i class="fas fa-plus mr-2"></i>Post a Project
            </a>
          </div>
        </div>

        <div class="text-center">
          <img 
            src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=600&h=400&fit=crop" 
            alt="Developers working" 
            class="rounded-2xl shadow-2xl max-w-full h-auto animate-float"
          >
        </div>
      </div>
    </div>
  </section>

  <!-- Stats Section -->
  <section class="py-16 bg-card-dark border-t border-b border-border-custom">
    <div class="container mx-auto px-4">
      <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
        <div class="text-center">
          <div class="text-4xl font-bold text-accent-green mb-2">2M+</div>
          <div class="text-text-secondary font-medium">Active Developers</div>
        </div>
        <div class="text-center">
          <div class="text-4xl font-bold text-accent-green mb-2">500K+</div>
          <div class="text-text-secondary font-medium">Projects Completed</div>
        </div>
        <div class="text-center">
          <div class="text-4xl font-bold text-accent-green mb-2">98%</div>
          <div class="text-text-secondary font-medium">Client Satisfaction</div>
        </div>
        <div class="text-center">
          <div class="text-4xl font-bold text-accent-green mb-2">24/7</div>
          <div class="text-text-secondary font-medium">Support Available</div>
        </div>
      </div>
    </div>
  </section>

  <!-- Categories Section -->
  <section id="categories" class="py-16 bg-secondary-dark">
    <div class="container mx-auto px-4">
      <h2 class="text-4xl font-bold text-center mb-12">Popular Categories</h2>
      <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-card-dark border border-border-custom rounded-xl p-8 text-center group hover:border-accent-green hover:-translate-y-2 transition-all duration-300 hover:shadow-2xl">
          <div class="w-16 h-16 bg-accent-green rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
            <i class="fas fa-globe text-2xl text-white"></i>
          </div>
          <h5 class="text-xl font-semibold mb-2">Web Development</h5>
          <p class="text-text-secondary">Full-stack, frontend & backend.</p>
        </div>

        <div class="bg-card-dark border border-border-custom rounded-xl p-8 text-center group hover:border-accent-green hover:-translate-y-2 transition-all duration-300 hover:shadow-2xl">
          <div class="w-16 h-16 bg-accent-green rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
            <i class="fas fa-mobile-alt text-2xl text-white"></i>
          </div>
          <h5 class="text-xl font-semibold mb-2">Mobile Apps</h5>
          <p class="text-text-secondary">iOS, Android, and cross-platform.</p>
        </div>

        <div class="bg-card-dark border border-border-custom rounded-xl p-8 text-center group hover:border-accent-green hover:-translate-y-2 transition-all duration-300 hover:shadow-2xl">
          <div class="w-16 h-16 bg-accent-green rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
            <i class="fas fa-brain text-2xl text-white"></i>
          </div>
          <h5 class="text-xl font-semibold mb-2">AI & ML</h5>
          <p class="text-text-secondary">Data science, machine learning & AI.</p>
        </div>

        <div class="bg-card-dark border border-border-custom rounded-xl p-8 text-center group hover:border-accent-green hover:-translate-y-2 transition-all duration-300 hover:shadow-2xl">
          <div class="w-16 h-16 bg-accent-green rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
            <i class="fas fa-link text-2xl text-white"></i>
          </div>
          <h5 class="text-xl font-semibold mb-2">Blockchain</h5>
          <p class="text-text-secondary">Smart contracts, DeFi & Web3.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Top Developers Section -->
  <section id="developers" class="py-16">
    <div class="container mx-auto px-4">
      <h2 class="text-4xl font-bold text-center mb-12">Top Rated Developers</h2>
      <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
        <!-- Developer Card 1 -->
        <div class="bg-card-dark border border-border-custom rounded-xl overflow-hidden group hover:border-accent-green hover:-translate-y-2 transition-all duration-300 hover:shadow-2xl">
          <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400&h=200&fit=crop&crop=face" alt="Developer" class="w-full h-48 object-cover">
          <div class="p-6">
            <div class="flex justify-between items-start">
              <h5 class="text-xl font-semibold mb-1">Alex Chen</h5>
              <span class="bg-accent-green text-white px-3 py-1 rounded-full text-sm font-medium">Pro</span>
            </div>
            <p class="text-text-secondary mb-4">Full Stack | React, Node.js</p>
            <div class="flex justify-between items-center">
                <div class="text-yellow-400 font-semibold">
                    <i class="fas fa-star"></i> 4.9 (127 reviews)
                </div>
                <span class="text-accent-green font-bold text-lg">From $50/hr</span>
            </div>
             <a href="#" class="mt-4 block w-full text-center bg-accent-green hover:bg-accent-green-hover text-white px-4 py-2 rounded-lg font-medium transition-colors duration-300">
                View Profile
              </a>
          </div>
        </div>

        <!-- Developer Card 2 -->
        <div class="bg-card-dark border border-border-custom rounded-xl overflow-hidden group hover:border-accent-green hover:-translate-y-2 transition-all duration-300 hover:shadow-2xl">
          <img src="https://images.unsplash.com/photo-1494790108755-2616b332c1cf?w=400&h=200&fit=crop&crop=face" alt="Developer" class="w-full h-48 object-cover">
          <div class="p-6">
             <div class="flex justify-between items-start">
                <h5 class="text-xl font-semibold mb-1">Sarah Kim</h5>
                <span class="bg-accent-green text-white px-3 py-1 rounded-full text-sm font-medium">Expert</span>
            </div>
            <p class="text-text-secondary mb-4">AI/ML Engineer | TensorFlow</p>
            <div class="flex justify-between items-center">
              <div class="text-yellow-400 font-semibold">
                <i class="fas fa-star"></i> 4.8 (89 reviews)
              </div>
              <span class="text-accent-green font-bold text-lg">From $75/hr</span>
            </div>
            <a href="#" class="mt-4 block w-full text-center bg-accent-green hover:bg-accent-green-hover text-white px-4 py-2 rounded-lg font-medium transition-colors duration-300">
                View Profile
            </a>
          </div>
        </div>

        <!-- Developer Card 3 -->
        <div class="bg-card-dark border border-border-custom rounded-xl overflow-hidden group hover:border-accent-green hover:-translate-y-2 transition-all duration-300 hover:shadow-2xl">
          <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=400&h=200&fit=crop&crop=face" alt="Developer" class="w-full h-48 object-cover">
          <div class="p-6">
            <div class="flex justify-between items-start">
                <h5 class="text-xl font-semibold mb-1">Marcus Johnson</h5>
                <span class="bg-accent-green text-white px-3 py-1 rounded-full text-sm font-medium">Top Rated</span>
            </div>
            <p class="text-text-secondary mb-4">Blockchain Dev | Solidity, Web3</p>
            <div class="flex justify-between items-center">
              <div class="text-yellow-400 font-semibold">
                <i class="fas fa-star"></i> 5.0 (156 reviews)
              </div>
              <span class="text-accent-green font-bold text-lg">From $90/hr</span>
            </div>
            <a href="#" class="mt-4 block w-full text-center bg-accent-green hover:bg-accent-green-hover text-white px-4 py-2 rounded-lg font-medium transition-colors duration-300">
                View Profile
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Featured Projects Section -->
  <section id="projects" class="py-16 bg-secondary-dark">
    <div class="container mx-auto px-4">
      <h2 class="text-4xl font-bold text-center mb-12">Featured Projects</h2>
      <div class="grid lg:grid-cols-2 gap-8">
        <!-- Project Card 1 -->
        <div class="bg-card-dark border border-border-custom rounded-xl p-6 group hover:border-accent-green hover:translate-x-2 transition-all duration-300 hover:shadow-xl flex flex-col">
          <div class="flex-grow">
            <div class="flex justify-between items-start mb-4">
              <h5 class="text-xl font-semibold w-3/4">E-commerce Platform Development</h5>
              <span class="text-accent-green font-bold text-xl text-right">$5k - $8k</span>
            </div>
            <p class="text-text-secondary mb-6">
              Seeking an expert to build a modern e-commerce site with React and Node.js.
            </p>
          </div>
          <div class="flex justify-between items-center">
            <div class="text-text-muted text-sm">
              <i class="fas fa-clock mr-1"></i> 2h ago
              <span class="ml-4"><i class="fas fa-user mr-1"></i> 12 proposals</span>
            </div>
            <a href="#" class="bg-accent-green hover:bg-accent-green-hover text-white px-6 py-2 rounded-lg font-medium transition-colors duration-300 whitespace-nowrap">
              Apply Now
            </a>
          </div>
        </div>

        <!-- Project Card 2 -->
        <div class="bg-card-dark border border-border-custom rounded-xl p-6 group hover:border-accent-green hover:translate-x-2 transition-all duration-300 hover:shadow-xl flex flex-col">
          <div class="flex-grow">
            <div class="flex justify-between items-start mb-4">
              <h5 class="text-xl font-semibold w-3/4">AI Chatbot for Customer Service</h5>
              <span class="text-accent-green font-bold text-xl text-right">$3k - $6k</span>
            </div>
            <p class="text-text-secondary mb-6">
              Need an AI specialist to build an intelligent NLP chatbot for customer support.
            </p>
          </div>
          <div class="flex justify-between items-center">
            <div class="text-text-muted text-sm">
              <i class="fas fa-clock mr-1"></i> 4h ago
              <span class="ml-4"><i class="fas fa-user mr-1"></i> 8 proposals</span>
            </div>
            <a href="#" class="bg-accent-green hover:bg-accent-green-hover text-white px-6 py-2 rounded-lg font-medium transition-colors duration-300 whitespace-nowrap">
              Apply Now
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection
