import { testWatcher } from '@js/helpers/scroll';

export default class YandexLoader {
    constructor($container, window, renderOptions, failOverCallback) {
        this.$container = $container;
        this.renderOptions = renderOptions;
        this.failOverCallback = failOverCallback;
        this.window = window;
        renderOptions.renderTo = this.$container.attr('id');
    }

    init() {
        const isTest = this.$container.hasClass('dummy');
        const self = this;
        testWatcher(self.$container, () => {
            self.$container.attr('data-loaded', true);
            console.log('Загрузился ', self.renderOptions);
            if (!isTest) {
                (function (w, d, n, s, t) {
                    w[n] = w[n] || [];
                    w[n].push(function () {
                        Ya.Context.AdvManager.render(self.renderOptions, self.failOverCallback);
                    });
                    t = d.getElementsByTagName('script')[0];
                    s = d.createElement('script');
                    s.type = 'text/javascript';
                    s.src = '//an.yandex.ru/system/context.js';
                    s.async = true;
                    t.parentNode.insertBefore(s, t);
                })(this.window, this.window.document, 'yandexContextAsyncCallbacks');
            } else {
                if (typeof self.failOverCallback === 'function') {
                    self.failOverCallback();
                }
            }
        });
    }
}
