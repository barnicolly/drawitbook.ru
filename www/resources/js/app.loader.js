import { initStackGrid } from '@js/components/stack_grid';

const lazyLoadElements = document.querySelector("img.lazyload");
if (lazyLoadElements) {
    import (/* webpackChunkName: "lazysizes" */'lazysizes');
}

import backUpButton from '../js/components/back_up_button';
import { sendRequest } from '@js/helpers/utils';
import { debounce } from '@js/helpers/optimization';
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

const $sidebar = $('.sidebar');

if ($sidebar.length) {
    $sidebar.theiaStickySidebar({
        additionalMarginTop: 20,
    });
}

const $claimButtons = $('.claim-button');
if ($claimButtons.length) {
    $claimButtons.each(function () {
        $(this).customClaim('init');
    });
}

if ($('#tagContainer').length) {
    console.log(123123);
    sendRequest('get', '/tag/list', {}, function (res) {
        if (res.success) {
            var cloudTags = res.cloud_items;
            reinitJQcloud(cloudTags);

            function reinitJQcloud(tags) {
                $("#tagContainer").html('');
                $("#tagContainer").jQCloud(tags, {
                    classPattern: null,
                    fontSize: {
                        from: 0.1,
                        to: 0.08
                    },
                    shape: false, // or 'rectangular'
                    autoResize: true,
                });

            }

            function checkScroll() {
                reinitJQcloud(cloudTags);
            }

            $(window).resize(debounce(checkScroll, 150));
        }
    });
}