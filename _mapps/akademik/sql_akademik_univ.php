<?php
session_start();
@include_once '../../connection/common.php';
$frm=isset($_GET["frm"])?$_GET["frm"]:"";
$pro=isset($_GET["pro"])?$_GET["pro"]:"";
$date=date("Y-m-d H:i:s");
//$oleh=$_SESSION['SESS_UID'];

function clear_jawatan($uid){
	global $conn;
	global $schema2;
	
	$sql = "DELETE FROM $schema2.`calon_jawatan_dipohon` WHERE id_pemohon=".tosql($uid);
	$conn->execute($sql);
	$sql1 = "DELETE FROM $schema2.`calon_pusat_temuduga` WHERE id_pemohon=".tosql($uid);
	$conn->execute($sql1);
	$sql2 = "UPDATE $schema2.`calon` SET `pengakuan`=NULL, `tarikh_akuan`=NULL, `status_pemohon`=NULL WHERE id_pemohon=".tosql($uid);
	$conn->execute($sql2);
	//print ".";
}

if($frm=='UNIV'){

//exit;
$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
$rsIC = $conn->query("SELECT ICNo FROM $schema2.calon WHERE id_pemohon=".tosql($id_pemohon));
$noic = $rsIC->fields['ICNo'];
//print $frm.":".$pro; exit;
	if($pro=='ADD'){

		$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
		$kep=isset($_REQUEST["kep"])?$_REQUEST["kep"]:"";

		$rss = $conn->execute("INSERT INTO $schema2.`calon_ipt`(`id_pemohon`, `bil_keputusan`) VALUES(".tosql($id_pemohon).", ".tosql($kep).") ");

		if($rss){
			$err='OK';
		} else {
			$err='ERR';
		}

	} else if($pro=='UNIV_DELALL'){
		//DELETE SEMUA MAKLUMAt KELULUSAN PENGAJIAN TINGGI
		//$conn->debug=true;
		$rss = $conn->execute("DELETE FROM $schema2.`calon_ipt` WHERE `id_pemohon`= ".tosql($id_pemohon));
		$rs = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil` LIKE 'univ%' AND `id_pemohon`=".tosql($id_pemohon));
		if(!$rs->EOF){
			$err='OK';
			while(!$rs->EOF){
				$sj = $rs->fields['jenis_sijil'];
				$sqld = "DELETE FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='{$sj}' AND `id_pemohon`=".tosql($id_pemohon);
				$path = '/var/www/html/upload/'.$id_pemohon.'/'.$rs->fields['sijil_nama']; // upload directory
				$rsd = $conn->execute($sqld);
				if($rsd){ 
					if(file_exists($path)){
						unlink($path); 
					}
				}
				$rs->movenext();
			}
		}

		if($rss){
			$err='OK';
		} else {
			$err='ERR';
		}


	} else if($pro=='UNIV_DEL'){

		$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
		$kep=isset($_REQUEST["kep"])?$_REQUEST["kep"]:"";

		//$conn->debug=true;
		if($kep==1){
			$jsijil1 = 'UNIV1A'; $jsijil2 = 'UNIV1B'; $jsijil3 = 'UNIV1C'; 
			$rss = $conn->execute("DELETE FROM $schema2.`calon_ipt` WHERE `id_pemohon`= ".tosql($id_pemohon)." AND `bil_keputusan`=".tosql($kep));
			$rsC = $conn->query("SELECT * FROM $schema2.`calon_ipt` WHERE `id_pemohon`= ".tosql($id_pemohon)." ORDER BY `bil_keputusan`");
			while(!$rsC->EOF){
				if($rsC->fields['bil_keputusan']==2){ 
					$conn->execute("UPDATE $schema2.`calon_ipt` SET `bil_keputusan`=1 WHERE `id_pemohon`= ".tosql($id_pemohon)." AND `bil_keputusan`=2");
				} else if($rsC->fields['bil_keputusan']==3){ 
					$conn->execute("UPDATE $schema2.`calon_ipt` SET `bil_keputusan`=2 WHERE `id_pemohon`= ".tosql($id_pemohon)." AND `bil_keputusan`=3");
				}
				$rsC->movenext();
			}

			$rs = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil` LIKE 'UNIV1%' AND `id_pemohon`='{$id_pemohon}'");
			while(!$rs->EOF){
				$sj = $rs->fields['jenis_sijil'];
				$sqld = "DELETE FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='{$sj}' AND `id_pemohon`='{$id_pemohon}'";
				$path = '/var/www/html/upload/'.$id_pemohon.'/'.$rs->fields['sijil_nama']; // upload directory
				$rsd = $conn->execute($sqld);
				if($rsd){ 
					if(file_exists($path)){
						unlink($path); 
					}
				}
				$rs->movenext();
			}
			$rs = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil` >= 'UNIV2A' AND `id_pemohon`='{$id_pemohon}' ORDER BY `jenis_sijil`");
			while(!$rs->EOF){
				$sj = $rs->fields['jenis_sijil'];
				$sijil_nama = $rs->fields['sijil_nama'];
				$sijil = explode(".", $sijil_nama);
				$sijil_end = $sijil[1];

				if($sj=='UNIV2A'){ $jenis_sijil = 'UNIV1A'; $file_name=$noic.'_univ1a.'.$sijil_end; }
				else if($sj=='UNIV2B'){ $jenis_sijil = 'UNIV1B'; $file_name=$noic.'_univ1b.'.$sijil_end; }
				else if($sj=='UNIV2C'){ $jenis_sijil = 'UNIV1C'; $file_name=$noic.'_univ1c.'.$sijil_end; }
				else if($sj=='UNIV3A'){ $jenis_sijil = 'UNIV2A'; $file_name=$noic.'_univ2a.'.$sijil_end; }
				else if($sj=='UNIV3B'){ $jenis_sijil = 'UNIV2B'; $file_name=$noic.'_univ2b.'.$sijil_end; }
				else if($sj=='UNIV3C'){ $jenis_sijil = 'UNIV2C'; $file_name=$noic.'_univ2c.'.$sijil_end; }
				$rsd = $conn->execute("UPDATE $schema2.`calon_sijil` SET `jenis_sijil`='{$jenis_sijil}' WHERE `jenis_sijil`='{$sj}' AND `id_pemohon`='{$id_pemohon}'");
				
				if(file_exists('/var/www/html/upload/'.$id_pemohon.'/'.$sijil_nama)){
    					rename('/var/www/html/upload/'.$id_pemohon.'/'.$sijil_nama,'/var/www/html/upload/'.$id_pemohon.'/'.$file_name);
					$rsd = $conn->execute("UPDATE $schema2.`calon_sijil` SET `sijil_nama`='{$file_name}' WHERE `jenis_sijil`='{$jenis_sijil}' AND `id_pemohon`='{$id_pemohon}'");
  				}

				$rs->movenext();
			}

		} else if($kep==2){

			$jsijil1 = 'UNIV2A'; $jsijil2 = 'UNIV2B'; $jsijil3 = 'UNIV2C'; 
			$rss = $conn->execute("DELETE FROM $schema2.`calon_ipt` WHERE `id_pemohon`= ".tosql($id_pemohon)." AND `bil_keputusan`=".tosql($kep));
			$rsC = $conn->query("SELECT * FROM $schema2.`calon_ipt` WHERE `id_pemohon`= ".tosql($id_pemohon)." ORDER BY `bil_keputusan`");
			while(!$rsC->EOF){
				if($rsC->fields['bil_keputusan']==2){ 
					$conn->execute("UPDATE $schema2.`calon_ipt` SET `bil_keputusan`=1 WHERE `id_pemohon`= ".tosql($id_pemohon)." AND `bil_keputusan`=2");
				} else if($rsC->fields['bil_keputusan']==3){ 
					$conn->execute("UPDATE $schema2.`calon_ipt` SET `bil_keputusan`=2 WHERE `id_pemohon`= ".tosql($id_pemohon)." AND `bil_keputusan`=3");
				}
				$rsC->movenext();
			}

			$rs = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil` LIKE 'UNIV2%' AND `id_pemohon`='{$id_pemohon}'");
			while(!$rs->EOF){
				$sj = $rs->fields['jenis_sijil'];
				$sqld = "DELETE FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='{$sj}' AND `id_pemohon`='{$id_pemohon}'";
				$path = '/var/www/html/upload/'.$id_pemohon.'/'.$rs->fields['sijil_nama']; // upload directory
				$rsd = $conn->execute($sqld);
				if($rsd){ 
					if(file_exists($path)){
						unlink($path); 
					}
				}
				$rs->movenext();
			}

			$rs = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil` >= 'UNIV3A' AND `id_pemohon`='{$id_pemohon}' ORDER BY `jenis_sijil`");
			while(!$rs->EOF){
				$sj = $rs->fields['jenis_sijil'];
				$sijil_nama = $rs->fields['sijil_nama'];
				$sijil = explode(".", $sijil_nama);
				$sijil_end = $sijil[1];

				if($sj=='UNIV3A'){ $jenis_sijil = 'UNIV2A'; $file_name=$noic.'_univ3a.'.$sijil_end; }
				else if($sj=='UNIV3B'){ $jenis_sijil = 'UNIV2B'; $file_name=$noic.'_univ3b.'.$sijil_end; }
				else if($sj=='UNIV3C'){ $jenis_sijil = 'UNIV2C'; $file_name=$noic.'_univ3c.'.$sijil_end; }
				$rsd = $conn->execute("UPDATE $schema2.`calon_sijil` SET `jenis_sijil`='{$jenis_sijil}' WHERE `jenis_sijil`='{$sj}' AND `id_pemohon`='{$id_pemohon}'");
				
				if(file_exists('/var/www/html/upload/'.$id_pemohon.'/'.$sijil_nama)){
    					rename('/var/www/html/upload/'.$id_pemohon.'/'.$sijil_nama,'/var/www/html/upload/'.$id_pemohon.'/'.$file_name);
					$rsd = $conn->execute("UPDATE $schema2.`calon_sijil` SET `sijil_nama`='{$file_name}' WHERE `jenis_sijil`='{$jenis_sijil}' AND `id_pemohon`='{$id_pemohon}'");
  				}

				$rs->movenext();
			}

		} else if($kep==3){
			$jsijil1 = 'UNIV3A'; $jsijil2 = 'UNIV3B'; $jsijil3 = 'UNIV3C'; 
			$rss = $conn->execute("DELETE FROM $schema2.`calon_ipt` WHERE `id_pemohon`= ".tosql($id_pemohon)." AND `bil_keputusan`=".tosql($kep));

			$rs = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil` LIKE 'UNIV3%' AND `id_pemohon`='{$id_pemohon}'");
			while(!$rs->EOF){
				$sj = $rs->fields['jenis_sijil'];
				$sqld = "DELETE FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='{$sj}' AND `id_pemohon`='{$id_pemohon}'";
				$path = '/var/www/html/upload/'.$id_pemohon.'/'.$rs->fields['sijil_nama']; // upload directory
				$rsd = $conn->execute($sqld);
				if($rsd){ 
					if(file_exists($path)){
						unlink($path); 
					}
				}

				$rs->movenext();
			}

		}

		if($rs){ $err = 'OK'; } else { $err='ERR'; }


	} else if($pro=='SAVE1'){
		$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
		$bil_keputusan1=isset($_REQUEST["bil_keputusan1"])?$_REQUEST["bil_keputusan1"]:"";

		$tahun1=isset($_REQUEST["tahun1"])?$_REQUEST["tahun1"]:"";
		$peringkat1=isset($_REQUEST["peringkat1"])?$_REQUEST["peringkat1"]:"";
		$cgpa1=isset($_REQUEST["cgpa1"])?$_REQUEST["cgpa1"]:"";
		$inst_keluar_sijil1=isset($_REQUEST["inst_keluar_sijil1"])?$_REQUEST["inst_keluar_sijil1"]:"";
		$inst_francais1=isset($_REQUEST["inst_francais1"])?$_REQUEST["inst_francais1"]:"";
		$bidang1=isset($_REQUEST["bidang1"])?$_REQUEST["bidang1"]:"";
		$pengkhususan1=isset($_REQUEST["pengkhususan1"])?$_REQUEST["pengkhususan1"]:"";
		$muet1=isset($_REQUEST["jenisMuetCefr1"])?$_REQUEST["jenisMuetCefr1"]:"";
		$muet_tahun=isset($_REQUEST["tahunMuetCefr1"])?$_REQUEST["tahunMuetCefr1"]:"";
		$muet_gred=isset($_REQUEST["keputusanMuetCefr1"])?$_REQUEST["keputusanMuetCefr1"]:"";
		$biasiswa1=isset($_REQUEST["biasiswa1"])?$_REQUEST["biasiswa1"]:"";
		$tkh_senate=isset($_REQUEST["tkh_senate"])?$_REQUEST["tkh_senate"]:"";

		$rsIC = $conn->query("SELECT ICNo FROM $schema2.calon WHERE id_pemohon=$id_pemohon");

		// print_r($mp);
		// $subj = "'002'";
		// $conn->debug=true;
		if(!empty($bil_keputusan1)){ 
			$sql = "UPDATE $schema2.`calon_ipt` SET `tahun`=".tosql($tahun1).", `peringkat`=".tosql($peringkat1).", `cgpa`=".tosql($cgpa1).", 
				`inst_keluar_sijil`=".tosql($inst_keluar_sijil1).", `inst_francais`=".tosql($inst_francais1).", `bidang`=".tosql($bidang1).", 
				`pengkhususan`=".tosql($pengkhususan1).", `biasiswa`=".tosql($biasiswa1).", `tkh_senate`=".tosql(DBDate($tkh_senate)).",  
				`muet`=".tosql($muet1).", `muet_tahun`=".tosql($muet_tahun).", `muet_gred`=".tosql($muet_gred).", 
				`d_kemaskini`=".tosql(date("Y-m-d H:i:s"))." 
			WHERE `id_pemohon`=".tosql($id_pemohon)." AND `bil_keputusan`=1";
		} else {
			$sql = "INSERT INTO $schema2.`calon_ipt`(`id_pemohon`, `bil_keputusan`, `tahun`, `peringkat`, `cgpa`, `inst_keluar_sijil`, `inst_francais`, `bidang`, `pengkhususan`, `biasiswa`, `muet`, `muet_tahun`, `muet_gred`, `tkh_senate`, `d_cipta`) 
			VALUES(".tosql($id_pemohon).", '1', ".tosql($tahun1).", ".tosql($peringkat1).", ".tosql($cgpa1).", ".tosql($inst_keluar_sijil1).", 
				".tosql($inst_francais1).", ".tosql($bidang1).", ".tosql($pengkhususan1).", ".tosql($biasiswa1).", 
				".tosql($muet1).", ".tosql($muet_tahun).", ".tosql($muet_gred).", 
				".tosql(DBDate($tkh_senate)).", ".tosql(date("Y-m-d H:i:s")).")";
		}

		$rss = $conn->execute($sql);
		if($rss){ $err = 'OK'; } else { $err='ERR'; }

	} else if($pro=='SAVE2'){

		$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
		$bil_keputusan2=isset($_REQUEST["bil_keputusan2"])?$_REQUEST["bil_keputusan2"]:"";
		$tahun1=isset($_REQUEST["tahun1"])?$_REQUEST["tahun1"]:"";
		$peringkat1=isset($_REQUEST["peringkat1"])?$_REQUEST["peringkat1"]:"";
		$cgpa1=isset($_REQUEST["cgpa1"])?$_REQUEST["cgpa1"]:"";
		$inst_keluar_sijil1=isset($_REQUEST["inst_keluar_sijil1"])?$_REQUEST["inst_keluar_sijil1"]:"";
		$inst_francais1=isset($_REQUEST["inst_francais1"])?$_REQUEST["inst_francais1"]:"";
		$bidang1=isset($_REQUEST["bidang1"])?$_REQUEST["bidang1"]:"";
		$pengkhususan1=isset($_REQUEST["pengkhususan1"])?$_REQUEST["pengkhususan1"]:"";
		$muet1=isset($_REQUEST["jenisMuetCefr1"])?$_REQUEST["jenisMuetCefr1"]:"";
		$muet_tahun=isset($_REQUEST["tahunMuetCefr1"])?$_REQUEST["tahunMuetCefr1"]:"";
		$muet_gred=isset($_REQUEST["keputusanMuetCefr1"])?$_REQUEST["keputusanMuetCefr1"]:"";
		$biasiswa1=isset($_REQUEST["biasiswa1"])?$_REQUEST["biasiswa1"]:"";
		$tkh_senate=isset($_REQUEST["tkh_senate"])?$_REQUEST["tkh_senate"]:"";
		
		$rsIC = $conn->query("SELECT ICNo FROM $schema2.calon WHERE id_pemohon=$id_pemohon");

		// print_r($mp);
		// $subj = "'002'";
		 //$conn->debug=true;
		if(!empty($bil_keputusan2)){ 
			$sql = "UPDATE $schema2.`calon_ipt` SET `tahun`=".tosql($tahun1).", `peringkat`=".tosql($peringkat1).", `cgpa`=".tosql($cgpa1).", 
				`inst_keluar_sijil`=".tosql($inst_keluar_sijil1).", `inst_francais`=".tosql($inst_francais1).", `bidang`=".tosql($bidang1).", 
				`pengkhususan`=".tosql($pengkhususan1).", `biasiswa`=".tosql($biasiswa1).", `tkh_senate`=".tosql(DBDate($tkh_senate)).",  
				`muet`=".tosql($muet1).", `muet_tahun`=".tosql($muet_tahun).", `muet_gred`=".tosql($muet_gred).", 
				`d_kemaskini`=".tosql(date("Y-m-d H:i:s"))." 
			WHERE `id_pemohon`=".tosql($id_pemohon)." AND `bil_keputusan`=2";
		} else {
			$sql = "INSERT INTO $schema2.`calon_ipt`(`id_pemohon`, `bil_keputusan`, `tahun`, `peringkat`, `cgpa`, `inst_keluar_sijil`, `inst_francais`, `bidang`, `pengkhususan`, `biasiswa`, `muet`, `muet_tahun`, `muet_gred`, `tkh_senate`, `d_cipta`) 
			VALUES(".tosql($id_pemohon).", '2', ".tosql($tahun1).", ".tosql($peringkat1).", ".tosql($cgpa1).", ".tosql($inst_keluar_sijil1).", 
				".tosql($inst_francais1).", ".tosql($bidang1).", ".tosql($pengkhususan1).", ".tosql($biasiswa1).", 
				".tosql($muet1).", ".tosql($muet_tahun).", ".tosql($muet_gred).", 
				".tosql(DBDate($tkh_senate)).", ".tosql(date("Y-m-d H:i:s")).")";
		}

		$rss = $conn->execute($sql);
		if($rss){ $err = 'OK'; } else { $err='ERR'; }

	} else if($pro=='SAVE3'){

		$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
		$bil_keputusan3=isset($_REQUEST["bil_keputusan3"])?$_REQUEST["bil_keputusan3"]:"";
		$tahun1=isset($_REQUEST["tahun1"])?$_REQUEST["tahun1"]:"";
		$peringkat1=isset($_REQUEST["peringkat1"])?$_REQUEST["peringkat1"]:"";
		$cgpa1=isset($_REQUEST["cgpa1"])?$_REQUEST["cgpa1"]:"";
		$inst_keluar_sijil1=isset($_REQUEST["inst_keluar_sijil1"])?$_REQUEST["inst_keluar_sijil1"]:"";
		$inst_francais1=isset($_REQUEST["inst_francais1"])?$_REQUEST["inst_francais1"]:"";
		$bidang1=isset($_REQUEST["bidang1"])?$_REQUEST["bidang1"]:"";
		$pengkhususan1=isset($_REQUEST["pengkhususan1"])?$_REQUEST["pengkhususan1"]:"";
		$muet1=isset($_REQUEST["jenisMuetCefr1"])?$_REQUEST["jenisMuetCefr1"]:"";
		$muet_tahun=isset($_REQUEST["tahunMuetCefr1"])?$_REQUEST["tahunMuetCefr1"]:"";
		$muet_gred=isset($_REQUEST["keputusanMuetCefr1"])?$_REQUEST["keputusanMuetCefr1"]:"";
		$biasiswa1=isset($_REQUEST["biasiswa1"])?$_REQUEST["biasiswa1"]:"";
		$tkh_senate=isset($_REQUEST["tkh_senate"])?$_REQUEST["tkh_senate"]:"";

		$rsIC = $conn->query("SELECT ICNo FROM $schema2.calon WHERE id_pemohon=$id_pemohon");

		// print_r($mp);
		// $subj = "'002'";
		// $conn->debug=true;
		if(!empty($bil_keputusan3)){ 
			$sql = "UPDATE $schema2.`calon_ipt` SET `tahun`=".tosql($tahun1).", `peringkat`=".tosql($peringkat1).", `cgpa`=".tosql($cgpa1).", 
				`inst_keluar_sijil`=".tosql($inst_keluar_sijil1).", `inst_francais`=".tosql($inst_francais1).", `bidang`=".tosql($bidang1).", 
				`pengkhususan`=".tosql($pengkhususan1).", `biasiswa`=".tosql($biasiswa1).", `tkh_senate`=".tosql(DBDate($tkh_senate)).",  
				`muet`=".tosql($muet1).", `muet_tahun`=".tosql($muet_tahun).", `muet_gred`=".tosql($muet_gred).", 
				`d_kemaskini`=".tosql(date("Y-m-d H:i:s"))." 
			WHERE `id_pemohon`=".tosql($id_pemohon)." AND `bil_keputusan`=3";
		} else {
			$sql = "INSERT INTO $schema2.`calon_ipt`(`id_pemohon`, `bil_keputusan`, `tahun`, `peringkat`, `cgpa`, `inst_keluar_sijil`, `inst_francais`, `bidang`, `pengkhususan`, `biasiswa`, `muet`, `muet_tahun`, `muet_gred`, `tkh_senate`, `d_cipta`) 
			VALUES(".tosql($id_pemohon).", '3', ".tosql($tahun1).", ".tosql($peringkat1).", ".tosql($cgpa1).", ".tosql($inst_keluar_sijil1).", 
				".tosql($inst_francais1).", ".tosql($bidang1).", ".tosql($pengkhususan1).", ".tosql($biasiswa1).", 
				".tosql($muet1).", ".tosql($muet_tahun).", ".tosql($muet_gred).", 
				".tosql(DBDate($tkh_senate)).", ".tosql(date("Y-m-d H:i:s")).")";
		}

		$rss = $conn->execute($sql);
		if($rss){ $err = 'OK'; } else { $err='ERR'; }

	} 

	 

	//print "UPL:".$_FILES['file1']['name'];
	//$sijil_pmr=isset($_REQUEST["sijil_pmr"])?$_REQUEST["sijil_pmr"]:"";
	// $conn->debug=true;
	if(!empty($_FILES['file1']['name'])){ 
		if($pro=='SAVE1'){ $typeA='UNIV1A'; }
		else if($pro=='SAVE2'){ $typeA='UNIV2A'; }
		else if($pro=='SAVE3'){ $typeA='UNIV3A'; }
		$valid_extensions = array('jpeg', 'jpg', 'png', 'gif','pdf','JPEG', 'JPG', 'PNG', 'GIF','PDF'); // valid extensions
        $path = '/var/www/html/upload/'.$id_pemohon.'/'; // upload directory
        if (file_exists($path)) {
            $path = $path;
        } else {
            mkdir($path);
            $path = '/var/www/html/upload/'.$id_pemohon.'/';
        }

        $img = $_FILES['file1']['name'];
        $tmp = $_FILES['file1']['tmp_name'];
        
        $ext = end((explode(".", $img))); 
        $fname = $img; //$id.".".$ext;
        $fname = str_replace(" ", "_", $fname);
        $fname = str_replace("-", "_", $fname);

        $final_image = strtolower($rsIC->fields['ICNo']."_".$typeA.".".$ext);
        $sijil_size = $_FILES['file1']['size'];
        $sijil_type = $_FILES['file1']['type'];
		// check's valid format
		// $conn->debug=true;
		if(in_array($ext, $valid_extensions)){ 
			$path = $path.strtolower($final_image); 
			// print "n:".$path.'>'.$tmp; exit();
			move_uploaded_file($tmp,$path);
			// $err = $path;
			$dt = date("Y-m-d H:i:s");
			$upd_main='';
			
			$rsu = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='{$typeA}' AND `id_pemohon`=".tosql($id_pemohon));
			if($rsu->EOF){ 
				$sqlu = "INSERT INTO $schema2.`calon_sijil`(`id_pemohon`, `jenis_sijil`, `sijil_nama`, `sijil_size`, `sijil_type`, `dt_create`) 
				VALUES('{$id_pemohon}', '{$typeA}', '{$final_image}', ".tosql($sijil_size).", '{$sijil_type}', '{$dt}')";
			} else {
				$sqlu = "UPDATE $schema2.`calon_sijil` SET `sijil_nama`='{$final_image}', `sijil_size`=".tosql($sijil_size).", 
				`sijil_type`=".tosql($sijil_type).", `dt_update`='{$date}' WHERE `jenis_sijil`='{$typeA}' AND `id_pemohon`=".tosql($id_pemohon);				
			}			    
			$rsn = $conn->execute($sqlu);		
			if($rsn){ 	
			    $err='OK';
			} else { 
				$err = 'ERR'; 
			}
		} else {
			$err = "XEX";
		}

	} //exit;

	if(!empty($_FILES['file2']['name'])){ 
		// $conn->debug=true;
		// $typeB='';
		if($pro=='SAVE1'){ $typeB='UNIV1B'; }
		else if($pro=='SAVE2'){ $typeB='UNIV2B'; }
		else if($pro=='SAVE3'){ $typeB='UNIV3B'; }
		$valid_extensions = array('jpeg', 'jpg', 'png', 'gif','pdf','JPEG', 'JPG', 'PNG', 'GIF','PDF'); // valid extensions
        $path = '/var/www/html/upload/'.$id_pemohon.'/'; // upload directory
        if (file_exists($path)) {
            $path = $path;
        } else {
            mkdir($path);
            $path = '/var/www/html/upload/'.$id_pemohon.'/';
        }

        $img = $_FILES['file2']['name'];
        $tmp = $_FILES['file2']['tmp_name'];
        
        $ext = end((explode(".", $img))); 
        $fname = $img; //$id.".".$ext;
        $fname = str_replace(" ", "_", $fname);
        $fname = str_replace("-", "_", $fname);

        $final_image = strtolower($rsIC->fields['ICNo']."_".$typeB.".".$ext);
        $sijil_size = $_FILES['file2']['size'];
        $sijil_type = $_FILES['file2']['type'];
		// check's valid format
		// $conn->debug=true;
		if(in_array($ext, $valid_extensions)){ 
			$path = $path.strtolower($final_image); 
			// print "n:".$path.'>'.$tmp; exit();
			move_uploaded_file($tmp,$path);
			// $err = $path;
			$dt = date("Y-m-d H:i:s");
			$upd_main='';
			
			$rsu = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='{$typeB}' AND `id_pemohon`=".tosql($id_pemohon));
			if($rsu->EOF){ 
				$sqlu = "INSERT INTO $schema2.`calon_sijil`(`id_pemohon`, `jenis_sijil`, `sijil_nama`, `sijil_size`, `sijil_type`, `dt_create`) 
				VALUES('{$id_pemohon}', '{$typeB}', '{$final_image}', ".tosql($sijil_size).", '{$sijil_type}', '{$dt}')";
			} else {
				$sqlu = "UPDATE $schema2.`calon_sijil` SET `sijil_nama`='{$final_image}', `sijil_size`=".tosql($sijil_size).", 
				`sijil_type`=".tosql($sijil_type).", `dt_update`='{$date}' WHERE `jenis_sijil`='{$typeB}' AND `id_pemohon`=".tosql($id_pemohon);				
			}			    
			$rsn = $conn->execute($sqlu);		
			if($rsn){ 	
			    $err='OK';
			} else { 
				$err = 'ERR'; 
			}
		} else {
			$err = "XEX";
		}

	} //exit;

	if(!empty($_FILES['file3']['name'])){ 
		// $conn->debug=true;
		// $typeB='';
		if($pro=='SAVE1'){ $typeC='UNIV1C'; }
		else if($pro=='SAVE2'){ $typeC='UNIV2C'; }
		else if($pro=='SAVE3'){ $typeC='UNIV3C'; }
		$valid_extensions = array('pdf', 'PDF'); // valid extensions
        $path = '/var/www/html/upload/'.$id_pemohon.'/'; // upload directory
        if (file_exists($path)) {
            $path = $path;
        } else {
            mkdir($path);
            $path = '/var/www/html/upload/'.$id_pemohon.'/';
        }

        $img = $_FILES['file3']['name'];
        $tmp = $_FILES['file3']['tmp_name'];
        
        $ext = end((explode(".", $img))); 
        $fname = $img; //$id.".".$ext;
        $fname = str_replace(" ", "_", $fname);
        $fname = str_replace("-", "_", $fname);

        $final_image = strtolower($rsIC->fields['ICNo']."_".$typeC.".".$ext);
        $sijil_size = $_FILES['file3']['size'];
        $sijil_type = $_FILES['file3']['type'];
		// check's valid format
		// $conn->debug=true;
		if(in_array($ext, $valid_extensions)){ 
			$path = $path.strtolower($final_image); 
			// print "n:".$path.'>'.$tmp; exit();
			move_uploaded_file($tmp,$path);
			// $err = $path;
			$dt = date("Y-m-d H:i:s");
			$upd_main='';
			
			$rsu = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='{$typeC}' AND `id_pemohon`=".tosql($id_pemohon));
			if($rsu->EOF){ 
				$sqlu = "INSERT INTO $schema2.`calon_sijil`(`id_pemohon`, `jenis_sijil`, `sijil_nama`, `sijil_size`, `sijil_type`, `dt_create`) 
				VALUES('{$id_pemohon}', '{$typeC}', '{$final_image}', ".tosql($sijil_size).", '{$sijil_type}', '{$dt}')";
			} else {
				$sqlu = "UPDATE $schema2.`calon_sijil` SET `sijil_nama`='{$final_image}', `sijil_size`=".tosql($sijil_size).", 
				`sijil_type`=".tosql($sijil_type).", `dt_update`='{$date}' WHERE `jenis_sijil`='{$typeC}' AND `id_pemohon`=".tosql($id_pemohon);				
			}			    
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

if($err=='OK'){
	set_tarikh($id_pemohon, "tkh_upd_akademik");
	clear_jawatan($id_pemohon);
}


// header("Content-Type: text/json");
// print json_encode($err); 
print $err;
?>
