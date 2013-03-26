<?php
	header("Content-type:text/html;charset=utf-8");
	require_once 'config.php';


	$c=new TopClient;
	$c->appkey="1021409528";
	$c->secretKey="sandbox31b961e472f864b1c17ebd4ba";
	$c->format="json";


	if (isset($_GET['search'])&&!empty($_GET['search'])){
		# code...
		$result=$_GET['search'];
		if (is_numeric($result)) {
			# code...
			if (strlen($result)==11) {
				# code...mobile
				$req = new TradesSoldGetRequest;
				$req->setFields("tid,receiver_mobile");
				$resp = $c->execute($req, $sessionKey);
				$total=$resp->total_results;

				$arr=array();

				$pageCount=ceil($total/40);
				$i=1;
				while ($i <= $pageCount) {
					# code...
					$req1=new TradesSoldGetRequest;
					$req1->setFields("tid,receiver_mobile");
					$req1->setPageNo($i);
					$resp1=$c->execute($req1,$sessionKey);
					$j=0;
					while ($j <= 39) {
						# code...
						if ($resp1->trades->trade[$j]->receiver_mobile==$result) {
							# code...
							$arr[]=$resp1->trades->trade[$j]->tid;
						}
						$j++;
					}
					$i++;
				}

			}elseif (strlen($result)==14) {
				# code...tid
				$req = new TradeFullinfoGetRequest;
				$req->setFields("buyer_nick,title,created,tid,status,receiver_name,receiver_state,receiver_city,receiver_district,receiver_address,receiver_mobile");
				$req->setTid($result);
				$resp = $c->execute($req, $sessionKey);

			}else{

			}
		}else{
			if (strlen($result)<=12) {
				# code...name
				$req = new TradesSoldGetRequest;
				$req->setFields("tid,receiver_name");
				$resp = $c->execute($req, $sessionKey);
				$total=$resp->total_results;

				$arr=array();

				$pageCount=ceil($total/40);
				$i=1;
				while ($i <= $pageCount) {
					# code...
					$req1=new TradesSoldGetRequest;
					$req1->setFields("tid,receiver_name");
					$req1->setPageNo($i);
					$resp1=$c->execute($req1,$sessionKey);
					$j=0;
					while ($j <= 39) {
						# code...
						if ($resp1->trades->trade[$j]->receiver_name==$result) {
							# code...
							$arr[]=$resp1->trades->trade[$j]->tid;
						}
						$j++;
					}
					$i++;
				}
			}else{
				#address
			}
		}
	}else{

	}
?>
<html>
<head>
	<title></title>
</head>
<body>
<?php echo $arr;?>
</body>
</html>
