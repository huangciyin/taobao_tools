<?php
	header("Content-type:text/html;charset=utf-8");
	require 'conndb.inc.php';
	require_once 'config.php';

	$c=new TopClient;
	$c->appkey="1021409528";
	$c->secretKey="sandbox31b961e472f864b1c17ebd4ba";
	$c->format="json";

	$user_req = new UserSellerGetRequest;
	$user_req->setFields("user_id");
	$user_resp = $c->execute($user_req, $sessionKey);
	$uID=$user_resp->user->user_id;
	if (!empty($uID)) {
		# code...
		$result=$operatedb->Execsql("select * from user where uID=".$uID."",$conn);
		if ($result==false) {
			# code...
			$arrUser=array('userID','uID','userName','userSessionkey','userAddress','userTel','userShopname');
			$strUser=sprintf("insert into %s(%s) values (NULL,'%s','%s','%s','%s','%s','%s')",'user',implode(',', $arrUser),$uID,'',$sessionKey,'','','');
			$result=$operatedb->Execsql($strUser,$conn);
			if ($result==true) {
				# code...
			}else{

			}
		}else{

		}
	}

	if (isset($_GET['type'])&&!empty($_GET['type'])) {
		# code...
		if ($_GET['type']=='order') {
			# code...
			$req = new TradesSoldGetRequest;
			$req->setFields("created,tid");
			$req->setStatus("WAIT_SELLER_SEND_GOODS");
			if (isset($_GET['pageNo'])&&!empty($_GET['pageNo'])) {
				# code...
				$req->setPageNo($_GET['pageNo']);
			}
			$resp = $c->execute($req, $sessionKey);
			$total=$resp->total_results-1;

			$result_first=$operatedb->Execsql("select * from orders where uID='".$uID."' limit 0,1",$conn);
			$time=$result_first[0]['created'];

			$arrOrder=array('uID','tID','created','printStatus');
			$j=0;
			while ($j <= $total) {
				# code...
				$tID=$resp->trades->trade[$j]->tid;
				$created=$resp->trades->trade[$j]->created;
				if (date("Y-m-d H:i:s",strtotime($created))>date("Y-m-d H:i:s",strtotime($time))) {
					# code...
					$strOrder=sprintf("insert into %s(%s) values ('%s','%s','%s','')",'orders',implode(',', $arrOrder),$uID,$tID,$created);
					$result_insert=$operatedb->Execsql($strOrder,$conn);
					$j++;
				}else{
					$j++;
				}
				// $result_select=$operatedb->Execsql("select * from orders where tID='".$tID."'",$conn);
				// if ($result_select==true) {
				// 	# code...
				// 	$result_update=$operatedb->Execsql("update orders set created='".$created."' where tID='".$tID."'",$conn);
				// 	$j++;
				// }else{
				// 	$strOrder=sprintf("insert into %s(%s) values ('%s','%s','%s','')",'orders',implode(',', $arrOrder),$uID,$tID,$created);
				// 	$result_insert=$operatedb->Execsql($strOrder,$conn);
				// 	$j++;
				// }
			}
		}elseif ($_GET['type']=='refund') {
			# code...
			$req = new RefundsReceiveGetRequest;
			$req->setFields("refund_id,created");
			$req->setStatus("WAIT_SELLER_AGREE");
			if (isset($_GET['pageNo'])&&!empty($_GET['pageNo'])) {
				# code...
				$req->setPageNo($_GET['pageNo']);
			}
			$resp = $c->execute($req, $sessionKey);
			$total=$resp->total_results-1;

			$result_first=$operatedb->Execsql("select * from refundlist where uID='".$uID."' limit 0,1 ",$conn);
			$time=$result_first[0]['created'];

			$arrRefund=array('refundID','uID','created');
			$j=0;
			while ($j <= $total) {
				# code...
				$refundID=$resp->refunds->refund[$j]->refund_id;
				$created=$resp->refunds->refund[$j]->created;
				if (date("Y-m-d H:i:s",strtotime($created))>date("Y-m-d H:i:s",strtotime($time))) {
					# code...
					$strRefund=sprintf("insert into refundlist (%s) values('%s','%s','%s')",implode(',', $arrRefund),$refundID,$uID,$created);
					$result_insert=$operatedb->Execsql($strRefund,$conn);
					$j++;
				}else{
					$j++;
				}
				// $result_select=$operatedb->Execsql("select * from refundlist where refundID='".$refundID."'",$conn);
				// if ($result_select==true) {
				// 	# code...
				// 	$result_update=$operatedb->Execsql("update refundlist set created='".$created."' where refundID='".$refundID."'",$conn);
				// 	$j++;
				// }else{
					// $strRefund=sprintf("insert into refundlist (%s) values('%s','%s','%s')",implode(',', $arrRefund),$refundID,$uID,$created);
					// $result_insert=$operatedb->Execsql($strRefund,$conn);
					// $j++;
				// }
			}
		}elseif ($_GET['type']=='stock') {
			# code...
			$req = new ItemsInventoryGetRequest;
			$req->setFields("num_iid,num,outer_id");
			if (isset($_GET['pageNo'])&&!empty($_GET['pageNo'])) {
				# code...
				$req->setPageNo($_GET['pageNo']);
			}
			$resp = $c->execute($req, $sessionKey);
			$total=$resp->total_results-1;

			$arrStock=array('uID','numId','outerID','stock');
			$j=0;
			while ($j <= $total) {
				# code...
				$numID=$resp->items->item[$j]->num_iid;
				@$outerID=$resp->items->item[$j]->outer_id;
				$result_select=$operatedb->Execsql("select * from stocklist where numID='".$numID."'",$conn);
				if ($result_select==true) {
					# code...
					// $result_update=$operatedb->Execsql("update stocklist set stock='".$stock."' where numID='".$numID."'",$conn);
					$j++;
				}else{
					$strStock=sprintf("insert into stocklist (%s) values ('%s','%s','%s','')",implode(',',$arrStock),$uID,$numID,$outerID);
					$result_insert=$operatedb->Execsql($strStock,$conn);
					$j++;
				}
			}
		}

	}else{

	}

	
?>