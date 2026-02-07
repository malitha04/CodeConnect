CodeConnect – Production Collaboration & Project Management Platform (AWS)

<p align="center"> <strong> A modern, secure collaboration and project management platform deployed on AWS using a production-ready cloud architecture </strong> </p>

🎯 About CodeConnect
CodeConnect is a comprehensive web-based platform designed to streamline team collaboration, project management, and communication. It enables teams and organizations to manage projects, collaborate in real time, and handle secure transactions using modern web and cloud technologies.
This project is deployed in a real production environment on AWS, demonstrating hands-on experience with cloud infrastructure, security, and deployment best practices.
✨ Key Features
🔐 Secure Authentication – Role-based access control (RBAC)
📋 Project Management – Create, track, and manage projects
👥 Team Collaboration – Assign tasks and monitor progress
💬 Communication Hub – Integrated notifications and messaging
📊 Analytics Dashboard – Insights into project and team performance
💳 Payment Integration – Stripe payment processing
📱 Responsive Design – Works across desktop and mobile devices
🎨 Modern UI/UX – Built with Tailwind CSS and Vue.js
🛠 Tech Stack
Backend
Framework: Laravel 12
Language: PHP 8.3
Database: PostgreSQL
ORM: Eloquent
Cache: Database cache
Sessions: Database-backed sessions
Frontend
Framework: Vue.js 3
Routing & Views: Inertia.js
Styling: Tailwind CSS
Build Tool: Vite
Payments & Services
Payment Gateway: Stripe
Mail Driver: Log (configurable)
Storage: Local filesystem (S3 planned)
☁️ Cloud Architecture & Deployment (AWS)
Architecture Diagram
Production Deployment Overview
CodeConnect is deployed on Amazon Web Services (AWS) using a production-style architecture focused on security, reliability, and scalability.
AWS Services Used
Amazon EC2
Ubuntu Linux
Nginx as reverse proxy
PHP-FPM running Laravel
Amazon RDS (PostgreSQL)
Managed relational database
Private access (not publicly exposed)
Security Groups
Database access restricted to EC2 only
IAM
Secure key-based access to EC2
Architecture Highlights
Users access the application via the internet
Application runs on an EC2 instance with Nginx and PHP-FPM
PostgreSQL database is hosted on Amazon RDS
Database is not publicly accessible
EC2 communicates with RDS using Security Group-to-Security Group rules
Environment variables managed securely using .env
Deployment Steps (High-Level)
Provisioned EC2 instance using Ubuntu AMI
Installed Nginx, PHP 8.3, Composer, Node.js, and required extensions
Deployed Laravel application via Git
Created PostgreSQL database on Amazon RDS
Configured Security Groups for private database access
Connected Laravel to RDS using environment variables
Executed Laravel migrations in production
Configured permissions for logs and cache directories
Current Status
✅ Application running in production
✅ Secure EC2 ↔ RDS database connectivity
✅ Database migrations completed
✅ Production configuration cached
Planned Improvements
HTTPS with SSL (Certbot)
Amazon S3 for file uploads
Custom VPC with public and private subnets
Load balancer and auto scaling
Monitoring with CloudWatch
📸 Screenshots
Screenshots are available in the docs/screenshots directory:
EC2 instance running
RDS database available
RDS security group rules (SG-to-SG)
Live application in browser
