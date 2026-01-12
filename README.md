# CodeConnect - Enterprise Collaboration & Project Management Platform

<p align="center">
  <strong>A modern, secure platform for team collaboration, project management, and seamless communication</strong>
</p>

---

## 🎯 About CodeConnect

CodeConnect is a comprehensive web-based platform designed to streamline team collaboration, project management, and communication. Built with modern technologies and best practices, it empowers organizations to manage workflows efficiently while maintaining secure data handling and role-based access control.

## ✨ Key Features

- **🔐 Secure Authentication** - Industry-standard user authentication with role-based access control (RBAC)
- **📋 Project Management** - Create, track, and collaborate on projects with real-time updates
- **👥 Team Collaboration** - Connect team members, assign tasks, and monitor progress
- **💬 Communication Hub** - Integrated messaging and notifications for seamless team interaction
- **📊 Analytics Dashboard** - Visual insights into project metrics and team performance
- **💳 Payment Integration** - Secure Stripe integration for transaction processing
- **📱 Responsive Design** - Fully responsive interface works seamlessly across all devices
- **🎨 Modern UI/UX** - Intuitive interface with Tailwind CSS for enhanced user experience

## 🛠 Tech Stack

### Backend
- **Framework:** Laravel 11 (PHP 8.2+)
- **Database:** PostgreSQL
- **Queue:** Database-driven queue system
- **Cache:** Database cache store
- **Session:** Database session management
- **ORM:** Eloquent

### Frontend
- **Framework:** Vue.js 3
- **Build Tool:** Vite
- **Styling:** Tailwind CSS
- **Templating:** Inertia.js

### Payment & Services
- **Payment Gateway:** Stripe API
- **Mail:** Log driver (configurable to SMTP)
- **Storage:** Local filesystem

## 📋 Prerequisites

- PHP 8.2 or higher
- PostgreSQL 12 or higher
- Node.js 18+ and npm
- Composer
- Git

## 🚀 Getting Started

### 1. Clone the Repository
```bash
git clone https://github.com/yourusername/codeconnect.git
cd CodeConnect
```

### 2. Install PHP Dependencies
```bash
composer install
```

### 3. Install Frontend Dependencies
```bash
npm install
```

### 4. Environment Setup
```bash
cp .env.example .env
php artisan key:generate
```

Update your `.env` file with your database credentials:
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=codeconnect
DB_USERNAME=postgres
DB_PASSWORD=your_password
```

### 5. Database Setup
```bash
php artisan migrate
php artisan db:seed
```

### 6. Build Frontend Assets
```bash
npm run build
```

For development with hot module replacement:
```bash
npm run dev
```

### 7. Start Development Server
```bash
php artisan serve
```

The application will be available at `http://localhost:8000`

## 🔑 Default Credentials

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@codeconnect.com | Admin@123 |

> ⚠️ **Important:** Change the default admin password immediately after first login in production.

## 📚 Documentation

- [Project Delivery System](./PROJECT_DELIVERY_SYSTEM.md)
- [Review System](./REVIEW_SYSTEM.md)
- [Payment System](./README-PaymentSystem.md)
- [Real Payments](./README-RealPayments.md)
- [Stripe Setup](./STRIPE_SETUP.md)

## 👥 User Roles & Permissions

CodeConnect supports multiple user roles with granular permission management:

- **Admin** - Full system access and management capabilities
- **Project Manager** - Project creation, team management, and resource allocation
- **Team Lead** - Task assignment, progress tracking, and team coordination
- **Team Member** - Task execution and project collaboration
- **Client** - Project viewing and communication with team

## 🔐 Security Features

- Encrypted application key for sensitive data protection
- Password hashing with bcrypt (12 rounds)
- CSRF protection on all state-changing requests
- SQL injection prevention via Eloquent ORM
- XSS protection and output escaping
- Role-based access control (RBAC) via Spatie permissions
- Secure session management with database storage
- Input validation and sanitization
- API rate limiting capabilities

## 📦 Project Structure

```
CodeConnect/
├── app/                      # Application logic
│   ├── Http/
│   │   ├── Controllers/     # Request handlers
│   │   └── Requests/        # Form validation
│   ├── Models/              # Database models
│   ├── Notifications/       # Notification classes
│   ├── Policies/            # Authorization policies
│   └── Providers/           # Service providers
├── bootstrap/               # Application bootstrap files
├── config/                  # Configuration files
├── database/
│   ├── migrations/          # Database migrations
│   ├── seeders/             # Database seeders
│   └── factories/           # Model factories
├── public/                  # Publicly accessible files
│   └── build/              # Compiled frontend assets
├── resources/
│   ├── css/                # Stylesheets
│   ├── js/                 # JavaScript files
│   └── views/              # Blade templates
├── routes/                  # Application routes
├── storage/                 # Logs and file storage
├── tests/                   # Test files
│   ├── Feature/            # Feature tests
│   └── Unit/               # Unit tests
└── vendor/                  # Composer dependencies
```

## 🧪 Testing

Run all tests:
```bash
php artisan test
```

Run tests with coverage:
```bash
php artisan test --coverage
```

Run specific test file:
```bash
php artisan test tests/Feature/YourTest.php
```

## 📝 Available Commands

```bash
# Database
php artisan migrate              # Run database migrations
php artisan migrate:fresh        # Drop all tables and re-run migrations
php artisan migrate:rollback     # Rollback last batch of migrations
php artisan db:seed              # Seed the database

# Cache
php artisan cache:clear          # Clear the application cache
php artisan cache:forget key     # Forget a specific cache item

# Development
php artisan tinker               # Interact with the application
php artisan serve                # Start the development server
php artisan make:model Model     # Create a new model
php artisan make:migration name  # Create a new migration

# Queue
php artisan queue:work           # Start the queue worker
php artisan queue:failed         # List failed jobs
```

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📝 License

This project is licensed under the MIT License - see the LICENSE file for details.

## 💬 Support & Contact

For support, email support@codeconnect.com or open an issue on GitHub.

---

**Last Updated:** January 2026  
**Version:** 1.0.0  
**Author:** Malitha Rathnathilaka

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
