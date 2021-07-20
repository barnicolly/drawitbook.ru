const merge = require('webpack-merge');
const helper = require('./utilites/parts');
const baseWebpackConfig = require('./base.conf');

const {staticInPort: inPort} = baseWebpackConfig.externals.settings;
const domain = 'http://127.0.0.1';
const  devWebpackConfig = merge(baseWebpackConfig, {
    mode: 'development',
    output: {
        filename: '[name].js',
        chunkFilename: '[name].js',
        publicPath: `${domain}:${inPort}/build/`,
    },
    devServer: {
        hot: true,
        compress: true,
        inline: true,
        overlay: true,
        quiet: false,
        port: inPort,
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
            moduleFilename: (chunk) => {
                let name = chunk.name.replace('js/', 'css/');
                return `${name}.css`;
            },
            filename: 'css/[id].css',
        }),
        helper.plugins.WriteFilePlugin({
            test: /(img|icons)\//,
        }),
    ],
    module: {
        rules: [
            {
                test: /\.scss$/,
                use: [
                    helper.loaders.MiniCssExtractPluginLoader(isProduction()),
                    helper.loaders.CacheLoader(isProduction()),
                    helper.loaders.CssLoader(isProduction()),
                    helper.loaders.PostcssLoader(isProduction()),
                    helper.loaders.SassLoader(isProduction()),
                ],
            },
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
