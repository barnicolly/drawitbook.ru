/**
 * Поиск тасков
 * @type {Gulp}
 */
helper.searchFilesInDir('gulp/tasks', /\.js$/, function (filename) {
    filename = '../' + filename;
    require(filename);
});