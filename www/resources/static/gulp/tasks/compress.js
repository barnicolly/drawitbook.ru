gulp.task('gzip:static', function () {
    return gulp.src([path.build + '**/*.js', path.build + '**/*.css'])
        .pipe(plugins.gzip({gzipOptions: {level: 9}, append: true}))
        .pipe(plugins.plumber())
        .pipe(gulp.dest(path.build));
});

gulp.task('br:static', function (cb) {
    var brotli = require('brotli');
    var fs = require('fs');

    helper.searchFilesInDir(path.build + 'js', /\.js$/, function (filename) {

        try {
            var buffer = brotli.compress(fs.readFileSync(filename));
            fs.writeFileSync(filename + '.br', new Buffer(buffer));
        } catch (e) {
            console.log(filename + ' мал для сжатия ');
        }
    });
    helper.searchFilesInDir(path.build + 'css', /\.css$/, function (filename) {
        try {
            var buffer = brotli.compress(fs.readFileSync(filename));
            fs.writeFileSync(filename + '.br', new Buffer(buffer));
        } catch (e) {
            console.log(filename + ' мал для сжатия ');
        }
    });

    cb();
});