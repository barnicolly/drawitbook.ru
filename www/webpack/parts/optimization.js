const OptimizeCssAssetsPlugin = require('optimize-css-assets-webpack-plugin');
const TerserPlugin = require('terser-webpack-plugin');

const checkPrimaryVendor = (vendorIdentity) => {
    const vendorModules = [
        'jquery',
        'bootstrap',
        'animate.css',
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
                            (module.resource.includes(`${path.sep}core-js${path.sep}`));
                    },
                    chunks: 'all',
                    priority: 1,
                },
                'vendors.js': {
                    name: 'vendors',
                    test: (module) => module.resource ? checkPrimaryVendor(module.resource): false,
                    chunks: 'all',
                    priority: 1,
                },
                'vendors.css': {
                    name: 'vendors',
                    test: (module) => module.constructor.name === 'CssModule' ? checkPrimaryVendor(module.identifier()): false,
                    chunks: 'all',
                    priority: 1,
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
