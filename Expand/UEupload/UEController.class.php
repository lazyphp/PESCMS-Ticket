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
        $expandPath = PES_PATH . '/Expand/UEupload/';
        $configjson = file_get_contents("{$expandPath}config.json");

        $imgsuffix = \Model\Content::findContent('option', 'upload_img', 'option_name')['value'];
        $filesuffix = \Model\Content::findContent('option', 'upload_file', 'option_name')['value'];


        $CONFIG = json_decode(preg_replace("/\/\*[\s\S]+?\*\//", "", str_replace('{pesupload}', \Core\Func\CoreFunc::loadConfig('UPLOAD_PATH'),
                str_replace('{imgsuffix}', $imgsuffix,
                    str_replace('{filesuffix}', $filesuffix, $configjson))
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
                    \Model\Content::insert('attachment', [
                        'attachment_name' => $info['original'],
                        'attachment_upload_name' => $info['title'],
                        'attachment_path' => $info['url'],
                        'attachment_type' => in_array($info['type'], json_decode($imgsuffix, true)) ? '1' : '2',
                        'attachment_createtime' => time(),
                    ]);
                }
            }
            return $result;
        }
    }

}