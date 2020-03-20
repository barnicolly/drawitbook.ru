var path = require('path'),
    fs = require('fs');

module.exports = {
    searchFilesInDir: function (startPath, filter, callback) {
        return searchFilesInDir(startPath, filter, callback);
    },
    getCommandLineArgs: function () {
        return getCommandLineArgs();
    },
};

/**
 * Получение списка параметров переданных в командной строке вида
 * gulp task --env development --par2 test2
 */
function getCommandLineArgs() {
    const arg = (argList => {
        let arg = {}, a, opt, thisOpt, curOpt;
        for (a = 0; a < argList.length; a++) {
            thisOpt = argList[a].trim();
            opt = thisOpt.replace(/^\-+/, '');
            if (opt === thisOpt) {
                if (curOpt) arg[curOpt] = opt;
                curOpt = null;
            } else {
                curOpt = opt;
                arg[curOpt] = true;
            }
        }
        return arg;
    })(process.argv);
    return arg;
}

/**
 * Поиск файлов в директории по регулярному выражению
 *
 * @param startPath
 * @param filter
 * @param callback
 */
function searchFilesInDir(startPath, filter, callback) {
    if (!fs.existsSync(startPath)) {
        return;
    }
    var files = fs.readdirSync(startPath);
    for (var i = 0; i < files.length; i++) {
        var filename = path.join(startPath, files[i]);
        var stat = fs.lstatSync(filename);
        if (stat.isDirectory()) {
            searchFilesInDir(filename, filter, callback);
        }
        else if (filter.test(filename)) {
            callback(filename);
        }
    }
}
/*
function test() {
    setInterval(function () {
    $('.js-message-load-more ._nb-button-text').trigger('click');
        $('.mail-Toolbar-Item_main-select-all').trigger('click');
        $('.mail-Toolbar-Item_delete').trigger('click');
        $('button.js-confirm-mops').trigger('click');
        $('.js-message-load-more ._nb-button-text').trigger('click');
    }, 2000);
}*/