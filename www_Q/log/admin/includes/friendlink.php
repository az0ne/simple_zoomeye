<?php

/**
 * 友情链接
 * $Author: pengwenfei p@simple-log.com
 * $Date: 2010-08-04
 * www.simple-log.com 
*/

//友情链接列表
if ($action=='friend_link_list')
{
	$pg=isset($_GET['pg'])?intval($_GET['pg']):1;
	$page_size=!empty($page_size)?$page_size:'15';
	$sql='SELECT count(*) FROM '.table('link').' WHERE 1';
	$page_count=intval(($db->getone($sql)-1)/$page_size)+1;
	$page_arr=create_page($page_count,$pg,0);

	$start=($pg-1)*$page_size;
	$sql='SELECT * FROM '.table('link').' WHERE 1 '.
	" ORDER BY sort ASC LIMIT ".$start.' , '.$page_size;
	$friend_link_list=$db->getall($sql);

	$smarty->assign('friend_link_list',$friend_link_list);
	$smarty->assign('page_arr',$page_arr);
	$smarty->assign('page_count',$page_count);
	$smarty->assign('pg',$pg);
	$smarty->assign('url','admin.php?act=friend_link_list&pg=');

	$smarty->assign('type','act_edit_friend_link_sort');
	$smarty->display('friend_link_list.html');
}

//修改友情链接的顺序
elseif ($action=='act_edit_friend_link_sort')
{

	$sort=$_POST['sort'];

	foreach ($sort as $key=>$val)
	{
		$sql='UPDATE '.table('link')."  SET `sort` =$val[0] "." WHERE link_id='".$key."'";
		$db->query($sql);
	}

	sys_message('修改成功',$referer_url);

}

//编辑友情链接
elseif ($action=='edit_friend_link')
{

	$id=$_GET['id'];

	$sql='SELECT * FROM '.table('link')." WHERE link_id= '".$id."'";
	$module=$db->getrow($sql);
	$smarty->assign('module',$module);
	$smarty->assign('type','act_edit_friend_link');
	$smarty->assign('setup_type',2);
	$smarty->assign('sort',$module['sort']);
	$smarty->assign('id',$id);
	$smarty->display('add_friend_link.html');
}

//编辑友情链接到数据库
elseif ($action=='act_edit_friend_link')
{
	$module_title=$_POST['module_title'];
	$module_content=$_POST['module_content'];
	$module_id=$_POST['id'];
	$sort=isset($_POST['sort'])?intval($_POST['sort']):1;


	if (empty($module_title))
	{
		sys_message('请填写友情链接名称',$referer_url);
	}

	if (empty($module_content))
	{
		sys_message('请填写友情链接URL',$referer_url);
	}
	$desc=htmlspecialchars($_POST['module_desc']);


	$sql='UPDATE '.table('link').
	"  SET  `title` =  '$module_title',`url` =  '$module_content',`desc` =  '$desc',`sort` =  '$sort'".
	" WHERE  `link_id` ='".$module_id."'";

	if ($db->query($sql))
	{

		sys_message('编辑友情链接成功','admin.php?act=friend_link_list');
	}
	else
	{
		sys_message('编辑友情链接失败，请重新返回添加',$referer_url);
	}
}




//安装友情链接页面
elseif ($action=='add_friend_link')
{
	$smarty->assign('setup_type',1);
	$smarty->assign('type','act_add_friend_link');
	$smarty->assign('sort',1);
	$smarty->display('add_friend_link.html');
}


//安装友情链接
elseif ($action=='act_add_friend_link')
{
	$module_title=$_POST['module_title'];
	$module_content=$_POST['module_content'];
	$sort=isset($_POST['sort'])?intval($_POST['sort']):1;


	if (empty($module_title))
	{
		sys_message('请填写友情链接名称',$referer_url);
	}

	if (empty($module_content))
	{
		sys_message('请填写友情链接URL',$referer_url);
	}

	$desc=htmlspecialchars($_POST['module_desc']);

	$sql='INSERT INTO '.table('link').
	" (`link_id` ,`title` ,`desc` ,`url` ,`sort`  )
		VALUES (NULL , '".$module_title."', '".$desc."', '".$module_content."', '".$sort."')";
	if ($db->query($sql))
	{

		sys_message('添加友情链接成功','admin.php?act=friend_link_list');
	}
	else
	{
		sys_message('添加失败，请重新返回添加',$referer_url);
	}
}

//删除安装友情链接
elseif ($action=='del_friend_link')
{
	$module_id=$_GET['id'];
	$sql='DELETE FROM '.table('link')." WHERE link_id='".$module_id."'";
	if ($db->query($sql))
	{

		sys_message('删除成功',$referer_url);
	}
	else
	{
		sys_message('删除失败，请重新删除',$referer_url);
	}
}


?>