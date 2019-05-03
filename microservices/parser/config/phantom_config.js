var pool = {
    max: 4, // default
    min: 1, // default
    // how long a resource can stay idle in pool before being removed
    idleTimeoutMillis: 300, // default.
    // maximum number of times an individual resource can be reused before being destroyed; set to 0 to disable
    maxUses: 15, // default
    // function to validate an instance prior to use; see https://github.com/coopernurse/node-pool#createpool
    validator: () => Promise.resolve(true), // defaults to always resolving true
    // validate resource before borrowing; required for `maxUses and `validator`
    testOnBorrow: true, // default
    // For all opts, see opts at https://github.com/coopernurse/node-pool#createpool
    phantomArgs: [['--proxy=127.0.0.1:9050 --proxy-type=socks5 '], {
        logLevel: 'error',
    }], // arguments passed to phantomjs-node directly, default is `[]`. For all opts, see https://github.com/amir20/phantomjs-node#phantom-object-api
};

// args: ['--proxy-server=socks5://localhost:1081']
var page = {
    settings: {
        loadImages: false,
        resourceTimeout: 3000,
        // javascriptEnabled: true,
    },
    property: {
        viewportSize: {width: 1024, height: 900},
        scrollPosition: {left: 0, top: 200}
    }
};

module.exports = {
    pool: pool,
    page: page,
};