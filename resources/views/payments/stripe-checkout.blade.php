@extends('layouts.dashboard')

@section('title', 'Complete Payment')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-text-primary">Complete Payment</h1>
            <p class="text-text-secondary mt-2">Secure payment powered by Stripe.</p>
        </div>

        <div class="bg-card-dark border border-border-custom rounded-xl p-6">
            <!-- Payment Summary -->
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-text-primary mb-4">Payment Summary</h2>
                <div class="bg-secondary-dark rounded-lg p-4">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-text-secondary">Project:</span>
                        <span class="text-text-primary font-medium">{{ $payment->project->title }}</span>
                    </div>
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-text-secondary">Developer:</span>
                        <span class="text-text-primary font-medium">{{ $payment->developer->name }}</span>
                    </div>
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-text-secondary">Amount:</span>
                        <span class="text-accent-green font-bold text-lg">${{ number_format($payment->amount, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-text-secondary">Payment Method:</span>
                        <span class="text-text-primary font-medium">{{ $payment->payment_method_display }}</span>
                    </div>
                </div>
            </div>

            <!-- Stripe Payment Form -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-text-primary mb-4">Payment Details</h3>
                <form id="payment-form" class="space-y-4">
                    <div id="payment-element" class="bg-secondary-dark border border-border-custom rounded-lg p-4">
                        <!-- Stripe Elements will be inserted here -->
                    </div>
                    
                    <div id="payment-message" class="hidden"></div>
                    
                    <button id="submit" type="submit" class="w-full bg-accent-green hover:bg-accent-green-hover text-white py-3 px-6 rounded-lg font-medium transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                        <div class="spinner hidden" id="spinner"></div>
                        <span id="button-text">Pay ${{ number_format($payment->amount, 2) }}</span>
                    </button>
                </form>
            </div>

            <!-- Security Notice -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex items-center">
                    <i class="fas fa-shield-alt text-blue-500 mr-3"></i>
                    <div>
                        <h4 class="font-medium text-blue-800">Secure Payment</h4>
                        <p class="text-sm text-blue-700 mt-1">
                            Your payment information is encrypted and secure. We use Stripe to process payments and never store your card details.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stripe.js -->
<script src="https://js.stripe.com/v3/"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Stripe
    const stripe = Stripe('{{ config("services.stripe.key") }}');
    const elements = stripe.elements();
    
    // Create payment element
    const paymentElement = elements.create('payment', {
        layout: 'tabs',
        defaultValues: {
            billingDetails: {
                name: '{{ Auth::user()->name }}',
                email: '{{ Auth::user()->email }}'
            }
        }
    });
    
    paymentElement.mount('#payment-element');
    
    // Handle form submission
    const form = document.getElementById('payment-form');
    const submitButton = document.getElementById('submit');
    const spinner = document.getElementById('spinner');
    const buttonText = document.getElementById('button-text');
    const messageContainer = document.getElementById('payment-message');
    
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        setLoading(true);
        
        const {error} = await stripe.confirmPayment({
            elements,
            confirmParams: {
                return_url: '{{ route("payments.show", $payment) }}',
                payment_method_data: {
                    billing_details: {
                        name: '{{ Auth::user()->name }}',
                        email: '{{ Auth::user()->email }}'
                    }
                }
            }
        });
        
        if (error.type === 'card_error' || error.type === 'validation_error') {
            showMessage(error.message);
        } else {
            showMessage('An unexpected error occurred.');
        }
        
        setLoading(false);
    });
    
    function setLoading(isLoading) {
        if (isLoading) {
            submitButton.disabled = true;
            spinner.classList.remove('hidden');
            buttonText.classList.add('hidden');
        } else {
            submitButton.disabled = false;
            spinner.classList.add('hidden');
            buttonText.classList.remove('hidden');
        }
    }
    
    function showMessage(messageText) {
        const messageContainer = document.getElementById('payment-message');
        messageContainer.classList.remove('hidden');
        messageContainer.textContent = messageText;
        
        setTimeout(function () {
            messageContainer.classList.add('hidden');
            messageContainer.textContent = '';
        }, 4000);
    }
});
</script>

<style>
.spinner,
.spinner:before,
.spinner:after {
    border-radius: 50%;
}

.spinner {
    color: #ffffff;
    font-size: 22px;
    text-indent: -99999px;
    margin: 0px auto;
    position: relative;
    width: 20px;
    height: 20px;
    box-shadow: inset 0 0 0 2px;
    -webkit-transform: translateZ(0);
    -ms-transform: translateZ(0);
    transform: translateZ(0);
}

.spinner:before,
.spinner:after {
    position: absolute;
    content: '';
}

.spinner:before {
    width: 10.4px;
    height: 20.4px;
    background: #5469d4;
    border-radius: 20.4px 0 0 20.4px;
    top: -0.2px;
    left: -0.2px;
    -webkit-transform-origin: 10.4px 10.2px;
    transform-origin: 10.4px 10.2px;
    -webkit-animation: loading 2s infinite ease 1.5s;
    animation: loading 2s infinite ease 1.5s;
}

.spinner:after {
    width: 10.4px;
    height: 10.2px;
    background: #5469d4;
    border-radius: 0 10.2px 10.2px 0;
    top: -0.1px;
    left: 10.2px;
    -webkit-transform-origin: 0px 10.2px;
    transform-origin: 0px 10.2px;
    -webkit-animation: loading 2s infinite ease;
    animation: loading 2s infinite ease;
}

@-webkit-keyframes loading {
    0% {
        -webkit-transform: rotate(0deg);
        transform: rotate(0deg);
    }
    100% {
        -webkit-transform: rotate(360deg);
        transform: rotate(360deg);
    }
}

@keyframes loading {
    0% {
        -webkit-transform: rotate(0deg);
        transform: rotate(0deg);
    }
    100% {
        -webkit-transform: rotate(360deg);
        transform: rotate(360deg);
    }
}

#payment-message {
    color: rgb(105, 115, 134);
    font-size: 16px;
    line-height: 20px;
    padding-top: 12px;
    text-align: center;
}

#payment-element {
    margin-bottom: 24px;
}
</style>
@endsection
