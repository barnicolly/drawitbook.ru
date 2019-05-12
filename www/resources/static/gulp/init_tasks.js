/**
 * Поиск тасков
 * @type {Gulp}
 */
require('./tasks/base');
require('./tasks/plugin');

/**
 * Основные таски
 */
gulp.task('base', gulp.parallel('scripts:base', 'styles:base', 'fonts:cp'));
gulp.task('admin', gulp.parallel('scripts:admin-base', 'styles:admin-base', 'scripts:admin-common'));

gulp.task('build', gulp.series('clean', gulp.parallel('base', 'plugins:common', 'admin'), 'createIndex'));

gulp.task('default', gulp.series('build'));
