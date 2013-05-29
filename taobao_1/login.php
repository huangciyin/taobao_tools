<?php
	include 'config.php';

	if (isset($_GET['top_session'])&&!empty($_GET['top_session'])) {
		// setcookie("sessionKey", $_GET['top_session'], time()+3600);
		$_SESSION['topsession'] = $_REQUEST['top_session'];

		$user_req = new UserSellerGetRequest;
		$user_req->setFields("user_id");
		$user_resp = $c->execute($user_req, $_GET['top_session']);
		$uID=$user_resp->user->user_id;

		// setcookie("uID" , $uID , time()+3600);
		$_SESSION['uID'] = $uID;
		header("location: http://".$_SERVER["SERVER_NAME"]."/index.php");
	}elseif (empty($sessions)) {
		header("location:".$sessionurl."");
	}else{
		echo "error";
	}
?>
