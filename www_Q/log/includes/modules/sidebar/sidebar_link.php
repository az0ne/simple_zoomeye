<?php
$type=1;			//1表示边栏模块
$id='link';			//id为该模块唯一标识

$modules['link']['title']='友情链接';
$modules['link']['desc']='友情链接，系统自带模块';
$modules['link']['content']='
        <ul>
		{foreach from=$link_list item=link}
			<li><a href={$link.url} title={$link.desc}>{$link.title}</a></li>
		{/foreach}
		</ul>';
?>