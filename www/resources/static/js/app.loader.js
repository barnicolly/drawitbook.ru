import './product_watcher';
import backUpButton from '@js/components/back_up_button';
import { initHeaderMenu } from '@js/components/header_menu';
import { initFixedHeader } from '@js/components/header_fixed';
import { initAds } from '@js/loaders/ads.loader';
import { loadStackGrid } from '@js/loaders/stack_grid.loader';
import { loadJQcloud } from '@js/loaders/jq_cloud.loader';
import { loadLazyloadImg } from '@js/loaders/lazy.loader';
import { loadFixedShared } from '@js/loaders/fixed_shared.loader';
import { loadFancybox } from '@js/loaders/fancybox.loader';
import { loadSidebar } from '@js/loaders/sidebar.loader';
import { SentryInstance } from '@js/sentry';
import { initArtControls } from '@js/loaders/art_control.loader';
import { FixedShare } from '@js/components/fixed_share';
import { isMobileOrTablet } from '@js/helpers/screen';

import '@js/translations';
import { getLocale } from '@js/helpers/navigation';

new SentryInstance();

const fixedShareOptions = {
    collapseText: Lang.get('js.fixed_share.collapsed_text'),
    titleText: Lang.get('js.fixed_share.title'),
    text: Lang.get('js.fixed_share.sub_title'),
};

const fixedShareLibOptions = {
    text: Lang.get('js.fixed_share.share_title'),
    shares: ['vkontakte', 'facebook', 'twitter', 'pinterest', 'telegram', 'whatsapp', 'viber'],
};

const locale = getLocale();
if (locale === 'en') {
    fixedShareLibOptions.shares = ['facebook', 'twitter', 'vkontakte', 'pinterest', 'telegram', 'whatsapp', 'viber'];
}

loadLazyloadImg();
loadStackGrid();
loadJQcloud();
initAds();

initHeaderMenu($('.header__menu'));
initFixedHeader($('header').first());

loadFancybox($('body').find('.fullscreen-image__link'));

$(function () {
    const fixedShareInstance = new FixedShare(fixedShareOptions, null, fixedShareLibOptions);
    fixedShareInstance.init();

    let backUpButtonElement = new backUpButton();
    backUpButtonElement.create();

    const $rateContainers = $('.rate-control');
    if ($rateContainers.length) {
        $rateContainers.each(function () {
            $(this).customRate('init');
        });
    }

    const $claimButtons = $('.claim-button');
    if ($claimButtons.length) {
        $claimButtons.each(function () {
            $(this).customClaim('init');
        });
    }

    if (!isMobileOrTablet()) {
        const $sidebar = $('.page-layout__share');
        if ($sidebar.length) {
            loadSidebar($sidebar);
        }
    }

    loadFixedShared();
    initArtControls($('.art-control'));

    $('.lang-switcher')
        .on('click', '.lang-switcher__option', function () {
            const selectedLocale = $(this).data('lang');
            let pathNameParts = window.location.pathname.split('/').filter(item => item);
            pathNameParts.shift();
            pathNameParts = [selectedLocale].concat(pathNameParts);
            const searchParams = window.location.search;
            let newURL = window.location.protocol + '//' + window.location.host;
            newURL += '/' + pathNameParts.join('/');
            if (searchParams) {
                newURL += searchParams;
            }
            window.location.href = newURL;
        });

});