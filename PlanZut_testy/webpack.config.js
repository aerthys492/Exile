const path = require('path');
const HtmlWebpackPlugin = require('html-webpack-plugin');

module.exports = {
    entry: {
        main: './src/js/plan.js',
        change: './src/js/change.js'
    },
    output: {
        filename: '[name].bundle.js', // Use [name] to generate unique filenames for each entry
        path: path.resolve(__dirname, 'dist'),
        clean: true,
    },
    module: {
        rules: [
            {
                test: /\.css$/,
                use: ['style-loader', 'css-loader'],
            },
            {
                test: /\.(png|svg|jpg|jpeg|gif)$/i,
                type: 'asset/resource',
            },
        ],
    },
    plugins: [
        new HtmlWebpackPlugin({
            template: './src/plan.html',
        }),
    ],
    devServer: {
        static: './dist',
        open: true,
    },
    resolve: {
        extensions: ['.js', '.json'],
    },
    mode: 'development',
};