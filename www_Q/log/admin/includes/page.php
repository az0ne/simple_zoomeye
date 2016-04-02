<?php

/**
 * $Author: pengwenfei p@simple-log.com
 * $Date: 2010-08-07
 * www.simple-log.com 
*/

if ($action=='page_list')
{
	$pg=isset($_GET['pg'])?intval($_GET['pg']):1;
	$page_size=!empty($config['page_size'])?$config['page_size']:'15';
	$sql='SELECT count(*) FROM '.table('page').' WHERE type=0';
	$page_count=intval(($db->getone($sql)-1)/$page_size)+1;
	$page_arr=create_page($page_count,$pg,0);

	$start=($pg-1)*$page_size;


	$sql='SELECT b.*, u.user_name FROM '.table('page').
	' AS  b LEFT JOIN '.table('user').' AS u on b.user_id=u.user_id'.
	"  WHERE b.type=0 ORDER BY b.page_id DESC LIMIT ".$start.' , '.$page_size;
	$pages_list=$db->getall($sql);
	foreach ($pages_list as $key=>$val)
	{
		$pages_list[$key]['add_time']=pbtime($val['add_time']);
	}

	$smarty->assign('pages_list',$pages_list);
	$smarty->assign('page_arr',$page_arr);
	$smarty->assign('page_count',$page_count);
	$smarty->assign('pg',$pg);
	$smarty->assign('url','admin.php?act=page_list&pg=');
	$smarty->display('page_list.html');
}


elseif ($action=='del_page')
{
	$id=intval($_GET['id']);
	$sql='DELETE FROM '.table('page')." WHERE page_id='".$id."'";
	if ($db->query($sql))
	{
		$db->query($sql);
		sys_message('删除页面成功',$referer_url);
	}
	else
	{
		sys_message('删除页面失败，请重新删除',$referer_url);
	}
}

elseif ($action=='add_page')
{
	$smarty->assign('type','act_add_page');
	$smarty->assign('rewrite',$GLOBALS['config']['rewrite']);
	$smarty->assign('url_type',1);
	$smarty->assign('u',str_replace(PBBLOG_WS_ADMIN, '', dirname($url)));
	$smarty->display('add_page.html');
}

elseif ($action=='act_add_page')
{
	require_once(PBBLOG_ROOT.'/includes/base.function.php');

	$user_id=intval($_SESSION['user_id']);
	//$url_type=intval($_POST['url_type']);
	$page_title=$_POST['title'];
	if (empty($page_title))
	{
		sys_message('页面标题不能为空',$referer_url);
	}

	$desc=htmlspecialchars($_POST['description']);
	$content=htmlspecialchars($_POST['editor']);


	$sql="INSERT INTO ".table('page')." (`page_id` ,`relate_id` ,`user_id` ,`title`,`desc`,`content` ,`add_time` ,`ip` ,`status`,`type` )".
	"VALUES (NULL , '', '$user_id', '".$page_title."', '".$desc."', '".$content."','$time', '$ip', '0','0' ) ";
	
	if ($db->query($sql))
	{
		$page_id=$db->insert_id();
		sys_message('创建页面成功','admin.php?act=add_page');
	}
	else
	{
		sys_message('创建页面失败，请重新返回添加','admin.php?act=add_page');
	}
}

elseif ($action=='edit_page')
{
	$page_id=intval($_GET['id']);
	if (empty($page_id))
	{
		sys_message('页面id不能为空',$referer_url);
	}
	$sql='SELECT * FROM '.table('page')." WHERE page_id='".$page_id."'";

	if ($row=$db->getrow($sql))
	{
		//$row['description']=unprocess_text($row['description']);
		$smarty->assign('page',$row);
	}
	else
	{
		sys_message('读取页面数据失败，请返回重新修改',$referer_url);
	}

	$smarty->assign('type','act_edit_page&id='.$page_id);
	$smarty->assign('id',$page_id);
	$smarty->display('add_page.html');
}

elseif ($action=='act_edit_page')
{
	require_once(PBBLOG_ROOT.'/includes/base.function.php');
	$page_id=intval($_GET['id']);

	if (empty($page_id))
	{
		sys_message('页面id不能为空',$referer_url);
	}

	$page_title=$_POST['title'];
	if (empty($page_title))
	{
		sys_message('页面标题不能为空',$referer_url);
	}


	$desc=htmlspecialchars($_POST['description']);
	$content=htmlspecialchars($_POST['editor']);


	$sql='UPDATE '.table('page').
	"  SET `title` = '".$page_title."',`desc` = '".$desc."',`content` = '".$content.
	"' , `add_time`='".$time.
	"' WHERE page_id='".$page_id."'";
	

	if ($db->query($sql))
	{
		sys_message('修改页面成功','admin.php?act=edit_page&id='.$page_id);
	}
	else
	{
		sys_message('修改页面失败，请重新返回添加','admin.php?act=edit_page&id='.$page_id);
	}
}

?>