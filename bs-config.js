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
    // https: { //如果您的proxy地址带有https，请取消注释此部分，然后本地证书直接用mkcert生成:localhost
    //     key: './localhost-key.pem',  // 指定密钥路径
    //     cert: './localhost.pem'      // 指定证书路径
    // }
};
