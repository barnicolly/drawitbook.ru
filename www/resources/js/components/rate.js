import { getRandomInt, sendRequest } from '@js/helpers/utils';
import { getApplyedLocaleLink } from '@js/helpers/navigation';

(function ($) {
    $.rateContainer = $.rateContainer || [];
    var routes = {
        like: getApplyedLocaleLink('/arts/{id}/like'),
        dislike: getApplyedLocaleLink('/arts/{id}/dislike'),
    };

    function rateContainer() {
        var self = this;
        self.container = null;
        self.artId = null;

        self.init = function (container, params) {
            return new Promise((resolve) => {
                self.container = container;
                self.artId = container.data('id');
                initListeners();
                self.config = $.extend(self.config, params);
                resolve(self.container);
            });
        };

        function initListeners() {
            self.container
                .on('click', '.rate-control__btn', lockRateButtons)
                .on('click', '.like', function () {
                    like($(this));
                })
                .on('click', '.dislike', function () {
                    dislike($(this));
                });
        }

        function lockRateButtons() {
            self.container.find('.rate-control__btn')
                .prop('disabled', true);
        }

        function unlockRateButtons() {
            self.container.find('.rate-control__btn')
                .prop('disabled', false);
        }

        function like(button) {
            var route = routes.like.replace('{id}', self.artId);
            fetch(button, route);
        }

        function dislike(button) {
            var route = routes.dislike.replace('{id}', self.artId);
            fetch(button, route);
        }

        function fetch(button, route) {
            let activeOff = $(button).hasClass('rate-control__btn--active');
            sendRequest('post', route, {off: activeOff}, function (res) {
                unlockRateButtons();
                if (res.success) {
                    if (!activeOff) {
                        self.container.find('.rate-control__btn').removeClass('rate-control__btn--active');
                        $(button).addClass('rate-control__btn--active');
                    } else {
                        $(button).removeClass('rate-control__btn--active');
                    }
                }
            });
        }
    }

    var methods = {
        init: function (params = {}) {
            var rateContainerId;
            if (this.attr('id')) {
                rateContainerId = this.attr('id');
            } else {
                do {
                    var randomId = getRandomInt(1000000, 9999999);
                    var isset = typeof $.rateContainer[randomId] !== 'undefined';
                } while (isset);
                $(this).attr('id', randomId);
                rateContainerId = randomId;
            }
            $.rateContainer[rateContainerId] = new rateContainer();
            return $.rateContainer[rateContainerId].init(this, params);
        },
    };

    $.fn.customRate = function (method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            throw 'Метод ' + method + ' не найден';
        }
    };
})(jQuery);
