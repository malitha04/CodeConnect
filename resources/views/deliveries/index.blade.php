@extends('layouts.dashboard')

@section('title', 'My Deliveries')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-text-primary">My Project Deliveries</h1>
        <p class="text-text-secondary mt-2">Track all your project deliveries and their status.</p>
    </div>

    @if(session('status'))
        <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
            {{ session('status') }}
        </div>
    @endif

    @if($deliveries->count() > 0)
        <div class="bg-card-dark border border-border-custom rounded-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-secondary-dark border-b border-border-custom">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-medium text-text-primary">Project</th>
                            <th class="px-6 py-4 text-left text-sm font-medium text-text-primary">Delivery Type</th>
                            <th class="px-6 py-4 text-left text-sm font-medium text-text-primary">Status</th>
                            <th class="px-6 py-4 text-left text-sm font-medium text-text-primary">Submitted</th>
                            <th class="px-6 py-4 text-left text-sm font-medium text-text-primary">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border-custom">
                        @foreach($deliveries as $delivery)
                            <tr class="hover:bg-secondary-dark transition-colors">
                                <td class="px-6 py-4">
                                    <div>
                                        <h3 class="font-medium text-text-primary">{{ $delivery->project->title }}</h3>
                                        <p class="text-sm text-text-secondary">Client: {{ $delivery->project->user->name }}</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($delivery->delivery_type === 'file') bg-blue-100 text-blue-800
                                        @elseif($delivery->delivery_type === 'github') bg-green-100 text-green-800
                                        @else bg-purple-100 text-purple-800
                                        @endif">
                                        @if($delivery->delivery_type === 'file')
                                            <i class="fas fa-file mr-1"></i>File
                                        @elseif($delivery->delivery_type === 'github')
                                            <i class="fab fa-github mr-1"></i>GitHub
                                        @else
                                            <i class="fas fa-link mr-1"></i>Link
                                        @endif
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($delivery->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($delivery->status === 'approved') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst($delivery->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-text-secondary">
                                    {{ $delivery->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('deliveries.show', $delivery) }}" 
                                           class="text-accent-green hover:text-accent-green-hover text-sm">
                                            <i class="fas fa-eye mr-1"></i>View
                                        </a>
                                        @if($delivery->delivery_type === 'file')
                                            <a href="{{ route('deliveries.download', $delivery) }}" 
                                               class="text-blue-500 hover:text-blue-600 text-sm">
                                                <i class="fas fa-download mr-1"></i>Download
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">
            {{ $deliveries->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <div class="w-24 h-24 bg-secondary-dark rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-box-open text-4xl text-text-secondary"></i>
            </div>
            <h3 class="text-xl font-medium text-text-primary mb-2">No Deliveries Yet</h3>
            <p class="text-text-secondary mb-6">You haven't submitted any project deliveries yet.</p>
            <a href="{{ route('projects.browse') }}" 
               class="inline-flex items-center px-4 py-2 bg-accent-green hover:bg-accent-green-hover text-white rounded-lg transition-colors">
                <i class="fas fa-search mr-2"></i>Browse Projects
            </a>
        </div>
    @endif
</div>
@endsection
