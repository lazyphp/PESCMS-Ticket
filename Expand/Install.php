<?php

/**
 * 版权所有 2022 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 */

namespace Expand;

class Install{

    private $tips, $action, $path;

    public function __construct(int $type, string $path = PES_CORE) {
        if($type == 1){
            $this->tips = '应用';
            $this->action = 'Application';
        }else{
            $this->tips = '主题';
            $this->action = 'ThemeCenter';
        }
        $this->path = $path;
    }


    public function downloadPlugin($plugin, $version = ''){
        $fileName = \Model\Extra::getOnlyNumber().'.zip';

        if(!is_dir(APP_PATH.'Temp') && mkdir(APP_PATH.'Temp') === false ){
            $this->error('程序创建临时目录失败，请检查程序目录是否有足够的写入权限。');
        }

        $patchSave = APP_PATH.'Temp/'.$fileName;

        $getFile = $this->fetchPlugin($plugin, $version);


        if(empty($getFile)){
            $this->error(sprintf('获取%s出错', $this->tips));
        }

        $convertResult = json_decode($getFile, true);
        if(!empty($convertResult['msg'])){
            $this->error($convertResult['msg']);
        }

        $download = fopen($patchSave, 'w');
        fwrite($download, $getFile);
        fclose($download);

        if(is_file($patchSave) == false){
            $this->error(sprintf('下载%s失败', $this->tips));
        }

        $unzipResult = (new \Expand\zip()) ->unzip($patchSave, $this->path);
        if($unzipResult === false){
            $this->error(sprintf('解压%s出错！请稍后再试.', $this->tips));
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
    public function fetchPlugin($plugin, $version = '', $check = false){
        $system = \Core\Func\CoreFunc::$param['system'];

        $param = [
            'project' => 5,
            'depend' => $system['version'],
            'name' => $plugin,
            'check_version' => $version,
            'check' => $check,
            'appkey' => $_REQUEST['appkey']
        ];

        $result = (new \Expand\cURL())->init(PESCMS_URL."/?g=Api&m={$this->action}&a=download", $param, [
            CURLOPT_HTTPHEADER => [
                'X-Requested-With: XMLHttpRequest',
                'Accept: application/json',
            ]
        ]);

        return $check == true ? json_decode($result, true) : $result;
    }

    private function error($msg){
        echo json_encode([
            'status' => 0,
            'msg' => $msg
        ]);
        exit;
    }

}