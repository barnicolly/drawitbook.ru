var helper = require('../helpers/functions');
var _ = require('lodash');

const {Cluster} = require('puppeteer-cluster');
var clusterInstance;

async function init(concurancy = 8) {
    clusterInstance = await Cluster.launch({
        concurrency: Cluster.CONCURRENCY_PAGE,
        maxConcurrency: concurancy,
        puppeteerOptions: {
            browsers: ['ChromeHeadlessNoSandbox'],
            customLaunchers: {
                ChromeHeadlessNoSandbox: {
                    base: 'ChromeHeadless',
                    flags: ['--no-sandbox']
                }
            },
            headless: true,
            args: ['--no-sandbox', '--disable-setuid-sandbox', '--proxy-server=socks5://127.0.0.1:9050'],
        },
    });
};

async function close() {
    await clusterInstance.idle();
    await clusterInstance.close();
}

module.exports = {
    init: async function (concurancy = 8) {
        return await init(concurancy);
    },
    close: async function () {
        return await close();
    },
    parseUrl: async function (url) {
        return new Promise((resolve, reject) => {
            clusterInstance.queue(async ({ page }) => {
                await page.setUserAgent(await helper.getRandomUseragent());
                await page.setRequestInterception(true);
                await page.setDefaultTimeout(7000);
                page.on('request', request => {
                    const url = request.url();
                    const filters = [
                        'yandex',
                        'google',
                        'yastatic',
                    ];
                    const shouldAbort = filters.some((urlPart) => url.includes(urlPart));
                    if (shouldAbort) {
                        request.abort();
                    } else {
                        if (['image', 'stylesheet', 'font'].indexOf(request.resourceType()) !== -1) {
                            request.abort();
                        } else {
                            request.continue();
                        }
                    }
                });
                try {
                    await page.goto(url);
                    await page.waitFor(250);
                } catch (error) {
                    console.log(`Не удалось открыть
      страницу: ${url} из-за ошибки: ${error}`);
                    reject(error);
                }

                // console.log();
                var content = await page.content();
                // console.log(content);
                // await page.close();
                resolve(content);
            });
        });
    }
};