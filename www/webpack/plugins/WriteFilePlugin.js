const WriteFilePlugin = require('write-file-webpack-plugin');

//https://github.com/gajus/write-file-webpack-plugin
module.exports = function createPlugin(options) {
    return new WriteFilePlugin(options);
};



