<?php
include '../common_log.php';
//$conn->debug=true;
$maqasid=isset($_REQUEST["maqasid"])?$_REQUEST["maqasid"]:"";
$T=isset($_REQUEST["T"])?$_REQUEST["T"]:"";

//if(empty($T)){
	$pejabat_arr = array();
	$query ="SELECT * FROM _ref_maqasid_sub WHERE msub_status=0 AND is_deleted=0 AND prinsip_id=".tosql($maqasid);
	
	$results = $conn->query($query);
	$pejabat_arr[] = array("id" => "", "name" => "Sila pilih sub-maqasid");
	while(!$results->EOF) {
		$pejabat_arr[] = array("id" => $results->fields['msub_id'], "name" => $results->fields['msub_nama']);
		$results->movenext(); 
	}
/*} else {
	$pejabat_arr='';
	$query ="SELECT * FROM _ref_maqasid_sub WHERE is_deleted=0 AND prinsip_id='{$teras}'";
	$results = $conn->query($query);
	
	$pejabat_arr = $results->fields['strategi_program'];
}*/

echo json_encode($pejabat_arr);
//$conn->close();
?>