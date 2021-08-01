const {merge} = require('webpack-merge');
const baseWebpackConfig = require('./base.conf');
const buildWebpackConfig = require('@misharatnikov/webpack/src/build.conf');

module.exports = merge(buildWebpackConfig, baseWebpackConfig);
