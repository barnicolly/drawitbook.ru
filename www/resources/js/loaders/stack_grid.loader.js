import { getScreenWidth } from '@js/helpers/screen';
import { initStackGridAds } from '@js/loaders/ads.loader';
import { initStackGrid } from '@js/components/stack_grid';
import throttle from 'lodash/throttle';

export function loadStackGrid() {
    const screenWidth = getScreenWidth();

    let stackGrid = document.querySelector('.stack-grid');
    if (stackGrid) {
        if (screenWidth <= 768) {
            $(stackGrid).closest('.stack-grid-wrapper').find('.stack-loader-container').remove();
            stackGrid.style.display = 'flex';
            initStackGridAds($(stackGrid));
        }

        const tryInitStackGrid = function () {
            const screenWidth = getScreenWidth();
            if (screenWidth >= 700) {
                const isStackGridVisible = $(stackGrid).is(':visible');
                initStackGrid(stackGrid, function ($stackGrid) {
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
    }

}
