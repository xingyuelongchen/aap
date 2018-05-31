<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>无标题文档</title>
<link href="style/base.css" rel="stylesheet" type="text/css"/>
<link href="style/reset.css" rel="stylesheet" type="text/css" />
<link href="style/<?php echo $val ?>.css" rel="stylesheet" type="text/css" />
</head>

<body>
	<div class="header">
		<div class="w1226 top_nav">
			<div class="logo left">
				<h1><a href="index.php"><img src="../images/logo.png" alt="logo" width="130px" height="70px"/></a></h1>
			</div>
			<!--导航栏-->
			<div class="nav_list nav_ul left">
				<ul>
					<li><a href="index.php?act=manage">订单管理</a></li>
					<li><a href="index.php?act=download">资料下载</a></li>
					<li><a href="index.php?act=smalltool">小工具</a></li>
				</ul>
			</div>
			<!--用户信息栏-->
			<div class="user_info right">
				<ul id="user_login" style="display:block">
					<li class="user_img cursor">
						<div class="user_img_manage">
							<a href="index.php?act=user_set">设置</a>
							<a href="index.php?act=logout">退出</a>
						</div>
					</li>
					<li class="user_state"></li>
					<li id="user_state_name"><?php echo $_SESSION['name']?></li>
				</ul>
				<ul id="user_out" style="display:none">
					<li><a href="index.php?act=login">登陆</a></li>
					<li><a href="index.php?act=register">注册</a></li>
				</ul>
			</div>
		</div>
	</div>
	<!--下接内容页面-->