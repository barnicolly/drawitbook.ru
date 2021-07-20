import { isOnScreen } from '@js/helpers/dom';
import throttle from 'lodash/throttle';

export function getWindowScrollPositionTop() {
    let doc = document.documentElement;
    return (window.pageYOffset || doc.scrollTop) - (doc.clientTop || 0);
}

export function scrollUpPage() {
    window.scroll({
        top: 0,
        left: 0,
        behavior: 'smooth',
    });
}

export function testWatcher($place, callBack) {
    let loaded = false;
    const scrollEvent = function () {
        if (!loaded && isOnScreen($place, 500)) {
            loaded = true;
            $(window).off('scroll', scrollEventThrottled);
            callBack();
        }
    };
    const scrollEventThrottled = throttle(scrollEvent, 150);
    scrollEvent();
    $(window).on('scroll', scrollEventThrottled);
}
