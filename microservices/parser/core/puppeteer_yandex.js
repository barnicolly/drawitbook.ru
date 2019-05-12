var helper = require('../helpers/functions');
var download = require('../helpers/download');
var _ = require('lodash');


const {Cluster} = require('puppeteer-cluster');
var clusterInstance;

async function init(concurancy = 8) {
    clusterInstance = await Cluster.launch({
        concurrency: Cluster.CONCURRENCY_CONTEXT,
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
            args: ['--no-sandbox', '--disable-setuid-sandbox'],
        },
    });
};

async function close() {
    await clusterInstance.idle();
    await clusterInstance.close();
}

function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}
async function autoScroll(page){
    await page.evaluate(async () => {
        await new Promise((resolve, reject) => {
            var totalHeight = 0;
            var distance = 1000;
            var timer = setInterval(() => {
                var scrollHeight = 15000;
                window.scrollBy(0, distance);
                totalHeight += distance;

                if(totalHeight >= scrollHeight){
                    clearInterval(timer);
                    resolve();
                }
            }, 100);
        });
    });
}

module.exports = {
    init: async function (concurancy = 1) {
        return await init(concurancy);
    },
    close: async function () {
        return await close();
    },
    parseUrl: async function (url, text) {
        return new Promise((resolve, reject) => {
            clusterInstance.queue(async ({page}) => {

                await sleep(2000);

                console.log('Получение страницы', url);
                await page.setUserAgent(await helper.getRandomUseragent());
                await page.setDefaultTimeout(0);
                try {
                    await page.goto(url);
                    await page.mouse.move(100, 100);
                    await page.mouse.down();
                    await page.mouse.move(200, 200);
                    await page.mouse.up();
                    await page.waitFor(1000);
                    if (await page.$('img.form__captcha') !== null) {
                        var IMAGE_SELECTOR = 'img.form__captcha';
                        let captchaLink = await page.evaluate((sel) => {
                            return document.querySelector(sel).getAttribute('src');
                        }, IMAGE_SELECTOR);
                        console.log('captcha: ', captchaLink);
                        await download.downloadCaptcha(captchaLink);
                        var code = await download.recognizeCaptcha();
                        await page.evaluate(function (code) {
                            var dom = document.querySelector('#rep');
                            dom.value = code;
                        }, code);
                        await page.evaluate(function () {
                            var dom = document.querySelector('button.form__submit');
                            dom.click();
                        });
                        console.log('Ввел капчу');
                        await page.waitFor(3000);
                        await autoScroll(page);
                    } else {
                        console.log('нет капчи');
                        await page.waitFor(3000);
                        await autoScroll(page);
                    }
                    await page.waitFor(3000);
                } catch (error) {
                    console.log(`Не удалось открыть
      страницу: ${url} из-за ошибки: ${error}`);
                    reject(error);
                }
                var content = await page.content();
                console.log(content);
                resolve(content);
            });
        });
    }
};