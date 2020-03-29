-- MySQL dump 10.13  Distrib 5.6.44, for Linux (x86_64)
--
-- Host: localhost    Database: ticket_install
-- ------------------------------------------------------
-- Server version	5.6.44-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `pes_attachment`
--

DROP TABLE IF EXISTS `pes_attachment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pes_attachment` (
  `attachment_id` int(11) NOT NULL AUTO_INCREMENT,
  `attachment_status` tinyint(4) NOT NULL DEFAULT '0',
  `attachment_path` varchar(1000) NOT NULL DEFAULT '',
  `attachment_createtime` int(11) NOT NULL DEFAULT '0',
  `attachment_name` varchar(255) NOT NULL DEFAULT '',
  `attachment_path_type` int(11) NOT NULL DEFAULT '0',
  `attachment_type` int(11) NOT NULL DEFAULT '0',
  `attachment_user_id` int(11) NOT NULL DEFAULT '0' COMMENT '后台上传用户ID',
  `attachment_member_id` int(11) NOT NULL DEFAULT '-1' COMMENT '前台上传用户ID -1 为匿名',
  `attachment_owner` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`attachment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pes_attachment`
--

LOCK TABLES `pes_attachment` WRITE;
/*!40000 ALTER TABLE `pes_attachment` DISABLE KEYS */;
/*!40000 ALTER TABLE `pes_attachment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pes_category`
--

DROP TABLE IF EXISTS `pes_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pes_category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `category_listsort` int(11) NOT NULL DEFAULT '0',
  `category_status` tinyint(4) NOT NULL DEFAULT '0',
  `category_name` varchar(255) NOT NULL DEFAULT '',
  `category_parent` int(11) NOT NULL DEFAULT '0',
  `category_description` text NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pes_category`
--

LOCK TABLES `pes_category` WRITE;
/*!40000 ALTER TABLE `pes_category` DISABLE KEYS */;
/*!40000 ALTER TABLE `pes_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pes_cssend_template`
--

DROP TABLE IF EXISTS `pes_cssend_template`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pes_cssend_template` (
  `cssend_template_id` int(11) NOT NULL,
  `cssend_template_type` int(11) NOT NULL DEFAULT '0',
  `cssend_template_title` varchar(255) NOT NULL DEFAULT '',
  `cssend_template_content` text NOT NULL,
  PRIMARY KEY (`cssend_template_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pes_cssend_template`
--

LOCK TABLES `pes_cssend_template` WRITE;
/*!40000 ALTER TABLE `pes_cssend_template` DISABLE KEYS */;
INSERT INTO `pes_cssend_template` VALUES (1,1,'新工单提醒','有新工单发起，单号为：{ticket_number} ，请及时处理! 详情: {handle_link}'),(2,3,'客户回复工单提醒','&lt;p&gt;工单单号{ticket_number}有新回复，请及时跟进处理。&lt;span style=&quot;background-color: rgb(255, 255, 255); font-size: 1.6rem;&quot;&gt;详情: {handle_link}&lt;/span&gt;&lt;/p&gt;'),(3,4,'工单转交通知','{user_name}将工单号为{ticket_number}指派给了您，请您协助他/她尽快解决该工单问题。详情: {handle_link}'),(4,504,'工单超时提醒','工单号为：{ticket_number}已在{time_out}分钟内无人受理，请您收到本消息后，尽快处理客户提交的问题。详情: {handle_link}');
/*!40000 ALTER TABLE `pes_cssend_template` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pes_field`
--

DROP TABLE IF EXISTS `pes_field`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pes_field` (
  `field_id` int(11) NOT NULL AUTO_INCREMENT,
  `field_model_id` int(11) NOT NULL,
  `field_name` varchar(128) NOT NULL DEFAULT '',
  `field_display_name` varchar(128) NOT NULL DEFAULT '',
  `field_type` varchar(128) NOT NULL DEFAULT '',
  `field_option` text NOT NULL,
  `field_explain` varchar(128) NOT NULL DEFAULT '',
  `field_default` varchar(128) NOT NULL DEFAULT '',
  `field_required` tinyint(4) NOT NULL DEFAULT '0',
  `field_listsort` int(11) NOT NULL DEFAULT '0',
  `field_list` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否显示于列表',
  `field_form` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否显示于表单 0:否 1:显示',
  `field_status` tinyint(4) NOT NULL DEFAULT '0',
  `field_is_null` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否为空',
  PRIMARY KEY (`field_id`),
  UNIQUE KEY `modle_id` (`field_model_id`,`field_name`),
  KEY `field_name` (`field_name`)
) ENGINE=InnoDB AUTO_INCREMENT=263 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pes_field`
--

LOCK TABLES `pes_field` WRITE;
/*!40000 ALTER TABLE `pes_field` DISABLE KEYS */;
INSERT INTO `pes_field` VALUES (1,1,'name','模型名称','text','','','',1,1,1,1,1,0),(2,1,'title','显示名称','text','','','',1,2,1,1,1,0),(3,1,'search','允许搜索','radio','{\"\\u5173\\u95ed\":\"0\",\"\\u5f00\\u542f\":\"1\"}','','',1,3,1,1,1,0),(4,1,'attr','模型属性','radio','{\"\\u524d\\u53f0\":\"1\",\"\\u540e\\u53f0\":\"2\"}','','',1,4,1,1,1,0),(5,1,'status','模型状态','radio','{\"\\u542f\\u7528\":\"1\",\"\\u7981\\u7528\":\"0\"}','','',1,5,1,1,1,0),(6,2,'model_id','模型ID','text','','','',1,0,0,0,1,0),(7,2,'type','字段类型','select','{\"\\u5206\\u7c7b\":\"category\",\"\\u5355\\u884c\\u8f93\\u5165\\u6846\":\"text\",\"\\u591a\\u884c\\u8f93\\u5165\\u6846\":\"textarea\",\"\\u5355\\u9009\\u6309\\u94ae\":\"radio\",\"\\u590d\\u9009\\u6846\":\"checkbox\",\"\\u5355\\u9009\\u4e0b\\u62c9\\u6846\":\"select\",\"\\u591a\\u9009\\u4e0b\\u62c9\\u6846\":\"multiple\",\"\\u7f16\\u8f91\\u5668\":\"editor\",\"\\u7f29\\u7565\\u56fe\":\"thumb\",\"\\u4e0a\\u4f20\\u56fe\\u7ec4\":\"img\",\"\\u4e0a\\u4f20\\u6587\\u4ef6\":\"file\",\"\\u65e5\\u671f\":\"date\",\"\\u5de5\\u5355\\u6a21\\u578b\":\"ticket\",\"\\u7c7b\\u578b\":\"types\",\"\\u9009\\u9879\\u503c\":\"option\"}','','',1,1,1,1,1,0),(8,2,'name','字段名称','text','','','',1,2,1,1,1,0),(9,2,'display_name','显示名称','text','','','',1,3,1,1,1,0),(10,2,'option','选项值','textarea','','选填， 选填， 此处若没有特殊说明，必须 名称|值 填写、且一行一个选项值，否则将导致数据异常!  注意:目前选项适用于单选，复选，下拉菜单。其余功能填写也不会产生任何实际效果。','',0,4,0,1,1,0),(11,2,'explain','字段说明','textarea','','','',0,5,0,1,1,0),(12,2,'default','默认值','text','','','',0,6,0,1,1,0),(13,2,'required','是否必填','radio','{\"\\u662f\":\"1\",\"\\u5426\":\"0\"}','','',1,7,1,1,1,0),(14,2,'list','显示列表','radio','{\"\\u663e\\u793a\":\"1\",\"\\u9690\\u85cf\":\"0\"}','','',1,8,1,1,1,0),(15,2,'form','显示表单','radio','{\"\\u663e\\u793a\":\"1\",\"\\u9690\\u85cf\":\"0\"}','','',1,9,1,1,1,0),(16,2,'status','字段状态','radio','{\"\\u542f\\u7528\":\"1\",\"\\u7981\\u7528\":\"0\"}','','',1,11,1,1,1,0),(17,2,'listsort','排序','text','','','',0,99,0,1,1,0),(18,3,'name','菜单名称','text','','','',1,2,1,1,1,0),(19,3,'pid','菜单层级','select','','','',1,1,1,1,1,0),(20,3,'icon','菜单图标','text','','','',1,5,1,1,1,0),(21,3,'link','菜单地址','text','{&quot;\\u82e5\\u9009\\u62e9\\u7ad9\\u5185\\u94fe\\u63a5\\uff0c\\u8bf7\\u4ee5\\u7ec4-\\u63a7\\u5236\\u5668-\\u65b9\\u6cd5\\u5f62\\u5f0f\\u586b\\u5199\\u3002&quot;:&quot;&quot;}','','',0,4,1,1,1,0),(22,3,'listsort','排序','text','','','',0,6,1,1,1,0),(67,6,'status','状态','radio','{\"\\u7981\\u7528\":\"0\",\"\\u542f\\u7528\":\"1\"}','','1',1,100,1,1,1,0),(69,6,'createtime','发布时间','date','','','',0,99,0,0,0,0),(70,7,'status','状态','radio','{\"\\u7981\\u7528\":\"0\",\"\\u542f\\u7528\":\"1\"}','','1',1,100,1,1,1,0),(73,7,'account','会员帐号','text','','','',1,2,1,1,1,0),(75,7,'password','会员密码','text','','新增用户时,密码为必填.编辑用户时为空则表示不修改密码','',0,3,0,1,1,0),(76,7,'mail','邮箱地址','text','','','',1,4,1,1,1,0),(77,7,'name','会员名称','text','','','',1,5,1,1,1,0),(78,7,'group_id','用户组','select','{\"\\u7ba1\\u7406\\u5458\":1,\"\\u5ba2\\u670d\\u4eba\\u5458\":2,\"\\u6295\\u8bc9\\u53cd\\u9988\":3}','','',1,1,1,1,1,0),(79,6,'name','用户组名称','text','','','',1,1,1,1,1,0),(136,13,'name','节点名称','text','','','',1,3,0,1,1,0),(137,13,'parent','所属菜单','select','{\"\\u8bf7\\u9009\\u62e9\":\"\",\"\\u9876\\u5c42\\u83dc\\u5355\":\"0\",\"\\u9996\\u9875\":1,\"\\u5de5\\u5355\\u5217\\u8868\":2,\"\\u5de5\\u5355\\u8bbe\\u7f6e\":7,\"\\u7528\\u6237\\u7ba1\\u7406\":21,\"\\u5206\\u7c7b\\u7ba1\\u7406\":76,\"\\u7cfb\\u7edf\\u8bbe\\u7f6e\":43,\"\\u6a21\\u578b\\u7ba1\\u7406\":58,\"\\u6742\\u9879\\u8282\\u70b9\":11}','本选项仅用于布置当前权限节点显示于何方。','',1,1,0,1,1,0),(138,13,'verify','是否验证','radio','{&quot;\\u4e0d\\u9a8c\\u8bc1&quot;:&quot;0&quot;,&quot;\\u9a8c\\u8bc1&quot;:&quot;1&quot;}','','',0,4,0,1,1,0),(139,13,'msg','提示信息','text','','','',0,5,0,1,1,0),(140,13,'method_type','请求方法','select','{&quot;GET&quot;:&quot;GET&quot;,&quot;POST&quot;:&quot;POST&quot;,&quot;PUT&quot;:&quot;PUT&quot;,&quot;DELETE&quot;:&quot;DELETE&quot;}','','',0,6,0,1,1,0),(141,13,'value','节点匹配值','text','','若选择父类节点为控制器，请填写控制器名称。反之填写方法名。区分大小写','',0,7,0,1,1,0),(142,13,'check_value','验证值','text','','','',0,8,0,0,1,0),(151,15,'status','状态','radio','{\"\\u7981\\u7528\":\"0\",\"\\u542f\\u7528\":\"1\"}','','1',1,6,1,1,1,0),(153,15,'number','工单ID','text','','','',1,2,1,0,1,0),(154,15,'name','工单名称','text','','','',1,3,0,1,1,0),(155,16,'model_id','工单模型ID','text','','','',1,4,0,0,1,0),(156,16,'name','工单表单字段名称','text','','建议以英语字母下划线填写！否则容易引起工单内容提交丢失的现象。','',1,3,0,1,1,0),(157,16,'description','工单字段显示名称','text','','告诉用户该表单的作用','',1,5,1,1,1,0),(158,16,'explain','工单表单说明','text','','非必填，告诉用户此工单表单的作用','',0,10,0,1,1,0),(159,16,'msg','工单提示信息','text','','非必填，提交失败返回的显示信息','',0,40,0,1,1,0),(160,16,'type','工单表单类型','select','','','',1,50,1,1,1,0),(161,16,'option','工单表单的选项值','option','','目前选项适用于单选，复选，下拉菜单。其余功能填写也不会产生任何实际效果。','',0,60,0,1,1,0),(162,16,'verify','工单表单验证类型','select','','','',0,70,1,1,1,0),(163,16,'required','工单表单是否必填','radio','{\"\\u975e\\u5fc5\\u586b\":\"0\",\"\\u5fc5\\u586b\":\"1\"}','','',1,80,1,1,1,0),(164,16,'status','工单表单启用状态','radio','{\"\\u7981\\u7528\":\"0\",\"\\u542f\\u7528\":\"1\"}','','',1,98,1,1,1,0),(165,16,'listsort','工单表单排序值','text','','升序','',0,99,0,1,1,0),(166,16,'bind','联动显示','select','','若需联动显示，请设置绑定的表单选项，当用户选择该选项时会触发本表单的显示。\r\n注：仅限单选、单选下拉框。','',0,2,0,1,1,0),(167,16,'bind_value','联动触发值','checkbox','','此处填写用户选择了绑定的表单的触发值。','',0,1,0,1,1,0),(168,15,'login','登录验证','radio','{&quot;\\u4e0d\\u9a8c\\u8bc1&quot;:&quot;0&quot;,&quot;\\u9a8c\\u8bc1&quot;:&quot;1&quot;}','','1',1,4,1,1,1,0),(169,15,'verify','开启验证码','radio','{\"\\u5173\\u95ed\":\"0\",\"\\u5f00\\u542f\":\"1\"}','','1',1,5,1,1,1,0),(170,4,'controller','路由控制器','text','','控制器填写以‘-’为分隔符，分别以：组-控制器名称-方法 形式填写。若是默认组的控制器，那么可以忽略填写组参数。','',1,2,1,1,1,0),(171,4,'param','显式参数','text','','若URL存在GET参数，填写上该参数，以半角逗号隔开。如有三个参数a，b，c。那么填写为：a,b,c','',0,3,1,1,1,0),(172,4,'rule','路由规则','text','','若链接中存在显式参数，那么用左右大括号包围着。如参数number，那么路由规则这样写：route/{number}。同时规则开头不要添加任何字符，且分隔符只能为\'/\'','',1,4,1,1,1,0),(173,4,'title','路由名称','text','','建议填写，以免路由规则过多时，自己也不清楚谁是他的爹。','',0,1,1,1,1,0),(174,4,'hash','路由哈希值','text','','','',1,99,0,0,1,0),(175,4,'listsort','排序','text','','','',0,100,1,1,1,0),(176,4,'status','启用状态','radio','{&quot;\\u542f\\u7528&quot;:&quot;1&quot;,&quot;\\u7981\\u7528&quot;:&quot;0&quot;}','','',1,7,1,1,1,0),(177,13,'controller','父类节点','select','{\"\\u8bf7\\u9009\\u62e9\":\"\",\"\\u9876\\u5c42\\u8282\\u70b9\":\"0\",\"\\u975e\\u6743\\u9650\\u8282\\u70b9\":\"-1\",\"\\u5b57\\u6bb5\\u7ba1\\u7406\":59,\"\\u5de5\\u5355\\u6a21\\u578b\":8,\"\\u5de5\\u5355\\u8868\\u5355\":9,\"\\u5de5\\u5355\\u5217\\u8868\":2,\"\\u7528\\u6237\\u7ec4\":22,\"\\u8282\\u70b9\\u7ba1\\u7406\":23,\"\\u7528\\u6237\\u7ba1\\u7406\":21,\"\\u5206\\u7c7b\\u7ba1\\u7406\":76,\"\\u83dc\\u5355\\u8bbe\\u7f6e\":46,\"\\u8def\\u7531\\u89c4\\u5219\":52,\"\\u7cfb\\u7edf\\u8bbe\\u7f6e\":43,\"\\u90ae\\u4ef6\\u6a21\\u677f\":70,\"\\u5e38\\u89c1\\u95ee\\u9898\":84,\"\\u9644\\u4ef6\\u7ba1\\u7406\":93,\"\\u53d1\\u9001\\u5217\\u8868\":99,\"\\u6a21\\u578b\\u7ba1\\u7406\":58}','','',1,2,1,1,1,0),(178,13,'listsort','排序','text','','','',0,99,1,1,1,0),(179,3,'type','链接类型','radio','{&quot;\\u7ad9\\u5185\\u94fe\\u63a5&quot;:&quot;0&quot;,&quot;\\u7ad9\\u5916\\u8fde\\u63a5&quot;:&quot;1&quot;}','','',1,3,1,1,1,0),(183,17,'type','模板类型','select','{&quot;\\u65b0\\u5de5\\u5355&quot;:&quot;1&quot;,&quot;\\u53d7\\u7406\\u5de5\\u5355&quot;:&quot;2&quot;,&quot;\\u56de\\u590d\\u5de5\\u5355&quot;:&quot;3&quot;,&quot;\\u8f6c\\u4ea4\\u5ba2\\u670d&quot;:&quot;4&quot;,&quot;\\u5de5\\u5355\\u5b8c\\u6210&quot;:&quot;5&quot;,&quot;\\u5de5\\u5355\\u5173\\u95ed&quot;:&quot;6&quot;}','','',1,1,1,1,1,0),(184,17,'title','邮件标题','text','','','',1,2,1,1,1,0),(185,17,'content','邮件模板内容','editor','','','',1,3,0,1,1,0),(186,15,'cid','所属分类','category','','','',1,1,1,1,1,0),(187,18,'status','状态','radio','{&quot;\\u7981\\u7528&quot;:&quot;0&quot;,&quot;\\u542f\\u7528&quot;:&quot;1&quot;}','','1',1,100,1,1,1,0),(188,18,'listsort','排序','text','','','',0,98,1,1,1,0),(190,18,'name','分类名称','text','','','',1,2,1,1,1,0),(191,18,'parent','所属父类','select','','','',1,1,1,1,1,0),(192,18,'description','分类描述','textarea','','','',1,3,1,1,1,0),(193,15,'listsort','排序值','text','','','',0,99,1,1,1,0),(194,15,'explain','工单说明','editor','','','',0,10,0,1,1,0),(204,20,'status','状态','radio','{\"\\u7981\\u7528\":\"0\",\"\\u542f\\u7528\":\"1\"}','','1',1,100,1,1,1,0),(206,20,'createtime','创建时间','date','','','',0,99,1,1,1,0),(207,20,'email','邮箱地址','text','','','',1,1,1,1,1,0),(208,20,'password','用户密码','text','','','',0,2,0,1,1,0),(209,20,'name','用户名称','text','','','',1,3,1,1,1,0),(210,20,'phone','手机号码','text','','','',1,4,1,1,1,1),(211,15,'group_id','管辖用户组','multiple','{\"\\u7ba1\\u7406\\u5458\":1,\"\\u5ba2\\u670d\\u4eba\\u5458\":2,\"\\u6295\\u8bc9\\u53cd\\u9988\":3}','绑定对应的用户组，当前工单模型有新工单，将会发送通知给该用户组下的所有成员。','',1,7,1,1,1,0),(212,21,'account','接收帐号','text','','','',1,1,1,1,1,0),(213,21,'title','发送标题','text','','','',1,2,1,1,1,0),(214,21,'content','发送内容','editor','','','',1,3,0,1,1,0),(215,21,'time','生成时间','date','','','',1,5,1,1,1,0),(216,21,'type','发送方式','select','{&quot;\\u90ae\\u7bb1&quot;:&quot;1&quot;,&quot;\\u624b\\u673a&quot;:&quot;2&quot;,&quot;\\u5fae\\u4fe1&quot;:&quot;3&quot;,&quot;\\u4f01\\u4e1a\\u5fae\\u4fe1&quot;:&quot;4&quot;}','','',1,4,1,1,1,0),(217,7,'weixinWork','企业微信ID','text','','','',0,6,1,1,1,1),(218,2,'is_null','是否为空','radio','{&quot;\\u5426&quot;:&quot;0&quot;,&quot;\\u662f&quot;:&quot;1&quot;}','','',0,7,1,1,1,0),(219,17,'sms','短信模板内容','textarea','','请先在短信平台添加模板，在按照模板格式，在此处填写通知内容。','',1,4,0,1,1,0),(221,22,'listsort','排序','text','','','',0,98,1,1,1,0),(223,22,'name','短语名称','text','','','',0,1,1,1,1,0),(224,22,'content','内容','editor','','','',1,2,0,1,1,0),(225,22,'user_id','所属者','text','','','',0,90,0,0,1,0),(226,23,'status','状态','radio','{\"\\u7981\\u7528\":\"0\",\"\\u542f\\u7528\":\"1\"}','','1',1,100,1,1,1,0),(227,23,'listsort','排序','text','','','',0,98,1,1,1,0),(228,23,'createtime','创建时间','date','','','',0,99,1,1,1,0),(229,23,'ticket_model_id','对应工单','ticket','','','',1,1,1,1,1,0),(230,23,'title','标题','text','','','',1,2,1,1,1,0),(231,23,'content','详细内容','editor','','','',1,3,0,1,1,0),(232,17,'weixin_template_id','微信模板ID','text','','','',0,5,1,1,1,0),(233,17,'weixin_template','微信模板内容','textarea','','请按照微信公众号选择模板的格式填写对应的参数。','',0,6,0,1,1,0),(234,21,'result','执行结果','text','','','',1,2,1,1,1,0),(235,20,'weixin','微信OPENID','text','','','',0,10,1,1,1,1),(236,1,'page','分页数','text','','','10',1,5,1,1,1,0),(237,15,'time_out','工单超时时长(分钟)','text','','有新工单提交后，在指定时间内无人受理工单，系统将发送通知给工单所在的管辖组成员。','10',1,8,1,1,1,0),(238,15,'time_out_sequence','超时提醒次数','text','','工单无人受理超时通知次数，系统将按照工单超时时长的间隔进行重复通知。','1',1,9,0,1,1,0),(239,20,'account','登陆账号','text','','','',1,1,1,1,1,0),(240,15,'contact','联系方式','checkbox','{&quot;\\u90ae\\u4ef6&quot;:&quot;1&quot;,&quot;\\u624b\\u673a\\u53f7\\u7801&quot;:&quot;2&quot;,&quot;\\u5fae\\u4fe1&quot;:&quot;3&quot;}','','',1,12,1,1,1,0),(241,15,'contact_default','默认联系方式','radio','{&quot;\\u90ae\\u4ef6&quot;:&quot;1&quot;,&quot;\\u624b\\u673a\\u53f7\\u7801&quot;:&quot;2&quot;,&quot;\\u5fae\\u4fe1&quot;:&quot;3&quot;}','','',1,13,0,1,1,0),(242,15,'postscript','页内指引','editor','','填写此项，在工单提交内页顶部将显示这部分填写的内容。','',0,11,0,1,1,0),(243,15,'default_send','默认发送通知','radio','{&quot;\\u5426&quot;:&quot;0&quot;,&quot;\\u662f&quot;:&quot;1&quot;}','选择是，则当前工单模型的工单处理过程，默认发送通知复选框会勾上。','',0,14,0,1,1,0),(244,16,'postscript','工单表单详细说明','editor','','若需要对当前表单字段有更加完整的说明，请在此处填写。','',0,11,0,1,1,0),(245,24,'status','状态','radio','{\"\\u7981\\u7528\":\"0\",\"\\u542f\\u7528\":\"1\"}','','1',1,100,1,1,1,0),(246,24,'createtime','创建时间','date','','','',0,99,1,1,1,0),(247,24,'name','附件名称','text','','','',1,2,1,1,1,0),(248,24,'path','附件地址','text','','','',1,3,1,1,1,0),(249,24,'path_type','存储位置','radio','{&quot;\\u672c\\u5730\\u786c\\u76d8&quot;:&quot;0&quot;}','','',1,4,1,1,1,0),(250,24,'type','附件类型','radio','{&quot;\\u56fe\\u7247&quot;:&quot;0&quot;,&quot;\\u6587\\u4ef6&quot;:&quot;1&quot;,&quot;\\u591a\\u5a92\\u4f53&quot;:&quot;3&quot;}','','',1,1,1,1,1,0),(251,24,'owner','上传方','radio','{&quot;\\u524d\\u53f0\\u7528\\u6237&quot;:&quot;0&quot;,&quot;\\u540e\\u53f0\\u7ba1\\u7406&quot;:&quot;1&quot;}','','',1,94,1,1,1,0),(252,6,'view_type','允许查看所有用户','radio','{&quot;\\u5426&quot;:&quot;0&quot;,&quot;\\u662f&quot;:&quot;1&quot;}','若您希望本用户组的用户可以查看所有用户信息，请勾选是。','',1,2,1,1,1,0),(253,15,'open_close','是否自动关闭工单','radio','{&quot;\\u7981\\u7528&quot;:&quot;0&quot;,&quot;\\u5f00\\u542f&quot;:&quot;1&quot;}','开启此选项后，当工单状态为0，即没有客服处理，在达到设定的时间后，将会自动关闭。','',1,15,1,1,1,0),(254,15,'close_time','自动关闭时长(分钟)','text','','','',0,16,0,1,1,0),(255,25,'type','类型','select','{&quot;\\u65b0\\u5de5\\u5355\\u63d0\\u9192&quot;:&quot;1&quot;,&quot;\\u5ba2\\u6237\\u56de\\u590d\\u5de5\\u5355\\u63d0\\u9192&quot;:&quot;3&quot;,&quot;\\u5de5\\u5355\\u8f6c\\u4ea4\\u901a\\u77e5&quot;:&quot;4&quot;,&quot;\\u5de5\\u5355\\u8d85\\u65f6\\u63d0\\u9192&quot;:&quot;504&quot;}','','',1,1,1,1,1,0),(256,25,'title','模板标题','text','','','',1,2,1,1,1,0),(257,25,'content','模板内容','editor','','','',1,3,0,1,1,0),(258,15,'exclusive','允许指定客服受理','radio','{&quot;\\u5426&quot;:&quot;0&quot;,&quot;\\u662f&quot;:&quot;1&quot;}','开启此功能后，客户在提交工单时，将直接分配给填入名称的客服帐号。','',0,17,0,1,1,0),(259,7,'job_number','工号','text','','','',1,2,1,1,1,0),(260,26,'name','分组名称','text','','','',1,1,1,1,1,0),(261,20,'organize_id','所属分组','select','{\"\\u9ed8\\u8ba4\\u5206\\u7ec4\":1}','','',1,1,1,1,1,0),(262,15,'organize_id','指定客户分组可见','multiple','{\"\\u9ed8\\u8ba4\\u5206\\u7ec4\":1}','若您需要指定客户才可以见到此工单，那么请选择该客户对应的客户分组。','',0,98,0,1,1,0);
/*!40000 ALTER TABLE `pes_field` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pes_findpassword`
--

DROP TABLE IF EXISTS `pes_findpassword`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pes_findpassword` (
  `findpassword_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `findpassword_mark` varchar(255) NOT NULL DEFAULT '' COMMENT '标记',
  `findpassword_createtime` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`findpassword_id`),
  UNIQUE KEY `findpassword_mark` (`findpassword_mark`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='查找密码';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pes_findpassword`
--

LOCK TABLES `pes_findpassword` WRITE;
/*!40000 ALTER TABLE `pes_findpassword` DISABLE KEYS */;
/*!40000 ALTER TABLE `pes_findpassword` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pes_fqa`
--

DROP TABLE IF EXISTS `pes_fqa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pes_fqa` (
  `fqa_id` int(11) NOT NULL AUTO_INCREMENT,
  `fqa_listsort` int(11) NOT NULL DEFAULT '0',
  `fqa_status` tinyint(4) NOT NULL DEFAULT '0',
  `fqa_url` varchar(255) NOT NULL DEFAULT '',
  `fqa_createtime` int(11) NOT NULL DEFAULT '0',
  `fqa_ticket_model_id` int(11) NOT NULL DEFAULT '0',
  `fqa_title` varchar(255) NOT NULL DEFAULT '',
  `fqa_content` text NOT NULL,
  PRIMARY KEY (`fqa_id`),
  KEY `fqa_ticket_model_id` (`fqa_ticket_model_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pes_fqa`
--

LOCK TABLES `pes_fqa` WRITE;
/*!40000 ALTER TABLE `pes_fqa` DISABLE KEYS */;
/*!40000 ALTER TABLE `pes_fqa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pes_mail_template`
--

DROP TABLE IF EXISTS `pes_mail_template`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pes_mail_template` (
  `mail_template_id` int(11) NOT NULL AUTO_INCREMENT,
  `mail_template_type` int(11) NOT NULL,
  `mail_template_title` varchar(255) NOT NULL,
  `mail_template_content` text NOT NULL,
  `mail_template_sms` varchar(500) NOT NULL DEFAULT '',
  `mail_template_weixin_template_id` varchar(128) NOT NULL DEFAULT '',
  `mail_template_weixin_template` text NOT NULL,
  PRIMARY KEY (`mail_template_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pes_mail_template`
--

LOCK TABLES `pes_mail_template` WRITE;
/*!40000 ALTER TABLE `pes_mail_template` DISABLE KEYS */;
INSERT INTO `pes_mail_template` VALUES (1,1,'工单提交成功！您的工单编号为：{ticket_number}','&lt;p&gt;我们已经收到您提交的工单，单号为：{ticket_number} 。我们将会尽快对您的问题进行处理，请耐心等待。此外，您可以通过如下链接对工单的进度查询：{ticket_link}&lt;/p&gt;','我们已经收到您提交的工单，我们将尽快安排人员为您解疑释惑。您的工单编号为：{ticket_number}。请不要把工单号码泄露给其他人。','','{&quot;&quot;:{&quot;value&quot;:&quot;&quot;,&quot;color&quot;:&quot;#000000&quot;}}'),(2,2,'工单:{ticket_number}已经受理','&lt;p&gt;您的工单已经受理，我们将会尽快解决您的问题，请耐心等待。\n查看工单进度，可以点击如下链接访问：{ticket_link}&lt;/p&gt;','您的工单已经受理，我们将会尽快解决您的问题，请耐心等待。 查看工单进度，可以点击如下链接访问：{ticket_link}','','{&quot;&quot;:{&quot;value&quot;:&quot;&quot;,&quot;color&quot;:&quot;#000000&quot;}}'),(3,3,'工单:{ticket_number}有新的回复','&lt;p&gt;您好，您的工单:{ticket_number} 有新的回复。点击如下链接可以查看工单的进度:{ticket_link}&lt;/p&gt;','您好，您的工单:{ticket_number} 有新的回复。点击如下链接可以查看工单的进度:{ticket_link}','','{&quot;&quot;:{&quot;value&quot;:&quot;&quot;,&quot;color&quot;:&quot;#000000&quot;}}'),(4,4,'工单:{ticket_number}需要转交客服处理','&lt;p&gt;您好，您的工单{ticket_number}需要转交客服处理，请耐心等待。\n点击如下链接可以查看工单的进度:{ticket_link}&lt;/p&gt;','您好，您的工单{ticket_number}需要转交客服处理，请耐心等待。','','{&quot;&quot;:{&quot;value&quot;:&quot;&quot;,&quot;color&quot;:&quot;#000000&quot;}}'),(5,5,'工单:{ticket_number}已经完成','&lt;p&gt;您好，您的工单:{ticket_number}已经被客服标记为完成状态。该工单将无法继续操作。若您的问题仍旧无法解决，请重新发起新的工单，感谢您的耐心等待。\n查看工单的详情，请点击如下链接:{ticket_link}&lt;/p&gt;','您好，您的工单:{ticket_number}已经被客服标记为完成状态。该工单将无法继续操作。若您的问题仍旧无法解决，请重新发起新的工单，感谢您的耐心等待。','','{&quot;&quot;:{&quot;value&quot;:&quot;&quot;,&quot;color&quot;:&quot;#000000&quot;}}'),(6,6,'工单:{ticket_number}被关闭','&lt;p&gt;您好，非常抱歉地告诉您，您的工单:{ticket_number}已经被客服标关闭。该工单将无法继续操作。若您的问题仍旧无法解决，请重新发起新的工单，感谢您的反馈。\n查看工单的详情，请点击如下链接:{ticket_link}&lt;/p&gt;','您好，非常抱歉地告诉您，您的工单:{ticket_number}已经被客服标关闭。该工单将无法继续操作。若您的问题仍旧无法解决，请重新发起新的工单，感谢您的反馈。','','{&quot;&quot;:{&quot;value&quot;:&quot;&quot;,&quot;color&quot;:&quot;#000000&quot;}}');
/*!40000 ALTER TABLE `pes_mail_template` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pes_member`
--

DROP TABLE IF EXISTS `pes_member`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pes_member` (
  `member_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_account` varchar(255) NOT NULL,
  `member_email` varchar(255) NOT NULL DEFAULT '',
  `member_password` varchar(255) NOT NULL DEFAULT '',
  `member_name` varchar(255) NOT NULL DEFAULT '',
  `member_phone` varchar(255) DEFAULT NULL,
  `member_status` tinyint(4) NOT NULL DEFAULT '0',
  `member_createtime` int(11) NOT NULL DEFAULT '0',
  `member_weixin` varchar(255) DEFAULT NULL COMMENT '微信openid',
  `member_organize_id` int(11) NOT NULL,
  PRIMARY KEY (`member_id`),
  UNIQUE KEY `member_email` (`member_email`),
  UNIQUE KEY `member_account` (`member_account`) USING BTREE,
  UNIQUE KEY `member_phone` (`member_phone`) USING BTREE,
  UNIQUE KEY `member_weixin` (`member_weixin`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pes_member`
--

LOCK TABLES `pes_member` WRITE;
/*!40000 ALTER TABLE `pes_member` DISABLE KEYS */;
/*!40000 ALTER TABLE `pes_member` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pes_member_organize`
--

DROP TABLE IF EXISTS `pes_member_organize`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pes_member_organize` (
  `member_organize_id` int(11) NOT NULL,
  `member_organize_name` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`member_organize_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pes_member_organize`
--

LOCK TABLES `pes_member_organize` WRITE;
/*!40000 ALTER TABLE `pes_member_organize` DISABLE KEYS */;
INSERT INTO `pes_member_organize` VALUES (1,'默认分组');
/*!40000 ALTER TABLE `pes_member_organize` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pes_menu`
--

DROP TABLE IF EXISTS `pes_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pes_menu` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(128) NOT NULL,
  `menu_pid` int(11) NOT NULL DEFAULT '0',
  `menu_icon` varchar(128) NOT NULL DEFAULT '',
  `menu_link` varchar(255) NOT NULL DEFAULT '',
  `menu_listsort` tinyint(100) NOT NULL DEFAULT '0',
  `menu_type` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`menu_id`),
  KEY `menu_pid` (`menu_pid`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pes_menu`
--

LOCK TABLES `pes_menu` WRITE;
/*!40000 ALTER TABLE `pes_menu` DISABLE KEYS */;
INSERT INTO `pes_menu` VALUES (1,'工单设置',0,'am-icon-ticket','',3,0),(2,'工单模型',1,'am-icon-modx','Ticket-Ticket_model-index',2,0),(3,'帐号管理',0,'am-icon-users','',5,0),(4,'客服帐号',3,'am-icon-user','Ticket-User-index',1,0),(6,'基础设置',9,'am-icon-tv','Ticket-Setting-action',1,0),(7,'菜单设置',9,'am-icon-map-signs','Ticket-Menu-index',2,0),(9,'系统设置',0,'am-icon-cog','',10,0),(10,'帮助文档',9,'am-icon-leanpub','https://www.pescms.com/d/index/22',98,1),(12,'工作台',0,'am-icon-tachometer','Ticket-Index-index',1,0),(13,'工单列表',0,'am-icon-yelp','',2,0),(14,'客服分组',3,'am-icon-steam','Ticket-User_group-index',2,0),(15,'节点管理',3,'am-icon-toggle-off','Ticket-Node-index',3,0),(16,'路由规则',9,'am-icon-map-o','Ticket-Route-index',4,0),(17,'工单列表',13,'am-icon-fire','Ticket-Ticket-index',2,0),(18,'我的工单',13,'am-icon-coffee','Ticket-Ticket-myTicket',3,0),(19,'通知模板',9,'am-icon-paint-brush','Ticket-Mail_template-index',7,0),(21,'工单分类',1,'am-icon-list-alt','Ticket-Category-index',1,0),(23,'客户管理',3,'am-icon-street-view','Ticket-Member-index',4,0),(24,'应用商店',9,'am-icon-cogs','Ticket-Application-index',3,0),(25,'商业授权',9,'am-icon-registered','https://www.pescms.com/Page/Authorization.html',99,1),(26,'发送列表',9,'am-icon-send','Ticket-Send-index',5,0),(27,'全部工单',13,'am-icon-list','Ticket-Ticket-all',1,0),(32,'常见问题解答',1,'am-icon-question-circle','Ticket-Fqa-index',20,0),(33,'工单投诉反馈',0,'am-icon-cutlery','Ticket-Ticket-complain',6,0),(34,'附件管理',9,'am-icon-suitcase','Ticket-Attachment-index',8,0),(35,'客服消息模板',9,'am-icon-phone-square','Ticket-Cssend_template-index',6,0),(36,'客户分组',3,'am-icon-user-secret','Ticket-Member_organize-index',5,0);
/*!40000 ALTER TABLE `pes_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pes_model`
--

DROP TABLE IF EXISTS `pes_model`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pes_model` (
  `model_id` int(11) NOT NULL AUTO_INCREMENT,
  `model_name` varchar(128) NOT NULL,
  `model_title` varchar(128) NOT NULL DEFAULT '',
  `model_status` tinyint(4) NOT NULL DEFAULT '0',
  `model_search` tinyint(11) NOT NULL DEFAULT '0' COMMENT '允许搜索',
  `model_attr` tinyint(1) NOT NULL DEFAULT '0' COMMENT '模型属性 1:前台(含前台) 2:后台',
  `model_page` int(11) NOT NULL DEFAULT '10',
  PRIMARY KEY (`model_id`),
  UNIQUE KEY `model_name` (`model_name`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pes_model`
--

LOCK TABLES `pes_model` WRITE;
/*!40000 ALTER TABLE `pes_model` DISABLE KEYS */;
INSERT INTO `pes_model` VALUES (1,'model','模型管理',1,1,2,10),(2,'field','字段管理',1,1,2,10),(3,'menu','菜单模型',1,1,2,10),(4,'route','路由规则',1,1,2,10),(6,'User_group','客服分组',1,0,2,10),(7,'User','客服帐号',1,0,2,10),(13,'Node','节点列表',1,1,2,10),(15,'ticket_model','工单模型',1,1,2,10),(16,'ticket_form','工单表单',1,1,2,10),(17,'mail_template','通知模板',1,0,2,10),(18,'Category','分类',1,1,1,10),(20,'Member','客户管理',1,1,1,10),(21,'Send','发送列表',1,1,1,10),(22,'Phrase','回复短语',1,0,2,10),(23,'Fqa','常见问题解答',1,1,1,10),(24,'attachment','附件管理',1,0,2,30),(25,'cssend_template','客服消息模板',1,0,2,10),(26,'member_organize','客户分组',1,0,2,10);
/*!40000 ALTER TABLE `pes_model` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pes_node`
--

DROP TABLE IF EXISTS `pes_node`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pes_node` (
  `node_id` int(11) NOT NULL AUTO_INCREMENT,
  `node_name` varchar(255) NOT NULL,
  `node_parent` int(11) NOT NULL DEFAULT '0',
  `node_verify` int(11) NOT NULL DEFAULT '0',
  `node_msg` varchar(255) DEFAULT '',
  `node_method_type` varchar(8) NOT NULL DEFAULT '',
  `node_value` varchar(255) NOT NULL DEFAULT '',
  `node_check_value` varchar(255) NOT NULL DEFAULT '',
  `node_controller` int(11) NOT NULL DEFAULT '0',
  `node_listsort` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`node_id`)
) ENGINE=InnoDB AUTO_INCREMENT=101 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pes_node`
--

LOCK TABLES `pes_node` WRITE;
/*!40000 ALTER TABLE `pes_node` DISABLE KEYS */;
INSERT INTO `pes_node` VALUES (1,'首页',0,0,'','GET','Index','',-1,1),(2,'工单列表',0,0,'','GET','Ticket','',0,2),(3,'工单列表',2,1,'','GET','index','TicketGETTicketindex',2,1),(4,'我的工单',2,1,'','GET','myTicket','TicketGETTicketmyTicket',2,2),(5,'回复工单',2,1,'','POST','reply','TicketPOSTTicketreply',2,3),(6,'关闭工单',2,1,'','POST','close','TicketPOSTTicketclose',2,4),(7,'工单设置',0,0,'','GET','','',-1,3),(8,'工单模型',11,0,'','GET','Ticket_model','',0,1),(9,'工单表单',11,0,'','GET','Ticket_form','',0,2),(10,'添加/编辑新工单',7,1,'','GET','action','TicketGETTicket_modelaction',8,20),(11,'杂项节点',0,0,'','GET','','',-1,99),(12,'工单模型列表',7,1,'','GET','index','TicketGETTicket_modelindex',8,10),(13,'提交新增工单模型',7,1,'','POST','action','TicketPOSTTicket_modelaction',8,30),(14,'提交更新工单模型',7,1,'','PUT','action','TicketPUTTicket_modelaction',8,40),(15,'提交删除工单模型',7,1,'','DELETE','action','TicketDELETETicket_modelaction',8,50),(16,'工单表单列表',7,1,'','GET','index','TicketGETTicket_formindex',9,60),(17,'新增/编辑工单表单',7,1,'','GET','action','TicketGETTicket_formaction',9,70),(18,'提交新增工单表单',7,1,'','POST','action','TicketPOSTTicket_formaction',9,80),(19,'提交更新工单表单',7,1,'','PUT','action','TicketPUTTicket_formaction',9,90),(20,'提交删除工单表单',7,1,'','DELETE','action','TicketDELETETicket_formaction',9,100),(21,'用户管理',0,0,'','GET','User','',0,4),(22,'用户组',11,0,'','GET','User_group','',0,3),(23,'节点管理',11,0,'','GET','Node','',0,4),(24,'用户列表',21,1,'','GET','index','TicketGETUserindex',21,10),(25,'新增/编辑用户',21,1,'','GET','action','TicketGETUseraction',21,20),(26,'提交新增用户',21,1,'','POST','action','TicketPOSTUseraction',21,30),(27,'提交更新用户',21,1,'','PUT','action','TicketPUTUseraction',21,40),(28,'提交删除用户',21,1,'','DELETE','action','TicketDELETEUseraction',21,50),(29,'用户组列表',21,1,'','GET','index','TicketGETUser_groupindex',22,60),(30,'新增/编辑用户组',21,1,'','GET','action','TicketGETUser_groupaction',22,70),(31,'提交新增用户组',21,1,'','POST','action','TicketPOSTUser_groupaction',22,80),(32,'提交编辑用户组',21,1,'','PUT','action','TicketPUTUser_groupaction',22,90),(33,'提交删除用户组',21,1,'','DELETE','action','TicketDELETEUser_groupaction',22,100),(34,'查看用户组菜单',21,1,'','GET','setMenu','TicketGETUser_groupsetMenu',22,110),(35,'更新用户组菜单',21,1,'','PUT','setMenu','TicketPUTUser_groupsetMenu',22,120),(36,'查看用户组权限',21,1,'','GET','setAuth','TicketGETUser_groupsetAuth',22,130),(37,'更新用户组权限',21,1,'','PUT','setAuth','TicketPUTUser_groupsetAuth',22,140),(38,'节点列表',21,1,'','GET','index','TicketGETNodeindex',23,150),(39,'新增/编辑节点',21,1,'','GET','action','TicketGETNodeaction',23,160),(40,'提交新增节点',21,1,'','POST','action','TicketPOSTNodeaction',23,170),(41,'提交更新节点',21,1,'','PUT','action','TicketPUTNodeaction',23,180),(42,'提交删除节点',21,1,'','DELETE','action','TicketDELETENodeaction',23,190),(43,'系统设置',0,0,'','GET','Setting','',0,6),(44,'查看基础设置',43,1,'','GET','action','TicketGETSettingaction',43,10),(45,'更新基础设置',43,1,'','PUT','action','TicketPUTSettingaction',43,20),(46,'菜单设置',11,0,'','GET','Menu','',0,5),(47,'查看菜单',43,1,'','GET','index','TicketGETMenuindex',46,30),(48,'新增菜单',43,1,'','POST','action','TicketPOSTMenuaction',46,50),(49,'新增/编辑菜单',43,1,'','GET','action','TicketGETMenuaction',46,40),(50,'更新菜单',43,1,'','PUT','action','TicketPUTMenuaction',46,60),(51,'删除菜单',43,1,'','DELETE','action','TicketDELETEMenuaction',46,70),(52,'路由规则',11,0,'','GET','Route','',0,6),(53,'路由列表',43,1,'','GET','index','TicketGETRouteindex',52,80),(54,'新增/编辑路由规则',43,1,'','GET','action','TicketGETRouteaction',52,90),(55,'新增路由规则',43,1,'','POST','action','TicketPOSTRouteaction',52,100),(56,'更新路由规则',43,1,'','PUT','action','TicketPUTRouteaction',52,110),(57,'删除路由规则',43,1,'','DELETE','action','TicketDELETERouteaction',52,120),(58,'模型管理',0,0,'','GET','Model','',0,95),(59,'字段管理',11,0,'','GET','Field','',0,1),(60,'模型列表',58,1,'','GET','index','TicketGETModelindex',58,1),(61,'新增/编辑模型',58,1,'','GET','action','TicketGETModelaction',58,1),(62,'新增模型',58,1,'','POST','action','TicketPOSTModelaction',58,1),(63,'更新模型',58,1,'','PUT','action','TicketPUTModelaction',58,1),(64,'删除模型',58,1,'','DELETE','action','TicketDELETEModelaction',58,1),(65,'字段列表',58,1,'','GET','index','TicketGETFieldindex',59,0),(66,'新增/编辑字段',58,1,'','GET','action','TicketGETFieldaction',59,0),(67,'新增字段',58,1,'','POST','action','TicketPOSTFieldaction',59,0),(68,'更新字段',58,1,'','PUT','action','TicketPUTFieldaction',59,0),(69,'删除字段',58,1,'','DELETE','action','TicketDELETEFieldaction',59,0),(70,'邮件模板',11,0,'','GET','Mail_template','',0,7),(71,'邮件模板列表',43,1,'','GET','index','TicketGETMail_templateindex',70,0),(72,'新增/编辑邮件模板',43,1,'','GET','action','TicketGETMail_templateaction',70,0),(73,'添加邮件模板',43,1,'','POST','action','TicketPOSTMail_templateaction',70,0),(74,'更新邮件模板',43,1,'','PUT','action','TicketPUTMail_templateaction',70,0),(75,'删除邮件模板',43,1,'','DELETE','action','TicketDELETEMail_templateaction',70,0),(76,'分类管理',0,0,'','GET','Category','',0,5),(77,'新增/编辑分类',76,1,'','GET','action','TicketGETCategoryaction',76,2),(78,'提交新增分类',76,1,'','POST','action','TicketPOSTCategoryaction',76,3),(79,'提交分类更新',76,1,'','PUT','action','TicketPUTCategoryaction',76,4),(80,'提交分类删除',76,1,'','DELETE','action','TicketDELETECategoryaction',76,5),(81,'分类列表',76,1,'','DELETE','index','TicketGETCategoryindex',76,1),(82,'删除工单',2,1,'当前权限不足，无法删除工单。','DELETE','action','TicketDELETETicketaction',2,5),(83,'全部工单',2,1,'','GET','all','TicketGETTicketall',2,5),(84,'常见问题',11,1,'','GET','Fqa','',0,8),(85,'FQA列表',7,1,'','GET','index','TicketGETFqaindex',84,110),(86,'FQA编辑',7,1,'','GET','action','TicketGETFqaaction',84,111),(87,'FQA添加',7,1,'','POST','action','TicketPOSTFqaaction',84,112),(88,'FQA更新',7,1,'','PUT','action','TicketPUTFqaaction',84,113),(89,'FQA删除',7,1,'','DELETE','action','TicketDELETEFqaaction',84,114),(90,'复制用户组',21,1,'','POST','copy','TicketPOSTUser_groupcopy',22,141),(91,'工单投诉列表',2,1,'','GET','complain','TicketGETTicketcomplain',2,130),(92,'工单投诉详情',2,1,'','GET','complainDetail','TicketGETTicketcomplainDetail',2,131),(93,'附件管理',11,1,'','GET','Attachment','',0,9),(94,'附件列表',43,1,'','GET','index','TicketGETAttachmentindex',93,130),(95,'附件编辑',43,1,'','GET','action','TicketGETAttachmentaction',93,140),(96,'附件添加',43,1,'','POST','action','TicketPOSTAttachmentaction',93,150),(97,'附件更新',43,1,'','PUT','action','TicketPUTAttachmentaction',93,160),(98,'附件删除',43,1,'','DELETE','action','TicketDELETEAttachmentaction',93,170),(99,'发送列表',11,0,NULL,'GET','Send','',0,10),(100,'清空发送列表',43,1,NULL,'DELETE','truncate','TicketDELETESendtruncate',99,180);
/*!40000 ALTER TABLE `pes_node` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pes_node_group`
--

DROP TABLE IF EXISTS `pes_node_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pes_node_group` (
  `node_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_group_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户组ID',
  `node_id` int(11) NOT NULL DEFAULT '0' COMMENT '节点ID',
  PRIMARY KEY (`node_group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8 COMMENT='用户组权限节点';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pes_node_group`
--

LOCK TABLES `pes_node_group` WRITE;
/*!40000 ALTER TABLE `pes_node_group` DISABLE KEYS */;
INSERT INTO `pes_node_group` VALUES (7,1,1),(8,1,2),(9,1,3),(10,1,4),(11,1,5),(12,1,6),(13,1,7),(14,1,12),(15,1,10),(16,1,13),(17,1,14),(18,1,15),(19,1,16),(20,1,17),(21,1,18),(22,1,19),(23,1,20),(24,1,21),(25,1,24),(26,1,25),(27,1,26),(28,1,27),(29,1,28),(30,1,29),(31,1,30),(32,1,31),(33,1,32),(34,1,33),(35,1,34),(36,1,35),(37,1,36),(38,1,37),(39,1,38),(40,1,39),(41,1,40),(42,1,41),(43,1,42),(44,1,43),(45,1,75),(46,1,74),(47,1,73),(48,1,72),(49,1,71),(50,1,44),(51,1,45),(52,1,47),(53,1,49),(54,1,48),(55,1,50),(56,1,51),(57,1,53),(58,1,54),(59,1,55),(60,1,56),(61,1,57),(62,1,11),(63,1,8),(64,1,9),(65,1,22),(66,1,23),(67,1,46),(68,1,52),(69,1,70),(70,3,2),(71,3,91),(72,3,92),(73,2,1),(74,2,2),(75,2,3),(76,2,4),(77,2,5);
/*!40000 ALTER TABLE `pes_node_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pes_option`
--

DROP TABLE IF EXISTS `pes_option`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pes_option` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `option_name` varchar(128) NOT NULL DEFAULT '',
  `name` varchar(128) NOT NULL DEFAULT '',
  `value` text NOT NULL,
  `option_range` varchar(128) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pes_option`
--

LOCK TABLES `pes_option` WRITE;
/*!40000 ALTER TABLE `pes_option` DISABLE KEYS */;
INSERT INTO `pes_option` VALUES (1,'domain','网站URL','','system'),(2,'crossdomain','跨域列表','','system'),(3,'version','系统版本','','system'),(4,'openindex','开启首页','1','system'),(5,'customstatus','工单状态','[{\"color\":\"#dd514c\",\"name\":\"\\u5f85\\u89e3\\u51b3\"},{\"color\":\"#F37B1D\",\"name\":\"\\u5df2\\u53d7\\u7406\"},{\"color\":\"#3bb4f2\",\"name\":\"\\u5f85\\u56de\\u590d\"},{\"color\":\"#5eb95e\",\"name\":\"\\u5b8c\\u6210\"}]',''),(6,'mail','邮箱设置','',''),(7,'notice_way','通知方式','3','system'),(8,'upload_img','图片格式','[\".jpg\",\".jpge\",\".bmp\",\".gif\",\".png\"]','upload'),(9,'upload_file','文件格式','[\".zip\",\".rar\",\".7z\",\".doc\",\".docx\",\".pdf\",\".xls\",\".xlsx\",\".ppt\",\".pptx\",\".txt\"]','upload'),(10,'interior_ticket','站内工单','1','system'),(11,'open_register','开启注册','1','system'),(12,'weixin_api','微信接口','','system'),(13,'weixinWork_api','企业微信接口','','system'),(14,'login_verify','登录验证码','[\"1\"]','system'),(15,'cs_notice_type','客服人员接收通知方式','{\"1\":\"1\"}','system'),(16,'sms','短信接口','','system'),(17,'siteLogo','网站LOGO','/Theme/assets/i/logo.png','system'),(18,'siteTitle','网站名称','PESCMS Ticket开源版','system'),(19,'pescmsIntroduce','页脚内容','<div class=\"am-u-sm-12 am-u-lg-11 am-u-sm-centered\">\r\n    <div class=\"am-g\">\r\n        <div class=\"am-u-sm-12 am-u-lg-3\">\r\n            <h4>关于我们</h4>\r\n            <p>当前站点正在使用<strong>PESCMS Ticket客服工单系统开源版</strong>。页脚内容为开源版预设，请按照业务需求自行设置页脚内容。</p>\r\n        </div>\r\n        <div class=\"am-u-sm-12 am-u-lg-3\">\r\n            <h4>PESCMS产品介绍</h4>\r\n            <ul>\r\n                <li><a href=\"https://www.pescms.com/download/2.html\">PESCMS TEAM 团队任务管理系统</a></li>\r\n                <li><a href=\"https://www.pescms.com/download/3.html\">PESCMS DOC 文档管理系统</a></li>\r\n                <li><a href=\"https://www.pescms.com/download/5.html\">PESCMS TICKET 客服工单系统</a></li>\r\n                <li><a href=\"https://www.pescms.com/download/4.html\">PESCMS LOGIN 网站登录管理</a></li>\r\n                <li><a href=\"https://www.pescms.com/download/6.html\">基金定投助手</a></li>\r\n            </ul>\r\n        </div>\r\n        <div class=\"am-u-sm-12 am-u-lg-3 am-u-end\">\r\n            <h4>PESCMS产品服务</h4>\r\n            <ul>\r\n                <li><a href=\"https://www.pescms.com/Page/Authorization.html\">商业授权</a></li>\r\n                <li><a href=\"https://www.pescms.com/Authorize-Verify\">授权查询</a></li>\r\n                <li><a href=\"https://www.pescms.com/service.html\">有偿服务</a></li>\r\n                <li><a href=\"https://www.pescms.com/Page/ad.html\">广告投放</a></li>\r\n                <li><a href=\"https://www.pescms.com/Page/donate.html\">赞助捐赠</a></li>\r\n            </ul>\r\n        </div>\r\n    </div>\r\n</div>','system'),(20,'siteContact','网站联系方式','<span class=\"am-margin-right-xs\"><i class=\"am-icon-qq\"></i> <a href=\"https://wpa.qq.com/msgrd?v=3&uin=&menu=yes\" target=\"_blank\">10000</a></span>\r\n<span class=\"am-margin-right-xs\"><i class=\"am-icon-weixin\"></i> <a href=\"javascript:;\" data-am-popover=\"{content: \'<img src=\\\'https://www.pescms.com/Theme/assets/i/weixin_test.jpg\\\' width=300>\', trigger: \'hover focus\'}\" >NoTSet</a></span>','system'),(21,'authorize','授权码','',''),(22,'siteKeywords','网站Keywords','PESCMS Ticket是一款以GPLv2协议发布的开源工单客服系统','system'),(23,'siteDescription','网站Description','PESCMS,PESCMS Ticket,开源的工单系统,工单系统,工单客服系统,客服工单系统,GPL工单,GPL客服系统,GPL工单客服系统','system'),(24,'verifyLength','验证码长度','4','system'),(25,'member_review','审核设置','1','system'),(26,'indexStyle','首页样式','0','system'),(27,'member_login','客户登陆方式','0','system'),(28,'max_upload_size','上传大小','1','upload'),(29,'siteStyle','自定义样式','','system'),(30,'siteTongji','网站统计代码','','system'),(31,'weixinRegister','微信公众号注册需要填写完整的用户资料','0','system'),(32,'cs_text','工单回复文本','{\"accept\":{\"title\":\"\\u5de5\\u5355\\u53d7\\u7406\\u56de\\u590d\",\"content\":\"\\u5df2\\u6536\\u5230\\u60a8\\u7684\\u5de5\\u5355\\uff0c\\u6211\\u4eec\\u5c06\\u4f1a\\u5c3d\\u5feb\\u5b89\\u6392\\u4eba\\u624b\\u8fdb\\u884c\\u5904\\u7406\\u3002\"},\"assign\":{\"title\":\"\\u5de5\\u5355\\u8f6c\\u6d3e\\u56de\\u590d\",\"content\":\"\\u5f53\\u524d\\u95ee\\u9898\\u9700\\u8981\\u79fb\\u4ea4\\u7ed9\\u5176\\u4ed6\\u5ba2\\u670d\\u4eba\\u5458\\uff0c\\u8bf7\\u8010\\u5fc3\\u7b49\\u5f85\\u3002\"},\"complete\":{\"title\":\"\\u5de5\\u5355\\u5b8c\\u6210\\u56de\\u590d\",\"content\":\"\\u5ba2\\u670d\\u5df2\\u7ecf\\u5c06\\u672c\\u5de5\\u5355\\u7ed3\\u675f\\uff0c\\u5982\\u6709\\u7591\\u95ee\\u8bf7\\u91cd\\u65b0\\u53d1\\u8d77\\u5de5\\u5355\\u54a8\\u8be2\\uff0c\\u8c22\\u8c22!\"},\"close\":{\"title\":\"\\u5de5\\u5355\\u5173\\u95ed\\u56de\\u590d\",\"content\":\"\\u5de5\\u5355\\u5df2\\u5173\\u95ed\\uff0c\\u82e5\\u8fd8\\u6709\\u7591\\u95ee\\uff0c\\u8bf7\\u91cd\\u65b0\\u53d1\\u8868\\u5de5\\u5355\\u54a8\\u8be2!\"}}','cs_text'),(33,'tipsManual','首次按照提醒指引','0','system'),(34,'ticketModel','工单模型提醒','0','system');
/*!40000 ALTER TABLE `pes_option` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pes_phrase`
--

DROP TABLE IF EXISTS `pes_phrase`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pes_phrase` (
  `phrase_id` int(11) NOT NULL AUTO_INCREMENT,
  `phrase_listsort` int(11) NOT NULL DEFAULT '0',
  `phrase_name` varchar(255) NOT NULL DEFAULT '',
  `phrase_content` text NOT NULL,
  `phrase_user_id` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`phrase_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pes_phrase`
--

LOCK TABLES `pes_phrase` WRITE;
/*!40000 ALTER TABLE `pes_phrase` DISABLE KEYS */;
/*!40000 ALTER TABLE `pes_phrase` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pes_route`
--

DROP TABLE IF EXISTS `pes_route`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pes_route` (
  `route_id` int(11) NOT NULL AUTO_INCREMENT,
  `route_controller` varchar(255) NOT NULL DEFAULT '',
  `route_param` varchar(255) NOT NULL DEFAULT '',
  `route_rule` varchar(255) NOT NULL DEFAULT '',
  `route_title` varchar(255) NOT NULL DEFAULT '',
  `route_hash` varchar(255) NOT NULL DEFAULT '',
  `route_listsort` int(11) NOT NULL DEFAULT '0',
  `route_status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`route_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='路由表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pes_route`
--

LOCK TABLES `pes_route` WRITE;
/*!40000 ALTER TABLE `pes_route` DISABLE KEYS */;
/*!40000 ALTER TABLE `pes_route` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pes_send`
--

DROP TABLE IF EXISTS `pes_send`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pes_send` (
  `send_id` int(11) NOT NULL AUTO_INCREMENT,
  `send_account` varchar(255) NOT NULL DEFAULT '',
  `send_title` varchar(255) NOT NULL DEFAULT '' COMMENT '待发送标题',
  `send_content` mediumtext NOT NULL COMMENT '待发送的内容',
  `send_time` int(11) NOT NULL DEFAULT '0' COMMENT '发送时间',
  `send_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1:邮箱 2:手机 ..',
  `send_result` varchar(255) NOT NULL,
  PRIMARY KEY (`send_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='待发送列表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pes_send`
--

LOCK TABLES `pes_send` WRITE;
/*!40000 ALTER TABLE `pes_send` DISABLE KEYS */;
/*!40000 ALTER TABLE `pes_send` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pes_ticket`
--

DROP TABLE IF EXISTS `pes_ticket`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pes_ticket` (
  `ticket_id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_number` varchar(128) NOT NULL DEFAULT '' COMMENT '工单序号',
  `ticket_title` varchar(255) NOT NULL DEFAULT '' COMMENT '工单标题',
  `ticket_model_id` int(11) NOT NULL DEFAULT '0' COMMENT '对应的工单模型',
  `ticket_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '工单状态,详情参考option中customstatus',
  `ticket_submit_time` int(11) NOT NULL DEFAULT '0' COMMENT '工单提交时间',
  `ticket_refer_time` int(11) NOT NULL DEFAULT '0' COMMENT '工单耗时参照时间',
  `ticket_run_time` int(11) NOT NULL DEFAULT '0' COMMENT '工单解决时长',
  `ticket_complete_time` int(11) NOT NULL DEFAULT '0' COMMENT '工单完成时间',
  `ticket_read` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:未读 1:已读',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '工单操作者ID',
  `member_id` int(11) NOT NULL DEFAULT '-1' COMMENT '站内会员ID . -1表示匿名提交',
  `user_name` varchar(128) NOT NULL DEFAULT '' COMMENT '工单操作者名字',
  `ticket_contact` tinyint(4) NOT NULL DEFAULT '0' COMMENT '联系方式 1:邮箱 2:手机号码',
  `ticket_contact_account` varchar(128) NOT NULL DEFAULT '' COMMENT '联系账号',
  `ticket_close` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:正常 1:关闭',
  `ticket_score` decimal(10,2) NOT NULL COMMENT '本次工单评分',
  `ticket_score_time` int(11) NOT NULL COMMENT '评分时间',
  `ticket_fix` tinyint(1) NOT NULL COMMENT '工单是否解决',
  `ticket_comment` varchar(1000) NOT NULL DEFAULT '' COMMENT '评价留言',
  `ticket_time_out_sequence` int(11) NOT NULL DEFAULT '0' COMMENT '已通知超时次数',
  `ticket_remark` varchar(64) NOT NULL DEFAULT '' COMMENT '工单备注说明',
  `ticket_exclusive` tinyint(1) NOT NULL COMMENT '专属工单标记',
  PRIMARY KEY (`ticket_id`),
  KEY `ticket_number` (`ticket_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pes_ticket`
--

LOCK TABLES `pes_ticket` WRITE;
/*!40000 ALTER TABLE `pes_ticket` DISABLE KEYS */;
/*!40000 ALTER TABLE `pes_ticket` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pes_ticket_chat`
--

DROP TABLE IF EXISTS `pes_ticket_chat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pes_ticket_chat` (
  `ticket_chat_id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_id` int(11) NOT NULL DEFAULT '0' COMMENT '工单ID',
  `user_id` int(11) NOT NULL DEFAULT '-1' COMMENT '用户ID,为0则为发起工单者回复',
  `user_name` varchar(128) NOT NULL DEFAULT 'Customer' COMMENT '回复者的名称,为空则为Customer,即用户回复',
  `ticket_chat_content` text NOT NULL COMMENT '回复内容',
  `ticket_chat_time` int(11) NOT NULL DEFAULT '0' COMMENT '沟通时间',
  PRIMARY KEY (`ticket_chat_id`),
  KEY `ticket_id` (`ticket_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='工单沟通内容';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pes_ticket_chat`
--

LOCK TABLES `pes_ticket_chat` WRITE;
/*!40000 ALTER TABLE `pes_ticket_chat` DISABLE KEYS */;
/*!40000 ALTER TABLE `pes_ticket_chat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pes_ticket_content`
--

DROP TABLE IF EXISTS `pes_ticket_content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pes_ticket_content` (
  `ticket_content_id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_id` int(11) NOT NULL DEFAULT '0' COMMENT '工单ID',
  `ticket_form_id` int(11) NOT NULL DEFAULT '0' COMMENT '对应的工单表单ID',
  `ticket_form_content` text NOT NULL COMMENT '表单内容值',
  PRIMARY KEY (`ticket_content_id`),
  KEY `ticket_id` (`ticket_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='工单动态表单内容表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pes_ticket_content`
--

LOCK TABLES `pes_ticket_content` WRITE;
/*!40000 ALTER TABLE `pes_ticket_content` DISABLE KEYS */;
/*!40000 ALTER TABLE `pes_ticket_content` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pes_ticket_form`
--

DROP TABLE IF EXISTS `pes_ticket_form`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pes_ticket_form` (
  `ticket_form_id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_form_model_id` int(11) NOT NULL DEFAULT '0' COMMENT '对应的工单模型ID',
  `ticket_form_name` varchar(128) NOT NULL DEFAULT '' COMMENT '工单表单名词',
  `ticket_form_description` varchar(128) NOT NULL DEFAULT '' COMMENT '工单表单显示名称',
  `ticket_form_explain` varchar(128) NOT NULL DEFAULT '' COMMENT '工单表单说明',
  `ticket_form_msg` varchar(128) NOT NULL DEFAULT '' COMMENT '提示信息',
  `ticket_form_type` varchar(16) NOT NULL DEFAULT '' COMMENT '工单表单类型',
  `ticket_form_option` text NOT NULL COMMENT '工单表单的选项值',
  `ticket_form_verify` varchar(32) NOT NULL DEFAULT '' COMMENT '工单表单的验证类型',
  `ticket_form_required` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否必填 0: 否 1:必填',
  `ticket_form_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否启用 0:否 1:启用',
  `ticket_form_listsort` int(11) NOT NULL DEFAULT '0' COMMENT '动态表单的排序值（升值））',
  `ticket_form_bind` int(11) NOT NULL DEFAULT '0' COMMENT '绑定的联动表单',
  `ticket_form_bind_value` varchar(255) NOT NULL DEFAULT '' COMMENT '联动触发值',
  `ticket_form_postscript` text NOT NULL COMMENT '工单表单详细说明',
  PRIMARY KEY (`ticket_form_id`),
  KEY `ticket_form_model_id` (`ticket_form_model_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='工单动态表单';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pes_ticket_form`
--

LOCK TABLES `pes_ticket_form` WRITE;
/*!40000 ALTER TABLE `pes_ticket_form` DISABLE KEYS */;
/*!40000 ALTER TABLE `pes_ticket_form` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pes_ticket_model`
--

DROP TABLE IF EXISTS `pes_ticket_model`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pes_ticket_model` (
  `ticket_model_id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_model_number` varchar(32) DEFAULT '' COMMENT '每个用户看到的唯一工单模型ID',
  `ticket_model_name` varchar(128) NOT NULL DEFAULT '' COMMENT '工单模型名称',
  `ticket_model_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '工单模型是否启用',
  `ticket_model_login` int(11) NOT NULL DEFAULT '0',
  `ticket_model_verify` int(11) NOT NULL DEFAULT '0',
  `ticket_model_cid` int(11) NOT NULL DEFAULT '0',
  `ticket_model_listsort` int(11) NOT NULL DEFAULT '0',
  `ticket_model_explain` text NOT NULL,
  `ticket_model_group_id` varchar(255) NOT NULL DEFAULT '',
  `ticket_model_time_out` int(11) NOT NULL DEFAULT '10' COMMENT '工单超时提醒设置',
  `ticket_model_time_out_sequence` int(11) NOT NULL DEFAULT '1' COMMENT '超时提醒次数',
  `ticket_model_contact` varchar(64) NOT NULL DEFAULT '',
  `ticket_model_contact_default` int(11) NOT NULL DEFAULT '0',
  `ticket_model_postscript` text NOT NULL COMMENT '工单页内指引',
  `ticket_model_default_send` tinyint(1) NOT NULL DEFAULT '0' COMMENT '默认发送通知',
  `ticket_model_open_close` tinyint(1) NOT NULL COMMENT '是否开启自动关闭工单',
  `ticket_model_close_time` int(11) NOT NULL COMMENT '自动关闭工单时长',
  `ticket_model_exclusive` tinyint(1) NOT NULL COMMENT '允许指定客服受理',
  `ticket_model_organize_id` text NOT NULL,
  PRIMARY KEY (`ticket_model_id`),
  UNIQUE KEY `ticket_model_number` (`ticket_model_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='工单模型';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pes_ticket_model`
--

LOCK TABLES `pes_ticket_model` WRITE;
/*!40000 ALTER TABLE `pes_ticket_model` DISABLE KEYS */;
/*!40000 ALTER TABLE `pes_ticket_model` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pes_ticket_notice_action`
--

DROP TABLE IF EXISTS `pes_ticket_notice_action`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pes_ticket_notice_action` (
  `action_id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_number` varchar(128) NOT NULL COMMENT '工单单号',
  `send_account` varchar(255) NOT NULL DEFAULT '' COMMENT '接收帐号',
  `send_type` int(11) NOT NULL DEFAULT '0' COMMENT '发送方式',
  `template_type` int(11) NOT NULL DEFAULT '0' COMMENT '发送模板类型',
  PRIMARY KEY (`action_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='工作消息通知发送动作';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pes_ticket_notice_action`
--

LOCK TABLES `pes_ticket_notice_action` WRITE;
/*!40000 ALTER TABLE `pes_ticket_notice_action` DISABLE KEYS */;
/*!40000 ALTER TABLE `pes_ticket_notice_action` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pes_user`
--

DROP TABLE IF EXISTS `pes_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pes_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_account` varchar(255) NOT NULL DEFAULT '',
  `user_password` varchar(255) NOT NULL DEFAULT '',
  `user_mail` varchar(255) NOT NULL DEFAULT '',
  `user_name` varchar(255) NOT NULL DEFAULT '',
  `user_group_id` int(11) NOT NULL DEFAULT '0',
  `user_status` tinyint(4) NOT NULL DEFAULT '0',
  `user_createtime` int(11) NOT NULL DEFAULT '0',
  `user_last_login` int(11) NOT NULL DEFAULT '0',
  `user_weixinWork` varchar(255) DEFAULT NULL,
  `user_score` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总体评分',
  `user_score_frequency` int(11) NOT NULL DEFAULT '0' COMMENT '评分次数',
  `user_job_number` varchar(255) DEFAULT '' COMMENT '工号',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_weixinWork` (`user_weixinWork`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pes_user`
--

LOCK TABLES `pes_user` WRITE;
/*!40000 ALTER TABLE `pes_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `pes_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pes_user_group`
--

DROP TABLE IF EXISTS `pes_user_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pes_user_group` (
  `user_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_group_status` tinyint(4) NOT NULL DEFAULT '0',
  `user_group_createtime` int(11) NOT NULL DEFAULT '0',
  `user_group_name` varchar(255) NOT NULL DEFAULT '',
  `user_group_menu` text NOT NULL,
  `user_group_view_type` tinyint(1) NOT NULL,
  PRIMARY KEY (`user_group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pes_user_group`
--

LOCK TABLES `pes_user_group` WRITE;
/*!40000 ALTER TABLE `pes_user_group` DISABLE KEYS */;
INSERT INTO `pes_user_group` VALUES (1,1,0,'管理员','12,13,17,18,1,2,21,3,4,14,15,23,9,6,7,16,19,10,11',0),(2,1,0,'客服人员','12,13,17,18',0),(3,1,0,'投诉反馈','33',0);
/*!40000 ALTER TABLE `pes_user_group` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-03-29 22:18:20
