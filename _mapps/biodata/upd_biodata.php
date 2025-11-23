<?php
include '../../connection/common.php';
$conn->debug=true;
$schema2='spp_calon';

	$sql = "SELECT C.`ICNo`, B.`Gander`, B.`Race`, B.`Religon` 
		FROM $schema2.`myid_jpn` B, $schema2.`calon` C 
		WHERE C.`ICNo`=B.`ICno`"; 
	//$sql .= " AND B.Gander IS NOT NULL";
	$sql .=" GROUP BY C.ICNo";
	//print $sql;
	
	$rs = $conn->query($sql);

	while(!$rs->EOF){
		$sql = "UPDATE $schema2.`calon` SET `jantina`=".tosql($rs->fields['Gander']).", `agama`=".tosql($rs->fields['Religon']).", 
			`keturunan`=".tosql($rs->fields['Race'])." WHERE ICNo=".tosql($rs->fields['ICNo']);
		$conn->execute($sql);	
		//print $sql."<br>";
		$rs->movenext();
	}

	//$conn->execute("UPDATE $schema2.`calon` SET `jantina`='L' WHERE `jantina`='1'");
	//$conn->execute("UPDATE $schema2.`calon` SET `jantina`='P' WHERE `jantina`='2'");


?>