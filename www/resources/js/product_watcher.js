import {
    reachClickBtnExternalLink,
    reachClickBtnRate,
    reachClickDownloadMoreBtn,
    reachClickSharePageFromFixedBar,
    reachClickTagItem,
} from '@js/components/ya_target';

$('body')
    .on('click', '.stack-grid__external-link a', reachClickBtnExternalLink)
    .on('click', '.tag-list a', reachClickTagItem)
    .on('click', '.rate-button', reachClickBtnRate)
    .on('click', '.download-more__btn', reachClickDownloadMoreBtn)
    //social
    .on('click', '.fixed-shared-block .jssocials-share a', reachClickSharePageFromFixedBar);
