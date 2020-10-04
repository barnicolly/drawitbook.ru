export function isOnScreen(elem, offset = 300) {
    // if the element doesn't exist, abort
    if( elem.length == 0 ) {
        return;
    }
    const $window = $(window)
    const viewport_top = $window.scrollTop()
    const viewport_height = $window.height()
    const viewport_bottom = viewport_top + viewport_height + offset
    const $elem = $(elem)
    const top = $elem.offset().top
    const height = $elem.height()
    const bottom = top + height

    return (top >= viewport_top && top < viewport_bottom) ||
        (bottom > viewport_top && bottom <= viewport_bottom) ||
        (height > viewport_height && top <= viewport_top && bottom >= viewport_bottom)
}
