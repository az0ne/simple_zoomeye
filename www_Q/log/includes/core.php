<?php

/**
 * $Author: pengwenfei p@simple-log.com
 * $Date: 2011-02-01
 * www.simple-log.com 
*/
/*核心公共文件*/

if (!defined('IN_PBBLOG')) {
	die('Access Denied');
}

error_reporting(E_ALL & ~E_NOTICE);

//获得系统运行开始时间
$mtime= explode(' ',microtime());
$start_time=$mtime[1]+$mtime[0];

define('PBBLOG_ROOT', str_replace('includes','',str_replace("\\", '/', dirname(__FILE__))));
//定义博客系统的根路径

//配置文件
if (file_exists(PBBLOG_ROOT.'/home/data/config.php')) 
{
	require_once(PBBLOG_ROOT.'/home/data/config.php');
}

require_once(PBBLOG_ROOT.'/includes/main.function.php');							//主要的函数文件
require_once(PBBLOG_ROOT.'/includes/base.function.php');							//一些基本的函数文件
require_once(PBBLOG_ROOT.'/includes/mysql.class.php');							    //数据库类文件
require_once(PBBLOG_ROOT.'/includes/Smarty/libs/Smarty.class.php');					//smarty模板

//如果系统没有安装，跳转到安装页面
if (!$install_lock)
{
	header('location: install/index.php');
}

//5.1以上的PHP版本设置时区，将默认时区设置成为东8区，也就是北京时间
if (version_compare(PHP_VERSION, 5.1, '>'))
{
	if (empty($timezone))
	{
		$timezone='Etc/GMT-8';
	}
	date_default_timezone_set($timezone);
}
$time=time();
$date=date('Y-m-d H:i:s',$time);

//关闭set_magic_quotes_runtime和设置错误输出信息
if (version_compare(PHP_VERSION, 5.3, '<'))
{
	set_magic_quotes_runtime(0);
	
}

// 对传入的变量过滤
if (!get_magic_quotes_gpc())
{
	$_GET  	  = empty($_GET)?'':input_filter($_GET);
	$_POST    = empty($_POST)?'':input_filter($_POST);
	$_COOKIE  = empty($_COOKIE)?'':input_filter($_COOKIE);
	$_FILES  = empty($_FILES)?'':input_filter($_FILES);
}


//开始获得客户端的参数
$ip=ip();
$referer_url=referer_url();
$url=url();

//初始化数据库
$db=new cls_mysql();
$db->connect($dbhost,$dbuser,$dbpw,$dbname,$charset,$pconnect);
unset($dbhost,$dbuser,$dbname,$charset,$pconnect);

//获取网站配置信息
$config=array();
$sql = 'SELECT * FROM ' . table('config');
$res = $db->getAll($sql);
foreach ($res AS $row)
{
	$config[$row['key']] = $row['value'];
}
$page_size=$config['page_size'];
unset($res);

//初始化模板
$smarty=new Smarty();
if (defined('IN_PBADMIN'))
{
	$smarty->template_dir=PBBLOG_ROOT.'/'.PBBLOG_WS_ADMIN.'/templates';
	$smarty->compile_dir=PBBLOG_ROOT.'/home/admin_compiled';
	$smarty->caching = false;
}
elseif (!defined('IN_PBADMIN'))
{
	$smarty->template_dir=PBBLOG_ROOT.'/themes/'.$config['template_name'];
	$smarty->compile_dir=PBBLOG_ROOT.'/home/compiled';
	
	//开启缓存
	if ($config['is_cache'])
	{
		$smarty->caching = true;
		$smarty->cache_lifetime = intval($config['cache_lifetime'])*3600; 	//缓存时间以小时为单位计算
	}
	
	$smarty->cache_dir      = PBBLOG_ROOT . 'home/cache';
}


//获得会话信息，并初始化会员信息
session_start();
if (empty($_SESSION['user_id']))
{
	$_SESSION=array();
	//游客登陆设置
	$_SESSION['user_id']=0;
	$_SESSION['group_id']=0;
}
else
{
	
	$user_id=$_SESSION['user_id'];
	$group_id=$_SESSION['group_id'];
}

?>