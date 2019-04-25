<?php

/**
 * Pes for PHP 5.3+
 *
 * Copyright (c) 2014 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 */

namespace Expand;

/**
 * 验证码
 */
class Verify {

    public $height = 30;

    /**
     * 字符串长度
     * @param type $length 验证码长度
     */
    public function createVerify($length = '4', $type = '') {
        switch ($type) {
            case 'num':
                $str = range(1, 9);
                break;
            case 'en':
                $str = array_merge(range('a', 'z'), range('A', 'Z'));
                break;
            default :
                $str = array_merge(range(1, 9), range('a', 'z'), range('A', 'Z'));
        }

        //移除一些容易混淆的字符
        foreach (['o', 'O', 'l', 'I'] as $needle){
            $key = array_search($needle, $str);
            if(!empty($key)){
                unset($str[$key]);
            }
        }

        //打乱数组
        shuffle($str);
        header('Content-Type: image/png');

        //设置验证码大小
        $im = imagecreatetruecolor($length * 32, $this->height);
        //设置背景颜色
        $background = imagecolorallocate($im, 128, 212, 246);
        imagefilledrectangle($im, 0, 0, $length * 32, $this->height, $background);

        //验证码
        $verify = array_slice($str, 0, $length);
        $text = implode(' ', $verify);

        $sessionID = defined('PHPSESSIONID') ? PHPSESSIONID : '';
        \Core\Func\CoreFunc::session($sessionID)->set('verify', md5(strtolower(implode('', $verify))));
        //加载字体
        $font = PES_CORE.'/Expand/Font/RobotoSlab-Regular.ttf';

        //设置验证码颜色
        imagettftext($im, 24, 0, 11, $this->height - 6, $this->randImagecolorallocate($im), $font, $text);

        //设置验证码颜色
        imagettftext($im, 24, 0, 11, $this->height - 6, $this->randImagecolorallocate($im), $font, $text);

        //添加干扰
        $this->randLine($im);
        //添加干扰
        $this->randEllipse($im);

        imagepng($im);
        imagedestroy($im);
    }

    /**
     * 随机生成一个颜色
     */
    private function randImagecolorallocate($img) {
        return imagecolorallocate($img, rand(238, 255), rand(0, 40), rand(0, 255));
    }

    /**
     * 随机划一条横线
     * @param type $img
     * @return type
     */
    private function randLine($img) {
        $timer = rand(0, 3);
        for ($i = 0; $i < $timer; $i++) {
            imageline($img, rand(0, 120), rand(0, 2), rand(0, 30), rand(0, 400), $this->randImagecolorallocate($img));
        }
    }

    /**
     * 随机划一个椭圆
     * @param type $img
     * @return type
     */
    private function randEllipse($img) {
        $timer = rand(0, 10);
        for ($i = 0; $i < $timer; $i++) {
            imageellipse($img, rand(0, 20), rand(0, 50), rand(0, 200), rand(0, 400), $this->randImagecolorallocate($img));
        }
    }

}
