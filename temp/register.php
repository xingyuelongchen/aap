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
								<input class="input_w" type="text" placeholder="设置账号..." value="" name="name" />
							</td>
							<td align="left"><i class="info"></i></td>
						</tr>
						<tr>
							<td align="right">密码:</td>
							<td>
								<input class="input_w" type="password" placeholder="设置密码..." value="" name="password1" />
							</td>
							<td align="left"><i class="info"></i></td>
						</tr>
							<tr>
							<td align="right">确认密码:</td>
							<td>
								<input class="input_w" type="password" placeholder="确认密码..." value="" name="password2" />
							</td>
							<td align="left"><i class="info"></i></td>
						</tr>
						</tr>
							<tr>
							<td align="right">手机号码:</td>
							<td>
								<input class="input_w" type="tel" placeholder="请输入11位手机号码..." value="" name="phone" />
							</td>
							<td align="left"><i class="info"></i></td>
						</tr></tr>
							<tr>
							<td align="right">邮箱:</td>
							<td>
								<input class="input_w" type="text" placeholder="请输入常用邮箱..." value="" name="email" />
							</td>
							<td align="left"><i class="info"></i></td>
						</tr>
						
						<tr>
							<td colspan="3" align="center" style="width:600px;">
								<input class="input_w" type="button" value="立即注册" />
							</td>
						</tr>
						<tr>
							<td colspan="3" align="center" style="width:600px;">
							<input type="checkbox" checked="checked" onclick="" name="login_checked" id="login_checked"/>
							<lable for="login_checked">我已阅读并同意用户协议  </lable>
							<a href="index.php?act=login">已有账号，立即登陆！</a>
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
	

