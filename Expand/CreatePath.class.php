<?php
/**
 * PESCMS for PHP 5.4+
 *
 * Copyright (c) 2014 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
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
    public static function action($path){
        $splitPath = explode('/', $path);
        if(empty($splitPath['0'])){
            array_shift($splitPath);
        }
        $mark = substr(PES_PATH, 0, -1);
        foreach($splitPath as $key => $value){
            $mark .= "/{$value}";
            if(!is_dir($mark) && mkdir($mark) === false && DEBUG === true){
                echo "warning: Create {$mark} path fail!<br/>";
            }else{
                fopen($mark.'/index.html', 'a');
            }
        }

    }

}