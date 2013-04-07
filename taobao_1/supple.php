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
	getData('refund');

	$result_page=$operatedb->Execsql("select count(*) from refundlist where uID='".$uID."' and status='0'",$conn);
	if (isset($_GET['pageNo'])&&!empty($_GET['pageNo'])) {
		# code...
		$pageNo=$_GET['pageNo'];
	}else{
		$pageNo=1;
	}
	$pagenum=($pageNo-1)*20;
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
	font-size: 11px;
}
</style>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css">
<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<script>
	$(function() {

		$(".mark").click(function(){
			if ($(this).text()!="确定") {
				$(this).parent().children("input:eq(0)").removeAttr("style");
				$(this).text("确定");
			} else{
				var refundID=$(this).parent().parent().children("td:eq(0)").html();
				var value=$(this).parent().children("input:eq(0)").val();
				var url="print.php?insertmark="+value+"&refundID="+refundID;
				$.get(url);
				$(this).parent().children("input:eq(0)").attr("style","display:none");
				$(this).text(value);
			};
		});

	  $( ".insert" ).click(function() {
	  	var num_iid=$(this).parent().parent().children("td:eq(1)").html();
	  	var refund=$(this).parent().parent().children("td:eq(0)").html();
	  	var url="print.php?insert="+num_iid+"&refund="+refund;
	  	$.get(url);
	  	$(this).html("已添加");

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
				<table class="table table-bordered table-condensed" style="margin-top: 10px;">
					<colgroup>
		                <col class="span2"></col>
		                <col class="span2"></col>
		                <col class="span5"></col>
						<col class="span5"></col>
						<col class="span2"></col>
            		</colgroup>
					<thead>
						<tr>
							<th>退货编号</th>
							<th>货物编号</th>
							<th>物品名称</th>
							<th>备注</th>
							<th>操作</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$result=$operatedb->Execsql("select * from refundlist where uID='".$uID."' and status='0' limit ".$pagenum.",20",$conn);
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
								echo "<td>".$result[$i]['refundID']."</td>";
								$req = new RefundGetRequest;
								$req->setFields("created,title,reason,num_iid");
								$req->setRefundId($result[$i]['refundID']);
								$resp=$c->execute($req,$sessionKey);
								echo "<td>".$resp->refund->num_iid."</td>";
								echo "<td>".$resp->refund->title."</td>";
								echo "<td><input type=\"text\" style=\"display:none;\"><a href=\"javascript:void(0);\" class=\"mark\">".$result[$i]['mark']."</a></td>";
								echo "<td><a href=\"javascript:void(0);\" class=\"insert\">添加到库存</a></td>";
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
 	$page=new Fenye($total,20,'supple.php');
 	$page->showFenye($pageNo);
 ?>
</div>
</body>
</html>
