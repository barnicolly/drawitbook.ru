const { CleanWebpackPlugin } = require('clean-webpack-plugin');

module.exports = function createPlugin(options) {
    return new CleanWebpackPlugin();
};


