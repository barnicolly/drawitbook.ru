var HIGH_PRIORITY = 1;
var MEDIUM_PRIORITY = 2;
var LOW_PRIORITY = 3;

var constants = {
    'PARSE_URL': 1,
    'PARSE_INFO': 2,
    'INSERT_DATA': 4,
    'GET_QUERIES': 5,
    'UPDATE_DONOR': 6,
};

module.exports = {
    constants: constants,
    actions: {
        getQueries: function () {
            return {
                priority: LOW_PRIORITY,
                type: constants.GET_QUERIES,
            }
        },
        parseUrl: function () {
            return {
                priority: LOW_PRIORITY,
                type: constants.PARSE_URL
            }
        },
        parseInfo: function () {
            return {
                priority: LOW_PRIORITY,
                type: constants.PARSE_INFO
            }
        },
        insertData: function () {
            return {
                priority: LOW_PRIORITY,
                type: constants.INSERT_DATA
            }
        },
        updateDonor: function () {
            return {
                priority: LOW_PRIORITY,
                type: constants.UPDATE_DONOR,
            }
        },
    }
};