const path = require("path");
const Dotenv = require("dotenv-webpack");

module.exports = {
    plugins: [new Dotenv()],

    resolve: {
        alias: {
            "@": path.resolve("resources/js"),
        },

        fallback: {
            fs: false,
            module: false,
            crypto: require.resolve("crypto-browserify"),
            os: require.resolve("os-browserify/browser"),
            https: require.resolve("https-browserify"),
            http: require.resolve("stream-http"),

            path: require.resolve("path-browserify"),
        },
    },
};
