<?php
session_start();
@include_once '../../connection/common.php';
$frm=isset($_GET["frm"])?$_GET["frm"]:"";
$pro=isset($_GET["pro"])?$_GET["pro"]:"";
$date=date("Y-m-d H:i:s");
$oleh=$_SESSION['SESS_UID'];
//$conn->debug=true;


if($frm=='POLIS'){
	$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
	$kategori=isset($_REQUEST["kategori"])?$_REQUEST["kategori"]:"";
	$pangkat=isset($_REQUEST["pangkat"])?$_REQUEST["pangkat"]:"";
	$ganjaran=isset($_REQUEST["ganjaran"])?$_REQUEST["ganjaran"]:"";

	
	if($pro=='SAVE'){
				
		$rs = $conn->query("SELECT * FROM $schema2.`calon_polis_ban_oku` WHERE `ind`='P' AND `id_pemohon`='{$id_pemohon}'");

		if(!$rs->EOF){
			$strSQL = "UPDATE $schema2.`calon_polis_ban_oku` SET `kategori`=".tosql($kategori).", pangkat=".tosql($pangkat).", 
			rujukan_ganjaran=".tosql($ganjaran).", d_kemaskini=".tosql($date); 
			$strSQL .= " WHERE `ind`='P' AND `id_pemohon`='{$id_pemohon}'";
			$rss = $conn->execute($strSQL);
			// audit_trail($strSQL, "KEMASKINI");
		} else {
			$strSQL = "INSERT INTO $schema2.`calon_polis_ban_oku`(id_pemohon, kategori, pangkat, rujukan_ganjaran, ind, d_cipta, d_kemaskini) 
				VALUES(".tosql($id_pemohon).", ".tosql($kategori).", ".tosql($pangkat).", ".tosql($ganjaran).", 'P', ".tosql($date).", ".tosql($date).")";
			$rss = $conn->execute($strSQL);
			// audit_trail($strSQL, "TAMBAH");
		}
		//exit;
		if($rss){
			$err='OK';
		} else {
			$err='ERR'; 
		}
	
	} else if($pro=="DEL"){
	
		$sqld = "DELETE FROM $schema2.`calon_polis_ban_oku` WHERE `ind`='P' AND `id_pemohon`='{$id_pemohon}'";
		$rss = $conn->execute($sqld);
		// audit_trail($sqld, "HAPUS");

		if($rss){
			$err='OK';
		} else {
			$err='ERR'; 
		}
	}		

} else if($frm=='INNOVASI'){

	// $conn->debug=true;
	if($pro=='SAVE'){ 
		$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
		$rekacipta=isset($_REQUEST["rekacipta"])?$_REQUEST["rekacipta"]:"";
		$sumbangan=isset($_REQUEST["sumbangan"])?$_REQUEST["sumbangan"]:"";
		$peringkat=isset($_REQUEST["peringkat"])?$_REQUEST["peringkat"]:"";
		$rekaciptaAsal=isset($_REQUEST["rekaciptaAsal"])?$_REQUEST["rekaciptaAsal"]:"";
		$sumbanganAsal=isset($_REQUEST["sumbanganAsal"])?$_REQUEST["sumbanganAsal"]:"";
		$peringkatAsal=isset($_REQUEST["peringkatAsal"])?$_REQUEST["peringkatAsal"]:"";

		$rss = $conn->query("SELECT * FROM $schema2.`calon_ko_rekacipta` WHERE id_pemohon=".tosql($id_pemohon));
			// ." AND `rekacipta`=".tosql($rekaciptaAsal)." AND `sumbangan`=".tosql($sumbanganAsal)." AND `peringkat`=".tosql($peringkatAsal));

		if(!$rss->EOF){
			$sql = "UPDATE $schema2.`calon_ko_rekacipta` SET `rekacipta`=".tosql($rekacipta).", `sumbangan`='{$sumbangan}', `peringkat`='{$peringkat}', `d_kemaskini`='{$date}' 
			WHERE id_pemohon='{$id_pemohon}'";
			// " AND `rekacipta`=".tosql($rekaciptaAsal)." AND `sumbangan`='{$sumbanganAsal}' AND `peringkat`='{$peringkatAsal}'"; 
			$rss = $conn->execute($sql);
		} else {
			if(!empty($rekacipta) && !empty($sumbangan) && !empty($peringkat)){ 
				$sql = "INSERT INTO $schema2.`calon_ko_rekacipta`(`id_pemohon`, `rekacipta`, `sumbangan`, `peringkat`, `d_cipta`, `d_kemaskini`) 
				VALUES('{$id_pemohon}', ".tosql($rekacipta).", '{$sumbangan}', '{$peringkat}', '{$date}', '{$date}')";
				$rss = $conn->execute($sql);
			}
		}


		if($rss){
			$err='OK';
		} else {
			$err='ERR'; 
		}

		$pencapaian=isset($_REQUEST["pencapaian"])?$_REQUEST["pencapaian"]:"";
		$pencapaianAsal=isset($_REQUEST["pencapaianAsal"])?$_REQUEST["pencapaianAsal"]:"";

		$rss = $conn->query("SELECT * FROM $schema2.`calon_ko_khas` WHERE id_pemohon=".tosql($id_pemohon));

		if(!$rss->EOF){
			$sql1 = "UPDATE $schema2.`calon_ko_khas` SET `pencapaian`=".tosql($pencapaian).", `d_kemaskini`='{$date}' 
			WHERE `id_pemohon`='{$id_pemohon}'"; 
			$rss = $conn->execute($sql1);
		} else {
			$sql1 = "INSERT INTO $schema2.`calon_ko_khas`(`id_pemohon`, `pencapaian`, `d_cipta`, `d_kemaskini`) 
				VALUES('{$id_pemohon}', ".tosql($pencapaian).", '{$date}', '{$date}')";
			$rss = $conn->execute($sql1);
		}


		if($rss){
			$err='OK';
		} else {
			$err='ERR'; 
		}

	} else if($pro=='DEL'){
		$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
		$rss = $conn->execute("DELETE FROM $schema2.`calon_ko_rekacipta` WHERE `id_pemohon`='{$id_pemohon}'");	
		$rss = $conn->execute("DELETE FROM $schema2.`calon_ko_khas` WHERE `id_pemohon`='{$id_pemohon}'");	
		if($rss){
			$err='OK';
		} else {
			$err='ERR'; 
		}
	}

} else if($frm=='SUKAN'){
	$err="OK";

	// print $frm.":".$pro.":".$sukan1;

	if($pro=='SAVE'){

		$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";

		$sukan1=isset($_REQUEST["sukan1"])?$_REQUEST["sukan1"]:"";
		$peringkat1=isset($_REQUEST["peringkat1"])?$_REQUEST["peringkat1"]:"";
		$sukan_u1=isset($_REQUEST["sukan_u1"])?$_REQUEST["sukan_u1"]:"";
		$peringkat_u1=isset($_REQUEST["peringkat_u1"])?$_REQUEST["peringkat_u1"]:"";

		$sukan2=isset($_REQUEST["sukan2"])?$_REQUEST["sukan2"]:"";
		$peringkat2=isset($_REQUEST["peringkat2"])?$_REQUEST["peringkat2"]:"";
		$sukan_u2=isset($_REQUEST["sukan_u2"])?$_REQUEST["sukan_u2"]:"";
		$peringkat_u2=isset($_REQUEST["peringkat_u2"])?$_REQUEST["peringkat_u2"]:"";

		$sukan3=isset($_REQUEST["sukan3"])?$_REQUEST["sukan3"]:"";
		$peringkat3=isset($_REQUEST["peringkat3"])?$_REQUEST["peringkat3"]:"";
		$sukan_u3=isset($_REQUEST["sukan_u3"])?$_REQUEST["sukan_u3"]:"";
		$peringkat_u3=isset($_REQUEST["peringkat_u3"])?$_REQUEST["peringkat_u3"]:"";
		
		// KEMASKINI DATA SUKAN				
		if(!empty($sukan1) && !empty($peringkat1)){
			$rss = $conn->query("SELECT * FROM $schema2.`calon_ko_sukan` WHERE `id_pemohon`='{$id_pemohon}' AND `sukan`='{$sukan_u1}' 
				AND `peringkat`='{$peringkat_u1}'");
			if(!$rss->EOF){
				if($sukan1!=$sukan_u1 || $peringkat1!=$peringkat_u1){ 
					$strSQL = "UPDATE $schema2.`calon_ko_sukan` SET `sukan`=".tosql($sukan1).", peringkat=".tosql($peringkat1).", d_kemaskini=".tosql($date); 
					$strSQL .= " WHERE `id_pemohon`='{$id_pemohon}' AND `sukan`='{$sukan_u1}' AND `peringkat`='{$peringkat_u1}'";
					$rss = $conn->execute($strSQL);
				}
				// audit_trail($strSQL, "KEMASKINI");
			} else {
				$strSQL = "INSERT INTO $schema2.`calon_ko_sukan`(id_pemohon, sukan, peringkat, d_cipta, d_kemaskini) 
					VALUES(".tosql($id_pemohon).", ".tosql($sukan1).", ".tosql($peringkat1).", ".tosql($date).", ".tosql($date).")";
				$rss = $conn->execute($strSQL);
				// audit_trail($strSQL, "TAMBAH");
			}
		}

		if(!empty($sukan2) && !empty($peringkat2)){
			$rs = $conn->query("SELECT * FROM $schema2.`calon_ko_sukan` WHERE `id_pemohon`='{$id_pemohon}' AND `sukan`='{$sukan_u2}' 
				AND `peringkat`='{$peringkat_u2}'");
			if(!$rs->EOF){
				if($sukan2!=$sukan_u2 || $peringkat2!=$peringkat_u2){ 
					$strSQL = "UPDATE $schema2.`calon_ko_sukan` SET `sukan`=".tosql($sukan2).", peringkat=".tosql($peringkat2).", d_kemaskini=".tosql($date); 
					$strSQL .= " WHERE `id_pemohon`='{$id_pemohon}' AND `sukan`='{$sukan_u2}' AND `peringkat`='{$peringkat_u2}'";
					$rss = $conn->execute($strSQL);
				}
				// audit_trail($strSQL, "KEMASKINI");
			} else {
				$strSQL = "INSERT INTO $schema2.`calon_ko_sukan`(id_pemohon, sukan, peringkat, d_cipta, d_kemaskini) 
					VALUES(".tosql($id_pemohon).", ".tosql($sukan2).", ".tosql($peringkat2).", ".tosql($date).", ".tosql($date).")";
				$rss = $conn->execute($strSQL);
				// audit_trail($strSQL, "TAMBAH");
			}
		}

		if(!empty($sukan3) && !empty($peringkat3)){
			$rs = $conn->query("SELECT * FROM $schema2.`calon_ko_sukan` WHERE `id_pemohon`='{$id_pemohon}' AND `sukan`='{$sukan_u3}' 
				AND `peringkat`='{$peringkat_u3}'");
			if(!$rs->EOF){
				if($sukan3!=$sukan_u3 || $peringkat3!=$peringkat_u3){ 
					$strSQL = "UPDATE $schema2.`calon_ko_sukan` SET `sukan`=".tosql($sukan3).", peringkat=".tosql($peringkat3).", d_kemaskini=".tosql($date); 
					$strSQL .= " WHERE `id_pemohon`='{$id_pemohon}' AND `sukan`='{$sukan_u3}' AND `peringkat`='{$peringkat_u3}'";
					$rss = $conn->execute($strSQL);
					// audit_trail($strSQL, "KEMASKINI");
				}
			} else {
				$strSQL = "INSERT INTO $schema2.`calon_ko_sukan`(id_pemohon, sukan, peringkat, d_cipta, d_kemaskini) 
					VALUES(".tosql($id_pemohon).", ".tosql($sukan3).", ".tosql($peringkat3).", ".tosql($date).", ".tosql($date).")";
				$rss = $conn->execute($strSQL);
				// audit_trail($strSQL, "TAMBAH");
			}
		}


		//KEMASKINI DATA PERSATUAN/KEPIMPINAN
		// $conn->debug=true;
		$persatuan1=isset($_REQUEST["persatuan1"])?$_REQUEST["persatuan1"]:"";
		$jawatan1=isset($_REQUEST["jawatan1"])?$_REQUEST["jawatan1"]:"";
		$pperingkat1=isset($_REQUEST["pperingkat1"])?$_REQUEST["pperingkat1"]:"";
		$persatuan_u1=isset($_REQUEST["persatuan_u1"])?$_REQUEST["persatuan_u1"]:"";
		$jawatan_u1=isset($_REQUEST["jawatan_u1"])?$_REQUEST["jawatan_u1"]:"";
		$pperingkat_u1=isset($_REQUEST["pperingkat_u1"])?$_REQUEST["pperingkat_u1"]:"";

		if(!empty($persatuan1) && !empty($jawatan1) && !empty($pperingkat1)){
			$rss = $conn->query("SELECT * FROM $schema2.`calon_ko_persatuan` WHERE `id_pemohon`='{$id_pemohon}' AND `persatuan`=".tosql($persatuan_u1)." 
				AND `jawatan`='{$jawatan_u1}' AND `peringkat`='{$pperingkat_u1}'");
			if(!$rss->EOF){
				if($persatuan1!=$persatuan_u1 || $jawatan1!=$jawatan_u1 || $pperingkat1!=$pperingkat_u1){ 
					$strSQL = "UPDATE $schema2.`calon_ko_persatuan` SET `persatuan`=".tosql($persatuan1).", jawatan=".tosql($jawatan1).", 
						peringkat=".tosql($pperingkat1).", d_kemaskini=".tosql($date); 
					$strSQL .= " WHERE `id_pemohon`='{$id_pemohon}' AND `persatuan`=".tosql($persatuan_u1)." AND `jawatan`='{$jawatan_u1}' 
						AND `peringkat`='{$pperingkat_u1}'";
					$rss = $conn->execute($strSQL);
				}
				// audit_trail($strSQL, "KEMASKINI");
			} else {
				$strSQL = "INSERT INTO $schema2.`calon_ko_persatuan`(id_pemohon, persatuan, jawatan, peringkat, d_cipta, d_kemaskini) 
					VALUES(".tosql($id_pemohon).", ".tosql($persatuan1).", ".tosql($jawatan1).", ".tosql($pperingkat1).", ".tosql($date).", ".tosql($date).")";
				$rss = $conn->execute($strSQL);
				// audit_trail($strSQL, "TAMBAH");
			}
		}

		$persatuan2=isset($_REQUEST["persatuan2"])?$_REQUEST["persatuan2"]:"";
		$jawatan2=isset($_REQUEST["jawatan2"])?$_REQUEST["jawatan2"]:"";
		$pperingkat2=isset($_REQUEST["pperingkat2"])?$_REQUEST["pperingkat2"]:"";
		$persatuan_u2=isset($_REQUEST["persatuan_u2"])?$_REQUEST["persatuan_u2"]:"";
		$jawatan_u2=isset($_REQUEST["jawatan_u2"])?$_REQUEST["jawatan_u2"]:"";
		$pperingkat_u2=isset($_REQUEST["pperingkat_u2"])?$_REQUEST["pperingkat_u2"]:"";

		if(!empty($persatuan2) && !empty($jawatan2) && !empty($pperingkat2)){
			$rss = $conn->query("SELECT * FROM $schema2.`calon_ko_persatuan` WHERE `id_pemohon`='{$id_pemohon}' AND `persatuan`=".tosql($persatuan_u2)." 
				AND `jawatan`='{$jawatan_u2}' AND `peringkat`='{$pperingkat_u2}'");
			if(!$rss->EOF){
				if($persatuan2!=$persatuan_u2 || $jawatan2!=$jawatan_u2 || $pperingkat2!=$pperingkat_u2){ 
					$strSQL = "UPDATE $schema2.`calon_ko_persatuan` SET `persatuan`=".tosql($persatuan2).", jawatan=".tosql($jawatan2).", 
						peringkat=".tosql($pperingkat2).", d_kemaskini=".tosql($date); 
					$strSQL .= " WHERE `id_pemohon`='{$id_pemohon}' AND `persatuan`=".tosql($persatuan_u2)." AND `jawatan`='{$jawatan_u2}' 
						AND `peringkat`='{$pperingkat_u2}'";
					$rss = $conn->execute($strSQL);
				}
				// audit_trail($strSQL, "KEMASKINI");
			} else {
				$strSQL = "INSERT INTO $schema2.`calon_ko_persatuan`(id_pemohon, persatuan, jawatan, peringkat, d_cipta, d_kemaskini) 
					VALUES(".tosql($id_pemohon).", ".tosql($persatuan2).", ".tosql($jawatan2).", ".tosql($pperingkat2).", ".tosql($date).", ".tosql($date).")";
				$rss = $conn->execute($strSQL);
				// audit_trail($strSQL, "TAMBAH");
			}
		}

		$persatuan3=isset($_REQUEST["persatuan3"])?$_REQUEST["persatuan3"]:"";
		$jawatan3=isset($_REQUEST["jawatan3"])?$_REQUEST["jawatan3"]:"";
		$pperingkat3=isset($_REQUEST["pperingkat3"])?$_REQUEST["pperingkat3"]:"";
		$persatuan_u3=isset($_REQUEST["persatuan_u3"])?$_REQUEST["persatuan_u3"]:"";
		$jawatan_u3=isset($_REQUEST["jawatan_u3"])?$_REQUEST["jawatan_u3"]:"";
		$pperingkat_u3=isset($_REQUEST["pperingkat_u3"])?$_REQUEST["pperingkat_u3"]:"";

		if(!empty($persatuan3) && !empty($jawatan3) && !empty($pperingkat3)){
			$rss = $conn->query("SELECT * FROM $schema2.`calon_ko_persatuan` WHERE `id_pemohon`='{$id_pemohon}' AND `persatuan`=".tosql($persatuan_u3)." 
				AND `jawatan`='{$jawatan_u3}' AND `peringkat`='{$pperingkat_u3}'");
			if(!$rss->EOF){
				if($persatuan3!=$persatuan_u3 || $jawatan3!=$jawatan_u3 || $pperingkat3!=$pperingkat_u3){ 
					$strSQL = "UPDATE $schema2.`calon_ko_persatuan` SET `persatuan`=".tosql($persatuan3).", jawatan=".tosql($jawatan3).", 
						peringkat=".tosql($pperingkat3).", d_kemaskini=".tosql($date); 
					$strSQL .= " WHERE `id_pemohon`='{$id_pemohon}' AND `persatuan`=".tosql($persatuan_u3)." AND `jawatan`='{$jawatan_u3}' 
						AND `peringkat`='{$pperingkat_u3}'";
					$rss = $conn->execute($strSQL);
				}
				// audit_trail($strSQL, "KEMASKINI");
			} else {
				$strSQL = "INSERT INTO $schema2.`calon_ko_persatuan`(id_pemohon, persatuan, jawatan, peringkat, d_cipta, d_kemaskini) 
					VALUES(".tosql($id_pemohon).", ".tosql($persatuan3).", ".tosql($jawatan3).", ".tosql($pperingkat3).", ".tosql($date).", ".tosql($date).")";
				$rss = $conn->execute($strSQL);
				// audit_trail($strSQL, "TAMBAH");
			}
		}

		//exit;
		if($rss){
			$err='OK';
		} else {
			$err='ERR'; 
		}
	
	} else if($pro=="DEL_SUK"){
	
		$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
		$v1=isset($_REQUEST["v1"])?$_REQUEST["v1"]:"";
		$v2=isset($_REQUEST["v2"])?$_REQUEST["v2"]:"";
		
		$sqld = "DELETE FROM $schema2.`calon_ko_sukan` WHERE `id_pemohon`='{$id_pemohon}' AND `sukan`='{$v1}' AND `peringkat`='{$v2}'";
		$rss = $conn->execute($sqld);
		// audit_trail($sqld, "HAPUS");

		if($rss){
			$err='OK';
		} else {
			$err='ERR'; 
		}
	} else if($pro=="DEL_PER"){
	
		$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
		$v1=isset($_REQUEST["v1"])?$_REQUEST["v1"]:"";
		$v2=isset($_REQUEST["v2"])?$_REQUEST["v2"]:"";
		$v3=isset($_REQUEST["v3"])?$_REQUEST["v3"]:"";
	
		$sqld = "DELETE FROM $schema2.`calon_ko_persatuan` WHERE `id_pemohon`='{$id_pemohon}' AND `persatuan`='{$v1}' 
			AND `jawatan`='{$v2}' AND `peringkat`='{$v3}'";
		$rss = $conn->execute($sqld);
		// audit_trail($sqld, "HAPUS");

		if($rss){
			$err='OK';
		} else {
			$err='ERR'; 
		}
	}		

} else if($frm=='BAKAT'){
	$err="OK";

	if($pro=='SAVE'){

		$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";

		// KEMASKINI MAKLUMAT BAKAT				
		$bakat1=isset($_REQUEST["bakat1"])?$_REQUEST["bakat1"]:"";
		$bakat_u1=isset($_REQUEST["bakat_u1"])?$_REQUEST["bakat_u1"]:"";
		$bakat2=isset($_REQUEST["bakat2"])?$_REQUEST["bakat2"]:"";
		$bakat_u2=isset($_REQUEST["bakat_u2"])?$_REQUEST["bakat_u2"]:"";
		$bakat3=isset($_REQUEST["bakat3"])?$_REQUEST["bakat3"]:"";
		$bakat_u3=isset($_REQUEST["bakat_u3"])?$_REQUEST["bakat_u3"]:"";
		if(!empty($bakat1)){
			$rss = $conn->query("SELECT * FROM $schema2.`calon_bakat_bahasa` WHERE `id_pemohon`='{$id_pemohon}' AND `bakat_bahasa`='{$bakat_u1}' 
				AND `bakat_bahasa_ind`='B'");
			if(!$rss->EOF){
				if($bakat1!=$bakat_u1){ 
					$strSQL = "UPDATE $schema2.`calon_bakat_bahasa` SET `bakat_bahasa`=".tosql($bakat1).", `d_kemaskini`=".tosql($date); 
					$strSQL .= " WHERE `id_pemohon`='{$id_pemohon}' AND `bakat_bahasa`='{$bakat_u1}' AND `bakat_bahasa_ind`='B'";
					$rss = $conn->execute($strSQL);
				}
				// audit_trail($strSQL, "KEMASKINI");
			} else {
				$strSQL = "INSERT INTO $schema2.`calon_bakat_bahasa`(`id_pemohon`, `bakat_bahasa`, `bakat_bahasa_ind`, `d_cipta`, `d_kemaskini`) 
					VALUES(".tosql($id_pemohon).", ".tosql($bakat1).", 'B', ".tosql($date).", ".tosql($date).")";
				$rss = $conn->execute($strSQL);
				// audit_trail($strSQL, "TAMBAH");
			}
		}

		if(!empty($bakat2)){
			$rss = $conn->query("SELECT * FROM $schema2.`calon_bakat_bahasa` WHERE `id_pemohon`='{$id_pemohon}' AND `bakat_bahasa`='{$bakat_u2}' 
				AND `bakat_bahasa_ind`='B'");
			if(!$rss->EOF){
				if($bakat2!=$bakat_u2){ 
					$strSQL = "UPDATE $schema2.`calon_bakat_bahasa` SET `bakat_bahasa`=".tosql($bakat2).", `d_kemaskini`=".tosql($date); 
					$strSQL .= " WHERE `id_pemohon`='{$id_pemohon}' AND `bakat_bahasa`='{$bakat_u2}' AND `bakat_bahasa_ind`='B'";
					$rss = $conn->execute($strSQL);
				}
				// audit_trail($strSQL, "KEMASKINI");
			} else {
				$strSQL = "INSERT INTO $schema2.`calon_bakat_bahasa`(`id_pemohon`, `bakat_bahasa`, `bakat_bahasa_ind`, `d_cipta`, `d_kemaskini`) 
					VALUES(".tosql($id_pemohon).", ".tosql($bakat2).", 'B', ".tosql($date).", ".tosql($date).")";
				$rss = $conn->execute($strSQL);
				// audit_trail($strSQL, "TAMBAH");
			}
		}
		if(!empty($bakat3)){
			$rss = $conn->query("SELECT * FROM $schema2.`calon_bakat_bahasa` WHERE `id_pemohon`='{$id_pemohon}' AND `bakat_bahasa`='{$bakat_u3}' 
				AND `bakat_bahasa_ind`='B'");
			if(!$rss->EOF){
				if($bakat3!=$bakat_u3){ 
					$strSQL = "UPDATE $schema2.`calon_bakat_bahasa` SET `bakat_bahasa`=".tosql($bakat3).", `d_kemaskini`=".tosql($date); 
					$strSQL .= " WHERE `id_pemohon`='{$id_pemohon}' AND `bakat_bahasa`='{$bakat_u3}' AND `bakat_bahasa_ind`='B'";
					$rss = $conn->execute($strSQL);
				}
				// audit_trail($strSQL, "KEMASKINI");
			} else {
				$strSQL = "INSERT INTO $schema2.`calon_bakat_bahasa`(`id_pemohon`, `bakat_bahasa`, `bakat_bahasa_ind`, `d_cipta`, `d_kemaskini`) 
					VALUES(".tosql($id_pemohon).", ".tosql($bakat3).", 'B', ".tosql($date).", ".tosql($date).")";
				$rss = $conn->execute($strSQL);
				// audit_trail($strSQL, "TAMBAH");
			}
		}

		// KEMASKINI MAKLUMAT BAHASA				
		// $conn->debug=true;
		$bahasa1=isset($_REQUEST["bahasa1"])?$_REQUEST["bahasa1"]:"";
		$bahasa_u1=isset($_REQUEST["bahasa_u1"])?$_REQUEST["bahasa_u1"]:"";
		$penguasaan1=isset($_REQUEST["penguasaan1"])?$_REQUEST["penguasaan1"]:"";
		$penguasaan_u1=isset($_REQUEST["penguasaan_u1"])?$_REQUEST["penguasaan_u1"]:"";

		// print "BB:".$bahasa1.":".$penguasaan1;
		if(!empty($bahasa1) && !empty($penguasaan1)){
			$rss = $conn->query("SELECT * FROM $schema2.`calon_bakat_bahasa` WHERE `id_pemohon`='{$id_pemohon}' AND `bakat_bahasa`='{$bahasa_u1}' 
				AND `bakat_bahasa_ind`='L'");
			if(!$rss->EOF){
				if($bahasa1!=$bahasa_u1 || $penguasaan1!=$penguasaan_u1){ 
					$strSQL = "UPDATE $schema2.`calon_bakat_bahasa` SET `bakat_bahasa`=".tosql($bahasa1).", `penguasaan`=".tosql($penguasaan1).", 
						`d_kemaskini`=".tosql($date); 
					$strSQL .= " WHERE `id_pemohon`='{$id_pemohon}' AND `bakat_bahasa`='{$bahasa_u1}' AND `penguasaan`='{$penguasaan_u1}' AND `bakat_bahasa_ind`='L'";
					$rss = $conn->execute($strSQL);
				}
				// audit_trail($strSQL, "KEMASKINI");
			} else {
				if(!empty($bahasa1)){ 
				$strSQL = "INSERT INTO $schema2.`calon_bakat_bahasa`(`id_pemohon`, `bakat_bahasa`, `penguasaan`, `bakat_bahasa_ind`, `d_cipta`, `d_kemaskini`) 
					VALUES(".tosql($id_pemohon).", ".tosql($bahasa1).", ".tosql($penguasaan1).", 'L', ".tosql($date).", ".tosql($date).")";
				$rss = $conn->execute($strSQL);
				}
				// audit_trail($strSQL, "TAMBAH");
			}
		}


		$bahasa2=isset($_REQUEST["bahasa2"])?$_REQUEST["bahasa2"]:"";
		$bahasa_u2=isset($_REQUEST["bahasa_u2"])?$_REQUEST["bahasa_u2"]:"";
		$penguasaan2=isset($_REQUEST["penguasaan2"])?$_REQUEST["penguasaan2"]:"";
		$penguasaan_u2=isset($_REQUEST["penguasaan_u2"])?$_REQUEST["penguasaan_u2"]:"";

		if(!empty($bahasa1) && !empty($penguasaan1)){
			$rss = $conn->query("SELECT * FROM $schema2.`calon_bakat_bahasa` WHERE `id_pemohon`='{$id_pemohon}' AND `bakat_bahasa`='{$bahasa_u2}' 
				AND `bakat_bahasa_ind`='L'");
			if(!$rss->EOF){
				if($bahasa2!=$bahasa_u2 || $penguasaan1!=$penguasaan_u2){ 
					$strSQL = "UPDATE $schema2.`calon_bakat_bahasa` SET `bakat_bahasa`=".tosql($bahasa2).", `penguasaan`=".tosql($penguasaan2).", 
						`d_kemaskini`=".tosql($date); 
					$strSQL .= " WHERE `id_pemohon`='{$id_pemohon}' AND `bakat_bahasa`='{$bahasa_u2}' AND `penguasaan`='{$penguasaan_u2}' AND `bakat_bahasa_ind`='L'";
					$rss = $conn->execute($strSQL);
				}
				// audit_trail($strSQL, "KEMASKINI");
			} else {
				if(!empty($bahasa2)){ 
				$strSQL = "INSERT INTO $schema2.`calon_bakat_bahasa`(`id_pemohon`, `bakat_bahasa`, `penguasaan`, `bakat_bahasa_ind`, `d_cipta`, `d_kemaskini`) 
					VALUES(".tosql($id_pemohon).", ".tosql($bahasa2).", ".tosql($penguasaan2).", 'L', ".tosql($date).", ".tosql($date).")";
				$rss = $conn->execute($strSQL);
				}
				// audit_trail($strSQL, "TAMBAH");
			}
		}

		$bahasa3=isset($_REQUEST["bahasa3"])?$_REQUEST["bahasa3"]:"";
		$bahasa_u3=isset($_REQUEST["bahasa_u3"])?$_REQUEST["bahasa_u3"]:"";
		$penguasaan3=isset($_REQUEST["penguasaan3"])?$_REQUEST["penguasaan3"]:"";
		$penguasaan_u3=isset($_REQUEST["penguasaan_u3"])?$_REQUEST["penguasaan_u3"]:"";

		// print "BB:".$bahasa1.":".$penguasaan1;
		if(!empty($bahasa3) && !empty($penguasaan3)){
			$rss = $conn->query("SELECT * FROM $schema2.`calon_bakat_bahasa` WHERE `id_pemohon`='{$id_pemohon}' AND `bakat_bahasa`='{$bahasa_u3}' 
				AND `bakat_bahasa_ind`='L'");
			if(!$rss->EOF){
				if($bahasa3!=$bahasa_u3 || $penguasaan3!=$penguasaan_u3){ 
					$strSQL = "UPDATE $schema2.`calon_bakat_bahasa` SET `bakat_bahasa`=".tosql($bahasa3).", `penguasaan`=".tosql($penguasaan3).", 
						`d_kemaskini`=".tosql($date); 
					$strSQL .= " WHERE `id_pemohon`='{$id_pemohon}' AND `bakat_bahasa`='{$bahasa_u3}' AND `penguasaan`='{$penguasaan_u3}' AND `bakat_bahasa_ind`='L'";
					$rss = $conn->execute($strSQL);
				}
				// audit_trail($strSQL, "KEMASKINI");
			} else {
				if(!empty($bahasa3)){ 
				$strSQL = "INSERT INTO $schema2.`calon_bakat_bahasa`(`id_pemohon`, `bakat_bahasa`, `penguasaan`, `bakat_bahasa_ind`, `d_cipta`, `d_kemaskini`) 
					VALUES(".tosql($id_pemohon).", ".tosql($bahasa3).", ".tosql($penguasaan3).", 'L', ".tosql($date).", ".tosql($date).")";
				$rss = $conn->execute($strSQL);
				}
				// audit_trail($strSQL, "TAMBAH");
			}
		}

		//exit;
		if($rss){
			$err='OK';
		} else {
			$err='ERR'; 
		}
	
	} else if($pro=="DEL_BAKAT"){
	
		$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
		$v1=isset($_REQUEST["v1"])?$_REQUEST["v1"]:"";
		$v2=isset($_REQUEST["v2"])?$_REQUEST["v2"]:"";
		
		$sqld = "DELETE FROM $schema2.`calon_bakat_bahasa` WHERE `id_pemohon`='{$id_pemohon}' AND `bakat_bahasa`='{$v1}' AND `bakat_bahasa_ind`='B'";
		$rss = $conn->execute($sqld);
		// audit_trail($sqld, "HAPUS");

		if($rss){
			$err='OK';
		} else {
			$err='ERR'; 
		}
		
	} else if($pro=="DEL_BAHASA"){
	
		$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
		$v1=isset($_REQUEST["v1"])?$_REQUEST["v1"]:"";
		$v2=isset($_REQUEST["v2"])?$_REQUEST["v2"]:"";
		$v3=isset($_REQUEST["v3"])?$_REQUEST["v3"]:"";
	
		$sqld = "DELETE FROM $schema2.`calon_bakat_bahasa` WHERE `id_pemohon`='{$id_pemohon}' AND `bakat_bahasa`='{$v1}' AND `bakat_bahasa_ind`='L'
			AND `penguasaan`='{$v3}'";
		$rss = $conn->execute($sqld);
		// audit_trail($sqld, "HAPUS");

		if($rss){
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