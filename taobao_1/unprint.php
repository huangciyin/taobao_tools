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
				<table class="table table-bordered table-condensed" style="margin-top: 10px;">
					<colgroup>
		                <col class="span2"></col>
		                <col class="span1"></col>
		                <col class="span4"></col>
						<col class="span1"></col>
						<col class="span2"></col>
						<col class="span4"></col>
            		</colgroup>
					<thead>
						<tr>
							<th>交易编号</th>
							<th>姓名</th>
							<th>地址</th>
							<th>电话</th>
							<th>操作</th>
							<th>商品</th>
						</tr>
					</thead>
					<tbody>
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
								# code...
								echo "<tr>";
								echo "<td>".$result[$i]['tID']."</td>";
								$req=new TradeFullinfoGetRequest;
								$req->setFields("receiver_name,receiver_state,receiver_city,receiver_district,receiver_address,receiver_mobile,orders.title,orders.num");
								$req->setTid($result[$i]['tID']);
								$resp=$c->execute($req,$sessionKey);
								echo "<td>".$resp->trade->receiver_name."</td>";
								echo "<td>".$resp->trade->receiver_state.$resp->trade->receiver_city.$resp->trade->receiver_district.$resp->trade->receiver_address."</td>";
								echo "<td>".$resp->trade->receiver_mobile."</td>";
								echo "<td><a href=\"javascript:void(0);\" class=\"opener\">打印快递单</a></td>";
								$goodscount=count($resp->trade->orders->order)-1;
								$m=0;
								while ($m <= $goodscount) {
									# code...
									@$goods.=$resp->trade->orders->order[$m]->title." X ".$resp->trade->orders->order[$m]->num;
									$m++;
								}
								echo "<td>".$goods."</td>";
								$goods="";
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
 	$page=new Fenye($total,20,'unprint.php');
 	$page->showFenye($pageNo);
 ?>
</div>
<div id="dialog" title="快递详细"></div>
</body>
</html>
