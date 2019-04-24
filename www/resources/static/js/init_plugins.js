$('.social-fixed-sidebar').theiaStickySidebar({
    additionalMarginTop: 40,
});

$('.sidebar').theiaStickySidebar({
    additionalMarginTop: 20,
});

$('.rate-button')
    .on('click', function () {
        console.log(this);
    });