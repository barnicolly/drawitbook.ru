export function initStackGrid(stackGrid, callback) {
    import (/* webpackChunkName: "masonry-layout" */'masonry-layout').then(Masonry => {
        stackGrid.closest('.stack-grid-wrapper').querySelector('.stack-loader-container').remove();
        stackGrid.style.display = 'flex';
        new Masonry.default(stackGrid, {
            itemSelector: '.art-container',
            // gutter: 10,
        });
        setTimeout(callback($(stackGrid)), 200);
    });
}
