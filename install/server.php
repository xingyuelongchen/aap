<?php

date_default_timezone_set("PRC");
$arr = $_POST["name"];
//数据库地址
$mysql_href = $arr['sql_host'];
//数据库名
$mysql_name = $arr['sql_name'];
//数据库用户账户
$mysql_user = $arr['sql_user'];
//数据库用户密码
$mysql_pass = $arr['sql_pass'];
//管理员账户和密码
$admin_user = $arr['admin_user'];
$admin_pass = md5($arr['admin_pass']);
$time = time();

//写入数据库配置信息
$myfile = fopen("../config/mysql.config.php",'w') or die("文件读取或写入错误");
$a="'utf8'";
$text = "<?php
		define('DB_HOST','{$mysql_href}');
		define('DB_USER','{$mysql_user}');
		define('DB_PWD','{$mysql_pass}');
		define('DB_DBNAME','{$mysql_name}');
		define('DB_CHARSET','utf8');"
		.'
		function connect(){
			if(!$sql_link= mysqli_connect(DB_HOST,DB_USER,DB_PWD)){
				die("数据库连接错误：");
			}
		mysqli_set_charset($sql_link,DB_CHARSET);
		mysqli_select_db($sql_link,DB_DBNAME) or die("指定数据库打开失败 Error:".mysqli_error());
			return $sql_link;
}';
//数据库信息
fwrite($myfile,$text);
fclose($myfile);
//创建数据库
$sql_link= mysqli_connect("$mysql_href","$mysql_user","$mysql_pass");
if(!mysqli_select_db($sql_link,$mysql_name)){
	if(!mysqli_query($sql_link,"create database $mysql_name")){
		die("create Error:".mysqli_error($sql_link));
	}
}else{
	echo'删除数据库';
}
mysqli_close($sql_link);

//连接数据库
include '../config/mysql.config.php';

	$table_user = "create table user_Info(
			id int NOT NULL AUTO_INCREMENT,
			PRIMARY KEY(id),
			name varchar(20),
			password varchar(255),
			type int(5),
			phone varchar(20),
			ltd varchar(40),
			creditCode varchar(20),
			faren varchar(24),
			license varchar(255),
			email varchar(40),
			time int(100)
		)";
	$table_admin = "create table admin(
			id int NOT NULL AUTO_INCREMENT,
			PRIMARY KEY(id),
			name varchar(24),
			pass varchar(40),
			type int(5),
			time datetime
		)";
	$order_list="create table order_list(
			id int not null auto_increment,
			primary key(id),
			uid int(20),
			userId int(20),
			num varchar(40),
			productName varchar(40),
			productNum int(6),
			productNums int(2),
			productSpec varchar(40),
			shippingDate date,
			demand varchar(100),
			typeOfShipping varchar(20),
			destination varchar(40),
			imgId varchar(40),
			jieshao varchar(100),
			peijian varchar(50),
			time int(100),
			order_state int(1),
			other varchar(2)
		)";
	$order_img_list="create table order_img_list(
			id int not null auto_increment,
			primary key(id),
			orderId int(20),
			imgType varchar(30),
			imgPath varchar(200),
			time int(100),
			other varchar(2)
		)";
$sql_con=connect();
//初始化数据库表
if($sql_con){
	//生成用户表
	mysqli_query($sql_con,$table_user);
	//创建超级管理员
	mysqli_query($sql_con,"insert into user_info(id,name,password,type,time) values('null','".$admin_user."','".$admin_pass."','0','".$time."')");
	//生成订单数据表
	if(!mysqli_query($sql_con,$order_list)){
		die('error:'.mysqli_error($sql_con));
	}
	//创建图片数据表
	mysqli_query($sql_con,$order_img_list);
	//断开数据库连接
	mysqli_close($sql_con);
	$bool=true;
}
if($bool){
	
//防误装文件
	$install = fopen("../config/install.BAK",'w');
	
	$a = array();
	fclose($install);
	$a["state"]='ok';
	$a["href"]='index.php';
	$a=json_encode($a);
	echo $a;
}
?>