<?php

/**
 * 版权所有 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 */

namespace Model;

class Theme extends \Core\Model\Model {

    /**
     * 获取主题首页设置信息
     * @return array|mixed
     */
    public static function getThemeIndexSetting() {
        $settingFile = THEME_PATH . '/index.json';
        return is_file($settingFile) ? json_decode(file_get_contents($settingFile), true) : [];
    }

    /**
     * 获取主题首页设置信息
     * @return array 返回模板名称和主题设置信息
     */
    public static function checkIndexSetting() {
        $theme = self::isG('theme', '请提交您要设置首页布局的主题');

        $themeDir = THEME . '/Form/' . $theme;

        if (is_dir($themeDir) === false) {
            self::error('主题不存在');
        }

        $settingFile = $themeDir . '/index.json';

        if (is_file($settingFile) === false) {
            self::error('主题没有设置文件');
        }

        $setting = json_decode(file_get_contents($settingFile), true);


        $indexFieldFile = $themeDir . '/indexField.php';
        $indexField = is_file($indexFieldFile) === false ? [] : require_once $indexFieldFile;

        return [
            'theme'       => $theme,
            'setting'     => $setting,
            'settingFile' => $settingFile,
            'indexField'  => $indexField,
        ];
    }

    /**
     * 获取主题配置信息
     * @param $theme
     * @return array|false
     */
    public static function getThemeINI($theme) {
        $themePatch = THEME . '/Form/' . $theme . '/info.ini';
        return is_file($themePatch) ? parse_ini_file($themePatch, true) : [];
    }

    /**
     * 获取主题配置信息
     * @param $theme
     * @return array|mixed
     */
    public static function getThemeJSON($theme) {
        $themePatch = THEME . '/Form/' . $theme . '/index.json';
        return file_exists($themePatch) ? json_decode(file_get_contents($themePatch), true) : [];
    }

    /**
     * 写入主题配置信息
     * @param $theme
     * @param $data
     * @return void
     */
    public static function writeThemeJSON($theme, $data) {
        $themePatch = THEME . '/Form/' . $theme . '/index.json';
        file_put_contents($themePatch, json_encode($data, JSON_UNESCAPED_UNICODE));
    }

}