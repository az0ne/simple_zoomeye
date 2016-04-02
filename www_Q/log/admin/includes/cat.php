<?php

/**
 * $Author: pengwenfei p@simple-log.com
 * $Date: 2010-08-06
 * www.simple-log.com 
*/

if ($action=='cat_list')
{
	$pg=isset($_GET['pg'])?intval($_GET['pg']):1;
	$page_size=!empty($page_size)?$page_size:'15';
	$sql='SELECT count(*) FROM '.table('category');
	$page_count=intval(($db->getone($sql)-1)/$page_size)+1;
	$page_arr=create_page($page_count,$pg,0);

	$start=($pg-1)*$page_size;
	$sql='SELECT cat_id,cat_name,cat_desc,listorder FROM '.table('category').
	" WHERE parent_id=0 ORDER BY listorder ASC , cat_id ASC LIMIT ".$start.' , '.$page_size;
	$cat_list=$db->getall($sql);

	//获取子分类，暂时只支持二级分类
	foreach ($cat_list as $key=>$val)
	{
		$sql='SELECT cat_id,cat_name,cat_desc,listorder FROM '.table('category').
		" WHERE parent_id=".$val['cat_id']." ORDER BY listorder ASC , cat_id ASC LIMIT ".$start.' , '.$page_size;
		$cat_list[$key]['children']=$db->getall($sql);
	}

	$smarty->assign('cat_list',$cat_list);
	$smarty->assign('page_arr',$page_arr);
	$smarty->assign('page_count',$page_count);
	$smarty->assign('pg',$pg);
	$smarty->assign('url','admin.php?act=cat_list&pg=');

	$smarty->display('cat_list.html');
}


elseif ($action=='del_cat')
{
	$cat_id=intval($_GET['id']);
	$sql='SELECT count(*) FROM '.table('blog')." WHERE cat_id='".$cat_id."'";
	if ($db->getone($sql)>0) {
		sys_message('该分类下还有日志，请先删除该分类下的日志',$referer_url);
	}
	$sql='DELETE FROM '.table('category')." WHERE cat_id='".$cat_id."'";
	if ($db->query($sql))
	{
		sys_message('删除分类成功',$referer_url);
	}
	else
	{
		sys_message('删除失败，请重新删除',$referer_url);
	}
}

elseif ($action=='add_cat')
{

	$sql='SELECT cat_id,cat_name,cat_desc,listorder FROM '.table('category').
	" WHERE parent_id=0";
	$cat_list=$db->getall($sql);

	$smarty->assign('cat_list',$cat_list);
	$smarty->assign('type','act_add_cat');
	$smarty->assign('rewrite',$GLOBALS['config']['rewrite']);
	$smarty->assign('url_type',1);
	$smarty->assign('u',str_replace(PBBLOG_WS_ADMIN, '', dirname($url)));
	$smarty->display('add_cat.html');
}

elseif ($action=='act_add_cat')
{
	$cat_name=$_POST['cat_name'];
	$parent_id=intval($_POST['parent_id']);
	if (empty($cat_name))
	{
		sys_message('分类名字不能为空',$referer_url);
	}
	$cat_desc=$_POST['cat_desc'];
	$list_sort=$_POST['list_sort'];
	$url_type=intval($_POST['url_type']);
	//对自定义url处理
	if ($url_type==2)
	{
		$url_type=$_POST['url'];
	}

	$sql='INSERT INTO '.table('category').
	"  (`cat_id` ,`cat_name` ,`cat_desc` ,`parent_id` ,`listorder`,`url_type` ) VALUES (".
	"Null, '".$cat_name."', '".$cat_desc."', '".$parent_id."', '".$list_sort."','".$url_type."')";
	if ($db->query($sql))
	{
		sys_message('添加分类成功','admin.php?act=cat_list');
	}
	else
	{
		sys_message('添加分类失败，请重新返回添加','admin.php?act=add_cat');
	}
}

elseif ($action=='edit_cat')
{
	$cat_id=intval($_GET['id']);
	if (empty($cat_id))
	{
		sys_message('分类id不能为空',$referer_url);
	}
	$sql='SELECT * FROM '.table('category')." WHERE cat_id='".$cat_id."'";

	if ($row=$db->getrow($sql))
	{
		$sql='SELECT cat_id,cat_name,cat_desc,listorder FROM '.table('category').
		" WHERE parent_id=0 AND cat_id!=".$cat_id;
		$cat_list=$db->getall($sql);

		$smarty->assign('cat_list',$cat_list);
		$smarty->assign('cat_name',$row['cat_name']);
		$smarty->assign('cat_desc',$row['cat_desc']);
		$smarty->assign('list_sort',$row['listorder']);
		$smarty->assign('parent_id',$row['parent_id']);
	}
	else
	{
		sys_message('读取分类数据失败，请返回重新修改',$referer_url);
	}

	$smarty->assign('rewrite',$GLOBALS['config']['rewrite']);
	$smarty->assign('url_type',$row['url_type']);
	$smarty->assign('u',str_replace(PBBLOG_WS_ADMIN, '', dirname($url)));
	$smarty->assign('type','act_edit_cat&id='.$cat_id);
	$smarty->display('add_cat.html');
}

elseif ($action=='act_edit_cat')
{
	$cat_id=intval($_GET['id']);
	$parent_id=intval($_POST['parent_id']);
	if (empty($cat_id))
	{
		sys_message('分类id不能为空',$referer_url);
	}

	$cat_name=$_POST['cat_name'];
	if (empty($cat_name))
	{
		sys_message('分类名字不能为空',$referer_url);
	}
	$cat_desc=$_POST['cat_desc'];
	$list_sort=$_POST['list_sort'];
		
	//对自定义url处理
	$url_type=intval($_POST['url_type']);
	if ($url_type==2)
	{
		$url_type=$_POST['url'];
	}

	$sql='UPDATE '.table('category').
	"  SET `cat_name` = '".$cat_name."',`cat_desc` = '".$cat_desc."',`parent_id` = '".$parent_id."',`listorder` = '".$list_sort."' , `url_type`='".$url_type.
	"' WHERE cat_id='".$cat_id."'";

	if ($db->query($sql))
	{
		sys_message('修改分类成功','admin.php?act=edit_cat&id='.$cat_id);
	}
	else
	{
		sys_message('修改分类失败，请重新返回添加','admin.php?act=edit_cat&id='.$cat_id);
	}
}

?>