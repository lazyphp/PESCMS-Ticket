var fs = require('fs');
var uglify = require('uglify-js');
var CleanCSS = require('clean-css');

//js文件压缩方法
//js文件压缩方法
function jsMinify(flieIn, fileOut) {
    var flieIn=Array.isArray(flieIn)? flieIn : [flieIn];
    var result = uglify.minify(flieIn);
    fs.writeFileSync(fileOut, result.code, 'utf8');
}

//css文件压缩方法
function cssMinify(flieIn, fileOut) {
    var flieIn=Array.isArray(flieIn)? flieIn : [flieIn];
    new CleanCSS().minify(flieIn, function(err, minified){
        fs.writeFileSync(fileOut, minified.styles, 'utf8');
    })
}

jsMinify(['./app.js'], './ccc.min.js');

// cssMinify(['./admin.css'], './admin.min.css');