const path = require("path");

module.exports = {
    entry: "./resources/react/index.js",
    output: {
        path: path.join(__dirname, "/public/build"),
        filename: "index.js"
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: {
                    loader: "babel-loader"
                },
            },
            {
                test: /\.css$/,
                use: ["style-loader", "css-loader"]
            }
        ]
    }
};