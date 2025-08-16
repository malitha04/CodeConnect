# Payment System Documentation

## Overview
The Payment System allows clients to pay developers after completing projects. It supports multiple payment methods and provides a complete payment tracking system.

## Features

### Payment Methods
- **Stripe (Credit Card)**: Automated payment processing
- **PayPal**: PayPal wallet payments
- **Bank Transfer**: Manual bank transfer with instructions
- **Cryptocurrency**: Crypto payments with wallet addresses

### Payment Statuses
- **Pending**: Payment initiated but not completed
- **Processing**: Payment is being processed
- **Completed**: Payment successfully completed
- **Failed**: Payment failed
- **Refunded**: Payment was refunded

## Database Structure

### Payments Table
```sql
- id (Primary Key)
- project_id (Foreign Key to projects)
- client_id (Foreign Key to users)
- developer_id (Foreign Key to users)
- amount (Decimal)
- payment_method (Enum: stripe, paypal, bank_transfer, crypto)
- transaction_id (String)
- status (Enum: pending, processing, completed, failed, refunded)
- payment_details (JSON)
- paid_at (Timestamp)
- created_at, updated_at
```

## Routes

### Client Routes
- `GET /projects/{project}/payments/create` - Create payment form
- `POST /projects/{project}/payments` - Process payment
- `GET /my-payments` - View payments made by client

### Developer Routes
- `GET /received-payments` - View payments received by developer
- `PATCH /payments/{payment}/complete` - Mark payment as completed

### General Routes
- `GET /payments` - View all payments (role-based)
- `GET /payments/{payment}` - View specific payment details

## Usage

### For Clients
1. **Complete a Project**: Mark project as completed in hires page
2. **Make Payment**: Click "Make Payment" button for completed projects
3. **Choose Method**: Select payment method (Stripe, PayPal, Bank Transfer, Crypto)
4. **Process Payment**: Complete the payment process
5. **Track Payments**: View payment history in "My Payments"

### For Developers
1. **Receive Payments**: View incoming payments in "Received Payments"
2. **Manual Completion**: Mark bank transfer/crypto payments as completed
3. **Track Earnings**: View total earnings and payment history

## Payment Processing

### Automated Payments (Stripe/PayPal)
- Payment is processed immediately
- Status automatically updated to "completed"
- Transaction ID generated

### Manual Payments (Bank Transfer/Crypto)
- Payment instructions provided
- Status remains "pending" until manually marked complete
- Developer can mark as completed when payment received

## Security Features
- Authorization checks for all payment operations
- Only project owners can make payments
- Only developers can mark their payments as completed
- Payment details stored securely

## Integration Points
- **Project Completion**: Triggers payment requirement
- **Review System**: Can be completed after payment
- **Dashboard**: Payment statistics and quick access
- **Hires Page**: Payment buttons for completed projects

## Future Enhancements
- Real payment gateway integration (Stripe API)
- Payment dispute resolution
- Automated payment reminders
- Payment analytics and reporting
- Multi-currency support
- Escrow system for large payments
