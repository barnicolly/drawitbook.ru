var cheerio = require('cheerio');
var beauty = require('js-beautify').html_beautify;
var lodash = require('lodash');

function cleanMessage(text) {
    var $ = cheerio.load(text, {decodeEntities: false});
    $("div[id^='yandex_rtb_']").remove();
    $('title').remove();
    $('noindex').remove();
    $('div.banner_ad').remove();
    $('*').removeAttr('style')
        .removeAttr('class')
        .removeAttr('width')
        .removeAttr('align')
        .removeAttr('height');
    $('pre > code').each(function () {
        $(this).replaceWith($(this).html());
    });
    $('style').remove();
    $('*').each(function () {
        if (!$(this).text().replace(/[\r\n]+/g, '')) {
            $(this).remove();
        }
    });
    $('h1').each(function () {
        var code = $(this).html();
        $(this).replaceWith('<h2>' + code + '</h2>');
    });
    $('strong').each(function () {
        var code = $(this).html();
        $(this).replaceWith('<span class="bold-font">' + code + '</span>');
    });
    $('yatag').remove();
    $('ins').remove();
    $('iframe').remove();
    $('pre').addClass('prettyprint linenums');
    $('img').addClass('img-responsive');
    if ($('pre span').length || $('code span').length) {
        if ($('pre span').length) {
            $('pre span').each(function () {
                $(this).replaceWith($(this).html());
            });
        }
        if ($('code span').length) {
            $('code span').each(function () {
                $(this).replaceWith($(this).html());
            });
        }
    }
    $('code').attr('translate', 'no');
    $('pre').attr('translate', 'no');
    var html = $('body').html().replace(/<!--(.*?)-->/g, '')
        .replace('<blockquote>\r\n<br>', '<blockquote>')
        .replace('<blockquote>\n<br>', '<blockquote>')
        .replace('<blockquote><br>', '<blockquote>')
        .replace('<br></blockquote>', '</blockquote>')
        .replace('<br>\n</blockquote>', '</blockquote>')
        .replace('<br>\r\n</blockquote>', '</blockquote>');


    function replacerCode(str, p1, offset, s) {
        return 'code> ' + p1;
    }
    html = html.replace(/code>([a-zA-Z0-9А-Яа-я])/g, replacerCode);


    return beauty(
        html, {
            "preserve-newlines": false,
            'brace-style': 'collapse-preserve-inline',
            'max_preserve_newline': 0,
            'end_with_newline': false,
        })
}

function recursiveReplaceWith($, html) {
    var tt = cheerio.load(html, {decodeEntities: false});
    if (tt('span').length) {
        tt('span').each(function () {
            $(this).replaceWith(recursiveReplaceWith($, $(this).html()));
        });
    }
    return tt.html();
}

module.exports = {
    cleanMessage: function (text) {
        return cleanMessage(text);
    },
};