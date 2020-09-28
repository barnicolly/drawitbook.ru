const CopyPlugin = require('copy-webpack-plugin');

//https://webpack.js.org/plugins/copy-webpack-plugin/
module.exports = function createPlugin(options) {
    return new CopyPlugin(options);
};



