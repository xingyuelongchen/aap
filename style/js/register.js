var odiv = document.getElementById('input');
var	inputs = document.getElementsByClassName("input_w");
inputs[inputs.length-1].onclick = function(){
	register();
}
document.onkeyup=function(event){
	var e=event?event:window.event;
	if(e.keyCode==13){
		register();
	}
};
function register(){
	var arr='{',
		a=false;
	for(i=0;i<inputs.length-1;i++){
		if(inputs[i].value){
			arr += '"'+inputs[i].name+'":"'+(inputs[i].value?inputs[i].value:" ")+'",';
			a=true;
		}else{
			a=false;
			break;
		}
	}
	var exp = /(,)(?!.*\1)/;//删除字符串最后一个逗号；
	var email_exp = /[\w]+@\w+\.\w+/;
	var password_exp = /[^\w]+/;
	arr = arr.replace(exp,'');
	arr +='}';
	arr = JSON.parse(arr);
	if(a){
		if(arr['phone'].length == 11){
			if(email_exp.test(arr['email'])){
				if(!(password_exp.test(arr['password1']))){
					if((arr['password1'] === arr['password2']) && (arr['password1'].length>=6)){
						
						var data = text_Ajax(arr,'register')['data'];
						data = JSON.parse(data);
						
						if(data['state']==false){
							alertErr(data['info'],false);
						}else{
							function fn(bool){
									if(bool){
										window.location.href='index.php';
									}
								}
							alertErr(data['info'],false,fn);
						}
					}else{
						alertErr('两次密码不一致或小于6位字符',false);
					}
				}else{
					alertErr('密码由字母和数字组成',false);
				}
			}else{
				alertErr('请输入正确的邮箱账号',false);
			}
		}else{
			alertErr('请输入正确的手机号码',false);
		}
	}else{
		alertErr('请将信息填写完整',false);
	}
}