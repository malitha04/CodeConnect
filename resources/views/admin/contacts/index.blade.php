@extends('layouts.admin')

@section('content')
<div>
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-text-primary">Contact Messages</h1>
            <p class="text-text-secondary mt-2">Manage and respond to messages from users.</p>
        </div>
        <a href="{{ route('admin.contacts.export') }}" class="px-4 py-2 font-medium transition-colors rounded-lg bg-accent-green hover:bg-accent-green-hover text-white">
            <i class="mr-2 fas fa-download"></i>Export Contacts
        </a>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-4">
        <div class="p-6 border bg-card-dark border-border-custom rounded-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-text-secondary">Total Messages</p>
                    <p class="mt-1 text-3xl font-bold">{{ $stats['total'] }}</p>
                </div>
                <div class="text-3xl opacity-50 text-accent-green">
                    <i class="fas fa-envelope"></i>
                </div>
            </div>
        </div>
        <div class="p-6 border bg-card-dark border-border-custom rounded-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-text-secondary">Unread</p>
                    <p class="mt-1 text-3xl font-bold">{{ $stats['unread'] }}</p>
                </div>
                <div class="text-3xl opacity-50 text-red-500">
                    <i class="fas fa-exclamation-circle"></i>
                </div>
            </div>
        </div>
        <div class="p-6 border bg-card-dark border-border-custom rounded-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-text-secondary">Read</p>
                    <p class="mt-1 text-3xl font-bold">{{ $stats['read'] }}</p>
                </div>
                <div class="text-3xl opacity-50 text-yellow-500">
                    <i class="fas fa-eye"></i>
                </div>
            </div>
        </div>
        <div class="p-6 border bg-card-dark border-border-custom rounded-xl">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-text-secondary">Replied</p>
                    <p class="mt-1 text-3xl font-bold">{{ $stats['replied'] }}</p>
                </div>
                <div class="text-3xl opacity-50 text-green-500">
                    <i class="fas fa-reply"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Messages Table -->
    <div class="bg-card-dark border border-border-custom rounded-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-secondary-dark border-b border-border-custom">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-medium text-text-primary">Name</th>
                        <th class="px-6 py-4 text-left text-sm font-medium text-text-primary">Email</th>
                        <th class="px-6 py-4 text-left text-sm font-medium text-text-primary">Subject</th>
                        <th class="px-6 py-4 text-left text-sm font-medium text-text-primary">Status</th>
                        <th class="px-6 py-4 text-left text-sm font-medium text-text-primary">Date</th>
                        <th class="px-6 py-4 text-left text-sm font-medium text-text-primary">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border-custom">
                    @forelse ($contacts as $contact)
                        <tr class="hover:bg-secondary-dark transition-colors">
                            <td class="px-6 py-4">
                                <div>
                                    <p class="font-medium text-text-primary">{{ $contact->name }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-text-secondary">{{ $contact->email }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-text-primary">{{ Str::limit($contact->subject, 50) }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $contact->status_badge_class }}">
                                    {{ $contact->status_display }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-text-secondary">
                                {{ $contact->created_at->format('M d, Y g:i A') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('admin.contacts.show', $contact) }}" 
                                       class="text-accent-green hover:text-accent-green-hover transition-colors">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($contact->status === 'unread')
                                        <form action="{{ route('admin.contacts.read', $contact) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-yellow-500 hover:text-yellow-400 transition-colors">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                    @endif
                                    <form action="{{ route('admin.contacts.delete', $contact) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-400 transition-colors" 
                                                onclick="return confirm('Are you sure you want to delete this message?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-text-muted">
                                <div class="text-6xl text-text-secondary mb-4">
                                    <i class="fas fa-inbox"></i>
                                </div>
                                <h3 class="text-xl font-medium text-text-primary mb-2">No Contact Messages</h3>
                                <p class="text-text-secondary">No messages have been sent yet.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($contacts->hasPages())
        <div class="mt-6">
            {{ $contacts->links() }}
        </div>
    @endif
</div>
@endsection


