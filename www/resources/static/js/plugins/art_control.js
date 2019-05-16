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

        /*  function lockClaimButton() {
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
          }*/

        /* function initListeners() {
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
         }*/
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
