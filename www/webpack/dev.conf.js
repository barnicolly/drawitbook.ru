const {merge} = require('webpack-merge');
const baseWebpackConfig = require('./base.conf');
const buildWebpackConfig = require('@misharatnikov/webpack/src/dev.conf');

const devWebpackConfig = merge(buildWebpackConfig, baseWebpackConfig, {
    output: {
        publicPath: `/build/`,
    },
    devServer: {
        port: 3000,
        sockPort: 'location',
    }
});

module.exports = devWebpackConfig;
