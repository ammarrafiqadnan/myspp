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
//$conn->debug=true;
if($frm=='MOHON'){
	
	if($pro=='SAVE'){
		$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
		$pusat_temuduga=isset($_REQUEST["pusat_temuduga"])?$_REQUEST["pusat_temuduga"]:"";
		$jawatan=isset($_REQUEST["jawatan"])?$_REQUEST["jawatan"]:"";
		
		$rs = $conn->query("SELECT * FROM $schema2.`calon_jawatan_dipohon` WHERE `id_pemohon`=".tosql($id_pemohon));
		if(!$rs->EOF){
			$conn->query("DELETE FROM $schema2.`calon_jawatan_dipohon` WHERE `id_pemohon`=".tosql($id_pemohon));
			$conn->query("DELETE FROM $schema2.`calon_pusat_temuduga` WHERE `id_pemohon`=".tosql($id_pemohon));
			$sql3 = "UPDATE $schema2.`calon` SET `pengakuan`=NULL, `tarikh_akuan`=NULL, `status_pemohon`=NULL WHERE id_pemohon=".tosql($id_pemohon);
			$conn->execute($sql3);
		}
	
		$str_arr = explode (",", $jawatan); 
		// print_r($str_arr);
		$bil=0;
		foreach ($str_arr as $a){ $bil++;
			$peringkat = "SPM";
			$sql="SELECT A.`kod_skim`, A.`kod_peringkat_akademik`, B.`kod_diskripsi` FROM $schema1.`padanan_peringkatakademik_skim` A, $schema1.`ref_peringkat_akademik` B 
			WHERE A.`kod_peringkat_akademik`=B.`kod` AND A.is_deleted=0 AND A.status=0 AND A.kod=".tosql($a);
			

			$rsks = $conn->query($sql);
			$kod_skim = $rsks->fields['kod_skim'];
			$kod_peringkat = $rsks->fields['kod_peringkat_akademik'];
			$peringkat = $rsks->fields['kod_diskripsi'];

    			$sql = "INSERT INTO $schema2.`calon_jawatan_dipohon`(`id_pemohon`,`kod_jaw_skim`,`kod_peringkat`,`kod_jawatan`, `peringkat`, `d_mohon`, `seq_no`, `d_cipta`) 
    			VALUES('{$id_pemohon}', '{$a}', '{$kod_peringkat}', '{$kod_skim}', '{$peringkat}', '{$dt_mohon}', '{$bil}', '{$date}')";
    			$conn->execute($sql);
			
		}

		$sql2 = "INSERT INTO $schema2.`calon_pusat_temuduga`(`id_pemohon`,`kod_jawatan`, `peringkat`, `d_mohon`, `pusat_temuduga`, `sesi_temuduga`, `d_cipta`) 
   			VALUES('{$id_pemohon}', 'NULL', '{$peringkat}', '{$dt_mohon}', ".tosql($pusat_temuduga).", '01', '{$date}')";
		$conn->execute($sql2);

		//$sql3 = "UPDATE $schema2.`calon` SET `pengakuan`=NULL, `tarikh_akuan`=NULL, `status_pemohon`=NULL WHERE id_pemohon=".tosql($id_pemohon);
		//$conn->execute($sql3);

		// $sql = "";
		//.", e_mail=".tosql($e_mail)
		// $rss = $conn->execute($strSQL1);

		// if($rss){
		// 	$err='OK';
		// } else {
		// 	$err='ERR'; 
		// }
	}

	set_tarikh($id_pemohon, "tkh_upd_jawatan");

	$err='OK';

} else if($frm=='PERAKUAN' && $pro=='SAVE'){ 
	//$conn->debug=true;
	$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";

	//if($id_pemohon == '2023860623135252'){
	 	//$conn->debug=true;
//}

	$rs = $conn->query("SELECT ketinggian, berat, year(dob) AS tahuns FROM $schema2.`calon` WHERE `id_pemohon`=".tosql($id_pemohon));
	
	$tinggi = $rs->fields['ketinggian'];
	$berat = $rs->fields['berat'];
	$dob = $rs->fields['tahuns'];

	if(!empty($tinggi) && !empty($berat)){ 
		$sqh=$tinggi*$tinggi;
		if(!empty($sqh)){ 
			$BMI = number_format($berat/$sqh,2);
		} else { $BMI=0; }
	}

	if(!empty($dob)){
		//$gumur = substr($dob,4)-0;
		$umur = date("Y")-$dob;
	}

	
	$BMI = str_replace(",", "", $BMI);
	$sql = "UPDATE $schema2.`calon` SET `bmi`='{$BMI}', `umur`='{$umur}' WHERE `id_pemohon`=".tosql($id_pemohon);
	$rss = $conn->execute($sql);



	if($rss){
		$err='OK';
		$dt = date("Y-m-d H:i:s");

		$sqlJ = "SELECT * FROM $schema2.`calon_jawatan_dipohon` A, $schema1.`ref_skim` B WHERE A.`kod_jawatan`=B.`KOD`";
   	     	$sqlJ .= " AND A.`id_pemohon`=".tosql($id_pemohon);  
        	$sqlJ .= " ORDER BY A.`seq_no` ASC";
        	$rsJawatan1 = $conn->query($sqlJ); $bil=0;

        	$bl=0; $J1=''; $J2=''; $J3=''; $Jawatan = '<font style="color:red">Tidak Lengkap. Sila semak semula maklumat diisi</font>';
        	while(!$rsJawatan1->EOF){
            		if($bl==0){
                		$J1 = $rsJawatan1->fields['kod_jawatan'];
            		} else if($bl==1){ 
                		$J2 = $rsJawatan1->fields['kod_jawatan'];
           		} else {
                		$J3 = $rsJawatan1->fields['kod_jawatan'];
            		}
            		$bl++; $Jawatan='Lengkap';
            		$rsJawatan1->movenext();
        	}


		$sql = "UPDATE $schema2.`calon` SET `pengakuan`='Y', `tarikh_akuan`=".tosql(date("Y-m-d H:i:s")).", `status_pemohon`=NULL, `tarikh_espp`=NULL 
			WHERE `id_pemohon`=".tosql($id_pemohon);
		$rss = $conn->execute($sql);
		// UPLOAD DATA KE SISTEM eSPP BAGI TUJUAN PROSES
		//include 'sql_upload.php';	
		//$err='OK';
		// KEMASKINI PENGHANTARAN KE eSPP
		if($err=='OK' || $err=='ERRORA'){
			if(!empty($oraerr)){ $err = $oraerr."OK"; }
			//$conn->debug=true;
			$ip_add = get_client_ipadd();
			$sql = "UPDATE $schema2.`myid` SET `ip_addr`=".tosql($ip_add)." WHERE `id_pemohon`=".tosql($id_pemohon);
			$conn->execute($sql);

			// KEMASKINI PERAKUAN
			//set_tarikh($id_pemohon, "tkh_upd_perakuan");
			$futureDate=date('Y-m-d', strtotime('+1 year'));
			$sql = "UPDATE $schema2.`calon_tarikh` SET `pengakuan`='Y', `tarikh_akuan`=".tosql(date("Y-m-d H:i:s")).", `tkh_upd_perakuan`=".tosql(date("Y-m-d H:i:s")).", 
				`tarikh_luput`='{$futureDate}', `tkh_espp`=NULL WHERE `id_pemohon`=".tosql($id_pemohon);
			$rss = $conn->execute($sql);

			//$rs = $conn->query("INSERT INTO `calon_tarikh_sejarah` SELECT * FROM `calon_tarikh` WHERE `id_pemohon`=".tosql($id_pemohon));
			$rs = $conn->query("SELECT * FROM $schema2.`calon_tarikh` WHERE `id_pemohon`=".tosql($id_pemohon));
			$sql = "INSERT INTO $schema2.`calon_tarikh_sejarah`(`id_pemohon`, `tkh_upd_biodata`, `tkh_upd_akademik`, `tkh_upd_koko`, 
			`tkh_upd_awam`, `tkh_upd_tambahan`, `tkh_upd_jawatan`, `tkh_upd_perakuan`, `tarikh_luput`, 
			`pengakuan`, `tarikh_akuan`, `status_pemohon`, `jawatan1`, `jawatan2`, `jawatan3`, `create_dt`)";
			$sql .= " VALUES(".tosql($id_pemohon).", ".tosql($rs->fields['tkh_upd_biodata']).", ".tosql($rs->fields['tkh_upd_akademik']).", ".tosql($rs->fields['tkh_upd_koko']).", 
			".tosql($rs->fields['tkh_upd_awam']).", ".tosql($rs->fields['tkh_upd_tambahan']).", ".tosql($rs->fields['tkh_upd_jawatan']).", ".tosql($rs->fields['tkh_upd_perakuan']).", '{$futureDate}', 
			".tosql($rs->fields['pengakuan']).", ".tosql($rs->fields['tarikh_akuan']).", ".tosql($rs->fields['status_pemohon']).", ".tosql($J1).", ".tosql($J2).", ".tosql($J3).", '{$dt}')";		
			$conn->execute($sql);

		}
	} else {
		$err='ERR'; 
	}
	// set_tarikh($id_pemohon, "tkh_upd_perakuan");

}
// header("Content-Type: text/json");
// print json_encode($err); 
print $err;
?>
