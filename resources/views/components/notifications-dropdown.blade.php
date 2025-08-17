<div x-data="notificationsDropdown()" class="relative">
    <button @click="toggle()" class="relative p-2 text-gray-500 hover:text-gray-700 transition-colors" aria-label="Notifications">
        <i class="fas fa-bell text-xl"></i>
        <template x-if="unreadCount > 0">
            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 min-w-[1.25rem] px-1 flex items-center justify-center" x-text="unreadCount > 9 ? '9+' : unreadCount"></span>
        </template>
    </button>

    <div x-show="open" @click.outside="open = false" x-transition
         class="absolute right-0 mt-2 w-80 bg-white shadow-lg rounded-lg ring-1 ring-black ring-opacity-5 z-50"
         style="display: none;">
        <div class="flex items-center justify-between px-4 py-2 border-b">
            <h3 class="font-semibold text-gray-800">Notifications</h3>
            <button @click="markAllAsRead" class="text-xs text-blue-600 hover:underline" x-bind:disabled="loading || unreadCount === 0">Mark all as read</button>
        </div>
        <div class="max-h-96 overflow-y-auto" x-show="items.length > 0">
            <template x-for="item in items" :key="item.id">
                <div class="px-4 py-3 border-b last:border-b-0 hover:bg-gray-50 flex items-start gap-3 cursor-pointer"
                     @click="goTo(item)">
                    <div class="mt-1">
                        <template x-if="(item.data && item.data.type) ? item.data.type === 'message' : item.type === 'MessageReceived' || item.type === 'message'">
                            <i class="fas fa-envelope text-sm" :class="item.read_at ? 'text-gray-300' : 'text-blue-500'"></i>
                        </template>
                        <template x-if="!((item.data && item.data.type) ? item.data.type === 'message' : item.type === 'MessageReceived' || item.type === 'message')">
                            <i class="fas fa-bell text-sm" :class="item.read_at ? 'text-gray-300' : 'text-blue-500'"></i>
                        </template>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-800" x-text="formatItem(item)"></p>
                        <p class="text-xs text-gray-500 mt-1" x-text="item.created_human"></p>
                    </div>
                    <button class="text-xs text-blue-600 hover:underline" x-show="!item.read_at" @click.stop="markAsRead(item)">Mark read</button>
                </div>
            </template>
        </div>
        <div class="p-4 text-sm text-gray-500" x-show="!loading && items.length === 0">
            No notifications
        </div>
        <div class="p-4 text-sm text-gray-500" x-show="loading">Loading...</div>
        <div class="px-4 py-2 border-t bg-gray-50 text-right">
            <a href="{{ route('notifications.index') }}" class="text-blue-600 hover:underline text-sm">View all</a>
        </div>
    </div>

    <script>
        function notificationsDropdown() {
            return {
                open: false,
                loading: false,
                items: [],
                unreadCount: 0,
                fetchedOnce: false,
                toggle() {
                    this.open = !this.open;
                    if (this.open && !this.fetchedOnce) {
                        this.fetchFeed();
                    }
                },
                fetchUnreadCount() {
                    fetch("{{ route('notifications.unreadCount') }}", { headers: { 'X-Requested-With': 'XMLHttpRequest' }})
                        .then(r => r.json())
                        .then(d => { this.unreadCount = d.count ?? 0; })
                        .catch(() => {});
                },
                fetchFeed() {
                    this.loading = true;
                    fetch("{{ route('notifications.feed') }}", { headers: { 'X-Requested-With': 'XMLHttpRequest' }})
                        .then(r => r.json())
                        .then(d => {
                            this.items = d.items ?? [];
                            this.unreadCount = d.unread_count ?? 0;
                            this.fetchedOnce = true;
                        })
                        .finally(() => { this.loading = false; });
                },
                markAllAsRead() {
                    if (this.unreadCount === 0) return;
                    fetch("{{ route('notifications.markAllAsRead') }}", {
                        method: 'PATCH',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content'),
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    }).then(() => {
                        this.items = this.items.map(i => ({ ...i, read_at: new Date().toISOString() }));
                        this.unreadCount = 0;
                    });
                },
                markAsRead(item) {
                    fetch("{{ url('/notifications') }}/" + item.id + "/mark-read", {
                        method: 'PATCH',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content'),
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    }).then(() => {
                        item.read_at = new Date().toISOString();
                        this.unreadCount = Math.max(0, this.unreadCount - 1);
                    });
                },
                goTo(item) {
                    const link = item?.data?.link;
                    if (!link) return;
                    const navigate = () => window.location = link;
                    if (!item.read_at) {
                        fetch("{{ url('/notifications') }}/" + item.id + "/mark-read", {
                            method: 'PATCH',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content'),
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        }).finally(navigate);
                    } else {
                        navigate();
                    }
                },
                formatItem(item) {
                    // Basic formatter; customize based on your notification types
                    if (item.data && item.data.message) return item.data.message;
                    if (item.type) return item.type + ' notification';
                    return 'You have a new notification';
                },
                init() {
                    // initial count and periodic refresh of badge
                    this.fetchUnreadCount();
                    setInterval(() => this.fetchUnreadCount(), 30000);
                }
            };
        }
    </script>
</div>
