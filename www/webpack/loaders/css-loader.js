const Loader = require('../core/base-loader');

//https://webpack.js.org/loaders/css-loader/
module.exports = class CssLoader extends Loader {
    constructor(isProduction, options = {}) {
        super();
        this.options = {};
        if (options) {
            this.options = this.merge(this.options, options)
        }
    }
    get() {
        return {
            loader: 'css-loader',
            options: this.options,
        };
    }
};
