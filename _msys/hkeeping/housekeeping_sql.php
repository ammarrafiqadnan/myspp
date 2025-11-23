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

function delete_pemohon($conn, $idp, $extra){
	// $conn->debug=true;
	$schema2='spp_calon';
	$rs = $conn->query("SELECT * FROM $schema2.`calon` WHERE `id_pemohon`=".tosql($idp));
	if(!$rs->EOF){
		$conn->execute("INSERT INTO $schema2.`archive_calon` 
			SELECT * FROM $schema2.`calon` WHERE `id_pemohon`=".tosql($idp));
		$conn->execute("INSERT INTO $schema2.`archive_calon_bakat_bahasa` 
			SELECT * FROM $schema2.`calon_bakat_bahasa` WHERE `id_pemohon`=".tosql($idp));
		$conn->execute("INSERT INTO $schema2.`archive_calon_bakat_detail` 
			SELECT * FROM $schema2.`calon_bakat_detail` WHERE `id_pemohon`=".tosql($idp));
		$conn->execute("INSERT INTO $schema2.`archive_calon_emel_reminder` 
			SELECT * FROM $schema2.`calon_emel_reminder` WHERE `id_pemohon`=".tosql($idp));
		$conn->execute("INSERT INTO $schema2.`archive_calon_gambar` 
			SELECT * FROM $schema2.`calon_gambar` WHERE `id_pemohon`=".tosql($idp));
		$conn->execute("INSERT INTO $schema2.`archive_calon_harta` 
			SELECT * FROM $schema2.`calon_harta` WHERE `id_pemohon`=".tosql($idp));
		$conn->execute("INSERT INTO $schema2.`archive_calon_ipt` 
			SELECT * FROM $schema2.`calon_ipt` WHERE `id_pemohon`=".tosql($idp));
		$conn->execute("INSERT INTO $schema2.`archive_calon_jawatan_dipohon` 
			SELECT * FROM $schema2.`calon_jawatan_dipohon` WHERE `id_pemohon`=".tosql($idp));
		$conn->execute("INSERT INTO $schema2.`archive_calon_ko_khas` 
			SELECT * FROM $schema2.`calon_ko_khas` WHERE `id_pemohon`=".tosql($idp));
		$conn->execute("INSERT INTO $schema2.`archive_calon_ko_persatuan` 
			SELECT * FROM $schema2.`calon_ko_persatuan` WHERE `id_pemohon`=".tosql($idp));
		$conn->execute("INSERT INTO $schema2.`archive_calon_ko_plkn` 
			SELECT * FROM $schema2.`calon_ko_plkn` WHERE `id_pemohon`=".tosql($idp));
		$conn->execute("INSERT INTO $schema2.`archive_calon_ko_rekacipta` 
			SELECT * FROM $schema2.`calon_ko_rekacipta` WHERE `id_pemohon`=".tosql($idp));
		$conn->execute("INSERT INTO $schema2.`archive_calon_ko_sukan` 
			SELECT * FROM $schema2.`calon_ko_sukan` WHERE `id_pemohon`=".tosql($idp));
		$conn->execute("INSERT INTO $schema2.`archive_calon_masih_khidmat` 
			SELECT * FROM $schema2.`calon_masih_khidmat` WHERE `id_pemohon`=".tosql($idp));
		$conn->execute("INSERT INTO $schema2.`archive_calon_matrik` 
			SELECT * FROM $schema2.`calon_matrik` WHERE `id_pemohon`=".tosql($idp));
		$conn->execute("INSERT INTO $schema2.`archive_calon_polis_ban_oku` 
			SELECT * FROM $schema2.`calon_polis_ban_oku` WHERE `id_pemohon`=".tosql($idp));
		$conn->execute("INSERT INTO $schema2.`archive_calon_pro_iktisas` 
			SELECT * FROM $schema2.`calon_pro_iktisas` WHERE `id_pemohon`=".tosql($idp));
		$conn->execute("INSERT INTO $schema2.`archive_calon_pusat_temuduga` 
			SELECT * FROM $schema2.`calon_pusat_temuduga` WHERE `id_pemohon`=".tosql($idp));
		$conn->execute("INSERT INTO $schema2.`archive_calon_sijil` 
			SELECT * FROM $schema2.`calon_sijil` WHERE `id_pemohon`=".tosql($idp));
		$conn->execute("INSERT INTO $schema2.`archive_calon_spm` 
			SELECT * FROM $schema2.`calon_spm` WHERE `id_pemohon`=".tosql($idp));
		$conn->execute("INSERT INTO $schema2.`archive_calon_srp` 
			SELECT * FROM $schema2.`calon_srp` WHERE `id_pemohon`=".tosql($idp));
		$conn->execute("INSERT INTO $schema2.`archive_calon_stp_stam` 
			SELECT * FROM $schema2.`calon_stp_stam` WHERE `id_pemohon`=".tosql($idp));
		$conn->execute("INSERT INTO $schema2.`archive_calon_svm` 
			SELECT * FROM $schema2.`calon_svm` WHERE `id_pemohon`=".tosql($idp));
		$conn->execute("INSERT INTO $schema2.`archive_calon_tambahan_lain` 
			SELECT * FROM $schema2.`calon_tambahan_lain` WHERE `id_pemohon`=".tosql($idp));
		$conn->execute("INSERT INTO $schema2.`archive_calon_tarikh` 
			SELECT * FROM $schema2.`calon_tarikh` WHERE `id_pemohon`=".tosql($idp));
		$conn->execute("INSERT INTO $schema2.`archive_calon_tarikh_sejarah` 
			SELECT * FROM $schema2.`calon_tarikh_sejarah` WHERE `id_pemohon`=".tosql($idp));
		$conn->execute("INSERT INTO $schema2.`archive_myid` 
			SELECT * FROM $schema2.`myid` WHERE `id_pemohon`=".tosql($idp));


		// DELETE DATA FROM DATABASE
		$conn->execute("DELETE FROM $schema2.`myid` WHERE `id_pemohon`=".tosql($idp));
		$conn->execute("DELETE FROM $schema2.`calon_tarikh_sejarah` WHERE `id_pemohon`=".tosql($idp));
		$conn->execute("DELETE FROM $schema2.`calon_tarikh` WHERE `id_pemohon`=".tosql($idp));
		$conn->execute("DELETE FROM $schema2.`calon_tambahan_lain` WHERE `id_pemohon`=".tosql($idp));
		$conn->execute("DELETE FROM $schema2.`calon_svm` WHERE `id_pemohon`=".tosql($idp));
		$conn->execute("DELETE FROM $schema2.`calon_stp_stam` WHERE `id_pemohon`=".tosql($idp));
		$conn->execute("DELETE FROM $schema2.`calon_srp` WHERE `id_pemohon`=".tosql($idp));
		$conn->execute("DELETE FROM $schema2.`calon_spm` WHERE `id_pemohon`=".tosql($idp));
		$conn->execute("DELETE FROM $schema2.`calon_sijil` WHERE `id_pemohon`=".tosql($idp));
		$conn->execute("DELETE FROM $schema2.`calon_pusat_temuduga` WHERE `id_pemohon`=".tosql($idp));
		$conn->execute("DELETE FROM $schema2.`calon_pro_iktisas` WHERE `id_pemohon`=".tosql($idp));
		$conn->execute("DELETE FROM $schema2.`calon_polis_ban_oku` WHERE `id_pemohon`=".tosql($idp));
		$conn->execute("DELETE FROM $schema2.`calon_null_login` WHERE `id_pemohon`=".tosql($idp));
		$conn->execute("DELETE FROM $schema2.`calon_matrik` WHERE `id_pemohon`=".tosql($idp));
		$conn->execute("DELETE FROM $schema2.`calon_masih_khidmat` WHERE `id_pemohon`=".tosql($idp));
		$conn->execute("DELETE FROM $schema2.`calon_ko_sukan` WHERE `id_pemohon`=".tosql($idp));
		$conn->execute("DELETE FROM $schema2.`calon_ko_rekacipta` WHERE `id_pemohon`=".tosql($idp));
		$conn->execute("DELETE FROM $schema2.`calon_ko_plkn` WHERE `id_pemohon`=".tosql($idp));
		$conn->execute("DELETE FROM $schema2.`calon_ko_persatuan` WHERE `id_pemohon`=".tosql($idp));
		$conn->execute("DELETE FROM $schema2.`calon_ko_khas` WHERE `id_pemohon`=".tosql($idp));
		$conn->execute("DELETE FROM $schema2.`calon_jawatan_dipohon` WHERE `id_pemohon`=".tosql($idp));
		$conn->execute("DELETE FROM $schema2.`calon_ipt` WHERE `id_pemohon`=".tosql($idp));
		$conn->execute("DELETE FROM $schema2.`calon_harta` WHERE `id_pemohon`=".tosql($idp));
		$conn->execute("DELETE FROM $schema2.`calon_gambar` WHERE `id_pemohon`=".tosql($idp));
		$conn->execute("DELETE FROM $schema2.`calon_emel_reminder` WHERE `id_pemohon`=".tosql($idp));
		$conn->execute("DELETE FROM $schema2.`calon_bakat_detail` WHERE `id_pemohon`=".tosql($idp));
		$conn->execute("DELETE FROM $schema2.`calon_bakat_bahasa` WHERE `id_pemohon`=".tosql($idp));
		$conn->execute("DELETE FROM $schema2.`calon` WHERE `id_pemohon`=".tosql($idp));

		if($extra=='L'){ 
			delete_lampiran($idp);
		}

	}		

}

function delete_lampiran($folder){

	$filename = "/var/www/upload/" . $folder . "/";
	//$filename = "D:/xampp/upload_ip/" . $folder . "/";
	// print $filename."<br>";

	if (file_exists($filename)) {
	    // echo "The directory $filename exists.<br>";
	    array_map('unlink', glob("$filename/*.*"));
	    rmdir($filename);
	}

}


if($frm=='S'){

	$idp=isset($_GET["idp"])?$_GET["idp"]:"";
	if($pro=='D'){
	
		delete_pemohon($conn,$idp,'');

	} else if($pro=='L'){

		delete_lampiran($idp);

	} else if($pro=='A'){

		delete_pemohon($conn,$idp,'L');

	}

} else if($frm='ALL'){

	$datas=isset($_GET["datas"])?$_GET["datas"]:"";
	$status=isset($_REQUEST["status"])?$_REQUEST["status"]:"";
	$tkh_mula=isset($_REQUEST["tkh_mula"])?$_REQUEST["tkh_mula"]:"";
	$tkh_akhir=isset($_REQUEST["tkh_akhir"])?$_REQUEST["tkh_akhir"]:"";
	$carian=isset($_REQUEST["carian"])?$_REQUEST["carian"]:"";

	$sql = "SELECT A.id_pemohon FROM $schema2.calon A WHERE A.id_pemohon IS NOT NULL ";

    if(!empty($status)){
        if($status == 1){
            //$sql .= " AND A.pengakuan='Y' AND A.status_pemohon='Y'";
        	$sql .= " AND A.pengakuan='Y'";
            if(!empty($tkh_mula)){
                if(!empty($tkh_akhir)){
                    // $sql .= " AND date(A.tarikh_akuan) BETWEEN ".tosql($tkh_mula)." AND ".tosql($tkh_akhir)."";
                    $sql .= " AND (date(A.d_cipta) BETWEEN ".tosql($tkh_mula)." AND ".tosql($tkh_akhir)." OR date(A.d_kemaskini) BETWEEN ".tosql($tkh_mula)." AND ".tosql($tkh_akhir).")";
                } else {
                    $sql .= " AND date(A.tarikh_akuan) LIKE ".tosql($tkh_mula)."";
                }
            } else {
                // $sql .= " AND (year(A.d_cipta) LIKE ".tosql($currYear)." OR year(A.d_kemaskini) LIKE ".tosql($currYear).")";
            }

        } else if($status == 2){
            $sql .= " AND A.pengakuan IS NULL"; // AND A.status_pemohon IS NULL";
            if(!empty($tkh_mula)){
                if(!empty($tkh_akhir)){
                    $sql .= " AND (date(A.d_cipta) BETWEEN ".tosql($tkh_mula)." AND ".tosql($tkh_akhir)." OR date(A.d_kemaskini) BETWEEN ".tosql($tkh_mula)." AND ".tosql($tkh_akhir).")";
                } else {
                    $sql .= " AND date(A.d_cipta) LIKE ".tosql($tkh_mula)."";
                }
            } else {
                // $sql .= " AND (year(A.d_cipta) LIKE ".tosql($currYear)." OR year(A.d_kemaskini) LIKE ".tosql($currYear).")";
            }
        } else if($status == 3){
            $sql .= " AND (A.pengakuan='Y' OR A.pengakuan IS NULL)";
            if(!empty($tkh_mula)){
                if(!empty($tkh_akhir)){
                    $sql .= " AND (date(A.d_cipta) BETWEEN ".tosql($tkh_mula)." AND ".tosql($tkh_akhir)." OR date(A.d_kemaskini) BETWEEN ".tosql($tkh_mula)." AND ".tosql($tkh_akhir).")";
                } else {
                    $sql .= " AND date(A.d_cipta) LIKE ".tosql($tkh_mula)."";
                }
            } else {
                // $sql .= " AND (year(A.d_cipta) LIKE ".tosql($currYear)." OR year(A.d_kemaskini) LIKE ".tosql($currYear).")";
            }
        }
    } else {
        //$sql .= " AND (A.pengakuan IS NULL OR A.pengakuan='Y')";
    }
    // }


    if(!empty($carian)){
        $sql .= " AND ((A.nama_penuh  LIKE '%".$carian."%') OR (A.ICNo  LIKE '%".$carian."%'))";
    }

    $sql .= " GROUP BY A.ICNo ORDER BY A.nama_penuh ASC";

    $rs = $conn->query($sql);
    while(!$rs->EOF){  

        $idp = $rs->fields['id_pemohon'];
        // print $idp."<br>";
		if($pro=='AD'){

    	    delete_pemohon($conn,$idp,'');
        
        } else if($pro=='AL'){
        
        	delete_lampiran($idp);
        
        } else if($pro=='AA'){
        
    	    delete_pemohon($conn,$idp,'L');
        
        }
        $rs->movenext();
    
    }

	$err='OK';

}
header("Content-Type: text/json");
print json_encode($err); 
// print $err;

?>