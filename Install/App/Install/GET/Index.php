<?php

/**
 * PESCMS for PHP 5.4+
 *
 * Copyright (c) 2014 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 */

namespace Install\App\Install\GET;

class Index extends \Core\Controller\Controller {

    public function __init() {
        if (is_file(PES_PATH . '/Install/install.txt')) {
            $this->error('不能再次执行安装程序！');
        }
    }

    /**
     * 欢迎界面
     */
    public function index() {
        $this->assign('title', '欢迎使用PESCMS Ticket客服工单系统');
        $this->layout();
    }

    /**
     * 验证扩展
     */
    public function config() {
        $phpVersion = explode('.', phpversion());
        $version = "{$phpVersion['0']}.{$phpVersion['1']}";
        $check['version'] =  $version >= 5.4 ? true : false;

        $check['pdo'] = in_array('pdo_mysql', get_loaded_extensions()) ? true : false;

        $check['gd'] = function_exists('gd_info') ? true : false;

        $check['curl'] = function_exists('curl_version') ? true : false;
        $this->assign($check);
        $this->assign('title', '配置信息');
        $this->layout();
    }

    /**
     * 配置选项
     */
    public function option() {
        $data['DB_TYPE'] = 'mysql';
        $data['DB_HOST'] = $this->isP('host', '请填写数据库地址!');
        $data['DB_NAME'] = $this->isP('name', '请填写数据库名称!');
        $data['DB_USER'] = $this->isP('account', '请填写数据库帐号!');
        $data['DB_PWD'] = $this->p('passwd');
        $data['DB_PORT'] = $this->isP('port', '请填写数据库端口!');
        $data['DB_PREFIX'] = 'pes_';
        $data['PRIVATE_KEY'] = substr(md5(uniqid()), '0', '10');
        $data['USER_KEY'] = substr(md5(uniqid()), '10', '10');

        //写入安装配置信息
        $installConfig = require PES_PATH . '/Install/Config/config_same.php';
        $fopen = fopen(PES_PATH . '/Install/Config/config.php', 'w+');
        if (!$fopen) {
            $this->error('文件无法打开，请检测程序安装目录是否设置足够的权限');
        }

        $str = "<?php\n return array(\n";
        foreach (array_merge($data, $installConfig) as $key => $value) {
            $str .= "'{$key}' => '{$value}',\n";
        }
        $str .= ");";
        fwrite($fopen, $str);
        fclose($fopen);

        //创建临时运行配置文件
        $config = require PES_PATH . '/Install/Config/config_array.php';
        $fopen = fopen(PES_PATH . '/Install/Config/config_tmp.php', 'w+');
        if (!$fopen) {
            $this->error('文件无法打开，请检测程序目录是否设置足够的权限');
        }

        $str = "<?php\n return array(\n";
        foreach (array_merge($data, $config) as $key => $value) {
            $str .= "'{$key}' => '{$value}',\n";
        }
        $str .= ");";
        fwrite($fopen, $str);
        fclose($fopen);

        $this->assign('title', '准备安装');

        $this->layout();
    }

    /**
     * 执行安装
     */
    public function doinstall() {
		$data['domain'] = $this->isP('domain', '请填写域名');
        $data['account'] = $this->isP('account', '请填写管理员帐号');
        $data['passwd'] = $this->isP('passwd', '请填写管理员密码');
        $data['name'] = $this->isP('name', '请填写管理员名称');
        $data['mail'] = $this->isP('mail', '请填写管理员邮箱');

        //纯粹为了效果
        $table = array('创建部门列表', '创建用户动态表', '创建字段列表', '创建菜单列表', '创建模型列表', '创建权限节点列表', '创建用户组权限节点', '创建系统消息列表', '创建选项列表', '创建项目列表', '创建报表列表', '创建报表内容列表', '创建任务列表', '创建任务审核列表', '创建任务日志列表', '创建任务补充说明列表', '创建更新列表', '创建用户列表', '创建用户组列表');
        $this->assign('table', json_encode($table));

        $this->assign($data);
        $this->assign('title', '执行安装');
        $this->layout();
    }

    /**
     * 导入数据库
     */
    public function import() {
		$domain = $this->isP('domain', '请填写域名');
        $data['user_account'] = $this->isP('account', '请填写管理员帐号');
        $data['user_password'] = \Core\Func\CoreFunc::generatePwd($data['user_account'].$this->isP('passwd', '请填写管理员密码'), 'PRIVATE_KEY');
        $data['user_name'] = $this->isP('name', '请填写管理员名称');
        $data['user_mail'] = $this->isP('mail', '请填写管理员邮箱');
        $data['user_group_id'] = '1';
        $data['user_status'] = '1';
        $data['user_createtime'] = time();

        //读取数据库文件
        $sqlFile = file_get_contents(PES_PATH . '/Install/InstallDb/install.sql');
        if (empty($sqlFile)) {
            $this->error('无法读取安装SQL文件');
        }

        //配置PDO信息
        $config = \Core\Func\CoreFunc::loadConfig();
        try {
            //创建数据库
            $tmp = new \PDO("mysql:host={$config['DB_HOST']};port={$config['DB_PORT']}", $config['DB_USER'], $config['DB_PWD']);
            $createDb = "CREATE DATABASE IF NOT EXISTS {$config['DB_NAME']} DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";
            $tmp->exec($createDb);
            //连接数据库
            $db = new \PDO("mysql:host={$config['DB_HOST']};port={$config['DB_PORT']};dbname={$config['DB_NAME']}", $config['DB_USER'], $config['DB_PWD']);

        } catch (\PDOException $e) {
            $this->error($e->getMessage());
        }


        //安装数据库文件
        $db->exec($sqlFile);

        $data['user_status'] = '1';

        //写入管理员帐号
        $this->db('user')->insert($data);
		
		//更新网站域名
		$this->db('option')->where('option_name = :option_name')->update([
			'value' => $domain,
			'noset' => [
				'option_name' => 'domain'
			]
		]);

        //更新运行的配置文件
        $config = require PES_PATH . '/Install/Config/config_tmp.php';
        $fopen = fopen(PES_PATH . '/Config/config.php', 'w+');
        if (!$fopen) {
            $this->error('文件无法打开，请检测程序目录是否设置足够的权限');
        }

        $str = "<?php\n \$config = array(\n";

        $urlModelArray['URLMODEL'] = array('index' => 0, 'suffix' => '1');
        foreach (array_merge($config, $urlModelArray) as $key => $value) {
            if(is_array($value)){
                $str .= "'{$key}' => array(\n";
                foreach($value as $ik => $iv){
                    $str .= "'".strtoupper($ik)."' => '{$iv}',\n";
                }
                $str .= "),";
            }else{
                $str .= "'{$key}' => '{$value}',\n";
            }
        }
        $str .= ");\n";
        $str .= file_get_contents(PES_PATH . '/Config/config_same.php');

        fwrite($fopen, $str);
        fclose($fopen);
        //更新根目录的index.php
        $readWriteFile = file_get_contents(PES_PATH . '/Install/Write/index.php');
        $fopen = fopen(PES_PATH . '/index.php', 'w+');
        fwrite($fopen, $readWriteFile);
        fclose($fopen);

        //标记程序已安装和移除安装数据库文件
        unlink(PES_PATH . '/Install/index.php');
        unlink(PES_PATH . '/Install/InstallDb/install.sql');
        fclose(fopen(PES_PATH . '/Install/install.txt', 'w+'));
        fclose(fopen(PES_PATH . '/Install/index.html', 'w+'));

        $this->success('安装完成!');
    }

}
