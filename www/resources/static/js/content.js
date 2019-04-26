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

$(function () {
    $('.rate-container').each(function () {
        $(this).customRate('init');
    });
});


function getRandomInt(min, max) {
    return Math.floor(Math.random() * (max - min)) + min;
}