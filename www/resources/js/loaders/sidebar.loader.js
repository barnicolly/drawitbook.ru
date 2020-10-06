export function loadSidebar() {
    const $sidebar = $('.sidebar');
    if ($sidebar.length) {
        import (/* webpackChunkName: "ResizeSensor" */'@plugins/sticky/ResizeSensor')
            .then(_ => {
                return import (/* webpackChunkName: "theia-sticky-sidebar" */'@plugins/sticky/theia-sticky-sidebar.min')
            })
            .then(_ => {
                $sidebar.theiaStickySidebar({
                    additionalMarginTop: 70,
                });
            });
    }
}
