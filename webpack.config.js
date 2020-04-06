'use strict';

const path = require('path');
const autoprefixer = require('mini-css-extract-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const UglifyJsPlugin = require("uglifyjs-webpack-plugin");
const OptimizeCSSAssetsPlugin = require("optimize-css-assets-webpack-plugin");
const StylelintPlugin = require('stylelint-webpack-plugin');
const DependencyExtractionWebpackPlugin = require( '@wordpress/dependency-extraction-webpack-plugin' );

const devMode = process.env.NODE_ENV !== 'production';

module.exports = {
  context: __dirname,
  entry: {
    main: './src/scripts/theme/index.js',
    admin: './src/scripts/admin/index.js',
    editor: './src/scripts/editor/index.js',
    login: './src/scripts/login/index.js',
  },
  devtool: 'source-map',
  output: {
    path: path.resolve(__dirname, 'dist'),
    filename: 'scripts/[name].js',
  },
  resolve: {
    alias: {
      '@scripts': path.resolve(__dirname, 'src/script/'),
      '@styles': path.resolve(__dirname, 'src/styles'),
      '@img': path.resolve(__dirname, 'src/img/'),
      '@fonts': path.resolve(__dirname, 'src/fonts/'),
      '@': path.resolve(__dirname, 'src/')
    },
    modules: [
      'node_modules',
      path.resolve(__dirname, 'src')
    ],
    extensions: ['.js'],
  },
  module: {
    rules: [
      {
        test: /\.js?$/,
        exclude: /(node_modules|bower_components)/,
        include: path.resolve(__dirname, 'src/scripts/'),
        use: {
          loader: 'babel-loader',
          options: {
            presets: [
              '@babel/preset-env',
              '@babel/preset-react'
            ],
            plugins: [
              ["transform-react-jsx", {
                "pragma": "wp.element.createElement"
              }]
            ]
          },
        },
      },
      {
        test: [/.css$|.scss$/],
        use: [
          MiniCssExtractPlugin.loader,
          {
            loader: 'css-loader',
            options: {
              sourceMap: true,
            }
          },
          {
            loader: 'postcss-loader',
            options: {
              ident: 'postcss',
              plugins: [
                require('autoprefixer'),
              ],
              sourceMap: true,
            }
          },
          {
            loader: 'sass-loader',
            options: {
              sourceMap: true,
            }
          },
        ]
      },
      {
        test: /\.(png|svg|jpg|gif)$/,
        include: path.resolve(__dirname, 'src/img'),
        use: [{
          loader: 'file-loader',
          options: {
            name: '[name].[ext]',
            outputPath: 'img/'
          }
        }],
      },
      {
        test: /.(ttf|otf|eot|woff(2)?)(\?[a-z0-9]+)?$/,
        include: path.resolve(__dirname, 'src/fonts'),
        use: [{
          loader: 'file-loader',
          options: {
            name: '[name].[ext]',
            outputPath: 'fonts/'
          }
        }],
      },
    ]
  },
  plugins: [
    () => !devMode && new CleanWebpackPlugin(),
    new MiniCssExtractPlugin({
      filename: '[name].css',
    }),
    new StylelintPlugin({
      failOnError: false,
    }),
    new DependencyExtractionWebpackPlugin(),
  ],
  optimization: {
    minimizer: [
      // new UglifyJsPlugin(),
      new OptimizeCSSAssetsPlugin()
    ]
  },
  externals: {
    $: '$',
    jquery: 'jQuery'
  },
}
