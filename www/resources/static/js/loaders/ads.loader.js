import { isMobileOrTablet } from '@js/helpers/screen';
import YandexLoader from '@js/loaders/ads/yandex';
import {getYandexStackGridAds} from '@js/loaders/ads/yandex_configurations';
import { getLocale } from '@js/helpers/navigation';

export function initAds() {
    const $monPlaces = $('body').find('.mon-place');
    if ($monPlaces.length) {

        const timerId = setInterval(() => {
            if (typeof Ya !== 'undefined' && typeof window.yaContextCb !== 'undefined') {
                tryInitLandingAds();
                tryInitDetailsAds();
                clearInterval(timerId);
            }
        }, 200);

        loadScript();
    }
}

function tryInitLandingAds() {
    const mobileOrTablet = isMobileOrTablet();
    if ($('body').find('#before_stack:not(.dummy)').length) {
        if (mobileOrTablet) {
            window.yaContextCb.push(()=>{
                Ya.adfoxCode.createScroll({
                    ownerId: 281565,
                    containerId: 'before_stack',
                    params: {
                        pp: 'cidf',
                        ps: 'euiz',
                        p2: 'hcsy'
                    }
                })
            })
        } else {
            window.yaContextCb.push(()=>{
                Ya.adfoxCode.createScroll({
                    ownerId: 281565,
                    containerId: 'before_stack',
                    params: {
                        pp: 'cidg',
                        ps: 'euiz',
                        p2: 'hcsx'
                    }
                })
            })
        }
    }

    if ($('body').find('#after_first_stack:not(.dummy)').length) {
        if (mobileOrTablet) {
            window.yaContextCb.push(()=>{
                Ya.adfoxCode.createScroll({
                    ownerId: 281565,
                    containerId: 'after_first_stack',
                    params: {
                        pp: 'cidd',
                        ps: 'euiz',
                        p2: 'hcsy'
                    }
                })
            })
        } else {
            window.yaContextCb.push(()=>{
                Ya.adfoxCode.createScroll({
                    ownerId: 281565,
                    containerId: 'after_first_stack',
                    params: {
                        pp: 'cide',
                        ps: 'euiz',
                        p2: 'hcsx'
                    }
                })
            })
        }
    }
}

function tryInitDetailsAds() {
    const mobileOrTablet = isMobileOrTablet();
    if ($('body').find('#after_detail_picture:not(.dummy)').length) {
        if (mobileOrTablet) {
            window.yaContextCb.push(()=>{
                Ya.adfoxCode.createScroll({
                    ownerId: 281565,
                    containerId: 'after_detail_picture',
                    params: {
                        pp: 'cidc',
                        ps: 'euiz',
                        p2: 'hcsy'
                    }
                })
            })
        } else {
            window.yaContextCb.push(()=>{
                Ya.adfoxCode.createScroll({
                    ownerId: 281565,
                    containerId: 'after_detail_picture',
                    params: {
                        pp: 'cidb',
                        ps: 'euiz',
                        p2: 'hcsx'
                    }
                })
            })
        }
    }

    if ($('body').find('#sidebar:not(.dummy)').length) {
        if (!mobileOrTablet) {
            window.yaContextCb.push(()=>{
                Ya.adfoxCode.createScroll({
                    ownerId: 281565,
                    containerId: 'sidebar',
                    params: {
                        pp: 'cida',
                        ps: 'euiz',
                        p2: 'hcsx'
                    }
                })
            })
        }
    }
}

function loadScript() {
    const scriptCounter = document.createElement('script');
    scriptCounter.innerHTML = 'window.yaContextCb = window.yaContextCb || []';
    document.head.appendChild(scriptCounter);
    const scriptContext = document.createElement('script');
    scriptContext.src = 'https://yandex.ru/ads/system/context.js';
    scriptContext.async = true;
    document.head.appendChild(scriptContext);
}

function getAdsLoaders(locale, $monPlaces, yandexConfigurations) {
    const ads = [];
    if (locale === 'ru') {
        $monPlaces.each(function () {
            const configurationKey = $(this).attr('data-configuration-key');
            if (typeof yandexConfigurations[configurationKey] !== 'undefined') {
                let failOverCallback = () => {
                };
                const renderOptions = yandexConfigurations[configurationKey];
                const instance = new YandexLoader($(this), window, renderOptions, failOverCallback);
                ads.push(instance);
            }
        });
    }
    return ads;
}

export function initStackGridAds($stackGrid, pageNumber = 1) {
    const locale = getLocale();
    const $monPlaces = $stackGrid.find('.mon-place[data-loaded="false"]');
    if ($monPlaces.length) {
        const mobileOrTablet = isMobileOrTablet();
        const yandexConfigurations = getYandexStackGridAds(mobileOrTablet);
        Object.keys(yandexConfigurations).forEach(function (objectKey) {
            yandexConfigurations[objectKey].pageNumber = pageNumber;
        });
        const ads = getAdsLoaders(locale, $monPlaces, yandexConfigurations);
        ads.forEach(function (instance) {
            instance.init();
        });
    }
}
