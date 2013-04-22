<?php
	include 'TopSdk.php';
	require_once 'function.php';
	require_once 'page.class.php';

	$appkey="1021409528";
	$secretKey="sandbox31b961e472f864b1c17ebd4ba";
	// $appkey="21471780";
	// $secretKey="e6cb3726906df8959625196a4909ff95";
	$format="json";
	
	$c=new TopClient;
	$c->appkey=$appkey;
	$c->secretKey=$secretKey;
	$c->format=$format;
	
?>
