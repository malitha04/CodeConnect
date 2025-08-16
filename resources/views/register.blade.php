<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up - CodeConnect</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <script>
    // Tailwind CSS configuration, consistent with other pages
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
              orange: '#ff7640'
            },
            text: {
              primary: '#ffffff',
              secondary: '#b5b6ba',
              muted: '#8a8a8a'
            },
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
  <style>
    .account-type-btn.active {
        border-color: #1dbf73;
        background-color: rgba(29, 191, 115, 0.1);
    }
    /* Styles for the message box */
    #messageBox {
        display: none;
        position: fixed;
        top: 80px;
        left: 50%;
        transform: translateX(-50%);
        padding: 1rem 1.5rem;
        border-radius: 0.5rem;
        color: white;
        z-index: 100;
        font-weight: 500;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    #messageBox.success { background-color: #1dbf73; }
    #messageBox.error { background-color: #ef4444; }
  </style>
</head>
<body class="flex flex-col min-h-screen font-inter bg-primary-dark text-text-primary">

  <!-- Navbar -->
  <nav class="fixed top-0 z-50 w-full border-b shadow-lg bg-primary-dark/95 backdrop-blur-md border-border-custom">
    <div class="container px-4 mx-auto">
      <div class="flex items-center justify-between h-16">
        <a href="{{ route('dashboard') }}" class="text-2xl font-bold text-accent-green">
            <i class="mr-2 fas fa-code"></i>Code<span class="text-text-primary">Connect</span>
        </a>
      </div>
    </div>
  </nav>

  <!-- Message Box -->
  <div id="messageBox"></div>

  <!-- Main Content -->
  <main class="flex items-center justify-center flex-grow px-4 py-12 mt-16">
    <div class="w-full max-w-lg">
      <div class="p-8 border shadow-2xl bg-card-dark border-border-custom rounded-2xl animate-fade-in-up">
        <div class="mb-8 text-center">
          <h1 class="mb-2 text-3xl font-bold">Join CodeConnect</h1>
          <p class="text-text-secondary">Create your account to get started</p>
        </div>

        <div class="mb-6">
          <p class="mb-3 text-sm font-medium text-center text-text-secondary">I want to:</p>
          <div class="grid grid-cols-2 gap-3">
            <button type="button" class="flex flex-col items-center p-4 transition-all duration-300 border rounded-lg account-type-btn bg-secondary-dark hover:border-accent-green" onclick="selectAccountType(this, 'Developer')" id="developer-btn">
              <i class="mb-2 text-xl fas fa-code text-accent-green"></i>
              <span class="text-sm font-medium">Work as a Developer</span>
            </button>
            <button type="button" class="flex flex-col items-center p-4 transition-all duration-300 border rounded-lg account-type-btn bg-secondary-dark hover:border-accent-green" onclick="selectAccountType(this, 'Client')" id="client-btn">
              <i class="mb-2 text-xl fas fa-briefcase text-accent-green"></i>
              <span class="text-sm font-medium">Hire a Developer</span>
            </button>
          </div>
        </div>

        {{-- Laravel form for direct submission, removing the fetch API part --}}
        <form method="POST" action="{{ route('register') }}" class="space-y-6" id="registerForm">
          @csrf {{-- THIS IS THE CRITICAL ADDITION TO PREVENT 419 ERRORS --}}

          {{-- The `name` attribute here needs to match what your backend expects, e.g., 'role' --}}
          <input type="hidden" id="accountType" name="role" value="Developer">

          <div class="space-y-2">
            <label for="name" class="block text-sm font-medium text-text-secondary">Full Name</label>
            {{-- The `name` attribute here needs to match what your backend expects, e.g., 'name' --}}
            <input type="text" id="name" name="name" required class="w-full py-3 pl-4 pr-4 transition-colors border rounded-lg bg-secondary-dark border-border-custom text-text-primary placeholder-text-muted focus:outline-none focus:ring-2 focus:ring-accent-green" placeholder="Enter your full name">
          </div>
          <div class="space-y-2">
            <label for="email" class="block text-sm font-medium text-text-secondary">Email Address</label>
            {{-- The `name` attribute here needs to match what your backend expects, e.g., 'email' --}}
            <input type="email" id="email" name="email" required class="w-full py-3 pl-4 pr-4 transition-colors border rounded-lg bg-secondary-dark border-border-custom text-text-primary placeholder-text-muted focus:outline-none focus:ring-2 focus:ring-accent-green" placeholder="Enter your email">
          </div>
          <div class="space-y-2">
            <label for="password" class="block text-sm font-medium text-text-secondary">Password</label>
            <div class="relative">
              <input type="password" id="password" name="password" required minlength="8" class="w-full py-3 pl-4 pr-12 transition-colors border rounded-lg bg-secondary-dark border-border-custom text-text-primary placeholder-text-muted focus:outline-none focus:ring-2 focus:ring-accent-green" placeholder="Create a password">
              <button type="button" class="absolute inset-y-0 right-0 flex items-center pr-3 text-text-muted hover:text-text-secondary" onclick="togglePasswordVisibility('password', 'password-toggle-icon')">
                <i class="fas fa-eye" id="password-toggle-icon"></i>
              </button>
            </div>
          </div>
          <div class="space-y-2">
            <label for="password_confirmation" class="block text-sm font-medium text-text-secondary">Confirm Password</label>
            <div class="relative">
              {{-- The `name` attribute must be `password_confirmation` for Laravel's default validation to work --}}
              <input type="password" id="password_confirmation" name="password_confirmation" required class="w-full py-3 pl-4 pr-12 transition-colors border rounded-lg bg-secondary-dark border-border-custom text-text-primary placeholder-text-muted focus:outline-none focus:ring-2 focus:ring-accent-green" placeholder="Confirm your password">
               <button type="button" class="absolute inset-y-0 right-0 flex items-center pr-3 text-text-muted hover:text-text-secondary" onclick="togglePasswordVisibility('password_confirmation', 'confirm-password-toggle-icon')">
                <i class="fas fa-eye" id="confirm-password-toggle-icon"></i>
              </button>
            </div>
          </div>
          <div class="flex items-start">
            <input type="checkbox" id="terms" name="terms" required class="w-4 h-4 mt-1 rounded text-accent-green bg-secondary-dark border-border-custom focus:ring-accent-green focus:ring-2">
            <label for="terms" class="ml-3 text-sm text-text-secondary">
              I agree to the <a href="#" class="text-accent-green hover:text-accent-green-hover">Terms of Service</a> and <a href="#" class="text-accent-green hover:text-accent-green-hover">Privacy Policy</a>
            </label>
          </div>
          <button type="submit" id="submitBtn" class="w-full py-3 font-semibold text-white transition-all duration-300 rounded-lg shadow-lg bg-accent-green hover:bg-accent-green-hover hover:-translate-y-1 hover:shadow-xl">
            <i class="mr-2 fas fa-user-plus"></i>Create Account
          </button>
        </form>
        <div class="mt-8 text-center">
          <p class="text-text-secondary">
            Already have an account? 
            <a href="{{ route('login') }}" class="font-medium transition-colors duration-300 text-accent-green hover:text-accent-green-hover">
              Sign in here
            </a>
          </p>
        </div>
      </div>
    </div>
  </main>

  <script>
    // Toggles the mobile menu visibility
    function toggleMobileMenu() {
      document.getElementById('mobileMenu').classList.toggle('hidden');
    }

    // Sets the account type and updates button styles
    function selectAccountType(selectedButton, type) {
      document.getElementById('accountType').value = type;
      document.querySelectorAll('.account-type-btn').forEach(btn => btn.classList.remove('active'));
      selectedButton.classList.add('active');
    }

    // Toggles password visibility for a given field
    function togglePasswordVisibility(fieldId, iconId) {
      const field = document.getElementById(fieldId);
      const icon = document.getElementById(iconId);
      if (field.type === 'password') {
        field.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
      } else {
        field.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
      }
    }

    // Shows a message box to the user
    function showMessage(message, type = 'error') {
        const messageBox = document.getElementById('messageBox');
        messageBox.textContent = message;
        messageBox.className = type; // 'success' or 'error'
        messageBox.style.display = 'block';

        // Hide the message after 5 seconds
        setTimeout(() => {
            messageBox.style.display = 'none';
        }, 5000);
    }
    
    // Set the default account type on page load
    document.addEventListener('DOMContentLoaded', function() {
      document.getElementById('developer-btn').classList.add('active');
      // The form will now submit directly to the server, so we're removing the custom JS fetch handler
    });
  </script>

</body>
</html>
