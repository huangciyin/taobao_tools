<?php
	include 'TopSdk.php';
	require_once 'function.php';
	require_once 'page.class.php';


	$sessionKey="61003181ca0b393ce04e1859f812d517de225e365dd29872054718218";
	$appkey="1021409528";
	$secretKey="sandbox31b961e472f864b1c17ebd4ba";
	$format="json";
	if (isset($_GET['top_session'])&&!empty($_GET['top_session'])) {
		# code...
		$sessionKey=$_GET['top_session'];
	}

	$c=new TopClient;
	$c->appkey=$appkey;
	$c->secretKey=$secretKey;
	$c->format=$format;

	$user_req = new UserSellerGetRequest;
	$user_req->setFields("user_id");
	$user_resp = $c->execute($user_req, $sessionKey);
	$uID=$user_resp->user->user_id;

?>