var articleForm = $('body').find('#saveArticle');
$('body')
    .on('click', '.save-article', function () {
        var data = articleForm.serialize();
        data += '&template=' + cleanHtml(CKEDITOR.instances['template-editor'].getData());
        sendRequest('post', '/admin/article/save', data, function (res) {
            if (res.success) {
                if (articleForm.find('[name="id"]').val() === '0') {
                    articleForm.find('[name="id"]').val(res.id);
                    history.pushState(null, null, '/admin/article/edit/' + res.id);
                    $('.add-picture').prop('disabled', false);
                }
            } else {
                showInfo(res.message);
            }
        });
    });

function cleanHtml(html) {
    var container = $('<div>').html(html);
    $(container).find('p:empty').remove();
    return $(container).html()
        .replace(/&nbsp;/g, '');
}

$(function () {
    CKEDITOR.config.fillEmptyBlocks = false;
    CKEDITOR.config.basicEntities = false;
    CKEDITOR.replace('template-editor');
});

$('#article-pictures')
    .on('click', '.delete-picture', function () {
        var closestRow = $(this).closest('tr');
        sendRequest('post', '/admin/article/' + articleForm.find('[name="id"]').val() + '/detach/' + closestRow.data('id'), {}, function (res) {
            if (res.success) {
                // closestRow.remove();
                sortTable($('#article-pictures table:first'))
                updateCountPictures();
            } else {
                showInfo(res.message);
            }
        });
    })
    .on('click', '.add-picture', function () {
        sendRequest('get', '/admin/article/getModal', {}, function (res) {
            if (res.success) {
                console.log(1234);
                var modal = new NewModal(res.data);
                modal.showModal();
                // closestRow.remove();
                // sortTable($('#article-pictures table:first'))
                // updateCountPictures();
            } else {
                showInfo(res.message);
            }
        });
    });

function updateCountPictures() {
    $('.count-pictures').html($('#article-pictures table:first tbody tr').length);
}

function sortNumber(a, b) {
    return $('td:nth-child(2)', a).text() - $('td:nth-child(2)', b).text();
}

function sortTable(table, order) {
    var tbody = table.find('tbody');
    tbody.find('tr').sort(sortNumber).appendTo(tbody);
}