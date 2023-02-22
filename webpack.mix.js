let mix = require('laravel-mix');
let webpack = require('webpack');
const WebpackShellPlugin = require('webpack-shell-plugin-next');
require('laravel-mix-bundle-analyzer');

if (!mix.inProduction()) {
  mix.bundleAnalyzer({
    analyzerMode: 'static',
    openAnalyzer: false
  });
}

mix.webpackConfig({
  plugins: [
    new webpack.IgnorePlugin({
      resourceRegExp: /^codemirror$/
    }),
    // Build a JS translation file that corresponds to our PHP lang/ folder.
    new WebpackShellPlugin({onBuildStart:['php artisan lang:js --no-lib --quiet resources/js/translations.js'], onBuildEnd:[]})
  ]
});

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
mix.js('resources/js/admin.js', 'public/js/map/', )
  .vue()
  .sass('resources/sass/app.scss', 'public/css/map');
