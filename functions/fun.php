<?php
/**
 * 根据单号查询订单
 *$a 接收传递的单号
 */
date_default_timezone_set( "PRC" );
$arr = $_REQUEST;
$name = $arr[ 'act' ];
if ( $name == 'time' ) {
	dateTime( $arr[ 'con' ] );
}

function dateTime( $vals ) {

	if ( $vals == 'date' ) {
		echo date( 'Y年 m月 d日' );
	} elseif ( $vals == 'time' ) {
		echo date( 'H:i:s' );
	}
}

function search( $a ) {
	$a = $a ? strtolower( $a ) : '不能为空';
	echo( $a );
}
?>