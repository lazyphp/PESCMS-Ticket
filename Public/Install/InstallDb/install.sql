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
-- Table structure for table `pes_bulletin`
--

DROP TABLE IF EXISTS `pes_bulletin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pes_bulletin` (
  `bulletin_id` int(11) NOT NULL AUTO_INCREMENT,
  `bulletin_listsort` int(11) NOT NULL DEFAULT '0',
  `bulletin_status` tinyint(4) NOT NULL DEFAULT '0',
  `bulletin_createtime` int(11) NOT NULL DEFAULT '0',
  `bulletin_title` varchar(255) NOT NULL DEFAULT '',
  `bulletin_group_id` varchar(255) NOT NULL DEFAULT '',
  `bulletin_description` text NOT NULL,
  PRIMARY KEY (`bulletin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pes_bulletin`
--

LOCK TABLES `pes_bulletin` WRITE;
/*!40000 ALTER TABLE `pes_bulletin` DISABLE KEYS */;
/*!40000 ALTER TABLE `pes_bulletin` ENABLE KEYS */;
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
-- Table structure for table `pes_certificate`
--

DROP TABLE IF EXISTS `pes_certificate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pes_certificate` (
  `certificate_id` int(11) NOT NULL AUTO_INCREMENT,
  `certificate_value` varchar(128) NOT NULL,
  `certificate_openid` varchar(128) NOT NULL COMMENT '微信用户ID',
  `certificate_token` varchar(128) NOT NULL COMMENT 'token',
  `certificate_systeminfo` text NOT NULL COMMENT '系统信息',
  `certificate_time` int(11) NOT NULL COMMENT '有效期',
  PRIMARY KEY (`certificate_id`),
  KEY `certificate_value` (`certificate_value`),
  KEY `certificate_token` (`certificate_token`),
  KEY `openid` (`certificate_openid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pes_certificate`
--

LOCK TABLES `pes_certificate` WRITE;
/*!40000 ALTER TABLE `pes_certificate` DISABLE KEYS */;
/*!40000 ALTER TABLE `pes_certificate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pes_csnotice`
--

DROP TABLE IF EXISTS `pes_csnotice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pes_csnotice` (
  `csnotice_id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_number` varchar(128) NOT NULL,
  `user_id` int(11) NOT NULL,
  `csnotice_type` int(11) NOT NULL,
  `csnotice_time` int(11) NOT NULL,
  `csnotice_read` tinyint(1) NOT NULL COMMENT '是否标记已读',
  `csnotice_read_time` int(11) NOT NULL,
  PRIMARY KEY (`csnotice_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='客服站内消息';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pes_csnotice`
--

LOCK TABLES `pes_csnotice` WRITE;
/*!40000 ALTER TABLE `pes_csnotice` DISABLE KEYS */;
/*!40000 ALTER TABLE `pes_csnotice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pes_cssend_template`
--

DROP TABLE IF EXISTS `pes_cssend_template`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pes_cssend_template` (
  `cssend_template_id` int(11) NOT NULL AUTO_INCREMENT,
  `cssend_template_type` int(11) NOT NULL DEFAULT '0',
  `cssend_template_title` varchar(255) NOT NULL DEFAULT '',
  `cssend_template_content` text NOT NULL,
  PRIMARY KEY (`cssend_template_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
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
  `field_only` int(11) NOT NULL,
  `field_action` varchar(255) NOT NULL,
  PRIMARY KEY (`field_id`),
  UNIQUE KEY `modle_id` (`field_model_id`,`field_name`),
  KEY `field_name` (`field_name`)
) ENGINE=InnoDB AUTO_INCREMENT=296 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pes_field`
--

LOCK TABLES `pes_field` WRITE;
/*!40000 ALTER TABLE `pes_field` DISABLE KEYS */;
INSERT INTO `pes_field` VALUES (1,1,'name','模型名称','text','','','',1,1,1,1,1,0,0,'POST,PUT'),(2,1,'title','显示名称','text','','','',1,2,1,1,1,0,0,'POST,PUT'),(3,1,'search','允许搜索','radio','{\"\\u5173\\u95ed\":\"0\",\"\\u5f00\\u542f\":\"1\"}','','',1,3,1,1,1,0,0,'POST,PUT'),(4,1,'attr','模型属性','radio','{\"\\u524d\\u53f0\":\"1\",\"\\u540e\\u53f0\":\"2\"}','','',1,4,1,1,1,0,0,'POST,PUT'),(5,1,'status','模型状态','radio','{\"\\u542f\\u7528\":\"1\",\"\\u7981\\u7528\":\"0\"}','','',1,5,1,1,1,0,0,'POST,PUT'),(6,2,'model_id','模型ID','text','','','',1,0,0,0,1,0,0,'POST,PUT'),(7,2,'type','字段类型','select','{\"\\u5206\\u7c7b\":\"category\",\"\\u5355\\u884c\\u8f93\\u5165\\u6846\":\"text\",\"\\u591a\\u884c\\u8f93\\u5165\\u6846\":\"textarea\",\"\\u5355\\u9009\\u6309\\u94ae\":\"radio\",\"\\u590d\\u9009\\u6846\":\"checkbox\",\"\\u5355\\u9009\\u4e0b\\u62c9\\u6846\":\"select\",\"\\u591a\\u9009\\u4e0b\\u62c9\\u6846\":\"multiple\",\"\\u7f16\\u8f91\\u5668\":\"editor\",\"\\u7f29\\u7565\\u56fe\":\"thumb\",\"\\u4e0a\\u4f20\\u56fe\\u7ec4\":\"img\",\"\\u4e0a\\u4f20\\u6587\\u4ef6\":\"file\",\"\\u65e5\\u671f\":\"date\",\"\\u5de5\\u5355\\u6a21\\u578b\":\"ticket\",\"\\u7c7b\\u578b\":\"types\",\"\\u9009\\u9879\\u503c\":\"option\"}','','',1,1,1,1,1,0,0,'POST,PUT'),(8,2,'name','字段名称','text','','','',1,2,1,1,1,0,0,'POST,PUT'),(9,2,'display_name','显示名称','text','','','',1,3,1,1,1,0,0,'POST,PUT'),(10,2,'option','选项值','textarea','','选填， 选填， 此处若没有特殊说明，必须 名称|值 填写、且一行一个选项值，否则将导致数据异常!  注意:目前选项适用于单选，复选，下拉菜单。其余功能填写也不会产生任何实际效果。','',0,4,0,1,1,0,0,'POST,PUT'),(11,2,'explain','字段说明','textarea','','','',0,5,0,1,1,0,0,'POST,PUT'),(12,2,'default','默认值','text','','','',0,6,0,1,1,0,0,'POST,PUT'),(13,2,'required','是否必填','radio','{\"\\u662f\":\"1\",\"\\u5426\":\"0\"}','','',1,7,1,1,1,0,0,'POST,PUT'),(14,2,'list','显示列表','radio','{\"\\u663e\\u793a\":\"1\",\"\\u9690\\u85cf\":\"0\"}','','',1,8,1,1,1,0,0,'POST,PUT'),(15,2,'form','显示表单','radio','{&quot;\\u663e\\u793a&quot;:&quot;1&quot;,&quot;\\u9690\\u85cf&quot;:&quot;0&quot;,&quot;\\u4ec5\\u540e\\u53f0&quot;:&quot;2&quot;}','','',1,9,1,1,1,0,0,'POST,PUT'),(16,2,'status','字段状态','radio','{\"\\u542f\\u7528\":\"1\",\"\\u7981\\u7528\":\"0\"}','','',1,11,1,1,1,0,0,'POST,PUT'),(17,2,'listsort','排序','text','','','',0,99,0,1,1,0,0,'POST,PUT'),(18,3,'name','菜单名称','text','','','',1,2,1,1,1,0,0,'POST,PUT'),(19,3,'pid','菜单层级','select','','','',1,1,1,1,1,0,0,'POST,PUT'),(20,3,'icon','菜单图标','text','','','',1,5,1,1,1,0,0,'POST,PUT'),(21,3,'link','菜单地址','text','{&quot;\\u82e5\\u9009\\u62e9\\u7ad9\\u5185\\u94fe\\u63a5\\uff0c\\u8bf7\\u4ee5\\u7ec4-\\u63a7\\u5236\\u5668-\\u65b9\\u6cd5\\u5f62\\u5f0f\\u586b\\u5199\\u3002&quot;:&quot;&quot;}','','',0,4,1,1,1,0,0,'POST,PUT'),(22,3,'listsort','排序','text','','','',0,6,1,1,1,0,0,'POST,PUT'),(67,6,'status','状态','radio','{\"\\u7981\\u7528\":\"0\",\"\\u542f\\u7528\":\"1\"}','','1',1,100,1,1,1,0,0,'POST,PUT'),(69,6,'createtime','发布时间','date','','','',0,99,0,0,0,0,0,'POST,PUT'),(70,7,'status','状态','radio','{\"\\u7981\\u7528\":\"0\",\"\\u542f\\u7528\":\"1\"}','','1',1,100,1,1,1,0,0,'POST,PUT'),(73,7,'account','会员账号','text','','','',1,2,1,1,1,0,1,'POST,PUT'),(75,7,'password','会员密码','text','','新增用户时,密码为必填.编辑用户时为空则表示不修改密码','',0,3,0,1,1,0,0,'POST,PUT'),(76,7,'mail','邮箱地址','text','','','',1,4,1,1,1,0,1,'POST,PUT'),(77,7,'name','会员名称','text','','','',1,5,1,1,1,0,0,'POST,PUT'),(78,7,'group_id','客服分组','select','{\"\\u7ba1\\u7406\\u5458\":1,\"\\u5ba2\\u670d\\u4eba\\u5458\":2,\"\\u6295\\u8bc9\\u53cd\\u9988\":3}','','',1,1,1,1,1,0,0,'POST,PUT'),(79,6,'name','客服分组名称','text','','','',1,1,1,1,1,0,0,'POST,PUT'),(136,13,'name','节点名称','text','','','',1,3,0,1,1,0,0,'POST,PUT'),(137,13,'parent','所属菜单','select','{\"\\u8bf7\\u9009\\u62e9\":\"\",\"\\u9876\\u5c42\\u83dc\\u5355\":\"0\",\"\\u9996\\u9875\":1,\"\\u5de5\\u5355\\u5217\\u8868\":2,\"\\u5de5\\u5355\\u8bbe\\u7f6e\":7,\"\\u5ba2\\u6237\\u5206\\u7ec4\\u7ba1\\u7406\":109,\"\\u5ba2\\u6237\\u7ba1\\u7406\":101,\"\\u5ba2\\u670d\\u7ba1\\u7406\":21,\"\\u5206\\u7c7b\\u7ba1\\u7406\":76,\"\\u7cfb\\u7edf\\u8bbe\\u7f6e\":43,\"\\u6a21\\u578b\\u7ba1\\u7406\":58,\"\\u6742\\u9879\\u8282\\u70b9\":11}','本选项仅用于布置当前权限节点显示于何方。','',1,1,0,1,1,0,0,'POST,PUT'),(138,13,'verify','是否验证','radio','{&quot;\\u4e0d\\u9a8c\\u8bc1&quot;:&quot;0&quot;,&quot;\\u9a8c\\u8bc1&quot;:&quot;1&quot;}','','',0,4,0,1,1,0,0,'POST,PUT'),(139,13,'msg','提示信息','text','','','',0,5,0,1,1,0,0,'POST,PUT'),(140,13,'method_type','请求方法','select','{&quot;GET&quot;:&quot;GET&quot;,&quot;POST&quot;:&quot;POST&quot;,&quot;PUT&quot;:&quot;PUT&quot;,&quot;DELETE&quot;:&quot;DELETE&quot;}','','',0,6,0,1,1,0,0,'POST,PUT'),(141,13,'value','节点匹配值','text','','若选择父类节点为控制器，请填写控制器名称。反之填写方法名。区分大小写','',0,7,0,1,1,0,0,'POST,PUT'),(142,13,'check_value','验证值','text','','','',0,8,0,0,1,0,0,'POST,PUT'),(151,15,'status','状态','radio','{\"\\u7981\\u7528\":\"0\",\"\\u542f\\u7528\":\"1\"}','','1',1,9999,1,1,1,0,0,'POST,PUT'),(153,15,'number','工单ID','text','','','',1,20,1,0,1,0,0,'POST,PUT'),(154,15,'name','工单名称','text','','','',1,30,0,1,1,0,0,'POST,PUT'),(155,16,'model_id','工单模型ID','text','','','',1,4,0,0,1,0,0,'POST,PUT'),(156,16,'name','工单表单字段名称','text','','建议以英语字母下划线填写！否则容易引起工单内容提交丢失的现象。','',1,3,0,1,1,0,0,'POST,PUT'),(157,16,'description','工单字段显示名称','text','','告诉用户该表单的作用','',1,5,1,1,1,0,0,'POST,PUT'),(158,16,'explain','工单表单说明','text','','非必填，告诉用户此工单表单的作用','',0,10,0,1,1,0,0,'POST,PUT'),(159,16,'msg','工单提示信息','text','','非必填，提交失败返回的显示信息','',0,40,0,1,1,0,0,'POST,PUT'),(160,16,'type','工单表单类型','select','','','',1,50,1,1,1,0,0,'POST,PUT'),(161,16,'option','工单表单的选项值','option','','目前选项适用于单选，复选，下拉菜单。其余功能填写也不会产生任何实际效果。','',0,60,0,1,1,0,0,'POST,PUT'),(162,16,'verify','工单表单验证类型','select','','','',0,70,1,1,1,0,0,'POST,PUT'),(163,16,'required','工单表单是否必填','radio','{\"\\u975e\\u5fc5\\u586b\":\"0\",\"\\u5fc5\\u586b\":\"1\"}','','',1,80,1,1,1,0,0,'POST,PUT'),(164,16,'status','工单表单启用状态','radio','{\"\\u7981\\u7528\":\"0\",\"\\u542f\\u7528\":\"1\"}','','',1,98,1,1,1,0,0,'POST,PUT'),(165,16,'listsort','工单表单排序值','text','','升序','',0,99,0,1,1,0,0,'POST,PUT'),(166,16,'bind','联动显示','select','','若需联动显示，请设置绑定的表单选项，当用户选择该选项时会触发本表单的显示。\r\n注：仅限单选、单选下拉框。','',0,2,0,1,1,0,0,'POST,PUT'),(167,16,'bind_value','联动触发值','checkbox','','此处填写用户选择了绑定的表单的触发值。','',0,1,0,1,1,0,0,'POST,PUT'),(168,15,'login','登录验证','radio','{&quot;\\u4e0d\\u9a8c\\u8bc1&quot;:&quot;0&quot;,&quot;\\u9a8c\\u8bc1&quot;:&quot;1&quot;}','','1',1,40,1,1,1,0,0,'POST,PUT'),(169,15,'verify','开启验证码','radio','{\"\\u5173\\u95ed\":\"0\",\"\\u5f00\\u542f\":\"1\"}','','1',1,50,1,1,1,0,0,'POST,PUT'),(170,4,'controller','路由控制器','text','','控制器填写以‘-’为分隔符，分别以：组-控制器名称-方法 形式填写。若是默认组的控制器，那么可以忽略填写组参数。','',1,2,1,1,1,0,0,'POST,PUT'),(171,4,'param','显式参数','text','','若URL存在GET参数，填写上该参数，以半角逗号隔开。如有三个参数a，b，c。那么填写为：a,b,c','',0,3,1,1,1,0,0,'POST,PUT'),(172,4,'rule','路由规则','text','','若链接中存在显式参数，那么用左右大括号包围着。如参数number，那么路由规则这样写：route/{number}。同时规则开头不要添加任何字符，且分隔符只能为\'/\'','',1,4,1,1,1,0,0,'POST,PUT'),(173,4,'title','路由名称','text','','建议填写，以免路由规则过多时，自己也不清楚谁是他的爹。','',0,1,1,1,1,0,0,'POST,PUT'),(174,4,'hash','路由哈希值','text','','','',1,99,0,0,1,0,0,'POST,PUT'),(175,4,'listsort','排序','text','','','',0,100,1,1,1,0,0,'POST,PUT'),(176,4,'status','启用状态','radio','{&quot;\\u542f\\u7528&quot;:&quot;1&quot;,&quot;\\u7981\\u7528&quot;:&quot;0&quot;}','','',1,7,1,1,1,0,0,'POST,PUT'),(177,13,'controller','父类节点','select','{\"\\u8bf7\\u9009\\u62e9\":\"\",\"\\u9876\\u5c42\\u8282\\u70b9\":\"0\",\"\\u975e\\u6743\\u9650\\u8282\\u70b9\":\"-1\",\"\\u5b57\\u6bb5\\u7ba1\\u7406\":59,\"\\u5de5\\u5355\\u6a21\\u578b\":8,\"\\u5de5\\u5355\\u8868\\u5355\":9,\"\\u5de5\\u5355\\u5217\\u8868\":2,\"\\u5ba2\\u670d\\u7ec4\":22,\"\\u5ba2\\u6237\\u5206\\u7ec4\\u7ba1\\u7406\":109,\"\\u5ba2\\u6237\\u7ba1\\u7406\":101,\"\\u8282\\u70b9\\u7ba1\\u7406\":23,\"\\u5ba2\\u670d\\u7ba1\\u7406\":21,\"\\u5206\\u7c7b\\u7ba1\\u7406\":76,\"\\u83dc\\u5355\\u8bbe\\u7f6e\":46,\"\\u8def\\u7531\\u89c4\\u5219\":52,\"\\u7cfb\\u7edf\\u8bbe\\u7f6e\":43,\"\\u90ae\\u4ef6\\u6a21\\u677f\":70,\"\\u5e38\\u89c1\\u95ee\\u9898\":84,\"\\u9644\\u4ef6\\u7ba1\\u7406\":93,\"\\u53d1\\u9001\\u5217\\u8868\":99,\"\\u6a21\\u578b\\u7ba1\\u7406\":58}','','',1,2,1,1,1,0,0,'POST,PUT'),(178,13,'listsort','排序','text','','','',0,99,1,1,1,0,0,'POST,PUT'),(179,3,'type','链接类型','radio','{&quot;\\u7ad9\\u5185\\u94fe\\u63a5&quot;:&quot;0&quot;,&quot;\\u7ad9\\u5916\\u8fde\\u63a5&quot;:&quot;1&quot;}','','',1,3,1,1,1,0,0,'POST,PUT'),(183,17,'type','模板类型','select','{&quot;\\u65b0\\u5de5\\u5355&quot;:&quot;1&quot;,&quot;\\u53d7\\u7406\\u5de5\\u5355&quot;:&quot;2&quot;,&quot;\\u56de\\u590d\\u5de5\\u5355&quot;:&quot;3&quot;,&quot;\\u8f6c\\u4ea4\\u5ba2\\u670d&quot;:&quot;4&quot;,&quot;\\u5de5\\u5355\\u5b8c\\u6210&quot;:&quot;5&quot;,&quot;\\u5de5\\u5355\\u5173\\u95ed&quot;:&quot;6&quot;}','','',1,1,1,1,1,0,0,'POST,PUT'),(184,17,'title','邮件标题','text','','','',1,2,1,1,1,0,0,'POST,PUT'),(185,17,'content','邮件模板内容','editor','','','',1,3,0,1,1,0,0,'POST,PUT'),(186,15,'cid','所属分类','category','','','',1,10,1,1,1,0,0,'POST,PUT'),(187,18,'status','状态','radio','{&quot;\\u7981\\u7528&quot;:&quot;0&quot;,&quot;\\u542f\\u7528&quot;:&quot;1&quot;}','','1',1,100,1,1,1,0,0,'POST,PUT'),(188,18,'listsort','排序','text','','','',0,98,1,1,1,0,0,'POST,PUT'),(190,18,'name','分类名称','text','','','',1,2,1,1,1,0,0,'POST,PUT'),(191,18,'parent','所属父类','select','','','',1,1,1,1,1,0,0,'POST,PUT'),(192,18,'description','分类描述','textarea','','','',1,3,1,1,1,0,0,'POST,PUT'),(193,15,'listsort','排序值','text','','','',0,230,1,1,1,0,0,'POST,PUT'),(194,15,'explain','工单说明','editor','','','',0,130,0,1,1,0,0,'POST,PUT'),(204,20,'status','状态','radio','{\"\\u7981\\u7528\":\"0\",\"\\u542f\\u7528\":\"1\"}','','1',1,100,1,1,1,0,0,'POST,PUT'),(206,20,'createtime','创建时间','date','','','',0,99,1,1,1,0,0,'POST,PUT'),(207,20,'email','邮箱地址','text','','','',1,1,1,1,1,0,1,'POST,PUT'),(208,20,'password','用户密码','text','','','',0,2,0,1,1,0,0,'POST,PUT'),(209,20,'name','用户名称','text','','','',1,3,1,1,1,0,0,'POST,PUT'),(210,20,'phone','手机号码','text','','','',1,4,1,1,1,1,1,'POST,PUT'),(211,15,'group_id','管辖客服分组','multiple','{\"\\u7ba1\\u7406\\u5458\":1,\"\\u5ba2\\u670d\\u4eba\\u5458\":2,\"\\u6295\\u8bc9\\u53cd\\u9988\":3}','绑定对应的客服分组，当前工单模型有新工单，将会发送通知给该客服分组下的所有成员。','',1,100,1,1,1,0,0,'POST,PUT'),(212,21,'account','接收账号','text','','','',1,1,1,1,1,0,0,'POST,PUT'),(213,21,'title','发送标题','text','','','',1,2,1,1,1,0,0,'POST,PUT'),(214,21,'content','发送内容','editor','','','',1,3,0,1,1,0,0,'POST,PUT'),(215,21,'time','生成时间','date','','','',1,5,1,1,1,0,0,'POST,PUT'),(216,21,'type','发送方式','select','{&quot;\\u90ae\\u7bb1&quot;:&quot;1&quot;,&quot;\\u624b\\u673a&quot;:&quot;2&quot;,&quot;\\u5fae\\u4fe1&quot;:&quot;3&quot;,&quot;\\u4f01\\u4e1a\\u5fae\\u4fe1&quot;:&quot;4&quot;}','','',1,4,1,1,1,0,0,'POST,PUT'),(217,7,'weixinWork','企业微信ID','text','','','',0,6,1,1,1,1,1,'POST,PUT'),(218,2,'is_null','是否为空','radio','{&quot;\\u5426&quot;:&quot;0&quot;,&quot;\\u662f&quot;:&quot;1&quot;}','','',0,7,1,1,1,0,0,'POST,PUT'),(219,17,'sms','短信模板内容','textarea','','请先在短信平台添加模板，在按照模板格式，在此处填写通知内容。','',1,4,0,1,1,0,0,'POST,PUT'),(221,22,'listsort','排序','text','','','',0,98,1,1,1,0,0,'POST,PUT'),(223,22,'name','短语名称','text','','','',0,1,1,1,1,0,0,'POST,PUT'),(224,22,'content','内容','editor','','','',1,2,0,1,1,0,0,'POST,PUT'),(225,22,'user_id','所属者','text','','','',0,90,0,0,1,0,0,'POST,PUT'),(226,23,'status','状态','radio','{\"\\u7981\\u7528\":\"0\",\"\\u542f\\u7528\":\"1\"}','','1',1,100,1,1,1,0,0,'POST,PUT'),(227,23,'listsort','排序','text','','','',0,98,1,1,1,0,0,'POST,PUT'),(228,23,'createtime','创建时间','date','','','',0,99,1,1,1,0,0,'POST,PUT'),(229,23,'ticket_model_id','对应工单','ticket','','','',1,1,1,1,1,0,0,'POST,PUT'),(230,23,'title','标题','text','','','',1,2,1,1,1,0,0,'POST,PUT'),(231,23,'content','详细内容','editor','','','',1,3,0,1,1,0,0,'POST,PUT'),(232,17,'weixin_template_id','微信模板ID','text','','','',0,5,1,1,1,0,0,'POST,PUT'),(233,17,'weixin_template','微信模板内容','textarea','','请按照微信公众号选择模板的格式填写对应的参数。','',0,6,0,1,1,0,0,'POST,PUT'),(234,21,'result','执行结果','text','','','',0,2,1,1,1,0,0,'POST,PUT'),(235,20,'weixin','微信OPENID','text','','','',0,10,1,2,1,1,1,'POST,PUT'),(236,1,'page','分页数','text','','','10',1,5,1,1,1,0,0,'POST,PUT'),(237,15,'time_out','工单超时时长(分钟)','text','','有新工单提交后，在指定时间内无人受理工单，系统将发送通知给工单所在的管辖组成员。','10',1,110,1,1,1,0,0,'POST,PUT'),(238,15,'time_out_sequence','超时提醒次数','text','','工单无人受理超时通知次数，系统将按照工单超时时长的间隔进行重复通知。','1',1,120,0,1,1,0,0,'POST,PUT'),(239,20,'account','登录账号','text','','','',1,1,1,1,1,0,1,'POST,PUT'),(240,15,'contact','联系方式','checkbox','{\"\\u7535\\u5b50\\u90ae\\u4ef6\":\"1\",\"\\u624b\\u673a\\u53f7\\u7801\":\"2\",\"\\u5fae\\u4fe1\":\"3\",\"\\u4f01\\u4e1a\\u5fae\\u4fe1\":\"4\",\"\\u9489\\u9489\":\"5\",\"\\u5fae\\u4fe1\\u5c0f\\u7a0b\\u5e8f\":\"6\"}','','',1,150,1,1,1,0,0,'POST,PUT'),(241,15,'contact_default','默认联系方式','radio','{\"\\u7535\\u5b50\\u90ae\\u4ef6\":\"1\",\"\\u624b\\u673a\\u53f7\\u7801\":\"2\",\"\\u5fae\\u4fe1\":\"3\",\"\\u4f01\\u4e1a\\u5fae\\u4fe1\":\"4\",\"\\u9489\\u9489\":\"5\",\"\\u5fae\\u4fe1\\u5c0f\\u7a0b\\u5e8f\":\"6\"}','','',1,160,0,1,1,0,0,'POST,PUT'),(242,15,'postscript','页内指引','editor','','填写此项，在工单提交内页顶部将显示这部分填写的内容。','',0,140,0,1,1,0,0,'POST,PUT'),(243,15,'default_send','默认发送通知','radio','{&quot;\\u5426&quot;:&quot;0&quot;,&quot;\\u662f&quot;:&quot;1&quot;}','选择是，则当前工单模型的工单处理过程，默认发送通知复选框会勾上。','',0,170,0,1,1,0,0,'POST,PUT'),(244,16,'postscript','工单表单详细说明','editor','','若需要对当前表单字段有更加完整的说明，请在此处填写。','',0,11,0,1,1,0,0,'POST,PUT'),(245,24,'status','状态','radio','{\"\\u7981\\u7528\":\"0\",\"\\u542f\\u7528\":\"1\"}','','1',1,100,1,1,1,0,0,'POST,PUT'),(246,24,'createtime','创建时间','date','','','',0,99,1,1,1,0,0,'POST,PUT'),(247,24,'name','附件名称','text','','','',1,2,1,1,1,0,0,'POST,PUT'),(248,24,'path','附件地址','text','','','',1,3,1,1,1,0,0,'POST,PUT'),(249,24,'path_type','存储位置','radio','{&quot;\\u672c\\u5730\\u786c\\u76d8&quot;:&quot;0&quot;}','','',1,4,1,1,1,0,0,'POST,PUT'),(250,24,'type','附件类型','radio','{&quot;\\u56fe\\u7247&quot;:&quot;0&quot;,&quot;\\u6587\\u4ef6&quot;:&quot;1&quot;,&quot;\\u591a\\u5a92\\u4f53&quot;:&quot;3&quot;}','','',1,1,1,1,1,0,0,'POST,PUT'),(251,24,'owner','上传方','radio','{&quot;\\u524d\\u53f0\\u7528\\u6237&quot;:&quot;0&quot;,&quot;\\u540e\\u53f0\\u7ba1\\u7406&quot;:&quot;1&quot;}','','',1,94,1,1,1,0,0,'POST,PUT'),(252,6,'view_type','允许查看所有用户','radio','{&quot;\\u5426&quot;:&quot;0&quot;,&quot;\\u662f&quot;:&quot;1&quot;}','若您希望本用户组的用户可以查看所有用户信息，请勾选是。','',1,2,1,1,1,0,0,'POST,PUT'),(253,15,'open_close','是否自动关闭工单','radio','{&quot;\\u7981\\u7528&quot;:&quot;0&quot;,&quot;\\u5f00\\u542f&quot;:&quot;1&quot;}','开启此选项后，当工单符合勾选类型时，在达到设定的时间后，将会自动关闭。','',1,180,1,1,1,0,0,'POST,PUT'),(254,15,'close_time','自动关闭时长(分钟)','text','','','',0,200,0,1,1,0,0,'POST,PUT'),(255,25,'type','类型','select','{\"\\u65b0\\u7684\\u5de5\\u5355\":\"1\",\"\\u5de5\\u5355\\u56de\\u590d\":\"3\",\"\\u5de5\\u5355\\u8f6c\\u4ea4\":\"4\",\"\\u5de5\\u5355\\u8d85\\u65f6\":\"504\"}','','',1,1,1,1,1,0,0,'POST,PUT'),(256,25,'title','模板标题','text','','','',1,2,1,1,1,0,0,'POST,PUT'),(257,25,'content','模板内容','editor','','','',1,3,0,1,1,0,0,'POST,PUT'),(258,15,'exclusive','允许指定客服受理','radio','{&quot;\\u5426&quot;:&quot;0&quot;,&quot;\\u662f&quot;:&quot;1&quot;}','开启此功能后，客户在提交工单时，将直接分配给填入名称的客服账号。','',0,210,0,1,1,0,0,'POST,PUT'),(259,7,'job_number','工号','text','','','',1,2,1,1,1,0,1,'POST,PUT'),(260,26,'name','分组名称','text','','','',1,1,1,1,1,0,0,'POST,PUT'),(261,20,'organize_id','所属分组','select','{\"\\u9ed8\\u8ba4\\u5206\\u7ec4\":1}','','',1,1,1,1,1,0,0,'POST,PUT'),(262,15,'organize_id','指定客户分组可见','checkbox','{\"\\u9ed8\\u8ba4\\u5206\\u7ec4\":1}','此选项，若您没有类似VIP客户可见需求，不要勾选上述客户组。否则非登录状态，且非此组的客户账号，将无法看到本工单。','',0,220,0,1,1,0,0,'POST,PUT'),(263,21,'status','发送状态','select','{&quot;\\u672a\\u53d1\\u9001&quot;:&quot;0&quot;,&quot;\\u53d1\\u9001\\u5931\\u8d25&quot;:&quot;1&quot;,&quot;\\u53d1\\u9001\\u6210\\u529f&quot;:&quot;2&quot;}','','',1,6,1,1,1,0,0,'POST,PUT'),(264,21,'sequence','发送次数','text','','','',0,7,1,1,1,0,0,'POST,PUT'),(265,7,'dingtalk','钉钉企业ID','text','','','',0,8,1,1,1,1,1,'POST,PUT'),(266,15,'title_description','工单标题描述','text','','要修改工单详细页的工单标题名称，请在此处填写您要显示的描述。格式为：描述名称|输入框显示的提示信息 。如：工单标题|简单扼要描述本次工单遇到的问题','',0,60,0,1,1,0,0,'POST,PUT'),(267,15,'auto_logic','自动分单逻辑','radio','{&quot;\\u968f\\u673a&quot;:&quot;0&quot;,&quot;\\u5e73\\u5747&quot;:&quot;1&quot;}','','',0,90,0,1,1,0,0,'POST,PUT'),(268,15,'auto','开启自动分单','radio','{&quot;\\u5173\\u95ed&quot;:&quot;0&quot;,&quot;\\u5f00\\u542f&quot;:&quot;1&quot;}','','',1,80,1,1,1,0,0,'POST,PUT'),(269,15,'close_type','自动关闭类型','checkbox','{&quot;\\u5f85\\u89e3\\u51b3&quot;:&quot;0&quot;,&quot;\\u53d7\\u7406\\u4e2d&quot;:&quot;1&quot;,&quot;\\u5f85\\u56de\\u590d&quot;:&quot;2&quot;}','待解决依据提交时间进行关闭。待回复依据工单最后操作时间进行关闭。','',0,190,0,1,1,0,0,'POST,PUT'),(270,20,'wxapp','微信小程序用户ID','text','','','',0,11,0,2,1,1,0,'POST,PUT'),(271,17,'wxapp_template_id','微信小程序模板ID','text','','','',0,7,0,1,1,0,0,'POST,PUT'),(272,17,'wxapp_template','微信小程序模板内容','textarea','','请按照微信小程序选择模板的格式填写对应的参数。','',0,8,0,1,1,0,0,'POST,PUT'),(273,27,'status','状态','radio','{\"\\u7981\\u7528\":\"0\",\"\\u542f\\u7528\":\"1\"}','','1',1,100,1,1,1,0,0,'POST,PUT'),(274,27,'listsort','排序','text','','','',0,98,1,1,1,0,0,'POST,PUT'),(275,27,'createtime','创建时间','date','','','',0,99,1,1,1,0,0,'POST,PUT'),(276,27,'title','标题','text','','','',1,1,1,1,1,0,0,'POST,PUT'),(277,27,'group_id','可见客服分组','multiple','{\"\\u7ba1\\u7406\\u5458\":1,\"\\u5ba2\\u670d\\u4eba\\u5458\":2,\"\\u6295\\u8bc9\\u53cd\\u9988\":3}','','',0,2,1,1,1,0,0,'POST,PUT'),(278,27,'description','内容','editor','','','',1,3,0,1,1,0,0,'POST,PUT'),(279,7,'vacation','休假','radio','{&quot;\\u5de5\\u4f5c&quot;:&quot;0&quot;,&quot;\\u4f11\\u5047&quot;:&quot;1&quot;}','','0',1,98,1,1,1,0,0,'POST,PUT'),(280,2,'only','唯一','radio','{&quot;\\u5426&quot;:&quot;0&quot;,&quot;\\u662f&quot;:&quot;1&quot;}','','',1,12,1,1,1,0,0,'POST,PUT'),(281,2,'action','行为','checkbox','{&quot;\\u65b0\\u589e&quot;:&quot;POST&quot;,&quot;\\u66f4\\u65b0&quot;:&quot;PUT&quot;}','','',0,13,1,1,1,0,0,'POST,PUT'),(282,20,'requisition','允许客服登录','radio','{&quot;\\u7981\\u6b62&quot;:&quot;0&quot;,&quot;\\u5141\\u8bb8&quot;:&quot;1&quot;}','','',1,90,1,2,1,0,0,'POST,PUT'),(283,15,'custom_no','自定义工单单号格式','text','','1. 默认留空单号规则随机生成。2. 只填写{X}则用雪花ID规则。3. 关键词{Y}是年，{M}是月，{D}是日，{Z}是当前工单模型提交的工单总数量，{A}是今天工单模型提交工单数量，{S}是五位数的随机值。','',0,4,0,1,1,0,0,'POST,PUT'),(284,28,'status','状态','radio','{\"\\u7981\\u7528\":\"0\",\"\\u542f\\u7528\":\"1\"}','','1',1,100,1,1,1,0,0,'POST,PUT'),(285,28,'listsort','排序','text','','','',0,98,1,1,1,0,0,'POST,PUT'),(286,28,'createtime','创建时间','date','','','',0,99,1,1,1,0,0,'POST,PUT'),(287,28,'name','菜单名称','text','','','',1,1,1,1,1,0,0,'POST,PUT'),(288,28,'type','菜单类型','radio','{&quot;\\u7ad9\\u5185\\u94fe\\u63a5&quot;:&quot;0&quot;,&quot;\\u7ad9\\u5916\\u94fe\\u63a5&quot;:&quot;1&quot;}','','',1,2,1,1,1,0,0,'POST,PUT'),(289,28,'link','菜单地址','text','','','',1,3,1,1,1,0,0,'POST,PUT'),(290,28,'icon','菜单图标','text','','','',0,4,0,1,1,0,0,'POST,PUT'),(291,15,'fqa_tips','FQA指引','radio','{&quot;\\u5f00\\u542f&quot;:&quot;0&quot;,&quot;\\u5173\\u95ed&quot;:&quot;1&quot;}','默认开启FQA指引，客户提交工单时，若当前工单模型存在FQA文档，则弹出FQA指引列表和工单提交按钮。','0',1,7,0,1,1,0,0,'POST,PUT'),(292,20,'dingtalk','钉钉','text','','','',0,32,0,2,1,1,0,'POST,PUT'),(293,20,'wxWork','企业微信','text','','','',0,33,0,2,1,1,0,'POST,PUT'),(294,16,'default','表单默认值','textarea','','若您的工单表单需要设置默认值，可以在这里填写对应的数值。页面渲染时会自动填充。<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;注意：部分表单类型可能不起效','',0,15,0,1,1,0,0,'POST,PUT'),(295,15,'recovery_day','工单恢复期限','text','','一般工单结束后，客户可以在7天内手动恢复功能。修改本参数可以调整对应的恢复期限。','7',0,65,1,1,1,0,0,'POST,PUT');
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
-- Table structure for table `pes_form_menu`
--

DROP TABLE IF EXISTS `pes_form_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pes_form_menu` (
  `form_menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `form_menu_listsort` int(11) NOT NULL DEFAULT '0',
  `form_menu_status` tinyint(4) NOT NULL DEFAULT '0',
  `form_menu_createtime` int(11) NOT NULL DEFAULT '0',
  `form_menu_name` varchar(255) NOT NULL DEFAULT '',
  `form_menu_type` int(11) NOT NULL DEFAULT '0',
  `form_menu_link` varchar(255) NOT NULL DEFAULT '',
  `form_menu_icon` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`form_menu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pes_form_menu`
--

LOCK TABLES `pes_form_menu` WRITE;
/*!40000 ALTER TABLE `pes_form_menu` DISABLE KEYS */;
INSERT INTO `pes_form_menu` VALUES (1,1,1,1652840160,'网站首页',1,'/',''),(2,2,1,1652840160,'提交工单',0,'Category-index',''),(3,3,1,1652840160,'常见问题',0,'Fqa-list',''),(4,4,1,1652840160,'我的工单',0,'Member-ticket','');
/*!40000 ALTER TABLE `pes_form_menu` ENABLE KEYS */;
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
-- Table structure for table `pes_help_document`
--

DROP TABLE IF EXISTS `pes_help_document`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pes_help_document` (
  `help_document_id` int(11) NOT NULL AUTO_INCREMENT,
  `help_document_controller` varchar(64) NOT NULL COMMENT '控制器',
  `help_document_link` varchar(255) NOT NULL COMMENT '文档链接地址',
  PRIMARY KEY (`help_document_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COMMENT='系统帮助文档';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pes_help_document`
--

LOCK TABLES `pes_help_document` WRITE;
/*!40000 ALTER TABLE `pes_help_document` DISABLE KEYS */;
INSERT INTO `pes_help_document` VALUES (1,'Ticket-Index-index','https://document.pescms.com/article/3/262978503023001600.html'),(2,'Ticket-Ticket-:a','https://document.pescms.com/article/3/263572759471194112.html'),(3,'Ticket-Ticket-handle','https://document.pescms.com/article/3/268557014429335552.html'),(4,'Ticket-Ticket_model-index','https://document.pescms.com/article/3/268655938838200320.html'),(5,'Ticket-Category-index','https://document.pescms.com/article/3/268651201115979776.html'),(6,'Ticket-Fqa-index','https://document.pescms.com/article/3/268657472783253504.html'),(7,'Ticket-Ticket_form-index','https://document.pescms.com/article/3/269002122886905856.html'),(8,'Ticket-Setting-action','https://document.pescms.com/article/3/276527731582173184.html'),(9,'Ticket-Route-index','https://document.pescms.com/article/3/277977871924854784.html'),(10,'Ticket-Mail_template-index','https://document.pescms.com/article/3/277980824031199232.html'),(11,'Ticket-Member-issue','https://document.pescms.com/article/3/263321778955223040.html'),(12,'Ticket-Phrase-index','https://document.pescms.com/article/3/263494640320118784.html'),(13,'Ticket-User-setting','https://document.pescms.com/article/3/263493076029276160.html'),(14,'Ticket-User-index','https://document.pescms.com/article/3/270750844222177280.html'),(15,'Ticket-User_group-index','https://document.pescms.com/article/3/270754494185209856.html'),(16,'Ticket-Ticket-complain','https://document.pescms.com/article/3/262978779675099136.html');
/*!40000 ALTER TABLE `pes_help_document` ENABLE KEYS */;
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
  `mail_template_wxapp_template_id` varchar(128) NOT NULL,
  `mail_template_wxapp_template` text NOT NULL,
  PRIMARY KEY (`mail_template_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pes_mail_template`
--

LOCK TABLES `pes_mail_template` WRITE;
/*!40000 ALTER TABLE `pes_mail_template` DISABLE KEYS */;
INSERT INTO `pes_mail_template` VALUES (1,1,'工单提交成功！您的工单编号为：{ticket_number}','&lt;p&gt;我们已经收到您提交的工单，单号为：{ticket_number} 。我们将会尽快对您的问题进行处理，请耐心等待。此外，您可以通过如下链接对工单的进度查询：{ticket_link}&lt;/p&gt;','我们已经收到您提交的工单，我们将尽快安排人员为您解疑释惑。您的工单编号为：{ticket_number}。请不要把工单号码泄露给其他人。','','{&quot;&quot;:{&quot;value&quot;:&quot;&quot;,&quot;color&quot;:&quot;#000000&quot;}}','',''),(2,2,'工单:{ticket_number}已经受理','&lt;p&gt;您的工单已经受理，我们将会尽快解决您的问题，请耐心等待。\n查看工单进度，可以点击如下链接访问：{ticket_link}&lt;/p&gt;','您的工单已经受理，我们将会尽快解决您的问题，请耐心等待。 查看工单进度，可以点击如下链接访问：{ticket_link}','','{&quot;&quot;:{&quot;value&quot;:&quot;&quot;,&quot;color&quot;:&quot;#000000&quot;}}','',''),(3,3,'工单:{ticket_number}有新的回复','&lt;p&gt;您好，您的工单:{ticket_number} 有新的回复。点击如下链接可以查看工单的进度:{ticket_link}&lt;/p&gt;','您好，您的工单:{ticket_number} 有新的回复。点击如下链接可以查看工单的进度:{ticket_link}','','{&quot;&quot;:{&quot;value&quot;:&quot;&quot;,&quot;color&quot;:&quot;#000000&quot;}}','',''),(4,4,'工单:{ticket_number}需要转交客服处理','&lt;p&gt;您好，您的工单{ticket_number}需要转交客服处理，请耐心等待。\n点击如下链接可以查看工单的进度:{ticket_link}&lt;/p&gt;','您好，您的工单{ticket_number}需要转交客服处理，请耐心等待。','','{&quot;&quot;:{&quot;value&quot;:&quot;&quot;,&quot;color&quot;:&quot;#000000&quot;}}','',''),(5,5,'工单:{ticket_number}已经完成','&lt;p&gt;您好，您的工单:{ticket_number}已经被客服标记为完成状态。该工单将无法继续操作。若您的问题仍旧无法解决，请重新发起新的工单，感谢您的耐心等待。\n查看工单的详情，请点击如下链接:{ticket_link}&lt;/p&gt;','您好，您的工单:{ticket_number}已经被客服标记为完成状态。该工单将无法继续操作。若您的问题仍旧无法解决，请重新发起新的工单，感谢您的耐心等待。','','{&quot;&quot;:{&quot;value&quot;:&quot;&quot;,&quot;color&quot;:&quot;#000000&quot;}}','',''),(6,6,'工单:{ticket_number}被关闭','&lt;p&gt;您好，非常抱歉地告诉您，您的工单:{ticket_number}已经被客服标关闭。该工单将无法继续操作。若您的问题仍旧无法解决，请重新发起新的工单，感谢您的反馈。\n查看工单的详情，请点击如下链接:{ticket_link}&lt;/p&gt;','您好，非常抱歉地告诉您，您的工单:{ticket_number}已经被客服标关闭。该工单将无法继续操作。若您的问题仍旧无法解决，请重新发起新的工单，感谢您的反馈。','','{&quot;&quot;:{&quot;value&quot;:&quot;&quot;,&quot;color&quot;:&quot;#000000&quot;}}','','');
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
  `member_wxapp` varchar(255) DEFAULT NULL COMMENT '小程序用户ID',
  `member_avatar` varchar(255) NOT NULL COMMENT '用户头像',
  `member_wxWork` varchar(255) DEFAULT NULL,
  `member_dingtalk` varchar(255) DEFAULT NULL,
  `member_requisition` int(11) NOT NULL,
  PRIMARY KEY (`member_id`),
  UNIQUE KEY `member_email` (`member_email`),
  UNIQUE KEY `member_account` (`member_account`) USING BTREE,
  UNIQUE KEY `member_phone` (`member_phone`) USING BTREE,
  UNIQUE KEY `member_weixin` (`member_weixin`),
  UNIQUE KEY `member_wxWork` (`member_wxWork`),
  UNIQUE KEY `member_dingtalk` (`member_dingtalk`)
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
-- Table structure for table `pes_member_activation`
--

DROP TABLE IF EXISTS `pes_member_activation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pes_member_activation` (
  `activation_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `activation_code` varchar(255) NOT NULL,
  `activation_time` int(11) NOT NULL,
  PRIMARY KEY (`activation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='账号激活表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pes_member_activation`
--

LOCK TABLES `pes_member_activation` WRITE;
/*!40000 ALTER TABLE `pes_member_activation` DISABLE KEYS */;
/*!40000 ALTER TABLE `pes_member_activation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pes_member_organize`
--

DROP TABLE IF EXISTS `pes_member_organize`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pes_member_organize` (
  `member_organize_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_organize_name` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`member_organize_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
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
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pes_menu`
--

LOCK TABLES `pes_menu` WRITE;
/*!40000 ALTER TABLE `pes_menu` DISABLE KEYS */;
INSERT INTO `pes_menu` VALUES (1,'工单设置',0,'am-icon-ticket','',3,0),(2,'工单模型',1,'am-icon-modx','Ticket-Ticket_model-index',2,0),(3,'账号管理',0,'am-icon-users','',5,0),(4,'客服账号',3,'am-icon-user','Ticket-User-index',1,0),(6,'基础设置',9,'am-icon-tv','Ticket-Setting-action',1,0),(7,'菜单设置',9,'am-icon-map-signs','Ticket-Menu-index',2,0),(9,'系统设置',0,'am-icon-cog','',10,0),(10,'帮助文档',9,'am-icon-leanpub','https://document.pescms.com/article/3.html',98,1),(12,'工作台',0,'am-icon-tachometer','Ticket-Index-index',1,0),(13,'工单列表',0,'am-icon-yelp','',2,0),(14,'客服分组',3,'am-icon-steam','Ticket-User_group-index',2,0),(15,'节点管理',3,'am-icon-toggle-off','Ticket-Node-index',3,0),(16,'路由规则',9,'am-icon-map-o','Ticket-Route-index',4,0),(17,'工单列表',13,'am-icon-fire','Ticket-Ticket-index',2,0),(18,'我的工单',13,'am-icon-coffee','Ticket-Ticket-myTicket',3,0),(19,'通知模板',9,'am-icon-paint-brush','Ticket-Mail_template-index',7,0),(21,'工单分类',1,'am-icon-list-alt','Ticket-Category-index',1,0),(23,'客户管理',3,'am-icon-street-view','Ticket-Member-index',4,0),(24,'应用商店',9,'am-icon-cogs','Ticket-Application-index',3,0),(25,'商业授权',9,'am-icon-registered','https://www.pescms.com/Page/Authorization.html',99,1),(26,'发送列表',9,'am-icon-send','Ticket-Send-index',5,0),(27,'全部工单',13,'am-icon-list','Ticket-Ticket-all',1,0),(32,'常见问题解答',1,'am-icon-question-circle','Ticket-Fqa-index',20,0),(33,'工单投诉反馈',0,'am-icon-cutlery','Ticket-Ticket-complain',6,0),(34,'附件管理',9,'am-icon-suitcase','Ticket-Attachment-index',8,0),(35,'客服消息模板',9,'am-icon-phone-square','Ticket-Cssend_template-index',6,0),(36,'客户分组',3,'am-icon-user-secret','Ticket-Member_organize-index',5,0),(37,'模板管理',9,'am-icon-magic','Ticket-Theme-index',10,0),(38,'公告栏',9,'am-icon-building','Ticket-Bulletin-index',11,0),(39,'前台菜单',9,'am-icon-map-signs','Ticket-Form_menu-index',12,0),(40,'日志快查',9,'am-icon-ambulance','Ticket-Log-index',90,0);
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
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pes_model`
--

LOCK TABLES `pes_model` WRITE;
/*!40000 ALTER TABLE `pes_model` DISABLE KEYS */;
INSERT INTO `pes_model` VALUES (1,'model','模型管理',1,1,2,10),(2,'field','字段管理',1,1,2,10),(3,'menu','菜单模型',1,1,2,10),(4,'route','路由规则',1,1,2,10),(6,'User_group','客服分组',1,0,2,10),(7,'User','客服账号',1,0,2,10),(13,'Node','节点列表',1,1,2,10),(15,'ticket_model','工单模型',1,1,2,10),(16,'ticket_form','工单表单',1,1,2,10),(17,'mail_template','通知模板',1,0,2,10),(18,'Category','分类',1,1,1,10),(20,'Member','客户管理',1,1,1,10),(21,'Send','发送列表',1,1,1,10),(22,'Phrase','回复短语',1,0,2,10),(23,'Fqa','常见问题解答',1,1,1,10),(24,'attachment','附件管理',1,0,2,30),(25,'cssend_template','客服消息模板',1,0,2,10),(26,'member_organize','客户分组',1,0,2,10),(27,'Bulletin','公告栏',1,0,2,10),(28,'form_menu','前台菜单',1,0,1,999);
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
) ENGINE=InnoDB AUTO_INCREMENT=150 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pes_node`
--

LOCK TABLES `pes_node` WRITE;
/*!40000 ALTER TABLE `pes_node` DISABLE KEYS */;
INSERT INTO `pes_node` VALUES (1,'首页',0,0,'','GET','Index','',-1,1),(2,'工单列表',0,0,'','GET','Ticket','',0,2),(3,'工单列表',2,1,'','GET','index','TicketGETTicketindex',2,1),(4,'我的工单',2,1,'','GET','myTicket','TicketGETTicketmyTicket',2,2),(5,'回复工单',2,1,'','POST','reply','TicketPOSTTicketreply',2,3),(6,'关闭工单',2,1,'','POST','close','TicketPOSTTicketclose',2,4),(7,'工单设置',0,0,'','GET','','',-1,3),(8,'工单模型',11,0,'','GET','Ticket_model','',0,1),(9,'工单表单',11,0,'','GET','Ticket_form','',0,2),(10,'添加/编辑新工单',7,1,'','GET','action','TicketGETTicket_modelaction',8,20),(11,'杂项节点',0,0,'','GET','','',-1,99),(12,'工单模型列表',7,1,'','GET','index','TicketGETTicket_modelindex',8,10),(13,'提交新增工单模型',7,1,'','POST','action','TicketPOSTTicket_modelaction',8,30),(14,'提交更新工单模型',7,1,'','PUT','action','TicketPUTTicket_modelaction',8,40),(15,'提交删除工单模型',7,1,'','DELETE','action','TicketDELETETicket_modelaction',8,50),(16,'工单表单列表',7,1,'','GET','index','TicketGETTicket_formindex',9,60),(17,'新增/编辑工单表单',7,1,'','GET','action','TicketGETTicket_formaction',9,70),(18,'提交新增工单表单',7,1,'','POST','action','TicketPOSTTicket_formaction',9,80),(19,'提交更新工单表单',7,1,'','PUT','action','TicketPUTTicket_formaction',9,90),(20,'提交删除工单表单',7,1,'','DELETE','action','TicketDELETETicket_formaction',9,100),(21,'客服管理',0,0,'','GET','User','',0,4),(22,'客服组',11,0,'','GET','User_group','',0,3),(23,'节点管理',11,0,'','GET','Node','',0,4),(24,'客服列表',21,1,'','GET','index','TicketGETUserindex',21,10),(25,'新增/编辑客服',21,1,'','GET','action','TicketGETUseraction',21,20),(26,'提交新增客服',21,1,'','POST','action','TicketPOSTUseraction',21,30),(27,'提交更新客服',21,1,'','PUT','action','TicketPUTUseraction',21,40),(28,'提交删除客服',21,1,'','DELETE','action','TicketDELETEUseraction',21,50),(29,'客服组列表',21,1,'','GET','index','TicketGETUser_groupindex',22,60),(30,'新增/编辑客服组',21,1,'','GET','action','TicketGETUser_groupaction',22,70),(31,'提交新增客服组',21,1,'','POST','action','TicketPOSTUser_groupaction',22,80),(32,'提交编辑客服组',21,1,'','PUT','action','TicketPUTUser_groupaction',22,90),(33,'提交删除客服组',21,1,'','DELETE','action','TicketDELETEUser_groupaction',22,100),(34,'查看客服组菜单',21,1,'','GET','setMenu','TicketGETUser_groupsetMenu',22,110),(35,'更新客服组菜单',21,1,'','PUT','setMenu','TicketPUTUser_groupsetMenu',22,120),(36,'查看客服组权限',21,1,'','GET','setAuth','TicketGETUser_groupsetAuth',22,130),(37,'更新客服组权限',21,1,'','PUT','setAuth','TicketPUTUser_groupsetAuth',22,140),(38,'节点列表',21,1,'','GET','index','TicketGETNodeindex',23,150),(39,'新增/编辑节点',21,1,'','GET','action','TicketGETNodeaction',23,160),(40,'提交新增节点',21,1,'','POST','action','TicketPOSTNodeaction',23,170),(41,'提交更新节点',21,1,'','PUT','action','TicketPUTNodeaction',23,180),(42,'提交删除节点',21,1,'','DELETE','action','TicketDELETENodeaction',23,190),(43,'系统设置',0,0,'','GET','Setting','',0,6),(44,'查看基础设置',43,1,'','GET','action','TicketGETSettingaction',43,10),(45,'更新基础设置',43,1,'','PUT','action','TicketPUTSettingaction',43,20),(46,'菜单设置',11,0,'','GET','Menu','',0,5),(47,'查看菜单',43,1,'','GET','index','TicketGETMenuindex',46,30),(48,'新增菜单',43,1,'','POST','action','TicketPOSTMenuaction',46,50),(49,'新增/编辑菜单',43,1,'','GET','action','TicketGETMenuaction',46,40),(50,'更新菜单',43,1,'','PUT','action','TicketPUTMenuaction',46,60),(51,'删除菜单',43,1,'','DELETE','action','TicketDELETEMenuaction',46,70),(52,'路由规则',11,0,'','GET','Route','',0,6),(53,'路由列表',43,1,'','GET','index','TicketGETRouteindex',52,80),(54,'新增/编辑路由规则',43,1,'','GET','action','TicketGETRouteaction',52,90),(55,'新增路由规则',43,1,'','POST','action','TicketPOSTRouteaction',52,100),(56,'更新路由规则',43,1,'','PUT','action','TicketPUTRouteaction',52,110),(57,'删除路由规则',43,1,'','DELETE','action','TicketDELETERouteaction',52,120),(58,'模型管理',0,0,'','GET','Model','',0,95),(59,'字段管理',11,0,'','GET','Field','',0,1),(60,'模型列表',58,1,'','GET','index','TicketGETModelindex',58,1),(61,'新增/编辑模型',58,1,'','GET','action','TicketGETModelaction',58,1),(62,'新增模型',58,1,'','POST','action','TicketPOSTModelaction',58,1),(63,'更新模型',58,1,'','PUT','action','TicketPUTModelaction',58,1),(64,'删除模型',58,1,'','DELETE','action','TicketDELETEModelaction',58,1),(65,'字段列表',58,1,'','GET','index','TicketGETFieldindex',59,0),(66,'新增/编辑字段',58,1,'','GET','action','TicketGETFieldaction',59,0),(67,'新增字段',58,1,'','POST','action','TicketPOSTFieldaction',59,0),(68,'更新字段',58,1,'','PUT','action','TicketPUTFieldaction',59,0),(69,'删除字段',58,1,'','DELETE','action','TicketDELETEFieldaction',59,0),(70,'邮件模板',11,0,'','GET','Mail_template','',0,7),(71,'邮件模板列表',43,1,'','GET','index','TicketGETMail_templateindex',70,0),(72,'新增/编辑邮件模板',43,1,'','GET','action','TicketGETMail_templateaction',70,0),(73,'添加邮件模板',43,1,'','POST','action','TicketPOSTMail_templateaction',70,0),(74,'更新邮件模板',43,1,'','PUT','action','TicketPUTMail_templateaction',70,0),(75,'删除邮件模板',43,1,'','DELETE','action','TicketDELETEMail_templateaction',70,0),(76,'分类管理',0,0,'','GET','Category','',0,5),(77,'新增/编辑分类',76,1,'','GET','action','TicketGETCategoryaction',76,2),(78,'提交新增分类',76,1,'','POST','action','TicketPOSTCategoryaction',76,3),(79,'提交分类更新',76,1,'','PUT','action','TicketPUTCategoryaction',76,4),(80,'提交分类删除',76,1,'','DELETE','action','TicketDELETECategoryaction',76,5),(81,'分类列表',76,1,'','DELETE','index','TicketGETCategoryindex',76,1),(82,'删除工单',2,1,'当前权限不足，无法删除工单。','DELETE','action','TicketDELETETicketaction',2,5),(83,'全部工单',2,1,'','GET','all','TicketGETTicketall',2,5),(84,'常见问题',11,1,'','GET','Fqa','',0,8),(85,'FQA列表',7,1,'','GET','index','TicketGETFqaindex',84,110),(86,'FQA编辑',7,1,'','GET','action','TicketGETFqaaction',84,111),(87,'FQA添加',7,1,'','POST','action','TicketPOSTFqaaction',84,112),(88,'FQA更新',7,1,'','PUT','action','TicketPUTFqaaction',84,113),(89,'FQA删除',7,1,'','DELETE','action','TicketDELETEFqaaction',84,114),(90,'复制客服组',21,1,'','POST','copy','TicketPOSTUser_groupcopy',22,141),(91,'工单投诉列表',2,1,'','GET','complain','TicketGETTicketcomplain',2,130),(92,'工单投诉详情',2,1,'','GET','complainDetail','TicketGETTicketcomplainDetail',2,131),(93,'附件管理',11,1,'','GET','Attachment','',0,9),(94,'附件列表',43,1,'','GET','index','TicketGETAttachmentindex',93,130),(95,'附件编辑',43,1,'','GET','action','TicketGETAttachmentaction',93,140),(96,'附件添加',43,1,'','POST','action','TicketPOSTAttachmentaction',93,150),(97,'附件更新',43,1,'','PUT','action','TicketPUTAttachmentaction',93,160),(98,'附件删除',43,1,'','DELETE','action','TicketDELETEAttachmentaction',93,170),(99,'发送列表',11,0,NULL,'GET','Send','',0,10),(100,'清空发送列表',43,1,NULL,'DELETE','truncate','TicketDELETESendtruncate',99,180),(101,'客户管理',0,0,'','GET','Member','',0,4),(102,'客户列表列表',101,1,'','GET','index','TicketGETMemberindex',101,10),(103,'新增/编辑客户',101,1,'','GET','action','TicketGETMemberaction',101,20),(104,'提交新增客户',101,1,'','POST','action','TicketPOSTMemberaction',101,30),(105,'提交更新客户',101,1,'','PUT','action','TicketPUTMemberaction',101,40),(106,'提交删除客户',101,1,'','DELETE','action','TicketDELETEMemberaction',101,50),(107,'创建工单',2,1,'','GET','issue','TicketGETMemberissue',101,50),(108,'创建工单-登录客户账号',2,1,'','GET','issueLogin','TicketGETMemberissueLogin',101,50),(109,'客户分组管理',0,0,'','GET','Member_organize','',0,4),(110,'客户分组列表列表',109,1,'','GET','index','TicketGETMember_organizeindex',109,10),(111,'新增/编辑客户分组',109,1,'','GET','action','TicketGETMember_organizeaction',109,20),(112,'提交新增客户分组',109,1,'','POST','action','TicketPOSTMember_organizeaction',109,30),(113,'提交更新客户分组',109,1,'','PUT','action','TicketPUTMember_organizeaction',109,40),(114,'提交删除客户分组',109,1,'','DELETE','action','TicketDELETEMember_organizeaction',109,50),(115,'公告栏',0,0,NULL,'GET','Bulletin','',0,2700),(116,'公告栏列表',115,0,NULL,'GET','index','TicketGETBulletinindex',115,0),(117,'新增/编辑公告栏',115,0,NULL,'GET','action','TicketGETBulletinaction',115,1),(118,'请求新增公告栏',115,0,NULL,'POST','action','TicketPOSTBulletinaction',115,2),(119,'请求更新公告栏',115,0,NULL,'PUT','action','TicketPUTBulletinaction',115,3),(120,'请求删除公告栏',115,0,NULL,'DELETE','action','TicketDELETEBulletinaction',115,4),(121,'变更工单模型',2,1,'您没有权限变更工单模型','PUT','changeTicketModel','TicketPUTTicketchangeTicketModel',2,6),(122,'工单标记完成',2,1,'您没有工单完成的权限 ','PUT','complete','TicketPUTTicketcomplete',2,7),(123,'工单介入处理',2,1,'您没有工单介入处理权限','PUT','intervene','TicketPUTTicketintervene',2,8),(124,'列表置顶工单',2,1,'您没有权限置顶列表工单','PUT','setListTop','TicketPUTTicketsetListTop',2,9),(125,'前台菜单管理',0,0,'','GET','Form_menu','',0,7),(126,'前台菜单列表',125,1,'','GET','index','TicketGETForm_menuindex',125,10),(127,'新增/编辑前台菜单',125,1,'','GET','action','TicketGETForm_menuaction',125,20),(128,'提交新增前台菜单',125,1,'','POST','action','TicketPOSTForm_menuaction',125,30),(129,'提交更新前台菜单',125,1,'','PUT','action','TicketPUTForm_menuaction',125,40),(130,'提交删除前台菜单',125,1,'','DELETE','action','TicketDELETEForm_menuaction',125,50),(131,'排序前台菜单',125,1,'','PUT','action','TicketPUTForm_menulistsort',125,60),(132,'应用商店',0,0,NULL,'GET','Application','',0,2800),(133,'打开应用商店',132,0,NULL,'GET','index','TicketGETApplicationindex',132,0),(134,'打开本地应用',132,0,NULL,'GET','index','TicketGETApplicationlocal',132,0),(135,'安装应用',132,0,NULL,'GET','index','TicketGETApplicationinstall',132,0),(136,'更新应用',132,0,NULL,'GET','index','TicketGETApplicationupgrade',132,0),(137,'前台菜单',0,0,NULL,'GET','Form_menu','',0,2900),(138,'前台菜单列表',137,0,NULL,'GET','index','TicketGETForm_menuindex',137,0),(139,'新增/编辑前台菜单',137,0,NULL,'GET','action','TicketGETForm_menuaction',137,1),(140,'请求新增前台菜单',137,0,NULL,'POST','action','TicketPOSTForm_menuaction',137,2),(141,'请求更新前台菜单',137,0,NULL,'PUT','action','TicketPUTForm_menuaction',137,3),(142,'排序前台菜单',137,0,NULL,'PUT','listsort','TicketPUTForm_menulistsort',137,3),(143,'请求删除前台菜单',137,0,NULL,'DELETE','action','TicketDELETEForm_menuaction',137,4),(144,'模板商店',0,0,NULL,'GET','Theme','',0,2800),(145,'打开模板商店',144,0,NULL,'GET','index','TicketGETThemeshop',144,0),(146,'模板列表',144,0,NULL,'GET','index','TicketGETThemeindex',144,0),(147,'安装模板',144,0,NULL,'GET','index','TicketGETThemeinstall',144,0),(148,'更新模板',144,0,NULL,'GET','index','TicketGETThemeupgrade',144,0),(149,'切换模板',144,0,NULL,'PUT','index','TicketGETThemecall',144,0);
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
) ENGINE=InnoDB AUTO_INCREMENT=210 DEFAULT CHARSET=utf8 COMMENT='用户组权限节点';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pes_node_group`
--

LOCK TABLES `pes_node_group` WRITE;
/*!40000 ALTER TABLE `pes_node_group` DISABLE KEYS */;
INSERT INTO `pes_node_group` VALUES (70,3,2),(71,3,91),(72,3,92),(92,1,1),(93,1,2),(94,1,3),(95,1,4),(96,1,5),(97,1,6),(98,1,83),(99,1,82),(100,1,121),(101,1,122),(102,1,123),(103,1,124),(104,1,108),(105,1,107),(106,1,91),(107,1,92),(108,1,7),(109,1,12),(110,1,10),(111,1,13),(112,1,14),(113,1,15),(114,1,16),(115,1,17),(116,1,18),(117,1,19),(118,1,20),(119,1,85),(120,1,86),(121,1,87),(122,1,88),(123,1,89),(124,1,110),(125,1,111),(126,1,112),(127,1,113),(128,1,114),(129,1,102),(130,1,103),(131,1,104),(132,1,105),(133,1,106),(134,1,21),(135,1,24),(136,1,25),(137,1,26),(138,1,27),(139,1,28),(140,1,29),(141,1,30),(142,1,31),(143,1,32),(144,1,33),(145,1,34),(146,1,35),(147,1,36),(148,1,37),(149,1,38),(150,1,39),(151,1,40),(152,1,41),(153,1,42),(154,1,76),(155,1,81),(156,1,77),(157,1,78),(158,1,79),(159,1,80),(160,1,43),(161,1,75),(162,1,74),(163,1,73),(164,1,72),(165,1,71),(166,1,44),(167,1,45),(168,1,47),(169,1,49),(170,1,48),(171,1,50),(172,1,51),(173,1,53),(174,1,54),(175,1,55),(176,1,56),(177,1,57),(178,1,94),(179,1,95),(180,1,96),(181,1,97),(182,1,98),(183,1,100),(184,1,11),(185,1,8),(186,1,9),(187,1,22),(188,1,23),(189,1,46),(190,1,52),(191,1,70),(192,1,84),(193,1,93),(194,1,99),(195,1,115),(196,1,116),(197,1,117),(198,1,118),(199,1,119),(200,1,120),(201,2,1),(202,2,2),(203,2,3),(204,2,4),(205,2,5),(206,2,6),(207,2,122),(208,2,108),(209,2,107);
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
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pes_option`
--

LOCK TABLES `pes_option` WRITE;
/*!40000 ALTER TABLE `pes_option` DISABLE KEYS */;
INSERT INTO `pes_option` VALUES (1,'domain','网站URL','','system'),(2,'crossdomain','跨域列表','','system'),(3,'version','系统版本','','system'),(4,'openindex','开启首页','1','system'),(5,'customstatus','工单状态','[{\"color\":\"#dd514c\",\"name\":\"\\u65b0\\u5de5\\u5355\"},{\"color\":\"#F37B1D\",\"name\":\"\\u53d7\\u7406\\u4e2d\"},{\"color\":\"#3bb4f2\",\"name\":\"\\u5f85\\u56de\\u590d\"},{\"color\":\"#5eb95e\",\"name\":\"\\u5b8c\\u6210\"}]',''),(6,'mail','邮箱设置','',''),(7,'notice_way','通知方式','3','system'),(8,'upload_img','图片格式','[\".jpg\",\".jpge\",\".bmp\",\".gif\",\".png\"]','upload'),(9,'upload_file','文件格式','[\".zip\",\".rar\",\".7z\",\".doc\",\".docx\",\".pdf\",\".xls\",\".xlsx\",\".ppt\",\".pptx\",\".txt\"]','upload'),(10,'interior_ticket','站内工单','1','system'),(11,'open_register','开启注册','1','system'),(12,'weixin_api','微信接口','','system'),(13,'weixinWork_api','企业微信接口','','system'),(14,'login_verify','登录验证码','[\"1\"]','system'),(15,'cs_notice_type','客服人员接收通知方式','{\"1\":\"1\"}','system'),(16,'sms','短信接口','','system'),(17,'siteLogo','网站LOGO','/Theme/assets/i/logo.png','system'),(18,'siteTitle','网站名称','PESCMS Ticket开源版','system'),(19,'pescmsIntroduce','页脚内容','<div class=\"am-u-sm-12 am-u-lg-11 am-u-sm-centered\">\r\n    <div class=\"am-g\">\r\n        <div class=\"am-u-sm-12 am-u-lg-3\">\r\n            <h4>关于我们</h4>\r\n            <p>当前站点正在使用<strong>PESCMS Ticket客服工单系统开源版</strong>。页脚内容为开源版预设，请按照业务需求自行设置页脚内容。</p>\r\n        </div>\r\n        <div class=\"am-u-sm-12 am-u-lg-3\">\r\n            <h4>PESCMS产品介绍</h4>\r\n            <ul>\r\n                <li><a href=\"https://www.pescms.com/download/2.html\">PESCMS TEAM 团队任务管理系统</a></li>\r\n                <li><a href=\"https://www.pescms.com/download/3.html\">PESCMS DOC 文档管理系统</a></li>\r\n                <li><a href=\"https://www.pescms.com/download/5.html\">PESCMS TICKET 客服工单系统</a></li>\r\n                <li><a href=\"https://www.pescms.com/download/4.html\">PESCMS LOGIN 网站登录管理</a></li>\r\n                <li><a href=\"https://www.pescms.com/download/6.html\">基金定投助手</a></li>\r\n            </ul>\r\n        </div>\r\n        <div class=\"am-u-sm-12 am-u-lg-3 am-u-end\">\r\n            <h4>PESCMS产品服务</h4>\r\n            <ul>\r\n                <li><a href=\"https://www.pescms.com/Page/Authorization.html\">商业授权</a></li>\r\n                <li><a href=\"https://www.pescms.com/Authorize-Verify\">授权查询</a></li>\r\n                <li><a href=\"https://www.pescms.com/service.html\">有偿服务</a></li>\r\n                <li><a href=\"https://www.pescms.com/Page/ad.html\">广告投放</a></li>\r\n                <li><a href=\"https://www.pescms.com/Page/donate.html\">赞助捐赠</a></li>\r\n            </ul>\r\n        </div>\r\n    </div>\r\n</div>','system'),(20,'siteContact','网站联系方式','<span class=\"am-margin-right-xs\"><i class=\"am-icon-qq\"></i> <a href=\"https://wpa.qq.com/msgrd?v=3&uin=&menu=yes\" target=\"_blank\">10000</a></span>\r\n<span class=\"am-margin-right-xs\"><i class=\"am-icon-weixin\"></i> <a href=\"javascript:;\" data-am-popover=\"{content: \'<img src=\\\'https://www.pescms.com/Theme/assets/i/weixin_test.jpg\\\' width=300>\', trigger: \'hover focus\'}\" >NoTSet</a></span>','system'),(21,'authorize','授权码','',''),(22,'siteKeywords','网站Keywords','PESCMS Ticket是一款以GPLv2协议发布的开源工单客服系统','system'),(23,'siteDescription','网站Description','PESCMS,PESCMS Ticket,开源的工单系统,工单系统,工单客服系统,客服工单系统,GPL工单,GPL客服系统,GPL工单客服系统','system'),(24,'verifyLength','验证码长度','4','system'),(25,'member_review','审核设置','1','system'),(26,'indexStyle','首页样式','0','system'),(27,'member_login','客户登录方式','0','system'),(28,'max_upload_size','上传大小','1','upload'),(29,'siteStyle','自定义样式','','system'),(30,'siteTongji','网站统计代码','','system'),(31,'weixinRegister','微信公众号注册需要填写完整的用户资料','0','system'),(32,'cs_text','工单回复文本','{\"accept\":{\"title\":\"\\u5de5\\u5355\\u53d7\\u7406\\u56de\\u590d\",\"content\":\"\\u5df2\\u6536\\u5230\\u60a8\\u7684\\u5de5\\u5355\\uff0c\\u6211\\u4eec\\u5c06\\u4f1a\\u5c3d\\u5feb\\u5b89\\u6392\\u4eba\\u624b\\u8fdb\\u884c\\u5904\\u7406\\u3002\"},\"assign\":{\"title\":\"\\u5de5\\u5355\\u8f6c\\u6d3e\\u56de\\u590d\",\"content\":\"\\u5f53\\u524d\\u95ee\\u9898\\u9700\\u8981\\u79fb\\u4ea4\\u7ed9\\u5176\\u4ed6\\u5ba2\\u670d\\u4eba\\u5458\\uff0c\\u8bf7\\u8010\\u5fc3\\u7b49\\u5f85\\u3002\"},\"complete\":{\"title\":\"\\u5de5\\u5355\\u5b8c\\u6210\\u56de\\u590d\",\"content\":\"\\u5ba2\\u670d\\u5df2\\u7ecf\\u5c06\\u672c\\u5de5\\u5355\\u7ed3\\u675f\\uff0c\\u5982\\u6709\\u7591\\u95ee\\u8bf7\\u91cd\\u65b0\\u53d1\\u8d77\\u5de5\\u5355\\u54a8\\u8be2\\uff0c\\u8c22\\u8c22!\"},\"close\":{\"title\":\"\\u5de5\\u5355\\u5173\\u95ed\\u56de\\u590d\",\"content\":\"\\u5de5\\u5355\\u5df2\\u5173\\u95ed\\uff0c\\u82e5\\u8fd8\\u6709\\u7591\\u95ee\\uff0c\\u8bf7\\u91cd\\u65b0\\u53d1\\u8868\\u5de5\\u5355\\u54a8\\u8be2!\"},\"recovery\":{\"title\":\"\\u5de5\\u5355\\u72b6\\u6001\\u91cd\\u7f6e\\u56de\\u590d\",\"content\":\"\\u56e0\\u4e1a\\u52a1\\u9700\\u8981\\uff0c\\u5ba2\\u670d\\u5df2\\u5c06\\u672c\\u5de5\\u5355\\u72b6\\u6001\\u91cd\\u7f6e\\u3002\"}}','cs_text'),(33,'tipsManual','首次按照提醒指引','0','system'),(34,'ticketModel','工单模型提醒','0','system'),(35,'dingtalk','钉钉接口','','system'),(36,'rowlock','开启行锁','0','system'),(37,'notice_login','登录参数','','system'),(39,'wxapp_api','微信接口','{\"appID\":\"\",\"appsecret\":\"\"}','system'),(40,'register_form','注册填写选项','{\"email\":\"email\",\"account\":\"account\",\"phone\":\"phone\"}','system'),(41,'ticket_contact','全局工单联系方式','[{\"title\":\"\\u7535\\u5b50\\u90ae\\u4ef6\",\"key\":\"1\",\"field\":\"member_email\"},{\"title\":\"\\u624b\\u673a\\u53f7\\u7801\",\"key\":\"2\",\"field\":\"member_phone\"},{\"title\":\"\\u5fae\\u4fe1\",\"key\":\"3\",\"field\":\"member_weixin\"},{\"title\":\"\\u4f01\\u4e1a\\u5fae\\u4fe1\",\"key\":\"4\",\"field\":\"member_wxWork\"},{\"title\":\"\\u9489\\u9489\",\"key\":\"5\",\"field\":\"member_dingtalk\"},{\"title\":\"\\u5fae\\u4fe1\\u5c0f\\u7a0b\\u5e8f\",\"key\":\"6\",\"field\":\"member_wxapp\"}]',''),(42,'openapi','是否开启api接口','0','system'),(43,'ticket_read','是否开启工单已读标识','0','system'),(44,'disturb','勿扰时段','','system'),(45,'help_document','帮助文档提示','0','system');
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
-- Table structure for table `pes_qrcode`
--

DROP TABLE IF EXISTS `pes_qrcode`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pes_qrcode` (
  `qrcode_id` int(11) NOT NULL AUTO_INCREMENT,
  `qrcode_key` varchar(128) NOT NULL COMMENT '二维码key值',
  `qrcode_value` varchar(64) NOT NULL COMMENT '二维码内容值',
  `qrcode_status` int(1) NOT NULL COMMENT '二维码使用状态 1:已使用',
  `qrcode_createtime` int(11) NOT NULL COMMENT '二维码生成时间',
  PRIMARY KEY (`qrcode_id`),
  KEY `qrcode_value` (`qrcode_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='二维码状态表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pes_qrcode`
--

LOCK TABLES `pes_qrcode` WRITE;
/*!40000 ALTER TABLE `pes_qrcode` DISABLE KEYS */;
/*!40000 ALTER TABLE `pes_qrcode` ENABLE KEYS */;
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
  `send_status` int(11) NOT NULL,
  `send_sequence` int(11) NOT NULL,
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
  `old_user_id` int(11) NOT NULL COMMENT '上一任的负责人ID',
  `member_id` int(11) NOT NULL DEFAULT '-1' COMMENT '站内会员ID . -1表示匿名提交',
  `user_name` varchar(128) NOT NULL DEFAULT '' COMMENT '工单操作者名字',
  `ticket_contact` tinyint(4) NOT NULL DEFAULT '0' COMMENT '联系方式 1:邮箱 2:手机号码',
  `ticket_contact_account` varchar(128) NOT NULL DEFAULT '' COMMENT '联系账号',
  `ticket_close` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:正常 1:关闭',
  `ticket_close_time` int(11) NOT NULL COMMENT '工单关闭时间',
  `ticket_close_reason` varchar(255) NOT NULL COMMENT '工单关闭理由',
  `ticket_score` decimal(10,2) NOT NULL COMMENT '本次工单评分',
  `ticket_score_time` int(11) NOT NULL COMMENT '评分时间',
  `ticket_fix` tinyint(1) NOT NULL COMMENT '工单是否解决',
  `ticket_comment` varchar(1000) NOT NULL DEFAULT '' COMMENT '评价留言',
  `ticket_time_out_sequence` int(11) NOT NULL DEFAULT '0' COMMENT '已通知超时次数',
  `ticket_remark` varchar(64) NOT NULL DEFAULT '' COMMENT '工单备注说明',
  `ticket_exclusive` tinyint(1) NOT NULL COMMENT '专属工单标记',
  `ticket_top` tinyint(1) NOT NULL COMMENT '个人置顶工单',
  `ticket_top_list` tinyint(1) NOT NULL COMMENT '列表置顶工单',
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
  `ticket_chat_read` tinyint(1) NOT NULL COMMENT '工单沟通内容是否已读',
  `ticket_chat_delete` int(11) NOT NULL COMMENT '是否被删除 0 正常 1被删除',
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
  `ticket_form_option_name` varchar(255) NOT NULL COMMENT '工单字段记录的选项名称',
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
  `ticket_form_default` text NOT NULL COMMENT '工单表单默认值',
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
  `ticket_model_title_description` varchar(255) NOT NULL DEFAULT '',
  `ticket_model_auto_logic` tinyint(1) NOT NULL,
  `ticket_model_auto` tinyint(1) NOT NULL,
  `ticket_model_close_type` varchar(16) NOT NULL,
  `ticket_model_custom_no` varchar(255) NOT NULL,
  `ticket_model_fqa_tips` tinyint(1) NOT NULL COMMENT 'FQA指引',
  `ticket_model_recovery_day` int(11) NOT NULL DEFAULT '7' COMMENT '工单模型恢复期限',
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
  `send_account` varchar(255) NOT NULL DEFAULT '' COMMENT '接收账号',
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
-- Table structure for table `pes_ticket_status_line`
--

DROP TABLE IF EXISTS `pes_ticket_status_line`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pes_ticket_status_line` (
  `status_line_id` int(11) NOT NULL AUTO_INCREMENT,
  `ticket_id` int(11) NOT NULL,
  `ticket_status` int(11) NOT NULL COMMENT '工单状态',
  `member_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `display_name` varchar(255) NOT NULL COMMENT '显示名称',
  `status_line_time` int(11) NOT NULL COMMENT '生成时的时间',
  PRIMARY KEY (`status_line_id`),
  KEY `ticket_id` (`ticket_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='工单状态线';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pes_ticket_status_line`
--

LOCK TABLES `pes_ticket_status_line` WRITE;
/*!40000 ALTER TABLE `pes_ticket_status_line` DISABLE KEYS */;
/*!40000 ALTER TABLE `pes_ticket_status_line` ENABLE KEYS */;
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
  `user_dingtalk` varchar(255) DEFAULT NULL,
  `user_score` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '总体评分',
  `user_score_frequency` int(11) NOT NULL DEFAULT '0' COMMENT '评分次数',
  `user_job_number` varchar(255) DEFAULT '' COMMENT '工号',
  `user_vacation` tinyint(1) NOT NULL COMMENT '是否休假中',
  `user_browser_msg` int(11) NOT NULL COMMENT '是否启用浏览器通知',
  `user_browser_msg_time` int(11) NOT NULL DEFAULT '1' COMMENT '默认浏览器通知间隔 1分钟',
  `user_suspension_button` tinyint(1) NOT NULL COMMENT '是否关闭悬浮按钮',
  `user_ticket_status` varchar(10) NOT NULL DEFAULT '' COMMENT '客服设置列表默认打开的工单筛选状态',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_weixinWork` (`user_weixinWork`),
  UNIQUE KEY `user_dingtalk` (`user_dingtalk`)
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

-- Dump completed on 2022-12-01 23:12:47
