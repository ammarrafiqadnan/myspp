<?php
session_start();
include '../../../connection/common.php';
$makl=isset($_GET["makl"])?$_GET["makl"]:"";
$km_jenis=isset($_GET["jenis"])?$_GET["jenis"]:"";
$kod_get=isset($_GET["kod_get"])?$_GET["kod_get"]:"";

// $km_jenis=2;
//$conn->debug=true;
$sql = "SELECT A.*, C.`DISKRIPSI` AS INSTITUSI, B.`DISKRIPSI` AS PENGKHUSUSAN 
FROM $schema1.`padanan_institusi_pengkhususan` A, $schema1.`ref_pengkhususan` B, $schema1.`ref_institusi` C 
WHERE A.`kod_pengkhususan`=B.`kod` AND A.`kod_institusi`=C.`KOD` AND A.`status`=0 AND A.`is_deleted`=0 ";
$sql .= " AND (A.`kod_pengkhususan` LIKE '%{$makl}%' OR A.`kod_institusi` LIKE '%{$makl}%' OR C.`DISKRIPSI` LIKE '%{$makl}%' OR B.`DISKRIPSI` LIKE '%{$makl}%')";
$sql .= " AND A.`kategori`=".tosql($km_jenis);
if(!empty($kod_get)){ $sql .= " AND A.kod NOT IN ($kod_get)"; }
$sql .= " ORDER BY A.`kod_institusi`, A.`kod_pengkhususan`";
$rsData1 = $conn->query($sql);
// print $sql;
$makl = str_replace("_"," ",strtoupper($makl));
if(!$rsData1->EOF){
	print '<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">';
	print '<tr><td width="10%"><b>Kod</b></td><td width="40%"><b>Universiti</b></td><td width="10%"><b>Kod</b></td><td width="40%"><b>Pengkhususan</b></td><td><b>Pilih</b></td></tr>';

	while(!$rsData1->EOF){

		$univ = str_replace($makl,'<font color="red"><b>'.$makl.'</b></font>',strtoupper($rsData1->fields['INSTITUSI']));
		$subj = str_replace($makl,'<font color="red"><b>'.$makl.'</b></font>',strtoupper($rsData1->fields['PENGKHUSUSAN']));

		print '<tr><td>'.$rsData1->fields['kod_institusi'].'</td><td>'.$univ.'</td><td>'.$rsData1->fields['kod_pengkhususan'].'</td><td>'.$subj.'</td><td><div align="center"><input type="checkbox" class="Checkbox" name="kods" id="kods" value="'.$rsData1->fields['kod'].'" onclick="do_chks('.$rsData1->fields['kod'].')"></div></td></tr>';

		$rsData1->movenext();
	}
	print '</table>';
}

// print 'sss';
?>