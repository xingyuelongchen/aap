<?php
function json($arr){
	$json = json_encode($arr,JSON_UNESCAPED_SLASHES);
	return $json;
}