@extends('layouts.dashboard')

@section('title', 'Settings')

@section('content')
        <!-- Main Content Area -->
        <main class="overflow-x-hidden">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-3xl font-bold">Settings</h1>
                <a href="{{ route('dashboard') }}" class="px-4 py-2 font-medium transition-colors rounded-lg bg-secondary-dark hover:bg-card-dark text-text-primary">
                    <i class="mr-2 fas fa-arrow-left"></i>Back to Dashboard
                </a>
            </div>

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                <!-- Profile Settings -->
                <div class="p-6 border bg-card-dark border-border-custom rounded-xl">
                    <h2 class="mb-6 text-xl font-semibold">Profile Settings</h2>
                    
                    <form method="POST" action="{{ route('settings.profile') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Profile Picture -->
                        <div class="mb-6">
                            <label class="block mb-2 text-sm font-medium text-text-secondary">Profile Picture</label>
                            <div class="flex items-center space-x-4">
                                <div class="w-20 h-20 overflow-hidden border-2 border-accent-green rounded-full">
                                    @if($user->profile_picture_url)
                            <img src="{{ $user->profile_picture_url }}" class="w-full h-full object-cover" alt="{{ $user->name }}">
                        @else
                            <div class="w-full h-full bg-accent-green flex items-center justify-center text-white font-bold text-4xl">
                                {{ $user->initial }}
                            </div>
                        @endif
                                </div>
                                <div class="flex-1">
                                    <input type="file" name="profile_picture" accept="image/*" class="block w-full text-sm text-text-secondary file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-accent-green file:text-white hover:file:bg-accent-green-hover">
                                    <p class="mt-1 text-xs text-text-muted">JPG, PNG, GIF up to 2MB</p>
                                </div>
                            </div>
                            @if($user->profile_picture)
                                <form method="POST" action="{{ route('settings.remove-picture') }}" class="mt-2">
                                    @csrf
                                    <button type="submit" class="text-sm text-red-400 hover:text-red-300">
                                        <i class="mr-1 fas fa-trash"></i>Remove current picture
                                    </button>
                                </form>
                            @endif
                        </div>

                        <!-- Name -->
                        <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-text-secondary">Name</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="w-full px-3 py-2 border rounded-lg bg-secondary-dark border-border-custom text-text-primary focus:outline-none focus:ring-1 focus:ring-accent-green @error('name') border-red-500 @enderror" required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-6">
                            <label for="email" class="block mb-2 text-sm font-medium text-text-secondary">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="w-full px-3 py-2 border rounded-lg bg-secondary-dark border-border-custom text-text-primary focus:outline-none focus:ring-1 focus:ring-accent-green @error('email') border-red-500 @enderror" required>
                            @error('email')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="w-full px-4 py-2 font-medium transition-colors rounded-lg bg-accent-green hover:bg-accent-green-hover text-text-primary">
                            <i class="mr-2 fas fa-save"></i>Update Profile
                        </button>
                    </form>
                </div>

                <!-- Password Settings -->
                <div class="p-6 border bg-card-dark border-border-custom rounded-xl">
                    <h2 class="mb-6 text-xl font-semibold">Password Settings</h2>
                    
                    <form method="POST" action="{{ route('settings.password') }}">
                        @csrf
                        
                        <!-- Current Password -->
                        <div class="mb-4">
                            <label for="current_password" class="block mb-2 text-sm font-medium text-text-secondary">Current Password</label>
                            <input type="password" id="current_password" name="current_password" class="w-full px-3 py-2 border rounded-lg bg-secondary-dark border-border-custom text-text-primary focus:outline-none focus:ring-1 focus:ring-accent-green @error('current_password') border-red-500 @enderror" required>
                            @error('current_password')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- New Password -->
                        <div class="mb-4">
                            <label for="password" class="block mb-2 text-sm font-medium text-text-secondary">New Password</label>
                            <input type="password" id="password" name="password" class="w-full px-3 py-2 border rounded-lg bg-secondary-dark border-border-custom text-text-primary focus:outline-none focus:ring-1 focus:ring-accent-green @error('password') border-red-500 @enderror" required>
                            @error('password')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Confirm New Password -->
                        <div class="mb-6">
                            <label for="password_confirmation" class="block mb-2 text-sm font-medium text-text-secondary">Confirm New Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="w-full px-3 py-2 border rounded-lg bg-secondary-dark border-border-custom text-text-primary focus:outline-none focus:ring-1 focus:ring-accent-green" required>
                        </div>

                        <button type="submit" class="w-full px-4 py-2 font-medium transition-colors rounded-lg bg-accent-orange hover:bg-orange-600 text-text-primary">
                            <i class="mr-2 fas fa-key"></i>Update Password
                        </button>
                    </form>
                </div>
            </div>

            <!-- Account Information -->
            <div class="mt-6 p-6 border bg-card-dark border-border-custom rounded-xl">
                <h2 class="mb-6 text-xl font-semibold">Account Information</h2>
                
                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    <div class="p-4 border border-border-custom rounded-lg bg-secondary-dark">
                        <p class="text-sm text-text-secondary">Account Type</p>
                        <p class="text-lg font-bold text-text-primary">
                            @if($user->hasRole('Admin'))
                                <span class="text-accent-red">Admin</span>
                            @elseif($user->hasRole('Developer'))
                                <span class="text-accent-green">Developer</span>
                            @elseif($user->hasRole('Client'))
                                <span class="text-accent-blue">Client</span>
                            @else
                                <span class="text-gray-500">No Role</span>
                            @endif
                        </p>
                    </div>
                    
                    <div class="p-4 border border-border-custom rounded-lg bg-secondary-dark">
                        <p class="text-sm text-text-secondary">Member Since</p>
                        <p class="text-lg font-bold text-text-primary">{{ $user->created_at->format('M j, Y') }}</p>
                    </div>
                    
                    <div class="p-4 border border-border-custom rounded-lg bg-secondary-dark">
                        <p class="text-sm text-text-secondary">Last Updated</p>
                        <p class="text-lg font-bold text-text-primary">{{ $user->updated_at->format('M j, Y') }}</p>
                    </div>
                </div>
            </div>
        </main>

<script>
    // Auto-hide success/error messages after 5 seconds
    setTimeout(() => {
        const messages = document.querySelectorAll('[class*="bg-green-500"], [class*="bg-red-500"]');
        messages.forEach(msg => {
            msg.style.display = 'none';
        });
    }, 5000);

    // Preview profile picture before upload
    document.querySelector('input[name="profile_picture"]').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.querySelector('.w-20.h-20 img').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection
