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

new SentryInstance();

const fixedShareOptions = {
    collapseText: 'Лучшая благодарность',
    titleText: 'Лучшая благодарность',
    text: 'Простой репост сайта в соц. сети очень поможет нам. Спасибо.',
};

loadLazyloadImg();
loadStackGrid();
loadJQcloud();
initAds();

initHeaderMenu($('.header__menu'));
initFixedHeader($('header').first());

loadFancybox($('body').find('.fullscreen-image__link'));

$(function () {
    const fixedShareInstance = new FixedShare(fixedShareOptions);
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
    loadSidebar($('.sidebar'));
    initArtControls($('.art-control'));


});
