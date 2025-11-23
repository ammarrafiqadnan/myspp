<?php
include '../../connection/common_log.php';
// $conn->debug=true;
$zon=isset($_REQUEST["zon"])?$_REQUEST["zon"]:"";
$negeri_arr = array();
if(!empty($zon)){ 

	$query ="SELECT * FROM $schema1.ref_negeri WHERE `status`=0";
    if($zon == 1){
        $query .= " AND KOD_NEGERI IN('09','02','07','08')";
    } else if($zon == 2){
        $query .= " AND KOD_NEGERI IN('05','04','01')";
    }  else if($zon == 3){
        $query .= " AND KOD_NEGERI IN('10','14','16')";
    } else if($zon == 4){
        $query .= " AND KOD_NEGERI IN('06','11','03')";
    } else if($zon == 5){
        $query .= " AND KOD_NEGERI IN('12','13','15')";
    }

	$query .= "  GROUP BY KOD_NEGERI";
	$results = $conn->query($query);
	$negeri_arr[] = array("kod" => "", "diskripsi2" => "Sila pilih negeri");
	while(!$results->EOF) {
		$negeri_arr[] = array("kod" => strtoupper($results->fields['KOD_NEGERI']), "diskripsi2" => strtoupper($results->fields['NEGERI']));
		$results->movenext(); 
	}

}
echo json_encode($negeri_arr);
//$conn->close();
?>