export function loadFixedShared() {
    const $fixedShared = $('.fixed-shared-block__inner');
    if ($fixedShared.length) {
        import (/* webpackChunkName: "jssocials" */'jssocials/dist/jssocials-theme-minima.css');
        import (/* webpackChunkName: "jssocials" */'jssocials/dist/jssocials.min').then(_ => {
            $fixedShared
                .jsSocials({
                    showLabel: false,
                    showCount: false,
                    shares: ['vkontakte', 'telegram', 'twitter', 'facebook', 'pinterest', 'whatsapp', 'viber', 'email'],
                });
        });
    }
}
