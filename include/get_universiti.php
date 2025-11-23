<?php
include '../connection/common_log.php';
if($_SESSION['SESS_UID'] == '20230414145982'){
 $conn->debug=true;
}
$kod=isset($_REQUEST["kod"])?$_REQUEST["kod"]:"";
$univ_arr = array();
$univ_arr[] = array("id" => "", "name" => "Sila pilih nama universiti");
if(!empty($kod)){ 

	// $query ="SELECT A.`su_id`, B.`DISKRIPSI` FROM $schema1.`ref_sijil_dan_univ` A, $schema1.`ref_institusi` B 
	// WHERE A.`KOD`=B.`KOD` AND A.`sijil_kod`='{$kod}' AND A.`is_deleted`=0 ORDER BY B.`DISKRIPSI`";

	$query ="SELECT A.*, B.`KOD`, B.`DISKRIPSI` FROM $schema1.`padanan_peringkatkelulusan_institusi` A, $schema1.`ref_institusi` B  
				WHERE A.`kod_institusi`=B.`KOD` AND A.`is_deleted`=0 AND A.`status`=0 AND A.`kod_peringkat_kelulusan`=".tosql($kod);
	$query .= " GROUP BY B.`KOD`";
	$results = $conn->query($query);
	while(!$results->EOF) {
		$univ_arr[] = array("id" => strtoupper($results->fields['KOD']), "name" => strtoupper($results->fields['DISKRIPSI']));
		$results->movenext(); 
	}

}
echo json_encode($univ_arr);
//$conn->close();
?>