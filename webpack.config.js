var CWP = require('clean-webpack-plugin');
var ETWP = require('extract-text-webpack-plugin');

var NODE_ENV = process.env.NODE_ENV || 'development';

module.exports = {
  context: __dirname+'/frontend',
  entry: './index.js',
  output: {
    path: __dirname+'/public',
    publicPath: '/public',
    filename: 'build.js'
  },
  module: {
    loaders: [
      {
        test: /\.js$/,
        exclude: /\/node_modules\//,
        loader: 'babel-loader?presets[]=es2015'
      },
      {
        test: /\.css$/,
        loader: ETWP.extract('style-loader', 'css-loader')
      },
      {
        test: /\.(jpg|png|ico|svg|ttf|woff|woff2|eot)(\?.*)?$/,
        loader: 'url-loader?name=assets/[hash].[ext]&limit=10000'
      }
    ]
  },
  plugins: [
    new CWP(['public'], {
      root: __dirname,
      verbose: true,
      dry: false
    }),
    new ETWP('build.css', { allChunks: true, disable: NODE_ENV === 'development' })
  ],
  devServer:{
    proxy: {
      '*': 'http://localhost:3001'
    }
  }
};
