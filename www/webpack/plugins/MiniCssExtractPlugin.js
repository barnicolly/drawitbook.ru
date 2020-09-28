const MiniCssExtractPlugin = require('mini-css-extract-plugin');

//https://webpack.js.org/plugins/mini-css-extract-plugin/
module.exports = function createPlugin(options) {
    return new MiniCssExtractPlugin(options);
};



