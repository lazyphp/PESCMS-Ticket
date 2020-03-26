var fs = require('fs');
var uglify = require('uglify-js');
var CleanCSS = require('clean-css');

//js文件压缩方法
function jsMinify(flieIn, fileOut) {
    //保留注释
    var options = {
        output: {
            comments: /^!/
        }
    };
    var result = uglify.minify(fs.readFileSync(flieIn, "utf8"), options);
    fs.writeFileSync(fileOut, result.code, 'utf8');
}

//css文件压缩方法
function cssMinify(flieIn, fileOut) {
    var flieIn=Array.isArray(flieIn)? flieIn : [flieIn];
    new CleanCSS().minify(flieIn, function(err, minified){
        fs.writeFileSync(fileOut, minified.styles, 'utf8');
    })
}

//开始压缩JS资源
jsMinify('./Public/Theme/assets/js/spectrum.js', './Public/Theme/assets/js/spectrum.min.js');
jsMinify('./Public/Theme/assets/js/webuploader.js', './Public/Theme/assets/js/webuploader.min.js');
jsMinify('./Public/Theme/assets/js/AMUIwebuploader.js', './Public/Theme/assets/js/AMUIwebuploader.min.js');
jsMinify('./Public/Theme/assets/js/app.js', './Public/Theme/assets/js/app.min.js');
jsMinify('./Public/Theme/assets/js/ticket.js', './Public/Theme/assets/js/ticket.min.js');

//百度编辑器
jsMinify('./Public/Theme/assets/ueditor/ueditor.config.js', './Public/Theme/assets/ueditor/ueditor.config.min.js');
jsMinify('./Public/Theme/assets/ueditor/ueditor_ticket.config.js', './Public/Theme/assets/ueditor/ueditor_ticket.config.min.js');
jsMinify('./Public/Theme/assets/ueditor/ueditor.all.js', './Public/Theme/assets/ueditor/ueditor.all.min.js');
jsMinify('./Public/Theme/assets/ueditor/lang/zh-cn/zh-cn.js', './Public/Theme/assets/ueditor/lang/zh-cn/zh-cn.min.js');

//开始压缩CSS资源
cssMinify(['./Public/Theme/assets/css/app.css'], './Public/Theme/assets/css/app.min.css');
cssMinify(['./Public/Theme/assets/css/index.css'], './Public/Theme/assets/css/index.min.css');
cssMinify(['./Public/Theme/assets/css/ui-dialog.css'], './Public/Theme/assets/css/ui-dialog.min.css');
cssMinify(['./Public/Theme/assets/css/webuploader.css'], './Public/Theme/assets/css/webuploader.min.css');
cssMinify(['./Public/Theme/assets/css/ticket.css'], './Public/Theme/assets/css/ticket.min.css');
cssMinify(['./Public/Theme/assets/css/spectrum.css'], './Public/Theme/assets/css/spectrum.min.css');