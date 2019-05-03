var cheerio = require('cheerio');
var _ = require('lodash');
var helper = require('../../../../helpers/functions');
var cleanHtml = require('../../../../helpers/clean_html');

module.exports = {
    parseInfo: async function (body) {
        return await parseInfo(body);
    },
};

async function parseInfo(html) {
    var data = {};
    try {
        var $ = cheerio.load(html, {decodeEntities: false});
        if ($('.serp-controller__content').length) {
            var imgs = [];
            $('.serp-controller__content').find('.serp-item').each(function () {
                var imgInfo = JSON.parse($(this).attr('data-bem'))['serp-item'];
                var img = {
                    title: imgInfo.snippet.title,
                    img_href: imgInfo.img_href,
                };
                imgs.push(img);
            });
            data.img = imgs;
        }
    } catch (e) {
        console.log(e);
        data = {};
    }
    return data;
}