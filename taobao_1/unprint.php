<?php
	header("Content-type:text/html;charset=utf-8");
	require "conndb.inc.php";
	require_once 'config.php';

	$result_page=$operatedb->Execsql("select count(*) from orders where uID='".$uID."' and printStatus=''",$conn);
	if (isset($_GET['pageNo'])&&!empty($_GET['pageNo'])) {
		# code...
		$pageNo=$_GET['pageNo'];
	}else{
		$pageNo=1;
	}
	$pagenum=($pageNo-1)*5;
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
	    width:910
	  });

	  $( ".opener" ).click(function() {
	  	var tid=$(this).parents().prev().find("label").html().split("订单编号：");
	  	var url="print.php?tid="+tid[1];

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
			<div class="span18" style="border-width:thin;border:1px solid #dddddd; padding:7px;">
				<table class="table">
					<?php
						$result=$operatedb->Execsql("select * from orders where uID='".$uID."' and printStatus='' limit ".$pagenum.",20",$conn);
						
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
							$req=new TradeFullinfoGetRequest;
							$req->setFields("pic_path,created,status,receiver_name,receiver_state,receiver_city,receiver_district,receiver_address,receiver_mobile,orders.title,orders.num,buyer_memo,seller_memo");
							$req->setTid($result[$i]['tID']);
							$resp=$c->execute($req,$sessionKey);
							$goodscount=count($resp->trade->orders->order)-1;
							$m=0;
							while ($m <= $goodscount) {
								# code...
								@$goods.=$resp->trade->orders->order[$m]->title." X ".$resp->trade->orders->order[$m]->num;
								$m++;
							}
							echo "<td><div class=\"div-tid\"><span style=\"display:inline-block;width:200px;\"><label style=\"margin-bottom:0px;\">订单编号：".$result[$i]['tID']."</label></span><span>成交时间：".$resp->trade->created."</span></div></td></tr>";
							echo "<tr class=\"tr-body border-no-top\">";
							echo "<td><div class=\"div-goods\"><div class=\"div-img\"><img src=\"".$resp->trade->pic_path."\"></div><div class=\"div-goods-name\">".$goods."</div></div></td>";
							echo "<td><div class=\"div-name\">".$resp->trade->receiver_name."</div></td>";
							echo "<td><div class=\"div-mobile\">".$resp->trade->receiver_mobile."</div></td>";
							echo "<td><div class=\"div-address\">".$resp->trade->receiver_state.$resp->trade->receiver_city.$resp->trade->receiver_district.$resp->trade->receiver_address."</div></td>";
							echo "<td><div class=\"div-buyer-memo\">".$resp->trade->buyer_memo."</div></td>";
							echo "<td><div class=\"div-buyer-memo\">".$resp->trade->seller_memo."</div></td>";
							echo "<td><a href=\"javascript:void(0);\" class=\"opener\">打印快递单</a></td>";
							echo "</tr>";
							echo "</tbody>";
							$i++;
							$goods="";
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
 	$page=new Fenye($total,5,'unprint.php');
 	$page->showFenye($pageNo);
 ?>
</div>
<div id="dialog" title="快递详细"></div>
</body>
</html>
