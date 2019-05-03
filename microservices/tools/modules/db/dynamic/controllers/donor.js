var donorModel = require('../models/donor_model');

module.exports = {
    insertBatch: async function (table, config, insertData) {
        var donor = new donorModel(table, config);
        return donor.insertBatch(insertData);
    },
    get: async function (table, config, where, select, options) {
        var donor = new donorModel(table, config);
        return donor.get(where, select, options);
    },
    save: async function (table, config, updateData) {
        var donor = new donorModel(table, config);
        return donor.save(updateData);
    },
    update: async function (table, config, updateData, where) {
        var donor = new donorModel(table, config);
        return donor.update(updateData, where);
    }
};