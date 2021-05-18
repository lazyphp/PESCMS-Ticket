# PESCMS Ticket  
![mahua](https://img.shields.io/github/tag/lazyphp/PESCMS-Ticket.svg) ![mahua](https://img.shields.io/github/license/lazyphp/PESCMS-Ticket.svg)      
PESMCS Ticket(下称PT)是一款基于GPLv2协议发布的开源客服工单系统。PT以全新的设计理念，实现一句JS即可嵌入任意页面中，让工单系统变得更加轻便。PT除了传统的站内工单，还支持微信小程序提交工单，让您的售后处理更加多元化。  
  
## 反馈和建议  
邮箱：sale#pescms.com  
演示地址：[https://ticket.pescms.com](http://ticket.pescms.com)  
反馈问题：[https://www.pescms.com/page/11.html](https://www.pescms.com/page/11.html)  
开发文档：[https://www.pescms.com/d/index](https://www.pescms.com/d/index)  
说明文档：[https://www.pescms.com/d/index/22.html](https://www.pescms.com/d/index/22.html)  
PESCMS官方QQ 1群：451828934(已满) <a target="_blank" href="http://shang.qq.com/wpa/qunwpa?idkey=70b9d382c5751b7b64117191a71d083fbab885f1fb7c009f0dc427851300be3a"><img border="0" src="http://pub.idqqimg.com/wpa/images/group.png" alt="PESCMS官方1群" title="PESCMS官方1群"></a>  
PESCMS官方QQ 2群：496804032 <a target="_blank" href="https://jq.qq.com/?_wv=1027&k=5HqmNLN"><img border="0" src="http://pub.idqqimg.com/wpa/images/group.png" alt="PESCMS官方2群" title="PESCMS官方2群"></a>  
  
## 运行环境  
PHP 7.0及以上版本  
Mysql 5.5及以上版本  
IE浏览器不保证兼容  
  
## 安装使用  
> * 下载并解压程序至您的HTTP运行环境所在目录。  
> * 没有配置虚拟主机，则访问Public目录。反之，请将虚拟主机目录配置到Public  
> * 根据安装程序填写对应数据，完成软件安装。  

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

<script src="PESCMS TICKET生成的工单JS文件" id="ticket"></script>
<script>
    var ticket = PT.createForm("ticket");
</script>
</body>
</html>
```
