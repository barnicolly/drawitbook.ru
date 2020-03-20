const merge = require('webpack-merge');
const helper = require('./utilites/parts');
const baseWebpackConfig = require('./base.conf');

const buildWebpackConfig = merge(baseWebpackConfig, {
    mode: 'production',
    output: {
        filename: '[name].[chunkhash].js',
        publicPath: '/build/',
    },
    plugins: [
        helper.plugins.MiniCssExtractPlugin({
            filename: '[name].[chunkhash].css',
        }),
        helper.plugins.CompressionPlugin({
            filename: '[path].gz[query]',
            algorithm: 'gzip',
            test: /\.js$|\.css$/,
        }),
        helper.plugins.CompressionPlugin({
            filename: '[path].br[query]',
            algorithm: 'brotliCompress',
            test: /\.(js|css|svg)$/,
            compressionOptions: {level: 11},
        }),
    ],
    module: {
        rules: [
            {
                test: /\.css$/,
                use: [
                    helper.loaders.MiniCssExtractPluginLoader(isProduction()),
                    helper.loaders.CssLoader(isProduction()),
                    helper.loaders.PostcssLoader(isProduction()),
                ]
            },
            {
                test: /\.scss$/,
                use: [
                    helper.loaders.MiniCssExtractPluginLoader(isProduction()),
                    helper.loaders.CssLoader(isProduction()),
                    helper.loaders.PostcssLoader(isProduction()),
                    helper.loaders.SassLoader(isProduction()),
                ]
            },
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: [
                    helper.loaders.ThreadLoader(isProduction()),
                    helper.loaders.BabelLoader(isProduction()),
                ],
            },
        ]
    },
});

module.exports = new Promise((resolve, reject) => {
    resolve(buildWebpackConfig);
});
