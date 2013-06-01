<?php
	require_once 'config.php';
	require_once "conndb.inc.php";
	// $sessionKey=$_COOKIE['sessionKey'];
	// $uID=$_COOKIE['uID'];

	
	if (empty($sessions)) {
		echo "please <a href='login.php'>login</a>";exit;
	}else{
		$sessionKey = $_SESSION['topsession'];
		$uID = $_SESSION['uID'];
	}


	require_once 'request.php';
	getData('order');

	
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
		echo "<td><span style=\"display:inline-block;width:200px;\"><label style=\"margin-bottom:0px;\">订单编号：<a href=\"http://trade.taobao.com/trade/detail/trade_item_detail.htm?spm=a1z09.1.11.16.CRSBK5&bizOrderId=".$resp->trade->tid."\" class=\"opener\" target=\"_blank\">".$resp->trade->tid."</a></label></span><span>成交时间：".$resp->trade->created."</span></td></tr>";
		echo "<tr class=\"tr-body border-no-top\">";
		echo "<td><div class=\"div-goods\"><div class=\"div-img\"><img src=\"".$resp->trade->pic_path."\"></div><div class=\"div-goods-name\">".$goods."</div></div></td>";
		echo "<td><div class=\"div-name\">".$resp->trade->receiver_name."</div></td>";
		echo "<td><div class=\"div-mobile\">".@$resp->trade->receiver_mobile."</div></td>";
		echo "<td><div class=\"div-address\">".$resp->trade->receiver_state.$resp->trade->receiver_city.$resp->trade->receiver_district.$resp->trade->receiver_address."</div></td>";
		echo "<td><div class=\"div-buyer-memo\">".@$resp->trade->buyer_message."</div></td>";
		echo "<td><div class=\"div-buyer-memo\">".@$resp->trade->seller_memo."</div></td>";
		echo "<td><div class=\"div-status\">".getOrderStatus($resp->trade->status)."</div></td>";
		echo "<td><div class=\"div-active\">".checkAftersale($resp->trade->tid)."</div></td>";
		echo "<td><div class=\"div-mark\">".drawTable($resp->trade->tid)."</div></td>";
		echo "</tr>";
		echo "<tr style=\"height:8px;\"><td></td></tr>";
		echo "</tbody>";
		$goods="";
	}
	function checkAftersale($tid){
		require_once 'config.php';
		global $operatedb,$uID,$conn;
		$select=$operatedb->Execsql("select * from aftersale where title='".$tid."' and uID='".$uID."'",$conn);
		if ($select==true) {
			if ($select[0]['status']=='open') {
				$result="已添加售后<br><a class=\"closeaftersale\" href=\"javascript:;\">关闭售后</a>";
				return $result;
			}elseif ($select[0]['status']=='close') {
				$result="已关闭";
				return $result;
			}
		}else{
			$result="<a class=\"aftersale\" href=\"javascript:;\">添加线下售后</a>";
			return $result;
		}
	}

	function drawTable($tid){
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

	  $( "#opener" ).click(function() {
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
<script type="text/javascript">
$(function(){
	$(".aftersale").click(function(){
		var tID=$(this).parent().parent().parent().prev().find("a:eq(0)").text();
		$(this).parent().parent().next().find("div:eq(1)").css("display","");
		var url="print.php?addaftersale="+tID;
		$(this).text("已添加");
		$.get(url);
	});
	$(".closeaftersale").click(function(){
		var tID=$(this).parent().parent().parent().prev().find("a:eq(0)").text();
		$(this).parent().parent().next().find("a:eq(0)").remove();
		$(this).parent().text("已关闭");
		var url="print.php?closeaftersale="+tID;
		$.get(url);
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
						if (isset($_POST['search'])&&!empty($_POST['search'])) {
							require_once 'search.php';
							$result_search=search($_POST['search']);
							$total_result=count($result_search);
							if ($total_result!=0) {
								$per=$total_result-1;
								$i=0;
								while ($i <= $per) {
									$resp=getInfoById($result_search[$i]);
									drawBody($resp);
									$i++;
								}
							}else{
								echo "<script type=\"text/javascript\">alert(\"没有记录\");</script>";
							}	
						}else{
							$result_page=$operatedb->Execsql("select count(uID) from orders where uID='".$uID."'",$conn);
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
							$result=$operatedb->Execsql("select * from orders where uID='".$uID."' limit ".$itemNum.",20",$conn);
							$i=0;
							while ($i <= $per) {
								$resp=getInfoById($result[$i]['tID']);
								drawBody($resp);
								$i++;
							}

						}
					?>
				</table>
			</div>
		</div>
	</div>
<div class="row" style="float:right;padding-right:35px;">
<?php
 	$page=new Fenye($result_page[0][0],20,'index.php');
 	$page->showFenye($pageNo);
?>
</div>
<div id="dialog" title="订单详情"></div>
<div id="searchdialog" title="查询结果"></div>
</body>
</html>
