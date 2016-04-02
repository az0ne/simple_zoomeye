<?php

/**
 * $Author: pengwenfei p@simple-log.com
 * $Date: 2010-08-07
 * www.simple-log.com 
*/

if ($action=='tags_list')
{
	$pg=isset($_GET['pg'])?intval($_GET['pg']):1;
	$page_size=!empty($config['page_size'])?$config['page_size']:'15';
	$sql='SELECT count(*) FROM '.table('tags');
	$page_count=intval(($db->getone($sql)-1)/$page_size)+1;
	$page_arr=create_page($page_count,$pg,0);

	$start=($pg-1)*$page_size;


	$sql='SELECT t.* , b.title FROM '.table('tags')." AS t LEFT JOIN ".table('blog')." AS b ON t.blog_id=b.blog_id ORDER BY tag_id DESC LIMIT ".$start.' , '.$page_size;
	$tags_list=$db->getall($sql);
	foreach ($tags_list as $key=>$val)
	{
		$tags_list[$key]['add_time']=pbtime($val['add_time']);
	}

	$smarty->assign('tags_list',$tags_list);
	$smarty->assign('page_arr',$page_arr);
	$smarty->assign('page_count',$page_count);
	$smarty->assign('pg',$pg);
	$smarty->assign('url','admin.php?act=tags_list&pg=');
	$smarty->display('tags_list.html');
}


elseif ($action=='del_tag')
{
	$tag_id=intval($_GET['id']);
	$sql='DELETE FROM '.table('tags')." WHERE tag_id='".$tag_id."'";
	if ($db->query($sql))
	{
		$db->query($sql);
		sys_message('删除tags成功',$referer_url);
	}
	else
	{
		sys_message('删除tags失败，请重新删除',$referer_url);
	}
}

elseif ($action=='attachments_list')
{
	$pg=isset($_GET['pg'])?intval($_GET['pg']):1;
	$page_size=!empty($config['page_size'])?$config['page_size']:'15';
	$sql='SELECT count(*) FROM '.table('attachments');
	$page_count=intval(($db->getone($sql)-1)/$page_size)+1;
	$page_arr=create_page($page_count,$pg,0);

	$start=($pg-1)*$page_size;


	$sql='SELECT * FROM '.table('attachments')." ORDER BY attachment_id DESC LIMIT ".$start.' , '.$page_size;
	$attachments_list=$db->getall($sql);
	foreach ($attachments_list as $key=>$val)
	{
		$attachments_list[$key]['add_time']=pbtime($val['add_time']);
	}

	$smarty->assign('attachments_list',$attachments_list);
	$smarty->assign('page_arr',$page_arr);
	$smarty->assign('page_count',$page_count);
	$smarty->assign('pg',$pg);
	$smarty->assign('url','admin.php?act=attachments_list&pg=');
	$smarty->display('attachments_list.html');
}


elseif ($action=='del_attachment')
{
	$attachment_id=intval($_GET['id']);
	$sql='DELETE FROM '.table('attachments')." WHERE attachment_id='".$attachment_id."'";
	if ($db->query($sql))
	{
		$db->query($sql);
		unlink(PBBLOG_ROOT.'/'.$db->getone('SELECT file_name FROM '.table('attachments')." WHERE attachment_id='".$attachment_id."'"));
		sys_message('删除附件成功',$referer_url);
	}
	else
	{
		sys_message('删除附件失败，请重新删除',$referer_url);
	}
}

elseif ($action=='auto_save')
{
	require(PBBLOG_ROOT. '/includes/json.class.php');
	$json   = new JSON;
	$res=array('content'=>'','error'=>'no');

	$user_id=intval($_SESSION['user_id']);
	$id=intval($_POST['id']);
	$title=htmlspecialchars($_POST['title']);
	$desc=htmlspecialchars($_POST['desc']);
	$content=htmlspecialchars($_POST['content']);

	$content=$_POST['content'];

	if (empty($content)&&empty($title))
	{
		$res['content']='于'.$date.'自动保存到草稿箱';
		die($json->encode($res));
	}

	$db->query('DELETE FROM '.table('page')." WHERE relate_id='".$id."'". " AND  user_id='".$user_id."' AND type='-1'");

	$sql="INSERT INTO ".table('page')." (`page_id` ,`relate_id` ,`user_id` ,`title`,`desc`,`content` ,`add_time` ,`ip` ,`status`,`type` )".
	"VALUES (NULL , '$id', '$user_id', '".$title."', '".$desc."', '".$content."','$time', '$ip', '0','-1' ) ";

	if ($db->query($sql)===false)
	{
		$res['error']='于'.$date.'自动保存到草稿箱失败';
	}
	else
	{
		$res['content']='于'.$date.'自动保存到草稿箱'.'    <a href="#" onclick="javascript:get_auto_data()" id="get_page">获取草稿内容覆盖现在编辑日志</a>';
	}

	die($json->encode($res));

}

elseif ($action=='get_auto_save')
{
	require(PBBLOG_ROOT. '/includes/json.class.php');
	$json   = new JSON;
	$res=array('title'=>'','desc'=>'','content'=>'','error'=>'no');

	$id=intval($_POST['id']);
	$sql='SELECT * FROM '.table('page')." WHERE relate_id='".$id."'". " AND user_id='".$user_id."' AND type='-1'";

	if (!$row=$db->getrow($sql))
	{
		$res['error']='获取草稿箱数据失败';
	}
	else
	{
		$res['title']=$row['title'];
		$res['desc']=$row['desc'];
		$res['content']=$row['content'];
	}
	die($json->encode($res));
}

elseif ($action=='check_auto_date')
{
	require(PBBLOG_ROOT. '/includes/json.class.php');
	$json   = new JSON;
	$res='no';

	$id=intval($_POST['id'])>0?intval($_POST['id']):0;
	$sql='SELECT add_time FROM '.table('page')." WHERE relate_id='".$id."'". " AND user_id='".$user_id."' AND type='-1'";
	if ($row=$db->getone($sql))
	{
		$res='系统在'.pbtime($row).'自动保存到草稿箱'.'    <a href="#" onclick="javascript:get_auto_data()" id="get_page">获取草稿内容覆盖现在编辑日志</a>';
	}
	die($json->encode($res));

}

?>