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

	$req = new TradeFullinfoGetRequest;
	$req->setFields("created,num_iid,receiver_name,receiver_state,receiver_city,receiver_district,receiver_address,receiver_mobile,total_fee,orders.title,orders.num");
	if (isset($_GET['tid'])&&!empty($_GET['tid'])) {
		# code...
		$req->setTid($_GET['tid']);
	}
	$resp = $c->execute($req, $sessionKey);
	$sender=$operatedb->Execsql("select * from user where uID='".$uID."'",$conn);
	
?>
<html>
<head>
<title></title>
<script type="text/javascript">
	function print(express)
	{
		var tid=$("#tid").html();
		$.get("print.php?print="+tid);

		var content=$("#img").html();
		var newwin=window.open('','content','width=910,height=500');
		newwin.document.write("<html><head><title></title>");
		newwin.document.write("<link rel=\"stylesheet\" type=\"text/css\" href=\"css/express/"+express+"\">");
		newwin.document.write("</head><body>");
		newwin.document.write(content);
		newwin.document.write("</body></html>");

		newwin.print();
		newwin.close();
		

	}

</script>
<script type="text/javascript">
$(function(){
	$("#name").draggable();
	$("#address").draggable();
	$("#mobile").draggable();
	$("#sendname").draggable();
	$("#sendaddress").draggable();
	$("#sendtel").draggable();
	$("#sendshopname").draggable();
	$("#custommark1").draggable();
	$("#custommark2").draggable();
	$("#custommark3").draggable();
});
</script>
</head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" id="style" href="css/express/sto.css">
<body>
	<div id="tid" style="display:none;"><?php echo @$_GET['tid'];?></div>
<?php
	if (isset($_GET['print'])&&!empty($_GET['print'])) {
		# code...
		$tID=$_GET['print'];
		$result=$operatedb->Execsql("update orders set printStatus='printed' where tID='".$tID."'",$conn);
	}elseif (isset($_GET['send'])&&!empty($_GET['send'])) {
		# code...
		$tID=$_GET['send'];
		$req = new TradeFullinfoGetRequest;
		$req->setFields("num_iid");
		$req->setTid($_GET['send']);
		$resp = $c->execute($req, $sessionKey);
		$result=$operatedb->Execsql("update orders set printStatus='sent' where tID='".$tID."'",$conn);
		$result_minus=$operatedb->Execsql("update stocklist set stock=stock-1 where uID='".$uID."' and numID='".$resp->trade->num_iid."'",$conn);
	}elseif (isset($_GET['delete'])&&!empty($_GET['delete'])) {
		# code...
		$tID=$_GET['delete'];
		$result=$operatedb->Execsql("delete from orders where tID='".$tID."'",$conn);
	}elseif (isset($_GET['stock'])&&!empty($_GET['stock'])) {
		# code...
		$numID=$_GET['numID'];
		$result=$operatedb->Execsql("update stocklist set stock='".$_GET['stock']."' where numID='".$numID."'",$conn);
	}elseif (isset($_GET['username'])&&!empty($_GET['username'])) {
		# code...
		$result=$operatedb->Execsql("update user set userName='".$_GET['username']."' , userTel='".$_GET['usertel']."' , userShopname='".$_GET['usershopname']."' , userAddress='".$_GET['useraddress']."' , customMark1='".$_GET['usermark1']."' , customMark2='".$_GET['usermark2']."' , customMark3='".$_GET['usermark3']."' where uID='".$uID."'",$conn);
	}elseif (isset($_GET['insertmark'])&&!empty($_GET['insertmark'])) {
		# code...
		$mark=$_GET['insertmark'];
		$refundID=$_GET['refundID'];
		$result=$operatedb->Execsql("update refundlist set mark='".$mark."' where uID='".$uID."' and refundID='".$refundID."'",$conn);
	}elseif (isset($_GET['css'])&&!empty($_GET['css'])) {
		# code...
		$result=$operatedb->Execsql("update user set ".$_GET['css']."='".$_GET['customexpress']."' where uID='".$uID."'",$conn);
	}elseif (isset($_GET['insert'])&&!empty($_GET['insert'])) {
		# code...
		$num_iid=$_GET['insert'];
		$refund=$_GET['refund'];
		$result=$operatedb->Execsql("update stocklist set stock=stock+1 where numID='".$num_iid."'",$conn);
		$result1=$operatedb->Execsql("update refundlist set status='1' where uID='".$uID."' and refundID='".$refund."'",$conn);
	}elseif (isset($_GET['deleterefund'])&&!empty($_GET['deleterefund'])) {
		# code...
		$result=$operatedb->Execsql("delete from refundlist where refundID='".$_GET['deleterefund']."'",$conn);
	}
	
?>
<div id="radio" style="margin-bottom: 20px;">
<div style="width:100px; height:20px; float:left;">申通快递<input type="radio" checked="checked" name="kuaidi" onclick="sto()"></div>
<div style="width:100px; height:20px; float:left;">韵达快递<input type="radio" name="kuaidi" onclick="yunda()"></div>
<div style="width:100px; height:20px; float:left;">自定义一<input type="radio" name="kuaidi" onclick="custom1()"></div>
<div style="width:100px; height:20px; float:left;">自定义二<input type="radio" name="kuaidi" onclick="custom2()"></div>
<div style="width:100px; height:20px; float:left;">自定义三<input type="radio" name="kuaidi" onclick="custom3()"></div>
</div>
<div style="height:500px; width:910px; background-image:url(source/sto.PNG);" id="img">
	<div id="name"><?php echo $resp->trade->receiver_name;?></div>
	<div id="address"><?php echo $resp->trade->receiver_state.$resp->trade->receiver_city.$resp->trade->receiver_district.$resp->trade->receiver_address;?></div>
	<div id="mobile"><?php echo $resp->trade->receiver_mobile;?></div>
	<div id="sendname"><?php echo $sender[0]['userName'];?></div>
	<div id="sendaddress"><?php echo $sender[0]['userAddress'];?></div>
	<div id="sendtel"><?php echo $sender[0]['userTel'];?></div>
	<div id="sendshopname"><?php echo $sender[0]['userShopname'];?></div>
	<div id="custommark1"><?php echo $sender[0]['customMark1'];?></div>
	<div id="custommark2"><?php echo $sender[0]['customMark2'];?></div>
	<div id="custommark3"><?php echo $sender[0]['customMark3'];?></div>
</div>
<!-- <input type="submit" value="打印" id="print" onclick="print('sto.css')"> -->
<input type="submit" value="打印" id="print" onclick="print('sto.css')">
<script type="text/javascript">
 	function sto()
 	{
 		$("#name").attr('style','');
		$("#address").attr('style','');
		$("#mobile").attr('style','');
		$("#sendname").attr('style','');
		$("#sendaddress").attr('style','');
		$("#sendtel").attr('style','');

 		$("#img").attr('style','background-image:url(source/sto.PNG);height:500px; width:910px;');
 		$("#style").attr('href','css/express/sto.css');
 		$("#print").attr('onclick','print(\'sto.css\')');
 		
 	}
 	function yunda()
 	{
 		$("#name").attr('style','');
		$("#address").attr('style','');
		$("#mobile").attr('style','');
		$("#sendname").attr('style','');
		$("#sendaddress").attr('style','');
		$("#sendtel").attr('style','');

 		$("#img").attr('style','background-image:url(source/yunda.PNG);height:500px; width:910px;');
 		$("#style").attr('href','css/express/yunda.css');
 		$("#print").attr('onclick','print(\'yunda.css\')');
 	}
 	function custom1()
 	{
 		$("#img").attr('style','height:500px; width:910px;');
 		$("#style").attr('href','');

 		var url1="readcss.php?customexpress1";
		$.get(url1,function(result1){
			var arr1=result1.split("%");
			$("#name").css({"left":arr1[0],"top":arr1[1]});
			$("#address").css({"left":arr1[2],"top":arr1[3]});
			$("#mobile").css({"left":arr1[4],"top":arr1[5]});
			$("#sendname").css({"left":arr1[6],"top":arr1[7]});
			$("#sendaddress").css({"left":arr1[8],"top":arr1[9]});
			$("#sendtel").css({"left":arr1[10],"top":arr1[11]});
		});
		// $("#print").attr('onclick','print(\'customexpress1\')');

 	}
 	function custom2()
	{
		$("#img").attr('style','height:500px; width:910px;');
		$("#style").attr('href','');

		var url2="readcss.php?customexpress2";
		$.get(url2,function(result2){
			var arr2=result2.split("%");
			$("#name").css({"left":arr2[0],"top":arr2[1]});
			$("#address").css({"left":arr2[2],"top":arr2[3]});
			$("#mobile").css({"left":arr2[4],"top":arr2[5]});
			$("#sendname").css({"left":arr2[6],"top":arr2[7]});
			$("#sendaddress").css({"left":arr2[8],"top":arr2[9]});
			$("#sendtel").css({"left":arr2[10],"top":arr2[11]});
		});
		// $("#print").attr('onclick','print(\'customexpress2\')');
	}
	function custom3()
	{
		$("#img").attr('style','height:500px; width:910px;');
		$("#style").attr('href','');

		var url3="readcss.php?customexpress3";
		$.get(url3,function(result3){
			var arr3=result3.split("%");
			$("#name").css({"left":arr3[0],"top":arr3[1]});
			$("#address").css({"left":arr3[2],"top":arr3[3]});
			$("#mobile").css({"left":arr3[4],"top":arr3[5]});
			$("#sendname").css({"left":arr3[6],"top":arr3[7]});
			$("#sendaddress").css({"left":arr3[8],"top":arr3[9]});
			$("#sendtel").css({"left":arr3[10],"top":arr3[11]});
		});
		// $("#print").attr('onclick','print(\'customexpress3\')');
	}
</script>
</body>
</html>