var helper = require('../helpers/functions');
var _ = require('lodash');
var phantomCfg = require('../config/phantom_config');
var createPhantomPool = require('phantom-pool');

/*module.exports = {
    parseUrl: async function (url) {
        return parseUrl(url);
    }
};*/

var pool;

function timeout(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

/*async function parseUrl(url) {
    console.log('Отправил', url);
    var content = await withPool(url);
    return content;
}*/

async function init() {
    // pool = createPhantomPool(phantomCfg.pool);
};

async function close() {
    return new Promise(resolve => function () {
       /* pool.drain().then(() => function () {
            pool.clear();
            resolve(true);
        })*/
       resolve(true);
    });

}

async function render(instance, url) {
    try {
        const page = await instance.createPage();
        page.setting('userAgent', await helper.getRandomUseragent());
        _.each(phantomCfg.page.settings, function (value, setting) {
            page.setting(setting, value);
        });
        _.each(phantomCfg.page.property, function (value, property) {
            page.property(property, value);
        });
        const status = await page.open(url);

        page.evaluate(function () {
            console.log(2228);
            // Scrolls to the bottom of page
            window.document.body.scrollTop = document.body.scrollHeight;
        });

        // await timeout(7000);
        if (status !== 'success') throw new Error('Не смог получить страницу ');
        return await page.property('content');
    } catch (e) {
        throw new Error('Не смог получить страницу ');
    }

}

var withPool = (url) => pool.use(async (instance) => {
    return new Promise((resolve, reject) => {
        try {
            resolve(render(instance, url));
        } catch (e) {
            reject(e);
        }
    });
});

module.exports = {
    init: async function () {
        return await init();
    },
    close: async function () {
        return await close();
    },
    parseUrl: async function (url) {
        console.log('Отправил', url);
        var content = await renderOne(url);
        return content;
    },
};

var randomUseragent = require('random-useragent');
var phantom = require('phantom');

async function f() {
    return new Promise(async function (resolve, reject) {

    });
}

function renderOne(url) {
    return new Promise(async function (resolve, reject) {
        var args = ['--proxy=127.0.0.1:9050 --proxy-type=socks5'];
        const instance = await phantom.create();
        const page = await instance.createPage();
        page.property('userAgent', randomUseragent.getRandom(function (ua) {
            return ua.deviceType !== 'mobile' && ua.deviceType !== 'tablet';
        }));
        page.property('viewportSize', {width: 1024, height: 900});
        page.property('loadImages', false);

        var status = await page.open(url);


        if (status !== "success") {
            // await timeout(1000);
            await instance.exit();
            reject(false);
        } else {

            for (var i = 1; i < 3; i++) {
                await page.evaluate(function () {
                    window.document.body.scrollTop = document.body.scrollHeight;
                    // Scrolls to the bottom of page
                    // window.document.body.scrollTop = document.body.scrollHeight;
                });
                console.log('жду 3 минут');
                await timeout(1800);
                // await timeout(180000);
                console.log('подождал 3 минут');
            }

            const content = await page.property('content');
            // await timeout(500);
            // page.evaluate(function () {
            //     console.log("nen");
            // Scrolls to the bottom of page
            // window.document.body.scrollTop = document.body.scrollHeight;
            // });
            // console.log(content);
            await instance.exit();
            console.log(content);
            resolve(content);
        }

        // page.open(url, function () {
        //
        //     // Checks for bottom div and scrolls down from time to time
        //     window.setInterval(async function() {
        //         // Checks if there is a div with class=".has-more-items"
        //         // (not sure if this is the best way of doing it)
        //         var count = page.content.match(/class=".has-more-items"/g);
        //
        //         if(count === null) { // Didn't find
        //             page.evaluate(function() {
        //                 // Scrolls to the bottom of page
        //                 window.document.body.scrollTop = document.body.scrollHeight;
        //             });
        //         }
        //         else {
        //             const content = await page.property('content');
        //             await instance.exit();
        //             resolve(content);
        //         }
        //     }, 500); // Number of milliseconds to wait between scrolls
        //
        // });

    });
}