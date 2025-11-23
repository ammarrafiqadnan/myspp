<?php
include '../connection/common_log.php';
//$conn->debug=true;
$neg=isset($_REQUEST["neg"])?$_REQUEST["neg"]:"";
$poskod=isset($_REQUEST["poskod"])?$_REQUEST["poskod"]:"";
$pejabat_arr = array();
if(!empty($neg)){ 

	$query ="SELECT bandar FROM $schema1.ref_poskod WHERE kod_negeri='{$neg}' GROUP BY kod_negeri, bandar";
	$results = $conn->query($query);
	$pejabat_arr[] = array("id" => "", "name" => "Sila pilih bandar");
	while(!$results->EOF) {
		$pejabat_arr[] = array("id" => strtoupper($results->fields['bandar']), "name" => strtoupper($results->fields['bandar']));
		$results->movenext(); 
	}

// } else if(!empty($poskod)){

// 	$query ="SELECT bandar FROM $schema1.ref_poskod WHERE kod_negeri='{$neg}' GROUP BY kod_negeri, bandar";

}
echo json_encode($pejabat_arr);
//$conn->close();
?>