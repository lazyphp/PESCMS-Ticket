<?php

namespace Expand;

/**
 * 微信小程序接口
 */
class wxapp {

    public $access_token = '', $error;
    public $appID, $appsecret;

    public function __construct() {
        $wxapp_api = json_decode(\Core\Func\CoreFunc::$param['system']['wxapp_api'], true);
        if (empty($wxapp_api['appID']) || empty($wxapp_api['appsecret'])) {
            $this->error = '未配置微信小程序接口信息';
            return $this->error;
        }
        $this->appID = $wxapp_api['appID'];
        $this->appsecret = $wxapp_api['appsecret'];

        $FileCache = new FileCache();
        $FileCache->setTime = 7200;
        $result = $FileCache->loadCache('wxapp_access_token');

        if(empty($result)){
            $result = (new cURL())->init("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$this->appID}&secret={$this->appsecret}");

            if(empty($result)){
                $this->error = '获取微信小程序access_token失败';
                return $this->error;
            }
            $FileCache->creatCache('wxapp_access_token', $result);
        }
        $this->access_token = json_decode($result, true)['access_token'];
        if(empty($this->access_token)){
            $this->error = '解析微信小程序access_token失败';
            return $this->error;
        }
    }

    /**
     * 发送消息
     */
    public function send($param){
        if(!empty($this->error)){
            \Model\Notice::stopSend($param['send_id'], $this->error);
            return $this->error;
        }

        $content = json_decode($param['send_content'], true);



        $data = [
            'touser' => $param['send_account'],
            'template_id' => $param['send_title'], //小程序模板ID
            'page' => '/pages/ticket/detail?number='.$content['ticket_number'],
            'data' => $content['data'],
        ];


        $result = json_decode((new cURL())->init("https://api.weixin.qq.com/cgi-bin/message/subscribe/send?access_token={$this->access_token}", json_encode($data)), true);


        if($result['errcode'] == 0){
            $sendStatus = [
                'msg' => '小程序模板消息发送成功。',
                'status' => 2,
                'second' => 0,
            ];
        }else{
            $sendStatus = [
                'msg' => "小程序模板消息发送失败！{$result['errcode']}",
                'status' => 1,
                'second' => 600,
            ];
        }

        $sendStatus['id'] = $param['send_id'];
        $sendStatus['sequence'] = $param['send_sequence'];
        $sendStatus['full'] = $result;

        \Model\Extra::updateSendStatus($sendStatus);
        

        return $sendStatus;

    }

    /**
     * 测试微信access_token返回内容
     */
    public function debug_access_token(){
        $result = (new cURL())->init("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$this->appID}&secret={$this->appsecret}");
        echo '<pre>';
        echo "微信返回的原始数据：<br/>{$result}";
        echo '<br/>';
        echo '<br/>';
        echo 'PESCMS解析微信返回数据结构:<br/>';
        print_r(json_decode($result));
        echo '</pre>';
        echo '<br/>';
        exit;

    }

    /**
     * 生成微信小程序
     */
    public function make(){
        if(!empty($this->error)){
            return [
                'status' => 0,
                'msg' => $this->error
            ];
        }
        return $this->getFileAndCreateWxapp();
    }

    /**
     * 获取源码并创建微信小程序
     * @param string $dirName
     * @param string $stopDir
     * @return array
     */
    private function getFileAndCreateWxapp($dirName = PES_CORE.'wxapp_sourcecode', $stopDir = PES_CORE.'wxapp_sourcecode'){

        $system = \Core\Func\CoreFunc::$param['system'];

        $search = ['{{siteUrl}}', '{{wxapp_title}}', '{{appid}}', '{{siteLogo}}'];
        $replace = [$system['domain'], $system['siteTitle'], $this->appID, $system['domain'].$system['siteLogo']];

        if ($handle = opendir("$dirName")) {
            while (false !== ($item = readdir($handle))) {
                if ($item != "." && $item != "..") {

                    //创建目录
                    $replacePath = str_replace($stopDir, '', $dirName);
                    if(!is_dir(PES_CORE.'wxapp'.$replacePath)) {
                        mkdir(PES_CORE . 'wxapp' . $replacePath);
                    }

                    if (is_dir("{$dirName}/{$item}")) {
                        $this->getFileAndCreateWxapp("{$dirName}/{$item}");
                    } else {
                        $filePath = "{$dirName}/{$item}";
                        $replaceFilePath = str_replace($stopDir, '', $filePath);
                        $fopen = fopen(PES_CORE . 'wxapp'.$replaceFilePath, 'w+');
                        $code = str_replace($search, $replace, file_get_contents($filePath));
                        fwrite($fopen, $code);
                        fclose($fopen);
                    }
                }
            }
            closedir($handle);

            if ($dirName == $stopDir) {
                return [
                    'status' => 200,
                    'msg' => "微信小程序已经创建完毕"
                ];
            }
        }
    }

}