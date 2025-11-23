<?php 
//Set the page size
$PageSize = 10;
$StartRow = 0;

//Set the page no
if(empty($_GET['PageNo'])){
    if($StartRow == 0){
        $PageNo = $StartRow + 1;
    }
}else{
    $PageNo = $_GET['PageNo'];
    $StartRow = ($PageNo - 1) * $PageSize;
}

//Set the counter start
if($PageNo % $PageSize == 0){
    $CounterStart = $PageNo - ($PageSize - 1);
}else{
    $CounterStart = $PageNo - ($PageNo % $PageSize) + 1;
}

//Counter End
$CounterEnd = $CounterStart + ($PageSize - 1);

$sSQL=$sql;
$strSQL=$sql. " LIMIT $StartRow,$PageSize ";
//$conn->debug=true;
//echo $strSQL;
$rs = $conn->query($strSQL);

$rs1 = $conn->query($sSQL);
$RecordCount = $rs1->recordcount();
				
//$TRecord = mysql_query($sSQL);
//$result = mysql_query($strSQL);

//Total of record
//$RecordCount = mysql_num_rows($TRecord);
//Set Maximum Page
$MaxPage = $RecordCount % $PageSize;
if($RecordCount % $PageSize == 0){
   $MaxPage = $RecordCount / $PageSize;
}else{
   $MaxPage = ceil($RecordCount / $PageSize);
}
?>