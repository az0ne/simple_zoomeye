<?php

/**
 * NAV模块
 * $Author: pengwenfei p@simple-log.com
 * $Date: 2010-07-21
 * www.simple-log.com 
*/

//已安装NAV模块
if ($action=='nav_list')
{
	$pg=isset($_GET['pg'])?intval($_GET['pg']):1;
	$page_size=!empty($page_size)?$page_size:'15';
	//type 2表示nav
	$sql='SELECT count(*) FROM '.table('modules').' WHERE type=2';
	$page_count=intval(($db->getone($sql)-1)/$page_size)+1;
	$page_arr=create_page($page_count,$pg,0);

	$start=($pg-1)*$page_size;
	$sql='SELECT * FROM '.table('modules').' WHERE type=2 '.
	" ORDER BY sort ASC LIMIT ".$start.' , '.$page_size;
	$nav_list=$db->getall($sql);

	$smarty->assign('nav_list',$nav_list);
	$smarty->assign('page_arr',$page_arr);
	$smarty->assign('page_count',$page_count);
	$smarty->assign('pg',$pg);
	$smarty->assign('url','admin.php?act=nav_list&pg=');

	$smarty->assign('type','act_edit_sort');
	$smarty->display('nav_list.html');
}

//修改已安装nav的顺序
elseif ($action=='act_edit_nav_sort')
{

	$sort=$_POST['sort'];

	foreach ($sort as $key=>$val)
	{
		$sql='UPDATE '.table('modules')."  SET `sort` =$val[0] "." WHERE id='".$key."'";
		$db->query($sql);
	}
	
	sys_message('修改成功',$referer_url);

}

//编辑导航
elseif ($action=='edit_nav')
{

	$id=$_GET['id'];

	$sql='SELECT * FROM '.table('modules')." WHERE id= '".$id."'";
	$module=$db->getrow($sql);
	$smarty->assign('module',$module);
	$smarty->assign('type','act_edit_nav');
	$smarty->assign('setup_type',2);
	$smarty->assign('sort',$module['sort']);
	$smarty->assign('id',$id);
	$smarty->display('add_nav.html');
}

//编辑网站导航到数据库
elseif ($action=='act_edit_nav')
{
	require_once(PBBLOG_ROOT.'/includes/base.function.php');

	$module_title=$_POST['module_title'];
	$module_content=$_POST['module_content'];
	$module_id=$_POST['id'];
	$sort=isset($_POST['sort'])?intval($_POST['sort']):1;


	if (empty($module_title))
	{
		sys_message('请填写NAV标题',$referer_url);
	}

	if (empty($module_content))
	{
		sys_message('请填写URL',$referer_url);
	}

	$desc=htmlspecialchars($_POST['module_desc']);
	$content=htmlspecialchars($module_content);


	$sql='UPDATE '.table('modules').
	"  SET  `title` =  '$module_title',`desc` =  '$desc',`content` =  '$module_content',`sort` =  '$sort'".
	" WHERE  `id` ='".$module_id."'";
	if ($db->query($sql))
	{
		
		sys_message('编辑NAV成功','admin.php?act=nav_list');
	}
	else
	{
		sys_message('编辑NAV失败，请重新返回添加',$referer_url);
	}
}




//安装NAV页面
elseif ($action=='add_nav')
{
	$smarty->assign('setup_type',1);
	$smarty->assign('type','act_add_nav');
	$smarty->assign('sort',1);
	$smarty->display('add_nav.html');
}


//安装NAV
elseif ($action=='act_add_nav')
{
	$module_title=$_POST['module_title'];
	$module_content=$_POST['module_content'];
	$module_id=$_POST['id'];
	$sort=isset($_POST['sort'])?intval($_POST['sort']):1;


	if (empty($module_title))
	{
		sys_message('请填写NAV标题',$referer_url);
	}

	if (empty($module_content))
	{
		sys_message('请填写URL',$referer_url);
	}

	$desc=htmlspecialchars($_POST['module_desc']);

	$sql='INSERT INTO '.table('modules').
	" (`id` ,`module_id` ,`title` ,`desc` ,`content` ,`sort` ,`type` )
		VALUES (NULL , '".$module_id."', '".$module_title."', '".$desc."', '".$module_content."', '".$sort."', 2)";
	if ($db->query($sql))
	{
		
		sys_message('添加网站导航链接成功','admin.php?act=nav_list');
	}
	else
	{
		sys_message('添加失败，请重新返回添加',$referer_url);
	}
}

//删除安装NAV
elseif ($action=='del_nav')
{
	$module_id=$_GET['id'];
	$sql='DELETE FROM '.table('modules')." WHERE id='".$module_id."'";
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