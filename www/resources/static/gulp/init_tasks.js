/**
 * Поиск тасков
 * @type {Gulp}
 */
require('./tasks/base');
require('./tasks/plugin');
require('./tasks/utils');

/**
 * Основные таски
 */
gulp.task('base', gulp.parallel('scripts:base', 'styles:base', 'fonts:cp', 'scripts:load_ads'));
gulp.task('admin', gulp.parallel('scripts:admin-base', 'styles:admin-base', 'scripts:admin-common'));
gulp.task('bootstrap4', gulp.parallel('styles:bootstrap4.minimized', 'styles:bootstrap4.extended'));

gulp.task('build', gulp.series('clean', gulp.parallel('base', 'plugins:common', 'admin'), 'createIndex'));

gulp.task('default', gulp.series('build'));
