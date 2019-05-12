const fs = require('fs');
const request = require('request');

var RecognizeInstance = require('recognize');


async function downloadCaptcha(path) {
    const file = fs.createWriteStream('C:\\OSPanel\\domains\\laravel\\drawitbook\\microservices\\tools\\data\\captcha.jpg');
    return new Promise((resolve, reject) => {
        request
            .get(path, {followAllRedirects: true})
            .on('error', function(err) {
                console.error(err);
                reject(error);
            })
            .on('response', function(response) {
                console.log('Сохранил капчу');
                resolve(true);
            })
            .pipe(file)
    });
}


async function recognizeCaptcha() {

    var recognize = new RecognizeInstance('rucaptcha', {
        key: 'b56fb1e46529a006de8b1c8560d4b355',
    });
    return new Promise((resolve, reject) => {
        fs.readFile('C:\\OSPanel\\domains\\laravel\\drawitbook\\microservices\\tools\\data\\captcha.jpg',
            {
                phrase: 1,
                regsense: 1,
            },
            function (err, data) {
                console.log('Получил файл');
                recognize.solving(data, function (err, id, code) {
                    // if (err)
                    if (err) {
                        reject(err);
                    };
                    if (code) {
                        console.log('Captcha:', code);
                        resolve(code);
                    } else {
                        console.log('Captcha not valid');
                        reject('Captcha not valid');
                    }
                });
            });
    });

}

module.exports = {
    downloadCaptcha: async function (path) {
        return await downloadCaptcha(path);
    },
    recognizeCaptcha: async function () {
        return await recognizeCaptcha();
    },
};