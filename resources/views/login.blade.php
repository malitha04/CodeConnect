<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign In - CodeConnect</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <script>
    // Tailwind CSS configuration, consistent with other pages
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
            'fade-in-up': 'fadeInUp 0.6s ease-out forwards'
          },
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
</head>
<body class="font-inter bg-primary-dark text-text-primary flex flex-col min-h-screen">

  <!-- Navbar -->
  <nav class="fixed top-0 w-full bg-primary-dark/95 backdrop-blur-md border-b border-border-custom shadow-lg z-50">
    <div class="container mx-auto px-4">
      <div class="flex items-center justify-between h-16">
        <!-- Logo -->
        <div class="flex items-center">
          <a href="index.html" class="text-2xl font-bold text-accent-green">
            <i class="fas fa-code mr-2"></i>Code<span class="text-text-primary">Connect</span>
          </a>
        </div>

        <!-- Desktop Navigation -->
        <div class="hidden md:flex items-center space-x-8">
          <a href="index.html#categories" class="text-text-secondary hover:text-text-primary transition-colors duration-300">Categories</a>
          <a href="index.html#developers" class="text-text-secondary hover:text-text-primary transition-colors duration-300">Find Developers</a>
          <a href="index.html#projects" class="text-text-secondary hover:text-text-primary transition-colors duration-300">Browse Projects</a>
          <a href="about.html" class="text-text-secondary hover:text-text-primary transition-colors duration-300">About</a>
          <a href="contact.html" class="text-text-secondary hover:text-text-primary transition-colors duration-300">Contact</a>
        </div>

        <!-- Auth Buttons -->
        <div class="hidden md:flex items-center space-x-4">
          <a href="login.html" class="text-accent-green font-semibold">Sign In</a>
          <a href="register.html" class="bg-accent-green hover:bg-accent-green-hover text-white px-6 py-2 rounded-lg font-semibold transition-all duration-300 hover:-translate-y-1">
            Join Now
          </a>
        </div>

        <!-- Mobile Menu Button -->
        <button class="md:hidden text-text-primary" onclick="toggleMobileMenu()">
          <i class="fas fa-bars text-xl"></i>
        </button>
      </div>

      <!-- Mobile Menu -->
      <div id="mobileMenu" class="md:hidden hidden bg-secondary-dark rounded-lg mt-2 p-4 border border-border-custom">
        <a href="index.html#categories" class="block py-2 text-text-secondary hover:text-accent-green transition-colors">Categories</a>
        <a href="index.html#developers" class="block py-2 text-text-secondary hover:text-accent-green transition-colors">Find Developers</a>
        <a href="index.html#projects" class="block py-2 text-text-secondary hover:text-accent-green transition-colors">Browse Projects</a>
        <a href="about.html" class="block py-2 text-text-secondary hover:text-accent-green transition-colors">About</a>
        <a href="contact.html" class="block py-2 text-text-secondary hover:text-accent-green transition-colors">Contact</a>
        <hr class="my-4 border-border-custom">
        <a href="login.html" class="block py-2 text-accent-green font-semibold">Sign In</a>
        <a href="register.html" class="block mt-2 bg-accent-green text-white px-4 py-2 rounded-lg text-center font-semibold">Join Now</a>
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <main class="flex-grow flex items-center justify-center py-12 px-4 mt-16">
    <div class="w-full max-w-md">
      <!-- Login Form Container -->
      <div class="bg-card-dark border border-border-custom rounded-2xl p-8 shadow-2xl animate-fade-in-up">
        <!-- Header -->
        <div class="text-center mb-8">
          <h1 class="text-3xl font-bold mb-2">Welcome Back</h1>
          <p class="text-text-secondary">Sign in to your CodeConnect account</p>
        </div>

        <!-- Login Form -->
        <form class="space-y-6" onsubmit="handleLogin(event)">
          <!-- Email Field -->
          <div class="space-y-2">
            <label for="email" class="block text-sm font-medium text-text-secondary">Email Address</label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-envelope text-text-muted"></i>
              </div>
              <input 
                type="email" 
                id="email" 
                name="email" 
                required
                class="w-full pl-10 pr-4 py-3 bg-secondary-dark border border-border-custom rounded-lg text-text-primary placeholder-text-muted focus:outline-none focus:ring-2 focus:ring-accent-green focus:border-accent-green transition-colors duration-300"
                placeholder="Enter your email"
              >
            </div>
          </div>

          <!-- Password Field -->
          <div class="space-y-2">
            <label for="password" class="block text-sm font-medium text-text-secondary">Password</label>
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-lock text-text-muted"></i>
              </div>
              <input 
                type="password" 
                id="password" 
                name="password" 
                required
                class="w-full pl-10 pr-12 py-3 bg-secondary-dark border border-border-custom rounded-lg text-text-primary placeholder-text-muted focus:outline-none focus:ring-2 focus:ring-accent-green focus:border-accent-green transition-colors duration-300"
                placeholder="Enter your password"
              >
              <button 
                type="button" 
                class="absolute inset-y-0 right-0 pr-3 flex items-center text-text-muted hover:text-text-secondary transition-colors duration-300"
                onclick="togglePasswordVisibility()"
              >
                <i class="fas fa-eye" id="password-toggle-icon"></i>
              </button>
            </div>
          </div>

          <!-- Remember Me & Forgot Password -->
          <div class="flex items-center justify-between">
            <div class="flex items-center">
              <input 
                type="checkbox" 
                id="remember" 
                name="remember"
                class="w-4 h-4 text-accent-green bg-secondary-dark border-border-custom rounded focus:ring-accent-green focus:ring-2"
              >
              <label for="remember" class="ml-2 text-sm text-text-secondary">Remember me</label>
            </div>
            <a href="#" class="text-sm text-accent-green hover:text-accent-green-hover transition-colors duration-300">
              Forgot password?
            </a>
          </div>

          <!-- Submit Button -->
          <button 
            type="submit" 
            class="w-full bg-accent-green hover:bg-accent-green-hover text-white py-3 rounded-lg font-semibold transition-all duration-300 hover:-translate-y-1 shadow-lg hover:shadow-xl"
          >
            <i class="fas fa-sign-in-alt mr-2"></i>Sign In
          </button>
        </form>

        <!-- Divider -->
        <div class="my-6 flex items-center">
          <div class="flex-1 border-t border-border-custom"></div>
          <span class="px-4 text-text-muted text-sm">or</span>
          <div class="flex-1 border-t border-border-custom"></div>
        </div>

        <!-- Social Login -->
        <div class="space-y-3">
          <button class="w-full flex items-center justify-center px-4 py-3 border border-border-custom rounded-lg bg-secondary-dark hover:bg-card-dark text-text-primary font-medium transition-colors duration-300">
            <i class="fab fa-google mr-3 text-red-500"></i>
            Continue with Google
          </button>
          <button class="w-full flex items-center justify-center px-4 py-3 border border-border-custom rounded-lg bg-secondary-dark hover:bg-card-dark text-text-primary font-medium transition-colors duration-300">
            <i class="fab fa-github mr-3 text-white"></i>
            Continue with GitHub
          </button>
        </div>

        <!-- Sign Up Link -->
        <div class="mt-8 text-center">
          <p class="text-text-secondary">
            Don't have an account? 
            <a href="register.html" class="text-accent-green hover:text-accent-green-hover font-medium transition-colors duration-300">
              Sign up here
            </a>
          </p>
        </div>
      </div>
    </div>
  </main>

  <!-- Footer -->
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
            The premier marketplace for top-tier developers.
          </p>
        </div>
        <div>
          <h4 class="text-lg font-semibold mb-4">For Clients</h4>
          <ul class="space-y-2 text-text-secondary">
            <li><a href="index.html#developers" class="hover:text-accent-green transition-colors">Find Developers</a></li>
            <li><a href="index.html#projects" class="hover:text-accent-green transition-colors">Post a Project</a></li>
            <li><a href="index.html#categories" class="hover:text-accent-green transition-colors">Browse Categories</a></li>
            <li><a href="#" class="hover:text-accent-green transition-colors">How It Works</a></li>
          </ul>
        </div>
        <div>
          <h4 class="text-lg font-semibold mb-4">For Developers</h4>
          <ul class="space-y-2 text-text-secondary">
            <li><a href="index.html#projects" class="hover:text-accent-green transition-colors">Find Projects</a></li>
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

  <!-- Scripts -->
  <script>
    // Toggles the mobile menu visibility
    function toggleMobileMenu() {
      const menu = document.getElementById('mobileMenu');
      menu.classList.toggle('hidden');
    }

    // Toggles the password field visibility
    function togglePasswordVisibility() {
      const passwordField = document.getElementById('password');
      const toggleIcon = document.getElementById('password-toggle-icon');
      
      if (passwordField.type === 'password') {
        passwordField.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
      } else {
        passwordField.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
      }
    }

    // Handles the form submission
    function handleLogin(event) {
      event.preventDefault(); // Prevent the form from submitting traditionally
      
      const email = document.getElementById('email').value;
      const password = document.getElementById('password').value;
      
      if (!email || !password) {
        // In a real app, you would show a more elegant error message
        console.error('Please fill in all fields');
        return;
      }
      
      // For demonstration, log the login attempt to the console
      console.log('Login attempt:', { email, password });
   
    }
  </script>

</body>
</html>
