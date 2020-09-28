var ManifestPlugin = require('webpack-manifest-plugin');

//https://www.npmjs.com/package/webpack-manifest-plugin
module.exports = function createPlugin(options) {
    let excludePatterns = [
        '\.*.gz$',
        '\.*.br$',
        'fonts/',
        'img/',
    ];
    return new ManifestPlugin({
        writeToFileEmit: true,
        filter: (FileDescriptor) => {
            let matchPatters = excludePatterns.filter(pattern => {
                let regexp = new RegExp(pattern);
                return FileDescriptor.name.match(regexp)
            });
            return !matchPatters.length;
        }
    });
};