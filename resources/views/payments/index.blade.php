@extends('layouts.dashboard')

@section('title', 'Payments')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-text-primary">
            @if(Auth::user()->hasRole('Client'))
                My Payments
            @else
                Received Payments
            @endif
        </h1>
        <p class="text-text-secondary mt-2">
            @if(Auth::user()->hasRole('Client'))
                Track all payments you've made to developers.
            @else
                Track all payments you've received from clients.
            @endif
        </p>
    </div>

    @if($payments->count() > 0)
        <div class="bg-card-dark border border-border-custom rounded-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-secondary-dark border-b border-border-custom">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-medium text-text-primary">Project</th>
                            <th class="px-6 py-4 text-left text-sm font-medium text-text-primary">
                                @if(Auth::user()->hasRole('Client'))
                                    Developer
                                @else
                                    Client
                                @endif
                            </th>
                            <th class="px-6 py-4 text-left text-sm font-medium text-text-primary">Amount</th>
                            <th class="px-6 py-4 text-left text-sm font-medium text-text-primary">Method</th>
                            <th class="px-6 py-4 text-left text-sm font-medium text-text-primary">Status</th>
                            <th class="px-6 py-4 text-left text-sm font-medium text-text-primary">Date</th>
                            <th class="px-6 py-4 text-left text-sm font-medium text-text-primary">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border-custom">
                        @foreach($payments as $payment)
                            <tr class="hover:bg-secondary-dark transition-colors">
                                <td class="px-6 py-4">
                                    <div>
                                        <h3 class="font-medium text-text-primary">{{ $payment->project->title }}</h3>
                                        <p class="text-sm text-text-secondary">{{ Str::limit($payment->project->description, 50) }}</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div>
                                        <p class="font-medium text-text-primary">
                                            @if(Auth::user()->hasRole('Client'))
                                                {{ $payment->developer->name }}
                                            @else
                                                {{ $payment->client->name }}
                                            @endif
                                        </p>
                                        <p class="text-sm text-text-secondary">
                                            @if(Auth::user()->hasRole('Client'))
                                                {{ $payment->developer->email }}
                                            @else
                                                {{ $payment->client->email }}
                                            @endif
                                        </p>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-accent-green font-bold">${{ number_format($payment->amount, 2) }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($payment->payment_method === 'stripe') bg-blue-100 text-blue-800
                                        @elseif($payment->payment_method === 'paypal') bg-blue-100 text-blue-800
                                        @elseif($payment->payment_method === 'bank_transfer') bg-green-100 text-green-800
                                        @else bg-orange-100 text-orange-800
                                        @endif">
                                        @if($payment->payment_method === 'stripe')
                                            <i class="fab fa-stripe mr-1"></i>
                                        @elseif($payment->payment_method === 'paypal')
                                            <i class="fab fa-paypal mr-1"></i>
                                        @elseif($payment->payment_method === 'bank_transfer')
                                            <i class="fas fa-university mr-1"></i>
                                        @else
                                            <i class="fab fa-bitcoin mr-1"></i>
                                        @endif
                                        {{ $payment->payment_method_display }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $payment->status_badge_class }}">
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-text-secondary">
                                    {{ $payment->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('payments.show', $payment) }}" 
                                           class="text-accent-green hover:text-accent-green-hover text-sm">
                                            <i class="fas fa-eye mr-1"></i>View
                                        </a>
                                        @if(Auth::user()->hasRole('Developer') && $payment->status === 'pending')
                                            <form action="{{ route('payments.markAsCompleted', $payment) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" 
                                                        class="text-blue-500 hover:text-blue-600 text-sm"
                                                        onclick="return confirm('Mark this payment as completed?')">
                                                    <i class="fas fa-check mr-1"></i>Complete
                                                </button>
                                            </form>
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
            {{ $payments->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <div class="w-24 h-24 bg-secondary-dark rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-credit-card text-4xl text-text-secondary"></i>
            </div>
            <h3 class="text-xl font-medium text-text-primary mb-2">No Payments Yet</h3>
            <p class="text-text-secondary mb-6">
                @if(Auth::user()->hasRole('Client'))
                    You haven't made any payments yet.
                @else
                    You haven't received any payments yet.
                @endif
            </p>
            <div class="text-sm text-text-secondary">
                <p>
                    @if(Auth::user()->hasRole('Client'))
                        Payments will appear here once you complete projects and pay developers.
                    @else
                        Payments will appear here once clients complete projects and make payments.
                    @endif
                </p>
            </div>
        </div>
    @endif
</div>
@endsection
