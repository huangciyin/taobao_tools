<?php
	
	function getData($type){
		require_once 'config.php';
		// $sessionKey=$_COOKIE['sessionKey'];
		// $uID=$_COOKIE['uID'];


		$sessionKey = $_SESSION['topsession'];
		$uID = $_SESSION['uID'];
	

		global $sessionKey,$appkey,$secretKey,$format,$c,$operatedb,$conn;
		
		if (!empty($uID)) {
		# code...
			$result=$operatedb->Execsql("select * from user where uID=".$uID."",$conn);
			if ($result==false) {
				# code...
				$arrUser=array('userID','uID','userName','userSessionkey','userAddress','userTel','userShopname','customExpress1','customExpress2','customExpress3','customMark1','customMark2','customMark3');
				$strUser=sprintf("insert into %s(%s) values (NULL,'%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')",'user',implode(',', $arrUser),$uID,'',$sessionKey,'','','','','','','','','');
				$result=$operatedb->Execsql($strUser,$conn);
				if ($result==true) {
					# code...
				}else{

				}
			}else{

			}
		}

		if (isset($type)&&!empty($type)) {
				# code...
				if ($type=='order') {
				# code...
				$req = new TradesSoldGetRequest;
				$req->setFields("status");
				$req->setStatus("WAIT_SELLER_SEND_GOODS");
				$resp = $c->execute($req, $sessionKey);

				$pageCount=ceil($resp->total_results/40);
				$i=1;
				while ($i <= $pageCount) {
					# code...
					// $response=get_url_content("http://".$_SERVER["SERVER_NAME"]."/db.php?type=order&pageNo=".$i."&sessionKey=".$sessionKey."&uID=".$uID."");
					$req = new TradesSoldGetRequest;
					$req->setFields("created,tid");
					$req->setStatus("WAIT_SELLER_SEND_GOODS");
					$req->setPageNo($i);
					
					$resp = $c->execute($req, $sessionKey);


					$lastPage=ceil($resp->total_results/40);
					if ($i<$lastPage) {
										# code...
						$total=39;
					}elseif ($i==$lastPage) {
						# code...
						$total=$resp->total_results-($i-1)*40-1;
					}

					$result_first=$operatedb->Execsql("select * from orders where uID='".$uID."' order by created DESC limit 0,1",$conn);
					if ($result_first==true) {
						# code...
						$time=$result_first[0]['created'];
					}else{
						$time=date("Y-m-d H:i:s",time()-30*24*60*60);

					}

					$arrOrder=array('uID','tID','created','printStatus','expressNum');
					$j=0;
					while ($j <= $total) {
						# code...
						$tID=$resp->trades->trade[$j]->tid;
						$created=$resp->trades->trade[$j]->created;
						if (date("Y-m-d H:i:s",strtotime($created))>date("Y-m-d H:i:s",strtotime($time))) {
							# code...
							$strOrder=sprintf("insert into %s(%s) values ('%s','%s','%s','','')",'orders',implode(',', $arrOrder),$uID,$tID,$created);
							$result_insert=$operatedb->Execsql($strOrder,$conn);
							$j++;
						}else{
							$j++;
						}
					}
					$i++;
				}
			}elseif ($type=='refund') {
				# code...
				$req = new RefundsReceiveGetRequest;
				$req->setFields("refund_id");
				$resp = $c->execute($req, $sessionKey);

				$pageCount=ceil($resp->total_results/40);
				$i=1;
				while ($i <= $pageCount) {
					$req = new RefundsReceiveGetRequest;
					$req->setFields("refund_id,created");
					$req->setPageNo($i);

					$resp = $c->execute($req, $sessionKey);

					$lastPage=ceil($resp->total_results/40);
					if ($i<$lastPage) {
							$total=39;
						}elseif ($i==$lastPage) {
							# code...
							$total=$resp->total_results-($i-1)*40-1;
						}

					$result_first=$operatedb->Execsql("select * from refundlist where uID='".$uID."' order by created DESC limit 0,1 ",$conn);
					if ($result_first==true) {
						# code...
						$time=$result_first[0]['created'];
					}else{
						$time=date("Y-m-d H:i:s",time()-30*24*60*60);

					}

					$arrRefund=array('refundID','uID','created','mark','status');
					$j=0;
					while ($j <= $total) {
						# code...
						$refundID=$resp->refunds->refund[$j]->refund_id;
						$created=$resp->refunds->refund[$j]->created;
						if (date("Y-m-d H:i:s",strtotime($created))>date("Y-m-d H:i:s",strtotime($time))) {
							# code...
							$strRefund=sprintf("insert into refundlist (%s) values('%s','%s','%s','备注','0')",implode(',', $arrRefund),$refundID,$uID,$created);
							$result_insert=$operatedb->Execsql($strRefund,$conn);
							$j++;
						}else{
							$j++;
						}
					}
					$i++;
				}
			}elseif ($type=='stock') {
				# code...
				$req = new ItemsOnsaleGetRequest;
				$req->setFields("num_iid,num");
				$resp = $c->execute($req, $sessionKey);

				$pageCount=ceil($resp->total_results/40);
				$i=1;
				while ($i <= $pageCount) {
					# code...
					// $response=get_url_content("http://".$_SERVER["SERVER_NAME"]."/db.php?type=stock&pageNo=".$i."&sessionKey=".$sessionKey."&uID=".$uID."");
					$req = new ItemsOnsaleGetRequest;
					$req->setFields("num_iid,num");
					$req->setPageNo($i);

					$resp = $c->execute($req, $sessionKey);
					// $total=$resp->total_results-1;
					$lastPage=ceil($resp->total_results/40);
					if ($i<$lastPage) {
										# code...
						$total=39;
					}elseif ($i==$lastPage) {
						# code...
						$total=$resp->total_results-($i-1)*40-1;
					}

					$arrStock=array('uID','numId','stockalise');
					$j=0;
					while ($j <= $total) {
						# code...
						$numID=$resp->items->item[$j]->num_iid;
						$result_select=$operatedb->Execsql("select * from stocklist where numID='".$numID."'",$conn);
						if ($result_select==true) {
							# code...
							// $result_update=$operatedb->Execsql("update stocklist set stock='".$stock."' where numID='".$numID."'",$conn);
							$j++;
						}else{
							$strStock=sprintf("insert into stocklist (%s) values ('%s','%s','请设置')",implode(',',$arrStock),$uID,$numID);
							$result_insert=$operatedb->Execsql($strStock,$conn);
							$j++;
						}
					}
					$i++;
				}
				// $response=get_url_content("http://".$_SERVER["SERVER_NAME"]."/db.php?type=sku&sessionKey=".$sessionKey."&uID=".$uID."");
				$result=$operatedb->Execsql("select * from stocklist where uID='".$uID."'",$conn);
				$result_count=count($result);
				$r=0;
				while ($r <= $result_count-1) {
					# code...
					$numID=$result[$r]['numID'];

					$req = new ItemGetRequest;
					$req->setFields("sku");
					$req->setNumIid($numID);
					$resp = $c->execute($req, $sessionKey);

					if ($resp!=NULL) {
						@$skus_count=count($resp->item->skus->sku);
						$t=0;
						while ($t <= $skus_count-1) {
							# code...
							@$sku_id=$resp->item->skus->sku[$t]->sku_id;
							$result_selectsku=$operatedb->Execsql("select * from sku where num_iid='".$numID."' and sku_id='".$sku_id."'",$conn);
							if ($result_selectsku==true) {
								# code...
								$t++;
							}else{
								$result_insertsku=$operatedb->Execsql("insert into sku(num_iid,sku_id,stock,warn) values('".$numID."','".$sku_id."','0','0')",$conn);
								$t++;
							}
						}
					}else{
						echo "null";
					}
					$r++;
				}
			}
		}
	}

?>
