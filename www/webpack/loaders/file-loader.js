const Loader = require('../core/base-loader');

module.exports = class FileLoader extends Loader {
    constructor(isProduction, options = {}) {
        super();
        this.options = options;
    }
    get() {
        return {
            loader: 'file-loader',
            options: this.options,
        };
    }
};
