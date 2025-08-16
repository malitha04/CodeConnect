@extends('layouts.dashboard')

@section('title', 'My Payments')

@section('content')
    <!-- Header -->
    <section class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold">My Payments</h1>
                <p class="text-text-secondary mt-2">Track all payments you've made for completed projects.</p>
            </div>
            <a href="{{ route('hires.index') }}" class="btn-secondary">
                <i class="fas fa-arrow-left mr-2"></i>Back to Hires
            </a>
        </div>
    </section>

    <!-- Payments List -->
    <section class="bg-card-dark border border-border-custom rounded-xl p-6">
        @if($payments->count() > 0)
            <div class="space-y-4">
                @foreach($payments as $payment)
                    <div class="border border-border-custom rounded-lg p-6 hover:border-accent-green transition-colors">
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold mb-2">{{ $payment->project->title }}</h3>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-text-secondary">
                                    <div>
                                        <span class="font-medium">Developer:</span>
                                        <span>{{ $payment->developer->name }}</span>
                                    </div>
                                    <div>
                                        <span class="font-medium">Amount:</span>
                                        <span class="text-accent-green font-semibold">${{ number_format($payment->amount, 2) }}</span>
                                    </div>
                                    <div>
                                        <span class="font-medium">Date:</span>
                                        <span>{{ $payment->created_at->format('M d, Y') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                @switch($payment->status)
                                    @case('pending')
                                        <span class="px-3 py-1 bg-yellow-500/20 text-yellow-500 rounded-full text-sm font-medium">
                                            Pending
                                        </span>
                                        @break
                                    @case('processing')
                                        <span class="px-3 py-1 bg-blue-500/20 text-blue-500 rounded-full text-sm font-medium">
                                            Processing
                                        </span>
                                        @break
                                    @case('completed')
                                        <span class="px-3 py-1 bg-accent-green/20 text-accent-green rounded-full text-sm font-medium">
                                            Completed
                                        </span>
                                        @break
                                    @case('failed')
                                        <span class="px-3 py-1 bg-red-500/20 text-red-500 rounded-full text-sm font-medium">
                                            Failed
                                        </span>
                                        @break
                                    @default
                                        <span class="px-3 py-1 bg-gray-500/20 text-gray-500 rounded-full text-sm font-medium">
                                            {{ ucfirst($payment->status) }}
                                        </span>
                                @endswitch
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-text-secondary mb-4">
                            <div>
                                <span class="font-medium">Payment Method:</span>
                                <span class="capitalize">{{ str_replace('_', ' ', $payment->payment_method) }}</span>
                            </div>
                            <div>
                                <span class="font-medium">Transaction ID:</span>
                                <span class="font-mono text-xs">{{ $payment->transaction_id ?? 'N/A' }}</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex space-x-2">
                                <a href="{{ route('payments.show', $payment) }}" class="btn-primary">
                                    <i class="fas fa-eye mr-2"></i>View Details
                                </a>
                                @if($payment->status === 'processing' && $payment->payment_method === 'stripe')
                                    <a href="{{ route('payments.stripe-checkout', $payment) }}" class="btn-secondary">
                                        <i class="fas fa-credit-card mr-2"></i>Complete Payment
                                    </a>
                                @endif
                            </div>
                            <div class="text-right">
                                @if($payment->paid_at)
                                    <p class="text-xs text-text-secondary">
                                        Paid on {{ $payment->paid_at->format('M d, Y \a\t g:i A') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $payments->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <div class="w-16 h-16 bg-accent-green/20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-credit-card text-accent-green text-2xl"></i>
                </div>
                <h3 class="text-xl font-semibold mb-2">No Payments Yet</h3>
                <p class="text-text-secondary mb-6">You haven't made any payments yet. Payments will appear here once you complete projects and pay developers.</p>
                <a href="{{ route('hires.index') }}" class="btn-primary">
                    <i class="fas fa-briefcase mr-2"></i>View My Hires
                </a>
            </div>
        @endif
    </section>
@endsection
