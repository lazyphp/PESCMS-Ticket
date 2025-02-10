module.exports = {
    proxy: "", // 你的 PHP 开发服务器地址
    files: [
        "./**/*.php",  // 使用相对路径
        "./**/*.js",
        "./**/*.css"
    ],
    notify: false,
    open: false,
    watchOptions: {
        ignored: ['**/node_modules/**', '**/dist/**']
    },
    https: {
        key: './localhost-key.pem',  // 指定密钥路径
        cert: './localhost.pem'      // 指定证书路径
    }
};
