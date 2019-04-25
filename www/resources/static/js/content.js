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
            if (callback) {
                callback.call(self, {success: false});
            }
        }
    });
}

function showInfo(message) {
    console.log(message);
}

var routes = {
    art: '/art/',
};
$('body')
    .on('click', '.like', function () {
        var rateButton = $(this);
        $('.rate-button').prop('disabled', true);
        var activeOff = $(rateButton).hasClass('active');
        sendRequest('post', routes.art + 'like/' + $('#art').val(), {off: activeOff}, function (res) {
            $('.rate-button').prop('disabled', false);
            if (res.success) {
                needActiveOff(rateButton, activeOff);
            }
        });
    })
    .on('click', '.dislike', function () {
        var rateButton = $(this);
        $('.rate-button').prop('disabled', true);
        var activeOff = $(rateButton).hasClass('active');
        sendRequest('post', routes.art + 'dislike/' + $('#art').val(), {off: activeOff}, function (res) {
            $('.rate-button').prop('disabled', false);
            if (res.success) {
                needActiveOff(rateButton, activeOff);
            }
        });
    });

function needActiveOff(rateButton, activeOff) {
    if (!activeOff) {
        $('.rate-button').removeClass('active');
        $(rateButton).addClass('active');
    } else {
        $(rateButton).removeClass('active');
    }
}