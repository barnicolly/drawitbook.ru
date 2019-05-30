(function ($) {
    $.artControlContainer = $.artControlContainer || [];

    function artControlContainer() {
        var self = this;
        self.container = null;
        self.dropdownContainer = null;
        self.iconsContainer = null;
        self.artId = null;
        self.params = {
            vkPosting: false,
        };

        self.init = function (container, params) {
            return new Promise((resolve) => {
                self.container = container;
                self.iconsContainer = container.find('.art-control-icons');
                self.dropdownContainer = container.find('.art-control-dropdown');
                self.artId = $(container).closest('.admin-panel').data('picture-id');
                getInicialIconStatus();
                addDropdowns();
                initListeners();
                resolve(self.container);
            });
        };

        function getInicialIconStatus() {
            if (self.iconsContainer.find('.vk-posting').length) {
                self.params.vkPosting = true;
            }
        }

        function addVkPostingIcon() {
            var icon = $('<span>', {class: 'vk-posting fa fa-vk', title: 'Постинг в VK'});
            self.iconsContainer.append(icon);
        }

        function removeVkPostingIcon() {
            self.iconsContainer.find('.vk-posting').remove();
        }

        function initListeners() {
            $(self.dropdownContainer).on('click', '.art-control-vk-posting', function () {
                var data = {
                    id: self.artId,
                };
                var button = $(this);
                if (self.params.vkPosting) {
                    sendRequest('post', '/admin/art/setVkPostingOff', data, function (res) {
                        if (res.success) {
                            button.text('Постить в ВК');
                            self.params.vkPosting = false;
                            removeVkPostingIcon();
                        }
                    });
                } else {
                    sendRequest('post', '/admin/art/setVkPostingOn', data, function (res) {
                        if (res.success) {
                            button.text('Не постить в ВК');
                            self.params.vkPosting = true;
                            addVkPostingIcon();
                        }
                    });
                }
            });
            $(self.container).on('click', '.picture-settings', function () {
                sendRequest('get', '/admin/art/' + self.artId + '/getSettingsModal', {}, function (res) {
                    if (res.success) {
                        var modal = new NewModal(res.data);
                        var modalHTML = modal.showModal();
                        modalHTML
                            .on('click', '.add-to-vk-album', function () {
                                var button = $(this);
                                var data = {
                                   'album_id': $(this).closest('tr').data('vk-album-id'),
                                };
                                sendRequest('post', '/admin/art/' + self.artId + '/postInVkAlbum', data, function (res) {
                                    if (res.success) {
                                        button.removeClass('add-to-vk-album')
                                            .addClass('remove-from-vk-album')
                                            .text('Убрать из альбома')
                                    } else {
                                        showInfo(res.message);
                                    }
                                });
                            })
                    } else {
                        showInfo(res.message);
                    }
                });

            })
        }

        function addDropdowns() {
            // <button type="button"
            // class="art-control-vk-posting btn btn-link dropdown-item"
            //     data-vk-posted="<?= $picture->in_vk_posting === IN_VK_POSTING ?>">
            //         Добавить в постинг в ВК
            //     </button>

            // if ()
            var vkPostingButton = $('<button>',
                {
                    type: 'button',
                    class: 'art-control-vk-posting btn btn-link dropdown-item',
                    'data-vk-posted': self.params.vkPosting
                }).text((!self.params.vkPosting ? 'Постить' : 'Не постить') + ' в ВК');
            self.dropdownContainer.find('.dropdown-menu').append(vkPostingButton);
        }
    }

    var methods = {
        init: function (params = {}) {
            var artControlContainerId;
            if (this.attr('id')) {
                artControlContainerId = this.attr('id');
            } else {
                do {
                    var randomId = getRandomInt(1000000, 9999999);
                    var isset = typeof $.artControlContainer[randomId] !== 'undefined';
                } while (isset);
                $(this).attr('id', randomId);
                artControlContainerId = randomId;
            }
            $.artControlContainer[artControlContainerId] = new artControlContainer();
            return $.artControlContainer[artControlContainerId].init(this, params);
        },
    };

    $.fn.customArtControl = function (method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            throw 'Метод ' + method + ' не найден';
        }
    };
})(jQuery);
