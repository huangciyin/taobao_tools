<?php	
	function getData($type){
		require_once 'config.php';
		global $sessionKey,$appkey,$secretKey,$format;

		$c=new TopClient;
		$c->appkey=$appkey;
		$c->secretKey=$secretKey;
		$c->format=$format;

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
					$response=get_url_content("http://localhost/sandbox/db.php?type=order&pageNo=".$i."");
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
					$response=get_url_content("http://localhost/sandbox/db.php?type=refund&pageNo=".$i."");
					$i++;
				}
			}elseif ($type=='stock') {
				# code...
				$req = new ItemsOnsaleGetRequest;
				$req->setFields("num_iid,num,outer_id");
				$resp = $c->execute($req, $sessionKey);

				$pageCount=ceil($resp->total_results/40);
				$i=1;
				while ($i <= $pageCount) {
					# code...
					$response=get_url_content("http://localhost/sandbox/db.php?type=stock&pageNo=".$i."");
					$i++;
				}
			}
		}
	}

?>