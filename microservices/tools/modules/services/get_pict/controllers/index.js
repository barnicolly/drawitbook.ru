var _ = require('lodash');
var async = require('async');
var axios = require('axios');
var actions = require('../constants/primary').actions;
var constants = require('../constants/primary').constants;
var helper = require('../../../../helpers/functions');
var request = require('../../../../../parser/core/puppeteer_yandex');
var parser = require('./parser');
var time = null;
var donor = require('../../../db/dynamic/controllers/donor');
var emojiStrip = require('emoji-strip');
var doneAll = false;
var parsed = 0;

module.exports = {
    init: async function () {
        await request.init();
        await start();
        // pushTask(actions.getParseLinks(), {});
        time = new Date().getTime();
        // var string = 'рисунки по клеточкам';
        // var data = {url: 'https://yandex.ru/images/search?text=' + encodeURI(string), query: string};
        // pushTask(actions.parseUrl(), data);
        pushTask(actions.getQueries());

        // const FileDownload = require('js-file-download');
        // axios.get('https://ext.captcha.yandex.net/image?key=003ysKVe9EfvGoajUwTd1MyO2UPsnltP')
        //     .then((response) => {
        //         // console.log(response);
        //         response.data.pipe(file);
        //         // FileDownload(response.data, 'C:\\OSPanel\\domains\\laravel\\drawitbook\\microservices\\tools\\data\\captcha.jpg');
        //     });

        /*axios({
            method: 'post',
            url: 'http://rucaptcha.com/in.php',
            data: {
                firstName: 'Fred',
                lastName: 'Flintstone'
            }
        });*/

    }
};

var taskHandler = function (work, done) {
    if (work.type === constants.GET_QUERIES) {
        var afterSuccess = function (res, work, done) {
            console.log('Получил поисковые запросы');
            if (_.size(res)) {
                parsed += 1;
                _.each(res, function (item) {
                    var data = {url: 'https://yandex.ru/images/search?text=' + encodeURI(item.query), queryId: item.id};
                    pushTask(actions.parseUrl(), data);
                })
            } else {
                doneAll = true;
            }

            done();
        };
        tryDone(donor.get('query', appConfig.database.kartinki, {
            status: 3,
        }, ['id', 'query'], {limit: 1}), work, afterSuccess, function () {
            done();
        });
    } else if (work.type === constants.PARSE_URL) {
        var afterSuccess = function (res, work, done) {
            console.log('Получил контент');
            // console.log(res);
            pushTask(actions.parseInfo(), {content: res, queryId: work.data.queryId});
            done();
        };
        tryDone(request.parseUrl(work.data.url), work, afterSuccess, function () {
            done();
        });
    } else if (work.type === constants.PARSE_INFO) {
        var afterSuccess = function (res, work, done) {
            // console.log('Получил ссылки');
            if (typeof res.img !== 'undefined') {
                var insertData = [];
                _.each(res.img, function (item) {
                    if (_.size(item.img_href) < 1000) {
                        insertData.push({
                            url: item.img_href,
                            query_id: work.data.queryId
                        })
                    }
                });
                // console.log(_.size(insertData));
                pushTask(actions.insertData(), {insertData: insertData, queryId: work.data.queryId});
            } else {
                console.log('не смог обработать контент');
            }
            done();
        };
        tryDone(parser.parseInfo(work.data.content), work, afterSuccess, function () {
            done();
        });
    } else if (work.type === constants.INSERT_DATA) {
        var afterSuccess = function (res, work, done) {
            console.log('Вставил ссылки');
            pushTask(actions.updateDonor(), {updateData: {id: work.data.queryId, status: 4}});
            done();
        };
        tryDone(donor.insertBatch('new_pages', appConfig.database.kartinki, work.data.insertData), work, afterSuccess, function () {
            done();
        });
    } else if (work.type === constants.UPDATE_DONOR) {
        var afterSuccess = function (res, work, done) {
            helper.log('Обновил донор');
            done();
        };
        tryDone(donor.save('query', appConfig.database.kartinki, work.data.updateData), work, afterSuccess, function () {
            done();
        });
    }
};

function tryDone(promise, work, successFunction, done) {
    return promise
        .then(res => {
            successFunction(res, work, function () {
                done(true);
            })
        })
        .catch(e => {
            repush(work, e);
            done(false);
        })
}

var query = null;

async function start() {
    query = async.priorityQueue(taskHandler, 15);
    query.drain = function () {
        if (doneAll === true || parsed >= 200) {
            request.close();
            process.exit();
        } else {
            pushTask(actions.getQueries());
        }
    };
}

function repush(work, message = '') {
    helper.log(work.type);
    work.action.priority = 99999;
    if (message) {
        helper.log(message);
        pushTask(work.action, work.data);
    } else {
        pushTask(work.action, work.data);
    }

}

function pushTask(action, data) {
    var newData = Object.assign({}, data);
    query.push({
        type: action.type,
        data: newData,
        action: action
    }, action.priority);
}
