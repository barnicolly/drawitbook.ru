$(function () {
    $('body')
        .on('change', '.moderate-table .selected', function () {
            if ($('.moderate-table .selected:checked').length) {
                $('.operation-with-selected').addClass('d-inline').show();
            } else {
                $('.operation-with-selected').removeClass('d-inline').hide();
            }
        })
        .on('click', '.copyToClipboard', function () {
            var content = $(this).closest('.popular-tag-container').find('.content').text();
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
            }
            var dt = new clipboard.DT();
            dt.setData("text/plain", content);
            clipboard.write(dt);
        })
        .on('click', '.popular-tag', function () {
            var row = $(this).closest('.popular-tag-container');
            $(row).find('button').trigger('click');
        })
});

$(function () {
    $('body')
        .on('click', '.refresh-page', function () {
            window.location.reload();
        })
        .on('click', '.unselect-all', function () {
            $('.moderate-table .selected:checked').prop('checked', false);
            $('.operation-with-selected').hide();
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
                        saveButton.attr('disabled', false);
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

$(function () {
    $('body')
        .on('click', '.add-tag', function () {
            var tagsContainer = $(this).closest('tr').find('.tags');
            createTagContainer(createTagContainer(tagsContainer));
        })
        .on('click', '.delete-tag', function () {
            $(this).closest('.tag').remove();
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
        .on('click', '.checkbox-padding', function () {
            var selected = $(this).find('.selected').attr('checked') ? '' : 'checked';
            if (!selected) {
                $(this).find('.selected').removeAttr('checked').prop('checked', false);
            } else {
                $(this).find('.selected')
                    .attr('checked', selected)
                    .prop('checked', true);
            }
            $(this).find('.selected').trigger('change');
        })
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
        class: 'btn btn-danger btn-xs delete-tag input-group-append',
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