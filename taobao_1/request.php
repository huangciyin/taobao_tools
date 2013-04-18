<?php	
	function getData($type){
		require_once 'config.php';
		global $sessionKey,$appkey,$secretKey,$format,$c;
		

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
					$response=get_url_content("http://localhost/db.php?type=order&pageNo=".$i."");
					$i++;
				}
			}elseif ($type=='refund') {
				# code...
				$req = new RefundsReceiveGetRequest;
				$req->setFields("refund_id");
				$req->setStatus("WAIT_SELLER_AGREE");
				$resp = $c->execute($req, $sessionKey);

				$pageCount=ceil($resp->total_results/40);
				$i=1;
				while ($i <= $pageCount) {
					# code...
					$response=get_url_content("http://localhost/db.php?type=refund&pageNo=".$i."");
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
					$response=get_url_content("http://localhost/db.php?type=stock&pageNo=".$i."");
					$i++;
				}
				$response=get_url_content("http://localhost/db.php?type=sku");
			}
		}
	}

?>