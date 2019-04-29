var articleForm = $('body').find('#saveArticle');
$('body')
    .on('click', '.save-article', function () {
        var data = articleForm.serialize();
        console.log(data);
        // console.log(1234);
        // history.pushState(null, null, '/admin/article/edit/' + bulkId);
        sendRequest('post', 'http://lr/admin/article/save', data, function (res) {
           if (res.success) {

           } else {
               showInfo(res.message);
           }
        });
    });