import {isOnScreen} from '@js/helpers/dom';
import throttle from 'lodash/throttle';
import { getScreenWidth } from '@js/helpers/screen';
import { initStackGrid } from '@js/components/stack_grid';

export function initAds() {
    const $monPlaces = $('body').find('.mon-place[data-integrated="false"]');

    if ($monPlaces.length) {
        const {configurations, failovers} = getConfigurations();
        initWatcher($monPlaces, configurations, failovers);
    }

    function getConfigurations() {
        const bvw = getScreenWidth();
        let configurations = {};
        if (bvw >= 993) {
            configurations = {
                'sidebar': 'R-A-734726-1',
                'after_detail_picture': 'R-A-734726-2',
                'before_stack': 'R-A-734726-4',
                'after_first_stack': 'R-A-734726-7',
            };
        } else {
            configurations = {
                'after_detail_picture': 'R-A-734726-3',
                'before_stack': 'R-A-734726-5',
                'after_first_stack': 'R-A-734726-6',
            };
        }
        let client = 'ca-pub-1368141699085758';
        const failovers = {
        /*    'after_detail_picture': {
                'class': 'adsbygoogle',
                'data-ad-client': client,
                'data-ad-slot': '6153216946',
                'data-full-width-responsive': 'true',
                'data-ad-format': 'auto',
                'style': 'display: block',
            },
            'before_stack': {
                'class': 'adsbygoogle',
                'data-ad-client': client,
                'data-ad-slot': '1076984235',
                'data-full-width-responsive': 'true',
                'data-ad-format': 'auto',
                'style': 'display: block',
            },
            'after_first_stack': {
                'class': 'adsbygoogle',
                'data-ad-client': client,
                'data-ad-slot': 'draw_after_stack',
                'data-full-width-responsive': 'true',
                'data-ad-format': 'auto',
                'style': 'display: block',
            },*/
        }
        return {configurations, failovers};
    }
}

export function initStackGridAds($stackGrid, pageNumber = 1) {
    const $monPlaces = $stackGrid.find('.mon-place[data-integrated="true"][data-loaded="false"]');
    if ($monPlaces.length) {
        const {configurations, failovers} = getConfigurations();
        initWatcher($monPlaces, configurations, failovers, pageNumber);
    }

    function getConfigurations() {
        const bvw = getScreenWidth();
        let configurations = {};
        if (bvw >= 768) {
            configurations = {
                'integrated-5': 'R-A-734726-11',
                'integrated-12': 'R-A-734726-12',
                'integrated-18': 'R-A-734726-13',
                'in_stack_arts_last': 'R-A-734726-14',
            };
        } else {
            configurations = {
                'integrated-5': 'R-A-734726-8',
                'integrated-12': 'R-A-734726-9',
                'integrated-18': 'R-A-734726-10',
                'in_stack_arts_last': 'R-A-734726-15',
            };
        }
        let client = 'ca-pub-1368141699085758';
        const failovers = {
            /*'integrated-5': {
                'class': 'adsbygoogle',
                'data-ad-client': client,
                'data-ad-slot': '6776690019',
                'data-full-width-responsive': 'true',
                'data-ad-format': 'auto',
                'style': 'display: block',
            },
            'integrated-12': {
                'class': 'adsbygoogle',
                'data-ad-client': client,
                'data-ad-slot': '6776690019',
                'data-full-width-responsive': 'true',
                'data-ad-format': 'auto',
                'style': 'display: block',
            },
            'integrated-18': {
                'class': 'adsbygoogle',
                'data-ad-client': client,
                'data-ad-slot': '6776690019',
                'data-full-width-responsive': 'true',
                'data-ad-format': 'auto',
                'style': 'display: block',
            },
            'in_stack_arts_last': {
                'class': 'adsbygoogle',
                'data-ad-client': client,
                'data-ad-slot': '6776690019',
                'data-full-width-responsive': 'true',
                'data-ad-format': 'auto',
                'style': 'display: block',
            },*/
        }
        return {configurations, failovers};
    }
}

function initWatcher($monPlaces, configurations, failovers, pageNumber) {
    const scrollEvent = function () {
        $monPlaces.each(function () {
            const $place = $(this);
            const id = $place.attr('id');
            const placeLoaded = $place.attr('data-loaded') === 'true';
            const configurationKey = $place.attr('data-configuration-key');
            const isDummy = $place.hasClass('dummy');
            if (!placeLoaded && isOnScreen($place, 500)) {
                $place.attr('data-loaded', true);
                if (!isDummy) {
                    if (typeof configurations[configurationKey] !== 'undefined') {
                        let failover = typeof failovers[configurationKey] !== 'undefined'
                            ? failovers[configurationKey]
                            : null;

                        const failoverCallback = () => {
                            const $wrapper = $('<ins>', failover);
                            $place.append($wrapper);

                            if (typeof window.adsbygoogle !== 'undefined') {
                                (adsbygoogle = window.adsbygoogle || []).push({});
                            }
                        }
                        const renderOptions = {
                            blockId: configurations[configurationKey],
                            renderTo: id,
                            async: true,
                            onRender: function (data) {
                                const $stackGrid = $place.closest('.stack-grid');
                                const screenWidth = getScreenWidth();
                                if ($stackGrid.length && $stackGrid.attr('data-loaded') !== 'true' && screenWidth >= 700) {
                                    initStackGrid($stackGrid);
                                }
                            }
                        };

                        if (typeof pageNumber !== 'undefined') {
                            renderOptions.pageNumber = pageNumber;
                        }

                        (function (w, d, n, s, t) {
                            w[n] = w[n] || [];
                            w[n].push(function () {
                                Ya.Context.AdvManager.render(renderOptions, failover !== null ? failoverCallback : null);
                            });
                            t = d.getElementsByTagName('script')[0];
                            s = d.createElement('script');
                            s.type = 'text/javascript';
                            s.src = '//an.yandex.ru/system/context.js';
                            s.async = true;
                            t.parentNode.insertBefore(s, t);
                        })(window, window.document, 'yandexContextAsyncCallbacks');
                    }
                }
            }
        });
        const $stayNotLoadedPlaces = $monPlaces.filter(function () {
           return $(this).attr('data-loaded') === 'false';
        });
        if (!$stayNotLoadedPlaces.length) {
            $(window).off('scroll', scrollEventThrottled);
        }
    };
    const scrollEventThrottled = throttle(scrollEvent, 150);

    scrollEvent();
    $(window).on('scroll', scrollEventThrottled);
}
