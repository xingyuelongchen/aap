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
window.onload=function(){
	setTimeout(GetDate,1);
}