appInit();

function appInit() {
    var version = '1.3.0';
    document.addEventListener("DOMContentLoaded", onDomLoaded);

    (function ($, sr) {
        jQuery.fn[sr] = function (fn) {
            return fn ? this.bind('resize', debounce(fn)) : this.trigger(sr);
        };
    })(jQuery, 'smartresize');

    function onDomLoaded() {
        checkJqueryLoaded();
    }

    function checkJqueryLoaded() {
        if (window.jQuery) {
            $('.img-wrapper a').on('click', function (e) {
                if ($(this).find('img').eq(0).hasClass('not-loaded')) {
                    e.preventDefault();
                }
            });
            afterJqueryLoaded();
        } else {
            window.setTimeout("checkJqueryLoaded();", 100);
        }
    }

    function afterJqueryLoaded() {
        var currentRequests = {};
        $.ajaxPrefilter(function (options, originalOptions, jqXHR) {
            if (currentRequests[options.url]) {
                currentRequests[options.url].abort();
            }
            currentRequests[options.url] = jqXHR;
        });

        var grid = $('.stack-grid');
        if (grid.length) {
            grid.closest('.stack-grid-wrapper')
                .find('.stack-loader-container').remove();
            grid.show();
            grid.masonry({
                itemSelector: '.art-container',
                columnWidth: getMasonryWidth(),
                gutter: 10,
            });
            lazyLoad();
            showStackGridAd.call(this);
            $(window).smartresize(function () {
                grid.masonry({
                    columnWidth: getMasonryWidth(),
                })
            });
        } else {
            lazyLoad();
        }

        $('#button').backUpButton('init');

        function lazyLoad() {
            $('.lazy.not-loaded').lazy({
                visibleOnly: true,
                effect: 'fadeIn',
                effectTime: 200,
                threshold: 300,
                enableThrottle: true,
                throttle: 1000,
                afterLoad: function (element) {
                    $(element).removeClass('not-loaded');
                },
            });
        }

        function getMasonryWidth() {
            var masonryWidth = 362;
            var bvw = document.getElementsByTagName("body")[0].offsetWidth;
            if (bvw >= 768 && bvw <= 1100) {
                masonryWidth = 300;
            } else if (bvw < 768) {
                masonryWidth = null;
            }
            return masonryWidth;
        }
    }

    window.onload = function () {
        appendJs('/build/js/after_load.min.js');
        appendCss('/build/css/after_load.min.css');

        setTimeout(function tick() {
            if (jQuery().fancybox) {
                if ($('.rate-container').length) {
                    $('.rate-container').each(function () {
                        $(this).customRate('init');
                    });
                }

                if ($('.claim-button').length) {
                    $('.claim-button').each(function () {
                        $(this).customClaim('init');
                    });
                }
                if ($('.art-control').length) {
                    $('.art-control').each(function () {
                        $(this).customArtControl('init');
                    });
                }

                if ($('.social-fixed-sidebar').length) {
                    $('.social-fixed-sidebar').theiaStickySidebar({
                        additionalMarginTop: 40,
                    });
                }

                if ($('.sidebar').length) {
                    $('.sidebar').theiaStickySidebar({
                        additionalMarginTop: 20,
                    });
                }
                initFancybox();
            } else {
                setTimeout(tick, 100);
            }
        }, 100);
    };

    function initFancybox() {
        $('[data-fancybox="images"]').fancybox({
            baseClass: "fancybox-custom-layout",
            infobar: true,
            touch: {
                vertical: false
            },
            gutter: 50,
            buttons: ["zoom", "close", 'vk', 'ok', 'fb'],
            animationEffect: "fade",
            transitionEffect: "fade",
            transitionDuration: 100,
            preventCaptionOverlap: false,
            idleTime: 60,
            thumbs: {
                autoStart: true,
                axis: 'x',
                parentEl: ".fancybox-stage",
            },
            // Base template for layout
            baseTpl:
                '<div class="fancybox-container" role="dialog" tabindex="-1">' +
                '<div class="fancybox-bg"></div>' +
                '<div class="fancybox-inner">' +
                '<div class="fancybox-infobar"><span data-fancybox-index></span>&nbsp;/&nbsp;<span data-fancybox-count></span></div>' +
                '<div class="fancybox-toolbar">{{buttons}}</div>' +
                '<div class="fancybox-navigation">{{arrows}}</div>' +
                '<div class="fancybox-stage">' +
                '<div class="fancybox-header"><div id="onFancyHeader"></div></div>' +
                '</div>' +
                '<div class="fancybox-caption">' +
                '<div class="fancybox-caption__body"></div>' +
                '<div id="onFancyPreview"></div>' +
                '</div>' +
                "</div>" +
                "</div>",
            mobile: {
                buttons: ["close", 'thumbs'],
                thumbs: {
                    autoStart: false,
                    axis: 'x',
                    parentEl: ".fancybox-stage",
                },
                // idleTime: false,
                clickContent: function (current, event) {
                    return false;
                },
                clickSlide: function (current, event) {
                    return "close";
                },
                dblclickContent: function (current, event) {
                    return current.type === "image" ? "zoom" : false;
                },
                dblclickSlide: function (current, event) {
                    return current.type === "image" ? "zoom" : false;
                }
            },
            lang: 'ru',
            i18n: {
                ru: {
                    CLOSE: "Закрыть",
                    NEXT: "Следующий",
                    PREV: "Предыдущий",
                    ERROR: "The requested content cannot be loaded. <br/> Please try again later.",
                    PLAY_START: "Start slideshow",
                    PLAY_STOP: "Pause slideshow",
                    FULL_SCREEN: "Full screen",
                    THUMBS: "Миниатюры",
                    ZOOM: "Zoom"
                },
            },
            hash: false,
            caption: function (instance) {
                return getCaption(this);
            }
        });

        function getCaption(imgContainer) {
            var bvw = document.getElementsByTagName("body")[0].offsetWidth;
            var wrapper = $('<div>');
            var tagList = $(imgContainer).closest('.art-wrapper').find('.tag-list').first().clone();

            var adWrapper = $('<div>');
            var h4 = $('<div>', {class: 'fancybox-title'}).text('Art #' + $(imgContainer).data('id'));
            wrapper.append(h4);
            wrapper.append(tagList);
            if (bvw > 768) {
                wrapper.append(adWrapper);
            }
            return wrapper.get(0).innerHTML;
        }
    }

    function appendJs(script) {
        var s = document.createElement('script');
        s.type = 'text/javascript';
        s.async = true;
        s.src = script + '?' + version;
        var x = document.getElementsByTagName('script')[0];
        x.parentNode.insertBefore(s, x);
    }

    function appendCss(href) {
        var css = document.createElement('link');
        css.rel = 'stylesheet';
        css.href = href + '?' + version;
        document.getElementsByTagName('head')[0].appendChild(css);
    }

};