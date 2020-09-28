const webpack = require('webpack');

//https://webpack.js.org/plugins/provide-plugin/
module.exports = function createPlugin(options) {
    return new webpack.ProvidePlugin(options);
};



