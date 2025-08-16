{{-- This is an example of what your form should look like in a .blade.php file --}}
<form class="space-y-6" method="POST" action="{{ route('login') }}">
    {{-- This is the directive you must add to fix the 419 error --}}
    @csrf

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
