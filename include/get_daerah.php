<?php
include '../connection/common_log.php';
//$conn->debug=true;
$neg=isset($_REQUEST["neg"])?$_REQUEST["neg"]:"";
$poskod=isset($_REQUEST["poskod"])?$_REQUEST["poskod"]:"";
$pejabat_arr = array();

if(!empty($neg)){ 
	if($neg == '99'){
		$pejabat_arr[] = array("id" => '0000', "name" => 'TIDAK BERKENAAN');
	} else {
		$pejabat_arr[] = array("id" => "", "name" => "Sila pilih bandar");
		$query ="SELECT bandar FROM $schema1.ref_poskod WHERE kod_negeri='{$neg}' GROUP BY kod_negeri, bandar";
		$results = $conn->query($query);
		while(!$results->EOF) {
			$pejabat_arr[] = array("id" => strtoupper($results->fields['bandar']), "name" => strtoupper($results->fields['bandar']));
			$results->movenext(); 
		}
	}
}
echo json_encode($pejabat_arr);
//$conn->close();
?>