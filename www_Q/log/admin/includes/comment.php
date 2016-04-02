<?php

/**
 * $Author: pengwenfei p@simple-log.com
 * $Date: 2010-02-16
 * www.simple-log.com 
*/

require_once(PBBLOG_ROOT.'/includes/base.function.php');

if ($action=='comment_list') 
{
	//页数处理
	$pg=isset($_GET['pg'])?intval($_GET['pg']):1;
	$page_size=!empty($page_size)?$page_size:'15';
	$sql='SELECT count(*) FROM '.table('comment');
	$page_count=intval(($db->getone($sql)-1)/$page_size)+1;
	$page_arr=create_page($page_count,$pg,0);
	
	//获取分组数据
	$start=($pg-1)*$page_size;
	$sql='SELECT o.* , u.title FROM '.table('comment').' o LEFT JOIN '.table('blog').' u on o.blog_id=u.blog_id'.
			" ORDER BY comment_id DESC  LIMIT ".$start.' , '.$page_size;
	if ($comment_list=$db->getall($sql)) 
	{
		
			foreach ($comment_list as $key => $val)
			{
				$comment_list[$key]['add_time']=pbtime($val['add_time']);
				$comment_list[$key]['short_comment']=pbsubstr($val['content'],10);
				$comment_list[$key]['content']=unprocess_text($val['content']);
				$comment_list[$key]['short_comment']=unprocess_text($comment_list[$key]['short_comment']);
			}
	}
	
	$smarty->assign('comment_list',$comment_list);
	$smarty->assign('page_arr',$page_arr);
	$smarty->assign('page_count',$page_count);
	$smarty->assign('pg',$pg);
	$smarty->assign('url','admin.php?act=comment_list&pg=');
	
	$smarty->assign('admin_title','评论列表');
	$smarty->display('comment_list.html');
}



elseif ($action=='del_comment')
{
	$comment_id=intval($_GET['id']);
	$blog_id=$db->getone('SELECT blog_id FROM '.table('comment').
		" WHERE comment_id='".$comment_id."'");
	$sql='DELETE FROM '.table('comment')." WHERE comment_id='".$comment_id."'";
	if ($db->query($sql)) 
	{
		$sql='UPDATE '.table('blog')." SET comments =comments-1 WHERE blog_id='$blog_id'";
		$db->query($sql);
        sys_message('删除评论成功',$referer_url);
	}
	else
	{
		sys_message('删除评论失败，请重新删除',$referer_url);
	}
}

elseif ($action=='edit_comment')
{
	$comment_id=intval($_GET['id']);
	if (empty($comment_id)) 
	{
		sys_message('日志评论id不能为空',$referer_url);
	}
	$sql='SELECT o.* , u.title FROM '.table('comment').' o LEFT JOIN '.table('blog').' u on o.blog_id=u.blog_id'.
			" WHERE comment_id='".$comment_id."'";
	
	if ($row=$db->getrow($sql)) 
	{
		$row['content']=unprocess_text($row['content']);
		$smarty->assign('comment',$row);
	}
	else 
	{
		sys_message('读取日志评论数据失败，请返回重新修改',$referer_url);
	}

	$smarty->assign('type','act_edit_comment&id='.$comment_id);
	$smarty->assign('admin_title','编辑评论');
	$smarty->display('edit_comment.html');
}

elseif ($action=='act_edit_comment')
{
	
	$comment_id=intval($_GET['id']);
	if (empty($comment_id)) 
	{
		sys_message('日志评论ID不能为空',$referer_url);
	}
	$status=!empty($_POST['status'])?$_POST['status']:0;

	$content=$_POST['content'];
	if (empty($content)) 
	{
		sys_message('评论内容不能为空',$referer_url);
	}
	
	$content=process_text($content);

	$sql='UPDATE '.table('comment').
		"  SET `status` = '".$status."',`content` = '".$content.
		"' WHERE comment_id='".$comment_id."'";
		
		
	if ($db->query($sql)) 
	{
		sys_message('修改评论成功','admin.php?act=edit_comment&id='.$comment_id);
	}
	else
	{
		sys_message('修改评论失败，请重新返回修改','admin.php?act=edit_comment&id='.$comment_id);
	}
}

?>