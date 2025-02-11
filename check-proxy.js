const fs = require('fs');
const path = require('path');

// 读取bs-config.js文件
const bsConfigPath = path.join(__dirname, 'bs-config.js');
const config = require(bsConfigPath);

// 检查proxy是否为空
if (!config.proxy) {
    console.log('\x1b[33m%s\x1b[0m', '警告: 要运行前端调试，请在 bs-config.js中设置proxy的PHP服务器地址！');
    process.exit(1); // 退出进程并返回错误代码
} else {
    console.log('proxy 地址已配置:', config.proxy);
}