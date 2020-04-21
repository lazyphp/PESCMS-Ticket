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


if (empty($argv) || count($argv) < 2) {
    die(PHP_EOL . "欢迎使用PESCMS应用插件开发工具." . PHP_EOL . "输入-h -help获取更多帮助" . PHP_EOL . PHP_EOL);
}
$command = [
    '-c' => 'create',
    '-p' => 'package',
];

if (in_array($argv['1'], ['-h', '-help'])) {
    $action = 'help';
} elseif (empty($command[$argv['1']])){
    die(PHP_EOL . '未知参数，请输入-h 或者 -help 查看帮助信息.' . PHP_EOL.PHP_EOL);
}elseif (empty($argv['2'])){
    die(PHP_EOL . "  {$argv['1']} 参数不完整，请输入-h 或者 -help 查看帮助信息." . PHP_EOL.PHP_EOL);
}else{
    $action = $command[$argv['1']];
}



class PluginDevelop {

    /**
     * 帮助文档
     */
    public function help() {
        $doc = [
            PHP_EOL . 'PESCMS应用插件开发工具支持如下指令',
            '  -h, -help         查看帮助信息',
            "  -c <应用名称>     快速创建一个新的应用插件.",
            "  -p <应用名称>     将当前开发的应用进行打包."
        ];
        die(implode(PHP_EOL, $doc
            ) . PHP_EOL . PHP_EOL);
    }

    /**
     * 创建一个新的应用插件
     */
    public function create($name) {

    }

    /**
     * 打包应用插件
     */
    public function package($name) {
        require_once __DIR__.'/Expand/zip.php';
        $zip = new \Expand\zip();
        $zip->package("{$name}.zip", PES_CORE."Plugin/{$name}");
        $zip->package("{$name}.zip", PES_CORE."Public/Plugin/{$name}");
    }

}

$init = new PluginDevelop();
$init->$action($argv['2']);