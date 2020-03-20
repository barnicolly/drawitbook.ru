const Loader = require('../core/base-loader');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

//https://webpack.js.org/plugins/mini-css-extract-plugin/
module.exports = class MiniCssExtractLoader extends Loader {
    constructor(isProduction, options = {}) {
        super();
        this.options = {
            hmr: !isProduction,
        };
        if (options) {
            this.options = this.merge(this.options, options)
        }
    }
    get() {
        return {
            loader: MiniCssExtractPlugin.loader,
            options: this.options,
        };
    }
};
