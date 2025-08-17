@extends('layouts.admin')

@section('content')
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-3xl font-bold">Manage Users</h1>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('admin.users.export') }}" class="px-4 py-2 font-medium transition-colors rounded-lg bg-accent-green hover:bg-accent-green-hover text-white">
                        <i class="mr-2 fas fa-download"></i>Export Users
                    </a>
                    <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 font-medium transition-colors rounded-lg bg-secondary-dark hover:bg-card-dark text-text-primary">
                        <i class="mr-2 fas fa-arrow-left"></i>Back to Dashboard
                    </a>
                </div>
            </div>

            <!-- Search and Filters -->
            <div class="flex flex-col items-center justify-between p-4 mb-6 border bg-card-dark border-border-custom rounded-xl sm:flex-row">
                <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-col w-full gap-4 sm:flex-row sm:items-center">
                    <div class="relative flex-1">
                        <input 
                            type="text" 
                            name="search" 
                            value="{{ request('search') }}"
                            placeholder="Search users by name or email..." 
                            class="w-full py-2 pl-10 pr-4 border rounded-lg bg-secondary-dark border-border-custom text-text-primary focus:outline-none focus:ring-1 focus:ring-accent-green"
                        >
                        <i class="absolute -translate-y-1/2 fas fa-search left-3 top-1/2 text-text-secondary"></i>
                    </div>
                    <div class="flex items-center gap-4">
                        <select name="role" class="px-3 py-2 border rounded-lg bg-secondary-dark border-border-custom text-text-primary focus:outline-none focus:ring-1 focus:ring-accent-green">
                            <option value="">All Roles</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}" {{ request('role') == $role->name ? 'selected' : '' }}>
                                    {{ ucfirst($role->name) }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="px-4 py-2 font-medium transition-colors rounded-lg bg-accent-green hover:bg-accent-green-hover text-text-primary">
                            <i class="mr-2 fas fa-search"></i>Search
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="px-4 py-2 font-medium transition-colors rounded-lg bg-secondary-dark hover:bg-card-dark text-text-primary">
                            <i class="mr-2 fas fa-times"></i>Clear
                        </a>
                    </div>
                </form>
            </div>

            <!-- User Table -->
            <div class="overflow-x-auto border bg-card-dark border-border-custom rounded-xl">
                <table class="w-full text-left whitespace-nowrap">
                    <thead class="bg-secondary-dark">
                        <tr>
                            <th class="p-4 text-text-muted">User ID</th>
                            <th class="p-4 text-text-muted">User Name</th>
                            <th class="p-4 text-text-muted">Email</th>
                            <th class="p-4 text-text-muted">Role</th>
                            <th class="p-4 text-text-muted">Status</th>
                            <th class="p-4 text-text-muted">Registered On</th>
                            <th class="p-4 text-center text-text-muted">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr class="border-b border-border-custom hover:bg-secondary-dark/50">
                                <td class="p-4 text-text-muted">#{{ $user->id }}</td>
                                <td class="p-4 font-medium">{{ $user->name }}</td>
                                <td class="p-4 text-text-secondary">{{ $user->email }}</td>
                                <td class="p-4">
                                    @if($user->hasRole('Admin'))
                                        <span class="px-2 py-1 text-sm font-medium rounded-full bg-accent-red/20 text-accent-red">Admin</span>
                                    @elseif($user->hasRole('Developer'))
                                        <span class="px-2 py-1 text-sm font-medium rounded-full bg-accent-green/20 text-accent-green">Developer</span>
                                    @elseif($user->hasRole('Client'))
                                        <span class="px-2 py-1 text-sm font-medium rounded-full bg-accent-blue/20 text-accent-blue">Client</span>
                                    @else
                                        <span class="px-2 py-1 text-sm font-medium rounded-full bg-gray-500/20 text-gray-500">No Role</span>
                                    @endif
                                </td>
                                <td class="p-4">
                                    @if($user->id === auth()->id())
                                        <span class="text-accent-green">● Current User</span>
                                    @else
                                        <span class="text-green-500">● Active</span>
                                    @endif
                                </td>
                                <td class="p-4 text-text-secondary">{{ $user->created_at->format('Y-m-d') }}</td>
                                <td class="p-4 text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="{{ route('admin.users.show', $user) }}" class="p-2 text-accent-blue hover:text-blue-400" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.users.edit', $user) }}" class="p-2 text-accent-orange hover:text-orange-400" title="Edit User">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        @if($user->id !== auth()->id())
                                            <form method="POST" action="{{ route('admin.users.delete', $user) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 text-accent-red hover:text-red-400" title="Delete User">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        @else
                                            <span class="p-2 text-gray-500 cursor-not-allowed" title="Cannot delete your own account">
                                                <i class="fas fa-trash-alt"></i>
                                            </span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-8 text-center text-text-muted">
                                    <div class="flex flex-col items-center">
                                        <i class="text-4xl mb-4 fas fa-users text-text-muted"></i>
                                        <p class="text-lg font-medium">No users found</p>
                                        <p class="text-sm">Try adjusting your search criteria</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($users->hasPages())
                <div class="flex items-center justify-between mt-6">
                    <p class="text-sm text-text-muted">
                        Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ $users->total() }} users
                    </p>
                    <div class="flex items-center gap-2">
                        @if($users->onFirstPage())
                            <span class="px-4 py-2 font-bold rounded-lg bg-secondary-dark text-text-muted cursor-not-allowed">&laquo; Prev</span>
                        @else
                            <a href="{{ $users->previousPageUrl() }}" class="px-4 py-2 font-bold rounded-lg bg-secondary-dark hover:bg-border-custom text-text-secondary">&laquo; Prev</a>
                        @endif
                        
                        @foreach($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                            @if($page == $users->currentPage())
                                <span class="px-4 py-2 font-bold rounded-lg bg-accent-green text-white">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="px-4 py-2 font-bold rounded-lg bg-secondary-dark hover:bg-border-custom text-text-secondary">{{ $page }}</a>
                            @endif
                        @endforeach
                        
                        @if($users->hasMorePages())
                            <a href="{{ $users->nextPageUrl() }}" class="px-4 py-2 font-bold rounded-lg bg-secondary-dark hover:bg-border-custom text-text-secondary">Next &raquo;</a>
                        @else
                            <span class="px-4 py-2 font-bold rounded-lg bg-secondary-dark text-text-muted cursor-not-allowed">Next &raquo;</span>
                        @endif
                    </div>
                </div>
            @endif
@endsection
