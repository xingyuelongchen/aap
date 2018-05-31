<?php
		define('DB_HOST','localhost');
		define('DB_USER','root');
		define('DB_PWD','root');
		define('DB_DBNAME','aaa');
		define('DB_CHARSET','utf8');
		function connect(){
			if(!$sql_link= mysqli_connect(DB_HOST,DB_USER,DB_PWD)){
				die("数据库连接错误：");
			}
		mysqli_set_charset($sql_link,DB_CHARSET);
		mysqli_select_db($sql_link,DB_DBNAME) or die("指定数据库打开失败 Error:".mysqli_error());
			return $sql_link;
}