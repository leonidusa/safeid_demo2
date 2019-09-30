const webpack = require('webpack');
const path = require('path');
// const ExtractTextPlugin = require("extract-text-webpack-plugin");
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const OptimizeCSSAssetsPlugin = require("optimize-css-assets-webpack-plugin");
const UglifyJsPlugin = require("uglifyjs-webpack-plugin"); 

let config = {
  mode: 'production', //development, production, none
  entry: {
    main: [
      './edm_theme/js/entry.js',
      './edm_theme/scss/entry.scss'
    ]
  },
  output: {
    path: path.resolve(__dirname, '../../public/assets/js'),
    filename: 'app.js'
  },
  resolve: {
    alias: {
    'uikit-util': path.resolve(__dirname, 'node_modules/uikit/src/js/util')
    }
  },
  module: {
    rules: [
      {
        test: /\.js/,
        loader: 'babel-loader'
      },
      {
        test: /\.(sa|sc|c)ss$/,
        use: [
          MiniCssExtractPlugin.loader,
          'css-loader',
          // 'postcss-loader',
          'sass-loader',
        ]
      },
      {
        test: /.(png|woff(2)?|eot|ttf|svg)(\?[a-z0-9=\.]+)?$/,
        use: [
          {
            loader: 'file-loader',
            options: {
              name: '../css/[hash].[ext]'
            }
          }
        ]
      },
    ]
  },
  // externals: {
  //   $: '$',
  //   jquery: 'jquery'
  // },
  plugins: [
    new MiniCssExtractPlugin({
      filename: '../css/custom.css',
      // filename: path.resolve(__dirname, '../../public/assets/css/custom.css'),
    })
  ],
  optimization: {
    minimizer: [
      new UglifyJsPlugin({
        uglifyOptions: {
          sourceMap: false,
          compress: {
            sequences: true,
            conditionals: true,
            booleans: true,
            if_return: true,
            join_vars: true,
            drop_console: false //true
          },
          output: {
            comments: false //true
          },
          minimize: true //true false
        }
      }),
      new OptimizeCSSAssetsPlugin({
        // assetNameRegExp: /\.optimize\.css$/g,
        cssProcessor: require('cssnano'),
        cssProcessorPluginOptions: {
          preset: ['default', { discardComments: { removeAll: true } }],
        },
        canPrint: true
      })
    ],
  }
};


module.exports = config;