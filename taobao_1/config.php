<?php
	include 'TopSdk.php';
	require_once 'function.php';
	require_once 'page.class.php';

	$sessionKey="610210283b16fed9d81a2d975806d692d36cb352afd19142074082786";
	$appkey="1021409528";
	$secretKey="sandbox31b961e472f864b1c17ebd4ba";
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