<?php

/**
 * feed文件
 * $Author: pengwenfei p@simple-log.com
 * $Date: 2010-07-18
 * www.simple-log.com 
*/

define('IN_PBBLOG', true);
require(dirname(__FILE__) . '/includes/core.php');
$act=!empty($_GET['act'])?trim($_GET['act']):'default';
header("Content-Type: text/plain"); 

//显示所有的日志
if ($act=='default')
{
	$sql='SELECT b.blog_id,b.title,b.content,b.add_time,b.views,b.comments,b.password,b.view_group,b.url_type,u.user_name,c.cat_name,c.cat_id,c.url_type as cat_url_type,u.user_name FROM '.
	table('blog').' AS  b LEFT JOIN '.table('user').' AS u on b.user_id=u.user_id'.
	'  LEFT JOIN '.table('category').' AS c on b.cat_id=c.cat_id'.
	" ORDER BY b.open_type DESC , b.blog_id DESC LIMIT 0 , 20 ";
	$blog_list=$db->getall($sql);
	foreach ($blog_list as $key=>$val)
	{
		$blog_list[$key]['add_time']=date('r',$val['add_time']);
		$blog_list[$key]['content']=htmlspecialchars_decode($val['content']);
		$id=$val['blog_id'];
		if ($val['password'])
		{
			if ($group_id!=1)
			{
				$blog_list[$key]['content']='本篇日志需要密码才能查看';
			}
		}
		else
		{
			if ($val['view_group']!='all'&&(!in_array($group_id,explode(' ',$val['view_group'])))&&$group_id!=1)
			{
				$blog_list[$key]['content']='您所在的组无权查看该日志';
			}
		}
		$blog_list[$key]['url']=build_url('blog',$id,$val['url_type']);
		$blog_list[$key]['cat_url']=build_url('cat',$val['cat_id'],$val['cat_url_type']);
	}

	$xml_body='';
	foreach ($blog_list as $val)
	{
		$xml_body.="<item> \n";
		$xml_body.="<title>{$val['title']}</title> \n";
		$xml_body.="<author>{$val['user_name']}</author> \n";
		$xml_body.="<link>{$u}/blog.php?id={$val['blog_id']}</link> \n";
		$xml_body.="<description><![CDATA[{$val['content']}]]></description> \n";
		$xml_body.="<category><![CDATA[{$val['cat_name']}]]></category> \n";
		$xml_body.="<pubDate>{$val['add_time']}</pubDate> \n";
		$xml_body.="<guid>{$u}/blog.php?id={$val['blog_id']}</guid> \n";
		$xml_body.="</item> \n";
	}
}


//显示评论rss
elseif ($act=='comments')
{
	$sql='SELECT b.blog_id,b.title,b.url_type,c.user_name,c.content,c.add_time FROM '.
	table('blog').' AS  b LEFT JOIN '.table('comment').' AS c on b.blog_id=c.blog_id'.
	" ORDER BY c.comment_id DESC ";
	if ($comments=$db->getall($sql))
	{
		$xml_body='';
		foreach ($comments as $key=>$val)
		{
		
			//评论是否还在审核中
			if ($val['status']==1)
			{
				$val['content']='该评论正在审核中';
			}
			else 
			{
				$val['content']=unprocess_text($val['content']);
			}
			$val['add_time']=pbtime($val['add_time']);
			
			$url=build_url('blog',$val['blog_id'],$val['url_type']);

			$xml_body.="<item> \n";
			$xml_body.="<title>【评论:{$val['title']}】</title> \n";
			$xml_body.="<author>{$val['user_name']}</author> \n";
			$xml_body.="<link>{$url}</link> \n";
			$xml_body.="<description><![CDATA[{$val['content']}]]></description> \n";
			$xml_body.="<pubDate>{$val['add_time']}</pubDate> \n";
			$xml_body.="<guid>{$url}</guid> \n";
			$xml_body.="</item> \n";
		}
	}
}


$u=dirname($url);
$logo=$u.'/themes/'.$config['template_name']."/logo.jpg";
$xml="<?xml version=\"1.0\" encoding=\"UTF-8\"?>  \n";
$xml.="<rss version=\"2.0\"> \n";
$xml.="<channel> \n";
$xml.="<title>{$config['blog_name']}</title>  \n";
$xml.="<link>{$u}/index.php</link> \n";
$xml.="<description>{$blog_desc}</description> \n";
$xml.="<generator>Simple-Log</generator> \n";
$xml.="<pubDate>{$date}</pubDate> \n";
$xml.="<image> \n";
$xml.="<url>{$logo}</url> \n";
$xml.="<title>{$blog_name}</title> \n";
$xml.="<link>{$u}/index.php</link> \n";
$xml.="</image> \n";


$xml.=$xml_body;


$xml.="</channel> \n";
$xml.="</rss> \n";

echo $xml;
?>