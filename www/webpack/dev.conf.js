const {merge} = require('webpack-merge');
const baseWebpackConfig = require('./base.conf');
const buildWebpackConfig = require('@misharatnikov/webpack/src/dev.conf');

const domain = 'http://172.17.0.1';
const port = process.env.WEBPACK_DEVSERVER_IN_PORT;
const devWebpackConfig = merge(buildWebpackConfig, baseWebpackConfig, {
    output: {
        publicPath: `${domain}:${port}/build/`,
    },
});

module.exports = devWebpackConfig;
