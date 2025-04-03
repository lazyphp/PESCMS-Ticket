<?php
/**
 * 版权所有 2022 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 */

namespace App\Ticket\GET;

class Setting extends \Core\Controller\Controller {

    /**
     * 系统设置
     */
    public function action(){
        //调试获取$_SERVER信息
        if(isset($_GET['dev'])){
            echo '<pre>';
            print_r($_SERVER);
            echo '</pre>';
            echo '<br/>';
            exit;
        }
        
        $option = [];
        foreach(\Model\Content::listContent(['table' => 'option']) as $key => $value){
            if((is_array(json_decode($value['value'], true)) || $value['option_name'] == 'crossdomain') && $value['option_name'] != 'sms_verify_template'){
                $option[$value['option_name']] = json_decode($value['value'], true);
            }else{
                $option[$value['option_name']] = $value;
            }
        }

        $this->assign($option);
        $this->assign('title', '系统设置');
        $this->layout();
    }

	/**
	 * 邮件发送测试
	 */
	public function emailTest(){
		$email = $this->isG('email', '请提交邮件地址');
		if(\Model\Extra::checkInputValueType($email, 1) === false){
			$this->error('请提交正确的邮件地址');
		}
		(new \Expand\Notice\Mail())->test($email);
	}

    /**
     * 短信测试
     */
    public function mobileTest(){
        $mobile = $this->isG('account', '请输入手机号码');
        $id = $this->isG('template', '请选择模板');

        $viewTicketLinke = \Model\MailTemplate::getViewLink('123456');

        $template = \Model\MailTemplate::matchContent('123456', $id);

        $param = [
            'send_id' => -1,
            'send_account' => $mobile,
            'send_title' => '短信测试',
            'send_content' => $template['2'],
        ];

        $result = (new \Expand\SMS\SMSMain())->send($param);

        echo "<p>当前发送模板: {$template['2']}</p>";
        echo '<pre>';
        echo "------------接口返回的原始数据-------------<br/><br/>";
        print_r($result);
        echo "<br/><br/>------------下面格式化后的模板格式-------------<br/>";
        print_r(json_decode($result));
        echo '</pre>';
        echo '<br/>';
        exit;

    }

    /**
     * 微信模板测试
     */
    public function weixinTest(){

        if(!empty($_GET['debug_access_token'])){
            (new \Expand\weixin())->debug_access_token();
        }

        $account = $this->isG('account', '请填写接收模板消息的微信openid');
        $id = $this->isG('template', '请选择模板');

        $title = \Model\MailTemplate::matchTitle('123456', $id);

        $template = \Model\MailTemplate::matchContent([
            'number' => '123456',
            'view' => \Model\MailTemplate::getViewLink('123456', 3),
            'content' => '测试的内容'], $id);

        $result = (new \Expand\weixin())->sendTemplate([
            'send_id' => -1,
            'send_account' => $account,
            'send_title' => $title[3],
            'send_content' => $template[3]
        ]);

        echo '<pre>';
        echo "您使用的模板ID: {$title['3']} <br/>";
        echo "模板格式: {$template['3']} <br/>";
        echo '<br/>';
        echo "------------下面格式化后的模板格式-------------<br/>";
        print_r(json_decode($template[3], true));
        echo '<br/>';
        echo "------------下面是微信返回的结果---------------<br/>";
        print_r($result);
        echo '</pre>';
        echo '<br/>';
        exit;
    }

    /**
     * 企业微信测试
     */
    public function weixinWorkTest(){
        if(!empty($_GET['debug_access_token'])){
            (new \Expand\weixinWork())->debug_access_token();
        }

        $account = $this->isG('account', '请填写接收消息的企业微信账号');

        $result = (new \Expand\weixinWork())->notice($account, '这是测试的消息内容');

        echo '<pre>';
        echo "您发送消息的账号是: {$account} <br/>";
        echo '<br/>';
        echo "------------下面格式化后的模板格式-------------<br/>";
        print_r(json_decode($result, true));
        echo '<br/>';
        echo "------------下面是微信返回的结果---------------<br/>";
        print_r($result);
        echo '</pre>';
        echo '<br/>';
        exit;
    }

    /**
     * 钉钉企业测试
     */
    public function dingtalkTest(){
        if(!empty($_GET['debug_access_token'])){
            (new \Expand\dingtalk())->debug_access_token();
        }

        $account = $this->isG('account', '请填写接收消息的钉钉企业账号');

        $result = (new \Expand\dingtalk())->notice($account, '这是测试的消息内容'.date('Y-m-d H:i:s'));

        echo '<pre>';
        echo "您发送消息的账号是: {$account} <br/>";
        echo '<br/>';
        echo "<strong>钉钉每天发送是有限额的：500条/天/人</strong> <br/>";
        echo '<br/>';
        echo "------------下面格式化后的模板格式-------------<br/>";
        print_r(json_decode($result, true));
        echo '<br/>';
        echo "------------下面是钉钉企业返回的结果---------------<br/>";
        print_r($result);
        echo '</pre>';
        echo '<br/>';
        exit;
    }

    /**
     * 微信模板测试
     */
    public function wxappTest(){

        if(!empty($_GET['debug_access_token'])){
            (new \Expand\wxapp())->debug_access_token();
        }

        $account = $this->isG('account', '请填写接收模板消息的微信小程序openid');
        $id = $this->isG('template', '请选择模板');

        $title = \Model\MailTemplate::matchTitle('123456', $id);

        $template = \Model\MailTemplate::matchContent('123456', $id);

        $result = (new \Expand\wxapp())->send([
            'send_id' => -1,
            'send_account' => $account,
            'send_title' => $title[6],
            'send_content' => $template[6]
        ]);

        echo '<pre>';
        echo "您使用的模板ID: {$title['6']} <br/>";
        echo "模板格式: {$template['6']} <br/>";
        echo '<br/>';
        echo "------------下面格式化后的模板格式-------------<br/>";
        print_r(json_decode($template[3], true));
        echo '<br/>';
        echo "------------下面是微信返回的结果---------------<br/>";
        print_r($result);
        echo '</pre>';
        echo '<br/>';
        exit;
    }

    /**
     * 检查更新模板
     */
    public function upgrade(){
        $this->assign('title', '检查更新');
        $this->assign('zip', in_array('zip', get_loaded_extensions()));
        $this->layout();
    }

    /**
     * 产品安全验证
     */
    public function authorize(){
        $license = PES_CORE.'/Core/LICENSE.pes';
        $authorize = \Model\Content::findContent('option', 'authorize', 'option_name');
        $result = (new \Expand\cURL())->init('https://www.pescms.com/?g=Api&m=Authorize&a=check', ['key' => $authorize['value']], [
            CURLOPT_HTTPHEADER => [
                'X-Requested-With: XMLHttpRequest',
                'Accept: application/json',
            ]
        ]);

        $authorizeJson = json_decode($result, true);
        if($authorizeJson['status']  == 200 ){
            if(strcmp(trim($_SERVER['HTTP_HOST']), trim($authorizeJson['data']['authorize_domain'])) !== 0){
                is_file($license) ? unlink($license) : '';
                $this->error('授权域名不一致');
            }
            $fopen = fopen($license, 'w+');
            fwrite($fopen, json_encode($authorizeJson['data']));
            fclose($fopen);
            $this->success('授权验证成功');
        }else{
            is_file($license) ? unlink($license) : '';
            $this->error('获取授权失败');
        }
    }

    /**
     * 生成微信小程序
     */
    public function wxapp(){
        $domain = \Core\Func\CoreFunc::$param['system']['domain'];
        if(stripos($domain, 'https://') === false){
            $this->error("小程序调用的网站URL必须是「https://」开头<br/>当前系统设置-基础信息中填写的网站URL是：{$domain}");
        }

        $wxapp = new \Expand\wxapp();
        $result = $wxapp->make();
        if($result['status'] == 200){
            $this->success($result['msg']);
        }else{
            $this->error($result['msg']);
        }
    }

}