@extends('layouts.app')

@section('title', 'Contact Us - CodeConnect')

@section('content')

  <!-- Hero Section -->
  <section class="pt-24 pb-16 bg-gradient-to-br from-primary-dark via-secondary-dark to-primary-dark relative overflow-hidden">
    <!-- Background Effects -->
    <div class="absolute inset-0 bg-gradient-radial from-accent-green/10 via-transparent to-transparent opacity-50"></div>
    <div class="absolute top-20 right-20 w-72 h-72 bg-accent-orange/5 rounded-full blur-3xl"></div>
    <div class="absolute bottom-20 left-20 w-96 h-96 bg-accent-green/5 rounded-full blur-3xl"></div>

    <div class="container mx-auto px-4 relative z-10">
      <div class="text-center max-w-4xl mx-auto animate-fade-in-up">
        <h1 class="text-5xl lg:text-6xl font-bold leading-tight mb-6">
          Get In <span class="text-accent-green">Touch</span>
        </h1>
        <p class="text-xl text-text-secondary max-w-3xl mx-auto">
          We’d love to hear from you! Whether you have a question, feedback, or need support, our team is ready to help.
        </p>
      </div>
    </div>
  </section>

  <!-- Contact Section -->
  <section class="py-16 bg-primary-dark">
    <div class="container mx-auto px-4">
        <div class="grid lg:grid-cols-2 gap-12 items-start">
            <!-- Contact Form -->
            <div class="bg-card-dark p-8 rounded-xl border border-border-custom shadow-2xl animate-fade-in-up" style="animation-delay: 0.2s;">
                <h3 class="text-3xl font-bold mb-6 text-text-primary">Send us a Message</h3>
                <form id="contactForm" method="POST" action="#" class="space-y-6">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-medium text-text-secondary mb-2">Full Name</label>
                        <input type="text" id="name" name="name" class="w-full bg-secondary-dark border border-border-custom rounded-lg px-4 py-3 text-text-primary focus:outline-none focus:ring-2 focus:ring-accent-green transition-all" placeholder="John Doe" required>
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-text-secondary mb-2">Email Address</label>
                        <input type="email" id="email" name="email" class="w-full bg-secondary-dark border border-border-custom rounded-lg px-4 py-3 text-text-primary focus:outline-none focus:ring-2 focus:ring-accent-green transition-all" placeholder="you@example.com" required>
                    </div>
                     <div>
                        <label for="subject" class="block text-sm font-medium text-text-secondary mb-2">Subject</label>
                        <input type="text" id="subject" name="subject" class="w-full bg-secondary-dark border border-border-custom rounded-lg px-4 py-3 text-text-primary focus:outline-none focus:ring-2 focus:ring-accent-green transition-all" placeholder="How can we help?" required>
                    </div>
                    <div>
                        <label for="message" class="block text-sm font-medium text-text-secondary mb-2">Message</label>
                        <textarea id="message" name="message" rows="5" class="w-full bg-secondary-dark border border-border-custom rounded-lg px-4 py-3 text-text-primary focus:outline-none focus:ring-2 focus:ring-accent-green transition-all" placeholder="Your message..." required></textarea>
                    </div>
                    <div>
                        <button type="submit" class="w-full bg-accent-green hover:bg-accent-green-hover text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 hover:-translate-y-1">
                            <i class="fas fa-paper-plane mr-2"></i>Send Message
                        </button>
                    </div>
                </form>
            </div>
            <!-- Contact Info -->
            <div class="space-y-8 animate-fade-in-up" style="animation-delay: 0.4s;">
                 <div class="bg-card-dark p-8 rounded-xl border border-border-custom shadow-2xl">
                    <h3 class="text-3xl font-bold mb-6 text-text-primary">Contact Information</h3>
                    <div class="space-y-6 text-text-secondary">
                        <div class="flex items-start">
                            <i class="fas fa-map-marker-alt text-accent-green text-2xl w-8 text-center mt-1"></i>
                            <div class="ml-4">
                                <h4 class="font-semibold text-text-primary text-lg">Our Office</h4>
                                <p>123 Innovation Drive, Tech City, 10100, Colombo</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                             <i class="fas fa-envelope text-accent-green text-2xl w-8 text-center mt-1"></i>
                             <div class="ml-4">
                                <h4 class="font-semibold text-text-primary text-lg">Email Us</h4>
                                <p>support@codeconnect.com</p>
                            </div>
                        </div>
                         <div class="flex items-start">
                             <i class="fas fa-phone text-accent-green text-2xl w-8 text-center mt-1"></i>
                             <div class="ml-4">
                                <h4 class="font-semibold text-text-primary text-lg">Call Us</h4>
                                <p>+94 (11) 234 5678</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                             <i class="fas fa-clock text-accent-green text-2xl w-8 text-center mt-1"></i>
                             <div class="ml-4">
                                <h4 class="font-semibold text-text-primary text-lg">Business Hours</h4>
                                <p>Monday - Friday: 9:00 AM - 6:00 PM</p>
                                <p>Saturday: 10:00 AM - 2:00 PM</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </section>

@endsection
