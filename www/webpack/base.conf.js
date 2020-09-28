global.isProduction = () => process.env.NODE_ENV === 'production';
const path = require('path');

const paths = {
    src: {
        self: path.join(__dirname, '../resources/'),
        js: path.join(__dirname, '../resources/js/'),
        css: path.join(__dirname, '../resources/css/'),
        scss: path.join(__dirname, '../resources/scss/'),
        img: path.join(__dirname, '../resources/img/'),
        plugins: path.join(__dirname, '../resources/plugins/'),
    },
    public: path.join(__dirname, '../public/'),
    dist: path.join(__dirname, '../public/build/'),
};

const helper = require('./utilites/parts');
const settings = require('./settings.json');
if (process.env.PROJECT_DOMAIN) {
    settings.domain = process.env.PROJECT_DOMAIN;
}
module.exports = {
    externals: {
        paths: paths,
        settings: settings,
    },
    resolve: {
        alias: {
            'jquery': 'jquery/dist/jquery.min.js',
            '@js': paths.src.js,
            '@css': paths.src.css,
            '@img': paths.src.img,
            '@scss': paths.src.scss,
            '@plugins': paths.src.plugins,
        },
    },
    entry: {
        'app': `${paths.src.self}entries/app.js`,
        'landing': `${paths.src.self}entries/landing.js`,
        'ranking': `${paths.src.self}entries/ranking.js`,
        'webinar': `${paths.src.self}entries/webinar.js`,
    },
    optimization: helper.parts.optimization(isProduction),
    output: {
        path: paths.dist,
    },
    plugins: [
        helper.plugins.HashedModuleIdsPlugin(),
        helper.plugins.CopyPlugin([
            {from: `${paths.src.img}**/*`, to: `${paths.dist}img`, context: `${paths.src.img}`},
        ]),
        helper.plugins.ProvidePlugin({
            $: 'jquery',
            jQuery: 'jquery',
            'window.jQuery': 'jquery',
            'window.$': 'jquery',
        }),
        helper.plugins.ManifestPlugin(),
        helper.plugins.SpriteLoaderPlugin(),
    ],
    module: {
        rules: [
            {
                test: /\.scss$/,
                use: [
                    helper.loaders.MiniCssExtractPluginLoader(isProduction()),
                    helper.loaders.CssLoader(isProduction()),
                    helper.loaders.PostcssLoader(isProduction()),
                    helper.loaders.SassLoader(isProduction()),
                ],
            },
            {
                test: /\.(ttf|eot|woff|woff2)$/,
                use: [
                    helper.loaders.FileLoader(isProduction(), {
                        name: 'fonts/[name].[ext]',
                    }),
                ],
            },
            {
                test: /\.svg$/,
                include: [
                    paths.src.img
                ],
                use: [
                    helper.loaders.SvgSpriteLoader(isProduction(), {
                        outputPath: 'icons/'
                    }),
                    helper.loaders.SvgoLoader(isProduction()),
                ]
            },
            {
                test: /\.(png|svg)$/,
                exclude: [
                    paths.src.img
                ],
                use: [
                    helper.loaders.FileLoader(isProduction(), {
                        name: 'img/[name].[ext]',
                    }),
                ],
            },
        ],
    },
};
