<?php
/**
 * 抓取远程图片
 * User: Jinqn
 * Date: 14-04-14
 * Time: 下午19:18
 */
set_time_limit(0);
include("Uploader.php");

/* 上传配置 */
$config = array(
    "pathFormat" => $CONFIG['catcherPathFormat'],
    "maxSize" => $CONFIG['catcherMaxSize'],
    "allowFiles" => $CONFIG['catcherAllowFiles'],
    "oriName" => "remote.png"
);
$fieldName = $CONFIG['catcherFieldName'];

/* 抓取远程图片 */
$list = array();
$source = isset($_POST[$fieldName]) ? $_POST[$fieldName] : (isset($_GET[$fieldName]) ? $_GET[$fieldName] : []);
if(!empty($source)) {
    $action = htmlspecialchars(trim($_GET['action']));
    foreach ($source as $imgUrl) {
        $item = new \Expand\Uploader($action, $imgUrl, $config, "remote");
        $info = $item->getFileInfo();
        array_push($list, array(
            "state" => $info["state"],
            "url" => $info["url"],
            "size" => $info["size"],
            "title" => htmlspecialchars($info["title"]),
            "original" => htmlspecialchars($info["original"]),
            "source" => htmlspecialchars($imgUrl)
        ));
    }
}

/* 返回抓取数据 */
return json_encode(array(
    'state'=> count($list) ? 'SUCCESS':'ERROR',
    'list'=> $list
));