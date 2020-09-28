const merge = require('webpack-merge');
const helper = require('./utilites/parts');
const baseWebpackConfig = require('./base.conf');
const BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin;

const {domain} = baseWebpackConfig.externals.settings;
const buildWebpackConfig = merge(baseWebpackConfig, {
    mode: 'production',
    output: {
        filename: 'js/[name].[contenthash].js',
        publicPath: `${domain}/build/`,
    },
    devtool: 'source-map',
    plugins: [
        helper.plugins.CleanWebpackPlugin(),
        helper.plugins.MiniCssExtractPlugin({
            filename: 'css/[name].[contenthash].css',
            moduleFilename: (chunk) => `css/${chunk.name}.[contenthash].css`,
        }),
        helper.plugins.CompressionPlugin({
            filename: '[path].gz[query]',
            algorithm: 'gzip',
            test: /\.js$|\.css$/,
        }),
        helper.plugins.CompressionPlugin({
            filename: '[path].br[query]',
            algorithm: 'brotliCompress',
            test: /\.(js|css)$/,
            compressionOptions: {level: 11},
        }),
        // new BundleAnalyzerPlugin(),
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
