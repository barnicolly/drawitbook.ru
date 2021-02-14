import { getRandomInt, sendRequest } from '@js/helpers/utils';

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

            $('html, body').animate({
                scrollTop: $(self.artContainer).find('.title').offset().top
            }, 'fast');
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
                        const data = $(self.artContainer).find('.claim-container').serialize();
                        sendRequest('post', '/arts/' + self.artId + '/claim', data, function () {
                            $(self.artContainer).find('.cancel-claim').trigger('click');
                        })
                    }
                })
        }
    }

    function getClaimContainer() {
        var claimContainer = $('<form>', {class: 'claim-container form-group'});
        var wrapper = $('<div>', {class: 'list-group-item'});
        wrapper.append($('<p>').html(Lang.get('js.claim.title')));
        wrapper.append($('<span>').html(Lang.get('js.claim.subtitle')));
        var claimList = $('<div>', {class: 'claim-list form-group'});
        var sprClaim = {
            1: Lang.get('js.claim.spr.1'),
            2: Lang.get('js.claim.spr.2'),
            3: Lang.get('js.claim.spr.3'),
            4: Lang.get('js.claim.spr.4'),
            5: Lang.get('js.claim.spr.5'),
        };
        for (var claimIndex in sprClaim) {
            var radio = $('<div>', {class: 'radio'});
            var label = $('<label>');
            if (claimIndex == 1) {
                label.append($('<input>', {type: 'radio', name: 'reason', value: claimIndex}).prop('checked', true));
            } else {
                label.append($('<input>', {type: 'radio', name: 'reason', value: claimIndex}));
            }
            label.append('&nbsp;');
            label.append(sprClaim[claimIndex]);
            radio.append(label);
            claimList.append(radio);
        }
        wrapper.append(claimList);
        const submitButtonText = Lang.get('js.claim.submit.text');
        const cancelButtonText = Lang.get('js.claim.cancel.text');
        var submit = $('<button>', {type: 'button', class: 'btn btn-link submit-claim'}).html(submitButtonText);
        var cancel = $('<button>', {type: 'button', class: 'btn btn-link cancel-claim'}).html(cancelButtonText);
        wrapper.append(submit);
        wrapper.append(cancel);
        claimContainer.append(wrapper);
        return claimContainer;
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
