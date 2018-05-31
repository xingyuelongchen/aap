<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>document</title>
<link href="style/base.css" rel="stylesheet" type="text/css"/>
<link href="style/reset.css" rel="stylesheet" type="text/css" />
<link href="style/<?php echo $val ?>.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<div class="logo w1226">
		<h1><a href="index.php" title="logo"><img src="images/logo.png" alt="logo" width="210px" height="120px"/></a></h1>
	</div>
	<div class="content w1226 max_height">
		<div class="con_input">
			<div class="con_login">
				<form method="post" enctype="multipart/form-data">
					<table cellpadding="0" cellspacing="0" width="100%" class="login_table" id="input">
						<tr>
							<td align="right">账号:</td>
							<td>
								<input class="input_w" type="text" placeholder="输入账号..." value="" name="username" />
							</td>
							<td align="left"><i class="info"></i></td>
						</tr>
						<tr>
							<td align="right">密码:</td>
							<td>
								<input class="input_w" type="password" placeholder="输入密码..." value="" name="password" />
							</td>
							<td align="left"><i class="info"></i></td>
						</tr>
						<tr>
							<td align="right">验证码:</td>
							<td>
								<input class="input_w" type="text" placeholder="验证码..." value="" name="captcha" />
							</td>
							<td align="left">
								<i class="info"></i>
							</td>
						</tr>
						<tr>
						
							<td align="right"></td>
							<td>
								<a href="#" id="fun"><img src="functions/captcha.php" id="captcha" alt="captcha"/></a>
							</td>
							<td align="left">
							</td>
						
						</tr>
						<tr>
							<td colspan="3" align="center" style="width:600px;">
								<input class="input_w" type="button" value="立即登录" />
							</td>
						</tr>
						<tr>
							<td colspan="3" align="center" style="width:600px;">
							<input type="checkbox" checked="checked" onclick="" name="login_checked" id="login_checked"/>
							<lable for="login_checked">记住登陆</lable>
							<a href="index.php?act=changePassword">忘记密码</a>
							<a href="index.php?act=register">立即注册</a>
							</td>
						</tr>
					</table>
				</form>
			</div>
		</div>
		<div class="con_input">
			<!--登陆页图片展示位-->
		</div>
	</div>
	
	<script>
		document.getElementById('fun').onclick=fun;
		function fun(){
			document.getElementById('captcha').src='functions/captcha.php#'+Math.random();
		}
	
	</script>

