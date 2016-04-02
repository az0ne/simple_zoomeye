<?php

/**
 * $Author: pengwenfei p@simple-log.com
 * $Date: 2010-07-30
 * www.simple-log.com 
*/

define('IN_PBBLOG',true);
define('IN_PBADMIN',true);

if (file_exists('../home/data/config.php'))
{
	require_once('../home/data/config.php');
}
else
{
	define('PBBLOG_WS_ADMIN', 'admin');
}

define('ROOT', str_replace(PBBLOG_WS_ADMIN,'',str_replace("\\", '/', dirname(__FILE__))));

require(ROOT.'/includes/core.php');

require(PBBLOG_ROOT.'/includes/admin.function.php');

$safe_act=array(
'pre_login','login','logout','index','get_version','header','menu','footer','default',
'cat_list','del_cat','add_cat','act_add_cat','edit_cat','act_edit_cat',
'blog_list','del_blog','add_blog','act_add_blog','edit_blog','act_edit_blog','upload',
'comment_list','del_comment','add_comment','act_add_comment','edit_comment','act_edit_comment',
'member_list','del_member','add_member','act_add_member','edit_member','act_edit_member',
'group_list','del_group','add_group','act_add_group','edit_group','act_edit_group',
'sidebar_setup_list','del_sidebar','sidebar_list','add_sidebar','act_setup_sidebar','act_edit_sort','setup_sidebar','edit_sidebar','act_edit_sidebar',
'set_footer','act_set_page','get_page_data','ajax_post_page_data','del_sql_file',
'page_list','del_page','add_page','act_add_page','edit_page','act_edit_page',
'nav_list','add_nav','act_add_nav','edit_nav','act_edit_nav','act_edit_nav_sort','del_nav',
'setting','act_setting','templates_list','select_template','clear_cache','databak','act_backup','re_data','act_re_data',
'friend_link_list','act_edit_friend_link_sort','edit_friend_link','act_edit_friend_link','add_friend_link','act_add_friend_link','del_friend_link',
'plugins_list','plugins_setup_list','setup_plugin','del_plugin','plugin_cp',
'tags_list','del_tag','attachments_list','del_attachment','auto_save','get_auto_save','check_auto_date'
);
$action=$_GET['act'];
if (!in_array($action,$safe_act))
{
	die('Acess Denied');
}

//对页面初始化
admin_here($action);

//检查用户权限
if ($action!='pre_login'&&$action!='login'&&$action!='logout'&&$action!='clear_cache'&&$action!='get_version')
{
	check_privilege($action);
}

if ($action=='pre_login'||$action=='login'||$action=='logout')
{
	require(PBBLOG_ROOT.'/'.PBBLOG_WS_ADMIN.'/includes/login.php');
	exit;
}

elseif ($action=='index'||$action=='get_version'||$action=='header'||$action=='menu'||$action=='footer'||$action=='default')
{
	require(PBBLOG_ROOT.'/'.PBBLOG_WS_ADMIN.'/includes/index.php');
}

elseif ($action=='add_blog'||$action=='act_add_blog'||$action=='blog_list'||$action=='edit_blog'||$action=='act_edit_blog'||$action=='del_blog')
{
	require(PBBLOG_ROOT.'/'.PBBLOG_WS_ADMIN.'/includes/blog.php');
}

elseif ($action=='add_cat'||$action=='act_add_cat'||$action=='cat_list'||$action=='edit_cat'||$action=='act_edit_cat'||$action=='del_cat')
{
	require(PBBLOG_ROOT.'/'.PBBLOG_WS_ADMIN.'/includes/cat.php');
}

elseif ($action=='add_member'||$action=='act_add_member'||$action=='member_list'||$action=='edit_member'||$action=='act_edit_member'||$action=='del_member')
{
	require(PBBLOG_ROOT.'/'.PBBLOG_WS_ADMIN.'/includes/member.php');
}

elseif ($action=='add_group'||$action=='act_add_group'||$action=='group_list'||$action=='edit_group'||$action=='act_edit_group'||$action=='del_group')
{
	require(PBBLOG_ROOT.'/'.PBBLOG_WS_ADMIN.'/includes/group.php');
}

elseif ($action=='setting'||$action=='act_setting')
{
	require(PBBLOG_ROOT.'/'.PBBLOG_WS_ADMIN.'/includes/setting.php');
}

elseif ($action=='templates_list'||$action=='select_template')
{
	require(PBBLOG_ROOT.'/'.PBBLOG_WS_ADMIN.'/includes/template.php');
}

elseif ($action=='add_comment'||$action=='act_add_comment'||$action=='comment_list'||$action=='edit_comment'||$action=='act_edit_comment'||$action=='del_comment')
{
	require(PBBLOG_ROOT.'/'.PBBLOG_WS_ADMIN.'/includes/comment.php');
}

//边栏模块
elseif ($action=='sidebar_setup_list'||$action=='edit_sidebar'||$action=='act_edit_sidebar'||$action=='sidebar_list'||$action=='del_sidebar'||$action=='act_edit_sort'||$action=='del_sidebar'||$action=='setup_sidebar'||$action=='act_setup_sidebar'||$action=='add_sidebar')
{
	require(PBBLOG_ROOT.'/'.PBBLOG_WS_ADMIN.'/includes/sidebar_module.php');
}

//导航模块
elseif ($action=='nav_list'||$action=='add_nav'||$action=='act_add_nav'||$action=='edit_nav'||$action=='act_edit_nav'||$action=='act_edit_nav_sort'||$action=='del_nav')
{
	require(PBBLOG_ROOT.'/'.PBBLOG_WS_ADMIN.'/includes/nav_module.php');
}

//修改页面
elseif ($action=='set_footer'||$action=='act_set_page'||$action=='get_page_data'||$action=='ajax_post_page_data')
{
	require(PBBLOG_ROOT.'/'.PBBLOG_WS_ADMIN.'/includes/set_page.php');
}

//页面创建
elseif ($action=='page_list'||$action=='add_page'||$action=='act_add_page'||$action=='edit_page'||$action=='act_edit_page'||$action=='del_page')
{
	require(PBBLOG_ROOT.'/'.PBBLOG_WS_ADMIN.'/includes/page.php');
}

//数据备份
elseif ($action=='databak'||$action=='act_backup'||$action=='re_data'||$action=='act_re_data'||$action=='del_sql_file')
{
	require(PBBLOG_ROOT.'/'.PBBLOG_WS_ADMIN.'/includes/database.php');
}

//友情链接
elseif ($action=='friend_link_list'||$action=='act_edit_friend_link_sort'||$action=='edit_friend_link'||$action=='act_edit_friend_link'||$action=='add_friend_link'||$action=='act_add_friend_link'||$action=='del_friend_link')
{
	require(PBBLOG_ROOT.'/'.PBBLOG_WS_ADMIN.'/includes/friendlink.php');
}

//调用后台插件
elseif ($action=='plugins_list'||$action=='plugins_setup_list'||$action=='setup_plugin'||$action=='del_plugin'||$action=='plugin_cp')
{
	require(PBBLOG_ROOT.'/'.PBBLOG_WS_ADMIN.'/includes/plugins.php');
}

//其他管理
elseif ($action=='attachments_list'||$action=='tags_list'||$action=='del_tag'||$action=='del_attachment'||$action=='auto_save'||$action=='get_auto_save'||$action=='check_auto_date')
{
	require(PBBLOG_ROOT.'/'.PBBLOG_WS_ADMIN.'/includes/other.php');
}

elseif ($action=='clear_cache'){
	$smarty->cache_dir      = PBBLOG_ROOT . 'home/cache';
	$smarty->compile_dir=PBBLOG_ROOT.'/home/compiled';
	$smarty->clear_all_cache();
	$smarty->clear_compiled_tpl();
	$smarty->compile_dir=PBBLOG_ROOT.'/home/admin_compiled';
	$smarty->clear_compiled_tpl();
	sys_message('清除缓存成功','admin.php?act=default');
}

elseif ($action=='upload')
{
	require(ROOT.'/includes/upload.html5.class.php');
	$file=new cls_upload();

	$file_name=$file->upload($_FILES['filedata'],$_GET['type']);
	$file_url='';
	if ($file->error()=='')
	{
		$sql="INSERT INTO  ".table('attachments')." (`attachment_id` ,`file_name` ,`type`,`add_time`)VALUES (NULL ,  '$file_name',  '".$_GET['type']."',  '".time()."' )";
		$db->query($sql);
		$u=str_replace(PBBLOG_WS_ADMIN, '', dirname($url));
		if ($_GET['type']=='img')
		{
			$file_url=$u.$file_name;
		}
		else 
		{
			$file_url=$u.'attachment.php?fid='.$db->insert_id();
		}
		
	}

	header('Content-Type: text/html; charset=UTF-8');
	$str='{"err":"'.$file->error().'","msg":"'.$file_url.'"}';
	exit($str);
}

?>