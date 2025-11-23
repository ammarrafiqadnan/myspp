<?php
include '../connection/common.php';
$sql = "SELECT * FROM $schema2.`calon_ipt` A, $schema2.`calon` B, $schema2.`calon_jawatan_dipohon` C  
	WHERE A.id_pemohon=B.id_pemohon AND A.id_pemohon=C.id_pemohon AND C.kod_jawatan IN ('1042','3042','1184','1180') 
	AND C.kod_jaw_skim IS NULL 
	GROUP BY A.id_pemohon ORDER BY A.id_pemohon, A.peringkat";
$rs = $conn->query($sql);
$cnt=0;
while(!$rs->EOF){
	$cnt++;
	$sql2 = "SELECT * FROM $schema2.`calon_ipt` WHERE id_pemohon=".tosql($rs->fields['id_pemohon'])." ORDER BY peringkat";
	$rss = $conn->query($sql2);
	$bil=0; $peringkat='';
	while(!$rss->EOF){

		if($bil==0){ $peringkat=$rss->fields['peringkat']; }
		else { $peringkat.=",".$rss->fields['peringkat']; }

		$bil++;

		$rss->movenext();
	}


	$rsc = $conn->query("SELECT * FROM $schema2.`calon_jawatan_dipohon` WHERE kod_jawatan IN ('1042','3042','1184','1180') 
		AND id_pemohon=".tosql($rs->fields['id_pemohon']));

	$bil=0; $kod='';
	while(!$rsc->EOF){

		if($bil==0){ $kod=$rsc->fields['kod_jawatan']; }
		else { $kod.=",".$rsc->fields['kod_jawatan']; }

		$bil++;

		$rsc->movenext();
	}	


	print "<br>".$cnt." : ".$rs->fields['id_pemohon']." : ".$peringkat." : (".$kod.")";
/*
	$conn->debug=true;
	if($peringkat==1){
		$conn->execute("update $schema2.`calon_jawatan_dipohon` SET peringkat='DIPLOMA PENDIDIKAN', kod_jaw_skim='107', kod_peringkat='6' WHERE `kod_jawatan` LIKE '3042' AND kod_jaw_skim IS NULL AND id_pemohon=".tosql($rs->fields['id_pemohon']));
		$conn->execute("update $schema2.`calon_jawatan_dipohon` SET peringkat='DIPLOMA PENDIDIKAN', kod_jaw_skim='115', kod_peringkat='6' WHERE `kod_jawatan` LIKE '1180' AND kod_jaw_skim IS NULL AND id_pemohon=".tosql($rs->fields['id_pemohon'])); 
	} else if($peringkat==2){
		$conn->execute("update $schema2.`calon_jawatan_dipohon` SET peringkat='DIPLOMA', kod_jaw_skim='116', kod_peringkat='7' WHERE `kod_jawatan` LIKE '3042' AND kod_jaw_skim IS NULL AND id_pemohon=".tosql($rs->fields['id_pemohon']));
	} else if($peringkat==3){
		$conn->execute("update $schema2.`calon_jawatan_dipohon` SET peringkat='IJAZAH PENDIDIKAN', kod_jaw_skim='113', kod_peringkat='4' WHERE `kod_jawatan` LIKE '1042' AND kod_jaw_skim IS NULL AND id_pemohon=".tosql($rs->fields['id_pemohon']));
		$conn->execute("update $schema2.`calon_jawatan_dipohon` SET peringkat='IJAZAH PENDIDIKAN', kod_jaw_skim='102', kod_peringkat='4' WHERE `kod_jawatan` LIKE '1184' AND kod_jaw_skim IS NULL AND id_pemohon=".tosql($rs->fields['id_pemohon']));
	} else if($peringkat==4){
		$conn->execute("update $schema2.`calon_jawatan_dipohon` SET peringkat='IJAZAH', kod_jaw_skim='106', kod_peringkat='5' WHERE `kod_jawatan` LIKE '1042' AND kod_jaw_skim IS NULL AND id_pemohon=".tosql($rs->fields['id_pemohon']));
	} else if($peringkat==6){
		$conn->execute("update $schema2.`calon_jawatan_dipohon` SET peringkat='MASTER', kod_jaw_skim='110', kod_peringkat='8' WHERE `kod_jawatan` LIKE '1042' AND kod_jaw_skim IS NULL AND id_pemohon=".tosql($rs->fields['id_pemohon']));
	} else if($peringkat=='2,4'){
		$conn->execute("update $schema2.`calon_jawatan_dipohon` SET peringkat='DIPLOMA', kod_jaw_skim='116', kod_peringkat='7' WHERE `kod_jawatan` LIKE '3042' AND kod_jaw_skim IS NULL AND id_pemohon=".tosql($rs->fields['id_pemohon']));
		$conn->execute("update $schema2.`calon_jawatan_dipohon` SET peringkat='IJAZAH', kod_jaw_skim='106', kod_peringkat='5' WHERE `kod_jawatan` LIKE '1042' AND kod_jaw_skim IS NULL AND id_pemohon=".tosql($rs->fields['id_pemohon']));
	} else if($peringkat=='2,6'){
		$conn->execute("update $schema2.`calon_jawatan_dipohon` SET peringkat='DIPLOMA', kod_jaw_skim='116', kod_peringkat='7' WHERE `kod_jawatan` LIKE '3042' AND kod_jaw_skim IS NULL AND id_pemohon=".tosql($rs->fields['id_pemohon']));
		$conn->execute("update $schema2.`calon_jawatan_dipohon` SET peringkat='IJAZAH', kod_jaw_skim='106', kod_peringkat='5' WHERE `kod_jawatan` LIKE '1042' AND kod_jaw_skim IS NULL AND id_pemohon=".tosql($rs->fields['id_pemohon']));
	} else if($peringkat=='4,6'){
		$conn->execute("update $schema2.`calon_jawatan_dipohon` SET peringkat='DIPLOMA', kod_jaw_skim='116', kod_peringkat='7' WHERE `kod_jawatan` LIKE '3042' AND kod_jaw_skim IS NULL AND id_pemohon=".tosql($rs->fields['id_pemohon']));
		$conn->execute("update $schema2.`calon_jawatan_dipohon` SET peringkat='IJAZAH', kod_jaw_skim='106', kod_peringkat='5' WHERE `kod_jawatan` LIKE '1042' AND kod_jaw_skim IS NULL AND id_pemohon=".tosql($rs->fields['id_pemohon']));
	} else if($peringkat=='1,4'){
		$conn->execute("update $schema2.`calon_jawatan_dipohon` SET peringkat='DIPLOMA PENDIDIKAN', kod_jaw_skim='115', kod_peringkat='6' WHERE `kod_jawatan` LIKE '1180' AND kod_jaw_skim IS NULL AND id_pemohon=".tosql($rs->fields['id_pemohon'])); 
		$conn->execute("update $schema2.`calon_jawatan_dipohon` SET peringkat='IJAZAH', kod_jaw_skim='106', kod_peringkat='5' WHERE `kod_jawatan` LIKE '1042' AND kod_jaw_skim IS NULL AND id_pemohon=".tosql($rs->fields['id_pemohon']));
		$conn->execute("update $schema2.`calon_jawatan_dipohon` SET peringkat='IJAZAH PENDIDIKAN', kod_jaw_skim='114', kod_peringkat='8' WHERE `kod_jawatan` LIKE '1184' AND kod_jaw_skim IS NULL AND id_pemohon=".tosql($rs->fields['id_pemohon']));
	} else if($peringkat=='2,4,6'){
		$conn->execute("update $schema2.`calon_jawatan_dipohon` SET peringkat='DIPLOMA', kod_jaw_skim='116', kod_peringkat='7' WHERE `kod_jawatan` LIKE '3042' AND kod_jaw_skim IS NULL AND id_pemohon=".tosql($rs->fields['id_pemohon']));
		$conn->execute("update $schema2.`calon_jawatan_dipohon` SET peringkat='IJAZAH', kod_jaw_skim='106', kod_peringkat='5' WHERE `kod_jawatan` LIKE '1042' AND kod_jaw_skim IS NULL AND id_pemohon=".tosql($rs->fields['id_pemohon']));
	} else if($peringkat=='1,4,6'){
		$conn->execute("update $schema2.`calon_jawatan_dipohon` SET peringkat='DIPLOMA PENDIDIKAN', kod_jaw_skim='115', kod_peringkat='6' WHERE `kod_jawatan` LIKE '1180' AND kod_jaw_skim IS NULL AND id_pemohon=".tosql($rs->fields['id_pemohon'])); 
		$conn->execute("update $schema2.`calon_jawatan_dipohon` SET peringkat='IJAZAH', kod_jaw_skim='106', kod_peringkat='5' WHERE `kod_jawatan` LIKE '1042' AND kod_jaw_skim IS NULL AND id_pemohon=".tosql($rs->fields['id_pemohon']));
		$conn->execute("update $schema2.`calon_jawatan_dipohon` SET peringkat='IJAZAH PENDIDIKAN', kod_jaw_skim='102', kod_peringkat='4' WHERE `kod_jawatan` LIKE '1184' AND kod_jaw_skim IS NULL AND id_pemohon=".tosql($rs->fields['id_pemohon']));
	} else if($peringkat=='1,3'){
		$conn->execute("update $schema2.`calon_jawatan_dipohon` SET peringkat='IJAZAH PENDIDIKAN', kod_jaw_skim='102', kod_peringkat='4' WHERE `kod_jawatan` LIKE '1184' AND kod_jaw_skim IS NULL AND id_pemohon=".tosql($rs->fields['id_pemohon']));
		$conn->execute("update $schema2.`calon_jawatan_dipohon` SET peringkat='DIPLOMA PENDIDIKAN', kod_jaw_skim='115', kod_peringkat='6' WHERE `kod_jawatan` LIKE '1180' AND kod_jaw_skim IS NULL AND id_pemohon=".tosql($rs->fields['id_pemohon'])); 
		$conn->execute("update $schema2.`calon_jawatan_dipohon` SET peringkat='DIPLOMA', kod_jaw_skim='116', kod_peringkat='7' WHERE `kod_jawatan` LIKE '3042' AND kod_jaw_skim IS NULL AND id_pemohon=".tosql($rs->fields['id_pemohon']));
		$conn->execute("update $schema2.`calon_jawatan_dipohon` SET peringkat='IJAZAH', kod_jaw_skim='106', kod_peringkat='5' WHERE `kod_jawatan` LIKE '1042' AND kod_jaw_skim IS NULL AND id_pemohon=".tosql($rs->fields['id_pemohon']));
	} else if($peringkat=='4,4'){
		$conn->execute("update $schema2.`calon_jawatan_dipohon` SET peringkat='IJAZAH', kod_jaw_skim='106', kod_peringkat='5' WHERE `kod_jawatan` LIKE '1042' AND kod_jaw_skim IS NULL AND id_pemohon=".tosql($rs->fields['id_pemohon']));
	} else if($peringkat=='2,4,4'){
		$conn->execute("update $schema2.`calon_jawatan_dipohon` SET peringkat='DIPLOMA', kod_jaw_skim='116', kod_peringkat='7' WHERE `kod_jawatan` LIKE '3042' AND kod_jaw_skim IS NULL AND id_pemohon=".tosql($rs->fields['id_pemohon']));
		$conn->execute("update $schema2.`calon_jawatan_dipohon` SET peringkat='IJAZAH'',,2,2' kod_jaw_skim='106', kod_peringkat='5' WHERE `kod_jawatan` LIKE '1042' AND kod_jaw_skim IS NULL AND id_pemohon=".tosql($rs->fields['id_pemohon']));
	} else if($peringkat=='2,2,2'){
		$conn->execute("update $schema2.`calon_jawatan_dipohon` SET peringkat='DIPLOMA', kod_jaw_skim='116', kod_peringkat='7' WHERE `kod_jawatan` LIKE '3042' AND kod_jaw_skim IS NULL AND id_pemohon=".tosql($rs->fields['id_pemohon']));
	}
*/
	$conn->debug=false;

	$rs->movenext();
}


?>