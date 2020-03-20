const Loader = require('../core/base-loader');

//https://webpack.js.org/loaders/sass-loader/
module.exports = class SassLoader extends Loader {
    constructor(isProduction, options = {}) {
        super();
        this.options = {
            sassOptions: {
                outputStyle: 'expanded',
            },
        };
        if (options) {
            this.options = this.merge(this.options, options)
        }
    }
    get() {
        return {
            loader: 'sass-loader',
            options: this.options,
        };
    }
};
