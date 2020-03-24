import 'normalize.css';

import '../scss/layout/_layout.scss';
import '../scss/components/_page_up_button.scss';
import '../scss/components/_breadcrumb.scss';
import '../scss/components/_pagination.scss';
import '../scss/components/_stack_grid.scss';
import '../scss/components/_loader.scss';
import '../scss/components/_social_fixed.scss';
import '../scss/components/_rate_button.scss';
import '../scss/components/_art.scss';
import '../scss/components/_img.scss';

const lazyLoadElements = document.querySelector("img.lazyload");
if (lazyLoadElements) {
    import (/* webpackChunkName: "lazysizes" */'lazysizes');
}

import './polyfil';
import '../js/components/stack_grid';

import backUpButton from '../js/components/back_up_button';
let backUpButtonElement = new backUpButton();
backUpButtonElement.create();
