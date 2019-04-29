/**
 * Поиск тасков
 * @type {Gulp}
 */
require('./tasks/base');

/**
 * Основные таски
 */
gulp.task('base', gulp.parallel('scripts:base', 'styles:base', 'fonts:cp'));
gulp.task('admin', gulp.parallel('scripts:admin-base', 'styles:admin-base'));

gulp.task('build', gulp.series('clean', gulp.parallel('base', 'admin', 'scripts:admin-common'), 'createIndex'));

gulp.task('default', gulp.series('build'));
