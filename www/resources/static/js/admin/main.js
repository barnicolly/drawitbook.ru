function showInfo(message) {
    alert(message);
}

function sendRequest(type, url, data, callback) {
    return $.ajax({
        type: type,
        url: url,
        dataType: 'json',
        data: data,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response, textStatus, jqXHR) {
            if (callback) {
                callback.call(self, response);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            showInfo('Произошла ошибка на стороне сервера');
        }
    });
}

$(function () {
    $('body').on('click', '.add-tag', function () {
        var tagsContainer = $(this).closest('td').find('.tags');
        createTagContainer(createTagContainer(tagsContainer));
    });

    function createTagContainer(tagsContainer, content = '') {
        var div = $('<div>').attr({
            class: 'tag form-group input-group',
        });

        $('<input>').attr({
            type: 'text',
            class: 'form-control',
            value: content,
        }).appendTo(div);

        var group = $('<div>').attr({
            class: 'input-group-btn',
        });

        var button = $('<button>').attr({
            type: 'button',
            class: 'btn btn-danger delete-tag input-group-append',
        });

        $('<span>').attr({
            class: 'fa fa-trash',
        }).appendTo(button);

        button.appendTo(group);
        group.appendTo(div);
        div.appendTo(tagsContainer);
        if (!content) {
            $(tagsContainer).find('.tag:last input').focus();
        }
    }

    $('body')
        .on('click', '.delete-tag', function () {
            $(this).closest('.tag').remove();
        })
        .on('click', '.checkbox-padding', function () {
            $(this).find('.selected').prop('checked', !$(this).find('.selected').prop('checked'));
        })
        .on('click', '.delete-selected', function () {
            if ($('.moderate-table .selected:checked').length) {
                var data = {
                    ids: []
                };
                $('.moderate-table .selected:checked').each(function () {
                    var closestRow = $(this).closest('tr');
                    data.ids.push($(closestRow).attr('data-id'))
                });
                sendRequest('post', '/admin/moderate/delete_images', data, function (res) {
                    if (res.success) {
                        $('.moderate-table .selected:checked').each(function () {
                            var closestRow = $(this).closest('tr');
                            $(closestRow).remove();
                        });
                    } else {
                        showInfo(res.message);
                    }
                })
            }
        })
        .on('click', '.unselect-all', function () {
            $('.moderate-table .selected:checked').prop('checked', false);
            $('.operation-with-selected').hide();
        })
        .on('click', '.select-all', function () {
            $('.moderate-table .selected').prop('checked', true);
            $('.operation-with-selected').show();
        })
        .on('change', '.selected', function () {
            if ($('.moderate-table .selected:checked').length) {
                $('.operation-with-selected').show();
            } else {
                $('.operation-with-selected').hide();
            }
        })
        .on('click', '.copyToClipboard', function () {
            var content = $(this).closest('tr').find('.content').text();
            if ($('.moderate-table .selected:checked').length) {
                $('.moderate-table .selected:checked').each(function () {
                    var closestRow = $(this).closest('tr');
                    var itHas = false;
                    var emptyRow = null;
                    $(closestRow).find('.tag').each(function () {
                        var tag = $(this).find('input');
                        if ($(tag).val() && $(tag).val() === content) {
                            itHas = true;
                        } else {
                            if (!$(tag).val() && emptyRow === null) {
                                emptyRow = $(tag);
                            }
                        }
                    });
                    if (!itHas) {
                        if (emptyRow !== null) {
                            emptyRow.val(content);
                        } else {
                            createTagContainer($(closestRow).find('.tags'), content);
                        }
                    }
                });
                $('.unselect-all').trigger('click');
            }
            var dt = new clipboard.DT();
            dt.setData("text/plain", content);
            clipboard.write(dt);
        })
        .on('click', '.refresh-page', function () {
            window.location.reload();
        })
        .on('click', '.delete-image', function () {
            var row = $(this).closest('tr');
            sendRequest('post', '/admin/moderate/delete_image', {id: row.data('id')}, function (res) {
                if (res.success) {
                    row.remove();
                } else {
                    showInfo(res.message);
                }
            })
        })
        .on('click', '.save-all', function () {
            var timerId = setInterval(function() {
                $('.save-image:not(:disabled):first').trigger('click');
                if (!$('.save-image:not(:disabled):first').length) {
                    clearInterval(timerId);
                }
            }, 1000);
        })
        .on('click', '.popular-tag', function () {
            var row = $(this).closest('tr');
            $(row).find('button').trigger('click');
        })
        .on('click', '.save-image', function () {
            var saveButton = $(this);
            saveButton.attr('disabled', true);
            var row = $(this).closest('tr');
            var data = {
                id: $(row).attr('data-picture-id'),
                description: row.find('.description').val(),
                tags: [],
                donor_id: $(row).data('id'),
            };
            var tags = $(row).find('.tag');
            if (tags.length) {
                $(tags).each(function () {
                    var tag = $(this).find('input');
                    if ($(tag).val()) {
                        data.tags.push($(tag).val());
                    }
                });
                if (data.tags.length) {
                    sendRequest('post', '/admin/moderate/save_image', data, function (res) {
                        if (res.success) {
                            row.remove();
                            $(row).attr('data-picture-id', res.picture_id);
                        } else {
                            showInfo(res.message);
                        }
                    })
                } else {
                    showInfo('Не выбраны теги');
                }
            } else {
                showInfo('Не выбраны теги');
            }
        })
});