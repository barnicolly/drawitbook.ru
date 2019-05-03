String.prototype.ucFirst = function () {
    var str = this;
    if (str.length) {
        str = str.charAt(0).toUpperCase() + str.slice(1);
    }
    return str;
};

function chpu(str) {
    const Entities = require('html-entities').AllHtmlEntities;
    const {slugify} = require('transliter');
    const entities = new Entities();
    str = entities.decode(str);
    str = slugify(str);
    str = str.replace(/_+/g, '-');
    str = str.replace(/--+/g, '-');
    str = clean(str);
    str = str.substring(0, 250);
    var last = str.split(/[- ]+/)
        .pop();
    if (!last) {
        str = str.substring(0, str.length - 1);
    }
    var last = str.split(/[- ]+/)
        .pop();
    if (!isNaN(parseInt(last))) {
        str += '-q';
    }
    str = str.toLowerCase();
    if (str.substring(0,1) === '-') {
        str = str.substring(1, str.length);
    }
    if (!str) {
        str = 'q';
    }
    return str;
}

function clean(str) {
    return str.replace(/  +/g, ' ')
        .replace('[дубликат]', '')
        .replace('[закрыт]', '')
        .trim().ucFirst();
}


function trimExt(str) {
    return str.replace(/  +/g, ' ')
        .trim();
}

module.exports = {
    clean: function (str) {
        return clean(str);
    },
    trimExt: function (str) {
        return trimExt(str);
    },
    chpu: function (str) {
        return chpu(str);
    },
    log: function log(message) {
        console.log(new Date(), message);
    }
};