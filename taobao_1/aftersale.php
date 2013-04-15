<?php
	header("Content-type:text/html;charset=utf-8");
	require "conndb.inc.php";
	require_once 'config.php';


	$result_page=$operatedb->Execsql("select count(*) from aftersale where uID='".$uID."'",$conn);
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
.border{
	border-width:thin;
	border:1px solid #dddddd;
}
.center{
	text-align: center;
}
</style>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css">
<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<script>
	$(function() {

	  $( ".zhankai" ).click(function() {
	  	// $(".mark").slideToggle("fast",function(){ });
	  	if ($(this).text()=="展开") {
	  		$(this).text("合并");
	  	} else{
	  		$(this).text("展开");
	  	};
	  	$(this).parent().parent().next().toggle();
	  });
	  $(".addmark").click(function(){
	  	if($(this).text()!="添加"){
	  		$(this).prev().removeAttr("style");
	  		$(this).text("添加");
	  	}else{
	  		var markcontent=$(this).prev().val();
	  		var title=$(this).parents().prev().children("div:eq(1)").text();
	  		if (markcontent!='') {
	  			$(this).prev().css("display","none");
	  			$(this).parent().before($("<div></div>").text(markcontent));
	  			$(this).parent().prev().addClass("span17 border");
	  			$(this).parent().prev().css("margin-top","2px");
	  			$(this).text("添加新记录");
	  			var url="print.php?addmark="+markcontent+"&title="+title;
	  			$.get(url);
	  		}else{

	  		}
	  	};
	  });

	  $("#addmark").click(function(){
	  	if($(this).text()!="添加"){
	  		$(this).prev().removeAttr("style");
	  		$(this).text("添加");
	  	}else{
	  		var addcontent=$(this).prev().val();
	  		if (addcontent!='') {
	  			
	  			$(this).prev().css("display","none");
	  			$(this).text("添加新的线下售后");
	  			var url="print.php?addaftersale="+addcontent;
	  			$.get(url,function(){
	  				location.reload(true).delay(1000);
	  			});
	  			
	  			
	  		} else{};
	  	};
	  });

	  $(".delete").click(function(){
	  	$(this).text("已删除");
	  	 var title=$(this).parent().prev().prev().text();
	  	 var url1="print.php?deleteaftersale="+title;
	  	 $.get(url1,function(){
	  	 	location.reload(true).delay(1000);
	  	 });
	  	 
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
				<?php
					$result=$operatedb->Execsql("select * from aftersale where uID='".$uID."'",$conn);
					// $per = (( $pageNo == $lastPage) ? $result_page[0][0]%20-1 : 19);
					$i=0;
					while ($i <= $result_page[0][0]-1) {
						# code...
						echo "<div class=\"span17 border\" style=\"	margin-top:5px;background: #e8f2ff;border: 1px solid #B4D5FF;\">".
								"<div class=\"center\" style=\"width:30px; float:left;\">".($i+1)."</div>".
								"<div class=\"center\" style=\"float:left;border-left: 1px solid #dddddd;border-right:1px solid #dddddd; width:500px;\">".$result[$i]['title']."</div>".
								"<div class=\"center\" style=\"float:left; width:50px;\"><a href=\"javascript:;\" class=\"zhankai\">展开</a>".
								"</div>".
								"<div class=\"center\" style=\"float:left; width:50px;border-left: 1px solid #dddddd;\"><a href=\"javascript:;\" class=\"delete\" style=\" \">删除</a>".
								"</div>".
							"</div>";
						$arr=explode("mark", $result[$i]['mark']);
						$count=count($arr);
						echo "<div class=\"mark\" style=\"display:none;\">";
						$j=1;
						while ($j <= $count-1) {
							# code...
							echo "<div class=\"span17 border\" style=\"margin-top:2px;\">".$arr[$j]."</div>";
							$j++;
						}
						echo "<div class=\"span17\"><input type=\"text\" style=\"display:none;\"><a href=\"javascript:;\" class=\"addmark\">添加新记录</a></div>";
						echo "</div>";
						$i++;
					}
					echo "<div class=\"span17 border\" style=\"margin-top:5px;\"><input tpye=\"text\" style=\"display:none;\"><a href=\"javascript:;\" id=\"addmark\">添加新的线下售后</a><div>";
				?>
			</div>
		</div>
	</div>
</body>
</html>
