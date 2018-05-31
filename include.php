<?php
date_default_timezone_set("PRC");
session_start();
define("ROOT",dirname(__FILE__));
set_include_path(".".PATH_SEPARATOR.ROOT."/lib".PATH_SEPARATOR.ROOT.'/functions'.PATH_SEPARATOR.ROOT.'/config'.PATH_SEPARATOR.get_include_path());
require_once 'config.php';//整站公共配置
require_once 'functions.php';//整站公共函数库
require_once 'captcha.class.php';//产生验证码
require_once 'mysql.config.php';//数据库配置
require_once 'query_sql.php';//数据库操作
require_once 'upfile.class.php';//文件操作
require_once 'upImage.php';//图像操作
