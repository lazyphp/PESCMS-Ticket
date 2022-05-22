<?php

namespace App\Ticket\GET;

/**
 * 应用商店
 */
class Application extends \Core\Controller\Controller {

    /**
     * 应用商店列表
     */
    public function index(){
        $plugin = $this->getPluginList();

        $this->assign('installed', json_encode(empty($plugin) ? [] :array_keys($plugin)));
        $this->assign('title', '应用商店');
        $this->layout();
    }

    /**
     * 本地插件
     */
    public function local(){
        $this->assign('list', $this->getPluginList());
        $this->assign('title', '本地应用');
        $this->layout();
    }

    /**
     * 获取插件列表
     * @return mixed
     */
    private function getPluginList(){
        $pluginPath = PES_CORE.'Plugin/';
        $plugin = [];
        $handler = opendir($pluginPath);
        while (($filename = readdir($handler)) !== false) {
            if ($filename != "." && $filename != ".." && is_dir($pluginPath.$filename) ) {

                $pluginConfigFile = $pluginPath.$filename.'/plugin.ini';

                if(is_file($pluginConfigFile) === false){
                    continue;
                }

                $config = parse_ini_file($pluginConfigFile, true);

                $plugin[$config['plugin']['name']] = [
                    'name' => $filename,
                    'index' => "{$filename}-Init",
                    'info' => $config['plugin']
                ];
            }
        }
        closedir($handler);

        return $plugin;

    }

    /**
     * 应用安装
     */
    public function install(){
        $plugin = $this->isP('name', '请提交您要安装的应用');
        $enName = $this->isP('enname', '请提交应用的名称');

        (new \Expand\Install('1'))->downloadPlugin($plugin);

        //获取插件初始化类命名空间。
        $pluginInitNameSpace = "\\Plugin\\{$enName}\\Init";
        $pluginInit = new $pluginInitNameSpace();

        //执行应用插件预设的安装事件
        $pluginInit->install();

        $this->success('应用安装完毕');

    }

    /**
     * 升级应用
     */
    public function upgrade(){
        $plugin = $this->isG('name', '请提交您要升级的应用');
        $version = $this->isG('version', '请提交应用版本号');
        $enName = $this->isG('enname', '请提交应用的名称');

        $pluginPatch = PES_CORE."Plugin/{$enName}";

        $getPluginInfo = parse_ini_file("{$pluginPatch}/plugin.ini", true);


        if(strcmp($plugin, $getPluginInfo['plugin']['name']) !== 0 || strcmp($enName, $getPluginInfo['plugin']['enname']) !== 0 ){
            $this->error('应用信息不一致，请检查提交信息');
        }

        //开始下载新版本和安装新版文件。
        $installObj = new \Expand\Install('1');
        $installObj->downloadPlugin($plugin, $version);

        //获取插件初始化类命名空间。
        $pluginInitNameSpace = "\\Plugin\\{$enName}\\Init";
        $pluginInit = new $pluginInitNameSpace();

        //执行新版预设的升级动作。
        $pluginInit->upgrade();

        //确保插件启用状态与更新前一致。
        $newConfig = $pluginInit->loadConfig($pluginInit);
        $newConfig['plugin']['status'] = $getPluginInfo['plugin']['status'];
        $pluginInit->updateConfig($pluginInit, $newConfig);

        //@todo还差递归升级了~~！！
        $existNewVersion = $installObj->fetchPlugin($plugin, $newConfig['plugin']['version'], true);
        if($existNewVersion['status'] == 200){
            $this->success("{$plugin}插件执行自动升级中，请勿关闭本页面", $this->url(GROUP.'-Application-upgrade', ['name' => $plugin, 'version' => $newConfig['plugin']['version'], 'enname' => $enName, 'appkey' => trim(htmlspecialchars($_REQUEST['appkey'])), 'method' => 'GET'  ]));
        }else{
            $this->success("{$plugin}插件升级完成", $this->url(GROUP.'-Application-local'));
        }

    }


}