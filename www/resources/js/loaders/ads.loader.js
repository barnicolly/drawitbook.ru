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
                'in_sidebar': 'R-A-400272-1',
                'after_detail_picture': 'R-A-400272-2',
                'before_stack': 'R-A-400272-4',
                'after_first_stack': 'R-A-400272-7',
            };
        } else {
            configurations = {
                'after_detail_picture': 'R-A-400272-3',
                'before_stack': 'R-A-400272-5',
                'after_first_stack': 'R-A-400272-6',
            };
        }
        const failovers = {};
        return {configurations, failovers};
    }
}

export function initStackGridAds($stackGrid) {
    const $monPlaces = $stackGrid.find('.mon-place[data-integrated="true"]');

    if ($monPlaces.length) {
        const {configurations, failovers} = getConfigurations();
        initWatcher($monPlaces, configurations, failovers, true);
    }

    function getConfigurations() {
        const bvw = getScreenWidth();
        let configurations = {};
        if (bvw >= 768) {
            configurations = {
                'integrated-5': 'R-A-400272-8',
                'integrated-12': 'R-A-400272-9',
                'integrated-18': 'R-A-400272-10',
                'in_stack_arts_last': 'R-A-400272-21',
            };
        } else {
            configurations = {
                'integrated-5': 'R-A-400272-18',
                'integrated-12': 'R-A-400272-19',
                'integrated-18': 'R-A-400272-20',
                'in_stack_arts_last': 'R-A-400272-22',
            };
        }
        const failovers = {};
        return {configurations, failovers};
    }
}

function initWatcher($monPlaces, configurations, failovers, needResize = false) {
    const mapPlaces = {};
    $monPlaces.each(function () {
        const id = $(this).attr('id');
        mapPlaces[id] = false;
    });
    const scrollEvent = function () {
        Object.keys(mapPlaces).forEach(id => {
            const placeLoaded = mapPlaces[id];
            const $place = $(`#${id.replace('.', '\\.')}`);
            const isDummy = $place.hasClass('dummy');
            if (!placeLoaded && isOnScreen($place, 500)) {
                mapPlaces[id] = true;
                $place.attr('data-loaded', true);
                if (!isDummy) {
                    if (typeof configurations[id] !== 'undefined') {
                        let failover = typeof failovers[id] !== 'undefined'
                            ? failovers[id]
                            : null;

                        const failoverCallback = () => {
                            const $wrapper = $('<ins>', failover);
                            $place.append($wrapper);
                        }

                        (function (w, d, n, s, t) {
                            w[n] = w[n] || [];
                            w[n].push(function () {
                                Ya.Context.AdvManager.render({
                                    blockId: configurations[id],
                                    renderTo: id,
                                    async: true,
                                    onRender: function (data) {
                                        const $stackGrid = $place.closest('.stack-grid');
                                        const screenWidth = getScreenWidth();
                                        if ($stackGrid.length && $stackGrid.attr('data-loaded') !== 'true' && screenWidth >= 700) {
                                            initStackGrid($stackGrid);
                                        }
                                    }
                                }, failover !== null ? failoverCallback : null);
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
        const stayNotLoadedPlaces = Object.keys(mapPlaces).filter(id => {
            return !mapPlaces[id];
        });
        if (!stayNotLoadedPlaces.length) {
            $(window).off('scroll', scrollEventThrottled);
        }
    };
    const scrollEventThrottled = throttle(scrollEvent, 150);

    scrollEvent();
    $(window).on('scroll', scrollEventThrottled);
}
