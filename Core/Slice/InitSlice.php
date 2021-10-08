<?php

/**
 * 版权所有 2021 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 */

namespace Core\Slice;

/**
 * 初始化切片
 * 定义四个切片：any,get,post,put,delete
 * Class InitSlice
 */
class InitSlice {

    /**
     * 存放切片对象的数组
     */
    public static $slice = [];

    /**
     * 是否优于试图渲染前执行切片after方法。
     */
    public static $beforeViewToExecAfter = false;

    /**
     * 使用魔术方法，对所有声明的切片进行对象初始化
     * @param $name
     * @param $arguments
     */
    public static function __callStatic($name, $arguments) {
        //验证请求类型
        if (strtoupper($name) !== METHOD && $name !== 'any') {
            return false;
        }

        if(self::checkRoute($arguments[2]) === true || self::checkRoute($arguments[0]) === false ){
            return false;
        }

        //实例化切片对象，放入数组
        foreach ($arguments['1'] as $value) {
            $obj = "\\Slice" . $value;
            self::$slice[$value] = new $obj();
        }

    }

    /**
     * 验证路由规则
     * @param $route 路由参数
     * @return bool
     */
    private static function checkRoute($route){
        if(is_array($route)){
            $goingDown = false;
            foreach($route as $value){
                if(strpos(GROUP . '-' . MODULE . '-' . ACTION, self::placeholder($value)) !== false){
                    $goingDown = true;
                }
            }
            return $goingDown;
        }else{
            //匹配控制器路由
            if(strpos(GROUP . '-' . MODULE . '-' . ACTION, self::placeholder($route)) === false){
                return false;
            }else{
                return true;
            }
        }
    }

    /**
     * 快速处理路由的占位符
     * @param $str 需要处理的路由规则
     * @return mixed
     */
    private static function placeholder($str){
        return str_replace([':g', ':m', ':a'], [GROUP, MODULE, ACTION], $str);
    }


}