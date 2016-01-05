<?php

/**
 * PESCMS自定义路由规则.
 * @version 1.0
 * 建议不要直接在本页编写路由规则.
 * 路由规则应尽量编写于Route目录下.
 */
$route = array();
$routePath = dirname(__FILE__) . '/Route/';
$routeFile = scandir($routePath);
//长度少于等于2结束植入检测.
if (count($routeFile) <= '2') {
    return $route;
}
foreach ($routeFile as $value) {
    if ($value != '.' && $value != '..' && $value != '.DS_Store') {
        $tmpArray = require $routePath . $value;
        if (is_array($tmpArray)) {
            $route = array_merge($route, $tmpArray);
        }
    }
}
return $route;
