global.isProduction = () => process.env.NODE_ENV === 'production';
const path = require('path');
const fs = require('fs');
const paths = {
    src: {
        self: path.join(__dirname, '../resources/static/'),
        js: path.join(__dirname, '../resources/static/js/'),
        css: path.join(__dirname, '../resources/static/css/'),
        scss: path.join(__dirname, '../resources/static/scss/'),
        img: path.join(__dirname, '../resources/static/img/'),
        plugins: path.join(__dirname, '../resources/static/plugins/'),
    },
    public: path.join(__dirname, '../public/'),
    dist: path.join(__dirname, '../public/build/'),
};

const helper = require('./utilites/parts');
let settings = {}
const settingsFilePath = __dirname + '/settings.json';
if (fs.existsSync(settingsFilePath)) {
    settings = require(settingsFilePath);
}
if (process.env.WEBPACK_DEVSERVER_IN_PORT) {
    settings.staticInPort = process.env.WEBPACK_DEVSERVER_IN_PORT;
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
        'app': `${paths.src.self}entries/app/index.js`,
        'admin': `${paths.src.self}entries/admin/index.js`,
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
                    paths.src.img,
                ],
                use: [
                    helper.loaders.SvgSpriteLoader(isProduction(), {
                        outputPath: 'icons/',
                    }),
                    helper.loaders.SvgoLoader(isProduction()),
                ],
            },
            {
                test: /\.(png|svg)$/,
                exclude: [
                    paths.src.img,
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
