<?php

/**
 * $Author: pengwenfei p@simple-log.com
 * $Date: 2011-04-17
 * www.simple-log.com 
*/

define('IN_PBBLOG', true);

require(dirname(__FILE__) . '/includes/core.php');
require(dirname(__FILE__) . '/includes/json.class.php');

$id=!empty($_GET['id'])?intval($_GET['id']):'1';

$act=!empty($_GET['act'])?trim($_GET['act']):'default';

if ($act=='comments_list')
{
	$json   = new JSON;
	$res=array('type'=>'comments_list','content'=>'');

	$pg=isset($_GET['pg'])?intval($_GET['pg']):1;
	$page_size=!empty($page_size)?$page_size:'15';
	$sql='SELECT count(*) FROM '.table('comment')." WHERE blog_id='".$id."'";
	$page_count=intval(($db->getone($sql)-1)/$page_size)+1;
	$page_arr=create_page($page_count,$pg,0);
	$start=($pg-1)*$page_size;

	$sort=$GLOBALS['config']['comment_sort']?'ASC':'DESC';
	$sql='SELECT * FROM '.table('comment')." WHERE blog_id='".$id."' order by comment_id $sort  LIMIT ".$start.' , '.$page_size;
	if ($comments=$db->getall($sql))
	{
		$page=array('pg'=>$pg,'page_count'=>$page_count,'page_arr'=>$page_arr,'start'=>$start);
		$res['content']=get_comments($comments,$page);
	}
	else
	{
		$res['content']='该日志暂无评论';
	}

	die($json->encode($res));
}

elseif ($act=='post_comment')
{
	$json   = new JSON;
	$res=array('type'=>'comments_list','content'=>'','error'=>'no');

	$user_name=htmlspecialchars(trim($_POST['name']));

	if (empty($user_name))
	{
		$res['error']='用户名字不能为空';
		die($json->encode($res));
	}
	else
	{
		if ($_SESSION['user_id']>0)
		{
			$u_name=$db->getone('SELECT user_name FROM '.table('user')." WHERE user_id='".$_SESSION['user_id']."'");
			if ($u_name!=$user_name)
			{
				$res['error']='您的名字与您注册的名字不一致请返回重新填写';
				die($json->encode($res));
			}
		}
		else
		{
			if ($db->getone('SELECT user_name FROM '.table('user')." WHERE user_name='".$user_name."'"))
			{
				$res['error']='您的名字已经被注册了，请返回重新填写';
				die($json->encode($res));
			}
		}
	}

	$home=htmlspecialchars($_POST['url']);
	if (!strstr($home,'http://'))
	{
		$home='http://'.$home;
	}

	$replay_id=intval($_GET['comment_id']);
	$email=htmlspecialchars($_POST['email']);

	$content=trim($_POST['content']);
	if (empty($content))
	{
		$res['error']='评论内容不能为空';
		die($json->encode($res));
	}
	else
	{
		$content=process_text($content);
	}

	$parent_id=($replay_id>0)?$replay_id:0;

	hook(9,array('user_name'=>$user_name, 'content'=>$content, 'email'=>$email, 'home'=>$home,'json'=>$json));

	$comment_safe=$user_id==1?0:$config['comment_safe'];

	$parent_id=($replay_id>0)?$replay_id:0;

	$sql="INSERT INTO ".table('comment')." (`comment_id` ,`blog_id` ,`user_id` ,`user_name` ,`content` ,`email` ,`home` ,`add_time` ,`ip` ,`status`,`parent_id` )".
	"VALUES (NULL , '$id', '$user_id', '$user_name', '".$content."', '$email', '$home', '$time', '$ip', '".$comment_safe."','".$parent_id."' ) ";

	if ($db->query($sql)===false)
	{
		$res['error']='添加失败，请重试';
	}

	/* 更新评论次数 */
	$db->query('UPDATE ' . table('blog') . " SET comments = comments + 1 WHERE blog_id = '$id'");

	hook(4,array('user_name'=>$user_name, 'content'=>$content, 'email'=>$email, 'home'=>$home));

	$pg=isset($_GET['pg'])?intval($_GET['pg']):1;
	$page_size=!empty($page_size)?$page_size:'15';
	$sql='SELECT count(*) FROM '.table('comment')." WHERE blog_id='".$id."'";
	$page_count=intval(($db->getone($sql)-1)/$page_size)+1;
	$page_arr=create_page($page_count,$pg,0);
	$start=($pg-1)*$page_size;
	$page=array('pg'=>$pg,'page_count'=>$page_count,'page_arr'=>$page_arr,'start'=>$start);
	
	$sort=$GLOBALS['config']['comment_sort']?'ASC':'DESC';
	$sql='SELECT * FROM '.table('comment')." WHERE blog_id='".$id."' order by comment_id $sort LIMIT ".$start.' , '.$page_size;
	if ($comments=$db->getall($sql))
	{
		$res['content']=get_comments($comments,$page);
	}
	else
	{
		$res['content']='该日志暂无评论';
	}

	die($json->encode($res));
}

elseif ($act=='check_name')
{
	$json = new JSON;
	$result=array('content'=>'','error'=>0);
	$member=htmlspecialchars(trim($_POST['name']));
	if (isset_member($member))
	{
		$result=array('content'=>'用户名已经存在','error'=>1);
		die($json->encode($result));
	}
}

function get_comments($comments,$page=array())
{
	$new_key=$page['start'];
	foreach ($comments as $key=>$val)
	{
		$new_key++;
		$comment[$new_key]=$comments[$key];
		if ($key%2==0)
		{
			$comment[$new_key]['odd']=1;
		}
		if (($val['user_id']==$_SESSION['user_id']))
		{
			$comment[$new_key]['edit']=true;
		}
		$comment[$new_key]['content']=$comment[$new_key]['content'];

		//评论是否还在审核中
		if ($val['status']==1)
		{
			$comment[$new_key]['content']='该评论正在审核中';
		}
		$comment[$new_key]['add_time']=pbtime($comment[$new_key]['add_time']);

		if ($val['parent_id']>0)
		{
			$comment[$new_key]['children']=get_comments_children($val['parent_id']);
		}

	}

	$caching_setting = $GLOBALS['smarty']->caching;
	$GLOBALS['smarty']->caching = false;
	$GLOBALS['smarty']->assign('comments_list',        $comment);
	$GLOBALS['smarty']->assign('page_arr',        $page['page_arr']);
	$GLOBALS['smarty']->assign('page_count',      $page['page_count']);
	$GLOBALS['smarty']->assign('pg',      		  $page['pg']);
	$GLOBALS['smarty']->assign('group_id',        $GLOBALS['group_id']);
	$res = $GLOBALS['smarty']->fetch('comments.html');
	$GLOBALS['smarty']->caching = $caching_setting;
	return $res;
}


function get_comments_children($id,$re_comments=array())
{
	$sql='SELECT * FROM '.table('comment')." WHERE comment_id='".$id."'  order by comment_id ASC LIMIT 1 ";
	if ($re_comment=$GLOBALS['db']->getrow($sql))
	{
		$re_comment['add_time']=pbtime($re_comment['add_time']);
		$re_comments[]=$re_comment;
		while ($re_comment['parent_id']>0)
		{
			$sql='SELECT * FROM '.table('comment')." WHERE comment_id='".$re_comment['parent_id']."'  order by comment_id ASC LIMIT 1 ";
			$re_comment=$GLOBALS['db']->getrow($sql);
			$re_comment['add_time']=pbtime($re_comment['add_time']);
			$re_comments[]=$re_comment;
		}

		return array_reverse($re_comments);
	}
}

?>