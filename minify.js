var fs = require('fs');
var uglify = require('uglify-js');
var CleanCSS = require('clean-css');
var program = require('commander');

program
    .version('0.0.1')
    .option('-c, --cheese [type]', 'Add the specified type of cheese [marble]', '')
	.option('-h, --recourse', '');
	
	
program.parse();

const cli = program.opts();


// console.log('you ordered a pizza with:');
if (cli.recourse){
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

var myDate = new Date();
console.log('开始时间: '+ myDate.getHours() + ':'+myDate.getMinutes()+':'+myDate.getSeconds());

//开始压缩JS资源
var js = ['spectrum', 'webuploader', 'AMUIwebuploader', 'app', 'ticket', 'pt-base', 'jquery.fancybox'];
for(var i in js){
    if(cli.cheese != '' && js[i] != cli.cheese){
        continue;
    }
    jsMinify('./Public/Theme/assets/js/'+js[i]+'.js', './Public/Theme/assets/js/'+js[i]+'.min.js');
    console.log('压缩了Javascript: '+js[i]+'.js');
}

//百度编辑器
var ueditor = ['ueditor.config', 'ueditor_ticket.config', 'ueditor.all', 'lang/zh-cn/zh-cn'];
for(var i in ueditor){
    if(cli.cheese !='' && ueditor[i] != cli.cheese){
        continue;
    }
    jsMinify('./Public/Theme/assets/ueditor/'+ueditor[i]+'.js', './Public/Theme/assets/ueditor/'+ueditor[i]+'.min.js');
    console.log('压缩了百度编辑器: '+ueditor[i]+'.js');
}


//开始压缩CSS资源
var css = ['app', 'index', 'ui-dialog', 'webuploader', 'ticket', 'spectrum'];
for(var i in css){
    if(cli.cheese !='' && css[i] != cli.cheese){
        continue;
    }
    cssMinify(['./Public/Theme/assets/css/'+css[i]+'.css'], './Public/Theme/assets/css/'+css[i]+'.min.css');
    console.log('压缩了样式: '+css[i]+'.css');
}