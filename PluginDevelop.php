<?php
/**
 * @author PESCMS
 * @copyright ©PESCMS
 * @license https://www.pescms.com/article/view/-1.html
 */

if (substr(php_sapi_name(), 0, 3) != 'cli') {
    exit("本功能只能在cli模式下允许");
}
defined('PES_CORE') or define('PES_CORE', __DIR__ . '/');

function msg($content){
    return PHP_EOL.$content.PHP_EOL.PHP_EOL;
}


if (empty($argv) || count($argv) < 2) {
    die(msg("欢迎使用PESCMS应用插件开发工具." . PHP_EOL . "输入-h -help获取更多帮助"));
}
$command = [
    '-c' => 'create',
    '-p' => 'package',
];

if (in_array($argv['1'], ['-h', '-help'])) {
    $action = 'help';
} elseif (empty($command[$argv['1']])){
    die(msg('未知参数，请输入-h 或者 -help 查看帮助信息.'));
}elseif (empty($argv['2'])){
    die(msg("  {$argv['1']} 参数不完整，请输入-h 或者 -help 查看帮助信息." ));
}else{
    $action = $command[$argv['1']];
}



class PluginDevelop {

    /**
     * 帮助文档
     */
    public function help() {
        $doc = [
            'PESCMS应用插件开发工具支持如下指令:',
            '  -h, -help         查看帮助信息',
            "  -c <应用名称>     快速创建一个新的应用插件.",
            "  -p <应用名称>     将当前开发的应用进行打包."
        ];
        die(msg(implode(PHP_EOL, $doc
            )));
    }

    /**
     * 创建一个新的应用插件
     */
    public function create($name) {
        $initPath = [PES_CORE."Plugin/{$name}", PES_CORE."Public/Plugin/{$name}", PES_CORE."Public/Plugin/{$name}/view"];
        foreach ($initPath as $item){
            if(is_dir($item) == false && mkdir($item) == false  ){
                die(msg("创建'{$name}'应用插件{$item}目录失败，请检查是否有写入权限。"));
            }
            touch("{$item}/index.html");
        }

        $this->createIniFile($name, $initPath['0']);

        $this->creditPHPInitFile($name, $initPath['0']);

        die(msg("应用插件'{$name}'已成功创建！马上开始您的开发之旅吧。"));
    }

    /**
     * 写入应用插件的ini文件信息
     * @param $name 应用名称
     * @param $patch 应用目录
     */
    private function createIniFile($name, $path){
        $iniInfo = ['[plugin]', 'version', 'name', 'enname', 'content', 'author', 'website', 'GROUP', 'status'];
        $iniFopen = fopen("{$path}/plugin.ini", 'w');
        $str = '';
        foreach ($iniInfo as $key => $item){
            if($key == 0){
                $str .= $item.PHP_EOL;
            }elseif ($item == 'enname'){
                $str .= "{$item} = {$name}".PHP_EOL;
            }elseif ($item == end($iniInfo)){
                $str .= "{$item} = disabled".PHP_EOL;
            }else{
                $str .= "{$item} = ".PHP_EOL;
            }
        }
        fwrite($iniFopen, $str);
        fclose($iniFopen);
    }

    /**
     * 创建应用插件Init.php
     * @param $name 应用名称
     * @param $patch 应用目录
     */
    private function creditPHPInitFile($name, $patch){
        $fileContent = [
            'header' => [
                '<?php',
                "namespace Plugin\\{$name};",
                'use \Core\Plugin\PluginController,',
                '    \Core\Plugin\PluginImplements;',
                '',
                'class Init extends PluginController implements PluginImplements {',
            ],
            'content' => [
                'option',
                'enabled',
                'disabled',
                'remove',
                'install',
                'upgrade'
            ],
            'footer' => '}'
        ];
        $fopen = fopen("{$patch}/Init.php", 'w');
        fwrite($fopen, implode(PHP_EOL, $fileContent['header']).PHP_EOL);
        foreach ($fileContent['content'] as $item){
            fwrite($fopen, PHP_EOL."    public function {$item}() {}".PHP_EOL);
        }
        fwrite($fopen, PHP_EOL.$fileContent['footer']);
    }

    /**
     * 打包应用插件
     */
    public function package($name) {
        require_once __DIR__.'/Expand/zip.php';
        $zip = new \Expand\zip();
        $zip->package("{$name}.zip", PES_CORE."Plugin/{$name}");
        $zip->package("{$name}.zip", PES_CORE."Public/Plugin/{$name}");

        die(msg("应用插件'{$name}'已完成打包！打包文件'{$name}'.zip存放在".PES_CORE."目录下。"));

    }

}

$init = new PluginDevelop();
$init->$action(empty($argv['2']) ? '' : $argv['2']);