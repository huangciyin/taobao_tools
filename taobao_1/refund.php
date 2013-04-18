<?php
	header("Content-type:text/html;charset=utf-8");
	require "conndb.inc.php";
	require_once 'config.php';
	require_once 'request.php';
	getData('refund');

	$result_page=$operatedb->Execsql("select count(*) from refundlist where uID='".$uID."'",$conn);
	if (isset($_GET['pageNo'])&&!empty($_GET['pageNo'])) {
		# code...
		$pageNo=$_GET['pageNo'];
	}else{
		$pageNo=1;
	}
	$pagenum=($pageNo-1)*20;
	$lastPage=ceil($result_page[0][0]/20);

	
	function getInfoById($id){
		require_once 'config.php';
		global $sessionKey,$appkey,$secretKey,$format,$c;
		$req = new RefundGetRequest;
		$req->setFields("created,title,reason,refund_id,tid");
		$req->setRefundId($id);
		$resp=$c->execute($req,$sessionKey);
		return $resp;
	}

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
	font-size: 11px;
}
</style>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css">
<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<script>
	$(function() {

	  $( ".detele" ).click(function() {
	  	// var refundID=$(this).parent().parent().children("td:eq(0)").html();
	  	// var url="print.php?deleterefund="+refundID;
	  	// $.get(url);
	  	// $(this).html("已删除");

	  });
	});
</script>
</head>
<body>
	<div class="container">
		<div class="row" style="margin-bottom:1px;">
			<div style="height:170px;"><?php include 'top.html';?></div>
		</div>
		<div class="row">
			<?php include 'leftside.html';?>
			<div style="width:1092px;margin:0 auto;border-width:thin;border:1px solid #dddddd; padding:10px;">
				<table class="table table-bordered table-condensed" style="margin-top: 10px;">
					<colgroup>
		                <col class="span2"></col>
		                <col class="span2"></col>
		                <col class="span3"></col>
		                <col class="span3"></col>
						<col class="span2"></col>
						<col class="span2"></col>
            		</colgroup>
					<thead>
						<tr>
							<th>退款编号</th>
							<th>订单编号</th>
							<th>物品名称</th>
							<th>退款原因</th>
							<th>申请时间</th>
							<th>操作</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$result=$operatedb->Execsql("select * from refundlist where uID='".$uID."' limit ".$pagenum.",20",$conn);
							if ($pageNo<$lastPage) {
								$per=19;
							}elseif ($pageNo==$lastPage) {
								$per=$result_page[0][0]-($pageNo-1)*20-1;
							}elseif ($lastPage==0) {
								$per=-1;
							}
							$i=0;
							while ($i <= $per) {
								# code...
								$resp=getInfoById($result[$i]['refundID']);
								echo "<tr>";
								echo "<td>".$resp->refund->refund_id."</td>";
								echo "<td>".$resp->refund->tid."</td>";
								echo "<td>".@$resp->refund->title."</td>";
								echo "<td>".@$resp->refund->reason."</td>";
								echo "<td>".$resp->refund->created."</td>";
								echo "<td><a href=\"http://mai.taobao.com\" class=\"detele\" target=\"_blank\">进入淘宝处理</a></td>";
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
 	$page=new Fenye($total,20,'refund.php');
 	$page->showFenye($pageNo);
 ?>
</div>
</body>
</html>
