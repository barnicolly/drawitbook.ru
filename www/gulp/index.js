global.helper = require('../gulp/helper');
global.plugins = require('gulp-load-plugins')({
    camelize: true,
    lazy: true
});
global.gulp = require('gulp');

//подключение тасков
require('./init_tasks');




