(function ($, sr) {
    var debounce = function (func, threshold, execAsap) {
        var timeout;

        return function debounced() {
            var obj = this, args = arguments;

            function delayed() {
                if (!execAsap)
                    func.apply(obj, args);
                timeout = null;
            };

            if (timeout)
                clearTimeout(timeout);
            else if (execAsap)
                func.apply(obj, args);

            timeout = setTimeout(delayed, threshold || 300);
        };
    }
    // smartresize
    jQuery.fn[sr] = function (fn) {
        return fn ? this.bind('resize', debounce(fn)) : this.trigger(sr);
    };

})(jQuery, 'smartresize');

$(function () {
    var $grid = $('.stack-grid');

    if ($grid.length) {
        $grid.find('.shared-image img').imagesLoaded()
            .always(function () {
                $grid.closest('.stack-grid-wrapper')
                    .find('.stack-loader-container').remove();
                $grid.show();
                $grid.masonry({
                    itemSelector: '.art-container',
                    columnWidth: getMasonryWidth(),
                    gutter: 10,
                });

                lazyLoad();
                showStackGridAd.call(this);
            });

        $(window).smartresize(function () {
            $grid.masonry({
                columnWidth: getMasonryWidth(),
            })
        });
    } else {
        lazyLoad();
    }

    function lazyLoad() {
        $('body').find('.shared-image img').lazy({
            visibleOnly: true,
            threshold: 50,
            afterLoad: function(element) {
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

    $('.shared-image img').sti({
        selector: '.shared-image img',
        orientation: "horizontal",
        title: 'Drawitbook.ru - рисуйте, развлекайтесь, делитесь с друзьями',
        style: "flat-small",
        always_show: false,
        is_mobile: false,
        primary_menu: ["vkontakte", "pinterest", 'odnoklassniki', "facebook", "twitter"]
    });

    $(document).ready(function () {
        $(".megamenu").on("click", function (e) {
            e.stopPropagation();
        });

        $('.social-fixed-sidebar').theiaStickySidebar({
            additionalMarginTop: 40,
        });

        $('.sidebar').theiaStickySidebar({
            additionalMarginTop: 20,
        });
    });

});

