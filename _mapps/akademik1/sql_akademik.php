<?php
session_start();
@include_once '../../connection/common.php';
$frm=isset($_GET["frm"])?$_GET["frm"]:"";
$pro=isset($_GET["pro"])?$_GET["pro"]:"";
$date=date("Y-m-d H:i:s");
//$oleh=$_SESSION['SESS_UID'];
// $conn->debug=true;
// print $frm.":".$pro; 

function get_pmr($conn, $uid){
	// $conn->debug=true;
	global $schema2;
	$sql = "SELECT id_pemohon, srp_tahun, srp_jenis_sijil, srp_pangkat FROM $schema2.calon WHERE `id_pemohon`=".tosql($uid);
	$rs = $conn->query($sql);
	$data = array();
	
	$data = array('id_pemohon'=> $rs->fields['id_pemohon'], 'srp_tahun'=> $rs->fields['srp_tahun'], 'srp_jenis_sijil'=> $rs->fields['srp_jenis_sijil'], 
	'srp_pangkat'=> $rs->fields['srp_pangkat']); 

	return $data;
}

function get_exam($conn, $uid){
	// $conn->debug=true;
	global $schema2;
	$sql = "SELECT id_pemohon, spm_tahun_1, spm_jenis_sijil_1, spm_pangkat_1, spm_tahun_2, spm_jenis_sijil_2, spm_pangkat_2, spm_lisan_1, 
	stp_tahun_1, stp_jenis_1, stp_pangkat_1, stp_tahun_2, stp_jenis_2, stp_pangkat_2,   
	stam_tahun_1, stam_jenis_1, stam_pangkat_1, stam_tahun_2, stam_jenis_2, stam_pangkat_2    
	FROM $schema2.calon WHERE `id_pemohon`=".tosql($uid);
	$rs = $conn->query($sql);
	$data = array();
	
	$data = array('id_pemohon'=> $rs->fields['id_pemohon'], 'spm_tahun_1'=> $rs->fields['spm_tahun_1'], 
	'spm_jenis_sijil_1'=> $rs->fields['spm_jenis_sijil_1'], 'spm_pangkat_1'=> $rs->fields['spm_pangkat_1'], 'spm_lisan_1'=> $rs->fields['spm_lisan_1'], 
	'spm_tahun_2'=> $rs->fields['spm_tahun_2'], 'spm_jenis_sijil_2'=> $rs->fields['spm_jenis_sijil_2'], 'spm_pangkat_2'=> $rs->fields['spm_pangkat_2'], 

	'stp_tahun_1'=> $rs->fields['stp_tahun_1'], 'stp_jenis_1'=> $rs->fields['stp_jenis_1'], 'stp_pangkat_1'=> $rs->fields['stp_pangkat_1'],
	'stp_tahun_2'=> $rs->fields['stp_tahun_2'], 'stp_jenis_2'=> $rs->fields['stp_jenis_2'], 'stp_pangkat_2'=> $rs->fields['stp_pangkat_2'], 
	'stam_tahun_1'=> $rs->fields['stam_tahun_1'], 'stam_jenis_1'=> $rs->fields['stam_jenis_1'], 'stam_pangkat_1'=> $rs->fields['stam_pangkat_1'],  
	'stam_tahun_2'=> $rs->fields['stam_tahun_2'], 'stam_jenis_2'=> $rs->fields['stam_jenis_2'], 'stam_pangkat_2'=> $rs->fields['stam_pangkat_2']  
	); 

	return $data;
}

function get_pmr_result($conn, $uid, $kod, $tahun){
	// $conn->debug=true;
	global $schema2;
	$sql = "SELECT * FROM $schema2.`calon_srp` WHERE `id_pemohon`=".tosql($uid)." 
		AND `matapelajaran`=".tosql($kod)." AND `tahun`=".tosql($tahun);
	$rs = $conn->query($sql);
	$data = array();
	// $columns[] = $data;
	
	$data = array('id_pemohon'=> $rs->fields['id_pemohon'], 'tahun'=> $rs->fields['tahun'], 'matapelajaran'=> $rs->fields['matapelajaran'], 
	'gred'=> $rs->fields['gred']); 

	return $data;
}

function get_spm_result($conn, $uid, $kod, $tahun, $typs){
	// $conn->debug=true;
	global $schema2;
	$sql = "SELECT * FROM $schema2.`calon_spm` WHERE `id_pemohon`=".tosql($uid)." AND `jenis_xm`='{$typs}' 
		AND `matapelajaran`=".tosql($kod)." AND `tahun`=".tosql($tahun);
	$rs = $conn->query($sql);
	$data = array();
	// $columns[] = $data;
	
	$data = array('id_pemohon'=> $rs->fields['id_pemohon'], 'tahun'=> $rs->fields['tahun'], 'matapelajaran'=> $rs->fields['matapelajaran'], 
	'gred'=> $rs->fields['gred']); 

	return $data;
}

function get_stp_result($conn, $uid, $kod, $tahun, $typs){
	// $conn->debug=true;
	global $schema2;
	$sql = "SELECT * FROM $schema2.`calon_stp_stam` WHERE `id_pemohon`=".tosql($uid)." AND `jenis_xm`='{$typs}' 
		AND `matapelajaran`=".tosql($kod)." AND `tahun`=".tosql($tahun);
	$rs = $conn->query($sql);
	$data = array();
	// $columns[] = $data;
	
	$data = array('id_pemohon'=> $rs->fields['id_pemohon'], 'tahun'=> $rs->fields['tahun'], 'matapelajaran'=> $rs->fields['matapelajaran'], 
	'gred'=> $rs->fields['gred']); 

	return $data;
}

if($frm=='SRP'){
	// $conn->debug=true;
	if($pro=='UPDATE'){
		$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
		$fields=isset($_REQUEST["fields"])?$_REQUEST["fields"]:"";
		$vals=isset($_REQUEST["vals"])?$_REQUEST["vals"]:"";
		$ty=isset($_REQUEST["ty"])?$_REQUEST["ty"]:"";

		if(!empty($id_pemohon)){
			$sqlu = "UPDATE $schema2.`calon` SET $fields=".tosql($vals);
			if($ty=='R'){ $sqlu .= ", srp_jenis_sijil=NULL, srp_pangkat=NULL "; } 
			$sqlu .= " WHERE `id_pemohon`=".tosql($id_pemohon);
			$rss = $conn->execute($sqlu);
		}

		if($rss){
			$err='OK';
			if($ty=='R'){ 
				$rs = $conn->query("SELECT * FROM $schema2.`calon_srp` WHERE `id_pemohon`=".tosql($id_pemohon));
				if(!$rs->EOF){
					$conn->execute("UPDATE $schema2.`calon_srp` SET `tahun`=".tosql($vals)." WHERE `id_pemohon`=".tosql($id_pemohon));
				}
			}
		} else {
			$err='ERR'; 
		}

	} else if($pro=='SAVE'){
		$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
		$srp_tahun=isset($_REQUEST["srp_tahun"])?$_REQUEST["srp_tahun"]:"";
		$mp=isset($_REQUEST["mp"])?$_REQUEST["mp"]:"";
		$gred=isset($_REQUEST["gred"])?$_REQUEST["gred"]:"";
		$jsijil=1;

		// print_r($mp); exit;
		// $subj = "'002'";
		for($i=0;$i<=11;$i++){
			if($i==0){
				if(!empty($mp[$i])){ $subj .= "'$mp[$i]'"; }
			} else {
				if(!empty($mp[$i])){ $subj .= ",'$mp[$i]'"; }
			}
			$dt = date("Y-m-d H:i:s");
			if(!empty($mp[$i]) && !empty($gred[$i])){
				$rs = $conn->query("SELECT * FROM $schema2.`calon_srp` WHERE `id_pemohon`=".tosql($id_pemohon)." AND `tahun`=".tosql($srp_tahun)." 
					AND `matapelajaran`=".tosql($mp[$i]));
				if($rs->EOF){
					$sql = "INSERT INTO $schema2.`calon_srp`(`id_pemohon`, `tahun`, `matapelajaran`, `jenis_sijil`, `gred`, `d_cipta`)";
					$sql .= " VALUES(".tosql($id_pemohon).",".tosql($srp_tahun).",".tosql($mp[$i]).",".tosql($jsijil).",".tosql($gred[$i]).",".tosql($dt).")";
				} else {
					$sql = "UPDATE $schema2.`calon_srp` SET `gred`=".tosql($gred[$i]).", d_kemaskini=".tosql($dt)." WHERE `id_pemohon`=".tosql($id_pemohon)." 
						AND `tahun`=".tosql($srp_tahun)." AND `matapelajaran`=".tosql($mp[$i]);
				}
				$conn->execute($sql);
			}
			$err='OK';
		}

		// print $subj;
		$rsd = $conn->query("SELECT * FROM $schema2.`calon_srp` WHERE `id_pemohon`=".tosql($id_pemohon)." AND `tahun`=".tosql($srp_tahun)." 
			AND `matapelajaran` NOT IN(".$subj.")");
		while(!$rsd->EOF){
			// print $rsd->fields['matapelajaran'];
			$conn->execute("DELETE FROM $schema2.`calon_srp` WHERE `id_pemohon`=".tosql($id_pemohon)." AND `tahun`=".tosql($srp_tahun)." 
			AND `matapelajaran`=".tosql($rsd->fields['matapelajaran']));
			$rsd->movenext();
		}

		// print "UPL:".$_FILES['file_pmr']['name'];
		//$sijil_pmr=isset($_REQUEST["sijil_pmr"])?$_REQUEST["sijil_pmr"]:"";
		if(!empty($_FILES['file_pmr']['name'])){ 
			//$conn->debug=true;
			$type='PMR';
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif','pdf'); // valid extensions
	        $path = '../../uploads_doc/'.$id_pemohon.'/'; // upload directory
	        if (file_exists($path)) {
	            $path = $path;
	        } else {
	            mkdir($path);
	            $path = '../../uploads_doc/'.$id_pemohon.'/';
	        }

	        $img = $_FILES['file_pmr']['name'];
	        $tmp = $_FILES['file_pmr']['tmp_name'];
	        
	        $ext = end((explode(".", $img))); 
	        // $fname = $img; //$id.".".$ext;
	        // $fname = str_replace(" ", "_", $fname);
	        // $fname = str_replace("-", "_", $fname);

	        // $final_image = "docSenaraiSemak_D3_1_".$appli_id2."_".$item_id.".".$ext;
	        // $final_image = rand(1000,1000000)."_".$fname;
	        $final_image = strtolower($id_pemohon."_".$type.".".$ext);
	        $sijil_size = $_FILES['sijil_pmr']['size'];
	        $sijil_type = $_FILES['sijil_pmr']['type'];
			// check's valid format
			// $conn->debug=true;
			if(in_array($ext, $valid_extensions)){ 
				$path = $path.strtolower($final_image); 
				// print "n:".$path.'>'.$tmp; exit();
				move_uploaded_file($tmp,$path);
				// $err = $path;
				$dt = date("Y-m-d H:i:s");
				$upd_main='';
				$sqlu = "INSERT INTO $schema2.`calon_sijil`(`id_pemohon`, `jenis_sijil`, `sijil_nama`, `sijil_size`, `sijil_type`, `dt_create`) 
				VALUES('{$id_pemohon}', '{$type}', '{$final_image}', '{$sijil_size}', '{$sijil_type}', '{$dt}')";
			    
				$rsn = $conn->execute($sqlu);		
				if($rsn){ 	
				    $err='OK';
				} else { 
					$err = 'ERR'; 
				}
			} else {
				$err = "XEX";
			}
		}
	}

} else if($frm=='SPM'){

	// $conn->debug=true;

	if($pro=='UPDATE'){
		$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
		$fields=isset($_REQUEST["fields"])?$_REQUEST["fields"]:"";
		$vals=isset($_REQUEST["vals"])?$_REQUEST["vals"]:"";
		$ty=isset($_REQUEST["ty"])?$_REQUEST["ty"]:"";

		if(!empty($id_pemohon)){

			$sqlu = "UPDATE $schema2.`calon` SET $fields=".tosql($vals);
			if($ty=='R' && $fields=='spm_tahun_1'){ $sqlu .= ", spm_jenis_sijil_1=NULL, spm_pangkat_1=NULL, spm_lisan_1=NULL "; } 
			else if($ty=='R' && $fields=='spm_tahun_2'){ $sqlu .= ", spm_jenis_sijil_2=NULL, spm_pangkat_2=NULL "; } 
			$sqlu .= " WHERE `id_pemohon`=".tosql($id_pemohon);
			$rss = $conn->execute($sqlu);

		}

		if($rss){
			$err='OK';
			if($ty=='R' && $fields=='spm_tahun_1'){ 
				$rs = $conn->query("SELECT * FROM $schema2.`calon_spm` WHERE `jenis_xm`='1' AND `id_pemohon`=".tosql($id_pemohon));
				if(!$rs->EOF){
					$conn->execute("UPDATE $schema2.`calon_spm` SET `tahun`=".tosql($vals)." WHERE `jenis_xm`='1' AND `id_pemohon`=".tosql($id_pemohon));
				}
			} else if($ty=='R' && $fields=='spm_tahun_2'){ 
				$rs = $conn->query("SELECT * FROM $schema2.`calon_spm` WHERE `jenis_xm`='T' AND `id_pemohon`=".tosql($id_pemohon));
				if(!$rs->EOF){
					$conn->execute("UPDATE $schema2.`calon_spm` SET `tahun`=".tosql($vals)." WHERE `jenis_xm`='T' AND `id_pemohon`=".tosql($id_pemohon));
				}
			}
		} else {
			$err='ERR'; 
		}

	} else if($pro=='ADD'){

		$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
		$tahun_add=isset($_REQUEST["tahun_add"])?$_REQUEST["tahun_add"]:"";

		$rss = $conn->execute("UPDATE $schema2.`calon` SET `spm_tahun_2`=".tosql($tahun_add)." WHERE `id_pemohon`=".tosql($id_pemohon));

		if($rss){
			$err='OK;index.php?data='.base64_encode('akademik/spm;MAKLUMAT AKADEMIK;Maklumat SPM/MCE/SPVM/SPM(V);;2;;');
		} else {
			$err='ERR';
		}

	} else if($pro=='SPM2_DEL'){

		$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";

		$rss = $conn->execute("UPDATE $schema2.`calon` SET `spm_tahun_2`=NULL, `spm_jenis_sijil_2`=NULL, `spm_pangkat_2`=NULL 
			WHERE `id_pemohon`=".tosql($id_pemohon));

		if($rss){
			// $err='OK';
			$rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='SPM2' AND `id_pemohon`=".tosql($id_pemohon));
			if(!$rsSijil->EOF){
		        $files = '../../uploads_doc/'.$id_pemohon.'/'.$rsSijil->fields['sijil_nama']; // upload directory
				$conn->execute("DELETE FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='SPM2' AND `id_pemohon`=".tosql($id_pemohon));
				unlink($files);
			}
			$err='OK;index.php?data='.base64_encode('akademik/spm;MAKLUMAT AKADEMIK;Maklumat SPM/MCE/SPVM/SPM(V);;1;;');
			$sqld = "DELETE FROM $schema2.`calon_spm` WHERE `jenis_xm`='T' AND `id_pemohon`=".tosql($id_pemohon);
			$conn->execute($sqld);
		} else {
			$err='ERR';
		}

	} else if($pro=='SAVE'){
		// $conn->debug=true;
		$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
		$spm_tahun_1=isset($_REQUEST["spm_tahun_1"])?$_REQUEST["spm_tahun_1"]:"";
		$spm_tahun_2=isset($_REQUEST["spm_tahun_2"])?$_REQUEST["spm_tahun_2"]:"";
		$mp=isset($_REQUEST["mp_1"])?$_REQUEST["mp_1"]:"";
		$gred=isset($_REQUEST["gred_1"])?$_REQUEST["gred_1"]:"";
		$mp_2=isset($_REQUEST["mp_2"])?$_REQUEST["mp_2"]:"";
		$gred_2=isset($_REQUEST["gred_2"])?$_REQUEST["gred_2"]:"";


		$jsijil=1;

		// $sql = "SELECT id_pemohon, spm_tahun_1, spm_jenis_sijil_1, spm_pangkat_1, spm_tahun_2, spm_jenis_sijil_2, spm_pangkat_2, spm_lisan_1, 
		// stp_tahun_1, stp_jenis_1, stp_pangkat_1, stp_tahun_2, stp_jenis_2, stp_pangkat_2,   
		// stam_tahun_1, stam_jenis_1, stam_pangkat_1, stam_tahun_2, stam_jenis_2, stam_pangkat_2    
		// FROM $schema2.calon WHERE `id_pemohon`=".tosql($uid);		

		// print $spm_tahun_1.":".$spm_tahun_2;
		if(!empty($spm_tahun_1)){ 
			$spm_jenis_sijil_1=isset($_REQUEST["spm_jenis_sijil_1"])?$_REQUEST["spm_jenis_sijil_1"]:"";
			$spm_pangkat_1=isset($_REQUEST["spm_pangkat_1"])?$_REQUEST["spm_pangkat_1"]:"";
			$sql = "UPDATE $schema2.calon  SET spm_tahun_1='{$spm_tahun_1}', spm_jenis_sijil_2='{$spm_jenis_sijil_1}', spm_pangkat_1='{$spm_pangkat_1}' WHERE  `id_pemohon`=".tosql($id_pemohon);
		} else {
			$spm_jenis_sijil_2=isset($_REQUEST["spm_jenis_sijil_2"])?$_REQUEST["spm_jenis_sijil_2"]:"";
			$spm_pangkat_2=isset($_REQUEST["spm_pangkat_2"])?$_REQUEST["spm_pangkat_2"]:"";
			$sql = "UPDATE $schema2.calon  SET spm_tahun_2='{$spm_tahun_2}', spm_jenis_sijil_2='{$spm_jenis_sijil_2}', spm_pangkat_2='{$spm_pangkat_2}' WHERE  `id_pemohon`=".tosql($id_pemohon);
		}
		// print $sql;
		if(!empty($sql)){ $conn->execute($sql); }

		// print_r($mp);
		// $subj = "'002'";
		if(!empty($spm_tahun_1)){ 
			//$conn->debug=true;
			$type='SPM1';
			for($i=0;$i<=11;$i++){
				if($i==0){ 
					if(!empty($mp[$i])){ $subj .= "'$mp[$i]'"; }
				} else {
					if(!empty($mp[$i])){ $subj .= ",'$mp[$i]'"; }
				}
				$dt = date("Y-m-d H:i:s");
				if(!empty($mp[$i]) && !empty($gred[$i])){
					$rs = $conn->query("SELECT * FROM $schema2.`calon_spm` WHERE `jenis_xm`='1' AND `id_pemohon`=".tosql($id_pemohon)." AND `tahun`=".tosql($spm_tahun_1)." AND `matapelajaran`=".tosql($mp[$i]));
					if($rs->EOF){
						$sql = "INSERT INTO $schema2.`calon_spm`(`id_pemohon`, `tahun`, `matapelajaran`, `jenis_sijil`, `gred`, `d_cipta`, `jenis_xm`)";
						$sql .= " VALUES(".tosql($id_pemohon).",".tosql($spm_tahun_1).",".tosql($mp[$i]).",".tosql($jsijil).",".tosql($gred[$i]).",".tosql($dt).", '1')";
					} else {
						$sql = "UPDATE $schema2.`calon_spm` SET `gred`=".tosql($gred[$i]).", d_kemaskini=".tosql($dt)." WHERE `jenis_xm`='1' AND `id_pemohon`=".tosql($id_pemohon)." AND `tahun`=".tosql($spm_tahun_1)." AND `matapelajaran`=".tosql($mp[$i]);
					}
					$conn->execute($sql);
				}
				$err='OK';
			}

			// print $subj;
			$rsd = $conn->query("SELECT * FROM $schema2.`calon_spm` WHERE `jenis_xm`='1' AND `id_pemohon`=".tosql($id_pemohon)." 
				AND `tahun`=".tosql($spm_tahun_1)." AND `matapelajaran` NOT IN(".$subj.")");
			while(!$rsd->EOF){
				// print $rsd->fields['matapelajaran'];
				$conn->execute("DELETE FROM $schema2.`calon_spm` WHERE `jenis_xm`='1' AND `id_pemohon`=".tosql($id_pemohon)." 
					AND `tahun`=".tosql($spm_tahun_1)." AND `matapelajaran`=".tosql($rsd->fields['matapelajaran']));
				$rsd->movenext();
			}
		}

		// $subj = "'002'";
		if(!empty($spm_tahun_2)){ 
			// $conn->debug=true;
			// print "GRED:".$gred_2[0];
			$type='SPM2';
			for($i=0;$i<=11;$i++){
				if($i==0){ 
					if(!empty($mp_2[$i])){ $subj .= "'$mp_2[$i]'"; }
				} else {
					if(!empty($mp_2[$i])){ $subj .= ",'$mp_2[$i]'"; }
				}
				$dt = date("Y-m-d H:i:s");
				if(!empty($mp_2[$i]) && !empty($gred_2[$i])){
					$rs = $conn->query("SELECT * FROM $schema2.`calon_spm` WHERE `jenis_xm`='T' AND `id_pemohon`=".tosql($id_pemohon)." AND `tahun`=".tosql($spm_tahun_2)." AND `matapelajaran`=".tosql($mp_2[$i]));
					if($rs->EOF){
						$sql = "INSERT INTO $schema2.`calon_spm`(`id_pemohon`, `tahun`, `matapelajaran`, `jenis_sijil`, `gred`, `d_cipta`, `jenis_xm`)";
						$sql .= " VALUES(".tosql($id_pemohon).",".tosql($spm_tahun_2).",".tosql($mp_2[$i]).",".tosql($jsijil).",".tosql($gred_2[$i]).",".tosql($dt).", 'T')";
					} else {
						$sql = "UPDATE $schema2.`calon_spm` SET `gred`=".tosql($gred_2[$i]).", d_kemaskini=".tosql($dt)." WHERE `jenis_xm`='T' AND `id_pemohon`=".tosql($id_pemohon)." AND `tahun`=".tosql($spm_tahun_2)." AND `matapelajaran`=".tosql($mp_2[$i]);
					}
					$conn->execute($sql);
				}
				$err='OK';
			}

			// print $subj;
			$rsd = $conn->query("SELECT * FROM $schema2.`calon_spm` WHERE `jenis_xm`='T' AND `id_pemohon`=".tosql($id_pemohon)." 
				AND `tahun`=".tosql($spm_tahun_2)." AND `matapelajaran` NOT IN(".$subj.")");
			while(!$rsd->EOF){
				// print $rsd->fields['matapelajaran'];
				$conn->execute("DELETE FROM $schema2.`calon_spm` WHERE `jenis_xm`='T' AND `id_pemohon`=".tosql($id_pemohon)." 
					AND `tahun`=".tosql($spm_tahun_2)." AND `matapelajaran`=".tosql($rsd->fields['matapelajaran']));
				$rsd->movenext();
			}
		}


		// print "UPL:".$_FILES['file_pmr']['name'];
		//$sijil_pmr=isset($_REQUEST["sijil_pmr"])?$_REQUEST["sijil_pmr"]:"";
		if(!empty($_FILES['file_pmr']['name'])){ 
			// $conn->debug=true;
			// $type='PMR';
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif','pdf'); // valid extensions
	        $path = '../../uploads_doc/'.$id_pemohon.'/'; // upload directory
	        if (file_exists($path)) {
	            $path = $path;
	        } else {
	            mkdir($path);
	            $path = '../../uploads_doc/'.$id_pemohon.'/';
	        }

	        $img = $_FILES['file_pmr']['name'];
	        $tmp = $_FILES['file_pmr']['tmp_name'];
	        
	        $ext = end((explode(".", $img))); 
	        // $fname = $img; //$id.".".$ext;
	        // $fname = str_replace(" ", "_", $fname);
	        // $fname = str_replace("-", "_", $fname);

	        // $final_image = "docSenaraiSemak_D3_1_".$appli_id2."_".$item_id.".".$ext;
	        // $final_image = rand(1000,1000000)."_".$fname;
	        $final_image = strtolower($id_pemohon."_".$type.".".$ext);
	        $sijil_size = $_FILES['sijil_pmr']['size'];
	        $sijil_type = $_FILES['sijil_pmr']['type'];
			// check's valid format
			// $conn->debug=true;
			if(in_array($ext, $valid_extensions)){ 
				$path = $path.strtolower($final_image); 
				// print "n:".$path.'>'.$tmp; exit();
				move_uploaded_file($tmp,$path);
				// $err = $path;
				$dt = date("Y-m-d H:i:s");
				$upd_main='';
				// $rs = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `id_pemohon`='{$id_pemohon}' AND `jenis_sijil`='{$type}'");
				// $if(!$rs->EOF){
				// 	$sql = "UPDATE $schema2.`calon_sijil` SET `sijil_nama`='{$final_image}' WHERE `id_pemohon`='{$id_pemohon}' AND `jenis_sijil`='{$type}'";
				// } else { 
					$sqlu = "INSERT INTO $schema2.`calon_sijil`(`id_pemohon`, `jenis_sijil`, `sijil_nama`, `sijil_size`, `sijil_type`, `dt_create`) 
					VALUES('{$id_pemohon}', '{$type}', '{$final_image}', '{$sijil_size}', '{$sijil_type}', '{$dt}')";
			    // }
				$rsn = $conn->execute($sqlu);		
				if($rsn){ 	
				    $err='OK';
				} else { 
					$err = 'ERR'; 
				}
			} else {
				$err = "XEX";
			}
		}
	}

} else if($frm=='STPM'){

	if($pro=='UPDATE'){
		// $conn->debug=true;
		$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
		$fields=isset($_REQUEST["fields"])?$_REQUEST["fields"]:"";
		$vals=isset($_REQUEST["vals"])?$_REQUEST["vals"]:"";
		$ty=isset($_REQUEST["ty"])?$_REQUEST["ty"]:"";

		if(!empty($id_pemohon)){

			$sqlu = "UPDATE $schema2.`calon` SET $fields=".tosql($vals);
			if($ty=='R' && $fields=='stp_tahun_1'){ $sqlu .= ", stp_jenis_1=NULL "; } 
			else if($ty=='R' && $fields=='stp_tahun_2'){ $sqlu .= ", stp_jenis_2=NULL "; } 
			$sqlu .= " WHERE `id_pemohon`=".tosql($id_pemohon);
			$rss = $conn->execute($sqlu);

		}

		if($rss){
			$err='OK';
			if($ty=='R' && $fields=='stp_tahun_1'){ 
				$rs = $conn->query("SELECT * FROM $schema2.`calon_stp_stam` WHERE `jenis_xm`='B' AND `id_pemohon`=".tosql($id_pemohon));
				if(!$rs->EOF){
					$conn->execute("UPDATE $schema2.`calon_stp_stam` SET `tahun`=".tosql($vals)." WHERE `jenis_xm`='B' AND `id_pemohon`=".tosql($id_pemohon));
				}
			} else if($ty=='R' && $fields=='stp_tahun_2'){ 
				$rs = $conn->query("SELECT * FROM $schema2.`calon_stp_stam` WHERE `jenis_xm`='BT' AND `id_pemohon`=".tosql($id_pemohon));
				if(!$rs->EOF){
					$conn->execute("UPDATE $schema2.`calon_stp_stam` SET `tahun`=".tosql($vals)." WHERE `jenis_xm`='BT' AND `id_pemohon`=".tosql($id_pemohon));
				}
			}
		} else {
			$err='ERR'; 
		}

	} else if($pro=='ADD'){

		$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
		$tahun_add=isset($_REQUEST["tahun_add"])?$_REQUEST["tahun_add"]:"";

		$rss = $conn->execute("UPDATE $schema2.`calon` SET `stp_tahun_2`=".tosql($tahun_add)." WHERE `id_pemohon`=".tosql($id_pemohon));

		if($rss){
			// $err='OK';
			$err='OK;index.php?data='.base64_encode('akademik/stpm;MAKLUMAT AKADEMIK;Maklumat STPM/STP/HSC;;2;;');
		} else {
			$err='ERR';
		}

	} else if($pro=='STPM2_DEL'){
		// $conn->debug=true;
		$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";

		$rss = $conn->execute("UPDATE $schema2.`calon` SET `stp_tahun_2`=NULL, `stp_jenis_2`=NULL, `stp_pangkat_2`=NULL 
			WHERE `id_pemohon`=".tosql($id_pemohon));

		if($rss){
			// $err='OK';
			$rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='STPM2' AND `id_pemohon`=".tosql($id_pemohon));
			if(!$rsSijil->EOF){
		        $files = '../../uploads_doc/'.$id_pemohon.'/'.$rsSijil->fields['sijil_nama']; // upload directory
				$conn->execute("DELETE FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='STPM2' AND `id_pemohon`=".tosql($id_pemohon));
				unlink($files);
			}
			$err='OK;index.php?data='.base64_encode('akademik/stpm;MAKLUMAT AKADEMIK;Maklumat STPM/STP/HSC;;1;;');
			$sqld = "DELETE FROM $schema2.`calon_stp_stam` WHERE `jenis_xm`='BT' AND `id_pemohon`=".tosql($id_pemohon);
			$conn->execute($sqld);
		} else {
			$err='ERR';
		}
		// exit;

	} else if($pro=='SAVE'){

		$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
		$stp_tahun_1=isset($_REQUEST["stp_tahun_1"])?$_REQUEST["stp_tahun_1"]:"";
		$stp_tahun_2=isset($_REQUEST["stp_tahun_2"])?$_REQUEST["stp_tahun_2"]:"";
		$mp=isset($_REQUEST["mp_1"])?$_REQUEST["mp_1"]:"";
		$gred=isset($_REQUEST["gred_1"])?$_REQUEST["gred_1"]:"";
		$mp_2=isset($_REQUEST["mp_2"])?$_REQUEST["mp_2"]:"";
		$gred_2=isset($_REQUEST["gred_2"])?$_REQUEST["gred_2"]:"";
		$jsijil=1;

		//print_r($mp);
		// $subj = "'002'";
		if(!empty($stp_tahun_1)){
			$type='STPM1'; 
			// $conn->debug=true;
			for($i=0;$i<=10;$i++){
				if($i==0){ 
					if(!empty($mp[$i])){ $subj .= "'$mp[$i]'"; }
				} else {
					if(!empty($mp[$i])){ $subj .= ",'$mp[$i]'"; }
				}
				// if(!empty($mp[$i])){ $subj .= ",'$mp[$i]'"; }
				$dt = date("Y-m-d H:i:s");
				if(!empty($mp[$i]) && !empty($gred[$i])){
					$rs = $conn->query("SELECT * FROM $schema2.`calon_stp_stam` WHERE `jenis_xm`='B' AND `id_pemohon`=".tosql($id_pemohon)." AND `tahun`=".tosql($stp_tahun_1)." AND `matapelajaran`=".tosql($mp[$i]));
					if($rs->EOF){
						$sql = "INSERT INTO $schema2.`calon_stp_stam`(`id_pemohon`, `tahun`, `matapelajaran`, `jenis_sijil`, `gred`, `d_cipta`, `jenis_xm`)";
						$sql .= " VALUES(".tosql($id_pemohon).",".tosql($stp_tahun_1).",".tosql($mp[$i]).",".tosql($jsijil).",".tosql($gred[$i]).",".tosql($dt).", 'B')";
					} else {
						$sql = "UPDATE $schema2.`calon_stp_stam` SET `gred`=".tosql($gred[$i]).", d_kemaskini=".tosql($dt)." WHERE `jenis_xm`='B' AND `id_pemohon`=".tosql($id_pemohon)." AND `tahun`=".tosql($stp_tahun_1)." AND `matapelajaran`=".tosql($mp[$i]);
					}
					$conn->execute($sql);
				}
				$err='OK';
			}

			// print $subj;
			$rsd = $conn->query("SELECT * FROM $schema2.`calon_stp_stam` WHERE `jenis_xm`='B' AND `id_pemohon`=".tosql($id_pemohon)." 
				AND `tahun`=".tosql($stp_tahun_1)." AND `matapelajaran` NOT IN(".$subj.")");
			while(!$rsd->EOF){
				// print $rsd->fields['matapelajaran'];
				$conn->execute("DELETE FROM $schema2.`calon_stp_stam` WHERE `jenis_xm`='B' AND `id_pemohon`=".tosql($id_pemohon)." 
					AND `tahun`=".tosql($stp_tahun_1)." AND `matapelajaran`=".tosql($rsd->fields['matapelajaran']));
				$rsd->movenext();
			}
		}

		// $subj = "'002'";
		if(!empty($stp_tahun_2)){ 
			// $conn->debug=true;
			$type='STPM2';
			for($i=0;$i<=10;$i++){
				if($i==0){ 
					if(!empty($mp_2[$i])){ $subj .= "'$mp_2[$i]'"; }
				} else {
					if(!empty($mp_2[$i])){ $subj .= ",'$mp_2[$i]'"; }
				}
				// if(!empty($mp_2[$i])){ $subj .= ",'$mp_2[$i]'"; }
				$dt = date("Y-m-d H:i:s");
				if(!empty($mp_2[$i]) && !empty($gred_2[$i])){
					$rs = $conn->query("SELECT * FROM $schema2.`calon_stp_stam` WHERE `jenis_xm`='BT' AND `id_pemohon`=".tosql($id_pemohon)." AND `tahun`=".tosql($stp_tahun_2)." AND `matapelajaran`=".tosql($mp_2[$i]));
					if($rs->EOF){
						$sql = "INSERT INTO $schema2.`calon_stp_stam`(`id_pemohon`, `tahun`, `matapelajaran`, `jenis_sijil`, `gred`, `d_cipta`, `jenis_xm`)";
						$sql .= " VALUES(".tosql($id_pemohon).",".tosql($stp_tahun_2).",".tosql($mp_2[$i]).",".tosql($jsijil).",".tosql($gred_2[$i]).",".tosql($dt).", 'BT')";
					} else {
						$sql = "UPDATE $schema2.`calon_stp_stam` SET `gred`=".tosql($gred_2[$i]).", d_kemaskini=".tosql($dt)." WHERE `jenis_xm`='BT' AND `id_pemohon`=".tosql($id_pemohon)." AND `tahun`=".tosql($stp_tahun_2)." AND `matapelajaran`=".tosql($mp_2[$i]);
					}
					$conn->execute($sql);
				}
				$err='OK';
			}

			// print $subj;
			$rsd = $conn->query("SELECT * FROM $schema2.`calon_stp_stam` WHERE `jenis_xm`='BT' AND `id_pemohon`=".tosql($id_pemohon)." 
				AND `tahun`=".tosql($stp_tahun_2)." AND `matapelajaran` NOT IN(".$subj.")");
			while(!$rsd->EOF){
				// print $rsd->fields['matapelajaran'];
				$conn->execute("DELETE FROM $schema2.`calon_stp_stam` WHERE `jenis_xm`='BT' AND `id_pemohon`=".tosql($id_pemohon)." 
					AND `tahun`=".tosql($stp_tahun_2)." AND `matapelajaran`=".tosql($rsd->fields['matapelajaran']));
				$rsd->movenext();
			}
		}


		// print "UPL:".$_FILES['file_pmr']['name'];
		//$sijil_pmr=isset($_REQUEST["sijil_pmr"])?$_REQUEST["sijil_pmr"]:"";
		if(!empty($_FILES['file_pmr']['name'])){ 
			// $conn->debug=true;
			// $type='PMR';
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif','pdf'); // valid extensions
	        $path = '../../uploads_doc/'.$id_pemohon.'/'; // upload directory
	        if (file_exists($path)) {
	            $path = $path;
	        } else {
	            mkdir($path);
	            $path = '../../uploads_doc/'.$id_pemohon.'/';
	        }

	        $img = $_FILES['file_pmr']['name'];
	        $tmp = $_FILES['file_pmr']['tmp_name'];
	        
	        $ext = end((explode(".", $img))); 
	        // $fname = $img; //$id.".".$ext;
	        // $fname = str_replace(" ", "_", $fname);
	        // $fname = str_replace("-", "_", $fname);

	        // $final_image = "docSenaraiSemak_D3_1_".$appli_id2."_".$item_id.".".$ext;
	        // $final_image = rand(1000,1000000)."_".$fname;
	        $final_image = strtolower($id_pemohon."_".$type.".".$ext);
	        $sijil_size = $_FILES['sijil_pmr']['size'];
	        $sijil_type = $_FILES['sijil_pmr']['type'];
			// check's valid format
			// $conn->debug=true;
			if(in_array($ext, $valid_extensions)){ 
				$path = $path.strtolower($final_image); 
				// print "n:".$path.'>'.$tmp; exit();
				move_uploaded_file($tmp,$path);
				// $err = $path;
				$dt = date("Y-m-d H:i:s");
				$upd_main='';
				$sqlu = "INSERT INTO $schema2.`calon_sijil`(`id_pemohon`, `jenis_sijil`, `sijil_nama`, `sijil_size`, `sijil_type`, `dt_create`) 
				VALUES('{$id_pemohon}', '{$type}', '{$final_image}', '{$sijil_size}', '{$sijil_type}', '{$dt}')";
			    
				$rsn = $conn->execute($sqlu);		
				if($rsn){ 	
				    $err='OK';
				} else { 
					$err = 'ERR'; 
				}
			} else {
				$err = "XEX";
			}
		}
	}

} else if($frm=='STAM'){

	if($pro=='UPDATE'){
		// $conn->debug=true;
		$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
		$fields=isset($_REQUEST["fields"])?$_REQUEST["fields"]:"";
		$vals=isset($_REQUEST["vals"])?$_REQUEST["vals"]:"";
		$ty=isset($_REQUEST["ty"])?$_REQUEST["ty"]:"";

		if(!empty($id_pemohon)){

			$sqlu = "UPDATE $schema2.`calon` SET $fields=".tosql($vals);
			if($ty=='R' && $fields=='stam_tahun_1'){ $sqlu .= ", stam_jenis_1=NULL, stam_pangkat_1=NULL "; } 
			else if($ty=='R' && $fields=='stam_tahun_2'){ $sqlu .= ", stam_jenis_2=NULL, stam_pangkat_2=NULL  "; } 
			$sqlu .= " WHERE `id_pemohon`=".tosql($id_pemohon);
			$rss = $conn->execute($sqlu);

		}

		if($rss){
			$err='OK';
			if($ty=='R' && $fields=='stam_tahun_1'){ 
				$rs = $conn->query("SELECT * FROM $schema2.`calon_stp_stam` WHERE `jenis_xm`='A' AND `id_pemohon`=".tosql($id_pemohon));
				if(!$rs->EOF){
					$conn->execute("UPDATE $schema2.`calon_stp_stam` SET `tahun`=".tosql($vals)." WHERE `jenis_xm`='A' AND `id_pemohon`=".tosql($id_pemohon));
				}
			} else if($ty=='R' && $fields=='stp_tahun_2'){ 
				$rs = $conn->query("SELECT * FROM $schema2.`calon_stp_stam` WHERE `jenis_xm`='AT' AND `id_pemohon`=".tosql($id_pemohon));
				if(!$rs->EOF){
					$conn->execute("UPDATE $schema2.`calon_stp_stam` SET `tahun`=".tosql($vals)." WHERE `jenis_xm`='AT' AND `id_pemohon`=".tosql($id_pemohon));
				}
			}
		} else {
			$err='ERR'; 
		}

	} else if($pro=='ADD'){

		$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
		$tahun_add=isset($_REQUEST["tahun_add"])?$_REQUEST["tahun_add"]:"";

		$rss = $conn->execute("UPDATE $schema2.`calon` SET `stam_tahun_2`=".tosql($tahun_add)." WHERE `id_pemohon`=".tosql($id_pemohon));

		if($rss){
			// $err='OK';
			$err='OK;index.php?data='.base64_encode('akademik/stam;MAKLUMAT AKADEMIK;Maklumat STAM;;2;;');
		} else {
			$err='ERR';
		}

	} else if($pro=='STAM2_DEL'){

		$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";

		$rss = $conn->execute("UPDATE $schema2.`calon` SET `stam_tahun_2`=NULL, `stam_jenis_2`=NULL, `stam_pangkat_2`=NULL 
			WHERE `id_pemohon`=".tosql($id_pemohon));
		if($rss){
			// $err='OK';
			$rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='STAM2' AND `id_pemohon`=".tosql($id_pemohon));
			if(!$rsSijil->EOF){
		        $files = '../../uploads_doc/'.$id_pemohon.'/'.$rsSijil->fields['sijil_nama']; // upload directory
				$conn->execute("DELETE FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='STAM2' AND `id_pemohon`=".tosql($id_pemohon));
				unlink($files);
			}
			$err='OK;index.php?data='.base64_encode('akademik/stam;MAKLUMAT AKADEMIK;Maklumat STAM;;1;;');
			$sqld = "DELETE FROM $schema2.`calon_stp_stam` WHERE `jenis_xm`='AT' AND `id_pemohon`=".tosql($id_pemohon);
			$conn->execute($sqld);
		} else {
			$err='ERR';
		}

	} else if($pro=='SAVE'){
		//$conn->debug=true;
		$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
		$stam_tahun_1=isset($_REQUEST["stam_tahun_1"])?$_REQUEST["stam_tahun_1"]:"";
		$stam_tahun_2=isset($_REQUEST["stam_tahun_2"])?$_REQUEST["stam_tahun_2"]:"";
		$mp=isset($_REQUEST["mp_1"])?$_REQUEST["mp_1"]:"";
		$gred=isset($_REQUEST["gred_1"])?$_REQUEST["gred_1"]:"";
		$mp_2=isset($_REQUEST["mp_2"])?$_REQUEST["mp_2"]:"";
		$gred_2=isset($_REQUEST["gred_2"])?$_REQUEST["gred_2"]:"";
		$jsijil=1;

		// print_r($mp);
		// $subj = "'002'";
		if(!empty($stam_tahun_1)){ 
			// $conn->debug=true;
			$type='STAM1';
			$subj='';
			for($i=0;$i<=10;$i++){
				if($i==0){ 
					if(!empty($mp[$i])){ $subj .= "'$mp[$i]'"; }
				} else {
					if(!empty($mp[$i])){ $subj .= ",'$mp[$i]'"; }
				}
				// if(!empty($mp[$i])){ $subj .= ",'$mp[$i]'"; }
				$dt = date("Y-m-d H:i:s");
				if(!empty($mp[$i]) && !empty($gred[$i])){
					$rs = $conn->query("SELECT * FROM $schema2.`calon_stp_stam` WHERE `jenis_xm`='A' AND `id_pemohon`=".tosql($id_pemohon)." AND `tahun`=".tosql($stam_tahun_1)." AND `matapelajaran`=".tosql($mp[$i]));
					if($rs->EOF){
						$sql = "INSERT INTO $schema2.`calon_stp_stam`(`id_pemohon`, `tahun`, `matapelajaran`, `jenis_sijil`, `gred`, `d_cipta`, `jenis_xm`)";
						$sql .= " VALUES(".tosql($id_pemohon).",".tosql($stam_tahun_1).",".tosql($mp[$i]).",".tosql($jsijil).",".tosql($gred[$i]).",".tosql($dt).", 'A')";
					} else {
						$sql = "UPDATE $schema2.`calon_stp_stam` SET `gred`=".tosql($gred[$i]).", d_kemaskini=".tosql($dt)." WHERE `jenis_xm`='A' AND `id_pemohon`=".tosql($id_pemohon)." AND `tahun`=".tosql($stam_tahun_1)." AND `matapelajaran`=".tosql($mp[$i]);
					}
					$conn->execute($sql);
				}
				$err='OK';
			}

			// print $subj;
			if(!empty($subj)){ 
				$rsd = $conn->query("SELECT * FROM $schema2.`calon_stp_stam` WHERE `jenis_xm`='A' AND `id_pemohon`=".tosql($id_pemohon)." 
					AND `tahun`=".tosql($stam_tahun_1)." AND `matapelajaran` NOT IN(".$subj.")");
				while(!$rsd->EOF){
					// print $rsd->fields['matapelajaran'];
					$conn->execute("DELETE FROM $schema2.`calon_stp_stam` WHERE `jenis_xm`='A' AND `id_pemohon`=".tosql($id_pemohon)." 
						AND `tahun`=".tosql($stam_tahun_1)." AND `matapelajaran`=".tosql($rsd->fields['matapelajaran']));
					$rsd->movenext();
				}
			}
		}

		// print_r($mp_2); 
		// $subj = "'002'";
		if(!empty($stam_tahun_2)){ 
			// $conn->debug=true;
			$type='STAM2';
			$subj='';
			for($i=0;$i<=10;$i++){
				if($i==0){ 
					if(!empty($mp_2[$i])){ $subj .= "'$mp_2[$i]'"; }
				} else {
					if(!empty($mp_2[$i])){ $subj .= ",'$mp_2[$i]'"; }
				}
				// if(!empty($mp_2[$i])){ $subj .= ",'$mp_2[$i]'"; }
				$dt = date("Y-m-d H:i:s");
				if(!empty($mp_2[$i]) && !empty($gred_2[$i])){
					$rs = $conn->query("SELECT * FROM $schema2.`calon_stp_stam` WHERE `jenis_xm`='AT' AND `id_pemohon`=".tosql($id_pemohon)." AND `tahun`=".tosql($stam_tahun_2)." AND `matapelajaran`=".tosql($mp_2[$i]));
					if($rs->EOF){
						$sql = "INSERT INTO $schema2.`calon_stp_stam`(`id_pemohon`, `tahun`, `matapelajaran`, `jenis_sijil`, `gred`, `d_cipta`, `jenis_xm`)";
						$sql .= " VALUES(".tosql($id_pemohon).",".tosql($stam_tahun_2).",".tosql($mp_2[$i]).",".tosql($jsijil).",".tosql($gred_2[$i]).",".tosql($dt).", 'AT')";
					} else {
						$sql = "UPDATE $schema2.`calon_stp_stam` SET `gred`=".tosql($gred_2[$i]).", d_kemaskini=".tosql($dt)." WHERE `jenis_xm`='AT' AND `id_pemohon`=".tosql($id_pemohon)." AND `tahun`=".tosql($stam_tahun_2)." AND `matapelajaran`=".tosql($mp_2[$i]);
					}
					$conn->execute($sql);
				}
				$err='OK';
			}

			// print $subj;
			if(!empty($subj)){ 
				$rsd = $conn->query("SELECT * FROM $schema2.`calon_stp_stam` WHERE `jenis_xm`='AT' AND `id_pemohon`=".tosql($id_pemohon)." 
					AND `tahun`=".tosql($stam_tahun_2)." AND `matapelajaran` NOT IN(".$subj.")");
				while(!$rsd->EOF){
					// print $rsd->fields['matapelajaran'];
					$conn->execute("DELETE FROM $schema2.`calon_stp_stam` WHERE `jenis_xm`='AT' AND `id_pemohon`=".tosql($id_pemohon)." 
						AND `tahun`=".tosql($stam_tahun_2)." AND `matapelajaran`=".tosql($rsd->fields['matapelajaran']));
					$rsd->movenext();
				}
			}
		}


		// print "UPL:".$_FILES['file_pmr']['name'];
		//$sijil_pmr=isset($_REQUEST["sijil_pmr"])?$_REQUEST["sijil_pmr"]:"";
		if(!empty($_FILES['file_pmr']['name'])){ 
			// $conn->debug=true;
			// $type='PMR';
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif','pdf'); // valid extensions
	        $path = '../../uploads_doc/'.$id_pemohon.'/'; // upload directory
	        if (file_exists($path)) {
	            $path = $path;
	        } else {
	            mkdir($path);
	            $path = '../../uploads_doc/'.$id_pemohon.'/';
	        }

	        $img = $_FILES['file_pmr']['name'];
	        $tmp = $_FILES['file_pmr']['tmp_name'];
	        
	        $ext = end((explode(".", $img))); 
	        // $fname = $img; //$id.".".$ext;
	        // $fname = str_replace(" ", "_", $fname);
	        // $fname = str_replace("-", "_", $fname);

	        // $final_image = "docSenaraiSemak_D3_1_".$appli_id2."_".$item_id.".".$ext;
	        // $final_image = rand(1000,1000000)."_".$fname;
	        $final_image = strtolower($id_pemohon."_".$type.".".$ext);
	        $sijil_size = $_FILES['sijil_pmr']['size'];
	        $sijil_type = $_FILES['sijil_pmr']['type'];
			// check's valid format
			// $conn->debug=true;
			if(in_array($ext, $valid_extensions)){ 
				$path = $path.strtolower($final_image); 
				// print "n:".$path.'>'.$tmp; exit();
				move_uploaded_file($tmp,$path);
				// $err = $path;
				$dt = date("Y-m-d H:i:s");
				$upd_main='';
				$sqlu = "INSERT INTO $schema2.`calon_sijil`(`id_pemohon`, `jenis_sijil`, `sijil_nama`, `sijil_size`, `sijil_type`, `dt_create`) 
				VALUES('{$id_pemohon}', '{$type}', '{$final_image}', '{$sijil_size}', '{$sijil_type}', '{$dt}')";
			    
				$rsn = $conn->execute($sqlu);		
				if($rsn){ 	
				    $err='OK';
				} else { 
					$err = 'ERR'; 
				}
			} else {
				$err = "XEX";
			}
		}
	}

} else if($frm=='UNIV'){

	//$conn->debug=true;
	if($pro=='ADD'){

		$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
		$kep=isset($_REQUEST["kep"])?$_REQUEST["kep"]:"";

		$rss = $conn->execute("INSERT INTO $schema2.`calon_ipt`(`id_pemohon`, `bil_keputusan`) VALUES(".tosql($id_pemohon).", ".tosql($kep).") ");

		if($rss){
			$err='OK';
		} else {
			$err='ERR';
		}

	} else if($pro=='DEL'){

		$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
		$kep=isset($_REQUEST["kep"])?$_REQUEST["kep"]:"";

		$rss = $conn->execute("DELETE FROM $schema2.`calon_ipt` WHERE `id_pemohon`= ".tosql($id_pemohon)." AND `bil_keputusan`=".tosql($kep));

		if($rss){
			$err='OK';
		} else {
			$err='ERR';
		}

	} else if($pro=='SAVE'){

		$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
		$bil_keputusan1=isset($_REQUEST["bil_keputusan1"])?$_REQUEST["bil_keputusan1"]:"";
		$bil_keputusan2=isset($_REQUEST["bil_keputusan2"])?$_REQUEST["bil_keputusan2"]:"";
		$bil_keputusan3=isset($_REQUEST["bil_keputusan3"])?$_REQUEST["bil_keputusan3"]:"";

		$tahun1=isset($_REQUEST["tahun1"])?$_REQUEST["tahun1"]:"";
		$peringkat1=isset($_REQUEST["peringkat1"])?$_REQUEST["peringkat1"]:"";
		$cgpa1=isset($_REQUEST["cgpa1"])?$_REQUEST["cgpa1"]:"";
		$inst_keluar_sijil1=isset($_REQUEST["inst_keluar_sijil1"])?$_REQUEST["inst_keluar_sijil1"]:"";
		$inst_francais1=isset($_REQUEST["inst_francais1"])?$_REQUEST["inst_francais1"]:"";
		$bidang1=isset($_REQUEST["bidang1"])?$_REQUEST["bidang1"]:"";
		$pengkhususan1=isset($_REQUEST["pengkhususan1"])?$_REQUEST["pengkhususan1"]:"";
		$muet1=isset($_REQUEST["muet1"])?$_REQUEST["muet1"]:"";
		$biasiswa1=isset($_REQUEST["biasiswa1"])?$_REQUEST["biasiswa1"]:"";

		// print_r($mp);
		// $subj = "'002'";
		if(!empty($bil_keputusan1)){ 
			$sql = "UPDATE $schema2.`calon_ipt` SET `tahun`=".tosql($tahun1).", `peringkat`=".tosql($peringkat1).", `cgpa`=".tosql($cgpa1).", 
				`inst_keluar_sijil`=".tosql($inst_keluar_sijil1).", `inst_francais`=".tosql($inst_francais1).", `bidang`=".tosql($bidang1).", 
				`pengkhususan`=".tosql($pengkhususan1).", `biasiswa`=".tosql($biasiswa1).", `muet`=".tosql($muet1).", 
				`d_kemaskini`=".tosql(date("Y-m-d H:i:s"))." 
			WHERE `id_pemohon`=".tosql($id_pemohon)." AND `bil_keputusan`=1";
		} else {
			$sql = "INSERT INTO $schema2.`calon_ipt`(`id_pemohon`, `bil_keputusan`, `tahun`, `peringkat`, `cgpa`, `inst_keluar_sijil`, `inst_francais`, `bidang`, `pengkhususan`, `biasiswa`, `muet`, `d_cipta`) 
			VALUES(".tosql($id_pemohon).", '1', ".tosql($tahun1).", ".tosql($peringkat1).", ".tosql($cgpa1).", ".tosql($inst_keluar_sijil1).", 
				".tosql($inst_francais1).", ".tosql($bidang1).", ".tosql($pengkhususan1).", ".tosql($biasiswa).", ".tosql($muet1).", ".tosql(date("Y-m-d H:i:s")).")";
		}

		$rss = $conn->execute($sql);
		if($rss){ $err = 'OK'; } else { $err='ERR'; }

		if(!empty($bil_keputusan2)){ 
			$tahun2=isset($_REQUEST["tahun2"])?$_REQUEST["tahun2"]:"";
			$peringkat2=isset($_REQUEST["peringkat2"])?$_REQUEST["peringkat2"]:"";
			$cgpa2=isset($_REQUEST["cgpa2"])?$_REQUEST["cgpa2"]:"";
			$inst_keluar_sijil2=isset($_REQUEST["inst_keluar_sijil2"])?$_REQUEST["inst_keluar_sijil2"]:"";
			$inst_francais2=isset($_REQUEST["inst_francais2"])?$_REQUEST["inst_francais2"]:"";
			$bidang2=isset($_REQUEST["bidang2"])?$_REQUEST["bidang2"]:"";
			$pengkhususan2=isset($_REQUEST["pengkhususan2"])?$_REQUEST["pengkhususan2"]:"";
			$muet2=isset($_REQUEST["muet2"])?$_REQUEST["muet2"]:"";
			$biasiswa2=isset($_REQUEST["biasiswa2"])?$_REQUEST["biasiswa2"]:"";

			$sql = "UPDATE $schema2.`calon_ipt` SET `tahun`=".tosql($tahun2).", `peringkat`=".tosql($peringkat2).", `cgpa`=".tosql($cgpa2).", 
				`inst_keluar_sijil`=".tosql($inst_keluar_sijil2).", `inst_francais`=".tosql($inst_francais2).", `bidang`=".tosql($bidang2).", 
				`pengkhususan`=".tosql($pengkhususan2).", `biasiswa`=".tosql($biasiswa2).", `muet`=".tosql($muet2).", 
				`d_kemaskini`=".tosql(date("Y-m-d H:i:s"))." 
			WHERE `id_pemohon`=".tosql($id_pemohon)." AND `bil_keputusan`=2";
		}
		$rss = $conn->execute($sql);
		if($rss){ $err = 'OK'; } else { $err='ERR'; }

	}

} else if($frm=='PROFESIONAL'){

	if($pro=='SAVE'){ 
		// $conn->debug=true;
		$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
		$professional_1=isset($_REQUEST["professional_1"])?$_REQUEST["professional_1"]:"";
		$professional_d_1=isset($_REQUEST["professional_d_1"])?$_REQUEST["professional_d_1"]:"";
		$professional_no_ahli_1=isset($_REQUEST["professional_no_ahli_1"])?$_REQUEST["professional_no_ahli_1"]:"";

		if(!empty($id_pemohon)){

			$sqlu = "UPDATE $schema2.`calon` SET `professional_1`=".tosql($professional_1).", `professional_d_1`=".tosql($professional_d_1).", 
			`professional_no_ahli_1`=".tosql($professional_no_ahli_1);
			$sqlu .= " WHERE `id_pemohon`=".tosql($id_pemohon);
			$rss = $conn->execute($sqlu);

		}

		if($rss){ $err = 'OK'; } else { $err='ERR'; }

		if(!empty($_FILES['file_profesional']['name'])){ 
			// $conn->debug=true;
			// $type='PMR';
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif','pdf'); // valid extensions
	        $path = '../../uploads_doc/'.$id_pemohon.'/'; // upload directory
	        if (file_exists($path)) {
	            $path = $path;
	        } else {
	            mkdir($path);
	            $path = '../../uploads_doc/'.$id_pemohon.'/';
	        }

	        $img = $_FILES['file_profesional']['name'];
	        $tmp = $_FILES['file_profesional']['tmp_name'];
	        
	        $ext = end((explode(".", $img))); 
	        // $fname = $img; //$id.".".$ext;
	        // $fname = str_replace(" ", "_", $fname);
	        // $fname = str_replace("-", "_", $fname);

	        // $final_image = "docSenaraiSemak_D3_1_".$appli_id2."_".$item_id.".".$ext;
	        // $final_image = rand(1000,1000000)."_".$fname;
	        $final_image = strtolower($id_pemohon."_SIJIL_PRO.".$ext);
	        $sijil_size = $_FILES['file_profesional']['size'];
	        $sijil_type = $_FILES['file_profesional']['type'];
			// check's valid format
			// $conn->debug=true;
			if(in_array($ext, $valid_extensions)){ 
				$path = $path.strtolower($final_image); 
				// print "n:".$path.'>'.$tmp; exit();
				move_uploaded_file($tmp,$path);
				// $err = $path;
				$dt = date("Y-m-d H:i:s");
				$upd_main='';
				$sqlu = "INSERT INTO $schema2.`calon_sijil`(`id_pemohon`, `jenis_sijil`, `sijil_nama`, `sijil_size`, `sijil_type`, `dt_create`) 
				VALUES('{$id_pemohon}', 'PRO', '{$final_image}', '{$sijil_size}', '{$sijil_type}', '{$dt}')";
			    
				$rsn = $conn->execute($sqlu);		
				if($rsn){ 	
				    $err='OK';
				} else { 
					$err = 'ERR'; 
				}
			} else {
				$err = "XEX";
			}
		}
	} else if($pro=='DEL'){

		$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
		if(!empty($id_pemohon)){

			$sqlu = "UPDATE $schema2.`calon` SET `professional_1`=NULL, `professional_d_1`=NULL, `professional_no_ahli_1`=NULL";
			$sqlu .= " WHERE `id_pemohon`=".tosql($id_pemohon);
			$rss = $conn->execute($sqlu);

			$rs = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='PRO' AND `id_pemohon`='{$id_pemohon}'");
			if(!$rs->EOF){
				$sqld = "DELETE FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='PRO' AND `id_pemohon`='{$id_pemohon}'";
				$path = '../../uploads_doc/'.$id_pemohon.'/'.$rs->fields['sijil_nama']; // upload directory
				$conn->execute($sqld);
				unlink($path);
			}
		}

		if($rss){ $err = 'OK'; } else { $err='ERR'; }
	}

} else if($frm=='ULANGAN'){

	if($pro=='SAVE'){ 
		// $conn->debug=true;
		$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
		$tahun1=isset($_REQUEST["tahun1"])?$_REQUEST["tahun1"]:"";
		$mp1=isset($_REQUEST["mp1"])?$_REQUEST["mp1"]:"";
		$gred1=isset($_REQUEST["gred1"])?$_REQUEST["gred1"]:"";
		$tahun2=isset($_REQUEST["tahun2"])?$_REQUEST["tahun2"]:"";
		$mp2=isset($_REQUEST["mp2"])?$_REQUEST["mp2"]:"";
		$gred2=isset($_REQUEST["gred2"])?$_REQUEST["gred2"]:"";
		$tahun3=isset($_REQUEST["tahun3"])?$_REQUEST["tahun3"]:"";
		$mp3=isset($_REQUEST["mp3"])?$_REQUEST["mp3"]:"";
		$gred3=isset($_REQUEST["gred3"])?$_REQUEST["gred3"]:"";
		$tahun4=isset($_REQUEST["tahun4"])?$_REQUEST["tahun4"]:"";
		$mp4=isset($_REQUEST["mp4"])?$_REQUEST["mp4"]:"";
		$gred4=isset($_REQUEST["gred4"])?$_REQUEST["gred4"]:"";

		if(!empty($id_pemohon)){

			if(!empty($tahun1) && !empty($mp1) && !empty($gred1)){
				$rs = $conn->query("SELECT * FROM `calon_spm` WHERE `id_pemohon`='{$id_pemohon}' AND `tahun`='{$tahun1}' AND `jenis_xm`='T' AND `matapelajaran`='{$mp1}'");
				if($rs->EOF){
					$sql = "INSERT INTO `calon_spm`(`id_pemohon`, `tahun`, `matapelajaran`, `gred`, `jenis_xm`, `d_cipta`, `d_kemaskini`)";
					$sql .= " VALUES('{$id_pemohon}', '{$tahun1}')";
				}
			}

			$sqlu = "UPDATE $schema2.`calon` SET `professional_1`=".tosql($professional_1).", `professional_d_1`=".tosql($professional_d_1).", 
			`professional_no_ahli_1`=".tosql($professional_no_ahli_1);
			$sqlu .= " WHERE `id_pemohon`=".tosql($id_pemohon);
			$rss = $conn->execute($sqlu);

		}

		if($rss){ $err = 'OK'; } else { $err='ERR'; }

		if(!empty($_FILES['file_profesional']['name'])){ 
			// $conn->debug=true;
			// $type='PMR';
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif','pdf'); // valid extensions
	        $path = '../../uploads_doc/'.$id_pemohon.'/'; // upload directory
	        if (file_exists($path)) {
	            $path = $path;
	        } else {
	            mkdir($path);
	            $path = '../../uploads_doc/'.$id_pemohon.'/';
	        }

	        $img = $_FILES['file_profesional']['name'];
	        $tmp = $_FILES['file_profesional']['tmp_name'];
	        
	        $ext = end((explode(".", $img))); 
	        // $fname = $img; //$id.".".$ext;
	        // $fname = str_replace(" ", "_", $fname);
	        // $fname = str_replace("-", "_", $fname);

	        // $final_image = "docSenaraiSemak_D3_1_".$appli_id2."_".$item_id.".".$ext;
	        // $final_image = rand(1000,1000000)."_".$fname;
	        $final_image = strtolower($id_pemohon."_SIJIL_PRO.".$ext);
	        $sijil_size = $_FILES['file_profesional']['size'];
	        $sijil_type = $_FILES['file_profesional']['type'];
			// check's valid format
			// $conn->debug=true;
			if(in_array($ext, $valid_extensions)){ 
				$path = $path.strtolower($final_image); 
				// print "n:".$path.'>'.$tmp; exit();
				move_uploaded_file($tmp,$path);
				// $err = $path;
				$dt = date("Y-m-d H:i:s");
				$upd_main='';
				$sqlu = "INSERT INTO $schema2.`calon_sijil`(`id_pemohon`, `jenis_sijil`, `sijil_nama`, `sijil_size`, `sijil_type`, `dt_create`) 
				VALUES('{$id_pemohon}', 'PRO', '{$final_image}', '{$sijil_size}', '{$sijil_type}', '{$dt}')";
			    
				$rsn = $conn->execute($sqlu);		
				if($rsn){ 	
				    $err='OK';
				} else { 
					$err = 'ERR'; 
				}
			} else {
				$err = "XEX";
			}
		}
	} else if($pro=='DEL'){

		$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
		if(!empty($id_pemohon)){

			$sqlu = "UPDATE $schema2.`calon` SET `professional_1`=NULL, `professional_d_1`=NULL, `professional_no_ahli_1`=NULL";
			$sqlu .= " WHERE `id_pemohon`=".tosql($id_pemohon);
			$rss = $conn->execute($sqlu);

			$rs = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='PRO' AND `id_pemohon`='{$id_pemohon}'");
			if(!$rs->EOF){
				$sqld = "DELETE FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='PRO' AND `id_pemohon`='{$id_pemohon}'";
				$path = '../../uploads_doc/'.$id_pemohon.'/'.$rs->fields['sijil_nama']; // upload directory
				$conn->execute($sqld);
				unlink($path);
			}
		}

		if($rss){ $err = 'OK'; } else { $err='ERR'; }
	}

}

if($frm=='SRP' || $frm=='SPM' || $frm=='STPM' || $frm=='STAM' || $frm=='UNIV'){
	set_tarikh($id_pemohon, "tkh_upd_akademik");
}

// header("Content-Type: text/json");
// print json_encode($err); 
print $err;
?>
