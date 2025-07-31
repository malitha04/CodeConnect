<x-guest-layout>
    <div class="w-full max-w-lg">
        <div class="bg-card-dark border border-border-custom rounded-2xl p-8 shadow-2xl animate-fade-in-up">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold mb-2">Join CodeConnect</h1>
                <p class="text-text-secondary">Create your account to get started</p>
            </div>

            {{-- The form tag includes the method, action, and CSRF token --}}
            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <!-- Role Selector -->
                <div class="mb-6">
                    <p class="text-sm font-medium text-text-secondary mb-3 text-center">I want to:</p>
                    <div class="grid grid-cols-2 gap-3">
                        <button type="button" class="account-type-btn flex flex-col items-center p-4 border rounded-lg bg-secondary-dark hover:border-accent-green transition-all duration-300 active" onclick="selectAccountType(this, 'Developer')" id="developer-btn">
                            <i class="fas fa-code text-accent-green text-xl mb-2"></i>
                            <span class="text-sm font-medium">Work as a Developer</span>
                        </button>
                        <button type="button" class="account-type-btn flex flex-col items-center p-4 border rounded-lg bg-secondary-dark hover:border-accent-green transition-all duration-300" onclick="selectAccountType(this, 'Client')" id="client-btn">
                            <i class="fas fa-briefcase text-accent-green text-xl mb-2"></i>
                            <span class="text-sm font-medium">Hire a Developer</span>
                        </button>
                    </div>
                    <input type="hidden" id="role" name="role" value="Developer">
                    <x-input-error :messages="$errors->get('role')" class="mt-2" />
                </div>

                <!-- Name -->
                <div class="space-y-2">
                    <label for="name" class="block text-sm font-medium text-text-secondary">Full Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" class="w-full pl-4 pr-4 py-3 bg-secondary-dark border border-border-custom rounded-lg text-text-primary placeholder-text-muted focus:outline-none focus:ring-2 focus:ring-accent-green transition-colors" placeholder="Enter your full name">
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div class="space-y-2">
                    <label for="email" class="block text-sm font-medium text-text-secondary">Email Address</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="username" class="w-full pl-4 pr-4 py-3 bg-secondary-dark border border-border-custom rounded-lg text-text-primary placeholder-text-muted focus:outline-none focus:ring-2 focus:ring-accent-green transition-colors" placeholder="Enter your email">
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="space-y-2">
                    <label for="password" class="block text-sm font-medium text-text-secondary">Password</label>
                    <input type="password" id="password" name="password" required autocomplete="new-password" class="w-full pl-4 pr-4 py-3 bg-secondary-dark border border-border-custom rounded-lg text-text-primary placeholder-text-muted focus:outline-none focus:ring-2 focus:ring-accent-green transition-colors" placeholder="Create a password">
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="space-y-2">
                    <label for="password_confirmation" class="block text-sm font-medium text-text-secondary">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password" class="w-full pl-4 pr-4 py-3 bg-secondary-dark border border-border-custom rounded-lg text-text-primary placeholder-text-muted focus:outline-none focus:ring-2 focus:ring-accent-green transition-colors" placeholder="Confirm your password">
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>
                
                <button type="submit" class="w-full bg-accent-green hover:bg-accent-green-hover text-white py-3 rounded-lg font-semibold transition-all duration-300 hover:-translate-y-1 shadow-lg hover:shadow-xl">
                    <i class="fas fa-user-plus mr-2"></i>Create Account
                </button>
            </form>
            <div class="mt-8 text-center">
                <p class="text-text-secondary">
                    Already have an account?
                    <a href="{{ route('login') }}" class="text-accent-green hover:text-accent-green-hover font-medium transition-colors duration-300">
                        Sign in here
                    </a>
                </p>
            </div>
        </div>
    </div>

    <script>
        function selectAccountType(selectedButton, type) {
            document.getElementById('role').value = type;
            document.querySelectorAll('.account-type-btn').forEach(btn => btn.classList.remove('active'));
            selectedButton.classList.add('active');
        }
        // Set default on load
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('developer-btn').classList.add('active');
        });
    </script>
</x-guest-layout>
