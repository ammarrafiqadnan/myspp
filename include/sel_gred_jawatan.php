<?php
include '../connection/common_log.php';
//$conn->debug=true;
$kod=isset($_REQUEST["kod"])?$_REQUEST["kod"]:"";


$res = $conn->query("SELECT B.DISKRIPSI AS NAMA, B.`KOD` AS kods FROM $schema1.`ref_skim` A, $schema1.`ref_gred_gaji` B WHERE A.`GGH_KOD`=B.`KOD` AND A.`KOD`='{$kod}'");
if(!$res->EOF){
	$des = $res->fields['NAMA'];
	$gred_kod = $res->fields['kods'];
}
$grds = substr($gred_kod,0,1);
//print $grds;

$univ_arr = array();
$univ_arr[] = array("id" => "", "name" => "Sila pilih maklumat gred");
$des=''; $gred_kod='';
if(!empty($kod)){ 

	$res = $conn->query("SELECT B.DISKRIPSI AS NAMA, B.`KOD` AS kods FROM $schema1.`ref_skim` A, $schema1.`ref_gred_gaji` B 
	WHERE A.`GGH_KOD`=B.`KOD` AND A.`KOD`='{$kod}'");
	if(!$res->EOF){
		$des = $res->fields['NAMA'];
		$gred_kod = $res->fields['kods'];
	}
	//$desc = dlookup("$schema1.`ref_skim` A, $schema1.`ref_gred_gaji` B","B.DISKRIPSI","A.`GGH_KOD`=B.`KOD` AND A.`KOD`='{$kod}'");
	//print "<br>D:".$des;

	$query = "SELECT KOD FROM $schema1.`ref_gred_gaji` WHERE `SAH_YT`='Y' AND GAB_YT='T' AND `DISKRIPSI` IN ('{$des}') AND KOD IS NOT NULL AND `KOD` LIKE '%$grds%'  ORDER BY KOD";
	$results = $conn->query($query);
	while(!$results->EOF) {
		if($results->fields['KOD']==$gred_kod){
			$univ_arr[] = array("id" => strtoupper($results->fields['KOD']), "name" => strtoupper($results->fields['KOD']), "sel" => 'selected');
		} else {
			$univ_arr[] = array("id" => strtoupper($results->fields['KOD']), "name" => strtoupper($results->fields['KOD']), "sel" => '');
		}
		$results->movenext(); 
	}

}
echo json_encode($univ_arr);
//$conn->close();
?>