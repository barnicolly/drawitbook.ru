var articleForm = $('body').find('#saveArticle');
var articleId = 0;
$('body')
    .on('click', '.save-article', function () {
        var data = articleForm.serialize();
        data += '&template=' + cleanHtml(CKEDITOR.instances['template-editor'].getData());
        sendRequest('post', '/admin/article/save', data, function (res) {
            if (res.success) {
                if (articleForm.find('[name="id"]').val() === '0') {
                    articleId = res.id;
                    articleForm.find('[name="id"]').val(articleId);
                    history.pushState(null, null, '/admin/article/edit/' + articleId);
                    $('.add-picture').prop('disabled', false);
                    $('.preview-article').prop('disabled', false);
                }
            } else {
                showInfo(res.message);
            }
        });
    })
    .on('click', '.preview-article', function () {
        window.open('/admin/article/preview/' + articleId, '_blank');
    });

function cleanHtml(html) {
    var container = $('<div>').html(html);
    $(container).find('p:empty').remove();
    return $(container).html()
        .replace(/&nbsp;/g, '');
}

$(function () {
    articleId = articleForm.find('[name="id"]').val();
    CKEDITOR.config.fillEmptyBlocks = false;
    CKEDITOR.config.basicEntities = false;
    CKEDITOR.config.height = 700;
    CKEDITOR.replace('template-editor');
});

$('#article-pictures')
    .on('click', '.delete-picture', function () {
        var closestRow = $(this).closest('tr');
        sendRequest('post', '/admin/article/' + articleId + '/detach/' + closestRow.data('id'), {}, function (res) {
            if (res.success) {
                closestRow.remove();
                updateCountPictures();
            } else {
                showInfo(res.message);
            }
        });
    })
    .on('click', '.edit-picture', function () {
        var closestRow = $(this).closest('tr');
        sendRequest('get', '/admin/article/getModal', {id: $(closestRow).attr('data-pivot-id')}, function (res) {
            if (res.success) {
                var modal = new NewModal(res.data);
                var modalHTML = modal.showModal();
                modalHTML
                    .on('click', '.save-modal-button', function () {
                        var form = $(modalHTML).find('#articlePictureModal');
                        var data = form.serialize();
                        data += '&article_id=' + articleId;
                        sendRequest('post', '/admin/article/pictures/save', data, function (res) {
                            if (res.success) {
                                modalHTML.modal('hide');
                                updateArticlePicturesList();
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
    .on('click', '.add-picture', function () {
        sendRequest('get', '/admin/article/getModal', {}, function (res) {
            if (res.success) {
                var modal = new NewModal(res.data);
                var modalHTML = modal.showModal();
                modalHTML
                    .on('click', '.save-modal-button', function () {
                        var form = $(modalHTML).find('#articlePictureModal');
                        var data = form.serialize();
                        data += '&article_id=' + articleId;
                        sendRequest('post', '/admin/article/pictures/save', data, function (res) {
                            if (res.success) {
                                modalHTML.modal('hide');
                                updateArticlePicturesList();
                            } else {
                                showInfo(res.message);
                            }
                        });
                    })
            } else {
                showInfo(res.message);
            }
        });
    });

function updateArticlePicturesList() {
    sendRequest('get', '/admin/article/' + articleId + '/refreshList', {}, function (res) {
        if (res.success) {
            $('#article-pictures-body').html(res.data);
            updateCountPictures();
        } else {
            showInfo(res.message);
        }
    });
}

function updateCountPictures() {
    $('.count-pictures').html($('#article-pictures table:first tbody tr').length);
}
