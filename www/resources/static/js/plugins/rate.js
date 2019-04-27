(function ($) {
    $.rateContainer = $.rateContainer || [];
    var routes = {
        like: '/art/like/',
        dislike: '/art/dislike/',
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
                .on('click', '.rate-button', lockRateButtons)
                .on('click', '.like', function () {
                    like($(this));
                })
                .on('click', '.dislike', function () {
                    dislike($(this));
                });
        }

        function lockRateButtons() {
            self.container.find('.rate-button')
                .prop('disabled', true);
        }

        function unlockRateButtons() {
            self.container.find('.rate-button')
                .prop('disabled', false);
        }

        function like(button) {
            fetch(button, routes.like);
        }

        function dislike(button) {
            fetch(button, routes.dislike);
        }

        function fetch(button, route) {
            let activeOff = $(button).hasClass('active');
            sendRequest('post', route + self.artId, {off: activeOff}, function (res) {
                unlockRateButtons();
                if (res.success) {
                    if (!activeOff) {
                        self.container.find('.rate-button').removeClass('active');
                        $(button).addClass('active');
                    } else {
                        $(button).removeClass('active');
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
