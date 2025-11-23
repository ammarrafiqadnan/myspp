<?php
include '../connection/common.php';
$conn->debug=true;
$muid=isset($_REQUEST["muid"])?$_REQUEST["muid"]:"";
$uid=isset($_REQUEST["uid"])?$_REQUEST["uid"]:"";
$menu_id=isset($_REQUEST["menu_id"])?$_REQUEST["menu_id"]:"";
$stat=isset($_REQUEST["stat"])?$_REQUEST["stat"]:"";

$strSQL = "UPDATE _tbl_user_menu SET menu_stat='{$stat}' WHERE menu_uid='{$muid}'";
$rss = $conn->execute($strSQL);

//header("Content-Type: text/json");
print json_encode($err); 
		
?>
