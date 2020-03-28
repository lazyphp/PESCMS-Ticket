var fs = require('fs');
var uglify = require('uglify-js');
var CleanCSS = require('clean-css');
var program = require('commander');

program
    .version('0.0.1')
    .option('-h, --recourse', '')
    .option('-c, --cheese [type]', 'Add the specified type of cheese [marble]', '')
    .parse(process.argv);


// console.log('you ordered a pizza with:');
if (program.recourse){
    console.log("    [使用说明] 不输入命令则压缩所有设定文件\n\n" +
        "    -h                                查看帮助说明\n" +
        "    -c 压缩的文件名称                 压缩指定的文件。 如 node minify -c app\n")
    return false;
}


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
var js = ['spectrum', 'webuploader', 'AMUIwebuploader', 'app', 'ticket'];
for(var i in js){
    if(program.cheese != '' && js[i] != program.cheese){
        continue;
    }
    jsMinify('./Public/Theme/assets/js/'+js[i]+'.js', './Public/Theme/assets/js/'+js[i]+'.min.js');
    console.log('压缩了Javascript: '+js[i]+'.js');
}

//百度编辑器
var ueditor = ['ueditor.config', 'ueditor_ticket.config', 'ueditor.all', 'lang/zh-cn/zh-cn'];
for(var i in ueditor){
    if(program.cheese !='' && ueditor[i] != program.cheese){
        continue;
    }
    jsMinify('./Public/Theme/assets/ueditor/'+ueditor[i]+'.js', './Public/Theme/assets/ueditor/'+ueditor[i]+'.min.js');
    console.log('压缩了百度编辑器: '+ueditor[i]+'.js');
}


//开始压缩CSS资源
var css = ['app', 'index', 'ui-dialog', 'webuploader', 'ticket', 'spectrum'];
for(var i in css){
    if(program.cheese !='' && css[i] != program.cheese){
        continue;
    }
    cssMinify(['./Public/Theme/assets/css/'+css[i]+'.css'], './Public/Theme/assets/css/'+css[i]+'.min.css');
    console.log('压缩了样式: '+css[i]+'.css');
}