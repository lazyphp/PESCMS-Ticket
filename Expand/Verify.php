<?php
/**
 * 版权所有PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 */
namespace Expand;

class Verify {

    public $height = 30;
    public $bgColor = [238, 238, 238]; // 可配置背景色
    public $fontPath = ''; // 可配置字体路径

    public function __construct($config = []) {
        // 允许通过构造函数配置参数
        foreach ($config as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
        
        // 设置默认字体路径
        if (empty($this->fontPath)) {
            $this->fontPath = PES_CORE . '/Expand/Font/RobotoSlab-Regular.ttf';
        }
    }

    public function createVerify($length = 4, $type = '') {
        $str = $this->getCharacterPool($type);

        // 生成验证码
        $verify = array_rand(array_flip($str), $length);
        $text = implode(' ', $verify);

        // 增加有效期和随机盐值
        $salt = uniqid(mt_rand(), true);
        \Core\Func\CoreFunc::session()->set('verify', [
            'code' => md5(strtolower(implode('', $verify)) . $salt),
            'salt' => $salt,
            'expire' => time() + 300 // 5分钟有效期
        ]);

        // 创建图片
        $im = imagecreatetruecolor($length * 32, $this->height);
        $background = imagecolorallocate($im, 238, 238, 238);
        imagefilledrectangle($im, 0, 0, $length * 32, $this->height, $background);

        // 添加背景噪点
        $this->addNoise($im, $length * 32, $this->height);

        // 加载字体
        $font = PES_CORE . '/Expand/Font/RobotoSlab-Regular.ttf';

        // 随机化字体大小和角度
        for ($i = 0; $i < $length; $i++) {
            $fontSize = rand(18, 28);
            $angle = rand(-15, 15);
            imagettftext($im, $fontSize, $angle, 11 + ($i * 32), $this->height - 6, 
                $this->randImageColor($im), $font, $verify[$i]);
        }

        // 添加干扰
        $this->randLine($im, $length * 32);
        $this->randEllipse($im, $length * 32);

        // 输出图片
        header('Content-Type: image/png');
        imagepng($im);
        imagedestroy($im);
    }

    private function getCharacterPool($type) {
        switch ($type) {
            case 'num':
                $str = range('1', '9');
                break;
            case 'en':
                $str = array_merge(range('a', 'z'), range('A', 'Z'));
                break;
            default:
                $str = array_merge(range('1', '9'), range('a', 'z'), range('A', 'Z'));
        }

        // 移除易混淆字符
        return array_diff($str, ['o', 'O', 'l', 'I']);
    }

    private function randImageColor($img) {
        // 增加颜色对比度，确保与背景区分
        return imagecolorallocate($img, rand(0, 80), rand(0, 80), rand(0, 80));
    }

    private function randLine($img, $width) {
        for ($i = 0; $i < rand(1, 5); $i++) {
            imageline($img, rand(0, $width), rand(0, $this->height), rand(0, $width), rand(0, $this->height), $this->randImageColor($img));
        }
    }

    private function randEllipse($img, $width) {
        for ($i = 0; $i < rand(1, 5); $i++) {
            imageellipse($img, rand(0, $width), rand(0, $this->height), rand(10, 50), rand(10, 50), $this->randImageColor($img));
        }
    }

    private function addNoise($img, $width, $height) {
        // 降低噪点密度，提高可读性
        for ($i = 0; $i < ($width * $height) / 10; $i++) {
            imagesetpixel($img, rand(0, $width), rand(0, $height), $this->randImageColor($img));
        }
    }

    // 添加验证方法
    public function checkVerify($code) {
        $session = \Core\Func\CoreFunc::session()->get('verify');
        
        if (empty($session) || empty($session['code']) || empty($session['salt']) || time() > $session['expire']) {
            return false;
        }
        
        $result = (md5(strtolower($code) . $session['salt']) === $session['code']);
        
        // 验证后立即清除，防止重复使用
        if ($result) {
            \Core\Func\CoreFunc::session()->delete('verify');
        }
        
        return $result;
    }
}