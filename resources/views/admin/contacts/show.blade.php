@extends('layouts.admin')

@section('content')
<div>
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-text-primary">Contact Message</h1>
                <p class="text-text-secondary mt-2">View and respond to user message.</p>
            </div>
            <a href="{{ route('admin.contacts.index') }}" class="bg-secondary-dark hover:bg-card-dark text-text-primary px-4 py-2 rounded-lg font-medium transition-colors border border-border-custom">
                <i class="fas fa-arrow-left mr-2"></i>Back to Messages
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-6 p-4 bg-green-600/20 border border-green-500/50 rounded-lg">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                <p class="text-green-500">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
        <!-- Message Details -->
        <div class="space-y-6">
            <!-- Message Info -->
            <div class="bg-card-dark border border-border-custom rounded-xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold">Message Details</h2>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $contact->status_badge_class }}">
                        {{ $contact->status_display }}
                    </span>
                </div>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-text-secondary mb-1">From</label>
                        <p class="text-text-primary font-medium">{{ $contact->name }}</p>
                        <p class="text-text-secondary text-sm">{{ $contact->email }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-text-secondary mb-1">Subject</label>
                        <p class="text-text-primary">{{ $contact->subject }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-text-secondary mb-1">Message</label>
                        <div class="bg-secondary-dark p-4 rounded-lg">
                            <p class="text-text-primary whitespace-pre-wrap">{{ $contact->message }}</p>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-text-secondary mb-1">Received</label>
                        <p class="text-text-secondary">{{ $contact->created_at->format('F d, Y \a\t g:i A') }}</p>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-card-dark border border-border-custom rounded-xl p-6">
                <h3 class="text-lg font-semibold mb-4">Actions</h3>
                <div class="space-y-3">
                    @if($contact->status === 'unread')
                        <form action="{{ route('admin.contacts.read', $contact) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                                <i class="fas fa-check mr-2"></i>Mark as Read
                            </button>
                        </form>
                    @endif
                    
                    <form action="{{ route('admin.contacts.delete', $contact) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg font-medium transition-colors" 
                                onclick="return confirm('Are you sure you want to delete this message?')">
                            <i class="fas fa-trash mr-2"></i>Delete Message
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Reply Section -->
        <div class="space-y-6">
            <!-- Admin Reply Form -->
            <div class="bg-card-dark border border-border-custom rounded-xl p-6">
                <h2 class="text-xl font-semibold mb-4">Send Reply</h2>
                
                <form action="{{ route('admin.contacts.reply', $contact) }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="admin_reply" class="block text-sm font-medium text-text-secondary mb-2">Your Reply</label>
                            <textarea id="admin_reply" name="admin_reply" rows="8" 
                                      class="w-full bg-secondary-dark border border-border-custom rounded-lg px-4 py-3 text-text-primary focus:outline-none focus:ring-2 focus:ring-accent-green transition-colors" 
                                      placeholder="Type your reply here..." required>{{ old('admin_reply', $contact->admin_reply) }}</textarea>
                        </div>
                        
                        <button type="submit" class="w-full bg-accent-green hover:bg-accent-green-hover text-white px-6 py-3 rounded-lg font-medium transition-colors">
                            <i class="fas fa-paper-plane mr-2"></i>Send Reply
                        </button>
                    </div>
                </form>
            </div>

            <!-- Previous Reply (if exists) -->
            @if($contact->admin_reply)
                <div class="bg-card-dark border border-border-custom rounded-xl p-6">
                    <h3 class="text-lg font-semibold mb-4">Previous Reply</h3>
                    <div class="bg-secondary-dark p-4 rounded-lg">
                        <p class="text-text-primary whitespace-pre-wrap">{{ $contact->admin_reply }}</p>
                    </div>
                    <p class="text-text-secondary text-sm mt-2">
                        Replied on {{ $contact->replied_at->format('F d, Y \a\t g:i A') }}
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection


