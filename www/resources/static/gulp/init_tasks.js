/**
 * Поиск тасков
 * @type {Gulp}
 */
require('./tasks/base');

/**
 * Основные таски
 */
gulp.task('base', gulp.parallel('scripts:base', 'styles:base', 'fonts:cp'));

gulp.task('build', gulp.series('clean', gulp.parallel('base'), 'createIndex'));

gulp.task('default', gulp.series('build'));
