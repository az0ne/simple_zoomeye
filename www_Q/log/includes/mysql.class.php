<?php

/**
 * $Author: pengwenfei p@simple-log.com
 * $Date: 2010-02-16
 * www.simple-log.com 
*/

if (!defined('IN_PBBLOG')) 
{
	die('Access Denied');
}

class cls_mysql{
	
	private $con_id;
	private $query_num;
	
	function connect($dbhost,$dbuser,$dbpw,$dbname = '',$charset='utf8',$pconnect = 0)
	{
		if ($pconnect) 
		{
			if (!($this->con_id=mysql_pconnect($dbhost,$dbuser,$dbpw))) {
				$this->err_msg('can not to pconnect mysql server "'.$dbhost.'"');
			}
		}
		else
		{
			if (!($this->con_id=mysql_connect($dbhost,$dbuser,$dbpw))) {
				$this->err_msg('can not to connect mysql server "'.$dbhost.'"');
			}
		}
		
		if ($charset&&$this->version()>'4.1') 
		{
			mysql_query("SET NAMES '".$charset."'" , $this->con_id);
		}
		
		if ($this->version()>'5.0.1') 
		{
			 mysql_query("SET sql_mode=''", $this->con_id);
		}
		
		if ($dbname) 
		{
			if (!mysql_select_db($dbname, $this->con_id) )
			{
				$this->err_msg('can not select db:'.$dbname);
			}
		}
		
		return $this->con_id;
	}
	
    function select_db($dbname)
    {
        return mysql_select_db($dbname, $this->con_id);
    }
    
    function query($sql,$type='')
    {
    	if (!($query=mysql_query($sql,$this->con_id))&&$type!='SILENT') 
    	{
    		$this->err_msg('there has a wrong when query sql:'.$sql);
    	}
    	$this->query_num++;
    	return $query;
    }
    
    function fetch_array($query,$result_type=MYSQL_ASSOC)
    {
    	return mysql_fetch_array($query,$result_type);
    }
    
    function affected_rows()
    {
        return mysql_affected_rows($this->con_id);
    }

    function error()
    {
        return mysql_error($this->con_id);
    }

    function errno()
    {
        return mysql_errno($this->con_id);
    }

    function result($query, $row)
    {
        return @mysql_result($query, $row);
    }

    function num_rows($query)
    {
        return mysql_num_rows($query);
    }

    function num_fields($query)
    {
        return mysql_num_fields($query);
    }

    function free_result($query)
    {
        return mysql_free_result($query);
    }
    
    function insert_id()
    {
    	return mysql_insert_id($this->con_id);
    }
    
    function fetchRow($query)
    {
        return mysql_fetch_assoc($query);
    }
    
	function version() 
	{
  		return mysql_get_server_info($this->con_id);
	}
	
	function close()
    {
        return mysql_close($this->con_id);
    }
    
    //获取单个返回结果集中的单个数据
    function getone($sql)
    {
    	$res=$this->query($sql);
    	if ($res) 
    	{
    		$row=$this->fetch_array($res,MYSQL_NUM);
    		if ($row!==false) 
    		{
    			return $row['0'];
    		}
    		else 
    		{
    			return '';
    		}
    	}
    	else
    	{
    		return false;
    	}
    }
    
    //获取一条结果集中的一条数组
    function getrow($sql)
    {
    	$res=$this->query($sql);
    	if ($res) 
    	{
    		$row=$this->fetch_array($res);
    		if ($row!==false) 
    		{
    			return $row;
    		}
    		else 
    		{
    			return '';
    		}
    	}
    	else
    	{
    		return false;
    	}
    }
    
    //获取所有结果
    function getall($sql)
    {
    	$res=$this->query($sql);
    	if ($res) 
    	{
    		$arr=array();
    		while ($row=$this->fetch_array($res)) 
    		{
    			$arr[]=$row;
    		}
    		return $arr;
    	}
    	else
    	{
    		return false;
    	}
    }

	function err_msg($msg)
	{
		if ($msg) 
		{
			die($msg.'<br /> error:'.$this->error().'<br /> errno:'.$this->errno());
		}
		else 
		{
			die('mysql error');
		}
	}
}
?>