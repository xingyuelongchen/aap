<?php

include_once('../include.php');
unset($_SESSION['yzm']);
$config = array(
		'fonts'=>ROOT.'/fonts/consola.ttf',
		'width'=>170,
		'height'=>50,
		'size'=>0,
		'length'=>4,
		'type'=>2
	);

$aa = new Captcha($config);
$yzm = $aa->getcaptcha();
$yzm=strtolower($yzm);
$_SESSION["yzm"]=$yzm;