const Loader = require('../core/base-loader');

//https://webpack.js.org/loaders/babel-loader
module.exports = class BabelLoader extends Loader {
    constructor(isProduction, options = {}) {
        super();
        this.options = {
            cacheDirectory: !isProduction,
        };
        if (options) {
            this.options = this.merge(this.options, options)
        }
    }
    get() {
        return {
            loader: 'babel-loader',
            options: this.options,
        };
    }
};
