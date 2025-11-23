<?php
// session_start();
include_once 'common_log.php';
$pro=isset($_GET["pro"])?$_GET["pro"]:"";
//$conn->debug=true;
$data_array = array();
if($pro=='ANN'){ 
	//$conn->debug=true;
	$val=isset($_REQUEST["val"])?$_REQUEST["val"]:"";
	// $com_no=isset($_REQUEST["com_no"])?$_REQUEST["com_no"]:"";
	// $err="ERR";
	$rs = $conn->query("SELECT * FROM $schema2.`hebahan_makluman` WHERE `kod`=".tosql($val));

	$data_array[]='PENGUMUMAN';
	$data_array[]=$rs->fields['tajuk'];
	$data_array[]=$rs->fields['keterangan'];
	$err = $data_array;	
	// print $rs->fields['title'];
} else if($pro=='POP'){ 
	// $conn->debug=true;
	$val=isset($_REQUEST["val"])?$_REQUEST["val"]:"";
	$rs = $conn->query("SELECT `title`, `content` FROM $schema1.`cms` WHERE `id`=".tosql($val));

	$data_array[]="MAKLUMAN";
	$data_array[]=$rs->fields['title'];
	$data_array[]=nl2br($rs->fields['content']);
	$err = $data_array;	

} else {
	$data_array[]='ERROR';
	$data_array[]="Ralat";
	$data_array[]="Terdapat ralat dalam sistem";
	$err = $data_array;	
}

header("Content-Type: text/json");
print json_encode($err); 
?>