global.helper = require('./helper');
global.plugins = require('gulp-load-plugins')({
    camelize: true,
    lazy: true
});
global.gulp = require('gulp');

var config = require('./config');
/**
 * Получаем параметры переданные в командной строке для определения окружения
 */
var argv = helper.getCommandLineArgs();
global.environment = argv.env || 'development';
global.env = config.env[environment];

config.path.build = config.path.build + '/';
global.path = config.path;

//подключение тасков
require('./init_tasks');




