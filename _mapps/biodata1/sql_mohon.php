<?php
session_start();
if(file_exists('../connection/common.php')){
	include '../connection/common.php';
} else {
	include '../../connection/common.php';
}
$frm=isset($_GET["frm"])?$_GET["frm"]:"";
$pro=isset($_GET["pro"])?$_GET["pro"]:"";
$date=date("Y-m-d H:i:s");
$dt_mohon=date("Y-m-d H:i:s");
//$oleh=$_SESSION['SESS_UID'];
// $conn->debug=true;
if($frm=='MOHON'){
	// $conn->debug=true;
	if($pro=='SAVE'){
		$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
		$pusat_temuduga=isset($_REQUEST["pusat_temuduga"])?$_REQUEST["pusat_temuduga"]:"";
		$jawatan=isset($_REQUEST["jawatan"])?$_REQUEST["jawatan"]:"";
		
		$rs = $conn->query("SELECT * FROM $schema2.`calon_jawatan_dipohon` WHERE `id_pemohon`=".tosql($id_pemohon));
		if(!$rs->EOF){
			$conn->query("DELETE FROM $schema2.`calon_jawatan_dipohon` WHERE `id_pemohon`=".tosql($id_pemohon));
			$conn->query("DELETE FROM $schema2.`calon_pusat_temuduga` WHERE `id_pemohon`=".tosql($id_pemohon));
		}
	
		$str_arr = explode (",", $jawatan); 
		// print_r($str_arr);
		$bil=0;
		foreach ($str_arr as $a){ $bil++;
			$peringkat = "SPM";
    		$sql = "INSERT INTO $schema2.`calon_jawatan_dipohon`(`id_pemohon`,`kod_jawatan`, `peringkat`, `d_mohon`, `seq_no`, `d_cipta`) 
    		VALUES('{$id_pemohon}', '{$a}', '{$peringkat}', '{$dt_mohon}', '{$bil}', '{$date}')";
    		$conn->execute($sql);
    		$sql2 = "INSERT INTO $schema2.`calon_pusat_temuduga`(`id_pemohon`,`kod_jawatan`, `peringkat`, `d_mohon`, `pusat_temuduga`, `sesi_temuduga`, `d_cipta`) 
    		VALUES('{$id_pemohon}', '{$a}', '{$peringkat}', '{$dt_mohon}', '{$pusat_temuduga}', '01', '{$date}')";
    		$conn->execute($sql2);
		}
		// $sql = "";
		//.", e_mail=".tosql($e_mail)
		// $rss = $conn->execute($strSQL1);

		// if($rss){
		// 	$err='OK';
		// } else {
		// 	$err='ERR'; 
		// }
	}
	$err='OK';

} else if($frm=='PERAKUAN' && $pro=='SAVE'){ 
	// $conn->debug=true;
	$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";

	$sql = "UPDATE $schema2.`calon` SET `pengakuan`='Y', `tarikh_akuan`=".tosql(date("Y-m-d H:i:s")).", `status_pemohon`='Y' WHERE `id_pemohon`=".tosql($id_pemohon);
	$rss = $conn->execute($sql);


	$sql = "UPDATE $schema2.`calon_tarikh` SET `pengakuan`='Y', `tarikh_akuan`=".tosql(date("Y-m-d H:i:s")).", `status_pemohon`='Y' WHERE `id_pemohon`=".tosql($id_pemohon);
	$rss = $conn->execute($sql);

	if($rss){
		$err='OK';
	} else {
		$err='ERR'; 
	}

}

// header("Content-Type: text/json");
// print json_encode($err); 
print $err;
?>
