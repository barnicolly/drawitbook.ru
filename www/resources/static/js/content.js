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

var currentRequests = {};
$.ajaxPrefilter(function (options, originalOptions, jqXHR) {
    if (currentRequests[options.url]) {
        currentRequests[options.url].abort();
    }
    currentRequests[options.url] = jqXHR;
});

$(function () {
    $('.rate-container').each(function () {
        $(this).customRate('init');
    });
    $('.claim-button').each(function () {
        $(this).customClaim('init');
    });
    $('.art-control').each(function () {
        $(this).customArtControl('init');
    });
    $('#button').backUpButton('init');
});

function getClaimContainer() {
    var claimContainer = $('<form>', {class: 'claim-container form-group'});
    var wrapper = $('<div>', {class: 'list-group-item'});
    wrapper.append($('<p>').html('Помогите нам сделать проект лучше. Обращение обязательно будет рассмотрено модератором.'));
    wrapper.append($('<span>').html('Причина жалобы:'));
    var claimList = $('<div>', {class: 'claim-list form-group'});
    var sprClaim = {
        1: 'Оскорбление',
        2: 'Материал для взрослых',
        3: 'Пропаганда наркотиков',
        4: 'Насилие',
        5: 'Призыв к суициду',
    };
    for (var claimIndex in sprClaim) {
        var radio = $('<div>', {class: 'radio'});
        var label = $('<label>');
        if (claimIndex == 1) {
            label.append($('<input>', {type: 'radio', name: 'reason', value: claimIndex}).prop('checked', true));
        } else {
            label.append($('<input>', {type: 'radio', name: 'reason', value: claimIndex}));
        }
        label.append('&nbsp;');
        label.append(sprClaim[claimIndex]);
        radio.append(label);
        claimList.append(radio);
    }
    wrapper.append(claimList);
    var submit = $('<button>', {type: 'button', class: 'btn btn-link submit-claim'}).html('Отправить');
    var cancel = $('<button>', {type: 'button', class: 'btn btn-link cancel-claim'}).html('Отменить');
    wrapper.append(submit);
    wrapper.append(cancel);
    claimContainer.append(wrapper);
    return claimContainer;
}

function NewModal(modal) {
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