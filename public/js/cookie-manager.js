/**
 * Cookie Management System for CodeConnect
 */

class CookieManager {
    constructor() {
        this.cookieTypes = {
            necessary: true, // Always true
            analytics: false,
            marketing: false,
            functional: false
        };
        
        this.init();
    }

    init() {
        // Check if user has already made a choice
        if (!this.hasUserConsent()) {
            this.showCookieBanner();
        } else {
            this.loadUserPreferences();
        }
    }

    hasUserConsent() {
        return this.getCookie('cookie_consent') !== null;
    }

    showCookieBanner() {
        const banner = document.getElementById('cookieConsent');
        if (banner) {
            banner.style.display = 'block';
            setTimeout(() => {
                banner.classList.remove('translate-y-full');
            }, 100);
        }
    }

    hideCookieBanner() {
        const banner = document.getElementById('cookieConsent');
        if (banner) {
            banner.classList.add('translate-y-full');
            setTimeout(() => {
                banner.style.display = 'none';
            }, 300);
        }
    }

    acceptAllCookies() {
        this.cookieTypes = {
            necessary: true,
            analytics: true,
            marketing: true,
            functional: true
        };
        this.savePreferences();
        this.hideCookieBanner();
        this.loadCookieScripts();
    }

    acceptNecessaryCookies() {
        this.cookieTypes = {
            necessary: true,
            analytics: false,
            marketing: false,
            functional: false
        };
        this.savePreferences();
        this.hideCookieBanner();
    }

    saveCustomPreferences() {
        this.cookieTypes = {
            necessary: true, // Always true
            analytics: document.getElementById('analyticsCookies')?.checked || false,
            marketing: document.getElementById('marketingCookies')?.checked || false,
            functional: document.getElementById('functionalCookies')?.checked || false
        };
        this.savePreferences();
        this.closeCookieSettings();
        this.hideCookieBanner();
        this.loadCookieScripts();
    }

    savePreferences() {
        const preferences = JSON.stringify(this.cookieTypes);
        this.setCookie('cookie_consent', preferences, 365);
        this.setCookie('cookie_timestamp', Date.now(), 365);
    }

    loadUserPreferences() {
        const preferences = this.getCookie('cookie_consent');
        if (preferences) {
            try {
                this.cookieTypes = JSON.parse(preferences);
                this.loadCookieScripts();
            } catch (e) {
                console.error('Error parsing cookie preferences:', e);
            }
        }
    }

    loadCookieScripts() {
        // Load analytics scripts if enabled
        if (this.cookieTypes.analytics) {
            this.loadAnalyticsScripts();
        }

        // Load marketing scripts if enabled
        if (this.cookieTypes.marketing) {
            this.loadMarketingScripts();
        }

        // Load functional scripts if enabled
        if (this.cookieTypes.functional) {
            this.loadFunctionalScripts();
        }
    }

    loadAnalyticsScripts() {
        // Example: Google Analytics
        if (!window.gtag && this.cookieTypes.analytics) {
            const script = document.createElement('script');
            script.async = true;
            script.src = 'https://www.googletagmanager.com/gtag/js?id=GA_MEASUREMENT_ID';
            document.head.appendChild(script);

            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'GA_MEASUREMENT_ID');
        }
    }

    loadMarketingScripts() {
        // Example: Facebook Pixel, Google Ads, etc.
        console.log('Loading marketing scripts...');
    }

    loadFunctionalScripts() {
        // Example: Chat widgets, preference storage, etc.
        console.log('Loading functional scripts...');
    }

    showCookieSettings() {
        const modal = document.getElementById('cookieSettingsModal');
        if (modal) {
            modal.style.display = 'flex';
            
            // Set current preferences in the modal
            document.getElementById('analyticsCookies').checked = this.cookieTypes.analytics;
            document.getElementById('marketingCookies').checked = this.cookieTypes.marketing;
            document.getElementById('functionalCookies').checked = this.cookieTypes.functional;
        }
    }

    closeCookieSettings() {
        const modal = document.getElementById('cookieSettingsModal');
        if (modal) {
            modal.style.display = 'none';
        }
    }

    // Utility methods for cookie handling
    setCookie(name, value, days) {
        const expires = new Date();
        expires.setTime(expires.getTime() + (days * 24 * 60 * 60 * 1000));
        document.cookie = `${name}=${value};expires=${expires.toUTCString()};path=/;SameSite=Lax`;
    }

    getCookie(name) {
        const nameEQ = name + "=";
        const ca = document.cookie.split(';');
        for (let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) === ' ') c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
        }
        return null;
    }

    deleteCookie(name) {
        document.cookie = `${name}=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;`;
    }

    // Public method to check if specific cookie type is allowed
    isAllowed(type) {
        return this.cookieTypes[type] || false;
    }

    // Method to reset all preferences (for testing or user request)
    resetPreferences() {
        this.deleteCookie('cookie_consent');
        this.deleteCookie('cookie_timestamp');
        this.cookieTypes = {
            necessary: true,
            analytics: false,
            marketing: false,
            functional: false
        };
        location.reload();
    }
}

// Global functions for the UI
let cookieManager;

function acceptAllCookies() {
    cookieManager.acceptAllCookies();
}

function acceptNecessaryCookies() {
    cookieManager.acceptNecessaryCookies();
}

function showCookieSettings() {
    cookieManager.showCookieSettings();
}

function closeCookieSettings() {
    cookieManager.closeCookieSettings();
}

function saveCustomCookiePreferences() {
    cookieManager.saveCustomPreferences();
}

function acceptAllCookiesFromModal() {
    cookieManager.acceptAllCookies();
    cookieManager.closeCookieSettings();
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    cookieManager = new CookieManager();
});

// Close modal when clicking outside
document.addEventListener('click', function(event) {
    const modal = document.getElementById('cookieSettingsModal');
    if (event.target === modal) {
        closeCookieSettings();
    }
});

// Export for use in other scripts
window.CookieManager = CookieManager;
