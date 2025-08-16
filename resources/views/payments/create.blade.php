@extends('layouts.dashboard')

@section('title', 'Make Payment')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-text-primary">Make Payment</h1>
            <p class="text-text-secondary mt-2">Complete payment for the finished project.</p>
        </div>

        <div class="bg-card-dark border border-border-custom rounded-xl p-6">
            <!-- Project Information -->
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-text-primary mb-4">Project Details</h2>
                <div class="bg-secondary-dark rounded-lg p-4">
                    <h3 class="font-medium text-text-primary">{{ $project->title }}</h3>
                    <p class="text-text-secondary text-sm mt-1">{{ $project->description }}</p>
                    <div class="flex items-center mt-2 text-sm text-text-secondary">
                        <span class="mr-4"><i class="fas fa-user mr-1"></i>Developer: {{ $developer->name }}</span>
                        <span><i class="fas fa-dollar-sign mr-1"></i>Agreed Amount: ${{ number_format($acceptedProposal->bid_amount, 2) }}</span>
                    </div>
                </div>
            </div>

            <form action="{{ route('payments.store', $project) }}" method="POST">
                @csrf
                
                <div class="space-y-6">
                    <!-- Payment Amount -->
                    <div>
                        <label for="amount" class="block text-sm font-medium text-text-primary mb-2">
                            Payment Amount *
                        </label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-text-secondary">$</span>
                            <input type="number" id="amount" name="amount" 
                                   value="{{ $acceptedProposal->bid_amount }}" step="0.01" min="0.01"
                                   class="w-full pl-8 pr-3 py-2 bg-secondary-dark border border-border-custom rounded-lg text-text-primary focus:outline-none focus:ring-2 focus:ring-accent-green focus:border-transparent"
                                   required>
                        </div>
                        <p class="text-sm text-text-secondary mt-1">This is the amount agreed upon in the accepted proposal.</p>
                        @error('amount')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Payment Method -->
                    <div>
                        <label class="block text-sm font-medium text-text-primary mb-3">
                            Payment Method *
                        </label>
                        <div class="space-y-3">
                            <label class="flex items-center p-4 border border-border-custom rounded-lg hover:border-accent-green transition-colors cursor-pointer">
                                <input type="radio" name="payment_method" value="stripe" class="mr-3" checked>
                                <div class="flex items-center">
                                    <i class="fab fa-stripe text-blue-500 text-xl mr-3"></i>
                                    <div>
                                        <p class="font-medium text-text-primary">Credit Card (Stripe)</p>
                                        <p class="text-sm text-text-secondary">Secure payment with credit or debit card</p>
                                    </div>
                                </div>
                            </label>

                            <label class="flex items-center p-4 border border-border-custom rounded-lg hover:border-accent-green transition-colors cursor-pointer">
                                <input type="radio" name="payment_method" value="paypal" class="mr-3">
                                <div class="flex items-center">
                                    <i class="fab fa-paypal text-blue-500 text-xl mr-3"></i>
                                    <div>
                                        <p class="font-medium text-text-primary">PayPal</p>
                                        <p class="text-sm text-text-secondary">Pay with your PayPal account</p>
                                    </div>
                                </div>
                            </label>

                            <label class="flex items-center p-4 border border-border-custom rounded-lg hover:border-accent-green transition-colors cursor-pointer">
                                <input type="radio" name="payment_method" value="bank_transfer" class="mr-3">
                                <div class="flex items-center">
                                    <i class="fas fa-university text-green-500 text-xl mr-3"></i>
                                    <div>
                                        <p class="font-medium text-text-primary">Bank Transfer</p>
                                        <p class="text-sm text-text-secondary">Direct bank transfer (manual processing)</p>
                                    </div>
                                </div>
                            </label>

                            <label class="flex items-center p-4 border border-border-custom rounded-lg hover:border-accent-green transition-colors cursor-pointer">
                                <input type="radio" name="payment_method" value="crypto" class="mr-3">
                                <div class="flex items-center">
                                    <i class="fab fa-bitcoin text-orange-500 text-xl mr-3"></i>
                                    <div>
                                        <p class="font-medium text-text-primary">Cryptocurrency</p>
                                        <p class="text-sm text-text-secondary">Pay with Bitcoin, Ethereum, or other crypto</p>
                                    </div>
                                </div>
                            </label>
                        </div>
                        @error('payment_method')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Payment Summary -->
                    <div class="bg-secondary-dark rounded-lg p-4">
                        <h3 class="font-medium text-text-primary mb-3">Payment Summary</h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-text-secondary">Project:</span>
                                <span class="text-text-primary">{{ $project->title }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-text-secondary">Developer:</span>
                                <span class="text-text-primary">{{ $developer->name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-text-secondary">Amount:</span>
                                <span class="text-accent-green font-medium" id="summary-amount">${{ number_format($acceptedProposal->bid_amount, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-text-secondary">Payment Method:</span>
                                <span class="text-text-primary" id="summary-method">Credit Card (Stripe)</span>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method Info -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex items-start">
                            <i class="fas fa-info-circle text-blue-500 mr-3 mt-1"></i>
                            <div>
                                <h4 class="font-medium text-blue-800 mb-1">Real Payment Processing</h4>
                                <p class="text-sm text-blue-700">
                                    <strong>Stripe:</strong> Real credit card processing with secure checkout<br>
                                    <strong>PayPal:</strong> Simulated (requires PayPal SDK integration)<br>
                                    <strong>Bank Transfer/Crypto:</strong> Manual processing with instructions
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('hires.index') }}" 
                           class="px-6 py-2 border border-border-custom text-text-primary rounded-lg hover:bg-secondary-dark transition-colors">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="px-6 py-2 bg-accent-green hover:bg-accent-green-hover text-white rounded-lg transition-colors">
                            <i class="fas fa-credit-card mr-2"></i>Process Payment
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const amountInput = document.getElementById('amount');
    const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
    const summaryAmount = document.getElementById('summary-amount');
    const summaryMethod = document.getElementById('summary-method');

    // Update summary when amount changes
    amountInput.addEventListener('input', function() {
        const amount = parseFloat(this.value) || 0;
        summaryAmount.textContent = '$' + amount.toFixed(2);
    });

    // Update summary when payment method changes
    paymentMethods.forEach(method => {
        method.addEventListener('change', function() {
            const methodLabels = {
                'stripe': 'Credit Card (Stripe)',
                'paypal': 'PayPal',
                'bank_transfer': 'Bank Transfer',
                'crypto': 'Cryptocurrency'
            };
            summaryMethod.textContent = methodLabels[this.value] || this.value;
        });
    });
});
</script>
@endsection
