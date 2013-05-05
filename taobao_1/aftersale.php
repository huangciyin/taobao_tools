<?php

	require_once "conndb.inc.php";
	require_once 'config.php';
	$sessionKey=$_COOKIE['sessionKey'];
	$uID=$_COOKIE['uID'];

	if ( isset( $_GET['pageNo']) && !empty( $_GET['pageNo'])) {
		$pageNo=$_GET['pageNo'];
	}else{
		$pageNo = 1;
	}
	
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
		echo "<tr class=\"tr-head\">";
		$goodscount=count($resp->trade->orders->order)-1;
		$m=0;
		while ($m <= $goodscount) {
		# code...
		@$goods.=$resp->trade->orders->order[$m]->title." X ".$resp->trade->orders->order[$m]->num;
		$m++;
		}
		echo "<td><span style=\"display:inline-block;width:200px;\"><label style=\"margin-bottom:0px;\">订单编号：<a href=\"javascript:void(0);\" class=\"opener\">".$resp->trade->tid."</a></label></span><span>成交时间：".$resp->trade->created."</span></td></tr>";
		echo "<tr class=\"tr-body border-no-top\">";
		echo "<td><div class=\"div-goods\"><div class=\"div-img\"><img src=\"".$resp->trade->pic_path."\"></div><div class=\"div-goods-name\">".$goods."</div></div></td>";
		echo "<td><div class=\"div-name\">".$resp->trade->receiver_name."</div></td>";
		echo "<td><div class=\"div-mobile\">".@$resp->trade->receiver_mobile."</div></td>";
		echo "<td><div class=\"div-address\">".$resp->trade->receiver_state.$resp->trade->receiver_city.$resp->trade->receiver_district.$resp->trade->receiver_address."</div></td>";
		echo "<td><div class=\"div-buyer-memo\">".@$resp->trade->buyer_message."</div></td>";
		echo "<td><div class=\"div-buyer-memo\">".@$resp->trade->seller_memo."</div></td>";
		echo "<td><div class=\"div-status\">".getOrderStatus($resp->trade->status)."</div></td>";
		echo "<td><div class=\"div-active\"><a class=\"aftersale\" href=\"javascript:;\">进入处理</a></div></td>";
		echo "<td><div class=\"div-mark\">".drawMark($resp->trade->tid)."</div></td>";
		echo "</tr>";
		echo "<tr style=\"height:8px;\"><td></td></tr>";
		echo "</tbody>";
		$goods="";
	}

	function drawTable($tid){
		require_once 'config.php';
		global $operatedb,$uID,$conn;
		$select=$operatedb->Execsql("select * from aftersale where title='".$tid."' and uID='".$uID."'",$conn);
		if ($select==true) {
			if ($select[0]['status']=="open") {
				$arr=explode("mark", $select[0]['mark']);
				$count=count($arr);
				echo "<tbody style=\"display:none;\">";
				$j=1;
				while ($j <= $count-1) {
					echo "<tr style=\"border: 1px solid #B4D5FF;border-top: transparent;\">";
					echo "<td>备注".$j.":".$arr[$j]."</td>";
					echo "</tr>";
					$j++;
				}
				echo "<tr style=\"border: 1px solid #B4D5FF;border-top: transparent;\">";
				echo "<td><input type=\"text\" style=\"display:none;\"><a href=\"javascript:;\" class=\"addmark\">添加新记录</a></td>";
				echo "</tr>";
				echo "</tbody>";
			}else{
				$arr=explode("mark", $select[0]['mark']);
				$count=count($arr);
				echo "<tbody style=\"display:none;\">";
				$j=1;
				while ($j <= $count-1) {
					echo "<tr style=\"border: 1px solid #B4D5FF;border-top: transparent;\">";
					echo "<td>备注".$j.":".$arr[$j]."</td>";
					echo "</tr>";
					$j++;
				}
				echo "<tr style=\"border: 1px solid #B4D5FF;border-top: transparent;\">";
				// echo "<td><input type=\"text\" style=\"display:none;\"><a href=\"javascript:;\" class=\"addmark\">添加新记录</a></td>";
				echo "</tr>";
				echo "</tbody>";
			}
		}
	}

	function drawMark($tid){
		require_once 'config.php';
		global $operatedb,$uID,$conn;
		$select=$operatedb->Execsql("select * from aftersale where title='".$tid."' and uID='".$uID."'",$conn);
		if ($select==true) {
			if ($select[0]['status']=='open') {
				$arr=explode("mark", $select[0]['mark']);
				$count=count($arr);
				$j=1;
				while ($j <= $count-1) {
					@$str.= "<div style=\"height:15px;width:169px;overflow:hidden; border-bottom: 1px solid #B4D5FF;\">备注".$j.":".$arr[$j]."</div>";
					$j++;
				}
				return @$str."<div style=\"height:20px;width:169px;overflow:hidden; border-bottom: 1px solid #B4D5FF;\"><input type=\"text\" style=\"display:none;height:20px;width:100px;\"><a href=\"javascript:;\" class=\"addmark\">添加新记录</a></div>";
			}elseif ($select[0]['status']=='close') {
				$arr=explode("mark", $select[0]['mark']);
				$count=count($arr);
				$j=1;
				while ($j <= $count-1) {
					@$str.= "<div style=\"height:15px;width:169px;overflow:hidden; border-bottom: 1px solid #B4D5FF;\">备注".$j.":".$arr[$j]."</div>";
					$j++;
				}
				return @$str;
			}
			
		}else{
			return "<div style=\" display:none;height:20px;width:169px;overflow:hidden; border-bottom: 1px solid #B4D5FF;\"><input type=\"text\" style=\"display:none;height:20px;width:100px;\"><a href=\"javascript:;\" class=\"addmark\">添加新记录</a></div>";
		}
	}
?>
<html>
<head>
<title></title>
<link rel="stylesheet" type="text/css" href="css/base.css">
<link rel="stylesheet" type="text/css" href="css/forms.css">
<link rel="stylesheet" type="text/css" href="css/index.css">
<style type="text/css">
li{
	display: inline;
	padding-left: 20px;
	font-size: 15px;
}
tbody{
	font-size: 12px;
}
</style>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css">
<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<script>
	$(function() {

	  $( ".aftersale" ).click(function() {
	  	if ($(this).text()=="进入处理") {
	  		$(this).text("合并");
	  	} else{
	  		$(this).text("进入处理");
	  	};
	  	$(this).parent().parent().parent().parent().next().toggle();
	  });
	  $(".addmark").click(function(){
	  	if($(this).text()!="添加"){
	  		$(this).prev().css("display","");
	  		$(this).text("添加");
	  	}else{
	  		var markcontent=$(this).prev().val();
	  		var title=$(this).parent().parent().parent().parent().prev().find("a:eq(0)").text();
	  		if (markcontent!='') {
	  			$(this).prev().css("display","none");
	  			$(this).parent().before($("<div></div>").text(markcontent));
	  			$(this).parent().prev().css({"height":"16px","width":"169px","overflow":"hidden", "border-bottom":"1px solid #B4D5FF"});
	  			$(this).text("添加新记录");
	  			var url="print.php?addmark="+markcontent+"&title="+title;
	  			$.get(url);
	  		}else{

	  		}
	  	};
	  });

	  $(".deteleaftersale").click(function(){
	  	$(this).text("已删除");
	  	 var title=$(this).parent().parent().parent().prev().find("a:eq(0)").text();
	  	 var url1="print.php?deleteaftersale="+title;
	  	 $.get(url1,function(){
	  	 	location.reload(true);
	  	 });
	  	 
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
						$result_page=$operatedb->Execsql("select count(*) from aftersale where uID='".$uID."'",$conn);
						$itemNum=($pageNo-1)*20;
						$lastPage=ceil($result_page[0][0]/20);
						$total_result=$result_page[0][0];
						if ($pageNo<$lastPage) {
							$per=19;
						}elseif ($pageNo==$lastPage) {
							$per=$total_result-($pageNo-1)*20-1;
						}elseif ($lastPage==0) {
							$per=-1;
						}
						$result=$operatedb->Execsql("select * from aftersale where uID='".$uID."'",$conn);
						$i=0;
						while ($i <= $per) {
							$resp=getInfoById($result[$i]['title']);
							drawBody($resp);
							drawTable($result[$i]['title']);
							
							$i++;
						}
					?>
			    </table>
			</div>
		</div>
	</div>
<div class="row" style="float:right;padding-right:35px;">
<?php
 	$page=new Fenye($result_page[0][0],20,'aftersale.php');
 	$page->showFenye($pageNo);
?>
</div>
</body>
</html>
