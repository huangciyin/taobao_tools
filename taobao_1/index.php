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

	require_once 'request.php';
	getData('order');

	$result_page=$operatedb->Execsql("select count(uID) from orders where uID='".$uID."'",$conn);
	if ( isset( $_GET['pageNo']) && !empty( $_GET['pageNo'])) {
		$pageNo=$_GET['pageNo'];
	}else{
		$pageNo = 1;
	}
	$itemNum=($pageNo-1)*20;
	$lastPage=ceil($result_page[0][0]/20);
?>
<html>
<head>
<title></title>
<link rel="stylesheet" type="text/css" href="css/base.css">
<link rel="stylesheet" type="text/css" href="css/forms.css">
<link rel="stylesheet" type="text/css" href="css/tables.css">
<style type="text/css">
li{
	display: inline;
	padding-left: 20px;
	font-size: 15px;
}
tbody{
	font-size: 10px;
}
</style>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css">
<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<script type="text/javascript">
  $(function() {
  	$.datepicker.setDefaults({ dateFormat: 'yy-mm-dd' });
    $( "#from" ).datepicker({
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 1,
      onClose: function( selectedDate ) {
        $( "#to" ).datepicker( "option", "minDate", selectedDate );
      }
    });
    $( "#to" ).datepicker({
      defaultDate: "+1w",
      changeMonth: true,
      numberOfMonths: 1,
      onClose: function( selectedDate ) {
        $( "#from" ).datepicker( "option", "maxDate", selectedDate );
      }
    });
  });
</script>
<script>
	$(function() {
	  $( "#dialog" ).dialog({
	    autoOpen: false,
	    width:620
	  });

	  $( ".opener" ).click(function() {
	  	var tid=$(this).html();
	  	var url="detail.php?tid="+tid;

  	$.get(url,function(result){
  		$("#dialog").html(result);
  	});

	    $( "#dialog" ).dialog( "open" );
	  });
	});
</script>
</head>
<body>
	<div class="container">
		<div class="row">
			<div style="height:100px;"></div>
		</div>
		<div class="row">
			<?php include 'leftside.html';?>
			<div class="span18" style="border-width:thin;border:1px solid #dddddd; padding:10px;">
				<form class="form-inline" action="index.php" method="post">
					<label>交易编号</label>
					<input type="text" class="span3" name="tid" >
					<label>收件人姓名</label>
					<input type="text" class="span3" name="receiver_name" >
					<label>创建时间</label>
					<input type="text" class="span3" name="start_created" id="from" >
					<label>订单状态</label>
						<select name="status">
							<option value="CREATED">订单已创建</option>
							<option value="RECREATED">订单重新创建</option>
							<option value="CANCELLED">订单已取消</option>
							<option value="CLOSED">订单关闭</option>
							<option value="SENDING">等候发送给物流公司</option>
							<option value="ACCEPTING">已发送给物流公司,等待接单</option>
							<option value="ACCEPTED">物流公司已接单</option>
							<option value="REJECTED">物流公司不接单</option>
							<option value="PICK_UP">物流公司揽收成功</option>
							<option value="PICK_UP_FAILED">物流公司揽收失败</option>
							<option value="LOST">物流公司丢单</option>
							<option value="REJECTED_BY_RECEIVER">对方拒签</option>
							<option value="ACCEPTED_BY_RECEIVER">对方已签收</option>
						</select>
					<input type="submit" value="查询" name="search">
				</form>
				<table class="table table-bordered table-condensed" style="margin-top: 10px;">
					<colgroup>
		                <col class="span2"></col>
		                <col class="span2"></col>
		                <col class="span5"></col>
						<col class="span2"></col>
						<col class="span2"></col>
            		</colgroup>
					<thead>
						<tr>
							<th>交易编号</th>
							<th>收件人姓名</th>
							<th>收件人地址</th>
							<th>收件人电话</th>
							<th>订单状态</th>
						</tr>
					</thead>
					<tbody>
						<?php

							$result=$operatedb->Execsql("select * from orders where uID='".$uID."' limit ".$itemNum.",20",$conn);

							// $per = (( $pageNo == $lastPage) ? $result_page[0][0]%20-1 : 19);
							 
							if ($pageNo<$lastPage) {
								# code...
								$per=19;
							}elseif ($pageNo==$lastPage) {
								# code...
								$per=$result_page[0][0]-($pageNo-1)*20-1;
							}
							$i=0;
							while ($i <= $per) {
								# code...
								echo "<tr>";
								echo "<td><a href=\"javascript:void(0);\" class=\"opener\">".$result[$i]['tID']."</a></td>";
								$req = new TradeFullinfoGetRequest;
								$req->setFields("status,receiver_name,receiver_state,receiver_city,receiver_district,receiver_address,receiver_mobile,orders.title");
								$req->setTid($result[$i]['tID']);
								$resp = $c->execute($req, $sessionKey);
								echo "<td>".$resp->trade->receiver_name."</td>";
								echo "<td>".$resp->trade->receiver_state.$resp->trade->receiver_city.$resp->trade->receiver_district.$resp->trade->receiver_address."</td>";
								echo "<td>".$resp->trade->receiver_mobile."</td>";
								echo "<td>".getOrderStatus($resp->trade->status)."</td>";
								echo "</tr>";
								$i++;
							}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
<div class="row" style="float:right;padding-right:35px;">
<?php
 	$total=$result_page[0][0];
 	if ($total>=200) {
 		# code...
 		$total=200;
 	}
 	$page=new Fenye($total,20,'index.php');
 	$page->showFenye($pageNo);
 ?>
</div>
<div id="dialog" title="订单详情"></div>
</body>
</html>
