import { isOnScreen } from '@js/helpers/dom';
import throttle from 'lodash/throttle';
import { getScreenWidth, isMobileOrTablet } from '@js/helpers/screen';
import { initStackGrid } from '@js/components/stack_grid';
import AdsenseLoader from '@js/loaders/ads/adsense';
import YandexLoader from '@js/loaders/ads/yandex';
import { getEnAdsenseStackLayoutAds, getRuAdsenseStackLayoutAds } from '@js/loaders/ads/adsense_configurations';
import { getYandexStackGridAds, getYandexStackLayoutAds } from '@js/loaders/ads/yandex_configurations';
import { getLocale } from '@js/helpers/navigation';

export function initAds() {
    const locale = getLocale();
    const $monPlaces = $('body').find('.mon-place[data-loaded="false"]');
    if ($monPlaces.length) {
        const mobileOrTablet = isMobileOrTablet();
        const yandexConfigurations = getYandexStackLayoutAds(mobileOrTablet);
        const adsenseConfigurations = locale === 'ru'
            ? getRuAdsenseStackLayoutAds(mobileOrTablet)
            : getEnAdsenseStackLayoutAds(mobileOrTablet);
        const ads = getAdsLoaders(locale, $monPlaces, yandexConfigurations, adsenseConfigurations);
        ads.forEach(function (instance) {
            instance.init();
        });
    }
}

function getAdsLoaders(locale, $monPlaces, yandexConfigurations, adsenseConfigurations) {
    const ads = [];
    $monPlaces.each(function () {
        const configurationKey = $(this).attr('data-configuration-key');
        if (typeof yandexConfigurations[configurationKey] !== 'undefined' && locale === 'ru') {
            const failOverOptions = typeof adsenseConfigurations[configurationKey] !== 'undefined'
                ? adsenseConfigurations[configurationKey]
                : null;
            let failOverCallback = () => {
            };
            if (failOverOptions !== null) {
                failOverCallback = () => {
                    const instance = new AdsenseLoader($(this), window, failOverOptions);
                    instance.init();
                };
            }
            const renderOptions = yandexConfigurations[configurationKey];
            const instance = new YandexLoader($(this), window, renderOptions, failOverCallback);
            ads.push(instance);
        } else {
            const failOverOptions = typeof adsenseConfigurations[configurationKey] !== 'undefined'
                ? adsenseConfigurations[configurationKey]
                : null;
            if (failOverOptions !== null) {
                const instance = new AdsenseLoader($(this), window, failOverOptions);
                ads.push(instance);
            }
        }
    });
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
        const adsenseConfigurations = locale === 'ru'
            ? getRuAdsenseStackLayoutAds(mobileOrTablet)
            : getEnAdsenseStackLayoutAds(mobileOrTablet);
        const ads = getAdsLoaders(locale, $monPlaces, yandexConfigurations, adsenseConfigurations);
        ads.forEach(function (instance) {
            instance.init();
        });
    }
}
