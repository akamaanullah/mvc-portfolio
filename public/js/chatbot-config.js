window.AK_CHATBOT_CONFIG = {
    endpoint: (window.__BASE_URL || '') + '/api/chat/message',
    leadEndpoint: (window.__BASE_URL || '') + '/api/chat/lead',
    initLiveEndpoint: (window.__BASE_URL || '') + '/api/chat/init-live',
    pollEndpoint: (window.__BASE_URL || '') + '/api/chat/poll',
    closeEndpoint: (window.__BASE_URL || '') + '/api/chat/close',
    botName: 'Amaanullah (Assistant)',
    whatsapp: 'https://api.whatsapp.com/send?phone=923196935307',
    poweredBy: 'Amaanullah Khan',
    poweredUrl: (window.__BASE_URL || '') + '/about',
    greetingDelay: 3500,
    maxChars: 500,
    timeout: 25000
};
