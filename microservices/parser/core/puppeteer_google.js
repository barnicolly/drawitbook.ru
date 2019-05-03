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
            headless: false,
            args: ['--no-sandbox', '--disable-setuid-sandbox'],
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
    parseUrl: async function (url, text) {
        return new Promise((resolve, reject) => {
            clusterInstance.queue(async ({page}) => {

                console.log('Получение страницы', url);
                await page.setUserAgent(await helper.getRandomUseragent());
                await page.setDefaultTimeout(30000);
                try {
                    await page.goto(url);
                    await page.evaluate(function (text) {
                        var dom = document.querySelector('#translate-text-unique');
                        dom.innerHTML = text;
                    }, text);
                    await page.waitForFunction(
                        'document.querySelector("#stopper").innerText.includes("заглавие")'
                    );
                    await page.evaluate(async() => {
                        window.scrollBy(0, window.innerHeight)
                    });
                    await page.evaluate(async() => {
                        window.scrollBy(0, window.innerHeight)
                    });
                    await page.waitFor(3000);
                } catch (error) {
                    console.log(`Не удалось открыть
      страницу: ${url} из-за ошибки: ${error}`);
                    reject(error);
                }
                var content = await page.content();
                resolve(content);
            });
        });
    }
};