@extends('layouts.dashboard')

@section('title', 'Received Payments')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-text-primary">Received Payments</h1>
        <p class="text-text-secondary mt-2">
            Track all payments you've received from clients for completed projects.
        </p>
    </div>

    @if($payments->count() > 0)
        <div class="bg-card-dark border border-border-custom rounded-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-secondary-dark border-b border-border-custom">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-medium text-text-primary">Project</th>
                            <th class="px-6 py-4 text-left text-sm font-medium text-text-primary">Client</th>
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
                                        <p class="font-medium text-text-primary">{{ $payment->client->name }}</p>
                                        <p class="text-sm text-text-secondary">{{ $payment->client->email }}</p>
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
                                    <a href="{{ route('payments.show', $payment) }}" 
                                       class="text-accent-green hover:text-accent-green-hover transition-colors">
                                        View Details
                                    </a>
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
            <div class="text-6xl text-text-secondary mb-4">
                <i class="fas fa-credit-card"></i>
            </div>
            <h3 class="text-xl font-medium text-text-primary mb-2">No Payments Received Yet</h3>
            <p class="text-text-secondary mb-6">
                You haven't received any payments yet. Complete projects and deliver them to start earning!
            </p>
            <a href="{{ route('projects.browse') }}" 
               class="inline-flex items-center px-2 py-3 bg-accent-green text-white font-medium rounded-lg hover:bg-accent-green-hover transition-colors">
                <i class="fas fa-search mr-2"></i>
                Browse Projects
            </a>
        </div>
    @endif
</div>
@endsection
