export function loadLazyloadImg() {
    const lazyLoadElements = document.querySelector('img.lazyload');
    if (lazyLoadElements) {
        import (/* webpackChunkName: "lazysizes" */'lazysizes');
    }
}
