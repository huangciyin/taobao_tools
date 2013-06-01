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

	function drawTabel($arr_prop,$arr_sku,$arr_show,$arr_stock,$arr_warn)
	  {
	      $num=sizeof($arr_prop);
	      $i=0;
	      $arr_first=array();
	      $arr_second=array();
	      while ($i <= $num - 1) {
	        $arr1=explode(";", $arr_prop[$i]);
	        $arr_d1=explode(":", $arr1[0]);
	        $arr_d2=explode(":", $arr1[1]);
	        $str1=$arr_d1[2].":".$arr_d1[3];
	        $str2=$arr_d2[2].":".$arr_d2[3];
	        $arr_first[]=$str1;
	        $arr_second[]=$str2;
	        $i++;
	      }

	      $arr2=array_count_values($arr_first);
	      foreach ($arr2 as $key => $value) {
	        $arr4=array();
	        $arr3=explode(":", $key);
	        $arr4[]=$arr3[1];
	        $arr4[]=$value;
	        $arr7[]=$arr4;
	      }

	      foreach ($arr_second as $key => $value) {
	        $arr5=explode(":", $value);
	        $arr6[]=$arr5[1];
	      }

	      $num_prop=sizeof($arr7);
	      echo "<table class=\"table table-bordered\">
	      			<thead>
	      				<tr>
	      					<th colspan=2>销售属性</th>
	      					<th>sku</th>
	      					<th>显示库存</th>
	      					<th>实际库存</th>
	     					<th>设置预警库存</th>
	      				</tr>
	      			</thead>
	      		<tbody>";
	      $r=0;
	      while ($r <= $num_prop-1) {
	        echo "<tr>";
	        echo "<td rowspan=".$arr7[$r][1].">".$arr7[$r][0]."</td>";
	        $s=0;
	        while ($s <= $arr7[$r][1]-1) {
	          echo "<td>".$arr6[$s]."</td>";
	          echo "<td style=\"width:100px;\">".$arr_sku[$s]."</td>";
	          echo "<td >".$arr_show[$s]."</td>";
	          echo "<td class=\"stock\" style=\"width:140px;\"><input type=\"text\" style=\"display:none;\"><a href=\"javascript:;\">".$arr_stock[$s]."</a></td>";
	          echo "<td class=\"warn\" style=\"width:120px;\"><input type=\"text\" style=\"display:none;\"><a href=\"javascript:;\">".$arr_warn[$s]."</a></td>";
	          echo "</tr><tr>";
	          $s++;
	        }
	        $arr6=array_slice($arr6, $arr7[$r][1]);
	        $arr_sku=array_slice($arr_sku, $arr7[$r][1]);
	        $arr_show=array_slice($arr_show, $arr7[$r][1]);
	        $arr_stock=array_slice($arr_stock, $arr7[$r][1]);
	        $arr_warn=array_slice($arr_warn, $arr7[$r][1]);
	        $r++;
	      }
	      echo "</tbody></table>";
	  }


	function drawBody($resp){
		require_once 'config.php';
		global $operatedb,$uID,$conn;
		$result_alias=$operatedb->Execsql("select * from stocklist where numID='".$resp->item->num_iid."' and uID='".$uID."'",$conn);
		echo "<div style=\"height:50px;width:50px;float:left;margin-bottom: 7px;\"><span><img src=\"".$resp->item->pic_url."\" height=\"50px\" width=\"50px\"></span></div>";
		echo "<div class=\"div-head\"><span style=\"display:inline-block;width:200px;\"><label style=\"margin-bottom:0px;\">商品编号：".$resp->item->num_iid."</label></span><span class=\"alise\" style=\"display:inline-block;width:200px;\">商品别名：<input type=\"text\" style=\"display:none;\"><a href=\"javascript:;\">".$result_alias[0]['stockalise']."</a></span><span>商品名称：".$resp->item->title."</span><span class=\"span_toggle\" style=\"float:right; cursor: pointer;\">展开<span></div>";
		echo "<div class=\"div-list\" style=\"display:none;\">";
		// echo "<div class=\"div-info\" style=\"height:20px;\"><span style=\"display:inline-block;width:600px;text-align:center;\">销售属性</span><span style=\"display:inline-block;width:100px;text-align:center;\">sku</span><span style=\"display:inline-block;width:120px;text-align:center;\">显示库存</span><span style=\"display:inline-block;width:140px;text-align:center;\">实际库存</span><span style=\"display:inline-block;width:100px;text-align:center;\">设置预警库存</span></div>";
		$skuscount=count($resp->item->skus->sku);
		$m=0;
		if ($skuscount==0) {
			# code...
			$skus="empty";
			echo "<div class=\"list-item\">no data</div>";
		}else{
			while ($m <= $skuscount-1) {
				if ($skuscount==1) {
					# code...
					$prop=$resp->item->skus->sku[0]->properties_name;
					$sku_id=$resp->item->skus->sku[0]->sku_id;
					$result_sku=$operatedb->Execsql("select * from sku where num_iid='".$resp->item->num_iid."' and sku_id='".$sku_id."'",$conn);
					$arr=split(":", $prop);
					@$str=$arr[2].":".$arr[3];
					echo "<div class=\"list-item\"><span style=\"display:inline-block;width:580px;\">".$str."</span><span style=\"display:inline-block;width:100px;\">".$resp->item->skus->sku[0]->quantity."</span><span style=\"display:inline-block;width:100px;\">".$result_sku[0]['stock']."</span><span style=\"display:inline-block;width:100px;\">设置预警库存</span></div>";
				}elseif ($skuscount>1) {
					# code...
					$prop=$resp->item->skus->sku[$m]->properties_name;
					$sku_id=$resp->item->skus->sku[$m]->sku_id;
					$result_sku=$operatedb->Execsql("select * from sku where num_iid='".$resp->item->num_iid."' and sku_id='".$sku_id."'",$conn);
					$arr_prop[]=$prop;
					$arr_sku[]=$sku_id;
					$arr_show[]=$resp->item->skus->sku[$m]->quantity;
					$arr_stock[]=$result_sku[0]['stock'];
					$arr_warn[]=$result_sku[0]['warn'];
				}
				$m++;
			}
			drawTabel($arr_prop,$arr_sku,$arr_show,$arr_stock,$arr_warn);
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
<link rel="stylesheet" type="text/css" href="css/tables.css">
<style type="text/css">
.list-item{
	border: 1px solid #B4D5FF;
	margin-bottom: 1px;
	padding-left: 2px;
}
#search_btn{
	position: relative;
	width: 83px;
	height: 27px;
	line-height: 27px;
	font-size: 16px;
	background-color: #F89913;
	color: #fff;
	border: 0 none #D25102;
	cursor: pointer;
	-moz-border-radius: 0 3px 3px 0;
	-webkit-border-radius: 0 3px 3px 0;
	-khtml-border-radius: 0 3px 3px 0;
	border-radius: 0 3px 3px 0;
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
		  	// $(this).parents().parent().parent().prev().find("label").css("background-color","#43B3DC");
		  	var text_red=$("<span style=\"padding-left:10px; color:red;\"></span>").text("紧急补货");
		  	$(this).parents().parent().parent().prev().children("span:eq(3)").before(text_red);
		  }else if(Number($(this).find("a").text())<Number($(this).next().find("a").text())){
		  	$(this).css("background-color","yellow");
		  	// $(this).parents().parent().parent().prev().find("label").css("background-color","yellow");
		  	var text_yellow=$("<span style=\"padding-left:10px; color:#43B3DC;\"></span>").text("库存提醒");
		  	$(this).parents().parent().parent().prev().children("span:eq(3)").before(text_yellow);
		  }else{

		  }
	  });
	  $(".span_toggle").click(function(){
	  	if ($(this).text()=="展开") {
	  		$(this).parent().next().toggle();
	  		$(this).text("合并");
	  	}else if($(this).text()!="展开"){
	  		$(this).parent().next().toggle();
	  		$(this).text("展开");
	  	}
	  	
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
	  		var num_iid=$(this).parents().parent().parent().prev().find("label").text().split("商品编号：");
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
	  		var sku=$(this).prev().prev().prev().text();
	  		var num_iid=$(this).parents().prev().find("label").text().split("商品编号：");
	  		var input=$(this).children("input:eq(0)").val();
	  		var url="print.php?updatewarn="+num_iid[1]+"&sku="+sku+"&value="+input;
	  		$(this).children("input:eq(0)").css("display","none");
	  		$(this).children("a:eq(0)").text(input);
	  		$.get(url);
	  	};
	  });

	  $(".alise").click(function(){
	  	if ($(this).children("a:eq(0)").text()!="确定") {
	  		var value=$(this).children("a:eq(0)").text();
		  	$(this).children("input:eq(0)").removeAttr("style");
		  	$(this).children("input:eq(0)").css({"height":"20","width":"70"});
		  	$(this).children("input:eq(0)").val(value);
		  	$(this).children("a:eq(0)").text("确定");
		}else{
	  		var num_iid=$(this).parent().children().find("label").text().split("商品编号：");
	  		var input=$(this).children("input:eq(0)").val();
	  		var url="print.php?updatealise="+num_iid[1]+"&value="+input;
	  		$(this).children("input:eq(0)").css("display","none");
	  		$(this).children("a:eq(0)").text(input);
	  		$.get(url);
		};
	  });

	  // $(".div-head").mouseover(function(){
	  // 	var url=$(this).find("span:eq(2)").text();
	  // 	var img=$("<img>");
	  // 	$(this).before(img);
	  // 	$(this).prev().attr("src",url);
	  // 	$(this).prev().css({"z-index":"5009","position":"fixed","max-height":"200px","max-width":"200px"});


	  // });
	  // $(".div-head").mouseout(function(){
	  // 	$(this).prev().remove();
	  // });
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
 	$page=new Fenye($result_page[0][0],20,'sku.php');
 	$page->showFenye($pageNo);
?>
</div>
</body>
</html>
