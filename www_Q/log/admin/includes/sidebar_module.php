<?php

/**
 * 边栏模块
 * $Author: pengwenfei p@simple-log.com
 * $Date: 2010-07-21
 * www.simple-log.com 
*/

//已安装边栏模块
if ($action=='sidebar_list')
{
	$sql='SELECT * FROM '.table('modules').' WHERE type=1 '.
	" ORDER BY sort ASC ";
	$sidebar_list=$db->getall($sql);

	$smarty->assign('sidebar_list',$sidebar_list);

	$smarty->assign('type','act_edit_sort');
	$smarty->display('sidebar_list.html');
}

//修改已安装边栏插件的顺序
elseif ($action=='act_edit_sort')
{

	$sort=$_POST['sort'];

	foreach ($sort as $key=>$val)
	{
		$sql='UPDATE '.table('modules')."  SET `sort` =$val[0] "." WHERE id='".$key."'";
		$db->query($sql);
	}
	make_sidebar();
	sys_message('修改成功',$referer_url);

}

//编辑已安装边栏插件
elseif ($action=='edit_sidebar')
{

	$id=$_GET['id'];

	$sql='SELECT * FROM '.table('modules')." WHERE id= '".$id."'";
	$module=$db->getrow($sql);

	$smarty->assign('module',$module);
	$smarty->assign('type','act_edit_sidebar');
	$smarty->assign('setup_type',2);
	$smarty->assign('sort',$module['sort']);
	$smarty->assign('id',$module['id']);
	$smarty->display('setup_sidebar.html');

}

//编辑边栏插件到数据库
elseif ($action=='act_edit_sidebar')
{
	require_once(PBBLOG_ROOT.'/includes/base.function.php');
	
	$module_title=$_POST['module_title'];
	$module_content=$_POST['module_content'];
	$module_id=$_POST['id'];
	$sort=isset($_POST['sort'])?intval($_POST['sort']):1;


	if (empty($module_title))
	{
		sys_message('请填写边栏标题',$referer_url);
	}

	if (empty($module_content))
	{
		sys_message('请填写边栏内容',$referer_url);
	}

	$desc=htmlspecialchars($_POST['module_desc']);
	$content=htmlspecialchars($module_content);


	$sql='UPDATE '.table('modules').
	"  SET  `title` =  '$module_title',`desc` =  '".$desc."',`content` =  '".$module_content."',`sort` =  '$sort'".
	" WHERE  `id` ='".$module_id."'";
	if ($db->query($sql))
	{
		make_sidebar();
		sys_message('编辑插件成功','admin.php?act=sidebar_list');
	}
	else
	{
		sys_message('编辑插件失败，请重新返回添加',$referer_url);
	}
}


//尚未安装插件
elseif ($action=='sidebar_setup_list')
{

	/* 获得可安装的边栏模块 */
	$modules = array();
	$sidebar_dir        = @opendir(PBBLOG_ROOT . '/includes/modules/sidebar/');
	while ($file = readdir($sidebar_dir))
	{
		if ($file != '.' && $file != '..' && file_exists(PBBLOG_ROOT. '/includes/modules/sidebar/' . $file))
		{
			include_once(PBBLOG_ROOT. '/includes/modules/sidebar/' . $file);

			//如果边栏模块已经安装或者不是边栏模块
			if ($type!=1||is_sidebar($id))
			{
				unset($modules[$id]);
			}
			else
			{
				$modules[$id]['file']=$file;
			}
			unset($type);
			unset($id);
		}
	}
	@closedir($sidebar_dir);

	$smarty->assign('modules',$modules);
	$smarty->display('sidebar_setup_list.html');
}

//安装边栏插件页面
elseif ($action=='setup_sidebar')
{

	$file=$_GET['id'];
	/* 获得可安装的边栏模块 */
	$modules = array();
	include_once(PBBLOG_ROOT. '/includes/modules/sidebar/' . $file);

	//如果边栏模块已经安装或者不是边栏模块
	if ($type!=1||is_sidebar($id))
	{
		sys_message('该插件已经安装',$referer_url);
	}
	$modules[$id]['desc']=htmlspecialchars($modules[$id]['desc']);
	$modules[$id]['content']=htmlspecialchars($modules[$id]['content']);


	$smarty->assign('module',$modules[$id]);
	$smarty->assign('type','act_setup_sidebar');
	$smarty->assign('setup_type',1);
	$smarty->assign('sort',1);
	$smarty->assign('id',$id);
	$smarty->display('setup_sidebar.html');
}


//安装插件
elseif ($action=='act_setup_sidebar')
{

	$module_title=$_POST['module_title'];
	$module_content=$_POST['module_content'];
	$module_id=$_POST['id'];
	$sort=isset($_POST['sort'])?intval($_POST['sort']):1;


	if (empty($module_title))
	{
		sys_message('请填写边栏标题',$referer_url);
	}

	if (empty($module_content))
	{
		sys_message('请填写边栏内容',$referer_url);
	}

	$desc=htmlspecialchars($_POST['module_desc']);
	$content=htmlspecialchars($module_content);

	$sql='INSERT INTO '.table('modules').
	" (`id` ,`module_id` ,`title` ,`desc` ,`content` ,`sort` ,`type` )
		VALUES (NULL , '".$module_id."', '".$module_title."', '".$desc."', '".$content."', '".$sort."', 1)";
	if ($db->query($sql))
	{
		make_sidebar();
		sys_message('安装插件成功','admin.php?act=sidebar_setup_list');
	}
	else
	{
		sys_message('安装插件失败，请重新返回添加',$referer_url);
	}
}

//删除安装插件
elseif ($action=='del_sidebar')
{
	$module_id=$_GET['id'];
	$sql='DELETE FROM '.table('modules')." WHERE id='".$module_id."'";
	if ($db->query($sql))
	{
		make_sidebar();
		sys_message('删除成功',$referer_url);
	}
	else
	{
		sys_message('删除失败，请重新删除',$referer_url);
	}
}


//添加边栏页面
elseif ($action=='add_sidebar')
{
	$smarty->assign('setup_type',1);
	$smarty->assign('type','act_setup_sidebar');
	$smarty->assign('sort',1);
	$smarty->display('setup_sidebar.html');
}



//检查边栏模块是否已经安装
function is_sidebar($id)
{
	$sql='SELECT * FROM '.table('modules')." WHERE module_id='".$id."'";
	if($GLOBALS['db']->getOne($sql))
	{
		return true;
	}
	else
	{
		return false;
	}
}

?>