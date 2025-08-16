<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="w-full max-w-md">
        <div class="bg-card-dark border border-border-custom rounded-2xl p-8 shadow-2xl animate-fade-in-up">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold mb-2">Welcome Back</h1>
                <p class="text-text-secondary">Sign in to your CodeConnect account</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="space-y-2">
                    <label for="email" class="block text-sm font-medium text-text-secondary">Email Address</label>
                    <input type="email" id="email" name="email" :value="old('email')" required autofocus autocomplete="username" class="w-full pl-4 pr-4 py-3 bg-secondary-dark border border-border-custom rounded-lg text-text-primary placeholder-text-muted focus:outline-none focus:ring-2 focus:ring-accent-green transition-colors" placeholder="Enter your email">
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="space-y-2">
                    <label for="password" class="block text-sm font-medium text-text-secondary">Password</label>
                    <input type="password" id="password" name="password" required autocomplete="current-password" class="w-full pl-4 pr-4 py-3 bg-secondary-dark border border-border-custom rounded-lg text-text-primary placeholder-text-muted focus:outline-none focus:ring-2 focus:ring-accent-green transition-colors" placeholder="Enter your password">
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input type="checkbox" id="remember_me" name="remember" class="w-4 h-4 text-accent-green bg-secondary-dark border-border-custom rounded focus:ring-accent-green focus:ring-2">
                        <label for="remember_me" class="ml-2 text-sm text-text-secondary">Remember me</label>
                    </div>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-accent-green hover:text-accent-green-hover transition-colors duration-300">
                            Forgot password?
                        </a>
                    @endif
                </div>

                <button type="submit" class="w-full bg-accent-green hover:bg-accent-green-hover text-white py-3 rounded-lg font-semibold transition-all duration-300 hover:-translate-y-1 shadow-lg hover:shadow-xl">
                    <i class="fas fa-sign-in-alt mr-2"></i>Sign In
                </button>
            </form>

            <div class="mt-8 text-center">
                <p class="text-text-secondary">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="text-accent-green hover:text-accent-green-hover font-medium transition-colors duration-300">
                        Sign up here
                    </a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>
