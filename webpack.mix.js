let mix = require('laravel-mix');
var { CleanWebpackPlugin } = require('clean-webpack-plugin');
var FaviconsWebpackPlugin = require('favicons-webpack-plugin');
var StylelintPlugin = require('stylelint-webpack-plugin');
const path = require('path');

require("@tinypixelco/laravel-mix-wp-blocks")

// Front theme
mix.js('src/scripts/theme/index.js', 'dist/scripts/theme.js')
    .js('src/scripts/admin/index.js', 'dist/scripts/admin.js')
    .block('src/scripts/editor/index.js', 'dist/scripts/editor.js')
    .js('src/scripts/login/index.js', 'dist/scripts/login.js')
    .sass('src/styles/theme/_main.scss', 'dist/theme.css')
    .sass('src/styles/admin/index.scss', 'dist/admin.css')
    .sass('src/styles/editor/index.scss', 'dist/editor.css')
    .sass('src/styles/login/index.scss', 'dist/login.css')
    .options({
      fileLoaderDirs: {
        images: 'img',
        fonts: 'fonts'
      }
    });
    
mix.copy('src/scripts/editor/**/*.php', 'dist/blocks/');
mix.setPublicPath('dist/');
mix.autoload({
  jquery: ['$', 'window.jQuery', 'jQuery'], // more than one
});

mix.sourceMaps(false, 'source-map');


mix.webpackConfig({
  module: {
    rules: [
      {
        test: [/.css$|.scss$/],
        use: [
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
    ]
  },
  plugins: [
    new StylelintPlugin({
      context: path.resolve(__dirname, 'src/styles'),
    }),
    new FaviconsWebpackPlugin({
      logo: './src/favicon.png',
      prefix: mix.inProduction() ? path.join('wp-content/themes', path.basename(__dirname), 'dist/icons') : './icons',
      outputPath: './icons/',
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
  ]
});


if (mix.inProduction()) {
  mix.webpackConfig({
    plugins: [
      new CleanWebpackPlugin()
    ]
  })
}

mix.disableSuccessNotifications();


mix.browserSync({
  host: 'starter.localhost',
  open: 'external',
  proxy: {
    target: 'https://starter.localhost'
  },
  port: 3000,
  https: {
    key: path.resolve(process.env.HOME, 'Work/_tools/traefik-proxy/devcerts/starter.localhost+1-key.pem'),
    cert: path.resolve(process.env.HOME, 'Work/_tools/traefik-proxy/devcerts/starter.localhost+1.pem')
  },
  files: [
    "src/styles/**/*.scss",
    "src/scripts/",
    "templates/"
  ]
});
