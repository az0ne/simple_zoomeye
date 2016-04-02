<?php
$type=1;				//1表示边栏模块
$id='cat';			//id为该模块唯一标识

$modules['cat']['title']='日志分类';
$modules['cat']['desc']='日志分类，系统自带模块';
$modules['cat']['content']='
        <ul>
		{foreach from=$cat item=cat_val}
			<li><a href={$cat_val.url} title={$cat_val.cat_desc}>{$cat_val.cat_name}</a></li>
			{if $cat_val.children}
     		  	{foreach from=$cat_val.children item=children}
     		  	<li class="children"><a href={$children.url} title={$children.cat_desc}>{$children.cat_name}</a></li>
      		    {/foreach}
  			{/if}
		{/foreach}
		</ul>';
?>