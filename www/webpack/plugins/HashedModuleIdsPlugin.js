const webpack = require('webpack');

module.exports = function createPlugin(options) {
    return new webpack.HashedModuleIdsPlugin({
        hashFunction: 'md4',
        hashDigest: 'base64',
        hashDigestLength: 8
    });
};



