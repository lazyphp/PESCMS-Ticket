<?php
/**
 * PESCMS for PHP 5.4+
 *
 * Copyright (c) 2014 PESCMS (http://www.pescms.com)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 * @core version 2.6
 * @version 1.0
 */


namespace Slice\Common;

/**
 * 更新路由规则
 * @package Slice\Ticket
 */
class UpdateRoute extends \Core\Slice\Slice {

    /**
     * 匹配的组
     */
    const MATCH_GROUP = 'Ticket';

    public function before() {

    }

    /**
     * 更新路由规则
     * @description 在非操作路由规则新增/更新，程序将仅判断文件是否存在，不存在则创建。反之则更新路由规则
     */
    public function after() {
        //路由规则文件
        $routeFileName = md5(\Core\Func\CoreFunc::loadConfig('PRIVATE_KEY')) . '_route.php';

        $routePath = PES_PATH . "/Config/Route/{$routeFileName}";
        $routeUrl = PES_PATH . "/Config/RouteUrl/{$routeFileName}";

        //检查路由规则文件是否存在。文件不存在则创建。只有在路由规则编辑中才会触发更新
        if ((is_file($routeUrl) && is_file($routeUrl)) && (GROUP != self::MATCH_GROUP || MODULE != 'Route' || ACTION != 'action')  ) {
            return true;
        }

        $route = \Model\Content::listContent([
            'table' => 'route',
            'condition' => 'route_status = 1',
            'order' => 'route_listsort ASC, route_id DESC'
        ]);

        if (empty($route)) {
          if(is_file($routePath)){
              unlink($routePath);
          }
          if(is_file($routeUrl)){
              unlink($routeUrl);
          }
        } else {
            $routeStr['route'] = $routeStr['url'] = "<?php\r\n return array(\r\n";
            foreach ($route as $key => $value) {
                $routeStr['route'] .= " '{$value['route_rule']}' => '{$value['route_controller']}',  \r\n";
                $routeStr['url'] .= " '{$value['route_hash']}' => '{$value['route_rule']}', \r\n";
            }
            $routeStr['route'] .= ");\r\n";
            $routeStr['url'] .= ");\r\n";

            //写入自定义路由规则
            $routeFopen = fopen($routePath, 'w+');
            fwrite($routeFopen, $routeStr['route']);
            fclose($routeFopen);

            //写入\Core\Func\Core::url()方法使用的匹配路由规则
            $urlFopen = fopen($routeUrl, 'w+');
            fwrite($urlFopen, $routeStr['url']);
            fclose($urlFopen);
        }
    }


}
