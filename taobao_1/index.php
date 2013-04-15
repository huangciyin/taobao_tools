<?php
	header("Content-type:text/html;charset=utf-8");
	require "conndb.inc.php";
	require_once 'config.php';
	require_once 'request.php';
	getData('order');

	$result_page=$operatedb->Execsql("select count(uID) from orders where uID='".$uID."'",$conn);
	if ( isset( $_GET['pageNo']) && !empty( $_GET['pageNo'])) {
		$pageNo=$_GET['pageNo'];
	}else{
		$pageNo = 1;
	}
	$itemNum=($pageNo-1)*5;
	$lastPage=ceil($result_page[0][0]/5);
?>
<html>
<head>
<title></title>
<link rel="stylesheet" type="text/css" href="css/base.css">
<link rel="stylesheet" type="text/css" href="css/forms.css">
<!-- <link rel="stylesheet" type="text/css" href="css/tables.css"> -->
<link rel="stylesheet" type="text/css" href="css/index.css">
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css">
<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
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
<script type="text/javascript">
$(function(){
	$( "#searchdialog" ).dialog({
		  	autoOpen:false,
		  	width:620
		  });

	$( "#search" ).click(function(){
		  	var content=$("input#content").val();
		  	var url="search.php?search="+content;

		  	$.get(url,function(result1){
		  		$("#searchdialog").html(result1);
		  	});

		  	$( "#searchdialog" ).dialog( "open" );

		  });
	});
</script>
</head>
<body>
	<div class="container">
		<div class="row">
			<div style="height:100px;"><?php include 'top.html';?></div>
		</div>
		<div class="row">
			<?php include 'leftside.html';?>
			<div class="span18" style="border-width:thin;border:1px solid #dddddd; padding:10px;">
				<form class="form-inline" method="post">
					<label>查询条件</label>
					<input type="text" class="span6" id="content" placeholder="姓名 手机号码 收货地址 交易编号" >
					<a href="javascript:;" id="search">查询</a>
				</form>
				<table class="table">
					<?php
						$result=$operatedb->Execsql("select * from orders where uID='".$uID."' limit ".$itemNum.",20",$conn);

						if ($pageNo<$lastPage) {
							# code...
							$per=4;
						}elseif ($pageNo==$lastPage) {
							# code...
							$per=$result_page[0][0]-($pageNo-1)*5-1;
						}elseif ($lastPage==0) {
							# code...
							$per=-1;
						}
						$i=0;
						while ($i <= $per) {
							# code...
							echo "<tbody class=\"table\">";
							echo "<tr><td></td></tr>";
							echo "<tr class=\"tr-head\">";
							$req = new TradeFullinfoGetRequest;
							$req->setFields("pic_path,created,status,receiver_name,receiver_state,receiver_city,receiver_district,receiver_address,receiver_mobile,orders.title,orders.num,buyer_memo,seller_memo");
							$req->setTid($result[$i]['tID']);
							$resp = $c->execute($req, $sessionKey);
							$goodscount=count($resp->trade->orders->order)-1;
							$m=0;
							while ($m <= $goodscount) {
								# code...
								@$goods.=$resp->trade->orders->order[$m]->title." X ".$resp->trade->orders->order[$m]->num;
								$m++;
							}
							echo "<td><div class=\"div-tid\"><span style=\"display:inline-block;width:200px;\"><label style=\"margin-bottom:0px;\">订单编号：<a href=\"javascript:void(0);\" class=\"opener\">".$result[$i]['tID']."</a></label></span><span>成交时间：".$resp->trade->created."</span></div></td></tr>";
							echo "<tr class=\"tr-body border-no-top\">";
							echo "<td><div class=\"div-goods\"><div class=\"div-img\"><img src=\"".$resp->trade->pic_path."\"></div><div class=\"div-goods-name\">".$goods."</div></div></td>";
							echo "<td><div class=\"div-name\">".$resp->trade->receiver_name."</div></td>";
							echo "<td><div class=\"div-mobile\">".$resp->trade->receiver_mobile."</div></td>";
							echo "<td><div class=\"div-address\">".$resp->trade->receiver_state.$resp->trade->receiver_city.$resp->trade->receiver_district.$resp->trade->receiver_address."</div></td>";
							echo "<td><div class=\"div-buyer-memo\">".$resp->trade->buyer_memo."</div></td>";
							echo "<td><div class=\"div-buyer-memo\">".$resp->trade->seller_memo."</div></td>";
							echo "<td><div class=\"div-status\">".getOrderStatus($resp->trade->status)."</div></td>";
							echo "</tr>";
							echo "</tbody>";
							$goods="";
							$i++;
						}
					?>
				
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
 	$page=new Fenye($total,5,'index.php');
 	$page->showFenye($pageNo);
 ?>
</div>
<div id="dialog" title="订单详情"></div>
<div id="searchdialog" title="查询结果"></div>
</body>
</html>
