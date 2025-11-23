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
function get_sql($sql, $pg){

	global $conn;
	//Set the page size
$PageSize = 10;
$StartRow = 0;

//Set the page no
if(empty($_GET['PageNo'])){
    if($StartRow == 0){
        $PageNo = $StartRow + 1;
    }
}else{
    $PageNo = $_GET['PageNo'];
    $StartRow = ($PageNo - 1) * $PageSize;
}

//Set the counter start
if($PageNo % $PageSize == 0){
    $CounterStart = $PageNo - ($PageSize - 1);
}else{
    $CounterStart = $PageNo - ($PageNo % $PageSize) + 1;
}

//Counter End
$CounterEnd = $CounterStart + ($PageSize - 1);

$sSQL=$sql;
$strSQL=$sql. " LIMIT $StartRow,$PageSize ";
//$conn->debug=true;
//echo $strSQL;
$rs = $conn->query($strSQL);

$rs1 = $conn->query($sSQL);
$RecordCount = $rs1->recordcount();
				
//$TRecord = mysql_query($sSQL);
//$result = mysql_query($strSQL);

//Total of record
//$RecordCount = mysql_num_rows($TRecord);
//Set Maximum Page
$MaxPage = $RecordCount % $PageSize;
if($RecordCount % $PageSize == 0){
   $MaxPage = $RecordCount / $PageSize;
}else{
   $MaxPage = ceil($RecordCount / $PageSize);
}
return $rs.":".$MaxPage;
}
// function get_pemohon($conn, $pg, $pgSize){
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

}
?>