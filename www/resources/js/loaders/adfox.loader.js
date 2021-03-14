import { isMobileOrTablet } from '@js/helpers/screen';

export function initAds() {
    // window.Ya.adfoxCode.create({
    //     ownerId: 281565,
    //     containerId: 'adfox_161381078845487353',
    //     params: {
    //         pp: 'g',
    //         ps: 'euiz',
    //         p2: 'hcrz'
    //     }
    // });
    if ($('body').find('#before_stack').length) {
        if (isMobileOrTablet()) {
            window.Ya.adfoxCode.createScroll({
                ownerId: 281565,
                containerId: 'before_stack',
                params: {
                    pp: 'bktf',
                    ps: 'euiz',
                    p2: 'hcsy'
                }
            });
        } else {
            window.Ya.adfoxCode.createScroll({
                ownerId: 281565,
                containerId: 'before_stack',
                params: {
                    pp: 'bktg',
                    ps: 'euiz',
                    p2: 'hcsx'
                }
            });
        }
    }

}
