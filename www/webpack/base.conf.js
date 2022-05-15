const helper = require('@misharatnikov/webpack/src/utilites/parts');
const isProduction = process.env.NODE_ENV === 'production';
const {merge} = require('webpack-merge');
const path = require('path');
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
const vendorModules = [
    'jquery',
    'font-awesome',
    'animate.css',
    'lodash',
    'translation',
];
let optimization = helper.parts.optimization.chunks(vendorModules);
if (isProduction) {
    optimization = merge(optimization, helper.parts.optimization.minimization());
}
const webpackConfig = {
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
    optimization,
    output: {
        path: paths.dist,
    },
    plugins: [
        helper.plugins.ProvidePlugin({
            $: 'jquery',
            jQuery: 'jquery',
            'window.jQuery': 'jquery',
            'window.$': 'jquery',
            'window.Lang': `${paths.src.plugins}translation/index.js`,
        }),
    ],
}

const webpackImageConfig = {
    plugins: [
        helper.plugins.CopyPlugin({
            patterns: [
                {
                    from: `${paths.src.img}**/*`,
                    to: `${paths.dist}img`,
                    force: true,
                    context: `${paths.src.img}`,
                },
            ],
        }),
        helper.plugins.SvgSpriteLoaderPlugin()
    ],
    module: {
        rules: [
            {
                test: /\.svg$/,
                include: [
                    path.join(paths.src.img, '/icons')
                ],
                use: [
                    helper.loaders.SvgSpriteLoader(isProduction, {
                        outputPath: 'icons/'
                    }),
                    helper.loaders.SvgoLoader(isProduction),
                ]
            },
            {
                test: /\.(png|gif|jpg|svg)$/,
                exclude: [
                    path.join(paths.src.img, '/icons')
                ],
                use: [
                    helper.loaders.FileLoader(isProduction, {
                        name: 'img/[name].[ext]',
                    }),
                ],
            },
        ],
    },
};

module.exports = merge(webpackConfig, webpackImageConfig);
