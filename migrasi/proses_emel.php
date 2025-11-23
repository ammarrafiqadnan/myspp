<?php
include '../connection/common.php';
$row = 1;
$conn->debug=true;
$rs = $conn->query("SELECT emel, ICNo FROM $schema2.`myid` WHERE `emel` LIKE '% %'");
print $rs->recordcount()."<br>";
while(!$rs->EOF){
	//print "d:". $rs->fields['emel']."<br>";
	$emel = str_replace(" ","",$rs->fields['emel']);
	print $emel."<br>";
	$sql = "UPDATE $schema2.`myid` SET `emel`=".tosqln($emel)." WHERE `ICNo`=".tosql($rs->fields['ICNo'])." AND `emel`=".tosqln($rs->fields['emel']);
	$conn->execute($sql);
	$rs->movenext();
} 
?>