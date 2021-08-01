const {merge} = require('webpack-merge');
const baseWebpackConfig = require('./base.conf');
const buildWebpackConfig = require('@misharatnikov/webpack/src/dev.conf');

module.exports = merge(buildWebpackConfig, baseWebpackConfig);
