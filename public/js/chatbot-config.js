/**
 * Dynamic AI Assistant & Live Chat Configuration
 * Loaded dynamically from database settings without hardcoded credentials.
 */
(function() {
    var path = window.location.pathname || '';
    var base = '';
    if (typeof window.__BASE_URL === 'string') {
        base = window.__BASE_URL;
    } else {
        var m = path.match(/^(\/[^\/]+)\/(admin|api|services|projects|articles|about|contact)/);
        if (m) {
            base = m[1];
        }
    }
    base = base.replace(/\/$/, '');
    window.__BASE_URL = base;

    var s = window.__SITE_SETTINGS || {};

    window.AK_CHATBOT_CONFIG = {
        endpoint: base + '/api/chat/message',
        leadEndpoint: base + '/api/chat/lead',
        initLiveEndpoint: base + '/api/chat/init-live',
        pollEndpoint: base + '/api/chat/poll',
        closeEndpoint: base + '/api/chat/close',
        botName: s.botName || 'Amaanullah AI',
        whatsapp: s.whatsapp || '',
        welcomeMessage: s.welcomeMsg || '',
        showMobile: typeof s.showMobile !== 'undefined' ? s.showMobile : true,
        greetingDelay: 3500,
        maxChars: 500,
        timeout: 25000
    };
})();
