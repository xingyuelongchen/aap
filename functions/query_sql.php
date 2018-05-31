<?php
/** 页面功能表
	create_sql($sql_name,$type)					- 创建或删除数据库
	delete($table,$where,$limit)	 			- 删除数据
	insert($table,$arr)							- 插入数据
	updata($table,$arr,$where)					- 更新数据
	query($table,$where)						- 查询数据
	field_add($table,$column,$datetype,$key) 	- 添加字段
	field_change($table,$column,$datetype)		- 修改字段数据类型
	field_del($table,$column)					- 删除字段
	table_add($table,$id)						- 添加数据表并设置主键ID
	table_change($old_table_name,$new_table_name)-修改数据表名
	table_del($table_name)						- 删除数据表
*/

//创建数据库
/*
* 	sql_name	string		数据库名称
*	$type		add or del	创建 or 删除
*	return		booler		成功true 失败false
*/
function create_sql($sql_name,$type='add'){
	$link=connect();
	if($type=='del'){
		$a="drop database {$sql_name}";
	}else{
		$a="create database {$sql_name}";
	}
	return mysqli_query($link,$a);
}
//删除记录
/*
* $table 表名 
* $where 条件
* $limit 指定记录条数
*	sql_del(表名,条件,指定记录条数)
*/
function delete($table,$where=null,$limit=null){
	$link=connect();
	$a="delete from $table where $where $limit";
	mysqli_query($link,$value);
	mysqli_affected_rows($linksql)?true:false;
}

//增加记录
/**
* $table	string	表名
* $arr		array	字段和值
* return	string	成功就返回添加的记录的id，失败返回错误信息
*/
function insert($table,$arr){
	$link=connect();
	if(is_array($arr)){
		$keys= join(",",array_keys($arr));
		$vals="'".join("','",array_values($arr))."'";
	}else{
		return '请以数组形式传入';
	}
	$a = "insert into {$table}($keys) values({$vals})";
	$bool=mysqli_query($link,$a);
	if($bool){
		return mysqli_insert_id($link);
	}else{
		return mysqli_error($link);
	}
}

//改记录
/**
* $table	string	表名
* $arr		array	要修改字段的值
* return	string	成功就返回添加的记录的id，失败返回false
*/
function update($table,$arr,$where=null){
	$link=connect();
	$str='';
	foreach($arr as $key=>$val){
		
		if($str==null){
			$sep='';
		}else{
			$sep=',';
		}
		$str.=$sep.$key."='".$val."'";
		//最终$str状态为 name='json',sex='man'
	}
	$a = "update {$table} set {$str}".($where==null?null:" where {$where}");
	mysqli_query($link,$a);
	$num=mysqli_affected_rows($link);
	$num = $num>=0?$num:false;
	return $num;
}


//增加字段
/**
* $table	string	表名
* $column	array	字段名
* $datetype	string	字段类型
* return	booler	成功true，失败返回false
*/
function field_add($table,$column,$datetype,$key=null){
	$link=connect();
	if(!$table or !$column or !$datetype){
		return '参数错误';
	}
	$a="alter table {$table} add {$column} {$datetype}".$key=$key==null?null:null;
	return mysqli_query($link,$a);
	
	//ALTER TABLE $table ADD $arr datatype
}
//更改字段数据类型
/*
* $table	string	表名
* $column	array	字段名
* return	booler	成功true，失败返回false
*/
function field_change($table,$column,$datetype){
	$link=connect();
	if(!$table or !$column){
		return '参数错误';
	}
	$a="alter table {$table} modify column {$column} $datetype";
	 return mysqli_query($link,$a);
	//ALTER TABLE table_name ALTER COLUMN column_name datetype /
	//alter table 表名 modifycolumn UnitPrice decimal(18, 4) not null
}
//删除字段
/*
* $table	string	表名
* $column	array	字段名
* return	booler	成功true，失败返回false
*/
function field_del($table,$column){
	$link=connect();
	if(!$table or !$column){
		return '参数错误';
	}
	$a="alter table {$table} DROP COLUMN {$column}";
	if(!mysqli_query($link,$a)){
		die("数据表创建失败：".sql_error(mysqli_errno($link)));
	}
	return true;
	//ALTER TABLE Person DROP COLUMN Birthday
}

//增加数据表
/*
* $table	string	表名
* $id		string	主键ID名
* return	booler	成功true，失败返回详情信息
*/
function table_add($table,$id){
	$link=connect();
	if(!$table or !$id){
		return '参数错误';
	}
	$a="CREATE TABLE {$table}(
		{$id} INT NOT NULL AUTO_INCREMENT,
		time date,
		PRIMARY KEY({$id})
		)ENGINE=InnoDB DEFAULT CHARSET=utf8;";
	if(!mysqli_query($link,$a)){
		die("数据表创建失败：".sql_error(mysqli_errno($link)));
	}
	return true;
}

//修改数据表
/*
* $old_table_name	string	需要更改的表名
* $new_table_name	string	更改后的新表名
* return	booler	成功true，失败返回详情信息
*/
function table_change($old_table_name,$new_table_name){
	$link=connect();
	if(!$old_table_name or !$new_table_name){
		return '参数错误';
	}
	$a="alter table {$old_table_name} rename to {$new_table_name}";
	if(!mysqli_query($link,$a)){
		die('数据执行失败：'.sql_error(mysqli_errno($link)));
	}
	return true;
}
//删除数据表
/*
* $table_name	string	需要删除数据表名称
* return	booler	成功true，失败返回详情信息
*/
function table_del($table_name){
	$link=connect();
	if(!$table_name){
		return '参数错误';
	}
	$a="drop table {$table_name}";
	if(!mysqli_query($link,$a)){
		die('数据执行失败：'.sql_error(mysqli_errno($link)));
	}
	return true;
}



//查记录
/**
$table  string 表名
$where	表达式  搜索条件
$name	列名	表列名称
$id		string	返回指定字段的值

*/
function query($table,$where=null,$clause=null,$name=null,$id=false){
	$link=connect();
	$a="select ".($name?$name:"*")." from {$table} " .($where?" where {$where}":null).' '.$clause;
	//print_r($a);
	$text = mysqli_query($link,$a);
	if($id){
		$a = mysqli_fetch_array($text);
		return $a["$id"];	
	}
	return $text;
}
function sql_error($num){
	switch($num){
		case 1005:$str="创建表失败";
			break;
		case 1006:$str="创建数据库失败";
			break;
		case 1007:$str="数据库已存在，创建数据库失败";
			break;
		case 1008:$str="数据库不存在，删除数据库失败";
			break;
		case 1009:$str="不能删除数据库文件导致删除数据库失败";
			break;
		case 1010:$str="不能删除数据目录导致删除数据库失败";
			break;
		case 1011:$str="删除数据库文件失败";
			break;
		case 1012:$str="不能读取系统表中的记录";
			break;
		case 1020:$str="记录已被其他用户修改";
			break;
		case 1021:$str="硬盘剩余空间不足，请加大硬盘可用空间";
			break;
		case 1022:$str="关键字重复，更改记录失败";
			break;
		case 1023:$str="关闭时发生错误";
			break;
		case 1024:$str="读文件错误";
			break;
		case 1025:$str="更改名字时发生错误";
			break;
		case 1026:$str="写文件错误";
			break;
		case 1032:$str="记录不存在";
			break;
		case 1036:$str="数据表是只读的，不能对它进行修改";
			break;
		case 1037:$str="系统内存不足，请重启数据库或重启服务器";
			break;
		case 1038:$str="用于排序的内存不足，请增大排序缓冲区";
			break;
		case 1040:$str="已到达数据库的最大连接数，请加大数据库可用连接数";
			break;
		case 1041:$str="系统内存不足";
			break;
		case 1042:$str="无效的主机名";
			break;
		case 1043:$str="无效连接";
			break;
		case 1044:$str="当前用户没有访问数据库的权限";
			break;
		case 1045:$str="不能连接数据库，用户名或密码错误";
			break;
		case 1048:$str="字段不能为空";
			break;
		case 1049:$str="数据库不存在";
			break;
		case 1050:$str="数据表已存在";
			break;
		case 1051:$str="数据表不存在";
			break;
		case 1054:$str="字段不存在";
			break;
		case 1065:$str="无效的SQL语句，SQL语句为空";
			break;
		case 1081:$str="不能建立Socket连接";
			break;
		case 1114:$str="数据表已满，不能容纳任何记录";
			break;
		case 1116:$str="打开的数据表太多";
			break;
		case 1129:$str="数据库出现异常，请重启数据库";
			break;
		case 1130:$str="连接数据库失败，没有连接数据库的权限";
			break;
		case 1133:$str="数据库用户不存在";
			break;
		case 1141:$str="当前用户无权访问数据库";
			break;
		case 1142:$str="当前用户无权访问数据表";
			break;
		case 1143:$str="当前用户无权访问数据表中的字段";
			break;
		case 1146:$str="数据表不存在";
			break;
		case 1147:$str="未定义用户对数据表的访问权限";
			break;
		case 1149:$str="SQL语句语法错误";
			break;
		case 1158:$str="网络错误，出现读错误，请检查网络连接状况";
			break;
		case 1159:$str="网络错误，读超时，请检查网络连接状况";
			break;
		case 1160:$str="网络错误，出现写错误，请检查网络连接状况";
			break;
		case 1161:$str="网络错误，写超时，请检查网络连接状况";
			break;
		case 1062:$str="字段值重复，入库失败";
			break;
		case 1169:$str="字段值重复，更新记录失败";
			break;
		case 1177:$str="打开数据表失败";
			break;
		case 1180:$str="提交事务失败";
			break;
		case 1181:$str="回滚事务失败";
			break;
		case 1203:$str="当前用户和数据库建立的连接已到达数据库的最大连接数，请增大可用的数据库连接数或重启数据库";
			break;
		case 1205:$str="加锁超时";
			break;
		case 1211:$str="当前用户没有创建用户的权限";
			break;
		case 1216:$str="外键约束检查失败，更新子表记录失败";
			break;
		case 1217:$str="外键约束检查失败，删除或修改主表记录失败";
			break;
		case 1226:$str="当前用户使用的资源已超过所允许的资源，请重启数据库或重启服务器";
			break;
		case 1227:$str="权限不足，您无权进行此操作";
			break;
		case 1235:$str="MySQL版本过低，不具有本功能";
			break;
		default:$str="请检查数据";
	}
	return $str;
}
