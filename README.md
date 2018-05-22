# PESCMS Ticket  
![mahua](https://img.shields.io/github/tag/lazyphp/PESCMS-Ticket.svg) ![mahua](https://img.shields.io/github/license/lazyphp/PESCMS-Ticket.svg)  
PESMCS Ticket(下称PT)是一款基于GPLv2协议发布的开源客服工单系统。PT以全新的设计理念，实现一句JS即可嵌入任意页面中，让工单系统变得更加轻便。  
## 运行环境
PHP 5.6及以上版本  
Mysql 5.5及以上版本  
IE浏览器不保证兼容  

## 快速使用  
登入系统后台--工单模型--创建工单 。创建完毕后，点击'生成JS'按钮。将JS文件保存到本地。最后在任意的页面中，引入如下代码，则可实现您的工单系统。  
  
```html
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
<!--JQ是必须组件-->
<script src="http://libs.baidu.com/jquery/2.1.4/jquery.min.js"></script>
<!--JQ是必须组件-->

<script src="您的工单JS" id="ticket"></script>
<script>
    var ticket = PT.createForm("ticket");
</script>
</body>
</html>
```

## 其他说明  
除了通过一句话引入JS生成工单，本系统支持站内提交工单，且支持登录验证或沿用JS中的匿名方式提交。  

## 界面预览  
待编辑  

## 反馈和建议  
邮箱：sale#pescms.com  
演示地址：[http://ticket.pescms.com](http://ticket.pescms.com)  
反馈问题:[https://www.pescms.com/page/11.html](https://www.pescms.com/page/11.html)  
开发文档：[https://www.pescms.com/d/index](https://www.pescms.com/d/index)  
QQ群：451828934 <a target="_blank" href="http://shang.qq.com/wpa/qunwpa?idkey=70b9d382c5751b7b64117191a71d083fbab885f1fb7c009f0dc427851300be3a"><img border="0" src="http://pub.idqqimg.com/wpa/images/group.png" alt="PESCMS TEAM官方群" title="PESCMS TEAM官方群"></a> 