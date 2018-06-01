module.exports = {
    entry: './react/index.js',
    output: {
        path: __dirname + '/public/js',
        filename: 'app.js'
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: {
                    loader: "babel-loader"
                }
            }
        ]
    }
};
