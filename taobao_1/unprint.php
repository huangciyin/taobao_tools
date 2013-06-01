<?php
	require "conndb.inc.php";
	require_once 'config.php';
	// $sessionKey=$_COOKIE['sessionKey'];
	// $uID=$_COOKIE['uID'];
	
	if (empty($sessions)) {
		echo "please <a href='login.php'>login</a>";exit;
	}else{
		$sessionKey = $_SESSION['topsession'];
		$uID = $_SESSION['uID'];
	}

	$result_page=$operatedb->Execsql("select count(*) from orders where uID='".$uID."' and printStatus=''",$conn);
	if (isset($_GET['pageNo'])&&!empty($_GET['pageNo'])) {
		# code...
		$pageNo=$_GET['pageNo'];
	}else{
		$pageNo=1;
	}
	$pagenum=($pageNo-1)*20;
	$lastPage=ceil($result_page[0][0]/20);

	function getInfoById($tid){
		require_once 'config.php';
		global $sessionKey,$appkey,$secretKey,$format,$c;
		$req = new TradeFullinfoGetRequest;
		$req->setFields("tid,pic_path,created,status,receiver_name,receiver_state,receiver_city,receiver_district,receiver_address,receiver_mobile,orders.title,orders.num,buyer_message,seller_memo");
		$req->setTid($tid);
		$resp = $c->execute($req, $sessionKey);
		return $resp;
	}
	function drawBody($resp){
		echo "<tbody class=\"table\">";
		// echo "<tr style=\"height:8px;\"><td></td></tr>";
		echo "<tr class=\"tr-head\">";
		$goodscount=count($resp->trade->orders->order)-1;
		$m=0;
		while ($m <= $goodscount) {
		# code...
		@$goods.=$resp->trade->orders->order[$m]->title." X ".$resp->trade->orders->order[$m]->num;
		$m++;
		}
		echo "<td><span style=\"display:inline-block;width:200px;\"><label style=\"margin-bottom:0px;\">订单编号：<a href=\"javascript:void(0);\">".$resp->trade->tid."</a></label></span><span>成交时间：".$resp->trade->created."</span></td></tr>";
		echo "<tr class=\"tr-body border-no-top\">";
		echo "<td><div class=\"div-goods\"><div class=\"div-img\"><img src=\"".$resp->trade->pic_path."\"></div><div class=\"div-goods-name\">".$goods."</div></div></td>";
		echo "<td><div class=\"div-name\">".$resp->trade->receiver_name."</div></td>";
		echo "<td><div class=\"div-mobile\">".@$resp->trade->receiver_mobile."</div></td>";
		echo "<td><div class=\"div-address\">".$resp->trade->receiver_state.$resp->trade->receiver_city.$resp->trade->receiver_district.$resp->trade->receiver_address."</div></td>";
		echo "<td><div class=\"div-buyer-memo\">".@$resp->trade->buyer_message."</div></td>";
		echo "<td><div class=\"div-buyer-memo\">".@$resp->trade->seller_memo."</div></td>";
		echo "<td><div class=\"div-status\">".getOrderStatus($resp->trade->status)."</div></td>";
		echo "<td style=\"width:300px;text-align:center;\"><a href=\"javascript:void(0);\" class=\"opener\">打印快递单</a></td>";
		echo "</tr>";
		echo "<tr style=\"height:8px;\"><td></td></tr>";
		echo "</tbody>";
		$goods="";
	}
?>
<html>
<head>
<title></title>
<link rel="stylesheet" type="text/css" href="css/base.css">
<link rel="stylesheet" type="text/css" href="css/forms.css">
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
	  	var tid=$(this).parent().parent().prev().find("a:eq(0)").text();
	  	var url="print.php?tid="+tid;

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
			<div style="height:170px;"><?php include 'top.html';?></div>
		</div>
		<div class="row">
			<?php include 'leftside.html';?>
			<div style="width:1114px;margin:0 auto;">
				<table class="table">
					<?php
						$result=$operatedb->Execsql("select * from orders where uID='".$uID."' and printStatus='' limit ".$pagenum.",20",$conn);
						
						if ($pageNo<$lastPage) {
							# code...
							$per=19;
						}elseif ($pageNo==$lastPage) {
							# code...
							$per=$result_page[0][0]-($pageNo-1)*20-1;
						}elseif ($lastPage==0) {
							# code...
							$per=-1;
						}
						$i=0;
						while ($i <= $per) {
							$resp=getInfoById($result[$i]['tID']);
							drawBody($resp);
							$i++;
						}
					?>
				</table>
			</div>
		</div>
	</div>
<div class="row" style="float:right;padding-right:35px;">
<?php
 	$page=new Fenye($result_page[0][0],20,'unprint.php');
 	$page->showFenye($pageNo);
?>
</div>
<div id="dialog" title="快递详细"></div>
</body>
</html>
