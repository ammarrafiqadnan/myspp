<?php
include '../connection/common_log.php';
//$conn->debug=true;
$tahun=isset($_REQUEST["tahun"])?$_REQUEST["tahun"]:"";
$jenisMuetCefr1=isset($_REQUEST["jenisMuetCefr1"])?$_REQUEST["jenisMuetCefr1"]:"";
$keputusan_arr = array();
if(!empty($jenisMuetCefr1)){ 
	if($jenisMuetCefr1 == 1 && $tahun <= 2020){ 
		$query ="SELECT * FROM $schema1.padanan_jenisPeperiksaan_keputusan WHERE kod_jenis_peperiksaan='{$jenisMuetCefr1}' AND tahun_mula='1999'";
	} else if($jenisMuetCefr1 == 1 && $tahun == 2021){ 
		$query ="SELECT * FROM $schema1.padanan_jenisPeperiksaan_keputusan WHERE kod_jenis_peperiksaan='{$jenisMuetCefr1}'";
	} else if($jenisMuetCefr1 == 1 && $tahun >= 2022){ 
		$query ="SELECT * FROM $schema1.padanan_jenisPeperiksaan_keputusan WHERE kod_jenis_peperiksaan='{$jenisMuetCefr1}' AND tahun_mula='2021'";
	} else {
		$query ="SELECT * FROM $schema1.padanan_jenisPeperiksaan_keputusan WHERE kod_jenis_peperiksaan='{$jenisMuetCefr1}'";
	}


	$results = $conn->query($query);
	$keputusan_arr[] = array("kod" => "", "keputusan" => "Sila pilih Keputusan MUET/CEFR");
	while(!$results->EOF) {
		$kep = '';
		if(!empty($results->fields['band'])){ $kep = $results->fields['band']; }
		if(!empty($results->fields['gred'])){ 
			if(!empty($kep)){ $kep .= " / "; }
			$kep .= $results->fields['gred']; 
		}
		if(!empty($results->fields['cefr'])){ 
			if(!empty($kep)){ $kep .= " / "; } 
			$kep .= $results->fields['cefr']; 
		}

		$keputusan_arr[] = array("kod" => strtoupper($results->fields['kod']), "keputusan" => strtoupper($kep));
		$results->movenext(); 
	}

// } else if(!empty($poskod)){

// 	$query ="SELECT bandar FROM $schema1.ref_poskod WHERE kod_negeri='{$neg}' GROUP BY kod_negeri, bandar";

}
echo json_encode($keputusan_arr);
//$conn->close();
?>