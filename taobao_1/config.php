<?php
	// error_reporting(0);
	session_start();

	include 'TopSdk.php';
	require_once 'function.php';
	require_once 'page.class.php';

	@$sessionKey=$_SESSION['topsession'];
	$appkey="1021409528";
	$secretKey="sandbox31b961e472f864b1c17ebd4ba";
	// $appkey="21471780";
	// $secretKey="e6cb3726906df8959625196a4909ff95";
	$format="json";

	$c=new TopClient;
	$c->appkey=$appkey;
	$c->secretKey=$secretKey;
	$c->format=$format;

	$user_req = new UserSellerGetRequest;
	$user_req->setFields("user_id");
	$user_resp = $c->execute($user_req, $sessionKey);
	$uID=$user_resp->user->user_id;
	


?>