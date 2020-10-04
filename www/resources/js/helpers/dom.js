export function isOnScreen(elem, offset = 300) {
    // if the element doesn't exist, abort
    if( elem.length == 0 ) {
        return;
    }
    var $window = $(window)
    var viewport_top = $window.scrollTop()
    var viewport_height = $window.height()
    var viewport_bottom = viewport_top + viewport_height + offset
    var $elem = $(elem)
    var top = $elem.offset().top
    var height = $elem.height()
    var bottom = top + height

    return (top >= viewport_top && top < viewport_bottom) ||
        (bottom > viewport_top && bottom <= viewport_bottom) ||
        (height > viewport_height && top <= viewport_top && bottom >= viewport_bottom)
}
