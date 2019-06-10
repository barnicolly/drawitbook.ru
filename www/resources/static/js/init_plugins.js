$(function () {
    var $grid = $('.stack-grid');

    $grid.find('.shared-image img').imagesLoaded()
        // .progress(onProgress)
        .always(function () {
            $grid.closest('.stack-grid-wrapper')
                .find('.stack-loader-container').remove();
            $grid.show();
            $grid.masonry({
                itemSelector: '.art-container',
                columnWidth: getMasonryWidth(),
                gutter: 10,
            });

            $('.shared-image img').addClass('not-loaded');
            // $('.item img.not-loaded').lazyload({
            //     effect: 'fadeIn',
            //     load: function() {
            //         // Disable trigger on this image
            //         $(this).removeClass("not-loaded");
            //         $container.masonry('reload');
            //     }
            // });

            $grid.find('.shared-image img').lazy({
                afterLoad: function(element) {
                    console.log(1234);
                    $(element).removeClass("not-loaded");
                },
                onFinishedAll: function() {
                    $grid.masonry({
                        columnWidth: getMasonryWidth(),
                    })
                }
                // placeholder: "data:image/gif;base64,R0lGODlhEALAPQAPzl5uLr9Nrl8e7..."
            });
            $('.item img.not-loaded').trigger('scroll');
            showStackGridAd.call(this);
        });

    // http://jsfiddle.net/snnwolf/a6fjek78/
    //https://florianbrinkmann.com/en/3405/lazy-loading-images-in-a-masonry-grid/
    // $grid.closest('.stack-grid-wrapper')
    //     .find('.stack-loader-container').remove();
    // $grid.show();

  /*  $grid.masonry({
        itemSelector: '.art-container',
        columnWidth: getMasonryWidth(),
        gutter: 10,
    });
    showStackGridAd.call(this);*/

    $(window).resize(function () {
        $grid.masonry({
            columnWidth: getMasonryWidth(),
        })
    });

    function onProgress(imgLoad, image) {
        if (!image.isLoaded) {
            $(image.img).closest('.art-container').remove();
        }
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

