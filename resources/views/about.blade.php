<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Us - CodeConnect</title>
  <script src="https://cdn.tailwindcss.com"></script>
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
          },
          animation: {
            'float': 'float 6s ease-in-out infinite',
            'fade-in-up': 'fadeInUp 0.6s ease-out forwards'
          },
          keyframes: {
            float: {
              '0%, 100%': { transform: 'translateY(0px)' },
              '50%': { transform: 'translateY(-20px)' }
            },
            fadeInUp: {
              '0%': { opacity: '0', transform: 'translateY(30px)' },
              '100%': { opacity: '1', transform: 'translateY(0)' }
            }
          }
        }
      }
    }
  </script>
</head>
<body class="font-inter bg-primary-dark text-text-primary leading-relaxed">

  <nav class="fixed top-0 w-full bg-primary-dark/95 backdrop-blur-md border-b border-border-custom shadow-lg z-50">
    <div class="container mx-auto px-4">
      <div class="flex items-center justify-between h-16">
        <div class="flex items-center">
          <a href="{{ url('/') }}" class="text-2xl font-bold text-accent-green">
            <i class="fas fa-code mr-2"></i>Code<span class="text-text-primary">Connect</span>
          </a>
        </div>

        <div class="hidden md:flex items-center space-x-8">
          <a href="{{ url('/#categories') }}" class="text-text-secondary hover:text-text-primary transition-colors duration-300">Categories</a>
          <a href="{{ url('/#developers') }}" class="text-text-secondary hover:text-text-primary transition-colors duration-300">Find Developers</a>
          <a href="{{ url('/#projects') }}" class="text-text-secondary hover:text-text-primary transition-colors duration-300">Browse Projects</a>
          <a href="{{ url('/about') }}" class="text-accent-green font-semibold">About</a>
          <a href="{{ url('/contact') }}" class="text-text-secondary hover:text-text-primary transition-colors duration-300">Contact</a>
        </div>

        <div class="hidden md:flex items-center space-x-4">
          <a href="login.html" class="text-text-secondary hover:text-text-primary transition-colors duration-300">Sign In</a>
          <a href="register.html" class="bg-accent-green hover:bg-accent-green-hover text-white px-6 py-2 rounded-lg font-semibold transition-all duration-300 hover:-translate-y-1">
            Join Now
          </a>
        </div>

        <button class="md:hidden text-text-primary" onclick="toggleMobileMenu()">
          <i class="fas fa-bars text-xl"></i>
        </button>
      </div>

      <div id="mobileMenu" class="md:hidden hidden bg-secondary-dark rounded-lg mt-2 p-4 border border-border-custom">
        <a href="index.html#categories" class="block py-2 text-text-secondary hover:text-accent-green transition-colors">Categories</a>
        <a href="index.html#developers" class="block py-2 text-text-secondary hover:text-accent-green transition-colors">Find Developers</a>
        <a href="index.html#projects" class="block py-2 text-text-secondary hover:text-accent-green transition-colors">Browse Projects</a>
        <a href="about.html" class="block py-2 text-accent-green font-semibold">About</a>
        <a href="contact.html" class="block py-2 text-text-secondary hover:text-accent-green transition-colors">Contact</a>
        <hr class="my-4 border-border-custom">
        <a href="login.html" class="block py-2 text-text-secondary hover:text-accent-green transition-colors">Sign In</a>
        <a href="register.html" class="block mt-2 bg-accent-green text-white px-4 py-2 rounded-lg text-center font-semibold">Join Now</a>
      </div>
    </div>
  </nav>

  <section class="pt-24 pb-16 bg-gradient-to-br from-primary-dark via-secondary-dark to-primary-dark relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-radial from-accent-green/10 via-transparent to-transparent opacity-50"></div>
    <div class="absolute top-20 right-20 w-72 h-72 bg-accent-orange/5 rounded-full blur-3xl"></div>
    <div class="absolute bottom-20 left-20 w-96 h-96 bg-accent-green/5 rounded-full blur-3xl"></div>

    <div class="container mx-auto px-4 relative z-10">
      <div class="text-center max-w-4xl mx-auto">
        <h1 class="text-5xl lg:text-6xl font-bold leading-tight mb-6">
          About <span class="text-accent-green">CodeConnect</span>
        </h1>
        <p class="text-xl text-text-secondary max-w-3xl mx-auto">
          We're revolutionizing how businesses connect with world-class developers, creating opportunities for innovation and growth in the digital age.
        </p>
      </div>
    </div>
  </section>

  <section class="py-16 bg-card-dark border-t border-b border-border-custom">
    <div class="container mx-auto px-4">
      <div class="grid lg:grid-cols-2 gap-12 items-center">
        <div>
          <h2 class="text-4xl font-bold mb-6">Our Mission</h2>
          <p class="text-text-secondary text-lg leading-relaxed mb-6">
            At CodeConnect, we believe that exceptional software should be accessible to everyone. Our mission is to bridge the gap between visionary businesses and talented developers, creating a marketplace where innovation thrives and projects come to life.
          </p>
          <p class="text-text-secondary text-lg leading-relaxed">
            We're committed to fostering a community built on trust, quality, and mutual success. Every connection made on our platform is an opportunity to push the boundaries of what's possible in technology.
          </p>
        </div>
        <div class="text-center">
          <img 
            src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=600&h=400&fit=crop" 
            alt="Team collaboration" 
            class="rounded-2xl shadow-2xl max-w-full h-auto"
          >
        </div>
      </div>
    </div>
  </section>

  <section class="py-16 bg-secondary-dark">
    <div class="container mx-auto px-4">
      <h2 class="text-4xl font-bold text-center mb-12">Our Values</h2>
      <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div class="bg-card-dark border border-border-custom rounded-xl p-8 text-center group hover:border-accent-green hover:-translate-y-2 transition-all duration-300 hover:shadow-2xl">
          <div class="w-16 h-16 bg-accent-green rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
            <i class="fas fa-handshake text-2xl text-white"></i>
          </div>
          <h5 class="text-xl font-semibold mb-4">Trust & Transparency</h5>
          <p class="text-text-secondary">
            We build lasting relationships through honest communication and transparent processes that benefit everyone in our community.
          </p>
        </div>

        <div class="bg-card-dark border border-border-custom rounded-xl p-8 text-center group hover:border-accent-green hover:-translate-y-2 transition-all duration-300 hover:shadow-2xl">
          <div class="w-16 h-16 bg-accent-green rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
            <i class="fas fa-star text-2xl text-white"></i>
          </div>
          <h5 class="text-xl font-semibold mb-4">Quality Excellence</h5>
          <p class="text-text-secondary">
            We're committed to maintaining the highest standards in everything we do, from our platform to the professionals we connect you with.
          </p>
        </div>

        <div class="bg-card-dark border border-border-custom rounded-xl p-8 text-center group hover:border-accent-green hover:-translate-y-2 transition-all duration-300 hover:shadow-2xl">
          <div class="w-16 h-16 bg-accent-green rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
            <i class="fas fa-rocket text-2xl text-white"></i>
          </div>
          <h5 class="text-xl font-semibold mb-4">Innovation First</h5>
          <p class="text-text-secondary">
            We embrace cutting-edge technology and creative solutions to continuously improve our platform and user experience.
          </p>
        </div>

        <div class="bg-card-dark border border-border-custom rounded-xl p-8 text-center group hover:border-accent-green hover:-translate-y-2 transition-all duration-300 hover:shadow-2xl">
          <div class="w-16 h-16 bg-accent-green rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
            <i class="fas fa-users text-2xl text-white"></i>
          </div>
          <h5 class="text-xl font-semibold mb-4">Community Focus</h5>
          <p class="text-text-secondary">
            Our success is measured by the success of our community. We're dedicated to creating an environment where everyone can thrive.
          </p>
        </div>

        <div class="bg-card-dark border border-border-custom rounded-xl p-8 text-center group hover:border-accent-green hover:-translate-y-2 transition-all duration-300 hover:shadow-2xl">
          <div class="w-16 h-16 bg-accent-green rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
            <i class="fas fa-shield-alt text-2xl text-white"></i>
          </div>
          <h5 class="text-xl font-semibold mb-4">Security & Privacy</h5>
          <p class="text-text-secondary">
            We prioritize the security of your data and privacy, implementing industry-leading measures to protect our community.
          </p>
        </div>

        <div class="bg-card-dark border border-border-custom rounded-xl p-8 text-center group hover:border-accent-green hover:-translate-y-2 transition-all duration-300 hover:shadow-2xl">
          <div class="w-16 h-16 bg-accent-green rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-300">
            <i class="fas fa-globe text-2xl text-white"></i>
          </div>
          <h5 class="text-xl font-semibold mb-4">Global Reach</h5>
          <p class="text-text-secondary">
            We connect talent and opportunities across the globe, breaking down barriers and creating a truly international marketplace.
          </p>
        </div>
      </div>
    </div>
  </section>

  <section class="py-16">
    <div class="container mx-auto px-4">
      <h2 class="text-4xl font-bold text-center mb-12">Meet Our Team</h2>
      <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
        <div class="bg-card-dark border border-border-custom rounded-xl overflow-hidden group hover:border-accent-green hover:-translate-y-2 transition-all duration-300 hover:shadow-2xl">
          <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?w=300&h=300&fit=crop&crop=face" alt="CEO" class="w-full h-48 object-cover">
          <div class="p-6 text-center">
            <h5 class="text-xl font-semibold mb-2">Michael Chen</h5>
            <p class="text-accent-green font-medium mb-2">Chief Executive Officer</p>
            <p class="text-text-secondary text-sm">
              Former tech executive with 15+ years experience building scalable platforms and connecting global talent.
            </p>
          </div>
        </div>

        <div class="bg-card-dark border border-border-custom rounded-xl overflow-hidden group hover:border-accent-green hover:-translate-y-2 transition-all duration-300 hover:shadow-2xl">
          <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=300&h=300&fit=crop&crop=face" alt="CTO" class="w-full h-48 object-cover">
          <div class="p-6 text-center">
            <h5 class="text-xl font-semibold mb-2">Sarah Johnson</h5>
            <p class="text-accent-green font-medium mb-2">Chief Technology Officer</p>
            <p class="text-text-secondary text-sm">
              Expert in distributed systems and AI, leading our technical vision and platform architecture.
            </p>
          </div>
        </div>

        <div class="bg-card-dark border border-border-custom rounded-xl overflow-hidden group hover:border-accent-green hover:-translate-y-2 transition-all duration-300 hover:shadow-2xl">
          <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=300&h=300&fit=crop&crop=face" alt="Head of Operations" class="w-full h-48 object-cover">
          <div class="p-6 text-center">
            <h5 class="text-xl font-semibold mb-2">David Rodriguez</h5>
            <p class="text-accent-green font-medium mb-2">Head of Operations</p>
            <p class="text-text-secondary text-sm">
              Operations specialist focused on scaling our platform and ensuring exceptional user experiences.
            </p>
          </div>
        </div>

        <div class="bg-card-dark border border-border-custom rounded-xl overflow-hidden group hover:border-accent-green hover:-translate-y-2 transition-all duration-300 hover:shadow-2xl">
          <img src="https://images.unsplash.com/photo-1580489944761-15a19d654956?w=300&h=300&fit=crop&crop=face" alt="Head of Community" class="w-full h-48 object-cover">
          <div class="p-6 text-center">
            <h5 class="text-xl font-semibold mb-2">Emily Davis</h5>
            <p class="text-accent-green font-medium mb-2">Head of Community</p>
            <p class="text-text-secondary text-sm">
              Community advocate passionate about fostering connections and supporting our developer ecosystem.
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="py-16 bg-card-dark border-t border-b border-border-custom">
    <div class="container mx-auto px-4">
      <div class="text-center mb-12">
        <h2 class="text-4xl font-bold mb-4">CodeConnect by the Numbers</h2>
        <p class="text-text-secondary text-lg">See how we're making a difference in the developer community</p>
      </div>
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

  <section class="py-16 bg-gradient-to-r from-accent-green to-accent-green-hover">
    <div class="container mx-auto px-4 text-center">
      <h2 class="text-4xl font-bold text-white mb-4">Ready to Join Our Community?</h2>
      <p class="text-white/90 text-lg mb-8 max-w-2xl mx-auto">
        Whether you're a business looking for top talent or a developer seeking exciting projects, CodeConnect is your gateway to success.
      </p>
      <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a href="register.html" class="bg-white text-accent-green hover:bg-gray-100 px-8 py-4 rounded-lg font-semibold transition-all duration-300 hover:-translate-y-1">
          <i class="fas fa-user-plus mr-2"></i>Join as Developer
        </a>
        <a href="contact.html" class="border-2 border-white text-white hover:bg-white hover:text-accent-green px-8 py-4 rounded-lg font-semibold transition-all duration-300 hover:-translate-y-1">
          <i class="fas fa-envelope mr-2"></i>Get in Touch
        </a>
      </div>
    </div>
  </section>

  <footer class="bg-primary-darker border-t border-border-custom py-12">
    <div class="container mx-auto px-4">
      <div class="grid md:grid-cols-4 gap-8">
        <div>
          <div class="flex items-center mb-4">
            <a href="index.html" class="text-2xl font-bold text-accent-green">
              <i class="fas fa-code mr-2"></i>Code<span class="text-text-primary">Connect</span>
            </a>
          </div>
          <p class="text-text-secondary">
            The premier marketplace for connecting with top-tier developers and getting your projects done right.
          </p>
        </div>
        <div>
          <h4 class="text-lg font-semibold mb-4">For Clients</h4>
          <ul class="space-y-2 text-text-secondary">
            <li><a href="#" class="hover:text-accent-green transition-colors">Find Developers</a></li>
            <li><a href="#" class="hover:text-accent-green transition-colors">Post a Project</a></li>
            <li><a href="#" class="hover:text-accent-green transition-colors">Browse Categories</a></li>
            <li><a href="#" class="hover:text-accent-green transition-colors">How It Works</a></li>
          </ul>
        </div>
        <div>
          <h4 class="text-lg font-semibold mb-4">For Developers</h4>
          <ul class="space-y-2 text-text-secondary">
            <li><a href="#" class="hover:text-accent-green transition-colors">Find Projects</a></li>
            <li><a href="#" class="hover:text-accent-green transition-colors">Create Profile</a></li>
            <li><a href="#" class="hover:text-accent-green transition-colors">Membership Plans</a></li>
            <li><a href="#" class="hover:text-accent-green transition-colors">Developer Resources</a></li>
          </ul>
        </div>
        <div>
          <h4 class="text-lg font-semibold mb-4">Company</h4>
          <ul class="space-y-2 text-text-secondary">
            <li><a href="about.html" class="hover:text-accent-green transition-colors">About Us</a></li>
            <li><a href="contact.html" class="hover:text-accent-green transition-colors">Contact</a></li>
            <li><a href="#" class="hover:text-accent-green transition-colors">Privacy Policy</a></li>
            <li><a href="#" class="hover:text-accent-green transition-colors">Terms of Service</a></li>
          </ul>
        </div>
      </div>
      <div class="mt-8 border-t border-border-custom pt-6 flex flex-col md:flex-row items-center justify-between text-text-secondary text-sm">
        <p>&copy; 2025 CodeConnect. All rights reserved.</p>
        <div class="flex space-x-4 mt-4 md:mt-0">
          <a href="#" class="hover:text-accent-green transition-colors"><i class="fab fa-twitter"></i></a>
          <a href="#" class="hover:text-accent-green transition-colors"><i class="fab fa-facebook"></i></a>
          <a href="#" class="hover:text-accent-green transition-colors"><i class="fab fa-linkedin"></i></a>
          <a href="#" class="hover:text-accent-green transition-colors"><i class="fab fa-github"></i></a>
        </div>
      </div>
    </div>
  </footer>

  <script>
    function toggleMobileMenu() {
      const menu = document.getElementById('mobileMenu');
      menu.classList.toggle('hidden');
    }
  </script>

</body>
</html>