/**
 * Amaanullah AI Assistant & Live Chat Configuration
 */
(function() {
    // Detect base URL dynamically (e.g. /web3d-full on local XAMPP or '' in production)
    var path = window.location.pathname || '';
    var base = '';
    if (window.__BASE_URL !== undefined) {
        base = window.__BASE_URL;
    } else if (path.indexOf('/web3d-full') !== -1) {
        base = '/web3d-full';
    }
    base = base.replace(/\/$/, '');
    window.__BASE_URL = base;

    window.AK_CHATBOT_CONFIG = {
        endpoint: base + '/api/chat/message',
        leadEndpoint: base + '/api/chat/lead',
        initLiveEndpoint: base + '/api/chat/init-live',
        pollEndpoint: base + '/api/chat/poll',
        closeEndpoint: base + '/api/chat/close',
        botName: 'Amaanullah AI',
        whatsapp: 'https://api.whatsapp.com/send?phone=923196935307',
        poweredBy: 'Amaanullah Khan',
        poweredUrl: base + '/about',
        greetingDelay: 3500,
        maxChars: 500,
        timeout: 25000
    };
})();
