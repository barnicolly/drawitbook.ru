const Loader = require('../core/base-loader');

//https://github.com/rpominov/svgo-loader
module.exports = class SvgoLoader extends Loader {
    constructor(isProduction, options = {}) {
        super();
        this.options = {};
        if (options) {
            this.options = this.merge(this.options, options)
        }
    }

    get() {
        return {
            loader: 'svgo-loader',
            options: this.options,
        };
    }
};
