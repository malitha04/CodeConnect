@extends('layouts.dashboard')

@section('title', 'Payment Details')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-text-primary">Payment Details</h1>
                    <p class="text-text-secondary mt-2">Payment information and transaction status.</p>
                </div>
                <a href="{{ route('payments.index') }}" 
                   class="px-4 py-2 border border-border-custom text-text-primary rounded-lg hover:bg-secondary-dark transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Payments
                </a>
            </div>
        </div>

        @if(session('status'))
            <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                {{ session('status') }}
            </div>
        @endif

        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Payment Information -->
                <div class="bg-card-dark border border-border-custom rounded-xl p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h2 class="text-xl font-semibold text-text-primary">Payment #{{ $payment->id }}</h2>
                            <p class="text-text-secondary text-sm">Created on {{ $payment->created_at->format('M d, Y \a\t g:i A') }}</p>
                        </div>
                        <div class="text-right">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $payment->status_badge_class }}">
                                {{ ucfirst($payment->status) }}
                            </span>
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <span class="text-text-secondary text-sm">Amount:</span>
                            <p class="text-2xl font-bold text-accent-green">${{ number_format($payment->amount, 2) }}</p>
                        </div>
                        <div>
                            <span class="text-text-secondary text-sm">Payment Method:</span>
                            <p class="text-text-primary font-medium">{{ $payment->payment_method_display }}</p>
                        </div>
                    </div>

                    @if($payment->transaction_id)
                        <div class="bg-secondary-dark rounded-lg p-4 mb-4">
                            <h3 class="font-medium text-text-primary mb-2">Transaction ID</h3>
                            <p class="text-text-secondary font-mono text-sm">{{ $payment->transaction_id }}</p>
                        </div>
                    @endif

                    @if($payment->paid_at)
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                            <h3 class="font-medium text-green-800 mb-2">Payment Completed</h3>
                            <p class="text-green-700 text-sm">Paid on {{ $payment->paid_at->format('M d, Y \a\t g:i A') }}</p>
                        </div>
                    @endif
                </div>

                <!-- Project Information -->
                <div class="bg-card-dark border border-border-custom rounded-xl p-6">
                    <h2 class="text-xl font-semibold text-text-primary mb-4">Project Information</h2>
                    <div class="space-y-4">
                        <div>
                            <h3 class="font-medium text-text-primary text-lg">{{ $payment->project->title }}</h3>
                            <p class="text-text-secondary mt-1">{{ $payment->project->description }}</p>
                        </div>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-text-secondary">Category:</span>
                                <span class="text-text-primary font-medium">{{ $payment->project->category }}</span>
                            </div>
                            <div>
                                <span class="text-text-secondary">Budget:</span>
                                <span class="text-text-primary font-medium">${{ number_format($payment->project->budget) }}</span>
                            </div>
                            <div>
                                <span class="text-text-secondary">Duration:</span>
                                <span class="text-text-primary font-medium">{{ $payment->project->duration }}</span>
                            </div>
                            <div>
                                <span class="text-text-secondary">Status:</span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($payment->project->status === 'completed') bg-green-100 text-green-800
                                    @elseif($payment->project->status === 'in-progress') bg-yellow-100 text-yellow-800
                                    @else bg-blue-100 text-blue-800
                                    @endif">
                                    {{ ucfirst(str_replace('-', ' ', $payment->project->status)) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                @if($payment->payment_details)
                    <div class="bg-card-dark border border-border-custom rounded-xl p-6">
                        <h2 class="text-xl font-semibold text-text-primary mb-4">Payment Details</h2>
                        <div class="bg-secondary-dark rounded-lg p-4">
                            <pre class="text-text-secondary text-sm whitespace-pre-wrap">{{ json_encode($payment->payment_details, JSON_PRETTY_PRINT) }}</pre>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- User Information -->
                <div class="bg-card-dark border border-border-custom rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-text-primary mb-4">
                        @if(Auth::id() === $payment->client_id)
                            Developer
                        @else
                            Client
                        @endif
                    </h3>
                    <div class="text-center">
                        <div class="w-20 h-20 bg-gradient-to-br from-accent-green to-accent-green-hover rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-user text-white text-2xl"></i>
                        </div>
                        <h4 class="font-medium text-text-primary">
                            @if(Auth::id() === $payment->client_id)
                                {{ $payment->developer->name }}
                            @else
                                {{ $payment->client->name }}
                            @endif
                        </h4>
                        <p class="text-text-secondary text-sm">
                            @if(Auth::id() === $payment->client_id)
                                {{ $payment->developer->email }}
                            @else
                                {{ $payment->client->email }}
                            @endif
                        </p>
                    </div>
                </div>

                <!-- Payment Actions -->
                @if(Auth::id() === $payment->developer_id && $payment->status === 'pending')
                    <div class="bg-card-dark border border-border-custom rounded-xl p-6">
                        <h3 class="text-lg font-semibold text-text-primary mb-4">Payment Actions</h3>
                        <form action="{{ route('payments.markAsCompleted', $payment) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" 
                                    class="w-full px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg transition-colors"
                                    onclick="return confirm('Mark this payment as completed?')">
                                <i class="fas fa-check mr-2"></i>Mark as Completed
                            </button>
                        </form>
                        <p class="text-sm text-text-secondary mt-2">
                            Use this button when you've received the payment via bank transfer or crypto.
                        </p>
                    </div>
                @endif

                <!-- Payment Instructions -->
                @if($payment->status === 'pending' && in_array($payment->payment_method, ['bank_transfer', 'crypto']))
                    <div class="bg-card-dark border border-border-custom rounded-xl p-6">
                        <h3 class="text-lg font-semibold text-text-primary mb-4">Payment Instructions</h3>
                        @if($payment->payment_method === 'bank_transfer')
                            <div class="space-y-3 text-sm">
                                <div>
                                    <span class="text-text-secondary">Bank Name:</span>
                                    <p class="text-text-primary font-medium">{{ $payment->payment_details['bank_name'] ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <span class="text-text-secondary">Account Number:</span>
                                    <p class="text-text-primary font-medium">{{ $payment->payment_details['account_number'] ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <span class="text-text-secondary">Routing Number:</span>
                                    <p class="text-text-primary font-medium">{{ $payment->payment_details['routing_number'] ?? 'N/A' }}</p>
                                </div>
                            </div>
                        @elseif($payment->payment_method === 'crypto')
                            <div class="space-y-3 text-sm">
                                <div>
                                    <span class="text-text-secondary">Wallet Address:</span>
                                    <p class="text-text-primary font-mono text-xs break-all">{{ $payment->payment_details['wallet_address'] ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <span class="text-text-secondary">Currency:</span>
                                    <p class="text-text-primary font-medium">{{ $payment->payment_details['currency'] ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <span class="text-text-secondary">Amount:</span>
                                    <p class="text-text-primary font-medium">{{ $payment->payment_details['amount_eth'] ?? 'N/A' }} {{ $payment->payment_details['currency'] ?? '' }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
