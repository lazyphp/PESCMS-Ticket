<?php
/**
 * 版权所有 2022 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 */

namespace Expand;

class zip {

    /**
     * 解压过程的信息，若成功，则返回true。否则返回一个一维数组
     * @var array
     */
    private $info = [];

    /**
     * 记录需要安装的文件信息
     * @var array
     */
    private $installFile = [];

    /**
     * 打包的目录文件列表
     * @var array
     */
    private $packageFile = [];

    /**
     * 解压文件
     * @param $zipfile
     * @return array|bool
     */
    public function unzip($zipfile, $patch = PES_CORE) {
        $zip = zip_open($zipfile);
        if (!is_resource($zip)) {
            return false;
        }

        $this->simulateInstall($zip, $patch);

        $this->install();
        if (empty($this->info)) {
            return true;
        } else {
            return $this->info;
        }
    }

    /**
     * 模拟安装，主要为创建必要的目录
     * @param $zip
     */
    private function simulateInstall($zip, $patch) {
        $i = -1;
        $files = [];
        $simulateSuccess = true;

        while ($file = zip_read($zip)) {
            $i++;
            $filename = zip_entry_name($file);

            $foldername = $patch . $filename;

            //目录或者文件不存在，则创建
            if (!file_exists($foldername)) {
                //检查目录是否可写
                if (!is_writable(dirname($foldername))) {
                    $this->info[] = sprintf('目录"%s"不可写入!', dirname($foldername));
                    continue;
                }

                //是目录，则进行创建
                if (substr($filename, -1, 1) == '/') {
                    if (mkdir($foldername) === false) {
                        $this->info[] = sprintf('创建目录"%s"失败!', $foldername);
                    }
                }
            }


            if (substr($filename, -1, 1) != '/') {
                $this->installFile[$i]['path'] = $foldername;
                $this->installFile[$i]['content'] = zip_entry_read($file, zip_entry_filesize($file));
            }

        }

    }

    /**
     * 执行文件写入
     */
    private function install() {
        if (!empty($this->installFile)) {
            foreach ($this->installFile as $key => $value) {
                $fopen = fopen($value['path'], 'w');
                if (!fwrite($fopen, $value['content'])) {
                    $this->info[] = "文件{$value['path']}无法写入，该文件已经损坏!请还原或手动覆盖文件";
                };
                fclose($fopen);
            }
        }
    }

    /**
     * 打包目录
     * @param $zipName 打包的文件名称
     * @param $path 要打包的目录
     */
    public function package($zipName, $path){
        $this->packageFile = [];
        $this->recursion($path);

        $zip = new \ZipArchive();
        $zip->open($zipName, \ZipArchive::CREATE);   //打开压缩包

        foreach ($this->packageFile as $item){
            if(is_dir($item)){
                $zip->addEmptyDir(str_replace(PES_CORE, '', $item));
            }else{
                $zip->addFile($item, str_replace(PES_CORE, '', $item));
            }
        }
        $zip->close();
    }

    /**
     * 递归指定目录所有文件信息
     * @param $dirName
     */
    private function recursion($dirName){
        $this->packageFile[] = $dirName;
        if ($handle = opendir("$dirName")) {
            while (false !== ($item = readdir($handle))) {
                if ($item != "." && $item != "..") {
                    if (is_dir("{$dirName}/{$item}")) {
                        $this->recursion("{$dirName}/{$item}");
                    } else {
                        $this->packageFile[] = "{$dirName}/{$item}";
                    }
                }
            }
            closedir($handle);
        }
    }

}