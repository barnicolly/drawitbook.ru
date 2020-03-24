let stackGrid = document.querySelector('.stack-grid');
if (stackGrid) {
    import (/* webpackChunkName: "masonry-layout" */'masonry-layout').then(Masonry => {
        stackGrid.closest('.stack-grid-wrapper').querySelector('.stack-loader-container').remove();
        showElements(stackGrid);
        new Masonry.default(stackGrid, {
            itemSelector: '.art-container',
            columnWidth: getMasonryWidth(),
            gutter: 10,
        });
        function getMasonryWidth() {
            var masonryWidth = 386;
            var bvw = document.getElementsByTagName("body")[0].offsetWidth;
            if (bvw >= 768 && bvw <= 1100) {
                masonryWidth = 300;
            } else if (bvw < 768) {
                masonryWidth = null;
            }
            return masonryWidth;
        }
    });
}

function showElements(elemets) {
    elemets.style.display = 'block';
}
