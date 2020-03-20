const CompressionPlugin = require('compression-webpack-plugin');

// https://webpack.js.org/plugins/compression-webpack-plugin/
module.exports = function createPlugin(options) {
    return new CompressionPlugin(options);
};