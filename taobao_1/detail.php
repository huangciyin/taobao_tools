<?php
	header("Content-type:text/html;charset=utf-8");
	require_once 'config.php';


	$req = new TradeFullinfoGetRequest;
	$req->setFields("created,receiver_name,receiver_state,receiver_city,receiver_district,receiver_address,receiver_mobile,total_fee,orders.title,orders.num");
	if (isset($_GET['tid'])&&!empty($_GET['tid'])) {
		# code...
		$req->setTid($_GET['tid']);
	}
	$resp = $c->execute($req, $sessionKey);
	$tID=$_GET['tid'];
	$created=$resp->trade->created;
	$receiverName=$resp->trade->receiver_name;
	$receicerLocation=$resp->trade->receiver_state.$resp->trade->receiver_city.$resp->trade->receiver_district.$resp->trade->receiver_address;
	$receiverMobile=$resp->trade->receiver_mobile;
	$total_fee=$resp->trade->total_fee;
	$result=count($resp->trade->orders->order)-1;
	$i=0;
	while ($i <= $result) {
		# code...
		@$goods.=$resp->trade->orders->order[$i]->title." X ".$resp->trade->orders->order[$i]->num;
		$i++;
	}
?>
<html>
<head>
<title></title>
<link rel="stylesheet" type="text/css" href="css/base.css">
<link rel="stylesheet" type="text/css" href="css/forms.css">
<!-- <link rel="stylesheet" type="text/css" href="css/tables.css"> -->
<style type="text/css">
label{
	font-weight: bolder;
}
#table{
	border: 1px solid #B4D5FF;
	width:595px;
}
#td{
	border-right:1px solid #B4D5FF;
}
#tr{
	border-bottom: 1px solid #B4D5FF;
}
</style>
</head>
<body>
	<table id="table">
		<tr id="tr">
			<td id="td" colspan="2"><label>交易编号:</label><?php echo $tID;?></td>
			<td id="td" colspan="2"><label>提交时间:</label><?php echo $created;?></td>
			<td id="td" colspan="2"><label>收件人姓名:</label><?php echo $receiverName;?></td>
		</tr>
		<tr id="tr"><td id="td" colspan="6"><label>收件人地址:</label><?php echo $receicerLocation;?></td></tr>
		<tr id="tr"><td id="td" colspan="6"><label>物品详情:</label><?php echo $goods;?></td></tr>
		<tr id="tr">
			<td id="td" colspan="3"><label>金额:</label><?php echo $total_fee;?></td>
			<td id="td" colspan="3"><label>操作:</label></td>
		</tr>
	</table>
</body>
</html>