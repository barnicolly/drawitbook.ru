$('.social-fixed-sidebar').theiaStickySidebar({
    additionalMarginTop: 40,
});

$('.sidebar').theiaStickySidebar({
    additionalMarginTop: 20,
});

$(function () {
    var $grid = $('.stack-grid').imagesLoaded(function() {
        $grid.masonry({
            itemSelector: '.art-container',
            columnWidth: getMasonryWidth(),
            gutter: 10,
        });
    });

    $(window).resize(function(){
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
});
