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

        var div = $('<div>').attr({
            class: 'tag form-group input-group',
        });

        $('<input>').attr({
            type: 'text',
            class: 'form-control',
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
    })

    $('body')
        .on('click', '.delete-tag', function () {
            $(this).closest('.tag').remove();
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
        .on('click', '.save-image', function () {
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