<?php

namespace Expand;

/**
 * 文件缓存
 */
class FileCache {

    //自定义缓存时间
    public $setTime = 0;
    public $config, $cachePath, $path;

    public function __construct() {
        $this->checkPath();
    }

    /**
     * 验证缓存目录是否存在
     */
    private function checkPath() {
        $this->config = require CONFIG_PATH . 'config.php';

        \Expand\CreatePath::action($this->config['FILE_CACHE_PATH'], PES_CORE);

        $this->cachePath = PES_CORE . $this->config['FILE_CACHE_PATH'];

    }

    /**
     * 创建日志
     * @param type $fileName 缓存文件名称
     * @param type $Content 缓存内容
     */
    public function creatCache($fileName, $content) {
        $file = "{$this->cachePath}/{$fileName}_" . md5(md5($this->config['PRIVATE_KEY'])) . ".txt";
        if (!file_exists("$file")) {
            $fp = fopen("$file", 'w+');
        } else {
            $fp = fopen("$file", 'w+');
        }
        fwrite($fp, time() . "\n");
        fwrite($fp, $content . "\n");
        fclose($fp);
        return $content;
    }

    /**
     * 加载缓存
     * @param $fileName
     * @return bool
     */
    public function loadCache($fileName) {

        //检查是否设置了自定义缓存时间
        $time = !empty($this->setTime) ? $this->setTime : $this->config['FILE_CACHE_TIME'];

        $cacheFile = "{$this->cachePath}/{$fileName}_" . md5(md5($this->config['PRIVATE_KEY'])) . ".txt";
        if (!is_file($cacheFile)) {
            return FALSE;
        }

        $file = file($cacheFile);
        if (time() - intval($file[0]) > $time) {
            return false;
        } else {
            return $file['1'];
        }
    }

}
