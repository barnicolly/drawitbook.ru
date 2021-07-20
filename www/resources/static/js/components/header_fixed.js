export function initFixedHeader($header) {
    const fixedHeadMenuHandler = function () {
        let topOffset = $(window).scrollTop() + 1;
        const classList = 'header--fixed header--animated header--fade-in-down';
        if (topOffset > 50) {
            $header.addClass(classList);
        } else {
            $header.removeClass(classList);
        }
    };
    fixedHeadMenuHandler();
    $(window).scroll(fixedHeadMenuHandler);
}
