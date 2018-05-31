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
	var userName = inputs[0].value,
		userPwd	= inputs[1].value,
		userCapcha	= inputs[2].value;
	var arr={'username':userName,'userpwd':userPwd,'usercapcha':userCapcha};
	var a=text_Ajax('login',arr);
	console.log(a);
	// if(a['data']=='ok'){
		// console.log('aaaaa');
		// alertErr('ok');
	// }
}
