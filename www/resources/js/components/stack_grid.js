
export function initStackGrid(stackGrid, callback) {
    import (/* webpackChunkName: "masonry-layout" */'masonry-layout').then(Masonry => {
        if (!$(stackGrid).is(':visible')) {
            $(stackGrid).closest('.stack-grid-wrapper').find('.stack-loader-container').remove();
            $(stackGrid).css({
                display: 'flex',
            });
        }
        new Masonry.default(stackGrid, {
            itemSelector: '.art-container',
            // gutter: 10,
        });
        setTimeout(callback($(stackGrid)), 200);
    });
}
