<?php
	function search($search){
		require_once 'config.php';
		$sessionKey=$_COOKIE['sessionKey'];
		$uID=$_COOKIE['uID'];
		global $sessionKey,$appkey,$secretKey,$format,$c,$operatedb,$uID,$conn;


		if (isset($search)&&!empty($search)){
			# code...
			$req = new TradesSoldGetRequest;
			$req->setFields("tid");
			$resp = $c->execute($req, $sessionKey);
			$len_tid=strlen($resp->trades->trade[0]->tid);
			if (is_numeric($search)) {
				# code...
				if (strlen($search)==11) {
					$result_page=$operatedb->Execsql("select count(uID) from orders where uID='".$uID."'",$conn);
					$pageCount=ceil($result_page[0][0]/40);

					$arr=array();

					$i=1;
					while ($i <= $pageCount) {

						$itemNum=($i-1)*40;
						$result=$operatedb->Execsql("select * from orders where uID='".$uID."' limit ".$itemNum.",40",$conn);

						$lastPage=ceil($result_page[0][0]/40);
						if ($i<$lastPage) {
							# code...
							$total=39;
						}elseif ($i==$lastPage) {
							# code...
							$total=$result_page[0][0]-($i-1)*40-1;

						}

						$j=0;
						while ($j <= $total) {
							# code...
							$req = new TradeFullinfoGetRequest;
							$req->setFields("receiver_mobile");
							$req->setTid($result[$j]['tID']);
							$resp = $c->execute($req, $sessionKey);

							if ($resp->trade->receiver_mobile==$search) {
								# code...
								$arr[]=$result[$j]['tID'];
							}
							$j++;
						}
						$i++;
					}
					return $arr;

				}elseif (strlen($search)==$len_tid) {
					# code...tid
					$result_page=$operatedb->Execsql("select count(uID) from orders where uID='".$uID."'",$conn);
					$pageCount=ceil($result_page[0][0]/40);

					$arr=array();

					$i=1;
					while ($i <= $pageCount) {

						$itemNum=($i-1)*40;
						$result=$operatedb->Execsql("select * from orders where uID='".$uID."' limit ".$itemNum.",40",$conn);

						$lastPage=ceil($result_page[0][0]/40);
						if ($i<$lastPage) {
							# code...
							$total=39;
						}elseif ($i==$lastPage) {
							# code...
							$total=$result_page[0][0]-($i-1)*40-1;
						}

						$j=0;
						while ($j <= $total) {
							# code...
							if ($result[$j]['tID']==$search) {
								# code...
								$arr[]=$result[$j]['tID'];
							}
							$j++;
						}
						$i++;
					}
					return $arr;
				}else{
					$result_page=$operatedb->Execsql("select count(uID) from orders where uID='".$uID."'",$conn);
					$pageCount=ceil($result_page[0][0]/40);

					$arr=array();

					$i=1;
					while ($i <= $pageCount) {

						$itemNum=($i-1)*40;
						$result=$operatedb->Execsql("select * from orders where uID='".$uID."' limit ".$itemNum.",40",$conn);

						$lastPage=ceil($result_page[0][0]/40);
						if ($i<$lastPage) {
							# code...
							$total=39;
						}elseif ($i==$lastPage) {
							# code...
							$total=$result_page[0][0]-($i-1)*40-1;
						}

						$j=0;
						while ($j <= $total) {
							# code...
							if ($result[$j]['expressNum']==$search) {
								# code...
								$arr[]=$result[$j]['tID'];
							}
							$j++;
						}
						$i++;
					}
					return $arr;
				}
			}else{
				if (strlen($search)<=12) {
					# code...name
					$result_page=$operatedb->Execsql("select count(uID) from orders where uID='".$uID."'",$conn);
					$pageCount=ceil($result_page[0][0]/40);

					$arr=array();

					$i=1;
					while ($i <= $pageCount) {

						$itemNum=($i-1)*40;
						$result=$operatedb->Execsql("select * from orders where uID='".$uID."' limit ".$itemNum.",40",$conn);

						$lastPage=ceil($result_page[0][0]/40);
						if ($i<$lastPage) {
							# code...
							$total=39;
						}elseif ($i==$lastPage) {
							# code...
							$total=$result_page[0][0]-($i-1)*40-1;

						}

						$j=0;
						while ($j <= $total) {
							# code...
							$req = new TradeFullinfoGetRequest;
							$req->setFields("receiver_name");
							$req->setTid($result[$j]['tID']);
							$resp = $c->execute($req, $sessionKey);

							if ($resp->trade->receiver_name==$search) {
								# code...
								$arr[]=$result[$j]['tID'];
							}
							$j++;
						}
						$i++;
					}
					return $arr;
				}else{
					#address
					$result_page=$operatedb->Execsql("select count(uID) from orders where uID='".$uID."'",$conn);
					$pageCount=ceil($result_page[0][0]/40);

					$arr=array();

					$i=1;
					while ($i <= $pageCount) {

						$itemNum=($i-1)*40;
						$result=$operatedb->Execsql("select * from orders where uID='".$uID."' limit ".$itemNum.",40",$conn);

						$lastPage=ceil($result_page[0][0]/40);
						if ($i<$lastPage) {
							# code...
							$total=39;
						}elseif ($i==$lastPage) {
							# code...
							$total=$result_page[0][0]-($i-1)*40-1;

						}

						$j=0;
						while ($j <= $total) {
							# code...
							$req = new TradeFullinfoGetRequest;
							$req->setFields("receiver_address");
							$req->setTid($result[$j]['tID']);
							$resp = $c->execute($req, $sessionKey);

							if ($resp->trade->receiver_address==$search) {
								# code...
								$arr[]=$result[$j]['tID'];
							}
							$j++;
						}
						$i++;
					}
					return $arr;
				}
			}
		}else{

		}
		
	}
	
?>

