var path = {
    //обработанные файлы
    build: 'public/build/',
    //исходники
    src: {
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
        minify: false,
        /**
         * Генерация карты кода для отладки кода, который изменен в процессе
         */
        sourcemaps: true
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