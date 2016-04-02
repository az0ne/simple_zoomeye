<?php

function new_article($arr=array())
{
	$sql='SELECT blog_id,title,url_type  FROM '.table('blog').' WHERE 1 ORDER BY `add_time` DESC LIMIT 10';
	if ($blog_list=$GLOBALS['db']->getall($sql))
	{
		foreach ($blog_list as $key=>$val)
		{
			$blog_list[$key]['url']=build_url('blog',$val['blog_id'],$val['url_type']);
		}
	}
	$GLOBALS['smarty']->assign('new_article',$blog_list);
}

function new_article_install()
{
	$modules['id']='new_article';		//1表示边栏模块
	$modules['type']=1;					//1表示边栏模块
	$modules['title']='最新文章';
	$modules['desc']='在边栏显示最新文章';
	$modules['content']='
        <ul>
		{foreach from=$new_article item=new_article_val}
			<li><a href={$new_article_val.url} title={$new_article_val.title}>{$new_article_val.title}</a></li>
		{/foreach}
		</ul>';
	return $modules;
}

function new_article_uninstall()
{
	$modules['id']='new_article';		//1表示边栏模块
	$modules['type']=1;					//1表示边栏模块
	return $modules;
}

?>