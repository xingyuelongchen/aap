
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>无标题文档</title>
<style type="text/css">
	html,*{
		margin:0;padding:0;border:0;color:#444;
	}
	span{
		display: block;
		width:500px;
		margin: 0 auto;
		text-align: center;
	}
	label{
		width:220px;
		margin:10px;
		text-align: right;
		line-height: 40px;
	}
	input[type=text]{
		width:220px;
		height:35px;
		line-height: 35px;
		border:1px solid #ccc;
		border-radius:5px;
		text-indent:5px;
	}
	input[type=button]{
		width:220px;
		height: 40px;
		border:1px solid #ccc;
		border-radius:5px;
		margin:10px auto;
	}
	input[type=button]:hover{
		box-shadow: 0 0 5px #444;
		cursor:pointer;
	}
	#info{
		display:none;
	}
	</style>
	<script src="../style/js/jquery.js"></script>
</head>
<?php
if(file_exists("../config/install.BAK")){
	echo "本程序已安装,如果需要重新安装请删除config目录下的 install.BAK 文件<a href='../index.php'>返回首页</a>";
}else{
	echo '


<body>
<span><label>数据库地址：</label><input type="text" value="" id="mysql_host" placeholder="默认为：localhost"></span>
<span><label>数据库名称：</label><input type="text" value="" id="mysql_name" placeholder="默认为：erp_cms"></span>
<span><label>数据库账号：</label><input type="text" value="" id="mysql_user" placeholder="默认：root"></span>
<span><label>数据库密码：</label><input type="text" value="" id="mysql_pass" placeholder="默认：root"></span>
<span><label>管理员账号：</label><input type="text" value="" id="admin_user" placeholder="默认：admin"></span>
<span><label>管理员密码：</label><input type="text" value="" id="admin_pass" placeholder="请设置密码"></span>
<span><label>请确认密码：</label><input type="text" value="" id="admin_pass_ok" placeholder="请确认密码"></span>
<span><input type="button" value="提交" id="btn"></span>
<span id="info">创建完成！</span>
	
<script>
	
function byid(id){
	return typeof id ==="string"?document.getElementById(id):"id";
}	
	var mysql_host = byid("mysql_host"),
		mysql_name = byid("mysql_name"),
		mysql_user = byid("mysql_user"),
		mysql_pass = byid("mysql_pass"),
		admin_user = byid("admin_user"),
		admin_pass = byid("admin_pass"),
		admin_pass_ok = byid("admin_pass_ok"),
		btn = byid("btn"),
		info = byid("info");
	
	btn.onclick = function(){
		var sql_host = (mysql_host.value || "localhost"),
			sql_name = (mysql_name.value || "erp_cms"),
			sql_user = (mysql_user.value || "root"),
			sql_pass = (mysql_pass.value || "root"),
			ad_user = (admin_user.value || "admin"),
			ad_pass = admin_pass.value,
			ad_pass_ok = admin_pass_ok.value;
		var exp = /^[\w+]{4,20}$/;
		if((ad_pass != ad_pass_ok) ||  !exp.test(ad_pass) || !exp.test(ad_pass_ok) || (ad_pass_ok.toString().length <= 4)){
			admin_pass_ok.style.border = "1px solid red";
			admin_pass_ok.value = "";
			admin_pass_ok.placeholder = "请输入字母或数字";
			admin_pass_ok.onkeydown = function(){
				this.setAttribute("style","");
			}
			return;
		}
		var arr = {
			"sid":"install",
			"sql_host":sql_host,
			"sql_name":sql_name,
			"sql_user":sql_user,
			"sql_pass":sql_pass,
			"admin_user":ad_user,
			"admin_pass":ad_pass
		};
		Ajax(arr);
		
		
	}
	var ajax_data;
	function Ajax(arr){
			$.ajax({
				type:"post",
				url:"server.php",
				async:true,
				dataType:"json",
				data:{
					"name":arr
				},
				success:function(data){
					ajax_data=data;
						if(ajax_data.state === "ok"){
							info.style.display = "block";
							info.style.color = "green";
							info.style.fontSize = "24px";
							setTimeout(a,1500);
							function a(){
								window.location.href = ajax_data.href;
							}
						}
						if(ajax_data.state === "false"){
							console.log(ajax_data.error)
						}
				},
				error:function(error){
					console.log(error);
				}
				
			});
		}
</script>
</body>
';}
?>
</html>