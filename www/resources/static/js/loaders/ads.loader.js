import { isMobileOrTablet } from '@js/helpers/screen';
import YandexLoader from '@js/loaders/ads/yandex';
import {getYandexStackGridAds, getYandexStackLayoutAds} from '@js/loaders/ads/yandex_configurations';
import { getLocale } from '@js/helpers/navigation';

export function initAds() {
    const locale = getLocale();
    const $monPlaces = $('body').find('.mon-place[data-loaded="false"]');
    if ($monPlaces.length) {
        const mobileOrTablet = isMobileOrTablet();
        const yandexConfigurations = getYandexStackLayoutAds(mobileOrTablet);
        const ads = getAdsLoaders(locale, $monPlaces, yandexConfigurations);
        ads.forEach(function (instance) {
            instance.init();
        });
    }
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
