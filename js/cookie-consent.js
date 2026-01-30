/**
 * Cookie Consent Manager
 * Handles cookie preferences and consent banner
 */
const CookieConsent = {
    // Cookie settings
    COOKIE_NAME: 'shophub_cookie_consent',
    COOKIE_EXPIRY_DAYS: 365,
    
    /**
     * Set a cookie
     */
    setCookie: function(name, value, days) {
        const date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        const expires = "expires=" + date.toUTCString();
        document.cookie = name + "=" + value + ";" + expires + ";path=/;SameSite=Lax";
    },
    
    /**
     * Get a cookie
     */
    getCookie: function(name) {
        const nameEQ = name + "=";
        const cookies = document.cookie.split(';');
        for(let i = 0; i < cookies.length; i++) {
            let cookie = cookies[i].trim();
            if (cookie.indexOf(nameEQ) === 0) {
                return cookie.substring(nameEQ.length);
            }
        }
        return null;
    },
    
    /**
     * Delete a cookie
     */
    deleteCookie: function(name) {
        document.cookie = name + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
    },
    
    /**
     * Check if user has made a choice
     */
    hasConsent: function() {
        return this.getCookie(this.COOKIE_NAME) !== null;
    },
    
    /**
     * Get user's consent status
     */
    getConsentStatus: function() {
        const consent = this.getCookie(this.COOKIE_NAME);
        return consent === 'accepted';
    },
    
    /**
     * Accept cookies
     */
    acceptCookies: function() {
        this.setCookie(this.COOKIE_NAME, 'accepted', this.COOKIE_EXPIRY_DAYS);
        this.enableAnalytics();
        this.hideBanner();
        this.showNotification('✓ Cookie preferences saved!', 'success');
    },
    
    /**
     * Reject cookies
     */
    rejectCookies: function() {
        this.setCookie(this.COOKIE_NAME, 'rejected', this.COOKIE_EXPIRY_DAYS);
        this.disableAnalytics();
        this.clearNonEssentialCookies();
        this.hideBanner();
        this.showNotification('Cookie preferences saved. Only essential cookies will be used.', 'info');
    },
    
    /**
     * Clear all non-essential cookies
     */
    clearNonEssentialCookies: function() {
        // List of cookies to keep (essential only)
        const essentialCookies = ['PHPSESSID', this.COOKIE_NAME];
        
        const cookies = document.cookie.split(';');
        cookies.forEach(cookie => {
            const cookieName = cookie.split('=')[0].trim();
            if (!essentialCookies.includes(cookieName)) {
                this.deleteCookie(cookieName);
            }
        });
    },
    
    /**
     * Enable analytics/tracking
     */
    enableAnalytics: function() {
        // Add your analytics code here (Google Analytics, etc.)
        console.log('Analytics enabled');
        // Example: gtag('consent', 'update', {'analytics_storage': 'granted'});
    },
    
    /**
     * Disable analytics/tracking
     */
    disableAnalytics: function() {
        console.log('Analytics disabled');
        // Example: gtag('consent', 'update', {'analytics_storage': 'denied'});
    },
    
    /**
     * Show cookie banner
     */
    showBanner: function() {
        if (!this.hasConsent()) {
            $('#cookieConsentBanner').fadeIn(300);
        }
    },
    
    /**
     * Hide cookie banner
     */
    hideBanner: function() {
        $('#cookieConsentBanner').fadeOut(300);
    },
    
    /**
     * Show notification
     */
    showNotification: function(message, type = 'info') {
        const colors = {
            success: 'bg-green-500',
            info: 'bg-blue-500',
            warning: 'bg-yellow-500',
            error: 'bg-red-500'
        };
        
        const notification = $(`
            <div class="fixed top-24 right-4 ${colors[type]} text-white px-6 py-4 rounded-lg shadow-2xl flex items-center space-x-3 z-[60] animate-slideIn">
                <i class="fas fa-cookie-bite text-2xl"></i>
                <span class="font-semibold">${message}</span>
            </div>
        `);
        
        $('body').append(notification);
        setTimeout(() => notification.fadeOut(() => notification.remove()), 3000);
    },
    
    /**
     * Initialize cookie consent
     */
    init: function() {
        // Show banner if no consent decision made
        this.showBanner();
        
        // Accept button
        $(document).on('click', '#acceptCookies', () => {
            this.acceptCookies();
        });
        
        // Reject button
        $(document).on('click', '#rejectCookies', () => {
            this.rejectCookies();
        });
        
        // Customize button (opens settings modal)
        $(document).on('click', '#customizeCookies', () => {
            this.showSettingsModal();
        });
        
        // Apply existing consent if present
        if (this.hasConsent() && this.getConsentStatus()) {
            this.enableAnalytics();
        }
    },
    
    /**
     * Show cookie settings modal
     */
    showSettingsModal: function() {
        const isAccepted = this.getConsentStatus();
        
        const modal = $(`
            <div id="cookieSettingsModal" class="fixed inset-0 bg-black bg-opacity-50 z-[70] flex items-center justify-center p-4">
                <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[80vh] overflow-y-auto animate-fadeIn">
                    <div class="gradient-bg text-white p-6 rounded-t-2xl">
                        <div class="flex justify-between items-center">
                            <h3 class="text-2xl font-bold flex items-center">
                                <i class="fas fa-cookie-bite mr-3"></i>
                                Cookie Settings
                            </h3>
                            <button id="closeSettingsModal" class="text-white hover:text-gray-200 text-2xl">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="p-6 space-y-6">
                        <p class="text-gray-600">
                            We use cookies to enhance your browsing experience and analyze site traffic. 
                            Choose which cookies you'd like to allow:
                        </p>
                        
                        <!-- Essential Cookies -->
                        <div class="border-2 border-gray-200 rounded-lg p-4">
                            <div class="flex justify-between items-center mb-2">
                                <div class="flex items-center">
                                    <i class="fas fa-shield-alt text-green-600 text-xl mr-3"></i>
                                    <h4 class="font-bold text-lg">Essential Cookies</h4>
                                </div>
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">
                                    Always Active
                                </span>
                            </div>
                            <p class="text-gray-600 text-sm ml-9">
                                Required for the website to function properly. Includes session management and security features.
                            </p>
                        </div>
                        
                        <!-- Analytics Cookies -->
                        <div class="border-2 border-gray-200 rounded-lg p-4">
                            <div class="flex justify-between items-center mb-2">
                                <div class="flex items-center">
                                    <i class="fas fa-chart-line text-blue-600 text-xl mr-3"></i>
                                    <h4 class="font-bold text-lg">Analytics Cookies</h4>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" id="analyticsToggle" class="sr-only peer" ${isAccepted ? 'checked' : ''}>
                                    <div class="w-14 h-7 bg-gray-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-purple-600"></div>
                                </label>
                            </div>
                            <p class="text-gray-600 text-sm ml-9">
                                Help us understand how visitors interact with our website to improve user experience.
                            </p>
                        </div>
                        
                        <!-- Preferences Cookies -->
                        <div class="border-2 border-gray-200 rounded-lg p-4">
                            <div class="flex justify-between items-center mb-2">
                                <div class="flex items-center">
                                    <i class="fas fa-sliders-h text-purple-600 text-xl mr-3"></i>
                                    <h4 class="font-bold text-lg">Preference Cookies</h4>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" id="preferencesToggle" class="sr-only peer" ${isAccepted ? 'checked' : ''}>
                                    <div class="w-14 h-7 bg-gray-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-purple-600"></div>
                                </label>
                            </div>
                            <p class="text-gray-600 text-sm ml-9">
                                Remember your preferences like language, region, and display settings.
                            </p>
                        </div>
                    </div>
                    
                    <div class="p-6 bg-gray-50 rounded-b-2xl flex justify-end space-x-3">
                        <button id="saveSettings" class="gradient-bg text-white px-6 py-3 rounded-lg font-semibold hover:opacity-90 transition">
                            <i class="fas fa-save mr-2"></i>Save Preferences
                        </button>
                    </div>
                </div>
            </div>
        `);
        
        $('body').append(modal);
        
        // Close modal
        $(document).on('click', '#closeSettingsModal, #cookieSettingsModal', function(e) {
            if (e.target.id === 'cookieSettingsModal' || e.target.id === 'closeSettingsModal' || $(e.target).parent().attr('id') === 'closeSettingsModal') {
                $('#cookieSettingsModal').fadeOut(() => $('#cookieSettingsModal').remove());
            }
        });
        
        // Save settings
        $(document).on('click', '#saveSettings', () => {
            const analyticsEnabled = $('#analyticsToggle').is(':checked');
            const preferencesEnabled = $('#preferencesToggle').is(':checked');
            
            if (analyticsEnabled || preferencesEnabled) {
                this.acceptCookies();
            } else {
                this.rejectCookies();
            }
            
            $('#cookieSettingsModal').fadeOut(() => $('#cookieSettingsModal').remove());
        });
    }
};

// Initialize on page load
$(document).ready(function() {
    CookieConsent.init();
});