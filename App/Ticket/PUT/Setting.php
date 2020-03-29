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
        $operate = [
            //字符串形式的更新设置
            'str' => [
                'domain',
                'siteLogo',
                'siteTitle',
                'pescmsIntroduce',
                'openindex',
                'indexStyle',
                'open_register',
                'member_review',
                'notice_way',
                'siteContact',
                'siteStyle',
                'authorize',
                'siteKeywords',
                'siteDescription',
                'siteTongji',
                'verifyLength',
                'member_login',
                'weixinRegister',
                'max_upload_size',
            ],
            //基于数组的json更新设置
            'array' => [
                'mail',
                'weixin_api',
                'weixinWork_api',
                'sms',
                'login_verify',
                'cs_notice_type',
                'cs_text'
            ]
        ];
        foreach ($operate as $type => $item){
            foreach ($item as $value){
                $this->db('option')->where('option_name = :option_name')->update([
                    'noset' => [
                        'option_name' => $value
                    ],
                    'value' => $type == 'array' ? json_encode($this->p($value, false)) :  $this->p($value, false)
                ]);
            }

        }


        $this->specialOperate();

        $this->success('保存设置成功!', $this->url('Ticket-Setting-action'));
    }

    /**
     * 特殊格式更新设置
     */
    private function specialOperate(){
        foreach (['upload_img', 'upload_file'] as $value) {
            $data[$value] = json_encode(explode(',', str_replace(["\r\n", "\r", "\n", " "], '', $_POST[$value])));
        }

        //        $data['crossdomain'] = !empty($_POST['crossdomain']) ? json_encode(explode("\n", str_replace("\r", "", $this->p('crossdomain')))) : '';

        if(count($_POST['customstatus']) != '4' && count($_POST['customcolor']) != '4'){
            $this->error('请提交工单状态');
        }
        $customstatus = [];
        foreach($_POST['customstatus'] as $key => $value){
            $customstatus[$key]['color'] = $_POST['customcolor'][$key];
            $customstatus[$key]['name'] = $value;
        }

        $data['customstatus'] = json_encode($customstatus);

        foreach($data as $key => $value){
            $this->db('option')->where('option_name = :option_name')->update([
                'value' => $value,
                'noset' => ['option_name'  => $key]
            ]);
        }
    }

    public function recordTips(){
        switch ($this->p('name')){
            case 'tipsManual':
            case 'ticketModel':
                $name = $this->p('name');
                break;
            default:
                $this->error('未知参数');
        }
        $this->db('option')->where('option_name = :name')->update([
            'noset' => [
                'name' => $name
            ],
            'value' => '1'
        ]);
        $this->success('更新记录成功');
    }

    /**
     * 自动更新
     */
    public function atUpgrade() {
        $getPatch = json_decode((new \Expand\cURL())->init('https://www.pescms.com/patch/5/'.\Core\Func\CoreFunc::$param['system']['version'], [], [
            CURLOPT_HTTPHEADER => [
                'X-Requested-With: XMLHttpRequest',
                'Content-Type: application/json; charset=utf-8',
                'Accept: application/json',
            ]
        ]), true);

        if(empty($getPatch)){
            $this->error('连接PESCMS服务器失败!');
        }

        if($getPatch['status'] == 200){
            $patchSave = APP_PATH.'Upgrade/'.pathinfo($getPatch['data']['update_patch_file'])['basename'];

            $getFile = (new \Expand\cURL())->init("https://www.pescms.com{$getPatch['data']['update_patch_file']}");

            $download = fopen($patchSave, 'w');
            fwrite($download, $getFile);
            fclose($download);

            if(hash_file('sha256', $patchSave) !== $getPatch['data']['patch_sha256'] ){
                exit('哈希值不一致');
            }

            (new \Expand\zip()) ->unzip($patchSave);

            $this->actionini();

            //更新完毕，删除文件
            unlink($patchSave);

            //继续跳转至自动更新方法
            $this->success("{$getPatch['data']['new_version']}升级完毕,自动更新程序正在运行,请勿关闭浏览器", $this->url(GROUP . '-Setting-atUpgrade', ['method' => 'PUT', 'complete' => 1]), '1');

        }elseif($getPatch['status'] == 0){
            //不是从自动更新跳转的，则提示接口信息
            if(empty($_GET['complete'])){
                $this->assign('info', [$getPatch['msg']]);
            }
            $this->upgradeStatistics(\Core\Func\CoreFunc::$param['system']['version']);
            $this->layout('Setting_upgrade_info');
        }else{
            $this->error('解析接口出错');
        }

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
        if(empty($getPatch)){
            $this->error('连接PESCMS服务器失败!');
        }

        if($getPatch['status'] != 200){
            $this->error($getPatch['msg']);
        }

        if(hash_file('sha256', $file['tmp_name']) !== $getPatch['data']['patch_sha256']){
            $this->error('非官方更新补丁!请访问<a href="https://www.pescms.com" target="_blank">PESCMS</a>获取最新的补丁', 'javascript:history.go(-1)', '10');
        }

        (new \Expand\zip()) ->unzip($file['tmp_name']);

        $this->actionini();

        $this->upgradeStatistics($getPatch['data']['new_version']);
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

    /**
     * 官方升级统计
     * @description 本功能仅用于官方统计程序版本的使用情况
     * @param $version
     */
    private function upgradeStatistics($version){
        (new \Expand\cURL())->init('https://www.pescms.com/?g=Api&m=Statistics&a=action', [
            'id' => 3,
            'type' => 2,
            'version' => $version
        ]);
    }

}