@extends('layouts.dashboard')

@section('title', 'Developer Dashboard')

@section('content')
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold">Welcome back, {{ Auth::user()->name }}!</h1>
        <p class="text-text-secondary mt-2">Here's what's happening with your freelance business today.</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        {{-- These would be populated with real data later --}}
        <div class="bg-card-dark border border-border-custom rounded-xl p-6">
            <p class="text-text-secondary text-sm">Active Projects</p>
            <p class="text-2xl font-bold text-accent-green">3</p>
        </div>
        <div class="bg-card-dark border border-border-custom rounded-xl p-6">
            <p class="text-text-secondary text-sm">Pending Proposals</p>
            <p class="text-2xl font-bold text-accent-orange">7</p>
        </div>
        <div class="bg-card-dark border border-border-custom rounded-xl p-6">
            <p class="text-text-secondary text-sm">This Month Earnings</p>
            <p class="text-2xl font-bold text-text-primary">$4,250</p>
        </div>
        <div class="bg-card-dark border border-border-custom rounded-xl p-6">
            <p class="text-text-secondary text-sm">Rating</p>
            <p class="text-2xl font-bold text-yellow-400">4.9</p>
        </div>
    </div>
 <!-- Main Content Grid -->
 <div class="grid lg:grid-cols-3 gap-8">
        <!-- Left Column -->
        <div class="lg:col-span-2 space-y-8">
          <!-- Recent Projects -->
          <div class="bg-card-dark border border-border-custom rounded-xl p-6">
            <div class="flex items-center justify-between mb-6">
              <h2 class="text-xl font-semibold">Active Projects</h2>
              <a href="#" class="text-accent-green hover:text-accent-green-hover text-sm">View All</a>
            </div>
            <div class="space-y-4">
              <div class="border border-border-custom rounded-lg p-4 hover:border-accent-green transition-colors">
                <div class="flex items-start justify-between">
                  <div class="flex-1">
                    <h3 class="font-semibold mb-2">E-commerce Platform Development</h3>
                    <p class="text-text-secondary text-sm mb-3">Building a modern e-commerce platform with React, Node.js, and payment integration.</p>
                    <div class="flex items-center text-sm text-text-muted">
                      <span class="mr-4"><i class="fas fa-calendar mr-1"></i>Due: Dec 15, 2024</span>
                      <span class="mr-4"><i class="fas fa-dollar-sign mr-1"></i>$5,000</span>
                      <span class="bg-accent-green/20 text-accent-green px-2 py-1 rounded-full text-xs">In Progress</span>
                    </div>
                  </div>
                  <div class="ml-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-accent-green to-accent-green-hover rounded-lg flex items-center justify-center">
                      <i class="fas fa-shopping-cart text-white"></i>
                    </div>
                  </div>
                </div>
              </div>

              <div class="border border-border-custom rounded-lg p-4 hover:border-accent-green transition-colors">
                <div class="flex items-start justify-between">
                  <div class="flex-1">
                    <h3 class="font-semibold mb-2">AI Chatbot Development</h3>
                    <p class="text-text-secondary text-sm mb-3">Creating an intelligent chatbot using Python and natural language processing.</p>
                    <div class="flex items-center text-sm text-text-muted">
                      <span class="mr-4"><i class="fas fa-calendar mr-1"></i>Due: Dec 20, 2024</span>
                      <span class="mr-4"><i class="fas fa-dollar-sign mr-1"></i>$3,500</span>
                      <span class="bg-yellow-400/20 text-yellow-400 px-2 py-1 rounded-full text-xs">Review</span>
                    </div>
                  </div>
                  <div class="ml-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                      <i class="fas fa-robot text-white"></i>
                    </div>
                  </div>
                </div>
              </div>

              <div class="border border-border-custom rounded-lg p-4 hover:border-accent-green transition-colors">
                <div class="flex items-start justify-between">
                  <div class="flex-1">
                    <h3 class="font-semibold mb-2">Mobile App UI/UX Design</h3>
                    <p class="text-text-secondary text-sm mb-3">Designing user interface and experience for a fitness tracking mobile application.</p>
                    <div class="flex items-center text-sm text-text-muted">
                      <span class="mr-4"><i class="fas fa-calendar mr-1"></i>Due: Dec 10, 2024</span>
                      <span class="mr-4"><i class="fas fa-dollar-sign mr-1"></i>$2,800</span>
                      <span class="bg-orange-500/20 text-orange-500 px-2 py-1 rounded-full text-xs">Starting</span>
                    </div>
                  </div>
                  <div class="ml-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center">
                      <i class="fas fa-mobile-alt text-white"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Recent Proposals -->
          <div class="bg-card-dark border border-border-custom rounded-xl p-6">
            <div class="flex items-center justify-between mb-6">
              <h2 class="text-xl font-semibold">Recent Proposals</h2>
              <a href="#" class="text-accent-green hover:text-accent-green-hover text-sm">View All</a>
            </div>
            <div class="space-y-4">
              <div class="border border-border-custom rounded-lg p-4">
                <div class="flex items-start justify-between">
                  <div class="flex-1">
                    <h3 class="font-semibold mb-2">React Native App Development</h3>
                    <p class="text-text-secondary text-sm mb-3">Cross-platform mobile app for social media management...</p>
                    <div class="flex items-center text-sm text-text-muted">
                      <span class="mr-4"><i class="fas fa-clock mr-1"></i>Submitted 2 hours ago</span>
                      <span class="mr-4"><i class="fas fa-dollar-sign mr-1"></i>$4,200</span>
                      <span class="bg-blue-500/20 text-blue-500 px-2 py-1 rounded-full text-xs">Pending</span>
                    </div>
                  </div>
                </div>
              </div>

              <div class="border border-border-custom rounded-lg p-4">
                <div class="flex items-start justify-between">
                  <div class="flex-1">
                    <h3 class="font-semibold mb-2">WordPress Plugin Development</h3>
                    <p class="text-text-secondary text-sm mb-3">Custom WordPress plugin for inventory management system...</p>
                    <div class="flex items-center text-sm text-text-muted">
                      <span class="mr-4"><i class="fas fa-clock mr-1"></i>Submitted 1 day ago</span>
                      <span class="mr-4"><i class="fas fa-dollar-sign mr-1"></i>$1,800</span>
                      <span class="bg-green-500/20 text-green-500 px-2 py-1 rounded-full text-xs">Shortlisted</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Right Column -->
        <div class="space-y-8">
          <!-- Quick Actions -->
          <div class="bg-card-dark border border-border-custom rounded-xl p-6">
            <h2 class="text-xl font-semibold mb-6">Quick Actions</h2>
            <div class="space-y-3">
              <button class="w-full bg-accent-green hover:bg-accent-green-hover text-white px-4 py-3 rounded-lg font-medium transition-colors">
                <i class="fas fa-search mr-2"></i>Browse New Projects
              </button>
              <button class="w-full bg-secondary-dark hover:bg-card-dark text-text-primary px-4 py-3 rounded-lg font-medium transition-colors border border-border-custom">
                <i class="fas fa-edit mr-2"></i>Update Profile
              </button>
              <button class="w-full bg-secondary-dark hover:bg-card-dark text-text-primary px-4 py-3 rounded-lg font-medium transition-colors border border-border-custom">
                <i class="fas fa-plus mr-2"></i>Add Portfolio Item
              </button>
            </div>
          </div>

          <!-- Recent Messages -->
          <div class="bg-card-dark border border-border-custom rounded-xl p-6">
            <div class="flex items-center justify-between mb-6">
              <h2 class="text-xl font-semibold">Recent Messages</h2>
              <a href="#" class="text-accent-green hover:text-accent-green-hover text-sm">View All</a>
            </div>
            <div class="space-y-4">
              <div class="flex items-center space-x-3 p-3 rounded-lg hover:bg-secondary-dark transition-colors">
                <img src="https://images.unsplash.com/photo-1494790108755-2616b332c1cf?w=40&h=40&fit=crop&crop=face" alt="Client" class="w-10 h-10 rounded-full">
                <div class="flex-1">
                  <p class="font-medium text-sm">Sarah Johnson</p>
                  <p class="text-text-secondary text-xs">Quick question about the project timeline...</p>
                </div>
                <div class="text-xs text-text-muted">2h</div>
              </div>

              <div class="flex items-center space-x-3 p-3 rounded-lg hover:bg-secondary-dark transition-colors">
                <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=40&h=40&fit=crop&crop=face" alt="Client" class="w-10 h-10 rounded-full">
                <div class="flex-1">
                  <p class="font-medium text-sm">Mike Chen</p>
                  <p class="text-text-secondary text-xs">Thanks for the update! Looking forward to...</p>
                </div>
                <div class="text-xs text-text-muted">1d</div>
              </div>

              <div class="flex items-center space-x-3 p-3 rounded-lg hover:bg-secondary-dark transition-colors">
                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=40&h=40&fit=crop&crop=face" alt="Client" class="w-10 h-10 rounded-full">
                <div class="flex-1">
                  <p class="font-medium text-sm">Emma Wilson</p>
                  <p class="text-text-secondary text-xs">Could you provide an estimate for...</p>
                </div>
                <div class="text-xs text-text-muted">2d</div>
              </div>
            </div>
          </div>

          <!-- Upcoming Deadlines -->
          <div class="bg-card-dark border border-border-custom rounded-xl p-6">
            <h2 class="text-xl font-semibold mb-6">Upcoming Deadlines</h2>
            <div class="space-y-4">
              <div class="flex items-center space-x-3 p-3 rounded-lg bg-red-500/10 border border-red-500/20">
                <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                <div class="flex-1">
                  <p class="font-medium text-sm">Mobile App UI/UX</p>
                  <p class="text-text-secondary text-xs">Due in 3 days</p>
                </div>
              </div>

              <div class="flex items-center space-x-3 p-3 rounded-lg bg-yellow-400/10 border border-yellow-400/20">
                <div class="w-3 h-3 bg-yellow-400 rounded-full"></div>
                <div class="flex-1">
                  <p class="font-medium text-sm">E-commerce Platform</p>
                  <p class="text-text-secondary text-xs">Due in 8 days</p>
                </div>
              </div>

              <div class="flex items-center space-x-3 p-3 rounded-lg bg-green-500/10 border border-green-500/20">
                <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                <div class="flex-1">
                  <p class="font-medium text-sm">AI Chatbot</p>
                  <p class="text-text-secondary text-xs">Due in 13 days</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
    
@endsection
