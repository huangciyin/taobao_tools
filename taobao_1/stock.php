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
	// $nick=$user_resp->user->nick;


	require_once 'request.php';
	getData('stock');


	$result_page=$operatedb->Execsql("select count(*) from stocklist where uID='".$uID."'",$conn);
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
$(document).ready(function(){

	  $( ".alter" ).click(function() {
	  	if ($(this).text()!="确定") {
	  		var value=$(this).parent().children("a:eq(0)").text();
		  	$(this).parent().children("input:eq(0)").removeAttr("style");
		  	$(this).parent().children("input:eq(0)").val(value);
		  	$(this).text("确定");
	  	} else{
	  		var numID=$(this).parent().parent().children("td:eq(0)").html();
	  		var value=$(this).parent().children("input:eq(0)").val();
	  		var url="print.php?stock="+value+"&numID="+numID;
	  		$.get(url);
	  		$(this).parent().children("input:eq(0)").attr("style","display:none");
	  		$(this).text(value);
	  		location.reload();
	  	};
	  });

	  $(".alter").each(function(){
		  	if(Number($(this).text())<=5)
		  {
		  	$(this).parent().attr('style','background-color:red');
		  }else{

		  }
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
				<table class="table table-bordered table-condensed" style="margin-top: 7px;">
					<colgroup>
		                <col class="span2"></col>
		                <col class="span5"></col>
		                <col class="span2"></col>
						<col class="span2"></col>
            		</colgroup>
					<thead>
						<tr>
							<th>商品编号</th>
							<th>商品名称</th>
							<th>显示库存</th>
							<th>真实库存</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$result=$operatedb->Execsql("select * from stocklist where uID='".$uID."' limit ".$pagenum.",20",$conn);
							// $per = (( $pageNo == $lastPage) ? $result_page[0][0]%20-1 : 19);
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
								echo "<td>".$result[$i]['numID']."</td>";
								$req = new ItemGetRequest;
								$req->setFields("title,num");
								$req->setNumIid($result[$i]['numID']);
								$resp = $c->execute($req, $sessionKey);
								echo "<td>".$resp->item->title."</td>";
								echo "<td>".$resp->item->num."</td>";
								echo "<td><input type=\"text\" style=\"display:none;\"><a href=\"javascript:void(0);\" class=\"alter\">".$result[$i]['stock']."</a></td>";
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
 	$page=new Fenye($total,20,'stock.php');
 	$page->showFenye($pageNo);
 ?>
</div>
</body>
</html>
