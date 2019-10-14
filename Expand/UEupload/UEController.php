<?php
/**
 * PESCMS for PHP 5.4+
 *
 * Copyright (c) 2014 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 */
namespace Expand\UEupload;

class UEController {

    public function action(){
        $expandPath = PES_CORE . '/Expand/UEupload/';
        $configjson = file_get_contents("{$expandPath}config.json");


        $upload = $this->uploadSetting();

        $search = ['{imgsuffix}', '{filesuffix}', '{uploadMaxSize}'];
        $replace = [$upload['upload_img'], $upload['upload_file'], $upload['max_upload_size'] * 1048576];

        $CONFIG = json_decode(preg_replace("/\/\*[\s\S]+?\*\//", "", str_replace('{pesupload}', \Core\Func\CoreFunc::loadConfig('UPLOAD_PATH'),
                str_replace($search, $replace, $configjson)
            )
        ), true);


        $action = $_GET['action'];

        switch ($action) {
            case 'config':
                $result = json_encode($CONFIG);
                break;
            /* 上传图片 */
            case 'uploadimage':
                /* 上传涂鸦 */
            case 'uploadscrawl':
                /* 上传视频 */
            case 'uploadvideo':
                /* 上传文件 */
            case 'uploadfile':
                $result = include("{$expandPath}action_upload.php");
                break;

            /* 列出图片 */
            case 'listimage':
                $result = include("{$expandPath}action_list.php");
                break;
            /* 列出文件 */
            case 'listfile':
                $result = include("{$expandPath}action_list.php");
                break;

            /* 抓取远程文件 */
            case 'catchimage':
                $result = include("{$expandPath}action_crawler.php");
                break;

            default:
                $result = json_encode(array(
                    'state' => '请求地址出错'
                ));
                break;
        }

        /* 输出结果 */
        if (isset($_GET["callback"])) {
            if (preg_match("/^[\w_]+$/", $_GET["callback"])) {
                return htmlspecialchars($_GET["callback"]) . '(' . $result . ')';
            } else {
                return json_encode(array(
                    'state' => 'callback参数不合法'
                ));
            }
        } else {
            $info = json_decode($result, true);
            if(!in_array($action, ['listimage', 'listfile'])){
                //上传成功，顺便将文件信息记录数据库
                if($info['state'] == 'SUCCESS'){

                    $session = \Core\Func\CoreFunc::session()->getAll();


                    switch ($action){
                        case 'uploadimage':
                            $type = 0;
                            break;
                        case 'uploadfile':
                            $type = 1;
                            break;
                        case 'uploadvideo':
                            $type = 3;
                            break;
                    }

                    \Model\Content::insert('attachment', [
                        'attachment_status' => 1,
                        'attachment_path' => $info['url'],
                        'attachment_path_type' => 0,
                        'attachment_createtime' => time(),
                        'attachment_name' => (new \voku\helper\AntiXSS())->xss_clean(trim($info['original'])),
                        'attachment_type' => $type,
                        'attachment_owner' => empty($session['ticket']) ? 0 : 1,
                        'attachment_user_id' => empty($session['ticket']) ? 0 : $session['ticket']['user_id'],
                        'attachment_member_id' => empty($session['member']) ? -1 : $session['member']['member_id']
                    ]);
                }
            }
            return $result;
        }
    }

    /**
     * 上传设置信息
     * @return mixed
     */
    private function uploadSetting(){
        $uploadSetting = \Model\Content::listContent([
            'table' => 'option',
            'condition' => 'option_range = :option_range',
            'param' => ['option_range' => 'upload']
        ]);
        foreach ($uploadSetting as $item){
            $upload[$item['option_name']] = $item['value'];
        }
        return $upload;
    }

}