(function ($) {
    $.backUpButtonContainer = $.backUpButtonContainer || [];

    function backUpButtonContainer() {
        this.container = null;
        this.init = init.bind(this);

        var self = this;
        function init(container, params) {
            return new Promise((resolve) => {
                self.container = container;
                initListeners.call(this);
                self.config = $.extend(self.config, params);
                resolve(this.container);
            });
        }

        function checkScroll() {
            if ($(window).scrollTop() > 300) {
                self.container.addClass('show');
            } else {
                self.container.removeClass('show');
            }
        }

        function initListeners() {
            $(window).scroll(debounce(checkScroll, 150));

            this.container
                .on('click', function (e) {
                    e.preventDefault();
                    $('html, body').animate({scrollTop: 0}, '300');
                });
        }
    }

    var methods = {
        init: function (params = {}) {
            var backUpButtonContainerId;
            if (this.attr('id')) {
                backUpButtonContainerId = this.attr('id');
            } else {
                do {
                    var randomId = getRandomInt(1000000, 9999999);
                    var isset = typeof $.backUpButtonContainer[randomId] !== 'undefined';
                } while (isset);
                $(this).attr('id', randomId);
                backUpButtonContainerId = randomId;
            }
            $.backUpButtonContainer[backUpButtonContainerId] = new backUpButtonContainer();
            return $.backUpButtonContainer[backUpButtonContainerId].init(this, params);
        },
    };

    $.fn.backUpButton = function (method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            throw 'Метод ' + method + ' не найден';
        }
    };
})(jQuery);
