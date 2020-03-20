global.isProduction = () => process.env.NODE_ENV === 'production';

const path = require("path");

const paths = {
    src: {
        self: path.join(__dirname, '../resources/static/'),
        js: path.join(__dirname, '../resources/static/js/'),
        css: path.join(__dirname, '../resources/static/css/'),
    },
    public: path.join(__dirname, '../public/'),
    dist: path.join(__dirname, '../public/build/'),
};

const helper = require('./utilites/parts');
module.exports = {
    externals: {
        paths: paths,
    },
    entry: {
        'app': [
            `${paths.src.self}entries/app.js`,
        ],
    },
    optimization: helper.parts.optimization(isProduction),
    output: {
        path: paths.dist,
    },
    plugins: [
        helper.plugins.CleanWebpackPlugin(),
        helper.plugins.HashedModuleIdsPlugin(),
        helper.plugins.ManifestPlugin(),
        helper.plugins.SpriteLoaderPlugin(),
    ],
    module: {
        rules: [
            {
                test: /\.svg$/,
                use: [
                    helper.loaders.SvgSpriteLoader(isProduction()),
                    helper.loaders.SvgoLoader(isProduction()),
                ]
            },
        ]
    },
};
