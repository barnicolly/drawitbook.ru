import {getScreenWidth} from '@js/helpers/screen';
import {initStackGridAds} from '@js/loaders/ads.loader';
import {initStackGrid} from '@js/components/stack_grid';
import throttle from 'lodash/throttle';
import {sendRequest} from "@js/helpers/utils";
import { loadFancybox } from '@js/loaders/fancybox.loader';

export function loadStackGrid() {
    const screenWidth = getScreenWidth();

    let $stackGrid = $('.stack-grid');
    if ($stackGrid.length) {
        const $stackGridWrapper = $stackGrid.closest('.stack-grid-wrapper');
        if (screenWidth <= 768) {
            $stackGridWrapper.find('.stack-loader-container').remove();
            $stackGrid.css({display: 'flex'});
            initStackGridAds($stackGrid);
        }

        const tryInitStackGrid = function () {
            const screenWidth = getScreenWidth();
            if (screenWidth >= 700) {
                const isStackGridVisible = $stackGrid.is(':visible');
                initStackGrid($stackGrid, function ($stackGrid) {
                    if (!isStackGridVisible) {
                        initStackGridAds($stackGrid);
                    }
                    $(window).off('resize', throttledInitStackGrid);
                });
            }
        }

        const throttledInitStackGrid = throttle(tryInitStackGrid, 150);

        tryInitStackGrid();
        $(window).on('resize', throttledInitStackGrid);

        const relativeUrlPath = window.location.pathname;
        const searchParams = window.location.search;
        $stackGridWrapper
            .on('click', '.download-more__btn', function () {
                const $downloadBtn = $(this);
                const sliceNumber = parseInt($stackGrid.attr('data-page')) + 1;
                const url = searchParams
                    ? `${relativeUrlPath}/slice${searchParams}&page=${sliceNumber}`
                    : `${relativeUrlPath}/slice?page=${sliceNumber}`;
                sendRequest('get',  url, {}, function (res) {
                    let scrollPosition = $(window).scrollTop();
                    if (typeof res.data !== 'undefined' && typeof res.data.html !== 'undefined') {
                        $stackGrid.append(res.data.html);
                        if (screenWidth >= 700) {
                            initStackGrid($stackGrid, function ($stackGrid) {
                                $(window).scrollTop(scrollPosition);
                                initStackGridAds($stackGrid, sliceNumber);
                            });
                        } else {
                            $(window).scrollTop(scrollPosition);
                            initStackGridAds($stackGrid, sliceNumber);
                        }
                        const $newImages = $stackGrid.find(`.art-container[data-page="${res.data.page}"]`).find('.fullscreen-image__link');
                        loadFancybox($newImages);
                        $stackGrid.attr('data-page', res.data.page);
                        $downloadBtn.find('.left-pictures-cnt').text(res.data.countLeftPicturesText);
                        if (res.data.isLastSlice) {
                            $downloadBtn.remove();
                        }
                        const $rateContainers = $stackGrid.find(`.art-container[data-page="${res.data.page}"]`).find('.rate-control');
                        if ($rateContainers.length) {
                            $rateContainers.each(function () {
                                $(this).customRate('init');
                            });
                        }
                    } else {
                        //TODO-misha сообщение об ошибке;
                    }
                })
            })
    }

}
