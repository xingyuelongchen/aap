// JavaScript Document
var inputs = document.getElementsByClassName('qd_num'),

	order_btn = $('.order_button')[0],	
	checks = $('.id')[0].getElementsByTagName('a');//获取配件清单
	order_btn.onclick = uporder;
//console.log(inputs)
//初始化材料清单选项
for(var i=0;i<checks.length;i++){
	checks[i].onclick = function(){
		cehcksdata(this)};
}
function cehcksdata(a){
	if(!a.getAttribute('data-style')){
		a.setAttribute('data-style','checked');
		a.setAttribute('class','checked');
		
	}else{
		a.removeAttribute('data-style')
		a.removeAttribute('class');
	}
}
//获取订单信息
function uporder(){
	var arr={
		'num':inputs[0].value,
		//'uid':order_num,
		'productName':inputs[1].value,
		'productNum':inputs[2].value,
		'productNums':inputs[3].value,
		'productSpec':inputs[4].value,
		'shippingDate':inputs[5].value,
		'demand':inputs[6].value,
		'img':document.getElementById("upfile_input1").files,
		'ai':$('#upfile_input2')[0].files,
		'xiaoguo':$('#upfile_input3')[0].files,
		'typeOfShipping':inputs[7].value,
		'destination':inputs[8].value,
		'peijian':inputs[9].value,
		'jieshao':inputs[10].value
		
	};
	var obj= new FormData();
	for(var key in arr){
		if(arr[key].length<1){
			alertErr('请将表格填写完整');
			return;
		}
		if(key=='img'||key=='ai'||key=='xiaoguo'){
			var val= new Array();
			//console.log(arr[key]);
			var len=arr[key].length;
			for(var i=0;i<len;i++){
				val= arr[key][i];
				obj.append(key+'[]',val);
			}
			continue;
		}
		obj.append(key,arr[key]);
	}
	//console.log(FormDate.getAll('ai'));
	//console.log(obj.getAll('img'));
	//console.log(obj.getAll('act'));
	state= upajax(obj,'order')['data'];
	// console.log(state);
	
	if(typeof state =='string'){
		state = JSON.parse(state);
	}
	if(typeof state!='array'){
		alertErr(state['data']);
	}
	
}
function ok(arr){
	
}
//显示待上传文件的文件名
function change(x,y){
	var obj = document.getElementById(x),
		val = document.getElementById(y),
		len = obj.files.length,
		i,
		temp;
	for(i=0;i<len;i++){
		if(temp){
			var temp = obj.files[i].name+','+temp;
		}else{
			var temp = obj.files[i].name;
		}
		
	}
	val.value = temp;
}


