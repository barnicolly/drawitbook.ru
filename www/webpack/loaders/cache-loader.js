const Loader = require('../core/base-loader');

//https://webpack.js.org/loaders/cache-loader/#root
module.exports = class BabelLoader extends Loader {
    constructor(isProduction, options = {}) {
        super();
        this.options = {};
        if (options) {
            this.options = this.merge(this.options, options)
        }
    }
    get() {
        return {
            loader: 'cache-loader',
            options: this.options,
        };
    }
};
