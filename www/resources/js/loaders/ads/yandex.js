export default class YandexLoader {
    constructor($container, window) {
        this.$container = $container;
        this.window = window;
        this.id = $container.attr('id');
    }

    init() {
        const isTest = this.$container.hasClass('dummy');
        if (!isTest) {
            const self = this;
            (function(w, d, n, s, t) {
                w[n] = w[n] || [];
                w[n].push(function() {
                    Ya.Context.AdvManager.render({
                        blockId: "R-A-734726-4",
                        renderTo: self.id,
                        async: true
                    });
                });
                t = d.getElementsByTagName("script")[0];
                s = d.createElement("script");
                s.type = "text/javascript";
                s.src = "//an.yandex.ru/system/context.js";
                s.async = true;
                t.parentNode.insertBefore(s, t);
            })(this.window, this.window.document, "yandexContextAsyncCallbacks");
        }
    }
}
