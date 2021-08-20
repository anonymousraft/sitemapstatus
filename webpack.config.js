const {
    timeStamp
} = require('console');
const HtmlWebpackPlugin = require('html-webpack-plugin');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const CopyPlugin = require("copy-webpack-plugin");
const {
    CleanWebpackPlugin
} = require('clean-webpack-plugin');
const path = require('path');

module.exports = {
    mode: 'development',

    entry: ['./src/js/index.js'],

    output: {
        path: path.resolve(__dirname, 'assets'),
        filename: 'js/bundle.js'
    },
    module: {
        rules: [{
                test: /\.js$/,
                exclude: /(node_modules)/,
                use: {
                    loader: 'babel-loader',
                }
            },
            {
                test: /\.(sa|sc|c)ss$/,
                use: [{
                        loader: MiniCssExtractPlugin.loader
                    },
                    {
                        loader: 'css-loader'
                    },
                    {
                        loader: 'postcss-loader',
                        options: {
                            postcssOptions: {
                                config: path.resolve(__dirname, "postcss.config.js"),
                            },
                        }
                    },
                    {
                        loader: 'sass-loader',
                        options: {
                            implementation: require("sass")
                        }
                    }
                ]
            },
            {
                // Now we apply rule for images
                test: /\.(png|jpe?g|gif|svg)$/,
                use: [{
                    // Using file-loader for these files
                    loader: "file-loader",

                    // In options we can set different things like format
                    // and directory to save
                    options: {
                        outputPath: 'img',
                        publicPath: 'img'
                    }
                }]
            },
            {
                // Apply rule for fonts files
                test: /\.(woff|woff2|ttf|otf|eot)$/,
                use: [{
                    // Using file-loader too
                    loader: "file-loader",
                    options: {
                        outputPath: 'fonts'
                    }
                }]
            }
        ]
    },
    plugins: [
        new CleanWebpackPlugin(),
        new CopyPlugin({
            patterns: [{
                from: "src/img/",
                to: "./img/"
            }, ],
        }),
        new MiniCssExtractPlugin({
            filename: "css/bundle.css"
        })
    ]
}