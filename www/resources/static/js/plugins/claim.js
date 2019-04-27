(function ($) {
    $.claimContainer = $.claimContainer || [];

    function claimContainer() {
        var self = this;
        self.container = null;
        self.artContainer = null;
        self.artId = null;

        self.init = function (container, params) {
            return new Promise((resolve) => {
                self.container = container;
                self.artContainer = $(container).closest('.art-container');
                self.art = $(container).closest('.art-container').find('.art');
                self.artId = container.data('id');
                initListeners();
                resolve(self.container);
            });
        };

        function lockClaimButton() {
            self.container.prop('disabled', true);
        }

        function unlockClaimButton() {
            self.container.prop('disabled', false);
        }

        function showClaimForm() {
            $(self.art).after(getClaimContainer());
        }

        function initListeners() {
            self.container
                .on('click', function () {
                    lockClaimButton();
                    if (!$(self.artContainer).find('.claim-container').length) {
                        self.art.hide();
                        showClaimForm();
                    }
                });
            self.artContainer
                .on('click', '.cancel-claim', function () {
                    self.art.show();
                    unlockClaimButton();
                    $(self.artContainer).find('.claim-container').remove();
                })
                .on('click', '.submit-claim', function () {
                    if ($(self.artContainer).find('.claim-container').length) {
                        var data = $(self.artContainer).find('.claim-container').serialize();
                        sendRequest('post', '/art/claim/' + self.artId, data, function () {
                            $(self.artContainer).find('.cancel-claim').trigger('click');
                        })
                    }
                })
        }
    }

    var methods = {
        init: function (params = {}) {
            var claimContainerId;
            if (this.attr('id')) {
                claimContainerId = this.attr('id');
            } else {
                do {
                    var randomId = getRandomInt(1000000, 9999999);
                    var isset = typeof $.claimContainer[randomId] !== 'undefined';
                } while (isset);
                $(this).attr('id', randomId);
                claimContainerId = randomId;
            }
            $.claimContainer[claimContainerId] = new claimContainer();
            return $.claimContainer[claimContainerId].init(this, params);
        },
    };

    $.fn.customClaim = function (method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            throw 'Метод ' + method + ' не найден';
        }
    };
})(jQuery);
