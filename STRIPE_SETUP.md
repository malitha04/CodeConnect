# Stripe Payment Setup Guide

## Overview
This guide will help you set up real Stripe payments in your CodeConnect application.

## Step 1: Create a Stripe Account
1. Go to [stripe.com](https://stripe.com) and create an account
2. Complete the account verification process
3. Get your API keys from the Stripe Dashboard

## Step 2: Get Your Stripe API Keys
1. Log in to your Stripe Dashboard
2. Go to **Developers** → **API keys**
3. Copy your **Publishable key** and **Secret key**
4. For testing, use the test keys (they start with `pk_test_` and `sk_test_`)

## Step 3: Configure Your .env File
Add these lines to your `.env` file:

```env
# Stripe Configuration
STRIPE_KEY=pk_test_your_publishable_key_here
STRIPE_SECRET=sk_test_your_secret_key_here
STRIPE_WEBHOOK_SECRET=whsec_your_webhook_secret_here
```

## Step 4: Set Up Webhooks (Optional but Recommended)
1. In your Stripe Dashboard, go to **Developers** → **Webhooks**
2. Click **Add endpoint**
3. Set the endpoint URL to: `https://yourdomain.com/payments/stripe/webhook`
4. Select these events:
   - `payment_intent.succeeded`
   - `payment_intent.payment_failed`
5. Copy the webhook signing secret and add it to your `.env` file

## Step 5: Test the Payment System
1. Use Stripe's test card numbers:
   - **Success**: `4242 4242 4242 4242`
   - **Decline**: `4000 0000 0000 0002`
   - **Requires Authentication**: `4000 0025 0000 3155`

2. Use any future expiry date and any 3-digit CVC

## Step 6: Go Live (Production)
When ready for production:
1. Switch to live API keys in your `.env` file
2. Update webhook endpoints to use your production domain
3. Test with real cards

## Security Notes
- Never commit your `.env` file to version control
- Keep your secret keys secure
- Use HTTPS in production
- Validate webhook signatures

## Troubleshooting
- Check Stripe Dashboard for payment status
- Verify API keys are correct
- Ensure webhook endpoints are accessible
- Check Laravel logs for errors

## Support
- [Stripe Documentation](https://stripe.com/docs)
- [Stripe Support](https://support.stripe.com)
- [Laravel Stripe Package](https://github.com/stripe/stripe-php)
