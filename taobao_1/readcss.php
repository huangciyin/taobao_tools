<?php

	require "conndb.inc.php";
	require_once 'config.php';
	// $sessionKey=$_COOKIE['sessionKey'];
	// $uID=$_COOKIE['uID'];

	if (empty($sessions)) {
		echo "please <a href='login.php'>login</a>";exit;
	}else{
		$sessionKey = $_SESSION['topsession'];
		$uID = $_SESSION['uID'];
	}

	if (isset($_GET['customexpress1'])) {
		# code...
		$result=$operatedb->Execsql("select customexpress1 from user where uID=".$uID."",$conn);
		$arr1=explode("px", $result[0]['customexpress1']);
		$i=0;
		while ($i <= 21) {
			# code...
			@$customexpress1.=$arr1[$i]."%";
			$i++;
		}
		echo $customexpress1;
	}elseif (isset($_GET['customexpress2'])) {
		# code...
		$result=$operatedb->Execsql("select customexpress2 from user where uID=".$uID."",$conn);
		$arr2=explode("px", $result[0]['customexpress2']);
		$i=0;
		while ($i <= 21) {
			# code...
			@$customexpress2.=$arr2[$i]."%";
			$i++;
		}
		echo $customexpress2;
	}elseif (isset($_GET['customexpress3'])) {
		# code...
		$result=$operatedb->Execsql("select customexpress3 from user where uID=".$uID."",$conn);
		$arr3=explode("px", $result[0]['customexpress3']);
		$i=0;
		while ($i <= 21) {
			# code...
			@$customexpress3.=$arr3[$i]."%";
			$i++;
		}
		echo $customexpress3;
	}
?>
