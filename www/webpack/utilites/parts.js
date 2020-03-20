const BabelLoader = require('../loaders/babel-loader');
const CssLoader = require('../loaders/css-loader');
const MiniCssExtractPluginLoader = require('../loaders/mini-css-extract-plugin-loader');
const SvgSpriteLoader = require('../loaders/svg-sprite-loader');
const SvgoLoader = require('../loaders/svgo-loader');
const PostcssLoader = require('../loaders/postcss-loader');
const SassLoader = require('../loaders/sass-loader');
const CacheLoader = require('../loaders/cache-loader');
const ThreadLoader = require('../loaders/thread-loader');
const loaders = {
    BabelLoader: (isProduction) => new BabelLoader(isProduction).get(),
    CssLoader: (isProduction) => new CssLoader(isProduction).get(),
    MiniCssExtractPluginLoader: (isProduction) => new MiniCssExtractPluginLoader(isProduction).get(),
    SvgSpriteLoader: (isProduction) => new SvgSpriteLoader(isProduction).get(),
    SvgoLoader: (isProduction) => new SvgoLoader(isProduction).get(),
    PostcssLoader: (isProduction) => new PostcssLoader(isProduction).get(),
    SassLoader: (isProduction) => new SassLoader(isProduction).get(),
    CacheLoader: (isProduction) => new CacheLoader(isProduction).get(),
    ThreadLoader: (isProduction) => new ThreadLoader(isProduction).get(),
};
const CleanWebpackPlugin = require('../plugins/CleanWebpackPlugin');
const HashedModuleIdsPlugin = require('../plugins/HashedModuleIdsPlugin');
const ManifestPlugin = require('../plugins/ManifestPlugin');
const CompressionPlugin = require('../plugins/CompressionPlugin');
const MiniCssExtractPlugin = require('../plugins/MiniCssExtractPlugin');
const SpriteLoaderPlugin = require('../plugins/SvgSpriteLoaderPlugin');
const plugins = {
    CleanWebpackPlugin: (options) => CleanWebpackPlugin(options),
    HashedModuleIdsPlugin: (options) => HashedModuleIdsPlugin(options),
    ManifestPlugin: (options) => ManifestPlugin(options),
    CompressionPlugin: (options) => CompressionPlugin(options),
    MiniCssExtractPlugin: (options) => MiniCssExtractPlugin(options),
    SpriteLoaderPlugin: (options) => SpriteLoaderPlugin(options),
};
const OptimizationPart = require('../parts/optimization');
const parts = {
    optimization: (isProduction) => OptimizationPart(isProduction),
};
module.exports = {
    loaders: loaders,
    plugins: plugins,
    parts: parts,
};
