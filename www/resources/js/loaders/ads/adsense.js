export default class AdsenseLoader {
    constructor($container, window, renderOptions, failOverCallback) {
        this.$container = $container;
        this.renderOptions = renderOptions;
        this.failOverCallback = failOverCallback;
        this.window = window;
    }

    init() {
        const isTest = this.$container.hasClass('dummy');
        const self = this;
        const $wrapper = $('<ins>', self.renderOptions);
        self.$container.append($wrapper);
        if (!isTest) {
            if (typeof self.window.adsbygoogle !== 'undefined') {
                (adsbygoogle = self.window.adsbygoogle || []).push({});
            }
        } else {
            if (typeof self.failOverCallback === 'function') {
                self.failOverCallback();
            }
        }
    }
}
