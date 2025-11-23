<?php
session_start();
@include_once '../../connection/common.php';
$frm=isset($_GET["frm"])?$_GET["frm"]:"";
$pro=isset($_GET["pro"])?$_GET["pro"]:"";
$date=date("Y-m-d H:i:s");
//$oleh=$_SESSION['SESS_UID'];
// $conn->debug=true;
// print $frm.":".$pro; 

$err='ERR';

function get_myid($conn, $id_pemohon){

	$StartRow = 0;
	global $schema2;
	$sql = "SELECT A.*, B.diskripsi, D.diskripsi as negeriLahirPemohon FROM $schema2.myid A, $schema2.ref_negeri B, $schema2.calon C,$schema2.ref_negeri D WHERE A.negeri=B.kod AND A.id_pemohon=C.id_pemohon AND C.negeri_lahir_pemohon=D.kod AND A.id_pemohon=".tosql($id_pemohon);
	$rs = $conn->query($sql);

	// $sql = "SELECT A.*, B.diskripsi as disk1,  B.diskripsi as disk2 FROM $schema2.myid A, $schema2.ref_negeri B, $schema2.calon C WHERE A.negeri=B.kod AND A.id_pemohon=B.id_pemohon AND C.negeri_lahir_pemohon=B.kod";
	// $rs = $conn->query($sql);

	return $rs;
}


function get_calon($conn, $id_pemohon){

	$StartRow = 0;
	global $schema2;
	$sql = "SELECT A.*, B.diskripsi, C.diskripsi as negeriLahirIbu, D.diskripsi as negeriLahirBapa, E.diskripsi as negeriLahirPemohon FROM $schema2.calon A, $schema2.ref_negeri B, $schema2.ref_negeri C, $schema2.ref_negeri D, $schema2.ref_negeri E WHERE A.negeri=B.kod AND A.negeri_lahir_pemohon=E.kod AND A.negeri_lahir_ibu=C.kod AND A.negeri_lahir_bapa=D.kod AND A.id_pemohon=".tosql($id_pemohon). "";
	$rs = $conn->query($sql);

	// $sql = "SELECT A.*, B.diskripsi as disk1,  B.diskripsi as disk2 FROM $schema2.myid A, $schema2.ref_negeri B, $schema2.calon C WHERE A.negeri=B.kod AND A.id_pemohon=B.id_pemohon AND C.negeri_lahir_pemohon=B.kod";
	// $rs = $conn->query($sql);

	return $rs;
}

?>