# PESCMS Ticket  
![mahua](https://img.shields.io/github/tag/lazyphp/PESCMS-Ticket.svg) ![mahua](https://img.shields.io/github/license/lazyphp/PESCMS-Ticket.svg) <a target="_blank" href="http://shang.qq.com/wpa/qunwpa?idkey=70b9d382c5751b7b64117191a71d083fbab885f1fb7c009f0dc427851300be3a"><img border="0" src="http://pub.idqqimg.com/wpa/images/group.png" alt="PESCMS TEAM官方群" title="PESCMS TEAM官方群"></a>     
PESMCS Ticket(下称PT)是一款基于GPLv2协议发布的开源客服工单系统。PT以全新的设计理念，实现一句JS即可嵌入任意页面中，让工单系统变得更加轻便。  
  
## 反馈和建议  
邮箱：sale#pescms.com  
演示地址：[http://ticket.pescms.com](http://ticket.pescms.com)  
反馈问题：[https://www.pescms.com/page/11.html](https://www.pescms.com/page/11.html)  
开发文档：[https://www.pescms.com/d/index](https://www.pescms.com/d/index)  
PESCMS官方QQ 1群：451828934(已满) <a target="_blank" href="http://shang.qq.com/wpa/qunwpa?idkey=70b9d382c5751b7b64117191a71d083fbab885f1fb7c009f0dc427851300be3a"><img border="0" src="http://pub.idqqimg.com/wpa/images/group.png" alt="PESCMS官方1群" title="PESCMS官方1群"></a>  
PESCMS官方QQ 2群：496804032 <a target="_blank" href="https://jq.qq.com/?_wv=1027&k=5HqmNLN"><img border="0" src="http://pub.idqqimg.com/wpa/images/group.png" alt="PESCMS官方2群" title="PESCMS官方2群"></a>  
  
## 运行环境  
PHP 5.6及以上版本  
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

## 其他说明  
除了通过一句话引入JS生成工单，本系统支持站内提交工单，且支持登录验证或沿用JS中的匿名方式提交。  

## 界面预览  
  
#### 工单系统首页  
<a href="http://wx3.sinaimg.cn/large/d2d33fbfgy1fspzl7j8y2j21kw0xdtax.jpg" target="_blank"><img src="http://wx3.sinaimg.cn/large/d2d33fbfgy1fspzl7j8y2j21kw0xdtax.jpg" width="500" /></a>   

#### 提交工单列表  
<a href="http://wx3.sinaimg.cn/large/d2d33fbfgy1fspzl8tsoxj21kw0xdwhi.jpg" target="_blank"><img src="http://wx3.sinaimg.cn/large/d2d33fbfgy1fspzl8tsoxj21kw0xdwhi.jpg" width="500" /></a>   
   
#### 提交工单详细页  
<a href="http://wx1.sinaimg.cn/large/d2d33fbfgy1fspzl9fmggj21kw16c790.jpg" target="_blank"><img src="http://wx1.sinaimg.cn/large/d2d33fbfgy1fspzl9fmggj21kw16c790.jpg" width="500" /></a>   
   
#### 查看工单详细内容以及回复  
<a href="http://wx3.sinaimg.cn/large/d2d33fbfgy1fspzl9yff5j21kw137q7s.jpg" target="_blank"><img src="http://wx3.sinaimg.cn/large/d2d33fbfgy1fspzl9yff5j21kw137q7s.jpg" width="500" /></a>   
   
#### 后台首页  
<a href="http://wx4.sinaimg.cn/large/d2d33fbfgy1fspzl8dm1bj21kw0xdn10.jpg" target="_blank"><img src="http://wx4.sinaimg.cn/large/d2d33fbfgy1fspzl8dm1bj21kw0xdn10.jpg" width="500" /></a>   
   
#### 后台工单列表  
<a href="http://wx3.sinaimg.cn/large/d2d33fbfgy1fspzl7z53fj21kw0xdgpt.jpg" target="_blank"><img src="http://wx3.sinaimg.cn/large/d2d33fbfgy1fspzl7z53fj21kw0xdgpt.jpg" width="500" /></a>   