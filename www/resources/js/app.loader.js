import { initStackGrid } from '@js/components/stack_grid';

const lazyLoadElements = document.querySelector("img.lazyload");
if (lazyLoadElements) {
    import (/* webpackChunkName: "lazysizes" */'lazysizes');
}

import backUpButton from '../js/components/back_up_button';
let backUpButtonElement = new backUpButton();
backUpButtonElement.create();

let stackGrid = document.querySelector('.stack-grid');
if (stackGrid) {
    initStackGrid(stackGrid);
}

const $rateContainers = $('.rate-container');
if ($rateContainers.length) {
    $rateContainers.each(function () {
        $(this).customRate('init');
    });
}
