<?php
	header("Content-type:text/html;charset=utf-8");
	require "conndb.inc.php";
	require_once 'config.php';


	$c=new TopClient;
	$c->appkey="1021409528";
	$c->secretKey="sandbox31b961e472f864b1c17ebd4ba";
	$c->format="json";

	$user_req = new UserSellerGetRequest;
	$user_req->setFields("user_id");
	$user_resp = $c->execute($user_req, $sessionKey);
	$uID=$user_resp->user->user_id;


	if (isset($_GET['search'])&&!empty($_GET['search'])){
		# code...
		$search=$_GET['search'];
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

			}elseif (strlen($search)==14) {
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
			}else{

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
			}
		}
	}else{

	}
	
	
	
?>
<html>
<head>
<title></title>
<link rel="stylesheet" type="text/css" href="css/base.css">
<link rel="stylesheet" type="text/css" href="css/forms.css">
<link rel="stylesheet" type="text/css" href="css/tables.css">
<style type="text/css">
label{
	font-weight: bolder;
}
</style>
</head>
<body>
	<table class="table table-bordered">
		<?php
			$count=count($arr);
			$m=0;
			while ($m <= $count-1) {
				# code...
				$req = new TradeFullinfoGetRequest;
				$req->setFields("created,receiver_name,receiver_state,receiver_city,receiver_district,receiver_address,receiver_mobile,total_fee,orders.title,orders.num");
				$req->setTid($arr[$m]);
				$resp = $c->execute($req, $sessionKey);

				$created=$resp->trade->created;
				$receiverName=$resp->trade->receiver_name;
				$receicerLocation=$resp->trade->receiver_state.$resp->trade->receiver_city.$resp->trade->receiver_district.$resp->trade->receiver_address;
				$receiverMobile=$resp->trade->receiver_mobile;
				$total_fee=$resp->trade->total_fee;
				$result=count($resp->trade->orders->order)-1;
				$n=0;
				while ($n <= $result) {
					# code...
					@$goods.=$resp->trade->orders->order[$n]->title." X ".$resp->trade->orders->order[$n]->num;
					$n++;
				}

				echo "<tr>".
						"<td colspan=\"2\"><label>交易编号:</label>".$arr[$m]."</td>".
						"<td colspan=\"2\"><label>提交时间:</label>".$created."</td>".
						"<td colspan=\"2\"><label>收件人姓名:</label>".$receiverName."</td>".
					"</tr>".
					"<tr><td colspan=\"6\"><label>收件人地址:</label>".$receicerLocation."</td></tr>".
					"<tr><td colspan=\"6\"><label>物品详情:</label>".$goods."</td></tr>".
					"<tr>".
						"<td colspan=\"3\"><label>金额:</label>".$total_fee."</td>".
						"<td colspan=\"3\"><label>操作:</label></td>".
					"</tr>".
					"<br>";
				$m++;
			}
		?>
	</table>
</body>
</html>
