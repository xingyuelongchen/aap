// JavaScript Document
var inputs = document.getElementsByClassName("input_w");
inputs[inputs.length-1].onclick=function(){
	login();
};
document.onkeyup=function(event){
	var e=event?event:window.event;
	if(e.keyCode==13){
		login();
	}
};
for(var i=0;i<inputs.length-1;i++){
	inputs[i].onfocus=state;
}
function state(a){
	this.removeAttribute('style');
}
function login(){
	alertErr('正在登陆……');
	function fn(bool){
		if(bool){
			window.location.href='index.php';
		}
	}
	var userName = inputs[0].value,
		userPwd	= inputs[1].value,
		userCapcha	= inputs[2].value;
	var arr={'username':userName,'userpwd':userPwd,'usercapcha':userCapcha};
	var data = text_Ajax(arr,'login')['data'];
	//console.log(data);
	// var data = upajax(arr,'login')['data'];
	
	if(data == 'ok'){
		alertErr('登陆成功!',false,fn);	
	}else if(data == '1'){
		inputs[0].style.borderColor='red';
		inputs[1].style.borderColor='red';
		alertErr('账户或密码错误！',true)
	}else if(data == '2'){
		inputs[2].style.borderColor='red';
		alertErr('验证码错误!');
	}else{
		inputs[0].style.borderColor='red';
		inputs[1].style.borderColor='red';
		inputs[2].style.borderColor='red';
		alertErr('登陆失败！');
	}
	
}
