   // JavaScript Document
var localhost = window.location.host;
//header();
/**
导航页  用户信息控制
*/
function header(){
	var user = $('.user_img')[0];
	var userManage = $('.user_img_manage')[0];
	if(user&&userManage){
		user.onmouseover=function(){
			userManage.style.display='block';
		};
		user.onmouseout=function(){
			userManage.style.display='none';
		};
	}
}
header();
/**
 * 公用交互接口
 */



/* 导航接口
 * act		string	//需要访问的类型
 * type		string	//需要做的操作
 * arr		string	//需要提交的内容
 * return string
 */
function Ajax(act, type, arr) {
	var ajaxdata =[];
	if (!act) {
		ajaxdata['error'] = 'act参数错误';
	}
	$.ajax({
		url:  'index.php?act=' + act + '&con=' + type,
		type: 'post',
		async: false,
		datatype: 'text/json',
		data: {
			"name": arr
		},
		success: function (data) {
			ajaxdata['data'] = data;
		},
		error: function (error) {
			return error;
		}
	});
	return ajaxdata;
}

/*  上传文件接口
 *	arr		object		需要上传的数据
 *	local	string		通过什么操作上传本次数据。服务端确定保存位置
 *	return 	object		服务端返回的数据	
 
function upfile(arr,order_num,local,type) {
	if(!arr){
		return '请传入正确的参数';
	}
	var ajaxdata =[];
		var FormDate= new FormData();
		FormDate.append("act","upfiles");
		FormDate.append("local",local);//文件顶级目录
		FormDate.append("order_num",order_num);//订单编号
		FormDate.append("type",type);//图片归类
		for(var i=0;i<arr.length;i++){
			FormDate.append(i,arr[i]);
		}
		console.log(FormDate);
		 $.ajax({
			url: "query.php",
			type: "POST",
			processData: false,
			contentType: false,
			data: FormDate,
			success: function(d) {
				ajaxdata['data']=d;
				console.log(d);
			 },
			error:function(XMLHttpRequest,textStatus){
				console.log(XMLHttpRequest.readyState+"  ;  "+XMLHttpRequest.status+"  ;  "+textStatus);
			}
		 });
}
*/
//文本操作接口
/* act	string	获取需要数据的标识
 * arr	string	上传内容
 *
 *
 */
function text_Ajax(arr,act,type) {
	var ajaxdata =[];
	type = type?type:'text';
	if (!act) {
		ajaxdata['error'] = 'act参数错误';
	}
	$.ajax({
		
		url:  'query.php?act='+act,
		type: 'post',
		async: false,
		datatype: type,
		data: arr,
		success: function (data) {
			ajaxdata['data'] = data;
			// console.log(data);
		},
		error: function (error) {
			return error;
		}
	});
	return ajaxdata;
}
function upajax(arr,act) {
	var ajaxdata =[];
	if (!arr) {
		ajaxdata['error'] = 'upajax(arr)参数错误';
	}
	$.ajax({
		
		url:  'query.php?act='+act,
		type: 'POST',
		async: false,
		processData: false,
		contentType: false,
		data: arr,
		success: function (data) {
			ajaxdata['data'] = data;
			//console.log(data);
		},
		error: function (error) {
			return error;
		}
	});
	return ajaxdata;
}

/*生成json格式数据*/
function json(a,b){
	
}



/**
*站点弹窗展示控制模块
* text type= document 	显示的内容
* bool type= boolean 	是否需要返回boolean值
* return type= boolean 	返回用户相应选择的Boolean值
*/
function alertErr(text,bool,fn) {
	var box = $('.alert_info')[0];
	var textbox = $('.alert_info_text')[0];
	var buttons = $('.alert_info_button')[0].getElementsByTagName('input');
	box.style.display = 'block';
	textbox.innerHTML=text;
	if (bool) {
		buttons[1].type = 'button';
		buttons[0].addEventListener('click',function () {box.style.display = 'none';if(fn){fn(true)}});
		buttons[1].addEventListener('click',function () {box.style.display = 'none';
		if(fn){fn(false)}});
		setTimeout(function(){
			buttons[0].onclick();
		},5000)
	} else {
		buttons[1].type = 'hidden';
		buttons[0].onclick = function () {
			box.style.display = 'none';
			if(fn){fn(true)};
		}
		setTimeout(function(){
			buttons[0].onclick();
		},5000)
	}
}
