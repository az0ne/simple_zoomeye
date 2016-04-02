<?php

function new_comment($arr=array())
{
	$sql='SELECT c.user_name,c.content,c.add_time,b.blog_id,b.title,b.url_type  FROM '.table('comment').
	' AS c LEFT JOIN '.table('blog').' AS b ON c.blog_id=b.blog_id'.
	' WHERE 1 ORDER BY c.add_time DESC LIMIT 10';
	if ($comment_list=$GLOBALS['db']->getall($sql))
	{
		foreach ($comment_list as $key=>$val)
		{
			$comment_list[$key]['url']=build_url('blog',$val['blog_id'],$val['url_type']);
			$comment_list[$key]['add_time']=pbtime($val['add_time']);
		}
	}
	$GLOBALS['smarty']->assign('new_comment',$comment_list);
}


function new_comment_install()
{
	$modules['id']='new_comment';		//1表示边栏模块
	$modules['type']=1;					//1表示边栏模块
	$modules['title']='最新评论';
	$modules['desc']='在边栏显示最新评论';
	$modules['content']='
        <ul>
		{foreach from=$new_comment item=val}
			<li>{$val.user_name} 说<a href={$val.url} title="{$val.user_name}于{$val.add_time}在{$val.title}发布评论{$val.content}">{$val.content}</a></li>
		{/foreach}
		</ul>';
	return $modules;
}

function new_comment_uninstall()
{
	$modules['id']='new_comment';		//1表示边栏模块
	$modules['type']=1;					//1表示边栏模块
	return $modules;
}

?>