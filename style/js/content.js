/**
*
*
*
*
*/
function search(a){
	var vals=document.getElementById(a);
	var val=(vals.value)?vals.value:false;
	if(val){
		var arr={'order':val};
		var data = text_Ajax(arr,'search')['data'];
		//console.log(data);
		datas = JSON.parse(data);
		if(datas['state']=='true'){
			sessionStorage.setItem('order',data);
			window.location.href='index.php?act=info';
		}else if(datas['state']=='false'){
			alertErr(datas['info']);
			//console.log(datas['error']);
		}
	}else{
		vals.placeholder="请输入单号......";
	}
}
function GetDate(){
	var time_bj_yaer = $("#time_bj_yaer")[0];
	var time_bj_date = $("#time_bj_date")[0];
	//console.log(text_Ajax('time','date')['data']);
	time_bj_yaer.innerHTML= text_Ajax('time','date')['data'];
	time_bj_date.innerHTML= text_Ajax('time','time')['data'];
	setTimeout(GetDate,1000);
}
function GetOrderTable(){
	var arr={
		'length': 7
	};
	var data = text_Ajax(arr,'order_table','json')['data'];
	//console.log(data);
	if(data = JSON.parse(data)){
		//console.log(data);
		
		//var lists = new Array;
		if(data = JSON.parse(data['info'])){
			var leng = 7>data.length?data.length:7;
			var otr="<tr>";
			var oth = '<th>单号</th><th>名称</th><th>数量</th><th>规格</th><th>日期</th><th>地址</th><th>方式</th>';
			otr+=oth+'</tr>';
			for(var i=0;i<leng;i++){
				// console.log(data[i]);
				var text = data[i];
				var list=new Array;
				for(var k in text){
					if(k=='uid'||k=='productName'||k=='productNum'||k=='productSpec'||k=='shippingDate'||k=='destination'||k=='typeOfShipping'){
						list.push(text[k]);
					}
					var otd='<td>'+list[0]+'</td><td>'+list[1]+'</td><td>'+list[2]+'</td><td>'+list[3]+'</td><td>'+list[4]+'</td><td>'+list[6]+'</td><td>'+list[5]+'</td>';
				}
				otr += otd+'</tr>';
			}
			document.getElementById('order_table').innerHTML=otr;
			//console.log(otable);
		}else{
			console.log('Error:info信息json格式化失败');
		}
		
	}else{
		console.log(data);
	}
}
function GetOrderAllTable(){
		var arr={
		'length': 7
	};
	var data = text_Ajax(arr,'order_table','json')['data'];
	//console.log(data);
	if(data = JSON.parse(data)){
		//console.log(data);
		
		//var lists = new Array;
		if(data = JSON.parse(data['info'])){
			var leng = 10>data.length?data.length:10;
			var otr=" ";
			var exp=/(^\["|"]|")/g;
			for(var i=0;i<leng;i++){
				// console.log(data[i]);
				
				var text = data[i];
				var list=new Array;
				for(var k in text){
					//console.log(text['order_img']);
					if(text['uid']==18052012){
					//	console.log(typeof text['order_img']);
					}
					if(k=='uid'||k=='productName'||k=='productNum'||k=='productSpec'||k=='shippingDate'||k=='destination'||k=='typeOfShipping'||k=='order_state'||k=='order_img'||k=='other'){
						if(k=='order_img'){
							var a = text[k].replace(exp,' ');//用正则去掉保存时多余的数据
							a = a.split(',');//分割获取的数据，用来判断是否有多个图片
						
							if((typeof a)=="object"){//判断是否有多个图片
								var img='<img  alt="img" style="width:60px;height:60px;margin:1px" title="" src="';
								var imgs=' ';
								for(var len=0;len<(a.length>5?5:a.length);len++){//循环处理多张图片
									imgs+=img+a[len]+'"/>';//把多个图片放到img标签里面
								}
								text['order_img']=imgs;
							}
							//console.log(text[k]);
						}
						list.push(text[k]);
					}
					if(list[8]){
						list[8]='未发货';
					}
					var otd='<ul><li>'+list[8]+'</li><li><a href="query.php?act=manage&order_num='+list[0]+'">管理</a></li><li>'+list[0]+'</li><li>'+list[2]+'</li><li>'+list[9]+'</li><li>'+list[3]+'</li><li>'+list[10]+'</li><li>'+list[4]+'</li><li>'+list[6]+'</li><li>'+list[5]+'</li></ul>';
				}
				otr += otd;
			}
			//otr+='</ul>';
			//console.log(otr);
			document.getElementById('order_All_list').innerHTML=otr;
			//console.log(otable);
		}else{
			console.log('Error:info信息json格式化失败');
		}
		
	}else{
		console.log(data);
	}
}

window.onload=function(){
	setTimeout(GetDate,1);
	GetOrderTable();
	GetOrderAllTable();
}