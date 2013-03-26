<?php

class ConnDB
{
    var $dbtype;
    var $host;
    var $user;
    var $pwd;
    var $dbname;
    var $conn;
    
    function ConnDB($dbtype,$host,$user,$pwd,$dbname)
    {
        $this->dbtype=$dbtype;
        $this->host=$host;
        $this->pwd=$pwd;
        $this->dbname=$dbname;
        $this->user=$user;
    }
    
    function GetConn()
    {
        $this->conn=mysql_connect($this->host,$this->user,$this->pwd) or die("fail connect to host".mysql_error());
        mysql_select_db($this->dbname,$this->conn) or die("fail connect to database".mysql_error());
        mysql_query("set names utf8");
        return $this->conn;
    }
    function __destruct()
    {
        $this->CloseDB();
    }
    function CloseDB()
    {
        mysql_close($this->conn);
    }
    
    
 }   
    class OperateDB
    {
        function Execsql($sql ,$conn)
        {
            $sqltype=strtolower(substr(trim($sql),0,6));
            $result=mysql_query($sql,$conn);
            $callback_array=array();
            if($sqltype=="select")
            {
                if($result=="false")
                {
                    return false;
                }else if(mysql_num_rows($result)==0)
                {
                    return false;
                }else
                {
                    while($result_array=mysql_fetch_array($result))
                    {
                        array_push($callback_array,$result_array);
                    }
                    return $callback_array;
                }
                
            }else if($sqltype=="update"||$sqltype=="insert"||$sqltype=="delete")
            {
                if($result)
                {
                    return true;
                }else{
                    return false;
                }
            }
        }
    }


?>