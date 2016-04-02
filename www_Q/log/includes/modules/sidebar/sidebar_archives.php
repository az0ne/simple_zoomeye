<?php

$type=1;				//1表示边栏模块
$id='archives';			//id为该模块唯一标识

$modules['archives']['title']='日志归档';
$modules['archives']['desc']='日志文件归档，系统自带模块';
$modules['archives']['content']='
		<ul>
		{foreach from=$archives item=archives_val key=key}
			<li><a href={$archives_val.url}>{$archives_val.data}</a></li>
		{/foreach}
		</ul>';
?>