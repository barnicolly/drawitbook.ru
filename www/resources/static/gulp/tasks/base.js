var base = {
    js: {
        append: [
            path.src.plugin + 'jquery/jquery-3.1.1.min.js',
            path.src.plugin + 'bootstrap/js/bootstrap.min.js',
        ],
        minify: [
            path.src.self + 'files/dummy.js',
        ]
    },
    css: {
        append: [
            path.src.plugin + 'bootstrap/css/bootstrap.min.css',
        ],
        minify: [
            path.src.self + 'css/content/*.css',
        ]
    }
};

var admin = {
    js: {
        append: [
            path.src.plugin + 'jquery/jquery-3.1.1.min.js',
            path.src.plugin + 'bootstrap/js/bootstrap.min.js',
            path.src.plugin + 'fancybox/jquery.fancybox.min.js',
            path.src.plugin + 'clipboard/clipboard.js',
        ],
        minify: [
            path.src.self + 'js/main.js',
        ]
    },
    css: {
        append: [
            path.src.plugin + 'bootstrap/css/bootstrap.min.css',
            path.src.plugin + 'font-awesome-4.7.0/css/font-awesome.min.css',
            path.src.plugin + 'fancybox/jquery.fancybox.min.css',
        ],
        minify: [
            path.src.self + 'css/*.css',
        ]
    }
};

gulp.task('styles:base', function () {
    var stream;
    if (typeof base.css.minify !== 'undefined' && Object.keys(base.css.minify).length) {
        if (environment === 'development') {
            initWatcher(base.css.minify, 'styles:base')
        }
        stream = prepareCssStream('styles:base', base.css);
    } else {
        stream = gulp.src(base.css.append);
    }
    return stream
        .pipe(plugins.concat('master.min.css'))
        .pipe(gulp.dest(path.build + 'css/'));
});

gulp.task('scripts:base', function () {
    var stream;
    if (typeof base.js.minify !== 'undefined' && Object.keys(base.js.minify).length) {
        if (environment === 'development') {
            initWatcher(base.js.minify, 'scripts:base')
        }
        stream = prepareJsStream('scripts:base', base.js);
    } else {
        stream = gulp.src(base.js.append);
    }
    return stream
        .pipe(plugins.plumber())
        .pipe(plugins.concat('master.min.js'))
        .pipe(gulp.dest(path.build + 'js/'));
});

function prepareJsStream(name, files) {
    return gulp.src(files.minify)
        .pipe(plugins.plumber())
        .pipe(plugins.cached(name))
        .pipe(plugins.babel())
        .pipe(plugins.if(env.minify, plugins.uglify()))
        .pipe(plugins.remember(name))
        .pipe(plugins.addSrc.prepend(files.append));
}

function prepareCssStream(name, files) {
    return gulp.src(files.minify)
        .pipe(plugins.plumber())
        .pipe(plugins.cached(name))
        .pipe(plugins.if(env.minify, plugins.cleanCss()))
        .pipe(plugins.autoprefixer())
        .pipe(plugins.remember(name))
        .pipe(plugins.if(
            files.append !== 'undefined' && Object.keys(files.append).length,
            plugins.addSrc.prepend(files.append))
        );
}

gulp.task('fonts:cp', function () {
    return gulp.src(
        [
            path.src.plugin + 'bootstrap/fonts/*',
            path.src.plugin + 'font-awesome-4.7.0/fonts/*',
        ])
        .pipe(plugins.plumber())
        .pipe(gulp.dest(path.build + 'fonts'))
});

/*gulp.task('scripts:load_ads', function () {
    var files = {
        minify: [
            path.src.self + 'js/ads.js',
        ],
        append: [
            path.src.self + 'files/dummy.js',
        ],
    };
    if (environment === 'development') {
        initWatcher(files.minify, 'scripts:load_ads')
    }
    var stream = prepareJsStream('scripts:load_ads', files);
    return stream
        .pipe(plugins.concat('loader.min.js'))
        .pipe(gulp.dest(path.build + 'js/'));
});*/

/**
 * Вспомогательные таски
 */

gulp.task('clean', function () {
    var del = require('del');
    return del(path.build)
});

/**
 * создает в каждой поддиректории build index.html
 * */
gulp.task('createIndex', plugins.recursiveFolder({
    base: path.build,
}, function (folderFound) {
    return gulp.src(path.src.files + "index.html")
        .pipe(plugins.plumber())
        .pipe(gulp.dest(path.build + folderFound.pathTarget));
}));

var watches = [];

function initWatcher(files, taskName) {
    if (watches.indexOf(taskName) === -1) {
        watches.push(taskName);
        var watcher = gulp.watch(files, gulp.series(taskName));
        watcher.on('change', function (event) {
            if (event.type === 'deleted') {
                delete cache.caches['scripts'][event.path];
                plugins.remember.forget('scripts', event.path);
            }
        });
    }
}
