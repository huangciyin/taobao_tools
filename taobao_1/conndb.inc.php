<?php

require("conn.class.php");
$conncet=new ConnDB("mysql","127.0.0.1","root","root","taobao");
$operatedb=new OperateDB();
$conn=$conncet->GetConn();

?>
