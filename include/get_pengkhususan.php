<?php
include '../connection/common_log.php';
//$conn->debug=true;
$kod=isset($_REQUEST["kod"])?$_REQUEST["kod"]:"";
$peringkat1=isset($_REQUEST["peringkat1"])?$_REQUEST["peringkat1"]:"";
$univ_arr = array();
$univ_arr[] = array("id" => "", "name" => "Sila pilih maklumat pengkhususan");
if(!empty($kod)){ 

	// $query ="SELECT A.`sud_id`, B.`DISKRIPSI` FROM $schema1.`ref_sijil_dan_univ_khusus` A, $schema1.`ref_pengkhususan` B 
	// WHERE A.`kod`=B.`kod` AND A.`su_id`='{$kod}' ORDER BY B.`DISKRIPSI`";

	$query ="SELECT A.`kod`, B.`DISKRIPSI` FROM $schema1.`padanan_institusi_pengkhususan` A, $schema1.`ref_pengkhususan` B 
	WHERE A.`kod_pengkhususan`=B.`kod` AND A.`kod_institusi`=".tosql($kod). " AND A.status=0 AND A.is_deleted=0 AND B.STATUS=0 AND B.is_deleted=0";
	if($peringkat1 == '1' || $peringkat1 == '3' || $peringkat1 == '5'){
		$query .= " AND A.kategori=1"; //pendidikan
		if($peringkat1 == '1'){
			$query .= " AND A.peringkat_kelulusan=1"; //diploma pendidikan
		} else if($peringkat1 == '3'){
			$query .= " AND A.peringkat_kelulusan=2"; //ijazah pendidikan
		}  else if($peringkat1 == '5'){
			$query .= " AND A.peringkat_kelulusan=3"; //master pendidikan
		}
	} else if($peringkat1 == '2' || $peringkat1 == '4' || $peringkat1 == '6' || $peringkat1 == '7'){
		$query .= " AND A.kategori=2"; //bukanpendidikan

		if($peringkat1 == '2'){
			$query .= " AND A.peringkat_kelulusan=1"; //diploma
		} else if($peringkat1 == '4'){
			$query .= " AND A.peringkat_kelulusan=2"; //ijazah
		}  else if($peringkat1 == '6'){
			$query .= " AND A.peringkat_kelulusan=3"; //master
		}  else if($peringkat1 == '7'){
			$query .= " AND A.peringkat_kelulusan=4"; //phd
		}


	}

	$query .= " ORDER BY B.`DISKRIPSI`";
	$results = $conn->query($query);
	while(!$results->EOF) {
		$univ_arr[] = array("id" => strtoupper($results->fields['kod']), "name" => strtoupper($results->fields['DISKRIPSI']));
		$results->movenext(); 
	}

}
echo json_encode($univ_arr);
//$conn->close();
?>