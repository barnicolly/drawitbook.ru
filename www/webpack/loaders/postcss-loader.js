const Loader = require('../core/base-loader');

//https://webpack.js.org/loaders/postcss-loader/
module.exports = class PostCssLoader extends Loader {
    constructor(isProduction, options = {}) {
        super();
        this.options = {
            plugins: [
                require('autoprefixer'),
            ],
            outputStyle: 'expanded',
        };
        if (options) {
            this.options = this.merge(this.options, options)
        }
    }
    get() {
        return {
            loader: 'postcss-loader',
            options: this.options,
        };
    }
};
