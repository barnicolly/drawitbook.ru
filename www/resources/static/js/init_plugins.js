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

    $('[data-fancybox="images"]').fancybox({
        baseClass: "fancybox-custom-layout",
        infobar: true,
        touch: {
            vertical: false
        },
        gutter: 50,
        buttons: ["zoom", "close", "thumbs"],
        animationEffect: "fade",
        transitionEffect: "fade",
        preventCaptionOverlap: false,
        idleTime: 60,
        thumbs : {
            autoStart : true,
            axis        : 'x'
        },
        mobile: {
            buttons: ["close", 'thumbs'],
            thumbs : {
                autoStart : false,
                axis        : 'y'
            },
            caption: function(instance) {
                return '';
            },
            // idleTime: false,
            clickContent: function(current, event) {
                return current.type === "image" ? "toggleControls" : false;
            },
            clickSlide: function(current, event) {
                return current.type === "image" ? "toggleControls" : "close";
            },
            dblclickContent: function(current, event) {
                return current.type === "image" ? "zoom" : false;
            },
            dblclickSlide: function(current, event) {
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
        // Customize caption area
        caption: function(instance) {
            // console.log(this);/
            // console.log(instance);
            return getCaption(this);
        }
    });

    function getCaption(imgContainer) {
        var wrapper = $('<div>');
        var tagList = $(imgContainer).closest('.art-wrapper').find('.tag-list').first().clone();

        var adWrapper = $('<div>');
        var h4 = $('<div>', {class: 'fancybox-title'}).text('Art #' + $(imgContainer).data('id'));
        wrapper.append(h4);
        wrapper.append(tagList);
        wrapper.append(adWrapper);
        // console.log(wrapper);
        // console.log(wrapper.get(0).innerHTML);
        return wrapper.get(0).innerHTML;
    }

    if ($grid.length) {
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
        $(window).smartresize(function () {
            $grid.masonry({
                columnWidth: getMasonryWidth(),
            })
        });
    } else {
        lazyLoad();
    }

    function lazyLoad() {

        $('.lazy.not-loaded').lazy({
            visibleOnly: true,
            effect: 'fadeIn',
            effectTime: 200,
            threshold: 300,
            enableThrottle: true,
            throttle: 550,
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

