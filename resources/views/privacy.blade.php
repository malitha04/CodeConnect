@extends('layouts.app')

@section('title', 'Privacy Policy & Cookie Policy - CodeConnect')

@section('content')
<div class="pt-20 pb-16 bg-primary-dark">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-4xl font-bold text-text-primary mb-8">Privacy & Cookie Policy</h1>
            
            <!-- Cookie Policy Section -->
            <div class="bg-card-dark border border-border-custom rounded-xl p-8 mb-8">
                <h2 class="text-2xl font-semibold text-text-primary mb-6 flex items-center">
                    <i class="fas fa-cookie-bite text-accent-orange mr-3"></i>
                    Cookie Policy
                </h2>
                
                <div class="space-y-6 text-text-secondary">
                    <p>
                        CodeConnect uses cookies to enhance your browsing experience, analyze site traffic, and understand where our audience is coming from. 
                        By using our website, you agree to our use of cookies as described in this policy.
                    </p>

                    <div>
                        <h3 class="text-xl font-semibold text-text-primary mb-3">What are Cookies?</h3>
                        <p>
                            Cookies are small text files that are placed on your computer or mobile device when you visit a website. 
                            They are widely used to make websites work more efficiently and provide information to website owners.
                        </p>
                    </div>

                    <div>
                        <h3 class="text-xl font-semibold text-text-primary mb-3">Types of Cookies We Use</h3>
                        
                        <div class="space-y-4">
                            <div class="border border-border-custom rounded-lg p-4">
                                <h4 class="font-semibold text-accent-green mb-2">Necessary Cookies</h4>
                                <p class="text-sm">
                                    These cookies are essential for the website to function properly. They enable core functionality 
                                    such as security, network management, and accessibility. You cannot opt-out of these cookies.
                                </p>
                            </div>

                            <div class="border border-border-custom rounded-lg p-4">
                                <h4 class="font-semibold text-accent-blue mb-2">Analytics Cookies</h4>
                                <p class="text-sm">
                                    These cookies help us understand how visitors interact with our website by collecting and 
                                    reporting information anonymously. This helps us improve our website's performance.
                                </p>
                            </div>

                            <div class="border border-border-custom rounded-lg p-4">
                                <h4 class="font-semibold text-accent-orange mb-2">Marketing Cookies</h4>
                                <p class="text-sm">
                                    These cookies are used to deliver personalized advertisements and track the effectiveness 
                                    of our marketing campaigns across different platforms.
                                </p>
                            </div>

                            <div class="border border-border-custom rounded-lg p-4">
                                <h4 class="font-semibold text-accent-green mb-2">Functional Cookies</h4>
                                <p class="text-sm">
                                    These cookies enable enhanced functionality and personalization, such as remembering your 
                                    preferences and settings to provide a more personalized experience.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-xl font-semibold text-text-primary mb-3">Managing Your Cookie Preferences</h3>
                        <p class="mb-4">
                            You can manage your cookie preferences at any time by clicking the button below or by adjusting 
                            your browser settings. Please note that disabling certain cookies may affect the functionality of our website.
                        </p>
                        <button onclick="showCookieSettings()" class="bg-accent-green hover:bg-accent-green-hover text-white px-6 py-3 rounded-lg font-medium transition-colors">
                            <i class="fas fa-cog mr-2"></i>Manage Cookie Preferences
                        </button>
                    </div>
                </div>
            </div>

            <!-- Privacy Policy Section -->
            <div class="bg-card-dark border border-border-custom rounded-xl p-8">
                <h2 class="text-2xl font-semibold text-text-primary mb-6 flex items-center">
                    <i class="fas fa-shield-alt text-accent-green mr-3"></i>
                    Privacy Policy
                </h2>
                
                <div class="space-y-6 text-text-secondary">
                    <p>
                        At CodeConnect, we are committed to protecting your privacy and ensuring the security of your personal information. 
                        This Privacy Policy explains how we collect, use, and protect your data.
                    </p>

                    <div>
                        <h3 class="text-xl font-semibold text-text-primary mb-3">Information We Collect</h3>
                        <ul class="list-disc list-inside space-y-2">
                            <li>Account information (name, email, profile details)</li>
                            <li>Project and proposal data</li>
                            <li>Communication records</li>
                            <li>Usage analytics and performance data</li>
                            <li>Payment and transaction information</li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="text-xl font-semibold text-text-primary mb-3">How We Use Your Information</h3>
                        <ul class="list-disc list-inside space-y-2">
                            <li>To provide and improve our services</li>
                            <li>To facilitate connections between clients and developers</li>
                            <li>To process payments and transactions</li>
                            <li>To communicate with you about your account and projects</li>
                            <li>To analyze usage patterns and improve user experience</li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="text-xl font-semibold text-text-primary mb-3">Data Security</h3>
                        <p>
                            We implement industry-standard security measures to protect your personal information from unauthorized 
                            access, alteration, disclosure, or destruction. This includes encryption, secure servers, and regular 
                            security audits.
                        </p>
                    </div>

                    <div>
                        <h3 class="text-xl font-semibold text-text-primary mb-3">Your Rights</h3>
                        <p>
                            You have the right to access, update, or delete your personal information. You can also opt-out of 
                            certain communications and data processing activities. Contact us if you wish to exercise these rights.
                        </p>
                    </div>

                    <div>
                        <h3 class="text-xl font-semibold text-text-primary mb-3">Contact Us</h3>
                        <p>
                            If you have any questions about this Privacy Policy or our cookie practices, please contact us at 
                            <a href="mailto:privacy@codeconnect.com" class="text-accent-green hover:text-accent-green-hover">privacy@codeconnect.com</a>.
                        </p>
                    </div>

                    <div class="text-sm text-text-muted pt-4 border-t border-border-custom">
                        <p>Last updated: {{ date('F j, Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
