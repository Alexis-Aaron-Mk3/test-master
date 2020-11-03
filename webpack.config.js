const path = require("path");
const HtmlWebPackPlugin = require("html-webpack-plugin");
const MiniCSSExtractPlugin = require("mini-css-extract-plugin");


module.exports = {
  entry: "./src/login/index.js",
  output: {
    path: path.resolve(__dirname, "public/modules/login"),
    filename: "bundle.js",
  },
  resolve: {
    extensions: [".js", ".jsx"],
  },
  module: {
    rules: [
      {
        test: /\.(js|jsx)$/,
        exclude: /node_modules/,
        use: {
          loader: "babel-loader",
        },
      },
      {
        test: /\.html$/,
        use: [
          {
            loader: "html-loader",
          },
        ],
      },
      {
        test: /\.css$/,
        loader: [MiniCSSExtractPlugin.loader, "css-loader"],
      },
      {
        test: /\.scss$/,
        loader: [MiniCSSExtractPlugin.loader, "sass-loader"],
      },
      {
        test: /\.(png|svg|jpg|jpeg|gif)$/,
        use: ["file-loader"],
      },
    ],
  },
  plugins: [
    new HtmlWebPackPlugin({
      template: "./src/login/index.html",
      filename: "./index.html",
    }),
    new MiniCSSExtractPlugin(),
  ],
};
