@extends('layouts.dashboard')

@section('title', 'Conversation with ' . $otherUser->name)

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6 pb-6 border-b border-border-custom">
            <div class="flex items-center space-x-4">
                <a href="{{ route('inbox.index') }}" class="text-text-secondary hover:text-text-primary">
                    <i class="fas fa-arrow-left text-lg"></i>
                </a>
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-accent-green/20 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-accent-green"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-text-primary">{{ $otherUser->name }}</h1>
                        <p class="text-text-secondary text-sm">
                            {{ $otherUser->hasRole('Developer') ? 'Developer' : 'Client' }}
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="flex items-center space-x-3">
                <form action="{{ route('inbox.destroy', $conversation) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this conversation?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500 hover:text-red-400 transition-colors">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </div>
        </div>

        <!-- Messages Container -->
        <div class="bg-card-dark border border-border-custom rounded-2xl p-6 mb-6 shadow-lg" style="height: 500px; overflow-y: auto;" id="messages-container">
            @if($messages->isEmpty())
                <div class="text-center py-8">
                    <i class="fas fa-comments text-4xl text-text-muted mb-4"></i>
                    <p class="text-text-secondary">No messages yet. Start the conversation!</p>
                </div>
            @else
                <div class="space-y-4" id="messages-list">
                    @foreach($messages as $message)
                        @include('inbox.partials.message', ['message' => $message])
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Message Input -->
        <div class="bg-card-dark border border-border-custom rounded-2xl p-6 shadow-lg">
            <form id="message-form" class="flex items-end space-x-4">
                @csrf
                <div class="flex-1">
                    <textarea 
                        id="message-body" 
                        name="body" 
                        rows="1" 
                        class="w-full bg-secondary-dark border-0 rounded-full px-6 py-4 text-text-primary placeholder-text-muted resize-none focus:outline-none focus:ring-2 focus:ring-accent-green/50 shadow-inner transition-all duration-200"
                        placeholder="Type your message here..."
                        required
                        style="min-height: 52px; max-height: 120px;"
                    ></textarea>
                </div>
                <button 
                    type="submit" 
                    class="bg-accent-green hover:bg-accent-green-hover text-white w-12 h-12 rounded-full font-medium transition-all duration-200 hover:scale-105 shadow-lg flex items-center justify-center"
                    id="send-button"
                >
                    <i class="fas fa-paper-plane text-lg"></i>
                </button>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const messagesContainer = document.getElementById('messages-container');
            const messagesList = document.getElementById('messages-list');
            const messageForm = document.getElementById('message-form');
            const messageBody = document.getElementById('message-body');
            const sendButton = document.getElementById('send-button');

            // Scroll to bottom of messages
            function scrollToBottom() {
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }

            // Scroll to bottom on page load
            scrollToBottom();

            // Handle message submission
            messageForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const body = messageBody.value.trim();
                if (!body) return;

                // Disable send button
                sendButton.disabled = true;
                sendButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Sending...';

                // Send message via AJAX
                fetch('{{ route("inbox.sendMessage", $conversation) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ body: body })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.html) {
                        // Add new message to the list
                        if (messagesList) {
                            messagesList.insertAdjacentHTML('beforeend', data.html);
                        } else {
                            // If no messages list exists, create one
                            messagesContainer.innerHTML = `<div class="space-y-4" id="messages-list">${data.html}</div>`;
                        }
                        
                        // Clear input
                        messageBody.value = '';
                        
                        // Scroll to bottom
                        scrollToBottom();
                        
                        // Update unread count in header if it exists
                        const unreadCountElement = document.querySelector('[data-unread-count]');
                        if (unreadCountElement) {
                            const currentCount = parseInt(unreadCountElement.textContent) || 0;
                            unreadCountElement.textContent = Math.max(0, currentCount - 1);
                        }
                    }
                })
                .catch(error => {
                    console.error('Error sending message:', error);
                    alert('Failed to send message. Please try again.');
                })
                .finally(() => {
                    // Re-enable send button
                    sendButton.disabled = false;
                    sendButton.innerHTML = '<i class="fas fa-paper-plane mr-2"></i>Send';
                });
            });

            // Auto-resize textarea
            messageBody.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = Math.min(this.scrollHeight, 120) + 'px';
            });

            // Focus on message input
            messageBody.focus();
        });
    </script>
    @endpush
@endsection



