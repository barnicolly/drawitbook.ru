var _ = require('lodash');

class myModel {
    constructor(table, config = appConfig.database.default) {
        this.table = table;
        const Store = require('openrecord/store/' + config.store);
        this.storeInstance = new Store({
            type: config.store,
            host: config.host,
            user: config.user,
            password: config.password,
            database: config.database,
            inflection: config.inflection,
            autoLoad: true
        });
    }

    async get(where, select, options) {
        var table = this.table;
        // var self = this;
        return new Promise((resolve, reject) => {
            this.storeInstance.ready()
                .then(_ => {
                    var model = this.storeInstance.Model(table);
                    if (typeof options !== "undefined" && options.limit) {
                        model = model.limit(options.limit)
                    }
                    if (typeof select !== "undefined" && select) {
                        model = model.select(select)
                    }
                    if (typeof options !== "undefined" && options.order) {
                        model = model.order(options.order.column, options.order.sortDesc)
                    }
                    var result = [];
                    model.where(where)
                        .then(res => {
                            result = res;
                        })
                        .then(_ => {
                            this.storeInstance.close(function () {
                                resolve(result);
                            });                            
                        })
                        .catch(e => {
                            this.storeInstance.close(function () {
                                reject(e);
                            });
                        });
                })
                .catch(e => {
                    console.log(e);
                    this.storeInstance.close(function () {
                        reject(e);
                    });
                })
        });
    }

    async insertBatch(insertData) {
        var table = this.table;
        return new Promise((resolve, reject) => {
            this.storeInstance.ready()
                .then(_ => {
                    var model = this.storeInstance.Model(table);
                    model.create(insertData)
                        .then(res => {
                            this.storeInstance.close(function () {
                                insertData = null;
                                model = null;
                                table = null;
                                resolve(res);
                            });
                        })
                        .catch(e => {
                            this.storeInstance.close(function () {
                                model = null;
                                table = null;
                                reject(e);
                            });
                        });
                })
                .catch(e => {
                    console.log(e);
                    this.storeInstance.close(function () {
                        table = null;
                        reject(e);
                    });
                })
        });
    }


    //одиночный update
    async save(data) {
        await timeout(1000);
        var table = this.table;
        return new Promise((resolve, reject) => {
            this.storeInstance.ready()
                .then(_ => {
                    var model = this.storeInstance.Model(table);
                    var result = false;
                    model.where({id: data.id})
                        .updateAll(data)
                        .then(res => {
                            result = res;
                        })
                        .then(_ => {
                            this.storeInstance.close(function () {
                                resolve(result);
                            });
                        })
                        .catch(e => {
                            this.storeInstance.close(function () {
                                reject(e);
                            });
                        });
                })
                .catch(e => {
                    console.log(e);
                    this.storeInstance.close(function () {
                        reject(e);
                    });
                })
        });
    }

    async update(data, where) {
        var table = this.table;
        return new Promise((resolve, reject) => {
            this.storeInstance.ready()
                .then(_ => {
                    var model = this.storeInstance.Model(table);
                    var result = false;
                    model.where(where)
                        .updateAll(data)
                        .then(res => {
                            result = res;
                        })
                        .then(_ => {
                            this.storeInstance.close(function () {
                                resolve(result);
                            });
                        })
                        .catch(e => {
                            this.storeInstance.close(function () {
                                reject(e);
                            });
                        });
                })
                .catch(e => {
                    console.log(e);
                    this.storeInstance.close(function () {
                        reject(e);
                    });
                })
        });
    }
}


function timeout(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

module.exports = myModel;