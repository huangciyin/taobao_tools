<?php

	require "conndb.inc.php";
	require_once 'config.php';
	$sessionKey=$_COOKIE['sessionKey'];
	$uID=$_COOKIE['uID'];


	$result_page=$operatedb->Execsql("select count(*) from orders where uID='".$uID."' and printStatus='printed'",$conn);
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
		$req->setFields("tid,pic_path,created,status,receiver_name,receiver_state,receiver_city,receiver_district,receiver_address,receiver_mobile,orders.title,orders.num,buyer_memo,seller_memo");
		$req->setTid($tid);
		$resp = $c->execute($req, $sessionKey);
		return $resp;
	}

	function drawBody($resp){
		echo "<tr>";
		echo "<td>".$resp->trade->tid."</td>";
		echo "<td>".$resp->trade->receiver_name."</td>";
		echo "<td>".$resp->trade->receiver_state.$resp->trade->receiver_city.$resp->trade->receiver_district.$resp->trade->receiver_address."</td>";
		echo "<td>".@$resp->trade->receiver_mobile."</td>";
		echo "<td><a href=\"javascript:void(0);\" class=\"opener\">重新打印</a></td>";
		echo "<td><a href=\"javascript:void(0);\" class=\"send\">发货</a></td>";
		echo "</tr>";
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
	font-size: 12px;
}
</style>
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
	  	var tid=$(this).parent().parent().children("td:eq(0)").html();
	  	var url="print.php?tid="+tid;

	  	$.get(url,function(result){
	  		$("#dialog").html(result);
	  	});

	    $( "#dialog" ).dialog( "open" );


	  });

	  $("#dialog-express").dialog({
	  	autoOpen: false,
	      height: 200,
	      width: 350,
	      modal: true,
	       buttons: {
	        "确定": function() {
	        	if ($("#express").val()!='') {
	        		var exp_num=$("#express").val();
	        		var url=surl+"&exp_num="+exp_num;
	        		$.get(url);
	        		$( this ).dialog( "close" );
	        	}else{

	        	};
	        },
	        "取消": function() {
	          $( this ).dialog( "close" );
	        }
      }
	  });
	  $(".send").click(function(){
	  	
	  	var sid=$(this).parent().parent().children("td:eq(0)").html();
	  	window.surl="print.php?send="+sid;
	  	$("#dialog-express").dialog("open");
	  	
	  	
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
				<table class="table table-bordered table-condensed">
					<colgroup>
		                <col class="span2"></col>
		                <col class="span2"></col>
		                <col class="span5"></col>
						<col class="span2"></col>
						<col class="span2"></col>
						<col class="span2"></col>
            		</colgroup>
					<thead>
						<tr>
							<th>交易编号</th>
							<th>收件人姓名</th>
							<th>收件人地址</th>
							<th>收件人电话</th>
							<th>操作</th>
							<th>发货</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$result=$operatedb->Execsql("select * from orders where uID='".$uID."' and printStatus='printed' limit ".$pagenum.",20",$conn);
							// $per = (( $pageNo == $lastPage) ? $result_page[0][0]-($pageNo-1)*20-1 : 19);
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
								# code...
								$resp=getInfoById($result[$i]['tID']);
								drawBody($resp);
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
 	$page=new Fenye($result_page[0][0],20,'printed.php');
 	$page->showFenye($pageNo);
 ?>
</div>
<div id="dialog" title="快递详细"></div>
<div id="dialog-express" title="请输入运单号">
<form>
  <fieldset>
    <label for="express">运单号</label>
    <input type="text" name="express" id="express"/>
  </fieldset>
  </form>
</div>
</body>
</html>
