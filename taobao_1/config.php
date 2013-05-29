<?php
	session_start();
	include 'TopSdk.php';
	require_once 'function.php';
	require_once 'page.class.php';

	$appkey="1021526590";
	$secretKey="sandbox16875fe78ef5c96fab51b96ca";
	// $appkey="21476727";
	// $secretKey="df0171fe9d200838b1518546a9dd6176";
	$format="json";
	
	$c=new TopClient;
	$c->appkey=$appkey;
	$c->secretKey=$secretKey;
	$c->format=$format;

	$sessions=$_SESSION['topsession'];
	$sessionurl = "http://container.api.tbsandbox.com/container?appkey=".$appkey;
	// $sessionurl = "http://container.api.taobao.com/container?appkey=".$appkey;
	
?>
