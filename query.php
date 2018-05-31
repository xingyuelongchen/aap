<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:POST');
header('Access-Control-Allow-Headers:x-requested-with,content-type');
include('include.php');

//获取上传过来的数据
$state = $_REQUEST;

$act = @$state['act'];
//验证登录状态
$sessionId = @$_COOKIE['name'];
if($act=='register' || $act =='login'){
}elseif($_SESSION[$sessionId] != 'ok'){
	//print_r($_SESSION);
	echo '非法访问！';
	header('location:index.php');
}

// 判断相应操作
//print_r($state);
switch($act){
	case $act=="upfiles":
		upfiles($state['local'],$state['order_num'],$state['type']);
		break;
	case $act=='login':
		login($state);
		break;
	case $act =='time':
		datatime($state);
		break;
	case $act =='date':
		datatime($state);
		break;
	case $act =='order':
		order($state);
		break;
	case $act =='num':
		num();
		break;
	case $act =='register':
		register_a($state);
		break;
	case $act =='search':
		search($state);
		break;
	case $act =='order_table':
		order_table($state);
		break;
}

function order_table($arr){
	$a = $arr['length'];
	$user_id = $_SESSION['userId'];
	$lists;
	$b=0;
	$text = query('order_list',"userId ={$user_id} and order_state=1",'ORDER BY shippingDate');
	while($list = mysqli_fetch_array($text)){
		if($list){
			$img = query('order_img_list',"orderId={$list['uid']} and imgType='img'");
			$img = mysqli_fetch_array($img);
			$list['order_img']=$img['imgPath'];
			$lists[$b]=$list;
			$b++;
		}
	}
	if($lists){
		
		$reg['state']=true;
		$reg['info']=json_encode($lists);
	}else{
		$reg['state']=false;
		$reg['info']='查询出错';
	}
	$reg = json_encode($reg);
	print_r($reg);
}


// print_r($state);
//首页搜索框
function search($arr){
	$order_num = $arr['order'];
	if(is_numeric($order_num)){
		$text = query('order_list',"uid={$order_num}");
		$text = mysqli_fetch_array($text);
		if($text){
			$reg['state']='true';
			$reg['info'] = $text;
		}else{
			$reg['state']='false';
			$reg['info']='查询不到该单号记录，请重新输入';
			$reg['error']="验证单号是否为数字";
		}
	}else{
		$reg['state']='false';
		$reg['info']='单号有误，请输入数字';
		$reg['error']="验证单号是否为数字";
	}
	$reg = json_encode($reg);
	print_r($reg);
}

//保存文件到相关位置
/**
* $local	string	相关操作，用来作为储存数据到相关位置的标识符
*
*
*/
function upfiles($local,$order_num,$arr,$sql_table,$type=null){
	$path = $local.'/'.$order_num;
		$upFileInfo = upfile($arr,$path);
		
		$arr=[
		'orderId'=>$order_num,
		'time'=>time()
		];
		if($upFileInfo){
			//保存后读取文件状态，判断是否保存成功
			foreach($upFileInfo as $a=>$b){
				$img=[];
				if($b[0]){
					$value[$a] = $b[1];
					$img[$type]=$value;
					$arr['imgType']=$type;
					$arr['imgPath']=json_encode($value);
				}else{
					print_r("文件保存错误");
				}
			}
			$a= insert($sql_table,$arr);
		}
		//$arr = json_encode($arr);
		//print_r($a);
		return $a;
	
}
//注册信息验证
function register_a($arr){
	$arr['password']=md5($arr['password2']);
	// $arr['act']="";
	// $arr['password1']="";
	// $arr['password2']="";
	unset($arr['act']);
	unset($arr['password1']);
	unset($arr['password2']);
	$arr['time']=time();
	// print_r($arr);
	
	//对比数据库注册信息是否重复
	$bool=true;
	if($arr){
		if($a=query('user_info',"name='{$arr['name']}'")){
			while($list_b = mysqli_fetch_array($a)){
				$aa = $list_b['name']==$arr['name']?true:false;
				if($aa){
					$reg['state']='false';
					$reg['info'] = '注册失败,用户名重复';
					$bool=false;
					$reg = json_encode($reg);
					print_r($reg);
					return;
				}
			}
		}
		if($b=query('user_info',"phone='{$arr['phone']}'")){
			while($list_c = mysqli_fetch_array($b)){
				$bb = $list_c['phone']==$arr['phone']?true:false;
				if($bb){
					$reg['state']='false';
					$reg['info'] = '注册失败,手机号重复';
					$bool=false;
					$reg = json_encode($reg);
					print_r($reg);
					return;
				}
			}			
		}
		
	}
	//开始注册
	if($bool){
		$reg['state']=insert('user_info',$arr);
		$reg['info'] = '注册成功,即将跳转登陆';
	}
	$reg = json_encode($reg);
	print_r($reg);
}
//登陆信息验证
function login($arr){
	$name = $arr['username'];
	// echo $name;
	// exit;
	$pass = md5($arr['userpwd']);
	$capcha = strtolower($arr['usercapcha']);
	$capcha = (@$_SESSION["yzm"]==$capcha?1:null);
	//print_r($name);
	//print_r($capcha);
	
	if($aa=query('user_info',"name='{$name}'")){
		 $list= mysqli_fetch_array($aa);
		 // print_r($list);
		//echo $list['pass']." : ".$pass;
		$a = $list['name']==$name?true:false;
		$b = $list['password']==$pass?true:false;
		//print_r($a);
	}
	
	if((!$a) || (!$b)){
		echo '1';//账号或密码错误
	}elseif(!$capcha){
		echo '2';//验证码错误
	}else{
		
		$_SESSION[session_id()]="ok";
		$_SESSION['name']=$name;
		$_SESSION['userId']=$list['id'];
		$_SESSION['userType']=$list['type'];
		setcookie('name',session_id(),time()+1200);
		 echo $_SESSION[session_id()];
	}
	
}

//获取时间
 function datatime($arr){
		date_default_timezone_set( "PRC" );
		function datea( $vals ) {

			if ( $vals == 'date' ) {
				//echo '2018-3-4';
			echo date('Y年m月d日');
		// echo $_SESSION['userId'];
			} elseif ( $vals == 'time' ) {
				print_r(date( 'H:i:s' ));
			}
		}

		
		$name = $arr[ 'act' ];
		if ( $name == 'time' ) {
			datea('time');
		  }elseif( $name == 'date' ){
			datea('date');
		}

 }
 
 
 //订单处理==============================
 //获取单号
function num(){
	date_default_timezone_set('PRC');
	// $link=connect();
	// $sql_text = "SELECT max(id) as max_id FROM `order_list`";
	// $d = mysqli_query($link,$sql_text);
	$d = query('order_list',null,null,'max(id) as max_id');
	$e = mysqli_fetch_array($d);
	// print_r($e);
	$id = $e['max_id']+1;
	if($id<=9){
		$num = date("ymd").'0'.$id;
	}else{
		$num = date("ymd").($e['max_id']+1);
	}
	// print_r($num);
	return $num;
}

//处理订单数据
function order($arr){
	$name = $_SESSION['name'];//获取当前登陆用户名
	$id = $_SESSION['userId'];//获取用户ID
	$arr['uid']= num();//生成单号
	$arr['userId']=$id;
	date_default_timezone_set('PRC');
	$arr['time']=time();
	$arr['order_state']=1;
	//$arr['shippingDate']=strtotime("{$arr['shippingDate']}");
	if($images = $_FILES){ //获取提交的文件
		$keys = array_keys($images); //多文件获取名称
		for($i=0;$i<count($keys);$i++){
			//$reg['length'] =$keys[$i];调试每个类型是否有多个文件
			for($j=0;$j<count($keys[$i]);$j++){
				$val = upfiles($arr['act'],$arr['uid'],$images[$keys[$i]],'order_img_list',$keys[$i]);//根据类保存上传的文件
			 }
		}
	}
	//print_r($val);
	unset($arr['act']);
	if($val>0 && $a=insert('order_list',$arr)){//保存订单信息
		$reg['state']='true';
		$reg['data']="下单成功，单号为:{$arr['uid']}";
		//print_r($arr);
	}else{
		$reg['state']='false';
		$reg['data']='下单失败！';	
	}
	//$reg['arr']=$arr;
	
	$reg = json($reg);
	print_r($reg);
}

		//print_r($_SESSION); 
		//SELECT name FROM admin UNION ALL SELECT name FROM user_info 
?>