<?php
include '../common_log.php';
//$conn->debug=true;
$agid=isset($_REQUEST["agid"])?$_REQUEST["agid"]:"";
$strategi=isset($_REQUEST["strategi"])?$_REQUEST["strategi"]:"";
$pejabat_arr = array();

if(!empty($agid)){ 
	$query ="SELECT A.*,B.agansia_singkat FROM _ref_agensi A, _ref_agansi_utama B WHERE A.agensia_id=B.agansia_id AND A.is_deleted=0 AND A.agensi_status=0 AND A.agensia_id='{$agid}'"; 
} else if(!empty($strategi)){
	$query ="SELECT A.*, C.agansia_singkat FROM _ref_agensi A, tbl_strategi_agensi B, _ref_agansi_utama C 
	WHERE A.agensia_id=C.agansia_id AND A.agensi_id=B.agensi_id AND A.is_deleted=0 AND A.agensi_status=0 ";
	$query .= " AND B.strategi_id='{$strategi}'"; 
}

$results = $conn->query($query);
$pejabat_arr[] = array("id" => "", "name" => "Sila pilih agensi");
while(!$results->EOF) {
	$pejabat_arr[] = array("id" => $results->fields['agensi_id'], "name" => "[".$results->fields['agansia_singkat']."] " . $results->fields['agensi_nama']);
	$results->movenext(); 
}
echo json_encode($pejabat_arr);
//$conn->close();
?>