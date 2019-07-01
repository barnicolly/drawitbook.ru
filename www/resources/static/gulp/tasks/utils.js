
gulp.task('scripts:compile-bootstrap', function () {
    var files = [
        path.src.plugin + 'bootstrap/js/dist/main.js',
    ];
    return gulp.src(files)
        .pipe(plugins.plumber())
        .pipe(plugins.cached('scripts:compile-bootstrap'))
        .pipe(plugins.purgeSourcemaps())
        .pipe(plugins.rigger())
        .pipe(plugins.uglify())
        .pipe(plugins.remember('scripts:compile-bootstrap'))
        .pipe(plugins.concat('bootstrap.min.js'))
        .pipe(gulp.dest(path.src.plugin + 'bootstrap/compiled/js'));
});

gulp.task('styles:bootstrap4.minimized', function () {
    return gulp.src(path.src.plugin + 'bootstrap/scss/bootstrap-minimized.scss')
        .pipe(plugins.sass({outputStyle: 'compressed'}))
        .pipe(gulp.dest(path.src.plugin + 'bootstrap/compiled/css'));
});

gulp.task('styles:bootstrap4.extended', function () {
    return gulp.src(path.src.plugin + 'bootstrap/scss/bootstrap-extended.scss')
        .pipe(plugins.sass({outputStyle: 'compressed'}))
        .pipe(gulp.dest(path.src.plugin + 'bootstrap/compiled/css'));
});
//
// gulp.task('img:create_arts_thumb', function () {
//     return gulp.src(path.src.arts + '**/*')
//         /*.pipe(plugins.imageResize({
//             width : 75,
//             height : 100,
//             crop : true,
//             upscale : false,
//             imageMagick: true,
//         }))*/
//        /* .pipe(plugins.rename({
//             suffix: '_thumb'
//         }))*/
//         .pipe(gulp.dest(path.build + 'thumbnails/arts'));
//
//
// });

gulp.task('img:compress_thumb', function () {
    return gulp.src(path.public + 'thumbnails/arts/**/*')
        .pipe(plugins.image({
            jpegRecompress: ['--quality', 'low', '--min', 20, '--max', 30],
            optipng: ['-i 1', '-strip all', '-fix', '-o7', '-force'],
            gifsicle: false,
            concurrent: 4,
        }))
        .pipe(gulp.dest(path.public + 'thumbnails/min', {overwrite: false}))
});

gulp.task('img:create_arts_thumb', function () {
    return gulp.src(path.src.arts + '/**/*', { nodir: true })
        /*.pipe(plugins.image({
            jpegRecompress: ['--quality', 'low', '--min', 30, '--max', 50],
            optipng: ['-i 1', '-strip all', '-fix', '-o7', '-force'],
            gifsicle: false,
            concurrent: 2,
        }))*/
        .pipe(plugins.imageResize({
                    width : 100,
                    height : 75,
                    crop : true,
                    upscale : false,
                    imageMagick: true,
                }))
        .pipe(plugins.rename({
                    suffix: '_thumb'
                }))
        .pipe(gulp.dest(path.public + 'thumbnails/arts', {overwrite: false}))
});