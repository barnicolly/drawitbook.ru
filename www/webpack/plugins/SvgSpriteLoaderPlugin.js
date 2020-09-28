const SpriteLoaderPlugin = require('svg-sprite-loader/plugin');

module.exports = function createPlugin(options) {
    return new SpriteLoaderPlugin({
        plainSprite: true,
    });
};



