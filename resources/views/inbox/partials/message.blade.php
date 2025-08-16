<div class="flex {{ $message->isFromCurrentUser() ? 'justify-end' : 'justify-start' }} mb-4">
    <div class="max-w-xs lg:max-w-md">
        <div class="flex items-end space-x-3 {{ $message->isFromCurrentUser() ? 'flex-row-reverse space-x-reverse' : '' }}">
            <!-- User Avatar -->
            <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 overflow-hidden shadow-md">
                @if($message->sender->avatar_url)
                    <img src="{{ $message->sender->avatar_url }}" alt="{{ $message->sender->name }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-gradient-to-br from-accent-green to-accent-green-hover flex items-center justify-center text-white font-bold text-sm">
                        {{ $message->sender->initial }}
                    </div>
                @endif
            </div>
            
            <!-- Message Bubble -->
            <div class="flex flex-col {{ $message->isFromCurrentUser() ? 'items-end' : 'items-start' }}">
                <div class="px-5 py-3 {{ $message->isFromCurrentUser() 
                    ? 'bg-gradient-to-r from-accent-green to-accent-green-hover text-white rounded-3xl rounded-br-lg shadow-lg' 
                    : 'bg-secondary-dark text-text-primary border border-border-custom rounded-3xl rounded-bl-lg shadow-md' }}">
                    <p class="text-sm leading-relaxed break-words">{{ $message->body }}</p>
                </div>
                
                <!-- Message Info -->
                <div class="flex items-center space-x-2 mt-2 {{ $message->isFromCurrentUser() ? 'flex-row-reverse space-x-reverse' : '' }}">
                    <span class="text-xs text-text-muted font-medium">
                        {{ $message->created_at->format('g:i A') }}
                    </span>
                    
                    @if($message->isFromCurrentUser())
                        <span class="text-xs {{ $message->is_read ? 'text-accent-green' : 'text-text-muted' }} transition-colors">
                            <i class="fas {{ $message->is_read ? 'fa-check-double' : 'fa-check' }}"></i>
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>



