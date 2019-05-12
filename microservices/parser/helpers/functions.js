var randomUseragent = require('random-useragent');

async function getRandomUserAgent() {
    return randomUseragent.getRandom(function (ua) {
        return ua.deviceType !== 'mobile' && ua.deviceType !== 'tablet' && !ua.userAgent.includes('Parser');
    });
}

module.exports = {
    getRandomUseragent: getRandomUserAgent
};