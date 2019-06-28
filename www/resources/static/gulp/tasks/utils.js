
gulp.task('scripts:compile-bootstrap', function () {
    var files = [
        // path.src.plugin + 'bootstrap/js/dist/button.js',
        // path.src.plugin + 'bootstrap/js/dist/collapse.js',
        // path.src.plugin + 'bootstrap/js/dist/modal.js',
        // path.src.plugin + 'bootstrap/js/dist/dropdown.js',
        // path.src.plugin + 'bootstrap/js/dist/util.js',
        path.src.plugin + 'bootstrap/js/dist/*.js',
    ];
    return gulp.src(files)
        .pipe(plugins.plumber())
        .pipe(plugins.cached('scripts:compile-bootstrap'))
        .pipe(plugins.purgeSourcemaps())
        .pipe(plugins.babel())
        .pipe(plugins.uglify())
        .pipe(plugins.remember('scripts:compile-bootstrap'))
        .pipe(plugins.concat('bootstrap.min.js'))
        .pipe(gulp.dest(path.src.plugin + 'bootstrap/compiled'));
});

gulp.task('styles:bootstrap4', function () {
    return gulp.src(path.src.plugin + 'bootstrap/scss/bootstrap-minimized.scss')
        .pipe(plugins.sass({outputStyle: 'compressed'}))
        // .pipe(plugins.sass())
        // .pipe(sass.sync().on('error', sass.logError))
        .pipe(gulp.dest(path.src.plugin + 'bootstrap/compiled'));
});