appInit();

function appInit() {
    var version = '1.3.2';
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
            showStackGridAd.call(this);
            $(window).smartresize(function () {
                grid.masonry({
                    columnWidth: getMasonryWidth(),
                })
            });
        }
        $('#button').backUpButton('init');

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
        setTimeout(function () {
            appendCss('/build/css/after_load.min.css');
        }, 250);

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
            } else {
                setTimeout(tick, 100);
            }


            if ($('#tagContainer').length) {
                sendRequest('get', '/tag/list', {}, function (res) {
                    if (res.success) {
                        var cloudTags = res.cloud_items;
                        reinitJQcloud(cloudTags);

                        function reinitJQcloud(tags) {
                            $("#tagContainer").html('');
                            $("#tagContainer").jQCloud(tags, {
                                classPattern: null,
                                fontSize: {
                                    from: 0.1,
                                    to: 0.08
                                },
                                shape: false, // or 'rectangular'
                                autoResize: true,
                            });

                        }

                        function checkScroll() {
                            reinitJQcloud(cloudTags);
                        }

                        $(window).resize(debounce(checkScroll, 150));
                    }
                });
            }
        }, 100);
    };

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