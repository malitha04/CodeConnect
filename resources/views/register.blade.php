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
<body class="font-inter bg-primary-dark text-text-primary flex flex-col min-h-screen">

  <!-- Navbar -->
  <nav class="fixed top-0 w-full bg-primary-dark/95 backdrop-blur-md border-b border-border-custom shadow-lg z-50">
    <div class="container mx-auto px-4">
      <div class="flex items-center justify-between h-16">
        <a href="index.html" class="text-2xl font-bold text-accent-green">
            <i class="fas fa-code mr-2"></i>Code<span class="text-text-primary">Connect</span>
        </a>
      </div>
    </div>
  </nav>

  <!-- Message Box -->
  <div id="messageBox"></div>

  <!-- Main Content -->
  <main class="flex-grow flex items-center justify-center py-12 px-4 mt-16">
    <div class="w-full max-w-lg">
      <div class="bg-card-dark border border-border-custom rounded-2xl p-8 shadow-2xl animate-fade-in-up">
        <div class="text-center mb-8">
          <h1 class="text-3xl font-bold mb-2">Join CodeConnect</h1>
          <p class="text-text-secondary">Create your account to get started</p>
        </div>

        <div class="mb-6">
          <p class="text-sm font-medium text-text-secondary mb-3 text-center">I want to:</p>
          <div class="grid grid-cols-2 gap-3">
            <button type="button" class="account-type-btn flex flex-col items-center p-4 border rounded-lg bg-secondary-dark hover:border-accent-green transition-all duration-300" onclick="selectAccountType(this, 'developer')" id="developer-btn">
              <i class="fas fa-code text-accent-green text-xl mb-2"></i>
              <span class="text-sm font-medium">Work as a Developer</span>
            </button>
            <button type="button" class="account-type-btn flex flex-col items-center p-4 border rounded-lg bg-secondary-dark hover:border-accent-green transition-all duration-300" onclick="selectAccountType(this, 'client')" id="client-btn">
              <i class="fas fa-briefcase text-accent-green text-xl mb-2"></i>
              <span class="text-sm font-medium">Hire a Developer</span>
            </button>
          </div>
        </div>

        <form id="registerForm" class="space-y-6">
          <input type="hidden" id="accountType" name="accountType" value="developer">
          <div class="space-y-2">
            <label for="fullName" class="block text-sm font-medium text-text-secondary">Full Name</label>
            <input type="text" id="fullName" name="fullName" required class="w-full pl-4 pr-4 py-3 bg-secondary-dark border border-border-custom rounded-lg text-text-primary placeholder-text-muted focus:outline-none focus:ring-2 focus:ring-accent-green transition-colors" placeholder="Enter your full name">
          </div>
          <div class="space-y-2">
            <label for="email" class="block text-sm font-medium text-text-secondary">Email Address</label>
            <input type="email" id="email" name="email" required class="w-full pl-4 pr-4 py-3 bg-secondary-dark border border-border-custom rounded-lg text-text-primary placeholder-text-muted focus:outline-none focus:ring-2 focus:ring-accent-green transition-colors" placeholder="Enter your email">
          </div>
          <div class="space-y-2">
            <label for="password" class="block text-sm font-medium text-text-secondary">Password</label>
            <div class="relative">
              <input type="password" id="password" name="password" required minlength="8" class="w-full pl-4 pr-12 py-3 bg-secondary-dark border border-border-custom rounded-lg text-text-primary placeholder-text-muted focus:outline-none focus:ring-2 focus:ring-accent-green transition-colors" placeholder="Create a password">
              <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-text-muted hover:text-text-secondary" onclick="togglePasswordVisibility('password', 'password-toggle-icon')">
                <i class="fas fa-eye" id="password-toggle-icon"></i>
              </button>
            </div>
          </div>
          <div class="space-y-2">
            <label for="confirmPassword" class="block text-sm font-medium text-text-secondary">Confirm Password</label>
            <div class="relative">
              <input type="password" id="confirmPassword" name="confirmPassword" required class="w-full pl-4 pr-12 py-3 bg-secondary-dark border border-border-custom rounded-lg text-text-primary placeholder-text-muted focus:outline-none focus:ring-2 focus:ring-accent-green transition-colors" placeholder="Confirm your password">
               <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-text-muted hover:text-text-secondary" onclick="togglePasswordVisibility('confirmPassword', 'confirm-password-toggle-icon')">
                <i class="fas fa-eye" id="confirm-password-toggle-icon"></i>
              </button>
            </div>
          </div>
          <div class="flex items-start">
            <input type="checkbox" id="terms" name="terms" required class="w-4 h-4 mt-1 text-accent-green bg-secondary-dark border-border-custom rounded focus:ring-accent-green focus:ring-2">
            <label for="terms" class="ml-3 text-sm text-text-secondary">
              I agree to the <a href="#" class="text-accent-green hover:text-accent-green-hover">Terms of Service</a> and <a href="#" class="text-accent-green hover:text-accent-green-hover">Privacy Policy</a>
            </label>
          </div>
          <button type="submit" id="submitBtn" class="w-full bg-accent-green hover:bg-accent-green-hover text-white py-3 rounded-lg font-semibold transition-all duration-300 hover:-translate-y-1 shadow-lg hover:shadow-xl">
            <i class="fas fa-user-plus mr-2"></i>Create Account
          </button>
        </form>
        <div class="mt-8 text-center">
          <p class="text-text-secondary">
            Already have an account? 
            <a href="login.html" class="text-accent-green hover:text-accent-green-hover font-medium transition-colors duration-300">
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

    // --- UPDATED: Handles the registration form submission with Fetch API ---
    document.getElementById('registerForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent default form submission

        const form = event.target;
        const submitBtn = document.getElementById('submitBtn');
        const password = form.password.value;
        const confirmPassword = form.confirmPassword.value;

        // Basic frontend validation
        if (password !== confirmPassword) {
            showMessage('Passwords do not match.', 'error');
            return;
        }

        // Disable button to prevent multiple submissions
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Creating Account...';

        const formData = new FormData(form);

        // Send data to the backend script
        fetch('register_process.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                showMessage(data.message, 'success');
                form.reset(); // Clear the form
                // Optionally, redirect to the login page after a delay
                setTimeout(() => {
                    window.location.href = 'login.html';
                }, 2000);
            } else {
                showMessage(data.message || 'An unknown error occurred.', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showMessage('A network error occurred. Please try again.', 'error');
        })
        .finally(() => {
            // Re-enable the button
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-user-plus mr-2"></i>Create Account';
        });
    });

    // Set the default account type on page load
    document.addEventListener('DOMContentLoaded', function() {
      document.getElementById('developer-btn').classList.add('active');
    });
  </script>

</body>
</html>
