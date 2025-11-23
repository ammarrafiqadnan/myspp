<?php
include '../../connection/common_log.php';
// $conn->debug=true;
$zon=isset($_REQUEST["zon"])?$_REQUEST["zon"]:"";
$negeri_arr = array();
if(!empty($zon)){ 

	$query ="SELECT * FROM $schema2.ref_negeri WHERE `status`=0";
    if($zon == 1){
        $query .= " AND kod IN('09','02','07','08')";
    } else if($zon == 2){
        $query .= " AND kod IN('05','04','01')";
    }  else if($zon == 3){
        $query .= " AND kod IN('10','14','16')";
    } else if($zon == 4){
        $query .= " AND kod IN('06','11','03')";
    } else if($zon == 5){
        $query .= " AND kod IN('12','13','15')";
    }
	$results = $conn->query($query);
	$negeri_arr[] = array("kod" => "", "diskripsi2" => "Sila pilih negeri");
	while(!$results->EOF) {
		$negeri_arr[] = array("kod" => strtoupper($results->fields['kod']), "diskripsi2" => strtoupper($results->fields['diskripsi2']));
		$results->movenext(); 
	}

}
echo json_encode($negeri_arr);
//$conn->close();
?>