/* create archive with build folder for send in deploy */
const fs = require('fs');
const path = require('path');
const archiver = require('archiver');

const publicPath = path.resolve(__dirname, '../public');
const publicBuildPath = path.join(publicPath, '/build');

const output = fs.createWriteStream(publicPath  + '/build.zip');
const archive = archiver('zip', {
    zlib: { level: 5 }
});

output.on('close', function () {
    console.log(archive.pointer() + ' total bytes');
    console.log('archiver has been finalized and the output file descriptor has closed.');
});

archive.on('error', function(err){
    throw err;
});

archive.pipe(output);

archive.directory(publicBuildPath, false, {});
archive.finalize();