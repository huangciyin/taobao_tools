<?php
	include 'config.php';
	if (isset($_GET['top_session'])&&!empty($_GET['top_session'])) {
		$_SESSION['topsession']=$_GET['top_session'];
		header("location: http://".$_SERVER["SERVER_NAME"]."/index.php");
	}else{
		echo "error";
	}
?>