<?php
/*
| PESCMS for PHP 5.4+
| @version 2.6
| For the full copyright and license information, please view
| the file LICENSE.md that was distributed with this source code.
|--------------------------------------------------------------------------
| 切片注册
| 程序提供五个方法声明切片绑定的请求类型: any, get, post, put, delete
| 参数一：绑定控制器路由规则。
          依次填写 组-控制器-方法。若为泛匹配，提供3个对应的占位符。
           :g-:m-:a 。如：Ticket-:m-:a 泛匹配组Ticket下任意的控制器以及方法
|         参数可以为字符串或者数组
| 参数二：
|         切片的命名空间。相对于当前Slice目录。不需要填写空间名Slice,如：\Slice\Common\Auto，则填写\Common\Auto
|         注：切片是按照由上至下的顺序进行注册。
|         参数必须为数组
| 参数三:
|         不参与绑定的路由规则。和参数一一样。可以不填写
|         参数可以为字符串或者数组
| 示例代码：
|
| InitSlice::any(['Home', 'Home-Index'], ['\Common\Authenticate']); //路由Home, Home-index 绑定 \Common\Authenticate
|
| InitSlice::any('Admin-Setting-index', ['\Common\Authenticate']); //路由Admin-Setting-index 绑定\Common\Authenticate
|
| InitSlice::any('Admin', ['\Admin\Login'], ['Admin-Login']); //路由Admin 绑定\Admin\Login 但Admin-login不会被绑定
|
|--------------------------------------------------------------------------
|
*/

use \Core\Slice\InitSlice as InitSlice;

$SLICE_ARRYR = [

    /*----------------全局设置部分----------------*/

    //全局切片
    'GLOBAL-SLICE' => [
        'any',
        ['Ticket-:m-:a', 'Form-:m-:a'],
        //注册系统设置
        ['\Common\Option']
    ],


    //后台菜单get请求的输出
    'TICKET-MENU' => [
        'get',
        'Ticket-:m-:a',
        ['\Ticket\Menu'],
        ['Ticket-Login-:a']
    ],

    //全局的工单状态get请求输出
    'TICKET-STATUS' => [
        'get',
        ['Ticket-Index-:a', 'Ticket-Ticket-:a', 'Form-View-:a', 'Form-Member-index'],
        ['\Common\TicketStatus'],
        ['Ticket-Ticket-Login']
    ],

    /*----------------前台部分----------------*/

    //前台登录验证
    'FORM-ACCESS' => [
        'any',
        ['Form-Member-:a', 'Form-Login-:a'],
        ['\Form\Login'],
        ['Form-Login-logout']
    ],

    //跨域的设置
//    'CROSSDOMAIN' => [
//        'any',
//        ['Form-Submit-ticket', 'Form-Index-getSession', 'Form-Index-verify', 'Form-Upload-ueditor'], ['\Form\CrossDomain']
//    ],

    /*----------------后台部分----------------*/

    //后台登录验证、权限管理、后台菜单输出
    'TICKET-ACCESS' => [
        'any',
        'Ticket-:m-:a',
        ['\Ticket\Login', '\Ticket\Menu', '\Ticket\Auth',],
    ],

    //注册自动更新用户组字段的信息
    'TICKET-UPDATE-USERGROUP' => [
        'any',
        ['Ticket-User-:a', 'Ticket-User_group-:a'],
        ['\Ticket\UpdateField\UpdateUserGroupField']
    ],

    //注册自动更新客户分组字段的信息
    'TICKET-UPDATE-MEMBERORGANIZE' => [
        'any',
        ['Ticket-Member-:a', 'Ticket-Member_organize-:a'],
        ['\Ticket\UpdateField\UpdateMemberOrganizeField']
    ],

    //注册自动更新用户组字段的信息
    'TICKET-NODE-PARENT' => [
        'any',
        ['Ticket-Node-:a'],
        ['\Ticket\UpdateField\UpdateNodeParentField']
    ],

    //注册处理节点管理 添加/编辑 提交的表单内容
    'TICKET-NODE-ACTION' => [
        'any',
        ['Ticket-Node-action'], ['\Ticket\HandleForm\HandleNode']
    ],

    //注册自动处理后台用户提交的用户密码表单
    'TICKET-UPDATE-USER-PWD' => [
        'any',
        ['Ticket-User-action'], ['\Ticket\HandleForm\HandleUser']
    ],

    //注册自动处理后台会员提交的会员密码表单
    'TICKET-UPDATE-MEMBER-PWD' => [
        'any',
        ['Ticket-Member-action'],
        ['\Ticket\HandleForm\HandleMember']
    ],

    //注册处理工单表单管理 添加/编辑 提交的表单内容
    'TICKET-FORM-ACTION' => [
        'any',
        ['Ticket-Ticket_form-action'],
        ['\Ticket\HandleForm\HandleModelTicket_form']
    ],

    //注册处理后台 工单模型添加/编辑提交过来的密码表单
    'TICKET-MODEL-ACTION' => [
        'any',
        ['Ticket-Ticket_model-action'],
        ['\Ticket\HandleForm\HandleTicket_model']
    ],

    //注册理路由规则 添加/编辑 提交的表单内容
    'TICKET-ROUTE-ACTION' => [
        'any',
        ['Ticket-Route-action'],
        ['\Ticket\HandleForm\HandleRoute', '\Common\UpdateRoute']
    ],

    //注册回复短语 添加/编辑 提交的表单内容
    'TICKET-PHRASE-ACTION' => [
        'any',
        ['Ticket-Phrase-action'],
        ['\Ticket\HandleForm\HandlePhrase']
    ],

    //注册发送模板 添加/编辑 提交的表单内容
    'TICKET-MAIL_TEMPLATE-ACTION' => [
        'any',
        ['Ticket-Mail_template-action'],
        ['\Ticket\HandleForm\HandleMail_template']
    ],

    //注册系统设置 添加/编辑 提交的表单内容
    'TICKET-SETTING-ACTION' => [
        'any',
        ['Ticket-Setting-action'],
        ['\Ticket\HandleForm\HandleSetting']
    ],

    //注册全局插件访问入口
    'GLOBAL-APPLICATION-PLUGIN' => [
        'any',
        [':g-Application-Plugin'],
        ['\Common\ApplicationPlugin']
    ],

    //注册插件初始化入口
    'TICKET-APPLICATION-Init' => [
        'any',
        ['Ticket-Application-Init'],
        ['\Common\ApplicationPlugin']
    ],

];

//执行切片注册
foreach ($SLICE_ARRYR as $item){
    $method = $item['0'];
    $exclude = empty($item['3']) ? [] : $item['3'];
    InitSlice::$method($item[1], $item[2], $exclude);
}