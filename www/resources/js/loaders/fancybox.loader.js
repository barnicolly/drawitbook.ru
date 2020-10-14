import { reachClickFullSizeImage } from '@js/components/ya_target';

export function loadFancybox($images) {
    if ($images.length) {
        let loaded = false;
        $images
            .on('click', function (e) {
                const $image = $(this);
                if (!loaded) {
                    e.preventDefault();
                    import (/* webpackChunkName: "fancybox" */'@plugins/fancybox/dist/jquery.fancybox.min.css');
                    import (/* webpackChunkName: "fancybox" */'@plugins/fancybox/dist/fancybox.compiled.min').then(_ => {
                        $images
                            .fancybox({
                                'speedIn': 600,
                                'speedOut': 200,
                                'overlayShow': false,
                            });
                        loaded = true;
                        $image.trigger('click');
                        reachClickFullSizeImage();
                    });
                }
            })

    }
}
