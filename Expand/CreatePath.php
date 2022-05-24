<?php
/**
 * 版权所有 2022 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 */

namespace Expand;

/**
 * 快速创建目录
 */
class CreatePath{

    /**
     * 执行目录创建
     * @param $path 目录
     */
    public static function action($path, $basePath = APP_PATH){
        $splitPath = explode('/', $path);
        if(empty($splitPath['0'])){
            array_shift($splitPath);
        }
        $mark = substr($basePath, 0, -1);
        foreach($splitPath as $key => $value){
			if($value == '.' || $value == '..'){
                continue;
            }
            $mark .= "/{$value}";
            if(!is_dir($mark) && mkdir($mark) === false && DEBUG === true){
                echo "warning: Create {$mark} path fail!<br/>";
            }else{
                fopen($mark.'/index.html', 'a');
            }
        }

    }

}