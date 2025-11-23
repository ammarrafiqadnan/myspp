<?php
include '../common_log.php';
//$conn->debug=true;
$teras=isset($_REQUEST["teras"])?$_REQUEST["teras"]:"";
$T=isset($_REQUEST["T"])?$_REQUEST["T"]:"";

if(empty($T)){
	$pejabat_arr = array();
	$query ="SELECT * FROM tbl_strategi WHERE strategi_status=0 AND is_deleted=0 AND teras_id='{$teras}'";
	if($_SESSION['SESSADM_ULEVEL']==3){	
		$sqlP = "SELECT A.* FROM tbl_strategi A, tbl_strategi_agensi B, _ref_agensi C 
		WHERE A.strategi_id=B.strategi_id AND B.agensi_id=C.agensi_id AND A.strategi_status=0 AND A.is_deleted=0 ";
		if(!empty($_SESSION['SESSADM_AGENSIGRP'])){ $sqlP .= " AND C.agensia_id=".tosql($_SESSION['SESSADM_AGENSIGRP']); }
		if(!empty($_SESSION['SESSADM_AGENSIID'])){ $sqlP .= " AND B.agensi_id=".tosql($_SESSION['SESSADM_AGENSIID']); }
	} else {
		$sqlP = "SELECT A.* FROM tbl_strategi A WHERE strategi_status=0 AND is_deleted=0 "; 
		//WHERE A.strategi_id=B.strategi_id AND B.agensi_id=C.agensi_id ";
		//if(!empty($_SESSION['SESSADM_AGENSIGRP'])){ $sqlP .= " AND C.agensia_id=".tosql($_SESSION['SESSADM_AGENSIGRP']); }
		//if(!empty($_SESSION['SESSADM_AGENSIID'])){ $sqlP .= " AND B.agensi_id=".tosql($_SESSION['SESSADM_AGENSIID']); }
	}
	$sqlP .= " AND A.teras_id='{$teras}'";
	$sqlP .= " GROUP BY A.strategi_id";
	
	$results = $conn->query($sqlP);
	$pejabat_arr[] = array("id" => "", "name" => "Sila pilih strategi");
	while(!$results->EOF) {
		$pejabat_arr[] = array("id" => $results->fields['strategi_id'], "name" => $results->fields['strategi_nama']);
		$results->movenext(); 
	}
} else {
	$pejabat_arr='';
	$query ="SELECT * FROM tbl_strategi WHERE is_deleted=0 AND strategi_id='{$teras}'";
	$results = $conn->query($query);
	
	$pejabat_arr = $results->fields['strategi_program'];
}

echo json_encode($pejabat_arr);
//$conn->close();
?>