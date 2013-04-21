<?php
	require "conndb.inc.php";
	require_once 'config.php';
	$sessionKey=$_COOKIE['sessionKey'];
	$uID=$_COOKIE['uID'];
	
	require_once 'request.php';
	getData('stock');


	function getInfoById($num_iid){
		require_once 'config.php';
		global $sessionKey,$appkey,$secretKey,$format,$c;
		$req = new ItemGetRequest;
		$req->setFields("num_iid,title,num,sku,pic_url");
		$req->setNumIid($num_iid);
		$resp = $c->execute($req, $sessionKey);
		return $resp;
	}
	function drawBody($resp){
		require_once 'config.php';
		global $operatedb,$uID,$conn;
		echo "<div class=\"div-head\"><span style=\"display:inline-block;width:200px;\"><label style=\"margin-bottom:0px;\">商品编号：".$resp->item->num_iid."</label></span><span>商品名称：".$resp->item->title."</span><span style=\"display:none;\">".$resp->item->pic_url."</span></div>";
		echo "<div class=\"div-list\" style=\"display:none;\">";
		echo "<div class=\"div-info\" style=\"height:20px;\"><span style=\"display:inline-block;width:500px;text-align:center;\">销售属性</span><span style=\"display:inline-block;width:80px;text-align:center;\">sku</span><span style=\"display:inline-block;width:100px;text-align:center;\">显示库存</span><span style=\"display:inline-block;width:100px;text-align:center;\">实际库存</span><span style=\"display:inline-block;width:100px;text-align:center;\">设置预警库存</span></div>";
		$skuscount=count($resp->item->skus->sku);
		$m=0;
		if ($skuscount==0) {
			# code...
			$skus="empty";
		}else{
			while ($m <= $skuscount-1) {
				if ($skuscount==1) {
					# code...
					$prop=$resp->item->skus->sku[0]->properties_name;
					$sku_id=$resp->item->skus->sku[0]->sku_id;
					$result_sku=$operatedb->Execsql("select * from sku where num_iid='".$resp->item->num_iid."' and sku_id='".$sku_id."'",$conn);
					$arr=split(":", $prop);
					$str=$arr[2].":".$arr[3];
					echo "<div class=\"list-item\"><span style=\"display:inline-block;width:580px;\">".$str."</span><span style=\"display:inline-block;width:100px;\">".$resp->item->skus->sku[0]->quantity."</span><span style=\"display:inline-block;width:100px;\">".$result_sku[0]['stock']."</span><span style=\"display:inline-block;width:100px;\">设置预警库存</span></div>";
				}elseif ($skuscount>1) {
					# code...
					$prop=$resp->item->skus->sku[$m]->properties_name;
					$sku_id=$resp->item->skus->sku[$m]->sku_id;
					$result_sku=$operatedb->Execsql("select * from sku where num_iid='".$resp->item->num_iid."' and sku_id='".$sku_id."'",$conn);
					$arr=split(";", $prop);
					$count=count($arr);
					$r=0;
					while ($r <= $count-1) {
						# code...
						$str1=split(":", $arr[$r]);
						$str.=$str1[2].":".$str1[3];
						$r++;
					}
					echo "<div class=\"list-item\"><span style=\"display:inline-block;width:500px;\">".$str."</span><span style=\"display:inline-block;width:80px;\">".$sku_id."</span><span style=\"display:inline-block;width:100px;text-align:center;\">".$resp->item->skus->sku[0]->quantity."</span><span style=\"display:inline-block;width:100px;text-align:center;\" class=\"stock\"><input type=\"text\" style=\"display:none;\"><a href=\"javascript:;\">".$result_sku[0]['stock']."</a></span><span class=\"warn\" style=\"display:inline-block;width:100px;text-align:center;\"><input type=\"text\" style=\"display:none;\"><a href=\"javascript:;\">".$result_sku[0]['warn']."</a></span></div>";
				}
				$str="";
				$m++;
			}

		}

		echo "</div>";
	}

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
<link rel="stylesheet" type="text/css" href="css/stock.css">
<style type="text/css">
.list-item{
	border: 1px solid #B4D5FF;
	margin-bottom: 1px;
	padding-left: 2px;
}
</style>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css">
<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<script>
$(document).ready(function(){

	  $(".stock").each(function(){
		  	if(Number($(this).find("a").text())<0)
		  {
		  	$(this).css("background-color","red");
		  	$(this).parent().parent().prev().css("background-color","red");
		  }else if(Number($(this).find("a").text())<Number($(this).next().find("a").text())){
		  	$(this).css("background-color","yellow");
		  	$(this).parent().parent().prev().css("background-color","yellow");
		  }else{

		  }
	  });
	  $(".div-head").click(function(){
	  	$(this).next().toggle();
	  });
	  $(".stock").mouseover(function(){
	  	$(this).attr("title","点击修改");
	  });
	  $(".stock").click(function(){
	  	if ($(this).children("a:eq(0)").text()!="确定") {
	  		var value=$(this).children("a:eq(0)").text();
		  	$(this).children("input:eq(0)").removeAttr("style");
		  	$(this).children("input:eq(0)").css({"height":"20","width":"50"});
		  	$(this).children("input:eq(0)").val(value);
		  	$(this).children("a:eq(0)").text("确定");
	  	} else{
	  		var sku=$(this).prev().prev().text();
	  		var num_iid=$(this).parents().parent().prev().find("label").text().split("商品编号：");
	  		var input=$(this).children("input:eq(0)").val();
	  		var url="print.php?updatesku="+num_iid[1]+"&sku="+sku+"&value="+input;
	  		$(this).children("input:eq(0)").css("display","none");
	  		$(this).children("a:eq(0)").text(input);
	  		$.get(url);
	  	};
	  });
	  $(".warn").click(function(){
	  	if ($(this).children("a:eq(0)").text()!="确定") {
	  		var value=$(this).children("a:eq(0)").text();
		  	$(this).children("input:eq(0)").removeAttr("style");
		  	$(this).children("input:eq(0)").css({"height":"20","width":"50"});
		  	$(this).children("input:eq(0)").val(value);
		  	$(this).children("a:eq(0)").text("确定");
	  	} else{
	  		var sku=$(this).parent().find("span:eq(1)").text();
	  		var num_iid=$(this).parents().prev().find("label").text().split("商品编号：");
	  		var input=$(this).children("input:eq(0)").val();
	  		var url="print.php?updatewarn="+num_iid[1]+"&sku="+sku+"&value="+input;
	  		$(this).children("input:eq(0)").css("display","none");
	  		$(this).children("a:eq(0)").text(input);
	  		$.get(url);
	  	};
	  });
	  $(".div-head").mouseover(function(){
	  	var url=$(this).find("span:eq(2)").text();
	  	var img=$("<img>");
	  	$(this).before(img);
	  	$(this).prev().attr("src",url);
	  	$(this).prev().css({"z-index":"5009","position":"fixed"});


	  });
	  $(".div-head").mouseout(function(){
	  	$(this).prev().remove();
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
				<?php
					$result=$operatedb->Execsql("select * from stocklist where uID='".$uID."' limit ".$pagenum.",20",$conn);
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

						$resp=getInfoById($result[$i]['numID']);
						
						drawBody($resp);

						$i++;
					}
				?>
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
 	$page=new Fenye($total,20,'sku.php');
 	$page->showFenye($pageNo);
 ?>
</div>
</body>
</html>
