/**
 * Поиск тасков
 * @type {Gulp}
 */
require('./tasks/base');
require('./tasks/plugin');
require('./tasks/utils');
require('./tasks/compress');

/**
 * Основные таски
 */
gulp.task('base', gulp.parallel('scripts:base', 'styles:base', 'fonts:cp', 'scripts:load_ads', 'scripts:base.copy'));
gulp.task('after_load', gulp.parallel('scripts:after_load', 'styles:after_load'));

gulp.task('admin', gulp.parallel('scripts:admin-base', 'styles:admin-base', 'scripts:admin-common'));
gulp.task('bootstrap4', gulp.parallel('styles:bootstrap4.minimized', 'styles:bootstrap4.extended'));


gulp.task('build', gulp.series('clean', gulp.parallel('base', 'plugins:common', 'admin', 'after_load'), 'createIndex', 'gzip:static', 'br:static'));

gulp.task('default', gulp.series('build'));
