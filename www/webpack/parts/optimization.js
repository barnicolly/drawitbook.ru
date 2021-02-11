const OptimizeCssAssetsPlugin = require('optimize-css-assets-webpack-plugin');
const TerserPlugin = require('terser-webpack-plugin');

const checkPrimaryVendor = (vendorIdentity, js = 'js') => {
    const vendorModules = [
        'jquery',
        'animate.css',
        'normalize.css',
        'lodash',
        'font-awesome',
    ];
    const path = require('path');
    let findVendorModule = false;
    vendorModules.forEach(vendorName => {
        if (vendorIdentity.includes(`${path.sep + vendorName + path.sep}`)) {
            findVendorModule = true;
            return;
        }
    });
    return findVendorModule;
};

module.exports = function (isProduction) {
    let config = {
        runtimeChunk: 'single',
        splitChunks: {
            cacheGroups: {
                polyfills: {
                    name: 'polyfills',
                    test(module, chunks) {
                        const path = require('path');
                        return module.resource &&
                            (module.resource.includes(`${path.sep}core-js${path.sep}`) || module.resource.includes(`_polyfills`));
                    },
                    chunks: 'all',
                    priority: 1,
                    enforce: true,
                },
                'translations.js': {
                    name: 'translations',
                    test(module, chunks) {
                        const path = require('path');
                        return module.resource &&
                            (module.resource.includes(`js${path.sep}translations`));
                    },
                    chunks: 'all',
                    priority: 1,
                    enforce: true,
                },
                'vendors.js': {
                    name: 'vendors',
                    test: (module) => module.resource ? checkPrimaryVendor(module.resource): false,
                    chunks: 'all',
                    priority: 1,
                    enforce: true,
                },
                'vendors.css': {
                    name: 'vendors',
                    test: (module) => module.constructor.name === 'CssModule' ? checkPrimaryVendor(module.identifier(), 'test'): false,
                    chunks: 'all',
                    priority: 1,
                    enforce: true,
                },
            },
        },
    };
    if (isProduction) {
        config.minimizer = [
            new TerserPlugin({
                sourceMap: true,
                parallel: true,
                exclude: /\.min/,
            }),
            new OptimizeCssAssetsPlugin({
                cssProcessorOptions: {
                    discardComments: {
                        removeAll: true,
                    },
                },
                canPrint: true,
            }),
        ];
    }
    return config;
};
