module.exports = {
  context: __dirname+'/frontend',
  entry: './index.js',
  output: {
    path: __dirname+'/public',
    filename: 'build.js'
  },
  module: {
    loaders: [
      {
        test: /\.js$/,
        exclude: /\/node_modules\//,
        loader: 'babel?presets[]=es2015'
      },
      {
        test: /\.css$/,
        loader: 'style!css'
      },
      {
        test: /\.(jpg|png|ico)$/,
        loader: 'url?name=assets/[hash].[ext]&limit=10000'
      }
    ]
  },
  devServer:{
    proxy: {
      '*': 'http://localhost:3001'
    }
  }

};
