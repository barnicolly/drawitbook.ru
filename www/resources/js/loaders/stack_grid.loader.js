import {getScreenWidth} from '@js/helpers/screen';
import {initStackGridAds} from '@js/loaders/ads.loader';
import {initStackGrid} from '@js/components/stack_grid';
import throttle from 'lodash/throttle';
import {sendRequest} from "@js/helpers/utils";

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
        $stackGridWrapper
            .on('click', '.download-more__btn', function () {
                const $downloadBtn = $(this);
                const sliceNumber = $stackGrid.attr('data-page');
                sendRequest('get',  `${relativeUrlPath}/slice`, {page: sliceNumber}, function (res) {
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
                        $stackGrid.attr('data-page', res.data.page);
                        $downloadBtn.find('.left-pictures-cnt').text(res.data.countLeftPicturesText);
                        if (res.data.isLastSlice) {
                            $downloadBtn.remove();
                        }
                    } else {
                        //TODO-misha сообщение об ошибке;
                    }
                })
            })
    }

}
