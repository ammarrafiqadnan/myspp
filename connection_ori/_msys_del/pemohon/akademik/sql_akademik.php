<?php
session_start();
@include_once '../../connection/common.php';
$frm=isset($_GET["frm"])?$_GET["frm"]:"";
$pro=isset($_GET["pro"])?$_GET["pro"]:"";
$date=date("Y-m-d H:i:s");
//$oleh=$_SESSION['SESS_UID'];
//$conn->debug=true;
// print $frm.":".$pro; 

$err='ERR';

function get_all($conn, $id_pemohon){
	// $conn->debug=true;
	global $schema2;
	$sql = "SELECT * FROM $schema2.calon WHERE `id_pemohon`=".tosql($id_pemohon);
	$rs = $conn->query($sql);
	
	return $rs;
}

function get_pmr_result($conn, $id_pemohon, $tahun){
	global $schema2;

	$sql = "SELECT A.* FROM $schema2.calon_srp A  WHERE A.id_pemohon=".tosql($id_pemohon)." AND `tahun`=".tosql($tahun);
    
	$rs = $conn->query($sql);
	return $rs;
}

function get_spm_result($conn, $id_pemohon, $tahun_spm){
	// $conn->debug=true;
	global $schema2;

	$sql = "SELECT A.* FROM $schema2.calon_spm A  WHERE A.id_pemohon=".tosql($id_pemohon)." AND `tahun`=".tosql($tahun_spm);
    
	$rs = $conn->query($sql);
	return $rs;
}

function get_stp_result($conn, $id_pemohon, $tahun_stp){
	// $conn->debug=true;
	global $schema2;

	$sql = "SELECT A.* FROM $schema2.calon_stp_stam A  WHERE A.id_pemohon=".tosql($id_pemohon)." AND `tahun`=".tosql($tahun_stp);
    
	$rs = $conn->query($sql);
	return $rs;
}

function get_stam_result($conn, $id_pemohon, $tahun_stam){
	// $conn->debug=true;
	global $schema2;

	$sql = "SELECT A.* FROM $schema2.calon_stp_stam A  WHERE A.id_pemohon=".tosql($id_pemohon)." AND `tahun`=".tosql($tahun_stam);
    
	$rs = $conn->query($sql);
	return $rs;
}

?>