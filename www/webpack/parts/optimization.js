const OptimizeCssAssetsPlugin = require('optimize-css-assets-webpack-plugin');
const TerserPlugin = require('terser-webpack-plugin');
const UglifyJsPlugin = require('uglifyjs-webpack-plugin');

module.exports = function (isProduction) {
    let config = {
        splitChunks: {
            cacheGroups: {
                polyfills: {
                    name: 'polyfills',
                    test(module, chunks) {
                        // `module.resource` contains the absolute path of the file on disk.
                        // Note the usage of `path.sep` instead of / or \, for cross-platform compatibility.
                        const path = require('path');
                        return module.resource &&
                            // module.resource.endsWith('.svg') &&
                            (module.resource.includes(`${path.sep}core-js${path.sep}`) || module.resource.includes(`${path.sep}polyfil.js`));
                    },
                    chunks: 'all',
                    priority: 1,
                }
            }
        }
    };
    if (isProduction) {
        // config.minimize = false;
        config.minimizer = [
            new UglifyJsPlugin({
                parallel: true,
                exclude: /\.min/,
                extractComments: false,
                uglifyOptions: {
                    output: {
                        comments: false,
                    },
                }
            }),
            /*   new TerserPlugin({
                   exclude: /\.min/,
                   parallel: true,
                   terserOptions: {
                       ecma: 6,
                   },
               }),*/
            new OptimizeCssAssetsPlugin({
                cssProcessorOptions: {
                    assetNameRegExp: /\.css$/g,
                    preset: ['default', {discardComments: {removeAll: true}}],
                },
                canPrint: true,
            }),
        ];
    }
    return config;
};
