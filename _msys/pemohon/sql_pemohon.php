<?php
session_start();
@include_once '../../connection/common.php';
$frm=isset($_GET["frm"])?$_GET["frm"]:"";
$pro=isset($_GET["pro"])?$_GET["pro"]:"";
$date=date("Y-m-d H:i:s");
$oleh=$_SESSION['SESSADM_UID'];
// $conn->debug=true;
// print $frm.":".$pro; 

$err='';

if($frm=='SORTING'){
	//  $conn->debug=true;
	// print 'sini';exit();
	$updown=isset($_REQUEST["updown"])?$_REQUEST["updown"]:"";
	$kategori=isset($_REQUEST["kategori"])?$_REQUEST["kategori"]:"";

	// print 'aaaa'.$id_hapus;
		// print 'aaaaaaa'.$rs->fields['total'];
		
	if($updown == 'up'){
		if($kategori == 'namaPemohon'){
			$err='UPnama_pemohon';
		}
	} else {
		if($kategori == 'namaPemohon'){
			$err='DOWNnama_pemohon';
		}
	}

	// if($rss){
	// 	// KEMASKINI DATA DETAIL
	// 	$err='OK';
	// } else {
	// 	$err='ERR'; 
	// }

}

function get_pemohon($conn){

	$StartRow = 0;
	//$conn->debug=true;
	global $schema2;

	$sql = "SELECT A.id_pemohon,A.nama_penuh, A.ICNo,A.d_cipta,A.d_kemaskini,A.pengakuan, B.diskripsi, C.kod_jawatan  FROM $schema2.calon A, $schema2.ref_negeri B, $schema2.calon_jawatan_dipohon C WHERE A.negeri=B.kod AND A.id_pemohon=C.id_pemohon GROUP BY A.id_pemohon DESC";

	$strSQL=$sql. " LIMIT 10";
	$rs = $conn->query($strSQL);

	return $rs;
}

function get_auditrail($conn, $id_pemohon){
	// $conn->debug=true;
	$StartRow = 0;
	global $schema2;

	$sql = "SELECT A.remarks FROM $schema2.auditrail A WHERE A.id_user=".tosql($id_pemohon);
	
	$rs = $conn->query($sql);
	return $rs;
}

function get_negeri($conn){
	global $schema2;
	// $conn->debug=true;
	$sql = "SELECT * FROM $schema2.`ref_negeri` WHERE 1";
	$rs = $conn->query($sql);
	
	$data='';
	while(!$rs->EOF){
		$data .= '<option value="'.$rs->fields['kod'].'"';
		$data .= '>'.$rs->fields['diskripsi'].'</option>';
		$rs->movenext();
	}

	return $data;

}

function get_jawatan($conn)
{
	global $schema1;
	global $schema2;

	// $conn->debug=true;
	$sql = "SELECT C.DISKRIPSI, C.KOD, A.id_pemohon FROM $schema2.calon_jawatan_dipohon A, $schema1.ref_skim C  WHERE A.kod_jawatan=C.KOD";
	$rs = $conn->query($sql);

	return $rs;
}

function get_skim($conn){
	global $schema1;
	// $conn->debug=true;
	$sql = "SELECT DISKRIPSI, KOD FROM $schema1.`ref_skim`";
	$rs = $conn->query($sql);
	
	$data='';
	while(!$rs->EOF){
		$data .= '<option value="'.$rs->fields['KOD'].'"';
		$data .= '>'.$rs->fields['DISKRIPSI'].'</option>';
		$rs->movenext();
	}

	return $data;

} if($frm=='BIODATA'){
	 //$conn->debug=true; 
	if($pro=='SAVE'){
		$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
		$e_mail=isset($_REQUEST["e_mail"])?$_REQUEST["e_mail"]:"";
		
		$strSQL = "UPDATE $schema2.`calon` SET ";
		$strSQL .= "e_mail=".tosqln($e_mail); 
		$strSQL .= " WHERE id_pemohon=".tosql($id_pemohon);
		$rss = $conn->execute($strSQL);

		$strSQL1 = "UPDATE $schema2.`myid` SET ";
		$strSQL1 .= "emel=".tosqln($e_mail); 
		$strSQL1 .= " WHERE id_pemohon=".tosql($id_pemohon);
		//.", e_mail=".tosql($e_mail)
		$conn->execute($strSQL1);

		if($rss){
			$err='OK';
		} else {
			$err='ERR1'; 
		}
	}
}
// header("Content-Type: text/json");
// print json_encode($err); 
print $err;

?>