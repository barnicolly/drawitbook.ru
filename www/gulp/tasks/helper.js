const path = require('path');
const folderPath = {
    build: path.join(__dirname, '../../public/build'),
    plugin: path.join(__dirname, '../../resources/plugins'),
    node_modules: path.join(__dirname, '../../node_modules'),
};

/**
 * создает в каждой поддиректории build index.html
 * */
gulp.task('createIndex', plugins.recursiveFolder({
    base: folderPath.build,
}, function (folderFound) {
    const targetPath = path.join(folderPath.build, folderFound.pathTarget);
    return gulp.src('gulp/files/index.html')
        .pipe(plugins.plumber())
        .pipe(gulp.dest(targetPath));
}));

gulp.task('styles:fa.purge', function () {
    const targetPath = path.join(folderPath.plugin, 'font-awesome/dist/');
    return gulp.src(folderPath.plugin + '/font-awesome/css/font-awesome.min.css')
        .pipe(plugins.purgecss({
            content: [
                'app/Http/Modules/Open/**/*.php',
                'resources/views/**/*.php',
                path.join(folderPath.node_modules, 'jssocials/dist/jssocials.js'),
            ]
        }))
        .pipe(plugins.rename('fa-purged.min.css'))
        .pipe(gulp.dest(targetPath));
});
