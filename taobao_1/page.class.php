<?php

    class Fenye{

        public $pageNo;       //页码 当前页码
        public $pageSize;   //每页显示多少少数据
        public $pageCount;  //总页数
        public $totalCount; //总的数据条数
        public $pageUrl;    //页面URL


        function __construct($totalCount, $pageSize, $pageUrl){

            $this->totalCount = $totalCount;
            $this->pageSize   = $pageSize;
            $this->pageUrl    = $pageUrl;
            //计算总的页数
            $this->pageCount = ceil($totalCount / $pageSize);

        }

        //显示分页
        function showFenye($pageNo){

            //按总页数判断输出页码
            // 1 2 3 4 5 6 7 8 9 10 11 12
            //总页数不大于11条时
            if($this->pageCount <= 11){

                echo "<ul style=\"list-style:none;\">";
                echo "<li style=\"display:inline;\"><a href='".$this->pageUrl."'>第一页</li>&nbsp";

                for($i = 1; $i <= $this->pageCount; $i++){

                    echo "<li style=\"display:inline;\"><a href='".$this->pageUrl."?pageNo=".$i."'>".$i."</a>&nbsp</li>";

                }

                echo "<li style=\"display:inline;\"><a href='".$this->pageUrl."?pageNo=".$this->pageCount."'>最后一页</li>";
                echo "</ul>";

            }else{

                //当页数大于11条时
                //---------------------------------
                if($pageNo <= 6){

                    echo "<ul style=\"list-style:none;\">";
                    echo "<li style=\"display:inline;\"><a href='".$this->pageUrl."'>第一页</li>&nbsp";

                    for($i = 1; $i <= 11; $i++){

                        echo "<li style=\"display:inline;\"><a href='".$this->pageUrl."?pageNo=".$i."'>".$i."</a>&nbsp</li>";

                    }

                    echo "<li style=\"display:inline;\"><a href='".$this->pageUrl."?pageNo=".$this->pageCount."'>最后一页</li>";
                    echo "</ul>";

                }

                if($this->pageCount - $pageNo <=6){

                    echo "<ul style=\"list-style:none;\">";
                    echo "<li style=\"display:inline;\"><a href='".$this->pageUrl."'>第一页</li>&nbsp";

                    for($i = $this->pageCount - 11; $i <= $this->pageCount ; $i++){

                        echo "<li style=\"display:inline;\"><a href='".$this->pageUrl."?pageNo=".$i."'>".$i."</a>&nbsp</li>";

                    }

                    echo "<li style=\"display:inline;\"><a href='".$this->pageUrl."?pageNo=".$this->pageCount."'>最后一页</li>";
                    echo "</ul>";

                }

                if($pageNo > 6 && $pageNo < $this->pageCount - 6){

                    echo "<ul style=\"list-style:none;\">";
                    echo "<li style=\"display:inline;\"><a href='".$this->pageUrl."'>第一页</li>&nbsp";

                    for($j = $pageNo - 5; $j <= $pageNo + 5; $j++){

                        echo "<li style=\"display:inline;\"><a href='".$this->pageUrl."?pageNo=".$j."'>".$j."</a>&nbsp</li>";
                    }

                    echo "<li style=\"display:inline;\"><a href='".$this->pageUrl."?pageNo=".$this->pageCount."'>最后一页</li>";
                    echo "</ul>";

                }

            }
   
        }

    }
    
?>
