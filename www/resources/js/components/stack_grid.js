export function initStackGrid(stackGrid) {
    import (/* webpackChunkName: "masonry-layout" */'masonry-layout').then(Masonry => {
        stackGrid.closest('.stack-grid-wrapper').querySelector('.stack-loader-container').remove();
        stackGrid.style.display = 'flex';
        new Masonry.default(stackGrid, {
            itemSelector: '.art-container',
        });
    });
}
