<html>
<head>
	<title></title>
</head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css">
<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<script type="text/javascript">
	$(function(){
		$("#order").dialog({
			autoOpen: false,
	    	width:620
		});
		$("#print").click(function(){
			$("#order").dialog("open");
		});
	});
</script>
<script type="text/javascript">
 function doPrint() {   
      //       打开一个新的窗体  
      //   var newWin = window.open('about:blank',"","");  
      //       //取得id为"order"的<div id="order"></div>之间的内容  
      //   var titleHTML = document.getElementById("order").innerHTML;  
      //      //将取得的打印内容放入新窗体  
      //   newWin.document.write(titleHTML);  
      //      //刷新新窗体  
      //   newWin.document.location.reload();  
      // //调用打印功能    
      //   newWin.print();  
      //      //打印完毕自动关闭新窗体  
      //   newWin.close();  
      window.print();
    } 
</script>
<body>
<div id="order" onclick="doPrint()";>dddddddddddd</div>
<div id="print" style="margin-top:110px;">ddddddddddddddddddddddddddddddddddddddddd</div>
</body>
<!-- </html> -->
