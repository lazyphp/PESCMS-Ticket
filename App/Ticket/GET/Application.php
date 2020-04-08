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

        $this->downloadPlugin($plugin);

        $this->success('应用安装完毕');

    }

    /**
     * 升级应用
     */
    public function upgrade(){
        $plugin = $this->isG('name', '请提交您要安装的应用');
        $version = $this->isG('version', '请提交应用版本');
        $enName = $this->isG('enname', '请提交应用的名称');

        $pluginPatch = PES_CORE."Plugin/{$enName}";

        $getPluginInfo = parse_ini_file("{$pluginPatch}/plugin.ini", true);


        if(strcmp($plugin, $getPluginInfo['plugin']['name']) !== 0 || strcmp($enName, $getPluginInfo['plugin']['enname']) !== 0 ){
            $this->error('应用信息不一致，请检查提交信息');
        }

        //开始下载新版本和安装新版文件。
        $this->downloadPlugin($plugin, $version);

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
        $existNewVersion = $this->fetchPlugin($plugin, $newConfig['plugin']['version'], true);
        if($existNewVersion['status'] == 200){
            $this->success("{$plugin}插件执行自动升级中，请勿关闭本页面", $this->url(GROUP.'-Application-upgrade', ['name' => $plugin, 'version' => $newConfig['plugin']['version'], 'enname' => $enName, 'appkey' => $this->g('appkey'), 'method' => 'GET'  ]));
        }else{
            $this->success("{$plugin}插件升级完成", $this->url(GROUP.'-Application-local'));
        }

    }

    /**
     * 下载应用解压
     * @param $plugin 插件名称
     * @param string $version 当前版本号
     */
    private function downloadPlugin($plugin, $version = ''){
        $fileName = \Model\Extra::getOnlyNumber().'.zip';

        $patchSave = APP_PATH.'Temp/'.$fileName;

        $getFile = $this->fetchPlugin($plugin, $version);


        if(empty($getFile)){
            $this->error('获取应用出错');
        }

        $convertResult = json_decode($getFile, true);
        if(!empty($convertResult['msg'])){
            $this->error($convertResult['msg']);
        }

        $download = fopen($patchSave, 'w');
        fwrite($download, $getFile);
        fclose($download);

        if(is_file($patchSave) == false){
            $this->error('下载插件失败');
        }

        $unzipResult = (new \Expand\zip()) ->unzip($patchSave);
        if($unzipResult === false){
            $this->error('解压应用插件出错！请稍后再试.');
        }


        unlink($patchSave);
    }

    /**
     * 获取插件信息
     * @param $plugin 插件名称
     * @param string $version 当前版本号
     * @param bool $check 是否验证存在新版
     * @return bool|string
     */
    private function fetchPlugin($plugin, $version = '', $check = false){
        $system = \Core\Func\CoreFunc::$param['system'];

        $param = [
            'project' => 5,
            'depend' => $system['version'],
            'name' => $plugin,
            'check_version' => $version,
            'check' => $check,
            'appkey' => $_REQUEST['appkey']
        ];

        $result = (new \Expand\cURL())->init(PESCMS_URL."/?g=Api&m=Application&a=download", $param, [
            CURLOPT_HTTPHEADER => [
                'X-Requested-With: XMLHttpRequest',
                'Accept: application/json',
            ]
        ]);

        return $check == true ? json_decode($result, true) : $result;
    }

}