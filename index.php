<?php
header('centent-type:text/html;charset=utf-8');
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST');
header('Access-Control-Allow-Headers:x-requested-with,content-type');
if(!file_exists("config/install.bak")){
	echo '本程序未安装，请访问install目录启动安装程序,<a href="install/index.php">点击安装</a>';
	exit;
}
//调用路由文件
include 'include.php';



//获取登录用户权限

$user_type = @$_SESSION['userType']; //0= 管理	1= 业务	2= 跟单	3=财务	
// print_r($_SESSION);
// exit;
$arr = $_REQUEST;
$val = @$arr['act'] ? $arr['act'] : 'content';

/*验证是否登录*/
$a=@$_COOKIE['name'];
$b=@$_SESSION["$a"];
//print_r($_COOKIE);
//var_dump($a);exit;
if(@$b!='ok' && !($val =='login' || $val == 'register')){
	if(!@$_SESSION["$a"]){
		
		$val="login";
	}
}else if($a=@$_COOKIE['name']){
	setcookie('name',$a,time()+1200);
}
//退出登陆状态
if($val=='loginout'){
	$_SESSION[session_id()]="";
	$_SESSION['name']='';
	$_SESSION['userId']='';
	setcookie('name',session_id(),time()-1,' ',DOMAIN);
	header("location:index.php");
}

//切换导航
if ( $val == 'login' || $val == 'register' ) {
	require_once "temp/{$val}.php";
	require_once 'temp/footer.php';
	exit;
} else {
	
	if ( $user_type == 0 || $user_type == 1) {
		require_once 'temp/header_nav.php';
	} elseif ( $user_type == 2 ) {
		require_once 'temp/header_nav2.php';
	} elseif ( $user_type == 3 ) {
		require_once 'temp/header_nav3.php';
	}

}

switch ( $val ) {
	case $val == 'order': //下单
		require_once "temp/{$val}.php";
		break;
	case $val == 'manage': //管理员页面
		require_once "temp/{$val}.php";
		break;
	case $val == 'download': //资料下载
		require_once "temp/{$val}.php";
		break;
	case $val == 'smalltool': //小工具
		require_once "temp/{$val}.php";
		break;
	case $val == 'content': //业务总览内容
		require_once "temp/{$val}.php";
		break;
	case $val == 'changePassword': //修改密码
		require_once "temp/{$val}.php";
		break;
	case $val == 'info': //修改密码
		require_once "temp/{$val}.php";
		break;
	case $val == 'fun': //
		header("location:functions/fun.php?act=time&con={$arr['name']}");
		break;
	default:
		echo $val.'act参数错误';
		break;
}


require_once 'temp/footer.php';
?>