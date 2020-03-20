const Loader = require('../core/base-loader');

//https://webpack.js.org/loaders/thread-loader/#root
module.exports = class BabelLoader extends Loader {
    constructor(isProduction, options = {}) {
        super();
        this.options = {
            workers: 2,
        };
        if (options) {
            this.options = this.merge(this.options, options)
        }
    }
    get() {
        return {
            loader: 'thread-loader',
            options: this.options,
        };
    }
};
