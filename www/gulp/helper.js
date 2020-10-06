var path = require('path'),
    fs = require('fs');

module.exports = {
    searchFilesInDir: function (startPath, filter, callback) {
        return searchFilesInDir(startPath, filter, callback);
    },
};

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