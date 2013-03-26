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
		// $("#img").attr("style","background-image:");
		var tid=$("#tid").html();
		$.get("print.php?print="+tid);
		$("#print").val("已打印");
		setPrint(express);

	}
	function setPrint(prints)
	{
		var content=$("#img").html();
		var newwin=window.open('','content','width=910,height=500');
		newwin.document.write("<html><head><title></title>");
		newwin.document.write("<link rel=\"stylesheet\" type=\"text/css\" href=\"css/express/"+prints+"\">");
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
		$result=$operatedb->Execsql("update user set userName='".$_GET['username']."' , userTel='".$_GET['usertel']."' , userShopname='".$_GET['usershopname']."' , userAddress='".$_GET['useraddress']."' where uID='".$uID."'",$conn);
	}
	
?>
<div id="radio" style="margin-bottom: 20px;">
<div style="width:100px; height:20px; float:left;">申通快递<input type="radio" checked="checked" name="kuaidi" onclick="sto()"></div>
<div style="width:100px; height:20px; float:left;">韵达快递<input type="radio" name="kuaidi" onclick="yunda()"></div>
</div>
<div style="height:500px; width:910px; background-image:url(source/sto.PNG);" id="img">
	<div id="name"><?php echo $resp->trade->receiver_name;?></div>
	<div id="address"><?php echo $resp->trade->receiver_state.$resp->trade->receiver_city.$resp->trade->receiver_district.$resp->trade->receiver_address;?></div>
	<div id="mobile"><?php echo $resp->trade->receiver_mobile;?></div>
	<div id="sendname"><?php echo $sender[0]['userName'];?></div>
	<div id="sendaddress"><?php echo $sender[0]['userAddress'];?></div>
	<div id="sendtel"><?php echo $sender[0]['userTel'];?></div>
</div>
<input type="submit" value="打印" id="print" onclick="print('sto.css')">
<script type="text/javascript">
 	function sto()
 	{
 		$("#img").attr('style','background-image:url(source/sto.PNG);height:500px; width:910px;');
 		$("#style").attr('href','css/express/sto.css');
 		$("#print").attr('onclick','print(\'sto.css\')');
 		
 	}
 	function yunda()
 	{
 		$("#img").attr('style','background-image:url(source/yunda.PNG);height:500px; width:910px;');
 		$("#style").attr('href','css/express/yunda.css');
 		$("#print").attr('onclick','print(\'yunda.css\')');
 	}
</script>
</body>
</html>