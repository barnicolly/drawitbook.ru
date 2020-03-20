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
                        var data = $(self.artContainer).find('.claim-container').serialize();
                        sendRequest('post', '/art/' + self.artId + '/claim', data, function () {
                            $(self.artContainer).find('.cancel-claim').trigger('click');
                        })
                    }
                })
        }
    }

    function getClaimContainer() {
        var claimContainer = $('<form>', {class: 'claim-container form-group'});
        var wrapper = $('<div>', {class: 'list-group-item'});
        wrapper.append($('<p>').html('Помогите нам сделать проект лучше. Обращение обязательно будет рассмотрено модератором.'));
        wrapper.append($('<span>').html('Причина жалобы:'));
        var claimList = $('<div>', {class: 'claim-list form-group'});
        var sprClaim = {
            1: 'Оскорбление',
            2: 'Материал для взрослых',
            3: 'Пропаганда наркотиков',
            4: 'Насилие',
            5: 'Призыв к суициду',
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
        var submit = $('<button>', {type: 'button', class: 'btn btn-link submit-claim'}).html('Отправить');
        var cancel = $('<button>', {type: 'button', class: 'btn btn-link cancel-claim'}).html('Отменить');
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
