var ManifestPlugin = require('webpack-manifest-plugin');
const path = require('path');
module.exports = function createPlugin(options) {
    return new ManifestPlugin({
        writeToFileEmit: true,
        // filter: (file) => !file.path.match(/\.map$/),
        // map: (file) => {
        //     const extension = path.extname(file.name).slice(1);
        //     console.log(file);
        //     // return {
        //     //     ...file,
        //     //     isAsset: false,
        //     //     // name: ['css', 'js'].includes(extension) ?
        //     //     //     `${extension}/${file.name}` :
        //     //     //     file.name
        //     // }
        //     file.isAsset = false;
        //     return {};
        // }
    });
};