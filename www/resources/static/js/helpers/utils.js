export function getRandomInt(min, max) {
    return Math.floor(Math.random() * (max - min)) + min;
}

export function sendRequest(type, url, data, callback) {
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
                if (typeof response.success === 'undefined') {
                    response.success = true;
                }
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

export function showInfo(message) {
    console.log(message);
}

export function NewModal(modal) {
    this.modal = $(modal);
    this.save = false;
    this.close = false;
}

NewModal.prototype.showModal = function () {
    var body = $('body');
    body.append(this.modal);
    this.modal.modal('show');
    this.modal.modal({backdrop: 'static'})
        .on('hidden.bs.modal', function () {
            $(this).remove();
        })
        .on('hide.bs.modal', function () {
            $(this).remove();
        });
    return this.modal;
};
