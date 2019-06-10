$(function () {
    var $grid = $('.stack-grid');


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
            $('.shared-image img').addClass('not-loaded');
            $grid.find('.shared-image img').lazy({
                // placeholder: "data:image/gif;base64,R0lGODlhEALAPQAPzl5uLr9Nrl8e7..."
            });
            showStackGridAd.call(this);
        });

    $(window).resize(function () {
        $grid.masonry({
            columnWidth: getMasonryWidth(),
        })
    });

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

