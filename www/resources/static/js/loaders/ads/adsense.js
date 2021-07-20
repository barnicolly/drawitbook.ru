import { testWatcher } from '@js/helpers/scroll';

export default class AdsenseLoader {
    constructor($container, window, renderOptions, failOverCallback) {
        this.$container = $container;
        this.renderOptions = renderOptions;
        this.failOverCallback = failOverCallback;
        this.window = window;
    }

    init() {
        const self = this;
        testWatcher(self.$container, () => {
            self.$container.attr('data-loaded', true);
            const isTest = self.$container.hasClass('dummy');
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
        });
    }
}
