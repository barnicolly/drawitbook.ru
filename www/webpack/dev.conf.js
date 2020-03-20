const merge = require('webpack-merge');
const helper = require('./utilites/parts');
const baseWebpackConfig = require('./base.conf');

let domain = 'http://test1';
const  devWebpackConfig = merge(baseWebpackConfig, {
    mode: 'development',
    output: {
        filename: "[name].js",
        publicPath: `${domain}:8080/build/`,
    },
    devServer: {
        hot: true,
        compress: true,
        inline: true,
        overlay: true,
        quiet: false,
        host: '0.0.0.0',
        proxy: {
            '**': {
                target: `${domain}`,
                changeOrigin: true,
            },
        },
        disableHostCheck: true,
        headers: {
            'Access-Control-Allow-Origin': '*',
        },
    },
    devtool: 'eval-sourcemap',
    plugins: [
        helper.plugins.MiniCssExtractPlugin({
            filename: '[name].css',
        }),
    ],

    module: {
        rules: [
            {
                test: /\.css$/,
                use: [
                    helper.loaders.MiniCssExtractPluginLoader(isProduction()),
                    helper.loaders.CacheLoader(isProduction()),
                    helper.loaders.CssLoader(isProduction()),
                    helper.loaders.PostcssLoader(isProduction()),
                ]
            },
            {
                test: /\.scss$/,
                use: [
                    helper.loaders.MiniCssExtractPluginLoader(isProduction()),
                    helper.loaders.CacheLoader(isProduction()),
                    helper.loaders.CssLoader(isProduction()),
                    helper.loaders.PostcssLoader(isProduction()),
                    helper.loaders.SassLoader(isProduction()),
                ]
            },
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: [
                    helper.loaders.CacheLoader(isProduction()),
                    helper.loaders.BabelLoader(isProduction()),
                ],
            },
        ]
    },
});

module.exports = new Promise((resolve, reject) => {
    resolve(devWebpackConfig);
});
