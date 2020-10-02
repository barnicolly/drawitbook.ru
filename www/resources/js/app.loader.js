const lazyLoadElements = document.querySelector("img.lazyload");
if (lazyLoadElements) {
    import (/* webpackChunkName: "lazysizes" */'lazysizes');
}

import backUpButton from '../js/components/back_up_button';
let backUpButtonElement = new backUpButton();
backUpButtonElement.create();
