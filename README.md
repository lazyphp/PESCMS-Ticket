#PESCMS Ticket
PESMCS Ticket(下称PT)是一款基于GPLv2协议发布的开源客服工单系统。PT基于PESCMS2为核心进行开发，以全新的设计理念，实现一句JS即可嵌入任意页面中，让工单系统变得更加轻便。  
##运行环境
PHP 5.4及以上版本  
Mysql 5.5及以上版本  
浏览器不能低于IE8含8  

##快速使用
登入系统后台--工单模型--创建工单 。创建完毕后，点击'生成JS'按钮。将JS文件保存到本地。最后在任意的页面中，引入如下代码，则可实现您的工单系统。  
  
```html
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
<!--以下三个组件为必须加载-->
<link rel="stylesheet" href="http://cdn.amazeui.org/amazeui/2.4.2/css/amazeui.min.css">
<script src="http://libs.baidu.com/jquery/2.1.4/jquery.min.js"></script>
<script src="http://cdn.amazeui.org/amazeui/2.4.2/js/amazeui.min.js"></script>
<!--以上三个组件为必须加载-->

<script src="您的工单JS" id="ticket"></script>
<script>
    var ticket = PT.createForm("ticket");
</script>
</body>
</html>
```
#####需要注意的是，amazeui为必须加载的前端组件。
##界面预览
后台首页  
![mahua](http://ww4.sinaimg.cn/large/d2d33fbfgw1ezoq4h8zobj213v0c2q5a.jpg)  
工单列表  
![mahua](http://ww3.sinaimg.cn/large/d2d33fbfgw1ezoq4gn8vhj213n0dewiq.jpg)  
工单详细页     
![mahua](http://ww3.sinaimg.cn/large/d2d33fbfgw1ezoq4h6k97j213f0m6mzs.jpg)  
自定义工单   
![mahua](http://ww2.sinaimg.cn/large/d2d33fbfgw1ezoq4i0ienj213q0a9acn.jpg)  

##反馈和建议  
邮箱：dev#pescms.com  
演示地址：[http://ticket.pescms.com](http://ticket.pescms.com)  
反馈问题:[http://www.pescms.com/page/11.html](http://www.pescms.com/page/11.html)  
开发文档：[http://www.pescms.com/d/index](http://www.pescms.com/d/index)  
QQ群：451828934 <a target="_blank" href="http://shang.qq.com/wpa/qunwpa?idkey=70b9d382c5751b7b64117191a71d083fbab885f1fb7c009f0dc427851300be3a"><img border="0" src="http://pub.idqqimg.com/wpa/images/group.png" alt="PESCMS TEAM官方群" title="PESCMS TEAM官方群"></a> 