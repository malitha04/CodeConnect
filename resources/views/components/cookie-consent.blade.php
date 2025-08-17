<!-- Cookie Consent Banner -->
<div id="cookieConsent" class="fixed bottom-0 left-0 right-0 bg-primary-darker border-t border-border-custom p-4 z-50 transform translate-y-full transition-transform duration-300" style="display: none;">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex-1">
                <div class="flex items-start space-x-3">
                    <i class="fas fa-cookie-bite text-accent-orange text-xl mt-1"></i>
                    <div>
                        <h4 class="text-text-primary font-semibold mb-1">We use cookies</h4>
                        <p class="text-text-secondary text-sm">
                            We use cookies to enhance your experience, analyze site traffic, and personalize content. 
                            By continuing to browse, you agree to our use of cookies.
                            <a href="#" onclick="showCookieSettings()" class="text-accent-green hover:text-accent-green-hover underline ml-1">Manage preferences</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <button onclick="acceptAllCookies()" class="bg-accent-green hover:bg-accent-green-hover text-white px-6 py-2 rounded-lg font-medium transition-colors">
                    Accept All
                </button>
                <button onclick="acceptNecessaryCookies()" class="bg-secondary-dark hover:bg-card-dark text-text-primary px-6 py-2 rounded-lg font-medium transition-colors border border-border-custom">
                    Necessary Only
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Cookie Settings Modal -->
<div id="cookieSettingsModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4" style="display: none;">
    <div class="bg-primary-dark border border-border-custom rounded-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-bold text-text-primary">Cookie Preferences</h3>
                <button onclick="closeCookieSettings()" class="text-text-secondary hover:text-text-primary">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <div class="space-y-6">
                <!-- Necessary Cookies -->
                <div class="border border-border-custom rounded-lg p-4">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="text-lg font-semibold text-text-primary">Necessary Cookies</h4>
                        <div class="bg-accent-green text-white px-3 py-1 rounded-full text-sm font-medium">
                            Always Active
                        </div>
                    </div>
                    <p class="text-text-secondary text-sm mb-3">
                        These cookies are essential for the website to function properly. They enable core functionality such as security, network management, and accessibility.
                    </p>
                    <div class="text-xs text-text-muted">
                        <strong>Examples:</strong> Session cookies, CSRF tokens, authentication cookies
                    </div>
                </div>

                <!-- Analytics Cookies -->
                <div class="border border-border-custom rounded-lg p-4">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="text-lg font-semibold text-text-primary">Analytics Cookies</h4>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="analyticsCookies" class="sr-only peer">
                            <div class="w-11 h-6 bg-secondary-dark peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-accent-green"></div>
                        </label>
                    </div>
                    <p class="text-text-secondary text-sm mb-3">
                        These cookies help us understand how visitors interact with our website by collecting and reporting information anonymously.
                    </p>
                    <div class="text-xs text-text-muted">
                        <strong>Examples:</strong> Google Analytics, page views, user behavior tracking
                    </div>
                </div>

                <!-- Marketing Cookies -->
                <div class="border border-border-custom rounded-lg p-4">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="text-lg font-semibold text-text-primary">Marketing Cookies</h4>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="marketingCookies" class="sr-only peer">
                            <div class="w-11 h-6 bg-secondary-dark peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-accent-green"></div>
                        </label>
                    </div>
                    <p class="text-text-secondary text-sm mb-3">
                        These cookies are used to deliver personalized advertisements and track the effectiveness of our marketing campaigns.
                    </p>
                    <div class="text-xs text-text-muted">
                        <strong>Examples:</strong> Ad targeting, conversion tracking, social media pixels
                    </div>
                </div>

                <!-- Functional Cookies -->
                <div class="border border-border-custom rounded-lg p-4">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="text-lg font-semibold text-text-primary">Functional Cookies</h4>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="functionalCookies" class="sr-only peer">
                            <div class="w-11 h-6 bg-secondary-dark peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-accent-green"></div>
                        </label>
                    </div>
                    <p class="text-text-secondary text-sm mb-3">
                        These cookies enable enhanced functionality and personalization, such as remembering your preferences and settings.
                    </p>
                    <div class="text-xs text-text-muted">
                        <strong>Examples:</strong> Language preferences, theme settings, remembered form data
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-3 mt-8 pt-6 border-t border-border-custom">
                <button onclick="saveCustomCookiePreferences()" class="bg-accent-green hover:bg-accent-green-hover text-white px-6 py-2 rounded-lg font-medium transition-colors">
                    Save Preferences
                </button>
                <button onclick="acceptAllCookiesFromModal()" class="bg-secondary-dark hover:bg-card-dark text-text-primary px-6 py-2 rounded-lg font-medium transition-colors border border-border-custom">
                    Accept All
                </button>
            </div>
        </div>
    </div>
</div>
