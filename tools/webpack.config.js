const path = require('path');
const webpack = require('webpack');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const autoprefixer = require('autoprefixer');

const { source, target, buildTime, isProduction } = require('./utils/config');

/* Setup */
const nameSuffix = buildTime + (isProduction ? '.min' : '');

const config = {
  entry: path.join(source, 'scripts', 'index'),
  output: {
    path: path.join(target, 'scripts'),
    filename: `[name]${nameSuffix}.js`
  },
  resolve: {
    root: [path.join(source)],
    extensions: ['', '.js', '.scss']
  },
  module: {
    loaders: [{
      /* styles */
      test: /\.s?css$/,
      loader: ExtractTextPlugin.extract('style', ['css-loader', 'postcss-loader', 'sass-loader'])
    }, {
      /* static assets */
      test: /\.(woff|png|svg|ttf|eot)$/i,
      loader: 'file?name=[name].[ext]'
    }, {
      /* data, config, mocks */
      test: /\.json$/i,
      loader: 'file?name=[name].[ext]'
    }, {
      /* javascript */
      test: /\.js$/,
      include: [source],
      loader: 'babel-loader',
      query: {
        cacheDirectory: true,
        presets: [ ['es2015', {
          loose: true
        }] ]
      }
    }]
  },
  plugins: [
    new ExtractTextPlugin(`[name]${nameSuffix}.css`, {})
  ],
  stats: {
    children: false,
    hash: false,
    version: false,
    colors: true
  },
  postcss: () => [autoprefixer],
  sassLoader: {
    includePaths: [source]
  }
};

if (isProduction) {
  config.plugins.push(new webpack.optimize.UglifyJsPlugin({
    compress: {
      warnings: false
    }
  }));
} else {
  config.devtool = '#eval';
}

module.exports = config;
