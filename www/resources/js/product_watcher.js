import {
    reachClickBtnExternalLink,
    reachClickBtnFindSimilar,
    reachClickBtnRate, reachClickBtnShareEmail,
    reachClickBtnShareFacebook, reachClickBtnSharePinterest,
    reachClickBtnShareTelegram,
    reachClickBtnShareTwitter, reachClickBtnShareViber,
    reachClickBtnShareVk, reachClickBtnShareWhatsapp,
    reachClickTagItem,
} from '@js/components/ya_target';

$('body')
    .on('click', '.stack-grid__external-link a', reachClickBtnExternalLink)
    .on('click', '.fullscreen-image__find-similar a', reachClickBtnFindSimilar)
    .on('click', '.tag-list a', reachClickTagItem)
    .on('click', '.rate-button', reachClickBtnRate)
    //social
    .on('click', '.jssocials-share-vkontakte a', reachClickBtnShareVk)
    .on('click', '.jssocials-share-telegram a', reachClickBtnShareTelegram)
    .on('click', '.jssocials-share-twitter a', reachClickBtnShareTwitter)
    .on('click', '.jssocials-share-facebook a', reachClickBtnShareFacebook)
    .on('click', '.jssocials-share-pinterest a', reachClickBtnSharePinterest)
    .on('click', '.jssocials-share-whatsapp a', reachClickBtnShareWhatsapp)
    .on('click', '.jssocials-share-viber a', reachClickBtnShareViber)
    .on('click', '.jssocials-share-email a', reachClickBtnShareEmail);
