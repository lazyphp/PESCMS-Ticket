<?php
/**
 * PESCMS for PHP 5.4+
 *
 * Copyright (c) 2015 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 * @core version 2.6
 * @version 1.0
 */

namespace App\Ticket\PUT;

class Setting extends \Core\Controller\Controller {

    /**
     * @todo 需要优化代码
     */
    public function action() {

        foreach (['upload_img', 'upload_file'] as $value) {
            $data[$value] = json_encode(explode(',', str_replace(["\r\n", "\r", " "], '', $_POST[$value])));
        }

        $data['domain'] = $this->isP('domain', '请提交网站域名');
        $data['openindex'] = $this->p('openindex');
        $data['notice_way'] = $this->p('notice_way');
        $data['open_register'] = $this->p('open_register');
        $data['crossdomain'] = !empty($_POST['crossdomain']) ? json_encode(explode("\n", str_replace("\r", "", $this->p('crossdomain')))) : '';

        if(count($_POST['customstatus']) != '4' && count($_POST['customcolor']) != '4'){
            $this->error('请提交工单状态');
        }

        $customstatus = [];
        foreach($_POST['customstatus'] as $key => $value){
            $customstatus[$key]['color'] = $_POST['customcolor'][$key];
            $customstatus[$key]['name'] = $value;
        }

        $data['customstatus'] = json_encode($customstatus);
        $data['mail'] = json_encode($this->p('mail'));
        $data['weixin_api'] = json_encode($this->p('weixin_api'));
        $data['weixinWork_api'] = json_encode($this->p('weixinWork_api'));
        $data['login_verify'] = json_encode($this->p('login_verify'));
        $data['cs_notice_type'] = json_encode($this->p('cs_notice_type'));
        $data['sms'] = json_encode($this->p('sms'));

        foreach($data as $key => $value){
            $this->db('option')->where('option_name = :option_name')->update([
                'value' => $value,
                'noset' => ['option_name'  => $key]
            ]);
        }

        $this->success('保存设置成功!', $this->url('Ticket-Setting-action'));
    }

    /**
     * 自动更新
     * @todo 日后在弄
     */
    public function atUpgrade() {

    }

    /**
     * 手动更新
     */
    public function mtUpgrade() {
        $file = $_FILES['zip'];
        if (pathinfo($file['name'])['extension'] != 'zip') {
            $this->error('请导入zip的更新补丁');
        }

        //获取文件hash值
        $getPatch = json_decode((new \Expand\cURL())->init('https://www.pescms.com/patch/5/'.\Core\Func\CoreFunc::$param['system']['version'], [], [
            CURLOPT_HTTPHEADER => [
                'X-Requested-With: XMLHttpRequest',
                'Content-Type: application/json; charset=utf-8',
                'Accept: application/json',
            ]
        ]), true);
        if(empty($getPatch['status'])){
            $this->error('连接PESCMS服务器失败!');
        }

        if($getPatch['status'] != 200){
            $this->error($getPatch['msg']);
        }

        if(hash_file('sha256', $file['tmp_name']) !== $getPatch['patch_sha256']){
            $this->error('非官方更新补丁!请访问<a href="https://www.pescms.com" target="_blank">PESCMS</a>获取最新的补丁', 'javascript:history.go(-1)', '10');
        }

        (new \Expand\zip()) ->unzip($file['tmp_name']);

        $this->actionini();
        
        $this->assign('info', $this->info);
        $this->layout('Setting_upgrade_info');
    }

    /**
     * 执行数据库更新
     * @return bool|string
     */
    private function actionini(){
        $version = \Core\Func\CoreFunc::$param['system']['version'];

        $ini = APP_PATH . 'Upgrade/action.ini';
        if (!file_exists($ini)) {
            return ['升级配置数据文件不存在'];
        }

        $ini_array = parse_ini_file($ini, true);


        foreach ($ini_array as $iniversion => $value) {
            if (str_replace('.', '', $iniversion) > str_replace('.', '', $version) ) {

                //更新SQL信息
                if (!empty($value['sql'])) {
                    foreach ($value['sql'] as $file) {
                        $sql = file_get_contents(APP_PATH.'/Upgrade/sql/'.$file);
                        if(!empty($sql)){
                            $this->db()->exec($sql);
                        }else{
                            //更新SQL文件失败，则记录起来
                            $this->info[] = "更新SQL文件出错: ".APP_PATH.'/Upgrade/sql/'.$file;
                        }
                    }
                }

                //移除废弃的文件(更名)
                if(!empty($value['delete'])){
                    foreach ($value['delete'] as $file) {
                        if(rename(APP_PATH.$file, APP_PATH.$file.'_remove') != true){
                            $this->info[] = "移除文件出错: ".APP_PATH.$file;
                        }
                    }
                }

                $this->db('option')->where('option_name = :option_name')->update([
                    'value' => $iniversion,
                    'noset' => [
                        'option_name' => 'version'
                    ]
                ]);
            }
        }
        //移除天网杀人的配置意识
        unlink($ini);
        return true;
    }

}