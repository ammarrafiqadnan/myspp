<?php
session_start();
include '../../../connection/common.php';
$frm=isset($_GET["frm"])?$_GET["frm"]:"";
$pro=isset($_GET["pro"])?$_GET["pro"]:"";
$date=date("Y-m-d H:i:s");
$oleh=$_SESSION['SESSADM_UID'];
// $conn->debug=true;
$err='ERR';



if($frm=='KLUSTER'){
	//$conn->debug=true;

	if($pro == 'UPD'){
	/*
		$kluster=isset($_REQUEST["gkluster"])?$_REQUEST["gkluster"]:"";
		$mp=isset($_REQUEST["gmp"])?$_REQUEST["gmp"]:"";
		$bidang=isset($_REQUEST["gbidang"])?$_REQUEST["gbidang"]:"";
		$kod=isset($_REQUEST["kod"])?$_REQUEST["kod"]:"";

		$sql = "UPDATE $schema1.`ref_kluster_main` SET ";
		
		$rss = $conn->Execute($sql);

		if($rss){
			// KEMASKINI DATA DETAIL
			$err='OK';
		} else {
			$err='ERR'; 
		}
	*/

	} else if($pro == 'ADD'){
		$kluster=isset($_REQUEST["gkluster"])?$_REQUEST["gkluster"]:"";
		$mp=isset($_REQUEST["gmp"])?$_REQUEST["gmp"]:"";
		$bidang=isset($_REQUEST["gbidang"])?$_REQUEST["gbidang"]:"";
		$kod=isset($_REQUEST["kod"])?$_REQUEST["kod"]:"";

		$datas=''; $bilk=0;
		$kods = explode(",", $kod);
		foreach($kods as $getcode) {
		    $getcode = trim($getcode);
		    if($bilk==0){ 
			    $datas .= "(".tosql($kluster).", ".tosql($mp).", ".tosql($bidang).", ".tosql($getcode).", 0, 0, ".tosql($date).", ".tosql($oleh).")";
			} else {
			    $datas .= ",(".tosql($kluster).", ".tosql($mp).", ".tosql($bidang).", ".tosql($getcode).", 0, 0, ".tosql($date).", ".tosql($oleh).")";
			}
			$bilk++;
		}

		$sql = "INSERT INTO $schema1.`ref_padanan_kluster`(`kod_kluster`,`kod_mpelajaran`,`kod_bidang`,`kod_pengkhususan`,`is_deleted`,`status`, `create_dt`, `create_by`)";
		$sql .= " VALUES ".$datas;
		// $sql .= " VALUES(".tosql($kluster).", ".tosql($mp).", ".tosql($bidang).", ".tosql($kod).", 0, 0, ".tosql($date).", ".tosql($oleh).")";
		// admin_audit_trail($sql, "HAPUS PENGGUNA");

		// print $sql; exit;
		$rss = $conn->Execute($sql);

		if($rss){
			// KEMASKINI DATA DETAIL
			$err='OK';
		} else {
			$err='ERR'; 
		}

		//exit();	
	} else if($pro == 'HAPUS'){
	
		$id_klu=isset($_REQUEST["id_klu"])?$_REQUEST["id_klu"]:"";
		$sql = "UPDATE $schema1.ref_padanan_kluster SET is_deleted=1, update_dt=".tosql($date).", update_by=".tosql($oleh)." WHERE `id`='{$id_klu}'"; 
		$rss = $conn->Execute($sql);
		// admin_audit_trail($sql, "HAPUS PENGGUNA");

		if($rss){
			// KEMASKINI DATA DETAIL
			$err='OK';
		} else {
			$err='ERR'; 
		}
	} else if($pro == 'HAPUS_ALL'){
		//&kod='+kod+'&gkluster='+kluster+'&gmp='+matapelajaran+'&gbidang='+bidang
	
		$gkluster=isset($_REQUEST["gkluster"])?$_REQUEST["gkluster"]:"";
		$gmp=isset($_REQUEST["gmp"])?$_REQUEST["gmp"]:"";
		$gbidang=isset($_REQUEST["gbidang"])?$_REQUEST["gbidang"]:"";
		
		$sql = "UPDATE $schema1.ref_padanan_kluster SET is_deleted=1, update_dt=".tosql($date).", update_by=".tosql($oleh)." 
		WHERE `kod_kluster`='{$gkluster}' AND `kod_mpelajaran`='{$gmp}' AND `kod_bidang`='{$gbidang}'"; 
		//print $sql;
		$rss = $conn->Execute($sql);
		// admin_audit_trail($sql, "HAPUS PENGGUNA");

		if($rss){
			// KEMASKINI DATA DETAIL
			$err='OK';
		} else {
			$err='ERR'; 
		}
	} 
}
// header("Content-Type: text/json");
// print json_encode($err); 
print $err;
?>