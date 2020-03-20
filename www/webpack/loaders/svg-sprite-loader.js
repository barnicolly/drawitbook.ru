const Loader = require('../core/base-loader');

//https://github.com/JetBrains/svg-sprite-loader
module.exports = class SvgSpriteLoader extends Loader {
    constructor(isProduction, options = {}) {
        super();
        this.options = {
            extract: true,
            runtimeCompat: true
        };
        if (options) {
            this.options = this.merge(this.options, options)
        }
    }

    get() {
        return {
            loader: 'svg-sprite-loader',
            options: this.options,
        };
    }
};
