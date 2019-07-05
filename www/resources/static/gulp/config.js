var path = {
    //обработанные файлы
    build: 'public/build/',
    public: 'public/',
    //исходники
    src: {
        arts: 'resources/static/arts/',
        self: 'resources/static/',
        plugin: 'resources/static/plugins/',
        files: 'resources/static/files/',
    },
};

/**
 * В зависимости от окружения выполняются те или иные действия
 * @type {{development: {concat: boolean, lint: boolean, minify: boolean, sourcemaps: boolean}, production: {concat: boolean, lint: boolean, minify: boolean, sourcemaps: boolean}}}
 */
var env = {
    development: {
        minify: true,
        /**
         * Генерация карты кода для отладки кода, который изменен в процессе
         */
        sourcemaps: false
    },
    production: {
        minify: true,
        sourcemaps: false
    }
};

module.exports = {
    path: path,
    env: env,
};