var gulp = require('gulp');

/**
 * Перенос только используемых файлов либ в папку со сборкой
 */
gulp.task('plugins:common', function (cb) {
    var pluginsPath = {
        'ckeditor': [
            path.src.plugin + 'ckeditor/**/*',
        ],
    };
    for (var pluginName in pluginsPath) {
        var files = pluginsPath[pluginName];
        gulp.src(files)
            .pipe(plugins.plumber())
            .pipe(gulp.dest(path.build + 'plugins/' + pluginName));
    }
    cb();
});
