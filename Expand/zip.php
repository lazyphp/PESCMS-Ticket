<?php
/**
 * PESCMS for PHP 5.4+
 *
 * Copyright (c) 2016 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
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

    public function unzip($zipfile) {
        $zip = zip_open($zipfile);
        if (!is_resource($zip)) {
            return "压缩包无法打开";
        }

        $this->simulateInstall($zip);

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
    private function simulateInstall($zip) {
        $i = -1;
        $files = [];
        $simulateSuccess = true;

        while ($file = zip_read($zip)) {
            $i++;
            $filename = zip_entry_name($file);

            $foldername = PES_CORE . $filename;

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

}