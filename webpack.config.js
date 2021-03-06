'use strict';

const path = require('path');
const autoprefixer = require('mini-css-extract-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const UglifyJsPlugin = require("uglifyjs-webpack-plugin");
const OptimizeCSSAssetsPlugin = require("optimize-css-assets-webpack-plugin");
const StylelintPlugin = require('stylelint-webpack-plugin');
const DependencyExtractionWebpackPlugin = require( '@wordpress/dependency-extraction-webpack-plugin' );
const CopyPlugin = require('copy-webpack-plugin');
const FaviconsWebpackPlugin = require('favicons-webpack-plugin')

var config = {
  context: __dirname,
  entry: {
    theme: './src/scripts/theme/index.js',
    admin: './src/scripts/admin/index.js',
    editor: './src/scripts/editor/index.js',
    login: './src/scripts/login/index.js',
  },
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
          // Reads Sass vars from files or inlined in the options property
          { 
            loader: "@epegzz/sass-vars-loader", 
            options: {
              syntax: 'scss',
              files: [
                // Option 2) Load vars from JSON file
                path.resolve(__dirname, 'themeConfig.json')
              ]
            }
          }
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
    new MiniCssExtractPlugin({
      filename: '[name].css',
    }),
    new StylelintPlugin({
      failOnError: false,
    }),
    new DependencyExtractionWebpackPlugin(),
    new CopyPlugin({
      patterns: [
        { 
          from: 'src/scripts/editor/**/*.php', 
          to: 'blocks/[name].[ext]'
        },
      ]
    }),
    new FaviconsWebpackPlugin({
      logo: './src/favicon.png',
      prefix: path.join('wp-content/themes', path.basename(__dirname), 'dist/icons'),
      outputPath: 'icons/',
      inject: false,
      favicons: {
        appName: 'Ecran Noir',
        appDescription: 'Site Vitrine',
        developerName: null,
        developerURL: null, // prevent retrieving from the nearest package.json
        background: '#1D1D1B',
        theme_color: '#1D1D1B',
        icons: {
          coast: false,
          appleStartup: false,
          yandex: false,
          firefox: false
        }
      }
    })
  ],
  externals: {
    $: '$',
    jquery: 'jQuery'
  }
}

module.exports = (env, argv) => {

  if (argv.mode === 'development') {
    config.devtool = 'source-map';
  }

  if (argv.mode === 'production') {
    config.devtool = 'none';
    config.plugins.push(new CleanWebpackPlugin())
    config.optimization = {
      minimize: true,
      minimizer: [new UglifyJsPlugin(), new OptimizeCSSAssetsPlugin({})],
    }
  }

  return config;
};
