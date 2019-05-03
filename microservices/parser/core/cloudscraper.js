var helper = require('../helpers/functions');
var _ = require('lodash');

async function init() {
};

async function close() {
}
const cloudscraper = require('cloudscraper');
module.exports = {
    init: async function () {
        return await init();
    },
    close: async function () {
        return await close();
    },
    parseUrl: async function (url) {
        return new Promise((resolve, reject) => {
            var options = {
                uri: url,
                // proxy: '127.0.0.1:9050',
                headers: {
                    'User-Agent': helper.getRandomUseragent(),
                    'Cache-Control': 'private',
                    'Accept': 'application/xml,application/xhtml+xml,text/html;q=0.9, text/plain;q=0.8,image/png,*/*;q=0.5'
                },
                // Cloudflare requires a delay of 5 seconds, so wait for at least 6.
                cloudflareTimeout: 6000,
                // followAllRedirects - follow non-GET HTTP 3xx responses as redirects
                followAllRedirects: true,
                // Support only this max challenges in row. If CF returns more, throw an error
                challengesToSolve: 3
            };
            var Agent = require('socks5-https-client/lib/Agent');
            options.agentClass = Agent;
            options.agentOptions = {
                socksHost: '178.62.217.192', // Defaults to 'localhost'.
                socksPort: 1080 // Defaults to 1080.
            };

            cloudscraper(options, function(error, response, body) {
                if (!error) {
                    console.log(error);
                    reject(error);
                } else {
                    resolve(body);
                }

            });
        });
    }
};