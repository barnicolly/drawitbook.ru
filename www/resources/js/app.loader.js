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
import {
    reachClickBtnExternalLink,
    reachClickBtnFindSimilar, reachClickBtnShareEmail, reachClickBtnShareFacebook, reachClickBtnSharePinterest,
    reachClickBtnShareTelegram, reachClickBtnShareTwitter, reachClickBtnShareViber,
    reachClickBtnShareVk, reachClickBtnShareWhatsapp,
} from '@js/components/ya_target';

new SentryInstance();

loadLazyloadImg();
loadStackGrid();
loadJQcloud();
initAds();

initHeaderMenu($('.header__menu'));
initFixedHeader($('header').first());

loadFancybox();

$(function () {
    let backUpButtonElement = new backUpButton();
    backUpButtonElement.create();

    const $rateContainers = $('.rate-container');
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

    loadFixedShared();
    loadSidebar();

    $('.stack-grid__external-link a').on('click', reachClickBtnExternalLink);
    $('.find-similar a').on('click', reachClickBtnFindSimilar);

    $('body')
        .on('click', '.jssocials-share-vkontakte a', reachClickBtnShareVk)
        .on('click', '.jssocials-share-telegram a', reachClickBtnShareTelegram)
        .on('click', '.jssocials-share-twitter a', reachClickBtnShareTwitter)
        .on('click', '.jssocials-share-facebook a', reachClickBtnShareFacebook)
        .on('click', '.jssocials-share-pinterest a', reachClickBtnSharePinterest)
        .on('click', '.jssocials-share-whatsapp a', reachClickBtnShareWhatsapp)
        .on('click', '.jssocials-share-viber a', reachClickBtnShareViber)
        .on('click', '.jssocials-share-email a', reachClickBtnShareEmail)
});
