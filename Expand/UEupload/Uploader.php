<?php

/**
 * Created by JetBrains PhpStorm.
 * User: taoqili
 * Date: 12-7-18
 * Time: 上午11: 32
 * UEditor编辑器通用上传类
 */
namespace Expand;

class Uploader {
    private $action;//请求方法
    private $fileField; //文件域名
    private $file; //文件上传对象
    private $base64; //文件上传对象
    private $config; //配置信息
    private $oriName; //原始文件名
    private $fileName; //新文件名
    private $fullName; //完整文件名,即从当前配置目录开始的URL
    private $filePath; //完整文件名,即从当前配置目录开始的URL
    private $fileSize; //文件大小
    private $fileType; //文件类型
    private $stateInfo; //上传状态信息,
    private $imgsuffix;//图片后缀，用来区分本次上传是否图片。
    private $stateMap = array( //上传状态映射表，国际化用户需考虑此处数据的国际化
        "SUCCESS", //上传成功标记，在UEditor中内不可改变，否则flash判断会出错
        "文件大小超出 upload_max_filesize 限制",
        "文件大小超出 MAX_FILE_SIZE 限制",
        "文件未被完整上传",
        "没有文件被上传",
        "上传文件为空",
        "ERROR_TMP_FILE" => "临时文件错误",
        "ERROR_TMP_FILE_NOT_FOUND" => "找不到临时文件",
        "ERROR_SIZE_EXCEED" => "文件大小超出网站限制",
        "ERROR_TYPE_NOT_ALLOWED" => "文件类型不允许",
        "ERROR_CREATE_DIR" => "目录创建失败",
        "ERROR_DIR_NOT_WRITEABLE" => "目录没有写权限",
        "ERROR_FILE_MOVE" => "文件保存时出错",
        "ERROR_FILE_NOT_FOUND" => "找不到上传文件",
        "ERROR_WRITE_CONTENT" => "写入文件内容错误",
        "ERROR_UNKNOWN" => "未知错误",
        "ERROR_DEAD_LINK" => "链接不可用",
        "ERROR_HTTP_LINK" => "链接不是http链接",
        "ERROR_HTTP_CONTENTTYPE" => "链接contentType不正确",
    );

    /**
     * Uploader constructor.
     * @param $action 请求方法
     * @param string $fileField 表单名称
     * @param array $config 配置项
     * @param bool $type | $base64 是否解析base64编码，可省略。若开启，则$fileField代表的是base64编码的字符串表单名
     * @param string $imgsuffix
     */
    public function __construct($action, $fileField, $config, $type = "upload", $imgsuffix = "") {
        $this->action = $action;
        $this->fileField = $fileField;
        $this->config = $config;
        $this->type = $type;
        $this->imgsuffix = $imgsuffix;
        if ($type == "remote") {
            $this->saveRemote();
        } else if ($type == "base64") {
            $this->upBase64();
        } else {
            $this->upFile();
        }
    }

    /**
     * 上传文件的主处理方法
     * @return mixed
     */
    private function upFile() {
        $file = $this->file = $_FILES[$this->fileField];
        if (!$file) {
            $this->stateInfo = $this->getStateInfo("ERROR_FILE_NOT_FOUND");
            return;
        }
        if ($this->file['error']) {
            $this->stateInfo = $this->getStateInfo($file['error']);
            return;
        } else if (!file_exists($file['tmp_name'])) {
            $this->stateInfo = $this->getStateInfo("ERROR_TMP_FILE_NOT_FOUND");
            return;
        } else if (!is_uploaded_file($file['tmp_name'])) {
            $this->stateInfo = $this->getStateInfo("ERROR_TMPFILE");
            return;
        }

        $this->oriName = $file['name'];
        $this->fileSize = $file['size'];
        $this->fileType = $this->getFileExt();
        $this->fullName = $this->getFullName();
        $this->filePath = $this->getFilePath();
        $this->fileName = $this->getFileName();
        $dirname = dirname($this->filePath);

        //检查文件大小是否超出限制
        if (!$this->checkSize()) {
            $this->stateInfo = $this->getStateInfo("ERROR_SIZE_EXCEED");
            return;
        }

        //检查是否不允许的文件格式
        if (!$this->checkType()) {
            $this->stateInfo = $this->getStateInfo("ERROR_TYPE_NOT_ALLOWED");
            return;
        }

        //创建目录失败
        if (!file_exists($dirname) && !mkdir($dirname, 0777, true)) {
            $this->stateInfo = $this->getStateInfo("ERROR_CREATE_DIR");
            return;
        } else if (!is_writeable($dirname)) {
            $this->stateInfo = $this->getStateInfo("ERROR_DIR_NOT_WRITEABLE");
            return;
        }

        //图片则利用GD库进行处理，过滤掉图片木马。同时生成对应的三种图片
        if (!empty($this->imgsuffix) && in_array($this->getFileExt(), json_decode($this->imgsuffix, true))) {
            //对已经上传成功的文件进行安全处理
            $this->grafikaImg($file["tmp_name"], $this->filePath);
            $this->stateInfo = $this->stateMap[0];
        } else {
            //移动文件
            if (!(move_uploaded_file($file["tmp_name"], $this->filePath) && file_exists($this->filePath))) { //移动失败
                $this->stateInfo = $this->getStateInfo("ERROR_FILE_MOVE");
            } else { //移动成功
                $this->stateInfo = $this->stateMap[0];
            }
        }

    }

    /**
     * 处理base64编码的图片上传
     * @return mixed
     */
    private function upBase64() {
        $base64Data = preg_replace('#^data:image/\w+;base64,#i', '', $_POST[$this->fileField]);

        $img = base64_decode($base64Data);

        $this->oriName = $this->config['oriName'];
        $this->fileSize = strlen($img);
        $this->fileType = $this->getFileExt();
        $this->fullName = $this->getFullName();
        $this->filePath = $this->getFilePath();
        $this->fileName = $this->getFileName();
        $dirname = dirname($this->filePath);

        //检查文件大小是否超出限制
        if (!$this->checkSize()) {
            $this->stateInfo = $this->getStateInfo("ERROR_SIZE_EXCEED");
            return;
        }

        //创建目录失败
        if (!file_exists($dirname) && !mkdir($dirname, 0777, true)) {
            $this->stateInfo = $this->getStateInfo("ERROR_CREATE_DIR");
            return;
        } else if (!is_writeable($dirname)) {
            $this->stateInfo = $this->getStateInfo("ERROR_DIR_NOT_WRITEABLE");
            return;
        }

        //移动文件
        if (!(file_put_contents($this->filePath, $img) && file_exists($this->filePath))) { //移动失败
            $this->stateInfo = $this->getStateInfo("ERROR_WRITE_CONTENT");
        } else { //移动成功
            //对已经上传成功的文件进行安全处理
            $this->grafikaImg($this->filePath, $this->filePath);

            $this->stateInfo = $this->stateMap[0];
        }

    }

    /**
     * 拉取远程图片
     * @return mixed
     */
    private function saveRemote() {
        $imgUrl = htmlspecialchars($this->fileField);
        $imgUrl = str_replace("&amp;", "&", $imgUrl);

        //http开头验证
        if (strpos($imgUrl, "http") !== 0) {
            $this->stateInfo = $this->getStateInfo("ERROR_HTTP_LINK");
            return;
        }

        //检查是否不允许的文件格式
        $ext = explode('?', strtolower(strrchr($imgUrl, '.')));
        if (!$this->checkType($ext[0])) {
            $this->stateInfo = $this->getStateInfo("ERROR_TYPE_NOT_ALLOWED");
            return;
        }

        //打开输出缓冲区并获取远程图片
        $img = $this->RequestGet($imgUrl);
        if(empty($img))
        {
            $this->stateInfo = $this->getStateInfo("ERROR_DEAD_LINK");
            return;
        }
        preg_match("/[\/]([^\/]*)[\.]?[^\.\/]*$/", $imgUrl, $m);

        $this->oriName = $m ? $m[1] : "";
        $this->fileSize = strlen($img);
        $this->fileType = $this->getFileExt();
        $this->fullName = $this->getFullName();
        $this->filePath = $this->getFilePath();
        $this->fileName = $this->getFileName();
        $dirname = dirname($this->filePath);

        //检查文件大小是否超出限制
        if (!$this->checkSize()) {
            $this->stateInfo = $this->getStateInfo("ERROR_SIZE_EXCEED");
            return;
        }

        //创建目录失败
        if (!file_exists($dirname) && !mkdir($dirname, 0777, true)) {
            $this->stateInfo = $this->getStateInfo("ERROR_CREATE_DIR");
            return;
        } else if (!is_writeable($dirname)) {
            $this->stateInfo = $this->getStateInfo("ERROR_DIR_NOT_WRITEABLE");
            return;
        }

        //移动文件
        if (!(file_put_contents($this->filePath, $img) && file_exists($this->filePath))) { //移动失败
            $this->stateInfo = $this->getStateInfo("ERROR_WRITE_CONTENT");
        } else { //移动成功
            //对已经上传成功的文件进行安全处理
            $this->grafikaImg($this->filePath, $this->filePath);
            $this->stateInfo = $this->stateMap[0];
        }

    }

    /**
     * 请求get，支持本地文件
     * @author  Devil
     * @blog    http://gong.gg/
     * @version 1.0.0
     * @date    2020-08-07
     * @desc    description
     * @param   [string]          $value        [本地文件路径或者远程url地址]
     * @param   [int]             $timeout      [超时时间（默认10秒）]
     */
    private function RequestGet($value, $timeout = 10)
    {
        // 远程
        if(substr($value, 0, 4) == 'http')
        {
            // 是否有curl模块
            if(function_exists('curl_init'))
            {
                return $this->CurlGet($value, $timeout);
            }
            return file_get_contents($value);
        }

        // 本地文件
        return file_exists($value) ? file_get_contents($value) : '';
    }

    /**
     * curl模拟get请求
     * @author   Devil
     * @blog     http://gong.gg/
     * @version  1.0.0
     * @datetime 2018-01-03T19:21:38+0800
     * @param    [string]           $url        [url地址]
     * @param    [int]              $timeout    [超时时间（默认10秒）]
     * @return   [array]                        [返回数据]
     */
    private function CurlGet($url, $timeout = 10)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_URL, $url);

        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    /**
     * 上传错误检查
     * @param $errCode
     * @return string
     */
    private function getStateInfo($errCode) {
        return !$this->stateMap[$errCode] ? $this->stateMap["ERROR_UNKNOWN"] : $this->stateMap[$errCode];
    }

    /**
     * 获取文件扩展名
     * @return string
     */
    private function getFileExt() {
        return strtolower(strrchr($this->oriName, '.'));
    }

    /**
     * 重命名文件
     * @return string
     */
    private function getFullName() {
        //替换日期事件
        $t = time();
        $d = explode('-', date("Y-y-m-d-H-i-s"));
        $format = $this->config["pathFormat"];
        $format = str_replace("{yyyy}", $d[0], $format);
        $format = str_replace("{yy}", $d[1], $format);
        $format = str_replace("{mm}", $d[2], $format);
        $format = str_replace("{dd}", $d[3], $format);
        $format = str_replace("{hh}", $d[4], $format);
        $format = str_replace("{ii}", $d[5], $format);
        $format = str_replace("{ss}", $d[6], $format);
        $format = str_replace("{time}", $t, $format);

        //过滤文件名的非法自负,并替换文件名
        $oriName = substr($this->oriName, 0, strrpos($this->oriName, '.'));
        $oriName = preg_replace("/[\|\?\"\<\>\/\*\\\\]+/", '', $oriName);
        $format = str_replace("{filename}", $oriName, $format);

        //替换随机字符串
        $randNum = rand(1, 10000000000) . rand(1, 10000000000);
        if (preg_match("/\{rand\:([\d]*)\}/i", $format, $matches)) {
            $format = preg_replace("/\{rand\:[\d]*\}/i", substr($randNum, 0, $matches[1]), $format);
        }

        $ext = $this->getFileExt();
        return $format . $ext;
    }

    /**
     * 获取文件名
     * @return string
     */
    private function getFileName() {
        return substr($this->filePath, strrpos($this->filePath, '/') + 1);
    }

    /**
     * 获取文件完整路径
     * @return string
     */
    private function getFilePath() {
        $fullname = $this->fullName;
        $rootPath = HTTP_PATH;

        if (substr($fullname, 0, 1) != '/') {
            $fullname = '/' . $fullname;
        }

        return $rootPath . $fullname;
    }

    /**
     * 文件类型检测
     * @return bool
     */
    private function checkType($ext = null) {
        $ext = empty($ext) ? $this->getFileExt() : $ext;
        if(in_array(trim($ext), ['.php', '.html'])){
            return false;
        }
        return in_array($ext, $this->config["allowFiles"]);
    }

    /**
     * 文件大小检测
     * @return bool
     */
    private function  checkSize() {
        return $this->fileSize <= ($this->config["maxSize"]);
    }

    /**
     * 获取当前上传成功文件的各项信息
     * @return array
     */
    public function getFileInfo() {
        return array(
            "action" => $this->action,
            "state" => $this->stateInfo,
            "url" => DOCUMENT_ROOT . $this->fullName,
            "title" => $this->fileName,
            "original" => $this->oriName,
            "type" => $this->fileType,
            "size" => $this->fileSize
        );
    }

    /**
     * 图片压缩
     * @param $img 要压缩的图片
     * @param $outName 图片保存的完整路径
     */
    private function grafikaImg($img, $outName){

        $editor = \Grafika\Grafika::createEditor();
        $editor->open( $image, $img);
        $width  = $image->getWidth();
        $height = $image->getHeight();
        $ratio  = $width / $height;

        $resizeWidth  = 150 * $ratio;
        $resizeHeight = 150;
        $editor->save( $image, $outName );

        $editor->resizeFit( $image, $resizeWidth, $resizeHeight );

        $editor->save( $image, "{$outName}_150x150.".pathinfo($outName)['extension'] );

    }

}