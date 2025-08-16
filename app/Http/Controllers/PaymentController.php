<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Exception\ApiErrorException;

class PaymentController extends Controller
{
    /**
     * Display a listing of payments for the authenticated user.
     */
    public function index(): View
    {
        $user = Auth::user();
        
        if ($user->hasRole('Client')) {
            $payments = $user->paymentsMade()
                ->with(['project', 'developer'])
                ->latest()
                ->paginate(10);
        } else {
            $payments = $user->paymentsReceived()
                ->with(['project', 'client'])
                ->latest()
                ->paginate(10);
        }

        return view('payments.index', compact('payments'));
    }

    /**
     * Show the form for creating a new payment.
     */
    public function create(Project $project): View|RedirectResponse
    {
        // Check if the authenticated user is the project owner
        if (Auth::id() !== $project->user_id) {
            return redirect()->route('dashboard')->withErrors('You are not authorized to make payments for this project.');
        }

        // Check if project is completed
        if ($project->status !== 'completed') {
            return redirect()->route('dashboard')->withErrors('You can only make payments for completed projects.');
        }

        // Check if payment already exists
        if ($project->payment) {
            return redirect()->route('payments.show', $project->payment)->withErrors('Payment already exists for this project.');
        }

        // Get the developer for this project
        $developer = $project->proposals()
            ->where('status', 'accepted')
            ->first()
            ->user;

        // Get the accepted proposal amount
        $acceptedProposal = $project->proposals()
            ->where('status', 'accepted')
            ->first();

        return view('payments.create', compact('project', 'developer', 'acceptedProposal'));
    }

    /**
     * Store a newly created payment in storage.
     */
    public function store(Request $request, Project $project): RedirectResponse
    {
        // Check if the authenticated user is the project owner
        if (Auth::id() !== $project->user_id) {
            return redirect()->route('dashboard')->withErrors('You are not authorized to make payments for this project.');
        }

        // Check if project is completed
        if ($project->status !== 'completed') {
            return redirect()->route('dashboard')->withErrors('You can only make payments for completed projects.');
        }

        // Check if payment already exists
        if ($project->payment) {
            return redirect()->route('payments.show', $project->payment)->withErrors('Payment already exists for this project.');
        }

        $validated = $request->validate([
            'payment_method' => 'required|in:stripe,paypal,bank_transfer,crypto',
            'amount' => 'required|numeric|min:1',
        ]);

        // Get the developer for this project
        $developer = $project->proposals()
            ->where('status', 'accepted')
            ->first()
            ->user;

        // Create payment record
        $payment = Payment::create([
            'project_id' => $project->id,
            'client_id' => Auth::id(),
            'developer_id' => $developer->id,
            'amount' => $validated['amount'],
            'payment_method' => $validated['payment_method'],
            'status' => 'pending',
        ]);

        // Redirect to payment processing based on method
        return $this->processPayment($payment, $request);
    }

    /**
     * Process the payment based on the selected method.
     */
    private function processPayment(Payment $payment, Request $request): RedirectResponse
    {
        switch ($payment->payment_method) {
            case 'stripe':
                return $this->processStripePayment($payment);
            case 'paypal':
                return $this->processPayPalPayment($payment);
            case 'bank_transfer':
                return $this->processBankTransfer($payment);
            case 'crypto':
                return $this->processCryptoPayment($payment);
            default:
                return redirect()->route('payments.show', $payment)->withErrors('Invalid payment method.');
        }
    }

    /**
     * Process Stripe payment (real implementation).
     */
    private function processStripePayment(Payment $payment): RedirectResponse
    {
        try {
            // Set Stripe API key
            Stripe::setApiKey(config('services.stripe.secret'));

            // Create a PaymentIntent with the order amount and currency
            $paymentIntent = PaymentIntent::create([
                'amount' => (int)($payment->amount * 100), // Convert to cents
                'currency' => 'usd',
                'metadata' => [
                    'payment_id' => $payment->id,
                    'project_id' => $payment->project_id,
                    'client_id' => $payment->client_id,
                    'developer_id' => $payment->developer_id,
                ],
            ]);

            // Update payment with Stripe payment intent ID
            $payment->update([
                'status' => 'processing',
                'transaction_id' => $paymentIntent->id,
                'payment_details' => [
                    'gateway' => 'stripe',
                    'payment_intent_id' => $paymentIntent->id,
                    'client_secret' => $paymentIntent->client_secret,
                    'amount' => $payment->amount,
                    'currency' => 'usd',
                ],
            ]);

            // Redirect to Stripe payment page
            return redirect()->route('payments.stripe.checkout', $payment);

        } catch (ApiErrorException $e) {
            // Handle Stripe API errors
            $payment->update([
                'status' => 'failed',
                'payment_details' => [
                    'error' => $e->getMessage(),
                    'error_code' => $e->getStripeCode(),
                ],
            ]);

            return redirect()->route('payments.show', $payment)
                ->withErrors('Payment failed: ' . $e->getMessage());
        }
    }

    /**
     * Process PayPal payment (simulated - requires PayPal SDK integration).
     */
    private function processPayPalPayment(Payment $payment): RedirectResponse
    {
        // For now, simulate PayPal payment processing
        // TODO: Integrate PayPal SDK for real payments
        $payment->update([
            'status' => 'processing',
            'transaction_id' => 'paypal_' . time() . '_' . $payment->id,
        ]);

        // Simulate successful payment after 2 seconds
        sleep(2);
        
        $payment->update([
            'status' => 'completed',
            'paid_at' => now(),
            'payment_details' => [
                'gateway' => 'paypal',
                'method' => 'paypal_wallet',
                'processed_at' => now()->toISOString(),
                'note' => 'PayPal integration requires additional SDK setup',
            ],
        ]);

        return redirect()->route('payments.show', $payment)->with('status', 'Payment completed successfully! (PayPal SDK integration pending)');
    }

    /**
     * Process bank transfer (manual).
     */
    private function processBankTransfer(Payment $payment): RedirectResponse
    {
        $payment->update([
            'status' => 'pending',
            'transaction_id' => 'bank_' . time() . '_' . $payment->id,
            'payment_details' => [
                'gateway' => 'bank_transfer',
                'instructions' => 'Please transfer the amount to the following account details.',
                'account_number' => '1234567890',
                'routing_number' => '987654321',
                'bank_name' => 'Sample Bank',
            ],
        ]);

        return redirect()->route('payments.show', $payment)->with('status', 'Bank transfer instructions have been generated. Please complete the transfer manually.');
    }

    /**
     * Process crypto payment (simulated).
     */
    private function processCryptoPayment(Payment $payment): RedirectResponse
    {
        $payment->update([
            'status' => 'pending',
            'transaction_id' => 'crypto_' . time() . '_' . $payment->id,
            'payment_details' => [
                'gateway' => 'crypto',
                'wallet_address' => '0x742d35Cc6634C0532925a3b8D4C9db96C4b4d8b6',
                'currency' => 'ETH',
                'amount_eth' => $payment->amount / 2000, // Simulated ETH rate
            ],
        ]);

        return redirect()->route('payments.show', $payment)->with('status', 'Crypto payment instructions have been generated. Please send the specified amount to the wallet address.');
    }

    /**
     * Display the specified payment.
     */
    public function show(Payment $payment): View
    {
        // Check if user is authorized to view this payment
        if (Auth::id() !== $payment->client_id && Auth::id() !== $payment->developer_id) {
            abort(403, 'Unauthorized action.');
        }

        return view('payments.show', compact('payment'));
    }

    /**
     * Mark a bank transfer or crypto payment as completed (admin/developer action).
     */
    public function markAsCompleted(Payment $payment): RedirectResponse
    {
        // Only developers can mark their payments as completed
        if (Auth::id() !== $payment->developer_id) {
            return back()->withErrors('You are not authorized to mark this payment as completed.');
        }

        if ($payment->status !== 'pending') {
            return back()->withErrors('Only pending payments can be marked as completed.');
        }

        $payment->update([
            'status' => 'completed',
            'paid_at' => now(),
        ]);

        return redirect()->route('payments.show', $payment)->with('status', 'Payment marked as completed successfully!');
    }

    /**
     * Display payments made by the authenticated client.
     */
    public function myPayments(): View
    {
        $payments = Auth::user()->paymentsMade()
            ->with(['project', 'developer'])
            ->latest()
            ->paginate(10);

        return view('payments.my-payments', compact('payments'));
    }

    /**
     * Display payments received by the authenticated developer.
     */
    public function receivedPayments(): View
    {
        $payments = Auth::user()->paymentsReceived()
            ->with(['project', 'client'])
            ->latest()
            ->paginate(10);

        return view('payments.received-payments', compact('payments'));
    }

    /**
     * Show Stripe checkout page.
     */
    public function stripeCheckout(Payment $payment): View
    {
        // Check if user is authorized to view this payment
        if (Auth::id() !== $payment->client_id) {
            abort(403, 'Unauthorized action.');
        }

        if ($payment->status !== 'processing' || $payment->payment_method !== 'stripe') {
            return redirect()->route('payments.show', $payment)
                ->withErrors('Invalid payment status or method.');
        }

        return view('payments.stripe-checkout', compact('payment'));
    }

    /**
     * Handle Stripe webhook.
     */
    public function stripeWebhook(Request $request): \Illuminate\Http\Response
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = config('services.stripe.webhook_secret');

        try {
            $event = \Stripe\Webhook::constructEvent($payload, $sigHeader, $endpointSecret);
        } catch (\UnexpectedValueException $e) {
            return response('Invalid payload', 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            return response('Invalid signature', 400);
        }

        // Handle the event
        switch ($event->type) {
            case 'payment_intent.succeeded':
                $this->handlePaymentSuccess($event->data->object);
                break;
            case 'payment_intent.payment_failed':
                $this->handlePaymentFailure($event->data->object);
                break;
            default:
                return response('Unhandled event type', 200);
        }

        return response('Webhook handled', 200);
    }

    /**
     * Handle successful payment.
     */
    private function handlePaymentSuccess($paymentIntent): void
    {
        $payment = Payment::where('transaction_id', $paymentIntent->id)->first();
        
        if ($payment) {
            $payment->update([
                'status' => 'completed',
                'paid_at' => now(),
                'payment_details' => array_merge($payment->payment_details ?? [], [
                    'stripe_status' => $paymentIntent->status,
                    'processed_at' => now()->toISOString(),
                ]),
            ]);
        }
    }

    /**
     * Handle failed payment.
     */
    private function handlePaymentFailure($paymentIntent): void
    {
        $payment = Payment::where('transaction_id', $paymentIntent->id)->first();
        
        if ($payment) {
            $payment->update([
                'status' => 'failed',
                'payment_details' => array_merge($payment->payment_details ?? [], [
                    'stripe_status' => $paymentIntent->status,
                    'error' => $paymentIntent->last_payment_error->message ?? 'Payment failed',
                    'failed_at' => now()->toISOString(),
                ]),
            ]);
        }
    }
}
