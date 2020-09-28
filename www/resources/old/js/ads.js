var bvw = document.getElementsByTagName("body")[0].offsetWidth;
var turnAds = true;

document.addEventListener("DOMContentLoaded", initLoader, false);

function isMyScriptLoaded(url) {
    var scripts = document.getElementsByTagName('script');
    for (var i = scripts.length; i--;) {
        if (scripts[i].src == url) return true;
    }
    return false;
}
function initLoader() {

    getAdYandexScript();
    showAds.call(window);

    function getAdYandexScript() {
        var s = document.createElement('script');
        s.type = 'text/javascript';
        s.async = true;
        s.src = '//an.yandex.ru/system/context.js';
        var x = document.getElementsByTagName('script')[0];
        x.parentNode.insertBefore(s, x);
    }
}

function isHidden(el) {
    return (el.offsetParent === null)
}

function initViewPage() {
    if (document.getElementById('onFancyPreview') && !isHidden(document.getElementById('onFancyPreview'))) {
        (function(w, d, n, s, t) {
            w[n] = w[n] || [];
            w[n].push(function() {
                Ya.Context.AdvManager.render({
                    blockId: "R-A-400272-16",
                    renderTo: "onFancyPreview",
                    async: true
                });
            });
        })(this, this.document, "yandexContextAsyncCallbacks");
    }

    if (document.getElementById('onFancyHeader') && !isHidden(document.getElementById('onFancyHeader'))) {
        (function(w, d, n, s, t) {
            w[n] = w[n] || [];
            w[n].push(function() {
                Ya.Context.AdvManager.render({
                    blockId: "R-A-400272-17",
                    renderTo: "onFancyHeader",
                    async: true
                });
            });
            if (!isMyScriptLoaded('//an.yandex.ru/system/context.js')) {
                t = d.getElementsByTagName("script")[0];
                s = d.createElement("script");
                s.type = "text/javascript";
                s.src = "//an.yandex.ru/system/context.js";
                s.async = true;
                t.parentNode.insertBefore(s, t);
            }
        })(this, this.document, "yandexContextAsyncCallbacks");
    }

}

function showAds() {
    if (turnAds) {
        if (bvw > 768) {
            if (document.getElementById('in_sidebar')) {
                (function (w, d, n, s, t) {
                    w[n] = w[n] || [];
                    w[n].push(function () {
                        Ya.Context.AdvManager.render({
                            blockId: "R-A-400272-1",
                            renderTo: "in_sidebar",
                            async: true
                        });
                    });
                    if (!isMyScriptLoaded('//an.yandex.ru/system/context.js')) {
                        t = d.getElementsByTagName("script")[0];
                        s = d.createElement("script");
                        s.type = "text/javascript";
                        s.src = "//an.yandex.ru/system/context.js";
                        s.async = true;
                        t.parentNode.insertBefore(s, t);
                    }
                })(this, this.document, "yandexContextAsyncCallbacks");
            }
        }
        if (bvw > 768) {
            if (document.getElementById('after_picture')) {
                (function (w, d, n, s, t) {
                    w[n] = w[n] || [];
                    w[n].push(function () {
                        Ya.Context.AdvManager.render({
                            blockId: "R-A-400272-2",
                            renderTo: "after_picture",
                            async: true
                        });
                    });
                })(this, this.document, "yandexContextAsyncCallbacks");
            }
            if (document.getElementById('before_stack')) {
                (function (w, d, n, s, t) {
                    w[n] = w[n] || [];
                    w[n].push(function () {
                        Ya.Context.AdvManager.render({
                            blockId: "R-A-400272-4",
                            renderTo: "before_stack",
                            async: true
                        });
                    });
                })(this, this.document, "yandexContextAsyncCallbacks");
            }
            if (document.getElementById('after_first_stack')) {
                (function (w, d, n, s, t) {
                    w[n] = w[n] || [];
                    w[n].push(function () {
                        Ya.Context.AdvManager.render({
                            blockId: "R-A-400272-7",
                            renderTo: "after_first_stack",
                            async: true
                        });
                    });
                })(this, this.document, "yandexContextAsyncCallbacks");
            }
        } else {
            if (document.getElementById('after_picture')) {
                (function (w, d, n, s, t) {
                    w[n] = w[n] || [];
                    w[n].push(function () {
                        Ya.Context.AdvManager.render({
                            blockId: "R-A-400272-3",
                            renderTo: "after_picture",
                            async: true
                        });
                    });
                })(this, this.document, "yandexContextAsyncCallbacks");
            }
            if (document.getElementById('before_stack')) {
                (function (w, d, n, s, t) {
                    w[n] = w[n] || [];
                    w[n].push(function () {
                        Ya.Context.AdvManager.render({
                            blockId: "R-A-400272-5",
                            renderTo: "before_stack",
                            async: true
                        });
                    });
                })(this, this.document, "yandexContextAsyncCallbacks");
            }
            if (document.getElementById('after_first_stack')) {
                (function (w, d, n, s, t) {
                    w[n] = w[n] || [];
                    w[n].push(function () {
                        Ya.Context.AdvManager.render({
                            blockId: "R-A-400272-6",
                            renderTo: "after_first_stack",
                            async: true
                        });
                    });
                })(this, this.document, "yandexContextAsyncCallbacks");
            }
        }
        showArticleAd.call(this);
    }
}

function showArticleAd() {
    if (document.getElementById('after_article')) {
        if (bvw > 768) {
            (function (w, d, n, s, t) {
                w[n] = w[n] || [];
                w[n].push(function () {
                    Ya.Context.AdvManager.render({
                        blockId: "R-A-400272-15",
                        renderTo: "after_article",
                        async: true
                    });
                });
            })(this, this.document, "yandexContextAsyncCallbacks");
        } else {
            (function (w, d, n, s, t) {
                w[n] = w[n] || [];
                w[n].push(function () {
                    Ya.Context.AdvManager.render({
                        blockId: "R-A-400272-14",
                        renderTo: "after_article",
                        async: true
                    });
                });
            })(this, this.document, "yandexContextAsyncCallbacks");
        }
    }
    if (document.getElementById('integrated_article_2')) {
        (function (w, d, n, s, t) {
            w[n] = w[n] || [];
            w[n].push(function () {
                Ya.Context.AdvManager.render({
                    blockId: "R-A-400272-11",
                    renderTo: "integrated_article_2",
                    async: true
                });
            });
        })(this, this.document, "yandexContextAsyncCallbacks");
    }
    if (document.getElementById('integrated_article_7')) {
        (function (w, d, n, s, t) {
            w[n] = w[n] || [];
            w[n].push(function () {
                Ya.Context.AdvManager.render({
                    blockId: "R-A-400272-12",
                    renderTo: "integrated_article_7",
                    async: true
                });
            });
        })(this, this.document, "yandexContextAsyncCallbacks");
    }
    if (document.getElementById('integrated_article_12')) {
        (function (w, d, n, s, t) {
            w[n] = w[n] || [];
            w[n].push(function () {
                Ya.Context.AdvManager.render({
                    blockId: "R-A-400272-13",
                    renderTo: "integrated_article_12",
                    async: true
                });
            });
        })(this, this.document, "yandexContextAsyncCallbacks");
    }
}

function showStackGridAd() {
    if (turnAds) {
        if (document.getElementById('integrated_5')) {
            (function (w, d, n, s, t) {
                w[n] = w[n] || [];
                w[n].push(function () {
                    Ya.Context.AdvManager.render({
                        blockId: "R-A-400272-8",
                        renderTo: "integrated_5",
                        async: true
                    });
                });
            })(this, this.document, "yandexContextAsyncCallbacks");
        }
        if (document.getElementById('integrated_12')) {
            (function (w, d, n, s, t) {
                w[n] = w[n] || [];
                w[n].push(function () {
                    Ya.Context.AdvManager.render({
                        blockId: "R-A-400272-9",
                        renderTo: "integrated_12",
                        async: true
                    });
                });
            })(this, this.document, "yandexContextAsyncCallbacks");
        }
        if (document.getElementById('integrated_18')) {
            (function (w, d, n, s, t) {
                w[n] = w[n] || [];
                w[n].push(function () {
                    Ya.Context.AdvManager.render({
                        blockId: "R-A-400272-10",
                        renderTo: "integrated_18",
                        async: true
                    });
                });
            })(this, this.document, "yandexContextAsyncCallbacks");
        }
    }
}
