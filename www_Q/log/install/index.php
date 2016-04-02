

<?php

/**
 * 安装文件
 * $Author: pengwenfei p@simple-log.com
 * $Date: 2011-02-05
 * www.simple-log.com 
*/


define('IN_PBBLOG', true);
define('PBBLOG_ROOT', str_replace('install','',str_replace("\\", '/', dirname(__FILE__))));

//对安装目录尝试自动设置权限
@chmod(PBBLOG_ROOT.'/home/data/config.php',0777);
@chmod(PBBLOG_ROOT.'/admin/compiled/',0777);
@chmod(PBBLOG_ROOT.'/home/data/cache/',0777);
@chmod(PBBLOG_ROOT.'/home/data/compiled/',0777);
@chmod(PBBLOG_ROOT.'/home/data/upload/',0777);

error_reporting(E_ALL & ~E_NOTICE);

require(PBBLOG_ROOT.'/includes/main.function.php');							//主要的函数文件
require(PBBLOG_ROOT.'/includes/base.function.php');							//一些基本的函数文件
require(PBBLOG_ROOT.'/includes/mysql.class.php');							//数据库类文件

if (PHP_VERSION>5.1)
{
	if (empty($timezone))
	{
		$timezone='Etc/GMT-8';
	}
	date_default_timezone_set($timezone);
}

// 对传入的变量过滤
if (!get_magic_quotes_gpc())
{
	$_GET  	  = empty($_GET)?'':input_filter($_GET);
	$_POST    = empty($_POST)?'':input_filter($_POST);
	$_COOKIE  = empty($_COOKIE)?'':input_filter($_COOKIE);
}



$setup=!empty($_POST['setup'])?$_POST['setup']:'check';

if (file_exists(PBBLOG_ROOT.'home/data/config.php'))
{
	require_once(PBBLOG_ROOT.'home/data/config.php');
}

if ($install_lock&&$setup!='finish')
{
	header('location: ../index.php');
}

?>

<!DOCTYPE>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>安装Simple-log</title>
<!-- {literal} -->
<style>
@charset "utf-8";
body,h1,h2,h3,p,blockquote,dl,dt,dd,ul,ol,li,button,input,textarea {margin: 0; padding: 0;}
body {font:13px Tahoma, Helvetica, Arial, sans-serif;}
img {border: 0;}
a, a:link, a:visited {text-decoration: none;}
#container {width:80%; margin:auto auto;}
#header { clear:both;overflow:auto;padding-top: 25px; }
#header .logo {float: left;}
#header .logo a {font-size: 25px; height:35px;}

#nav {height:34px; line-height:34px;margin-top:20px;background: #999;border-bottom:1px solid #e6e6e6; border-top:1px solid #fff;}
#nav ul {list-style-type: none;}
#nav ul li {float: left;text-transform: uppercase;font-weight: normal;font-size: 12px; height:35px; overflow:hidden; font-family:'微软雅黑',Tahoma, Arial; }
#nav ul li a {color: #ececec;display:inline-block;padding: 0 12px; height:35px; line-height:33px; }


#content {width: 100%;float: right;padding-bottom: 20px;padding-top: 15px;}

#install {border-top:1px dashed #ccc; padding-top:15px;}
#install p{padding-top:5px;}
#install input{ height:27px;font-size: 16px;overflow:hidden; font-family:'微软雅黑',Tahoma, Arial;}
#install textarea{font-size: 16px;overflow:hidden; font-family:'微软雅黑',Tahoma, Arial;}
.line{font-weight: normal;font-size: 18px;overflow:hidden; font-family:'微软雅黑',Tahoma, Arial;padding-bottom:10px;border-bottom:1px dashed #ccc;}

#footer {clear: both;background: #999;color: #ececec;padding: 10px 15px; margin-bottom:15px;text-align: center;font-size:11px;}
#footer a {color: #ececec;}
#footer a:hover {color: #ccc;}
.clearfloat { font-size: 0; height: 0; width: 0; clear: both; overflow:hidden;}
</style>
<!-- {/literal} -->
<script src="includes/js/jquery.js"></script>
</head>
<body>
<div id="container">
  <div id="header">
  <div class="logo">
  <a href="./index.php">Simple-Log</a>
  </div>
  </div>  <!-- end #header -->

  <div id="nav">
<ul>
    <li {if $id eq 1}class="current"{/if}><a href="index.php?act=check">系统检测</a></li>
    <li {if $id eq 2}class="current"{/if}><a>参数配置</a></li>
    <li {if $id eq 3}class="current"{/if}><a>安装完成</a></li>
</ul>
</div>

<div id="content">

<?php
if ($setup=='check')
{
?>
<form action="index.php" method="post"  name="install" id="install">
<p class="line">服务器信息</p>
<p>服务器信息：<?=$_SERVER['SERVER_SOFTWARE']?></p>
<p>PHP版本：<?=PHP_VERSION?></p>
<br /><br />
	<p class="line">文件权限检测</p>
<?php
$file=array();
//检查目录权限
if (!check_write(PBBLOG_ROOT.'/home/data/config.php',2))
{
	$file[]='/home/data/config.php文件不可写，安装将无法继续进行';
	$set=1;
}

if (!check_write(PBBLOG_ROOT.'/home/admin_compiled/'))
{
	$file[]='/home/admin_compiled/目录不可写，程序将无法正常运行';;
	$set=1;
}

if (!check_write(PBBLOG_ROOT.'/home/compiled/'))
{
	$file[]='/home/compiled/目录不可写，程序将无法正常运行';
	$set=1;
}

if (!check_write(PBBLOG_ROOT.'/home/cache/'))
{
	$file[]='/home/cache/目录不可写，程序将无法正常运行';
	$set=1;
}

if (!check_write(PBBLOG_ROOT.'/home/upload/'))
{
	$file[]='/home/upload/目录不可写，此目录放置上传的文件，建议将其设置可写';
}
if (!check_write(PBBLOG_ROOT.'/home/backup/'))
{
	$file[]='/home/backup/目录不可写，此目录用于备份数据库，建议将其设置可写';;
}

if (!check_write(PBBLOG_ROOT.'/themes/',1,2))
{
	$file[]='/themes/目录及其所有子目录没有写权限，建议将其设置可写';
}
foreach ($file as $val)
{
	echo "<p>{$val}</p>";
}

if ($set==1)
{
	echo '<br /><p><input type="submit" name="button" id="button" value="下一步" disabled/></p>';
}
else
{
	echo '<p>文件权限设置正确</p><br /><p><input type="submit" name="button" id="button" value="下一步" /></p>';
}
echo '<input name="setup" type="hidden" value="config"></form>';

}

elseif ($setup=='config')
{
	?>
<form action="index.php" method="post"  name="install" id="install">

<p class="line">数据库配置</p>
 <p>数据库地址：(一般为localhost) <br />
  <input name="host" type="text" id="host" value="localhost"  />
   </p>
   <p>
 数据库名：<br />
    <input type="text" name="dbname" id="dbname" /> 
</p>
     <p>
 数据库用户名：<br />
    <input type="text" name="dbuser" id="dbuser" /> 
 </p>
   <p>
 数据库密码：<br />
    <input name="dbpass" type="text" id="dbpass" /> 
  </p>
    <p>
 数据库前缀（默认为fb_）：<br />
    <input name="dbprefix" type="text" id="dbprefix" /> 
  </p>
  
  <p class="line">博客信息配置</p>
  <p>
 管理员用户名：<br />
    <input name="admin_user" type="text" id="admin_user" />
  </p>
  <p>
 管理员密码：<br />
    <input name="admin_pass" type="text" id="admin_pass" />
  </p>
  <p>
 博客名字：<br />
    <input name="blogname" type="text" id="blogname" />
  </p>
    <p>
 博客简介：<br />
 <textarea name="blogdesc" cols="40" rows="5" id="blogdesc"></textarea>
  </p>

  <p>
    <input name="setup" type="hidden" value="finish"><input type="submit" name="button" id="button" value="开始安装" />
  </p>
</form>
	<?php
}

elseif ($setup=='finish')
{
	$error=array();
	if (empty($_POST['host']))
	{
		$error[]='请填写数据库地址';
	}
	if (empty($_POST['dbname']))
	{
		$error[]='请填写数据库';
	}
	if (empty($_POST['dbuser']))
	{
		$error[]='请填写数据库用户名';
	}
	if (empty($_POST['admin_user']))
	{
		$error[]='请填写管理员账号';
	}
	if (empty($_POST['admin_pass']))
	{
		$error[]='请填写管理员密码';
	}
	if (empty($_POST['blogname']))
	{
		$error[]='请填写博客名字';
	}

	if ($error)
	{

		echo '<p class="line">错误信息</p>';
		foreach ($error as $val)
		{
			echo "<p>$val</p>";
		}
		exit;
	}

	$dbhost=$_POST['host'];
	$dbuser=$_POST['dbuser'];
	$dbpw=$_POST['dbpass'];
	$dbname=$_POST['dbname'];
	$charset   = 'utf8';
	$db=new cls_mysql();
	if ($db->connect($dbhost,$dbuser,$dbpw,$dbname,$charset,$pconnect))
	{
		$error[]='数据库连接错误';
	}

	if (empty($_POST['dbprefix']))
	{
		$dbprefix='fb_';
	}
	else
	{
		$dbprefix=$_POST['dbprefix'];
	}

	$admin_user=$_POST['admin_user'];
	$admin_pass=$_POST['admin_pass'];
	$blogname=$_POST['blogname'];
	$blogdesc=$_POST['blogdesc'];
	$blog_keyword=$_POST['blogkeyword'];

	$domain=dirname(url());
	$domain=str_replace("install", '', $domain);
	$cookie_path='/';
	$session='1440';
	$hash_secret=substr(md5(time()),5,15);

	//写入配置文件
	$blog_config="<?php

/**
 * $Author: pengwenfei p@simple-log.com
 * $Date: 2011-02-04
 * www.simple-log.com 
*/ \n\n
define('PBBLOG_WS_INCLUDES', 'includes');\n
define('PBBLOG_WS_ADMIN', 'admin');
\n\n/*数据库信息*/ \n";
	$blog_config.='$dbhost   = \''.$dbhost."';\n//数据库主机地址\n";
	$blog_config.='$dbname   = \''.$dbname."';\n//数据库名字\n";
	$blog_config.='$dbuser   = \''.$dbuser."';\n//用户名\n";
	$blog_config.='$dbpw   = \''.$dbpw."';\n//数据库密码\n";
	$blog_config.='$dbprefix   = \''.$dbprefix."';\n//表前缀\n";
	$blog_config.='$pconnect   = \''.$pconnect."';\n//是否保持连接\n";

	$blog_config.="\n/*会话、cookie设置*/ \n";
	$blog_config.='$cookie_path   = \''.$cookie_path."';\n";
	$blog_config.='$cookie_domain   = \''.$cookie_domain."';\n";
	$blog_config.='$session   = \''.$session."';\n";

	$blog_config.="\n/*网站编码，暂时只支持utf8*/ \n";
	$blog_config.='$charset   = \''.$charset."';\n";

	$blog_config.="\n/*安全哈希密码*/ \n";
	$blog_config.='$hash_secret   = \''.$hash_secret."';\n//此处与全站的md5相关\n";

	$blog_config.="\$install_lock=true;  \n//博客是否已经安装\n";

	$blog_config.="\n?>";

	//将博客配置保存到文件中
	$fp=@fopen(PBBLOG_ROOT.'home/data/config.php',"w") or die('can not open file');
	flock($fp,LOCK_EX);
	fwrite($fp,$blog_config);
	fclose($fp);

	//导入数据库文件
	$sql=file_get_contents('simple-log.sql');

	$sql_list = explode(";\n\n", $sql);

	$sql_num=count($sql_list);

	for ($i=0;$i<$sql_num;$i++)
	{
		if (!empty($sql_list[$i]))
		{
			$sql_list[$i]=str_replace("fb_", $dbprefix, $sql_list[$i]);
			$db->query($sql_list[$i]);
		}
	}

	//将配置写入到数据库

	$sql='UPDATE '.table('config')."  SET `value`='".$blogname."' WHERE `key`='blog_name'";
	$db->query($sql);

	$sql='UPDATE '.table('config')."  SET `value`='".$blogdesc."' WHERE `key`='blog_desc'";
	$db->query($sql);

	$sql='UPDATE '.table('config')."  SET `value`='".$blog_keyword."' WHERE `key`='blog_keyword'";
	$db->query($sql);

	$sql='UPDATE '.table('config')."  SET `value`='".$domain."' WHERE `key`='domain'";
	$db->query($sql);

	$sql="INSERT INTO ".table('user')." (`user_id`,`user_name`,`password`,`email`,`group_id`,`reg_time`,`last_time`,`reg_ip`,`last_ip`,`visit_count`,`msn`,`qq`,`home` ) VALUES ( '1','".$admin_user."','".md5($admin_pass)."','p@simple-log.com','1','".$time."','".$time."','','','0','','','');
";
	$db->query($sql);

	?>
	<p class="line">安装成功</p>
<p>管理员用户名：<?=$admin_user?></p>
<p>管理员密码：<?=$admin_pass?></p>
<p><a href="../admin/">前往后台</a></p>
<p><a href="../index.php">前往前台</a></p>
	<?php
}

function check_write($path,$path_type=1,$check_type=1) {

	if ($path_type==1)
	{
		if (is_dir($path))
		{
			if ($check_type==1)
			{
				$testfile = $path.'/test.tmp';
			}
			else
			{
				check_write($path);
				$testfile = $path.'default'.'/test.tmp';
			}

			@chmod($testfile,0777);
			$fp = @fopen($testfile,'ab');
			@unlink($testfile);
			if ($fp===false)
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}

	elseif ($path_type==2)
	{
		@chmod($path,0777);
		$fp = @fopen($path,'ab');
		if ($fp===false)
		{
			return false;
		}
	}

	return true;

}

?>


</div>
<br class="clearfloat" />
<div id="footer">
<p>&copy;2009-2011 Powered by <a href="http://www.simple-log.com">Simple-Log</a> v1.3</p>
  <!-- end #footer --></div>
<!-- end #container --></div>
</body>
</html>