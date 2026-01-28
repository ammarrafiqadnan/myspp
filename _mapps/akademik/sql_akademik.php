<?php
session_start();
@include_once '../../connection/common.php';
$frm=isset($_GET["frm"])?$_GET["frm"]:"";
$pro=isset($_GET["pro"])?$_GET["pro"]:"";
$date=date("Y-m-d H:i:s");
//$oleh=$_SESSION['SESS_UID'];
// $conn->debug=true;
// print $frm.":".$pro;  

// ... code atas kekal ...

function callKptSkpgApi($no_kp)
{
    $url = 'http://10.29.53.228/api/kpt/skpg';
    // Token dari curl yang anda beri
    $token = 'I4ITysnunS2qUw0qHc1hu14bO70WAT8Q7te9QnBJ23fdd7cb'; 

    $payload = ["no_kp" => $no_kp];

    $ch = curl_init($url);

    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        // UBAH 1: Guna CUSTOMREQUEST 'GET' sebab Postman anda guna GET
        CURLOPT_CUSTOMREQUEST => 'GET', 
        // Walaupun GET, kita hantar body JSON sebab API anda perlukannya
        CURLOPT_POSTFIELDS => json_encode($payload),
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token,
        ],
        // UBAH 2: Naikkan timeout ke 60 saat (sebab anda kata lambat)
        CURLOPT_TIMEOUT => 60, 
        CURLOPT_CONNECTTIMEOUT => 10,
    ]);

    $response = curl_exec($ch);
    $error    = curl_error($ch); // Dapatkan error curl jika ada
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    curl_close($ch);

    // Debugging: Jika cURL fail (timeout atau network error)
    if ($response === false) {
        return [
            'success' => false,
            'data' => null,
            'curl_error' => $error // Hantar error supaya kita tahu kenapa
        ];
    }

    return [
        'success' => $httpCode >= 200 && $httpCode < 300,
        'data' => json_decode($response, true),
        'http_code' => $httpCode
    ];
}
// ... (Kod function callKptSkpgApi dan get_mapped_kpt_data KEKALKAN di atas) ...

// TAMBAH BLOK INI SEBELUM HUBUNGAN DATABASE DITUTUP ATAU SEBELUM PRINT $ERR
if ($frm == 'UNIV' && $pro == 'FETCH_UNIV_API') {
    global $schema1;
    $id_pemohon = $_POST['id_pemohon'];

    // Dapatkan No KP
    $no_kp = $_SESSION['SESS_UIC']; 

    // Panggil API
	$apiRes = callKptSkpgApi($no_kp);
    
    // UBAH SINI: Tambah check untuk curl_error
    if ($apiRes['success'] == false && !empty($apiRes['curl_error'])) {
        echo json_encode([
            'status' => 'ERR', 
            'msg' => 'Ralat sambungan API: ' . $apiRes['curl_error']
        ]);
        exit;
    }

    // Sambung logic asal...
    if ($apiRes['success'] && isset($apiRes['data']['data']) && is_array($apiRes['data']['data'])) {
        
        $mapped_list = [];
        foreach ($apiRes['data']['data'] as $row) {
            $mapped_row = [];

            // 1. Tahun
            $mapped_row['tahun'] = ($row['end_date']) ? date('Y', strtotime($row['end_date'])) : '';
            // 2. Tarikh Senat (Format DD/MM/YYYY untuk frontend display)
            $mapped_row['tkh_senate'] = ($row['end_date']) ? date('d/m/Y', strtotime($row['end_date'])) : '';
            // 3. Peringkat
            $mapped_row['peringkat'] = $row['level_course_id'];
            // 4. CGPA
            $mapped_row['cgpa'] = $row['CGPA'];
            
            // 5. Institusi (Mapping Kod & Nama)
            $id_univ_api = $row['id_univ'];
            $sql_inst = "SELECT KOD, DISKRIPSI FROM $schema1.ref_institusi WHERE KOD_INTEGRASI = " . tosql($id_univ_api) . " LIMIT 1";
            $rsInst = $conn->query($sql_inst);
            
            if ($rsInst && !$rsInst->EOF) {
                $mapped_row['inst_kod'] = $rsInst->fields['KOD'];
                $mapped_row['inst_nama'] = $rsInst->fields['DISKRIPSI'];
            } else {
                // Fallback jika mapping tiada
                $mapped_row['inst_kod'] = ''; 
                $mapped_row['inst_nama'] = $row['univ_long']; 
            }

            // 6. Nama Sijil / Pengkhususan
            $course_code_api = $row['course_code'];
            $sql_course = "SELECT A.kod_myspp, B.DISKRIPSI 
                           FROM $schema1.ref_pengkhususan_kpt_padanan A
                           JOIN $schema1.ref_pengkhususan B ON A.kod_myspp = B.kod
                           WHERE A.kod_kpt = " . tosql($course_code_api) . " LIMIT 1";
            $rsCourse = $conn->query($sql_course);

            if ($rsCourse && !$rsCourse->EOF) {
                $mapped_row['khusus_kod'] = $rsCourse->fields['kod_myspp'];
                $mapped_row['khusus_nama'] = $rsCourse->fields['DISKRIPSI'];
            } else {
                $mapped_row['khusus_kod'] = '';
                $mapped_row['khusus_nama'] = $row['course_long'];
            }

            $mapped_list[] = $mapped_row;
        }
        echo json_encode(['status' => 'OK', 'data' => $mapped_list]);
    } else {
        echo json_encode(['status' => 'ERR', 'msg' => 'Tiada data API dijumpai.']);
    }
    exit; // PENTING: Stop execution sini supaya tak print $err
}

// ... code bawah kekal ...

function callSvkspmApi(array $payload = [])
{
    $url = 'http://10.29.53.228/api/lpm/svkspm';
    $token = 'lQtew1bSNutZmJ3XXbEGgORyclKtuAF21x3myXgH4dfd73cb';

    $ch = curl_init($url);

    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($payload),
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Authorization: ' . 'Bearer ' . $token,
        ],
        CURLOPT_TIMEOUT => 30,
    ]);

    $response = curl_exec($ch);

    if ($response === false) {
        $error = curl_error($ch);
        curl_close($ch);
        return [
            'success' => false,
            'error' => $error,
        ];
    }

    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return [
        'success' => $httpCode >= 200 && $httpCode < 300,
        'http_code' => $httpCode,
        'data' => json_decode($response, true),
        'raw' => $response,
    ];
}

function callStpmMyGdxApi($no_kp, $tahun)
{
    $url = 'http://10.29.53.228/api/mygdx/stpm';
    $token = 'lQtew1bSNutZmJ3XXbEGgORyclKtuAF21x3myXgH4dfd73cb'; // Gunakan token anda

    $payload = [
        "no_kp" => $no_kp,
        "tahun" => (int)$tahun
    ];

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($payload),
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token,
        ],
        CURLOPT_TIMEOUT => 30,
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return [
        'success' => $httpCode >= 200 && $httpCode < 300,
        'data' => json_decode($response, true)
    ];
}

function callSvkspmulanganApi(array $payload = [])
{
    $url = 'http://10.29.53.228/api/lpm/svkspmulangan';
    // Masukkan token yang anda berikan di sini
    $token = 'lQtew1bSNutZmJ3XXbEGgORyclKtuAF21x3myXgH4dfd73cb'; 

    $ch = curl_init($url);

    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($payload),
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token, // Pastikan ada perkataan 'Bearer'
        ],
        CURLOPT_TIMEOUT => 30,
    ]);

    $response = curl_exec($ch);
    
    // Periksa jika ada error CURL
    if (curl_errno($ch)) {
        return ['success' => false, 'error' => curl_error($ch)];
    }

    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return [
        'success' => $httpCode >= 200 && $httpCode < 300,
        'http_code' => $httpCode,
        'data' => json_decode($response, true)
    ];
}

function clear_jawatan($uid){
	global $conn;
	global $schema2;

	$sql = "DELETE FROM $schema2.calon_jawatan_dipohon WHERE id_pemohon=".tosql($uid);
	$conn->execute($sql);
	$sql = "DELETE FROM $schema2.`calon_pusat_temuduga` WHERE id_pemohon=".tosql($uid);
	$conn->execute($sql);
	$sql = "UPDATE $schema2.`calon` SET `pengakuan`=NULL, `tarikh_akuan`=NULL, `status_pemohon`=NULL WHERE id_pemohon=".tosql($uid);
	$conn->execute($sql);
}

function get_pmr($conn, $uid){
	//$conn->debug=true;
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
    $sql = "SELECT * FROM $schema2.calon WHERE `id_pemohon`=".tosql($uid);
    $rs = $conn->query($sql);

    // --- FIX: AMBIL DATA INTEGRASI BERASINGAN UNTUK EXAM 1 & 2 ---
    
    // 1. Data Peperiksaan 1 (Jenis XM = 'B')
    $rsStpm1 = $conn->query("SELECT is_integrasi, angka_giliran FROM $schema2.calon_stp_stam 
                             WHERE id_pemohon=".tosql($uid)." AND jenis_xm='B' LIMIT 1");
    $integ_1 = $rsStpm1->EOF ? 'T' : $rsStpm1->fields['is_integrasi'];
    $akg_1   = $rsStpm1->EOF ? ''  : $rsStpm1->fields['angka_giliran'];

    // 2. Data Peperiksaan 2 (Jenis XM = 'BT')
    $rsStpm2 = $conn->query("SELECT is_integrasi, angka_giliran FROM $schema2.calon_stp_stam 
                             WHERE id_pemohon=".tosql($uid)." AND jenis_xm='BT' LIMIT 1");
    $integ_2 = $rsStpm2->EOF ? 'T' : $rsStpm2->fields['is_integrasi'];
    $akg_2   = $rsStpm2->EOF ? ''  : $rsStpm2->fields['angka_giliran'];

	$rsSpm1 = $conn->query("SELECT is_integrasi, angka_giliran FROM $schema2.calon_spm WHERE id_pemohon=".tosql($uid)." AND jenis_xm='1' LIMIT 1");
    $integ_spm1 = $rsSpm1->EOF ? 'T' : $rsSpm1->fields['is_integrasi']; // <-- FIX
    $akg_spm1   = $rsSpm1->EOF ? ''  : $rsSpm1->fields['angka_giliran'];

    // SPM 2 (jenis_xm = '2')
    $rsSpm2 = $conn->query("SELECT is_integrasi, angka_giliran FROM $schema2.calon_spm WHERE id_pemohon=".tosql($uid)." AND jenis_xm='T' LIMIT 1");
    $integ_spm2 = $rsSpm2->EOF ? 'T' : $rsSpm2->fields['is_integrasi']; // <-- FIX
    $akg_spm2   = $rsSpm2->EOF ? ''  : $rsSpm2->fields['angka_giliran'];
    
    // Data SPM (Untuk kegunaan lain jika perlu)
    // $rsSpm = $conn->query("SELECT is_integrasi, angka_giliran FROM $schema2.calon_spm WHERE id_pemohon=".tosql($uid)." LIMIT 1");

    $data = array(
        'id_pemohon'=> $rs->fields['id_pemohon'], 
        
        // Data SPM
		'spm_tahun_1'=> $rs->fields['spm_tahun_1'], 
        'spm_jenis_sijil_1'=> $rs->fields['spm_jenis_sijil_1'], 
        'spm_pangkat_1'=> $rs->fields['spm_pangkat_1'], 
        'spm_lisan_1'=> $rs->fields['spm_lisan_1'],
        'spm_tahun_2'=> $rs->fields['spm_tahun_2'], 
        'spm_jenis_sijil_2'=> $rs->fields['spm_jenis_sijil_2'], 
        'spm_pangkat_2'=> $rs->fields['spm_pangkat_2'], 
        
        // Integrasi SPM
        'is_integrasi_spm1' => $integ_spm1, 
        'angka_giliran_spm1' => $akg_spm1,
        'is_integrasi_spm2' => $integ_spm2, 
        'angka_giliran_spm2' => $akg_spm2,
        // Data STPM 1
        'stp_tahun_1'=> $rs->fields['stp_tahun_1'], 
        'stp_jenis_1'=> $rs->fields['stp_jenis_1'], 
        'stp_pangkat_1'=> $rs->fields['stp_pangkat_1'],
        'is_integrasi_stpm1' => $integ_1, // <--- Variable Baru
        'angka_giliran_stpm1' => $akg_1,  // <--- Variable Baru

        // Data STPM 2
        'stp_tahun_2'=> $rs->fields['stp_tahun_2'], 
        'stp_jenis_2'=> $rs->fields['stp_jenis_2'], 
        'stp_pangkat_2'=> $rs->fields['stp_pangkat_2'], 
        'is_integrasi_stpm2' => $integ_2, // <--- Variable Baru
        'angka_giliran_stpm2' => $akg_2,  // <--- Variable Baru

        // Data STAM
        'stam_tahun_1'=> $rs->fields['stam_tahun_1'], 
        'stam_jenis_1'=> $rs->fields['stam_jenis_1'], 
        'stam_pangkat_1'=> $rs->fields['stam_pangkat_1'],  
        'stam_tahun_2'=> $rs->fields['stam_tahun_2'], 
        'stam_jenis_2'=> $rs->fields['stam_jenis_2'], 
        'stam_pangkat_2'=> $rs->fields['stam_pangkat_2']  
    ); 

	return $data;
}

function get_pmr_result($conn, $uid, $kod, $tahun){
	//$conn->debug=true;
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
	//$conn->debug=true;
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

if($frm=='STPM' && $pro=='FETCH_STPM'){
    $id_pemohon = $_POST['id_pemohon'];
    $tahun = $_POST['stp_tahun'];

    // --- BAHAGIAN HARDCODE UNTUK TESTING ---
    $no_kp = $_SESSION['SESS_UIC']; 
    // Jika nanti nak guna yang betul semula, baru buka komen di bawah:
    /*
    $rsIC = $conn->query("SELECT ICNo FROM $schema2.calon WHERE id_pemohon=".tosql($id_pemohon));
    $no_kp = $rsIC->fields['ICNo'];
    */
    // ---------------------------------------

    $apiResult = callStpmMyGdxApi($no_kp, $tahun);

    if($apiResult['success']){
        // Navigasi ke dalam struktur JSON MyGDX
        $dataResponse = $apiResult['data']['soapenv:Body']['v1:MPM-SSKSM-R-MPMFikSTPMResponse'];
        
        if(isset($dataResponse['data']) && !empty($dataResponse['data']['akg'])){
            echo json_encode([
                'status' => 'OK',
                'data' => $dataResponse['data']
            ]);
        } else {
            echo json_encode(['status' => 'ERR', 'msg' => 'Data tidak dijumpai untuk IC dan Tahun tersebut.']);
        }
    } else {
        echo json_encode(['status' => 'ERR', 'msg' => 'Ralat pada sambungan API MyGDX.']);
    }
    exit;
}

if($frm == 'ULANGAN' && $pro == 'FETCH_ULANGAN'){
    $no_kp = "000320020757"; // Hardcode untuk testing
    $tahun = $_POST['tahun'];
    $akg = $_POST['akg'];

    $payload = [
        "no_kp" => $no_kp,
        "tahun" => (int)$tahun,
        "angka_giliran" => $akg
    ];

    $result = callSvkspmulanganApi($payload);

    if($result['success'] && !empty($result['data'])){
        $api_data = $result['data'][0]['data']; // Ambil array subjek
        $mapped_data = [];

        foreach($api_data as $row) {
            $kod_dari_api = $row['kod'];
            $gred_dari_api = trim($row['gred']);

            // CARI MAPPING DALAM DB
            // Cari mpel_kod berdasarkan kod_integrasi
            $sql_map = "SELECT mpel_kod FROM $schema1.ref_paper_julai 
                        WHERE kod_integrasi = " . tosql($kod_dari_api);
            $rsMap = $conn->query($sql_map);

            if(!$rsMap->EOF) {
                // Jika jumpa, guna kod sistem kita (mpel_kod)
                $mapped_data[] = [
                    'kod'  => $rsMap->fields['mpel_kod'], 
                    'gred' => $gred_dari_api
                ];
            } else {
                // Jika tidak jumpa, hantar kod asal API (sebagai fallback)
                $mapped_data[] = [
                    'kod'  => $kod_dari_api,
                    'gred' => $gred_dari_api
                ];
            }
        }

        echo json_encode(['status' => 'OK', 'data' => $mapped_data]);
    } else {
        echo json_encode(['status' => 'ERR', 'msg' => 'Keputusan tidak dijumpai.']);
    }
    exit;
}

function callSvmApi(array $payload = [])
{
    $url = 'http://10.29.53.228/api/lpm/svm';
    $token = 'I4ITysnunS2qUw0qHc1hu14bO70WAT8Q7te9QnBJ23fdd7cb'; 

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($payload),
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token,
        ],
        CURLOPT_TIMEOUT => 30,
        CURLOPT_SSL_VERIFYPEER => false, // Tambah ini jika server ada masalah SSL cert
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return [
        'success' => ($httpCode == 200),
        'data' => json_decode($response, true)
    ];
}

// Logik untuk FETCH SVM
if($frm=='SVM' && $pro=='FETCH_SVM'){
    $id_pemohon = $_POST['id_pemohon'];
    $angkaGiliran = $_POST['angkaGiliran'];

    // Hardcode IC untuk testing
    $no_ic = "071201110395"; 
    /* $rsIC = $conn->query("SELECT ICNo FROM $schema2.calon WHERE id_pemohon=".tosql($id_pemohon));
    $no_ic = $rsIC->fields['ICNo']; 
    */

    $payload = [
        "no_kp" => $no_ic,
        "angka_giliran" => $angkaGiliran
    ];

    $apiResult = callSvmApi($payload);

    if($apiResult['success'] && $apiResult['data']['status'] == "Berjaya"){
        echo json_encode(['status' => 'OK', 'data' => $apiResult['data']]);
    } else {
        $msg = isset($apiResult['data']['message']) ? $apiResult['data']['message'] : 'Data tidak dijumpai.';
        echo json_encode(['status' => 'ERR', 'msg' => $msg]);
    }
    exit;
}

if($frm=='SRP'){
	//$conn->debug=true;
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
					$rs = $conn->query("DELETE FROM $schema2.`calon_srp` WHERE `id_pemohon`=".tosql($id_pemohon));
				}
			}
		} else {
			$err='ERR'; 
		}

	} else if($pro=='SAVE'){
		//$conn->debug=true;
		$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
		$srp_tahun=isset($_REQUEST["srp_tahun"])?$_REQUEST["srp_tahun"]:"";
		$srp_tahun_pilih=isset($_REQUEST["srp_tahun_pilih"])?$_REQUEST["srp_tahun_pilih"]:"";
		$srp_jenis_sijil=isset($_REQUEST["srp_jenis_sijil"])?$_REQUEST["srp_jenis_sijil"]:"";
		$mp=isset($_REQUEST["mp"])?$_REQUEST["mp"]:"";
		$gred=isset($_REQUEST["gred"])?$_REQUEST["gred"]:"";
		$mp_old=isset($_REQUEST["mp_old"])?$_REQUEST["mp_old"]:"";
		$srp_id=isset($_REQUEST["srp_id"])?$_REQUEST["srp_id"]:"";
		$jsijil=1;

		//print $id_pemohon;

		$rsIC = $conn->query("SELECT ICNo FROM $schema2.calon WHERE id_pemohon=$id_pemohon");

		if(empty($srp_tahun) && !empty($srp_tahun_pilih)){ $srp_tahun=$srp_tahun_pilih; }

		$sqlu = "UPDATE $schema2.`calon` SET `srp_tahun`=".tosql($srp_tahun).", `srp_jenis_sijil`=".tosql($srp_jenis_sijil);	
		//if($ty=='R'){ $sqlu .= ", srp_jenis_sijil=NULL, srp_pangkat=NULL "; } 
		$sqlu .= " WHERE `id_pemohon`=".tosql($id_pemohon);
		$rss = $conn->execute($sqlu);

		// print_r($mp); exit;
		// $subj = "'002'";
		for($i=0;$i<=11;$i++){
			$dt = date("Y-m-d H:i:s");

			if(!empty($mp[$i]) && !empty($gred[$i])){
				$rs = $conn->query("SELECT * FROM $schema2.`calon_srp` WHERE `jenis_sijil`=".tosql($srp_jenis_sijil)." AND `id_pemohon`=".tosql($id_pemohon)." AND `tahun`=".tosql($srp_tahun)." AND `matapelajaran`=".tosql($mp_old[$i]));
				if($rs->EOF){
					$srp_id = date("YmdHisN").uniqid();
					$sql = "INSERT INTO $schema2.`calon_srp`(`srp_id`, `id_pemohon`, `tahun`, `matapelajaran`, `jenis_sijil`, `gred`, `d_cipta`)";
					$sql .= " VALUES('{$srp_id}', ".tosql($id_pemohon).",".tosql($srp_tahun).",".tosql($mp[$i]).",".tosql($srp_jenis_sijil).",".tosql($gred[$i]).",".tosql($dt).")";
				} else {
					$sql = "UPDATE $schema2.`calon_srp` SET `matapelajaran`=".tosql($mp[$i]).", `gred`=".tosql($gred[$i]).", d_kemaskini=".tosql($dt)." WHERE `id_pemohon`=".tosql($id_pemohon)." AND `tahun`=".tosql($srp_tahun)." AND `matapelajaran`=".tosql($mp_old[$i]);
				}
				// print "AAAA".$sql."<br><br>";
				$conn->execute($sql);
			}
			$err='OK';
		}

		if(!empty($_FILES['file_pmr']['name'])){ 
			//$conn->debug=true;
			$type='PMR';
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif','pdf','JPEG', 'JPG', 'PNG', 'GIF','PDF'); // valid extensions
	        $path = '/var/www/upload/'.$id_pemohon.'/'; // upload directory
	        if (file_exists($path)) {
	            $path = $path;
	        } else {
	            mkdir($path);
	            $path = '/var/www/upload/'.$id_pemohon.'/';
	        }

	        $img = $_FILES['file_pmr']['name'];
	        $tmp = $_FILES['file_pmr']['tmp_name'];
	        
	        $ext = end((explode(".", $img))); 
	        // $fname = $img; //$id.".".$ext;
	        // $fname = str_replace(" ", "_", $fname);
	        // $fname = str_replace("-", "_", $fname);

	        // $final_image = "docSenaraiSemak_D3_1_".$appli_id2."_".$item_id.".".$ext;
	        // $final_image = rand(1000,1000000)."_".$fname;
		if(empty($type)){ $type='png'; }
	        $final_image = strtolower($rsIC->fields['ICNo']."_".$type.".".$ext);
	        $sijil_size = $_FILES['sijil_pmr']['size'];
	        $sijil_type = $_FILES['sijil_pmr']['type'];
			// check's valid format
			// $conn->debug=true;
			if(in_array($ext, $valid_extensions)){ 
				$path = $path.strtolower($final_image); 
				// print "n:".$path.'>'.$tmp; exit();
				//print $tmp.":".$path;
				move_uploaded_file($tmp,$path);
				// $err = $path;
				$dt = date("Y-m-d H:i:s");
				$upd_main='';
				$rsu = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='PMR' AND `id_pemohon`=".tosql($id_pemohon));
				if($rsu->EOF){ 
					$sqlu = "INSERT INTO $schema2.`calon_sijil`(`id_pemohon`, `jenis_sijil`, `sijil_nama`, `sijil_size`, `sijil_type`, `dt_create`) 
					VALUES('{$id_pemohon}', '{$type}', '{$final_image}', ".tosql($sijil_size).", ".tosql($sijil_type).", '{$dt}')";
				} else {
					$sqlu = "UPDATE $schema2.`calon_sijil` SET `sijil_nama`='{$final_image}', `sijil_size`=".tosql($sijil_size).", 
					`sijil_type`=".tosql($sijil_type).", `dt_update`='{$date}' WHERE `jenis_sijil`='PMR' AND `id_pemohon`=".tosql($id_pemohon);				
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

	} else if($pro=='SRP_DEL_REC'){

		$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
		$srp_tahun_pilih=isset($_REQUEST["srp_tahun_pilih"])?$_REQUEST["srp_tahun_pilih"]:"";
		$mp=isset($_REQUEST["mpp"])?$_REQUEST["mpp"]:"";
		$sid=isset($_REQUEST["sid"])?$_REQUEST["sid"]:"";

		$sql = "DELETE FROM $schema2.`calon_srp` WHERE `id_pemohon`=".tosql($id_pemohon)." AND `tahun`=".tosql($srp_tahun_pilih)." AND `srp_id`=".tosql($sid);
		// print $sql;
		$rss = $conn->execute($sql);
		if($rss){ 	
		    $err='OK';
		    clear_jawatan($id_pemohon);
		} else {
			$err='ERR';
		}

	} else if($pro=='SRP_DEL'){

		$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";

		$rss = $conn->execute("UPDATE $schema2.`calon` SET `srp_tahun`=NULL, `srp_jenis_sijil`=NULL, `srp_pangkat`=NULL WHERE `id_pemohon`=".tosql($id_pemohon));
		if($rss){ 	
		    $err='OK';
		    $conn->execute("DELETE FROM $schema2.`calon_srp` WHERE `id_pemohon`=".tosql($id_pemohon));

			$rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='PMR' AND `id_pemohon`=".tosql($id_pemohon));
			if(!$rsSijil->EOF){
		        $files = '/var/www/upload/'.$id_pemohon.'/'.$rsSijil->fields['sijil_nama']; // upload directory
				$conn->execute("DELETE FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='PMR' AND `id_pemohon`=".tosql($id_pemohon));
				unlink($files);
			}

			//if($err=='OK'){
				//$sql = "$schema2.`calon_jawatan_dipohon` WHERE `id_pemohon`=".tosql($id_pemohon);
				//$conn->execute($sql);
				
			//}

		     clear_jawatan($id_pemohon);
		} else { 
			$err = 'ERR'; 
		}
	}
	
} else if($frm=='SPM'){

    if($pro=='SVKSPM_API'){

        $body = file_get_contents('php://input');
        $jsonPayload = json_decode($body, true);

        $no_kp = $_SESSION['SESS_UIC']; 
        $tahun = $jsonPayload['tahun'] ?? $_REQUEST['tahun'] ?? '';
        $angka_giliran = $jsonPayload['angka_giliran'] ?? $_REQUEST['angka_giliran'] ?? '';

        $payload = [
            'no_kp' => $no_kp,
            'tahun' => $tahun,
            'angka_giliran' => $angka_giliran,
        ];

        // Panggil fungsi API integrasi sedia ada
        $result = callSvkspmApi($payload);

        // --- MULA LOGIK MAPPING ---
        if ($result['success'] && !empty($result['data'])) {
            // Ambil array 'data' matapelajaran dari JSON API (biasanya index 0)
            $apiData = $result['data'][0]['data'];
            $mappedData = [];

            foreach ($apiData as $row) {
                $kodIntegrasi = $row['kod'];
                
                $gredClean = trim($row['gred']); 
                $row['gred'] = $gredClean; // Assign semula nilai yang bersih ke dalam row

                // Cari kod sistem berdasarkan kod_integrasi dalam table ref_matapelajaran
                $sql_map = "SELECT kod, diskripsi FROM $schema1.ref_matapelajaran 
                            WHERE kod_integrasi = " . tosql($kodIntegrasi) . " 
                            AND TKT = '5' LIMIT 1";
                
                $rsMap = $conn->query($sql_map);

                if (!$rsMap->EOF) {
                    $row['kod_sistem'] = $rsMap->fields['kod'];
                    $row['nama_sistem'] = $rsMap->fields['diskripsi'];
                } else {
                    $row['kod_sistem'] = $kodIntegrasi; 
                    $row['nama_sistem'] = $row['nama']; 
                }
                
                $mappedData[] = $row;
            }

            $result['data'][0]['data'] = $mappedData;
        }

        header('Content-Type: application/json');
        echo json_encode($result);
        exit;
		
    } else if($pro=='AWAL'){

		$actions=isset($_REQUEST["actions"])?$_REQUEST["actions"]:"";
		if($actions==1){ 
			$_SESSION['SESS_SPMSIJIL']=isset($_REQUEST["spm_jenis_sijil_1"])?$_REQUEST["spm_jenis_sijil_1"]:"";
			$_SESSION['SESS_SPMTAHUN']=isset($_REQUEST["spm_tahun_1"])?$_REQUEST["spm_tahun_1"]:"";
		} else {
			$_SESSION['SESS_SPMSIJIL2']=isset($_REQUEST["spm_jenis_sijil_1"])?$_REQUEST["spm_jenis_sijil_1"]:"";
			$_SESSION['SESS_SPMTAHUN2']=isset($_REQUEST["spm_tahun_1"])?$_REQUEST["spm_tahun_1"]:"";
		}
	} else if($pro=='SPM_DELALL'){
		$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
		//DELETE SEMUA MAKLUMAt KELULUSAN SPM
		$rss = $conn->execute("UPDATE $schema2.`calon` SET `spm_tahun_1`=NULL, `spm_jenis_sijil_1`=NULL, `spm_pangkat_1`=NULL, `spm_lisan_1`=NULL,
			`spm_tahun_2`=NULL, `spm_jenis_sijil_2`=NULL, `spm_pangkat_2`=NULL  
			WHERE `id_pemohon`=".tosql($id_pemohon));

		if($rss){
			// $err='OK';
			$rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil` IN ('SPM1','SPM2','SVM1','SVM2') AND `id_pemohon`=".tosql($id_pemohon));
			if(!$rsSijil->EOF){
				while(!$rsSijil->EOF){
		        		$files = '/var/www/upload/'.$id_pemohon.'/'.$rsSijil->fields['sijil_nama']; // upload directory
					unlink($files);
					$rsSijil->movenext();
				}
				$conn->execute("DELETE FROM $schema2.`calon_sijil` WHERE `jenis_sijil` LIKE 'SPM%' AND `id_pemohon`=".tosql($id_pemohon));

				$conn->execute("DELETE FROM $schema2.`calon_sijil` WHERE `jenis_sijil` LIKE 'SVM%' AND `id_pemohon`=".tosql($id_pemohon));
			}
			$err='OK'; //;index.php?data='.base64_encode('akademik/spm;MAKLUMAT AKADEMIK;Maklumat SPM/SPVM/SPM(V);;1;;');
			$sqld = "DELETE FROM $schema2.`calon_spm` WHERE `id_pemohon`=".tosql($id_pemohon);
			$conn->execute($sqld);

			$sqld2 = "DELETE FROM $schema2.`calon_svm` WHERE `id_pemohon`=".tosql($id_pemohon);
			$conn->execute($sqld2);
			
			$_SESSION['SESS_SPMSIJIL']="";
			$_SESSION['SESS_SPMTAHUN']="";
			$_SESSION['SESS_SPMSIJIL2']="";
			$_SESSION['SESS_SPMTAHUN2']="";
			clear_jawatan($id_pemohon);

		} else {
			$err='ERR';
		}

	   } else if($pro=='UPDATE'){
		$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
		$fields=isset($_REQUEST["fields"])?$_REQUEST["fields"]:"";
		$vals=isset($_REQUEST["vals"])?$_REQUEST["vals"]:"";
		$ty=isset($_REQUEST["ty"])?$_REQUEST["ty"]:"";
		$actions=isset($_REQUEST["actions"])?$_REQUEST["actions"]:"";

		// if(!empty($id_pemohon)){

		// 	$sqlu = "UPDATE $schema2.`calon` SET $fields=".tosql($vals);
		// 	if($ty=='R' && $fields=='spm_tahun_1'){ $sqlu .= ", spm_jenis_sijil_1=NULL, spm_pangkat_1=NULL, spm_lisan_1=NULL "; } 
		// 	else if($ty=='R' && $fields=='spm_tahun_2'){ $sqlu .= ", spm_jenis_sijil_2=NULL, spm_pangkat_2=NULL "; } 
		// 	$sqlu .= " WHERE `id_pemohon`=".tosql($id_pemohon);
		// 	$rss = $conn->execute($sqlu);

		// }

		if(!empty($actions) && $actions=='1'){ 
	
			$spm_jenis_sijil_1=isset($_REQUEST["spm_jenis_sijil_1"])?$_REQUEST["spm_jenis_sijil_1"]:"";
			$spm_tahun_1=isset($_REQUEST["spm_tahun_1"])?$_REQUEST["spm_tahun_1"]:"";
			$spm_lisan_1=isset($_REQUEST["spm_lisan_1"])?$_REQUEST["spm_lisan_1"]:"";

			//$sql = "UPDATE $schema2.calon  SET spm_jenis_sijil_1=".tosql($spm_jenis_sijil_1).", spm_lisan_1=".tosql($spm_lisan_1)." WHERE `id_pemohon`=".tosql($id_pemohon);
			$sql = "UPDATE $schema2.calon  SET spm_jenis_sijil_1=".tosql($spm_jenis_sijil_1).", spm_tahun_1=".tosql($spm_tahun_1)." WHERE `id_pemohon`=".tosql($id_pemohon);
			
			if(!empty($spm_tahun_1)){
				$sql = "UPDATE $schema2.calon  SET spm_jenis_sijil_1=".tosql($spm_jenis_sijil_1).", spm_tahun_1=".tosql($spm_tahun_1)." WHERE `id_pemohon`=".tosql($id_pemohon);
			} else {
				$sql = "UPDATE $schema2.calon  SET spm_jenis_sijil_1=NULL, spm_tahun_1=NULL WHERE `id_pemohon`=".tosql($id_pemohon);
			}

			// spm_tahun_1=".tosql($spm_tahun_1).", 
	
		} else if(!empty($actions) && $actions=='2'){ 
	
			$spm_jenis_sijil_1=isset($_REQUEST["spm_jenis_sijil_1"])?$_REQUEST["spm_jenis_sijil_1"]:"";
			$spm_tahun_1=isset($_REQUEST["spm_tahun_1"])?$_REQUEST["spm_tahun_1"]:"";
			//$spm_lisan_1=isset($_REQUEST["spm_lisan_1"])?$_REQUEST["spm_lisan_1"]:"";

			//$sql = "UPDATE $schema2.calon  SET spm_jenis_sijil_2=".tosql($spm_jenis_sijil_1).", spm_lisan_2=".tosql($spm_lisan_1)."  WHERE `id_pemohon`=".tosql($id_pemohon);
			if(!empty($spm_tahun_1)){
				$sql = "UPDATE $schema2.calon  SET spm_jenis_sijil_2=".tosql($spm_jenis_sijil_1).", spm_tahun_2=".tosql($spm_tahun_1)."  WHERE `id_pemohon`=".tosql($id_pemohon);
			} else {
				$sql = "UPDATE $schema2.calon  SET spm_jenis_sijil_2=NULL, spm_tahun_2=NULL  WHERE `id_pemohon`=".tosql($id_pemohon);
			}
			// /spm_tahun_2=".tosql($spm_tahun_1).",
	
		}
		$rss = $conn->execute($sql);
		//$conn->debug=false;

		if($rss){
			$err='OK';
			// if($ty=='R' && $fields=='spm_tahun_1'){ 
			// 	$rs = $conn->query("SELECT * FROM $schema2.`calon_spm` WHERE `jenis_xm`='1' AND `id_pemohon`=".tosql($id_pemohon));
			// 	if(!$rs->EOF){
			// 		$conn->execute("UPDATE $schema2.`calon_spm` SET `tahun`=".tosql($vals)." WHERE `jenis_xm`='1' AND `id_pemohon`=".tosql($id_pemohon));
			// 	}
			// } else if($ty=='R' && $fields=='spm_tahun_2'){ 
			// 	$rs = $conn->query("SELECT * FROM $schema2.`calon_spm` WHERE `jenis_xm`='T' AND `id_pemohon`=".tosql($id_pemohon));
			// 	if(!$rs->EOF){
			// 		$conn->execute("UPDATE $schema2.`calon_spm` SET `tahun`=".tosql($vals)." WHERE `jenis_xm`='T' AND `id_pemohon`=".tosql($id_pemohon));
			// 	}
			// }
		} else {
			$err='ERR'; 
		}

	} else if($pro=='ADD'){

		$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
		$tahun_add=isset($_REQUEST["tahun_add"])?$_REQUEST["tahun_add"]:"";

		$rss = $conn->execute("UPDATE $schema2.`calon` SET `spm_tahun_2`=".tosql($tahun_add)." WHERE `id_pemohon`=".tosql($id_pemohon));

		if($rss){
			$err='OK;index.php?data='.base64_encode('akademik/spm;MAKLUMAT AKADEMIK;Maklumat SPM/SPVM/SPM(V);;2;;');
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
		        $files = '/var/www/upload/'.$id_pemohon.'/'.$rsSijil->fields['sijil_nama']; // upload directory
				$conn->execute("DELETE FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='SPM2' AND `id_pemohon`=".tosql($id_pemohon));
				unlink($files);
			}
			$err='OK;index.php?data='.base64_encode('akademik/spm;MAKLUMAT AKADEMIK;Maklumat SPM/SPVM/SPM(V);;1;;');
			$sqld = "DELETE FROM $schema2.`calon_spm` WHERE `jenis_xm`='T' AND `id_pemohon`=".tosql($id_pemohon);
			$conn->execute($sqld);

			
			$_SESSION['SESS_SPMSIJIL']="";
			$_SESSION['SESS_SPMTAHUN']="";
			$_SESSION['SESS_SPMSIJIL2']="";
			$_SESSION['SESS_SPMTAHUN2']="";
			//if($err=='OK'){
				//$sql = "$schema2.`calon_jawatan_dipohon` WHERE `id_pemohon`=".tosql($id_pemohon);
				//$conn->execute($sql);
			//}
			clear_jawatan($id_pemohon);
		} else {
			$err='ERR';
		}

	} else if($pro=='SAVE'){
        //$conn->debug=true;
        $actions=isset($_REQUEST["actions"])?$_REQUEST["actions"]:"";
        $id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
        $spm_tahun_1=isset($_REQUEST["spm_tahun_1"])?$_REQUEST["spm_tahun_1"]:"";
        $spm_tahun_2=isset($_REQUEST["spm_tahun_2"])?$_REQUEST["spm_tahun_2"]:"";
        $spm_jenis_sijil_1=isset($_REQUEST["spm_jenis_sijil_1"])?$_REQUEST["spm_jenis_sijil_1"]:"";
        $spm_jenis_sijil_2=isset($_REQUEST["spm_jenis_sijil_2"])?$_REQUEST["spm_jenis_sijil_2"]:"";
        $spm_lisan_1=isset($_REQUEST["spm_lisan_1"])?$_REQUEST["spm_lisan_1"]:"";

        // --- DATA BARU UNTUK DISIMPAN ---
        $akg_spm = isset($_REQUEST["spm_angka_giliran"])?$_REQUEST["spm_angka_giliran"]:"";
        $is_integrasi = isset($_REQUEST["is_integrasi_input"])?$_REQUEST["is_integrasi_input"]:"T";

        $mp=isset($_REQUEST["mp_1"])?$_REQUEST["mp_1"]:"";
        $gred=isset($_REQUEST["gred_1"])?$_REQUEST["gred_1"]:"";
        
        $spm_tahun_pilih=isset($_REQUEST["spm_tahun_pilih"])?$_REQUEST["spm_tahun_pilih"]:"";
        $spm_sijil_pilih=isset($_REQUEST["spm_sijil_pilih"])?$_REQUEST["spm_sijil_pilih"]:"";
        $mp_old=isset($_REQUEST["mp_old"])?$_REQUEST["mp_old"]:"";

        if(empty($spm_tahun_pilih)){ $spm_tahun_pilih=$spm_tahun_1; }
        if(empty($spm_sijil_pilih)){ $spm_sijil_pilih=$spm_jenis_sijil_1; }

        $jsijil=1;

        // 1. UPDATE TABLE CALON (MAKLUMAT ASAS)
        if($actions==1){ 
            $spm_pangkat_1=isset($_REQUEST["spm_pangkat_1"])?$_REQUEST["spm_pangkat_1"]:"";
            $sql = "UPDATE $schema2.calon SET spm_tahun_1=".tosql($spm_tahun_pilih).", spm_jenis_sijil_1=".tosql($spm_sijil_pilih).", 
            spm_pangkat_1=".tosql($spm_pangkat_1).", spm_lisan_1=".tosql($spm_lisan_1)." WHERE `id_pemohon`=".tosql($id_pemohon);
        } else if($actions==2){ 
            $spm_pangkat_2=isset($_REQUEST["spm_pangkat_2"])?$_REQUEST["spm_pangkat_2"]:"";
            $sql = "UPDATE $schema2.calon SET spm_tahun_2=".tosql($spm_tahun_pilih)." , spm_jenis_sijil_2=".tosql($spm_sijil_pilih).", 
            spm_pangkat_2=".tosql($spm_pangkat_2)." WHERE `id_pemohon`=".tosql($id_pemohon);
        }
        
        if(!empty($sql)){ $conn->execute($sql); }

        // 2. SIMPAN MATAPELAJARAN (TABLE CALON_SPM)
        if(!empty($spm_tahun_pilih)){ 
            // Tentukan jenis_xm (1=Sijil Pertama, 2=Sijil Kedua)
            $jenis_xm_db = ($actions == 1) ? '1' : '2';

            for($i=0; $i < count($mp); $i++){
                $dt = date("Y-m-d H:i:s");
                if(!empty($mp[$i]) && !empty($gred[$i])){

                    // Cari rekod sedia ada berdasarkan mp_old
                    $rs = $conn->query("SELECT spm_id FROM $schema2.`calon_spm` 
                                        WHERE `jenis_xm`=".tosql($jenis_xm_db)." 
                                        AND `id_pemohon`=".tosql($id_pemohon)." 
                                        AND `tahun`=".tosql($spm_tahun_pilih)." 
                                        AND `matapelajaran`=".tosql($mp_old[$i]));
                    
                    if($rs->EOF){
                        $spm_id = date("YmdHisN").uniqid();
                        // INSERT TERMASUK angka_giliran & is_integrasi
                        $sql = "INSERT INTO $schema2.`calon_spm`(`spm_id`, `id_pemohon`, `tahun`, `matapelajaran`, `jenis_sijil`, `gred`, `d_cipta`, `jenis_xm`, `angka_giliran`, `is_integrasi`)";
                        $sql .= " VALUES('{$spm_id}', ".tosql($id_pemohon).",".tosql($spm_tahun_pilih).",".tosql($mp[$i]).",".tosql($jsijil).",".tosql($gred[$i]).",".tosql($dt).", ".tosql($jenis_xm_db).", ".tosql($akg_spm).", ".tosql($is_integrasi).")";
                    } else {
                        // UPDATE TERMASUK angka_giliran & is_integrasi
                        $sql = "UPDATE $schema2.`calon_spm` SET 
                                `matapelajaran`=".tosql($mp[$i]).", 
                                `gred`=".tosql($gred[$i]).", 
                                `angka_giliran`=".tosql($akg_spm).", 
                                `is_integrasi`=".tosql($is_integrasi).", 
                                d_kemaskini=".tosql($dt)." 
                                WHERE `spm_id`=".tosql($rs->fields['spm_id']);
                    }
                    $conn->execute($sql);
                    $err='OK';
                }
            }
        }
		//$conn->debug=true;
		$rsIC = $conn->query("SELECT ICNo FROM $schema2.calon WHERE id_pemohon=$id_pemohon");

		//print $rsIC->fields['ICNo'];exit();

		// print "UPL:".$_FILES['file_pmr']['name'];
		//$sijil_pmr=isset($_REQUEST["sijil_pmr"])?$_REQUEST["sijil_pmr"]:"";
		if(!empty($_FILES['file_pmr']['name'])){ 
			// $conn->debug=true;
			// $type='PMR';
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif','JPEG', 'JPG', 'PNG', 'GIF','PDF'); // valid extensions
	        $path = '/var/www/upload/'.$id_pemohon.'/'; // upload directory
		//print $path;
	        if(file_exists($path)) {
	            $path = $path;
	        } else {
	            mkdir($path);
	            $path = '/var/www/upload/'.$id_pemohon.'/';
	        }

	        $img = $_FILES['file_pmr']['name'];
	        $tmp = $_FILES['file_pmr']['tmp_name'];
	        
	        $ext = end((explode(".", $img))); 
	        // $fname = $img; //$id.".".$ext;
	        // $fname = str_replace(" ", "_", $fname);
	        // $fname = str_replace("-", "_", $fname);

	        // $final_image = "docSenaraiSemak_D3_1_".$appli_id2."_".$item_id.".".$ext;
	        // $final_image = rand(1000,1000000)."_".$fname;
	        $final_image = strtolower($rsIC->fields['ICNo']."_".$type.".".$ext);
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
				$rs = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `id_pemohon`='{$id_pemohon}' AND `jenis_sijil`='{$type}'");
				if(!$rs->EOF){
					$sqlu = "UPDATE $schema2.`calon_sijil` SET `sijil_nama`='{$final_image}', `sijil_size`= ".tosql($sijil_size).", `sijil_type`='{$sijil_type}' 
					WHERE `id_pemohon`='{$id_pemohon}' AND `jenis_sijil`='{$type}'";
				} else { 
					$sqlu = "INSERT INTO $schema2.`calon_sijil`(`id_pemohon`, `jenis_sijil`, `sijil_nama`, `sijil_size`, `sijil_type`, `dt_create`) 
					VALUES('{$id_pemohon}', '{$type}', '{$final_image}', ".tosql($sijil_size).", '{$sijil_type}', '{$dt}')";
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

	} else if($pro=='SPM_DEL_REC'){

		$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
		$spm_tahun_pilih=isset($_REQUEST["spm_tahun_pilih"])?$_REQUEST["spm_tahun_pilih"]:"";
		$mp=isset($_REQUEST["mpp"])?$_REQUEST["mpp"]:"";
		$sid=isset($_REQUEST["sid"])?$_REQUEST["sid"]:"";
		// $conn->debug=true;
		$sql = "DELETE FROM $schema2.`calon_spm` WHERE `id_pemohon`=".tosql($id_pemohon)." AND `tahun`=".tosql($spm_tahun_pilih)." AND `spm_id`=".tosql($sid);
		// print $sql;
		$rss = $conn->execute($sql);
		if($rss){ 	
		    $err='OK';
		    clear_jawatan($id_pemohon);
		} else {
			$err='ERR';
		}

	} else if($pro=='SPM_DEL'){

		// $conn->debug=true;
		$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
		$actions=isset($_REQUEST["actions"])?$_REQUEST["actions"]:"";
		$tahun=isset($_REQUEST["tahun"])?$_REQUEST["tahun"]:"";
		$borang = "";


		if($actions==1){
			$data = $conn->query("SELECT `spm_tahun_1` FROM $schema2.`calon` WHERE `id_pemohon`=".tosql($id_pemohon));
			$tahuns = $data->fields['spm_tahun_1'];
			$rss = $conn->execute("UPDATE $schema2.`calon` SET `spm_tahun_1`=NULL, `spm_jenis_sijil_1`=NULL, `spm_pangkat_1`=NULL, `spm_lisan_1`=NULL 
				WHERE `id_pemohon`=".tosql($id_pemohon));
			$borang='SPM1';
		} else if($actions==2){
			$data = $conn->query("SELECT `spm_tahun_2` FROM $schema2.`calon` WHERE `id_pemohon`=".tosql($id_pemohon));
			$tahuns = $data->fields['spm_tahun_2'];
			$rss = $conn->execute("UPDATE $schema2.`calon` SET `spm_tahun_2`=NULL, `spm_jenis_sijil_2`=NULL, `spm_pangkat_2`=NULL, `spm_lisan_2`=NULL  
				WHERE `id_pemohon`=".tosql($id_pemohon));
			$borang='SPM2';
		}

		if($rss){
			$_SESSION['SESS_SPMSIJIL']="";
			$_SESSION['SESS_SPMTAHUN']="";
			$_SESSION['SESS_SPMSIJIL2']="";
			$_SESSION['SESS_SPMTAHUN2']="";
			// $err='OK';
			$conn->execute("DELETE FROM $schema2.`calon_spm` WHERE `tahun`='{$tahun}' AND `id_pemohon`=".tosql($id_pemohon));

			$rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='{$borang}' AND `id_pemohon`=".tosql($id_pemohon));
			if(!$rsSijil->EOF){
		        $files = '/var/www/upload/'.$id_pemohon.'/'.$rsSijil->fields['sijil_nama']; // upload directory
				$conn->execute("DELETE FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='{$borang}' AND `id_pemohon`=".tosql($id_pemohon));
				unlink($files);
			}


			$err='OK;index.php?data='.base64_encode('akademik/spm;MAKLUMAT AKADEMIK;Maklumat SPM/SPVM/SPM(V);;1;;');
			// $sqld = "DELETE FROM $schema2.`calon_spm` WHERE `jenis_xm`='T' AND `id_pemohon`=".tosql($id_pemohon);
			// $conn->execute($sqld);


			//if($err=='OK'){
				//$sql = "$schema2.`calon_jawatan_dipohon` WHERE `id_pemohon`=".tosql($id_pemohon);
				//$conn->execute($sql);
			//}
			clear_jawatan($id_pemohon);
		} else {
			$err='ERR';
		}
	}


} else if($frm=='STPM'){

	$actions=isset($_REQUEST["actions"])?$_REQUEST["actions"]:"";

	if($pro=='UPDATE'){
		// $conn->debug=true;
		$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
		$fields=isset($_REQUEST["fields"])?$_REQUEST["fields"]:"";
		$vals=isset($_REQUEST["vals"])?$_REQUEST["vals"]:"";
		$ty=isset($_REQUEST["ty"])?$_REQUEST["ty"]:"";

		if(!empty($id_pemohon)){

			$sqlu = "UPDATE $schema2.`calon` SET $fields=".tosql($vals);
			$sqlu .= " WHERE `id_pemohon`=".tosql($id_pemohon);
			$rss = $conn->execute($sqlu);

		}

		if($rss){
			$err='OK';
		} else {
			$err='ERR'; 
		}

	// } else if($pro=='ADD'){

	// 	$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
	// 	$tahun_add=isset($_REQUEST["tahun_add"])?$_REQUEST["tahun_add"]:"";

	// 	$rss = $conn->execute("UPDATE $schema2.`calon` SET `stp_tahun_2`=".tosql($tahun_add)." WHERE `id_pemohon`=".tosql($id_pemohon));

	// 	if($rss){
	// 		// $err='OK';
	// 		$err='OK;index.php?data='.base64_encode('akademik/stpm;MAKLUMAT AKADEMIK;Maklumat STPM/STP/HSC;;2;;');
	// 	} else {
	// 		$err='ERR';
	// 	}

	} else if($pro=='STPM_DEL'){
		//$conn->debug=true;
		$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";

		if($actions==1){
			$js = 'STPM1'; $jenisxm='B';
			$rss = $conn->execute("UPDATE $schema2.`calon` SET `stp_tahun_1`=NULL, `stp_jenis_1`=NULL, `stp_pangkat_2`=NULL 
				WHERE `id_pemohon`=".tosql($id_pemohon));
		} else if($actions==2){
			$js='STPM2'; $jenisxm='BT';
			$rss = $conn->execute("UPDATE $schema2.`calon` SET `stp_tahun_2`=NULL, `stp_jenis_2`=NULL, `stp_pangkat_2`=NULL 
				WHERE `id_pemohon`=".tosql($id_pemohon));
		}

		if($rss){
			// $err='OK';
			$rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='{$js}' AND `id_pemohon`=".tosql($id_pemohon));
			if(!$rsSijil->EOF){
		        $files = '/var/www/upload/'.$id_pemohon.'/'.$rsSijil->fields['sijil_nama']; // upload directory
				$conn->execute("DELETE FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='{$js}' AND `id_pemohon`=".tosql($id_pemohon));
				unlink($files);
			}
			$err='OK;index.php?data='.base64_encode('akademik/stpm;MAKLUMAT AKADEMIK;Maklumat STPM/STP/HSC;;1;;');
			$sqld = "DELETE FROM $schema2.`calon_stp_stam` WHERE `jenis_xm`='{$jenisxm}' AND `id_pemohon`=".tosql($id_pemohon);
			$conn->execute($sqld);
			clear_jawatan($id_pemohon);
		} else {
			$err='ERR';
		}
		// exit;

	} else if($pro=='SAVE'){

		//$conn->debug=true;
		$id_pemohon = isset($_REQUEST["id_pemohon"]) ? $_REQUEST["id_pemohon"] : "";
			$stp_tahun_1 = isset($_REQUEST["stp_tahun_1"]) ? $_REQUEST["stp_tahun_1"] : "";
			$stp_jenis_1 = isset($_REQUEST["stp_jenis_1"]) ? $_REQUEST["stp_jenis_1"] : "";
			$akg = isset($_REQUEST["stpm_angka_giliran_1"]) ? $_REQUEST["stpm_angka_giliran_1"] : "";
			$is_integrasi = isset($_REQUEST["is_integrasi_input"]) ? $_REQUEST["is_integrasi_input"] : "T";
			
			$actions = $_REQUEST['actions'];
			$jsijil = 1;
			$dt = date("Y-m-d H:i:s");

			if(!empty($id_pemohon)){
				// 1. Update Table Calon (Tahun & Jenis)
				if($actions == 1){
					$sqlu = "UPDATE $schema2.`calon` SET `stp_tahun_1`=".tosql($stp_tahun_1).", `stp_jenis_1`=".tosql($stp_jenis_1)." WHERE `id_pemohon`=".tosql($id_pemohon);
				} else {
					$sqlu = "UPDATE $schema2.`calon` SET `stp_tahun_2`=".tosql($stp_tahun_1).", `stp_jenis_2`=".tosql($stp_jenis_1)." WHERE `id_pemohon`=".tosql($id_pemohon);
				}
				$conn->execute($sqlu);

				// 2. Simpan Matapelajaran
				$mp = isset($_REQUEST["mp_1"]) ? $_REQUEST["mp_1"] : "";
				$gred = isset($_REQUEST["gred_1"]) ? $_REQUEST["gred_1"] : "";
				$mp_old = isset($_REQUEST["mp_old"]) ? $_REQUEST["mp_old"] : "";
				
				$jxm = ($actions == 1) ? 'B' : 'BT';

				for($i=0; $i<count($mp); $i++){
					if(!empty($mp[$i]) && !empty($gred[$i])){
						// Cari rekod sedia ada
						$rs = $conn->query("SELECT * FROM $schema2.`calon_stp_stam` 
											WHERE `jenis_xm`=".tosql($jxm)." 
											AND `id_pemohon`=".tosql($id_pemohon)." 
											AND `tahun`=".tosql($stp_tahun_1)." 
											AND `matapelajaran`=".tosql($mp_old[$i]));
						
						if($rs->EOF){
							$stpm_id = date("YmdHisN").uniqid();
							$sql = "INSERT INTO $schema2.`calon_stp_stam` 
									(`stp_id`, `id_pemohon`, `tahun`, `matapelajaran`, `jenis_sijil`, `gred`, `d_cipta`, `jenis_xm`, `angka_giliran`, `is_integrasi`)
									VALUES 
									('{$stpm_id}', ".tosql($id_pemohon).", ".tosql($stp_tahun_1).", ".tosql($mp[$i]).", ".tosql($jsijil).", ".tosql($gred[$i]).", ".tosql($dt).", ".tosql($jxm).", ".tosql($akg).", ".tosql($is_integrasi).")";
						} else {
							$sql = "UPDATE $schema2.`calon_stp_stam` SET 
									`matapelajaran`=".tosql($mp[$i]).", 
									`gred`=".tosql($gred[$i]).", 
									`angka_giliran`=".tosql($akg).",
									`is_integrasi`=".tosql($is_integrasi).",
									`d_kemaskini`=".tosql($dt)." 
									WHERE `stp_id`=".tosql($rs->fields['stp_id']);
						}
						$conn->execute($sql);
					}
				}
				echo "OK";
			} else {
				echo "ERR";
			}
			exit;
		// $subj = "'002'";
		if(!empty($actions) && $actions==2){
			$type='STPM2'; 
			$mp=isset($_REQUEST["mp_1"])?$_REQUEST["mp_1"]:"";
			$gred=isset($_REQUEST["gred_1"])?$_REQUEST["gred_1"]:"";
			$mp_old=isset($_REQUEST["mp_old"])?$_REQUEST["mp_old"]:"";
			// $conn->debug=true;
			for($i=0;$i<=7;$i++){
				$dt = date("Y-m-d H:i:s");
				if(!empty($mp[$i]) && !empty($gred[$i])){

					$rs = $conn->query("SELECT * FROM $schema2.`calon_stp_stam` WHERE `jenis_xm`='BT' AND `id_pemohon`=".tosql($id_pemohon)." AND `tahun`=".tosql($stp_tahun_1)." AND `matapelajaran`=".tosql($mp_old[$i]));
					if($rs->EOF){
						$stpm_id = date("YmdHisN").uniqid();
						$sql = "INSERT INTO $schema2.`calon_stp_stam`(`stp_id`, `id_pemohon`, `tahun`, `matapelajaran`, `jenis_sijil`, `gred`, `d_cipta`, `jenis_xm`)";
						$sql .= " VALUES('{$stpm_id}', ".tosql($id_pemohon).",".tosql($stp_tahun_1).",".tosql($mp[$i]).",".tosql($jsijil).",".tosql($gred[$i]).",".tosql($dt).", 'BT')";
					} else {
						$sql = "UPDATE $schema2.`calon_stp_stam` SET `matapelajaran`=".tosql($mp[$i]).", `gred`=".tosql($gred[$i]).", d_kemaskini=".tosql($dt)." WHERE `jenis_xm`='BT' AND `id_pemohon`=".tosql($id_pemohon)." AND `tahun`=".tosql($stp_tahun_1)." AND `matapelajaran`=".tosql($mp_old[$i]);
					}

					$conn->execute($sql);
				}
				$err='OK';
			}

		}


		// print "UPL:".$_FILES['file_pmr']['name'];
		//$sijil_pmr=isset($_REQUEST["sijil_pmr"])?$_REQUEST["sijil_pmr"]:"";
		if(!empty($_FILES['file_pmr']['name'])){ 
			// $conn->debug=true;
			// $type='PMR';
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif','pdf','JPEG', 'JPG', 'PNG', 'GIF','PDF'); // valid extensions
	        $path = '/var/www/upload/'.$id_pemohon.'/'; // upload directory
	        if (file_exists($path)) {
	            $path = $path;
	        } else {
	            mkdir($path);
	            $path = '/var/www/upload/'.$id_pemohon.'/';
	        }

		//print 'aaaaaa'.$type;

	        $img = $_FILES['file_pmr']['name'];
	        $tmp = $_FILES['file_pmr']['tmp_name'];
	        
	        $ext = end((explode(".", $img))); 
	        // $fname = $img; //$id.".".$ext;
	        // $fname = str_replace(" ", "_", $fname);
	        // $fname = str_replace("-", "_", $fname);

	        // $final_image = "docSenaraiSemak_D3_1_".$appli_id2."_".$item_id.".".$ext;
	        // $final_image = rand(1000,1000000)."_".$fname;
	        $final_image = strtolower($rsIC->fields['ICNo']."_".$type.".".$ext);
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
				$rsu = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`=".tosql($type)." AND `id_pemohon`=".tosql($id_pemohon));
				if($rsu->EOF){ 
					$sqlu = "INSERT INTO $schema2.`calon_sijil`(`id_pemohon`, `jenis_sijil`, `sijil_nama`, `sijil_size`, `sijil_type`, `dt_create`) 
					VALUES('{$id_pemohon}', '{$type}', '{$final_image}', ".tosql($sijil_size).", '{$sijil_type}', '{$dt}')";
				} else {
					$sqlu = "UPDATE $schema2.`calon_sijil` SET `sijil_nama`='{$final_image}', `sijil_size`=".tosql($sijil_size).", 
					`sijil_type`=".tosql($sijil_type).", `dt_update`='{$dt}' WHERE `jenis_sijil`=".tosql($type)." AND `id_pemohon`=".tosql($id_pemohon);				
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
	
	} else if($pro=='STPM_DEL_REC'){

		// $conn->debug=true;
		$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
		$stpm_tahun_pilih=isset($_REQUEST["stpm_tahun_pilih"])?$_REQUEST["stpm_tahun_pilih"]:"";
		$mp=isset($_REQUEST["mpp"])?$_REQUEST["mpp"]:"";
		$sid=isset($_REQUEST["sid"])?$_REQUEST["sid"]:"";
		// $conn->debug=true;
		$sql = "DELETE FROM $schema2.`calon_stp_stam` WHERE `id_pemohon`=".tosql($id_pemohon)." AND `stp_id`=".tosql($sid);
		// print $sql; AND `tahun`=".tosql($stpm_tahun_pilih)."
		$rss = $conn->execute($sql);

		
		if($rss){ 	
		    $err='OK';
		    clear_jawatan($id_pemohon);
		} else {
			$err='ERR';
		}
	}

} else if($frm=='STAM'){

	if($pro=='UPDATE'){
		// // $conn->debug=true;
		// $id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
		// $fields=isset($_REQUEST["fields"])?$_REQUEST["fields"]:"";
		// $vals=isset($_REQUEST["vals"])?$_REQUEST["vals"]:"";
		// $ty=isset($_REQUEST["ty"])?$_REQUEST["ty"]:"";

		// if(!empty($id_pemohon)){

		// 	$sqlu = "UPDATE $schema2.`calon` SET $fields=".tosql($vals);
		// 	if($ty=='R' && $fields=='stam_tahun_1'){ $sqlu .= ", stam_jenis_1=NULL, stam_pangkat_1=NULL "; } 
		// 	else if($ty=='R' && $fields=='stam_tahun_2'){ $sqlu .= ", stam_jenis_2=NULL, stam_pangkat_2=NULL  "; } 
		// 	$sqlu .= " WHERE `id_pemohon`=".tosql($id_pemohon);
		// 	$rss = $conn->execute($sqlu);

		// }

		// if($rss){
		// 	$err='OK';
		// 	if($ty=='R' && $fields=='stam_tahun_1'){ 
		// 		$rs = $conn->query("SELECT * FROM $schema2.`calon_stp_stam` WHERE `jenis_xm`='A' AND `id_pemohon`=".tosql($id_pemohon));
		// 		if(!$rs->EOF){
		// 			$conn->execute("UPDATE $schema2.`calon_stp_stam` SET `tahun`=".tosql($vals)." WHERE `jenis_xm`='A' AND `id_pemohon`=".tosql($id_pemohon));
		// 		}
		// 	} else if($ty=='R' && $fields=='stp_tahun_2'){ 
		// 		$rs = $conn->query("SELECT * FROM $schema2.`calon_stp_stam` WHERE `jenis_xm`='AT' AND `id_pemohon`=".tosql($id_pemohon));
		// 		if(!$rs->EOF){
		// 			$conn->execute("UPDATE $schema2.`calon_stp_stam` SET `tahun`=".tosql($vals)." WHERE `jenis_xm`='AT' AND `id_pemohon`=".tosql($id_pemohon));
		// 		}
		// 	}
		// } else {
		// 	$err='ERR'; 
		// }

	} else if($pro=='ADD'){

		// $id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
		// $tahun_add=isset($_REQUEST["tahun_add"])?$_REQUEST["tahun_add"]:"";

		// $rss = $conn->execute("UPDATE $schema2.`calon` SET `stam_tahun_2`=".tosql($tahun_add)." WHERE `id_pemohon`=".tosql($id_pemohon));

		// if($rss){
		// 	// $err='OK';
		// 	$err='OK;index.php?data='.base64_encode('akademik/stam;MAKLUMAT AKADEMIK;Maklumat STAM;;2;;');
		// } else {
		// 	$err='ERR';
		// }

	} else if($pro=='STAM_DEL'){
		// $conn->debug=true;
		$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
		$actions=isset($_REQUEST["actions"])?$_REQUEST["actions"]:"";

		if($actions==1){
			$js = 'STAM1'; $jenisxm='A';
			$rss = $conn->execute("UPDATE $schema2.`calon` SET `stam_tahun_1`=NULL, `stam_jenis_1`=NULL, `stam_pangkat_1`=NULL 
				WHERE `id_pemohon`=".tosql($id_pemohon));
		} else if($actions==2){
			$js='STAM2'; $jenisxm='AT';
			$rss = $conn->execute("UPDATE $schema2.`calon` SET `stam_tahun_2`=NULL, `stam_jenis_2`=NULL, `stam_pangkat_2`=NULL 
				WHERE `id_pemohon`=".tosql($id_pemohon));
		}

		if($rss){
			// $err='OK';
			$rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='{$js}' AND `id_pemohon`=".tosql($id_pemohon));
			if(!$rsSijil->EOF){
		        $files = '/var/www/upload/'.$id_pemohon.'/'.$rsSijil->fields['sijil_nama']; // upload directory
				$conn->execute("DELETE FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='{$js}' AND `id_pemohon`=".tosql($id_pemohon));
				unlink($files);
			}
			$err='OK;index.php?data='.base64_encode('akademik/stam;MAKLUMAT AKADEMIK;Maklumat STAM;;1;;');
			$sqld = "DELETE FROM $schema2.`calon_stp_stam` WHERE `jenis_xm`='{$jenisxm}' AND `id_pemohon`=".tosql($id_pemohon);
			$conn->execute($sqld);

			clear_jawatan($id_pemohon);
		} else {
			$err='ERR';
		}
		// exit;

	} else if($pro=='SAVE'){
		//$conn->debug=true;
		$actions=isset($_REQUEST["actions"])?$_REQUEST["actions"]:"";
		$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
		$stam_tahun_1=isset($_REQUEST["stam_tahun_1"])?$_REQUEST["stam_tahun_1"]:"";
		$stam_jenis_1=isset($_REQUEST["stam_jenis_1"])?$_REQUEST["stam_jenis_1"]:"";
		$stam_pangkat_1=isset($_REQUEST["stam_pangkat_1"])?$_REQUEST["stam_pangkat_1"]:"";
		$jsijil=1;

		$stam_tahun_pilih=isset($_REQUEST["stam_tahun_pilih"])?$_REQUEST["stam_tahun_pilih"]:"";
		$stam_sijil_pilih=isset($_REQUEST["stam_sijil_pilih"])?$_REQUEST["stam_sijil_pilih"]:"";
		$stam_pangkat_pilih=isset($_REQUEST["stam_pangkat_pilih"])?$_REQUEST["stam_pangkat_pilih"]:"";
		$jsijil=1;

		$rsIC = $conn->query("SELECT ICNo FROM $schema2.calon WHERE id_pemohon=$id_pemohon");

		if(!empty($stam_tahun_pilih)){ $stam_tahun_1=$stam_tahun_pilih; }
		if(!empty($stam_sijil_pilih)){ $stam_jenis_1=$stam_sijil_pilih; }
		if(!empty($stam_pangkat_pilih)){ $stam_pangkat_1=$stam_pangkat_pilih; }

		if(!empty($actions) && $actions==1){
			$sqlu = "UPDATE $schema2.`calon` SET `stam_tahun_1`=".tosql($stam_tahun_1).", `stam_jenis_1`=".tosql($stam_jenis_1).", `stam_pangkat_1`=".tosql($stam_pangkat_1);
			$sqlu .= " WHERE `id_pemohon`=".tosql($id_pemohon);
			$rss = $conn->execute($sqlu);
		} else 	if(!empty($actions) && $actions==2){
			$sqlu = "UPDATE $schema2.`calon` SET `stam_tahun_2`=".tosql($stam_tahun_1).", `stam_jenis_2`=".tosql($stam_jenis_1).", `stam_pangkat_2`=".tosql($stam_pangkat_1);
			$sqlu .= " WHERE `id_pemohon`=".tosql($id_pemohon);
			$rss = $conn->execute($sqlu);
		}


		if(!empty($actions) && $actions==1){
			$type='STAM1'; 
			$mp=isset($_REQUEST["mp_1"])?$_REQUEST["mp_1"]:"";
			$gred=isset($_REQUEST["gred_1"])?$_REQUEST["gred_1"]:"";
			$mp_old=isset($_REQUEST["mp_old"])?$_REQUEST["mp_old"]:"";
			// $conn->debug=true;
			//print $mp[0].':'.$gred[0];
			for($i=0;$i<=7;$i++){
				$dt = date("Y-m-d H:i:s");
				if(!empty($mp[$i]) && !empty($gred[$i])){

					$rs = $conn->query("SELECT * FROM $schema2.`calon_stp_stam` WHERE `jenis_xm`='A' AND `id_pemohon`=".tosql($id_pemohon)." AND `tahun`=".tosql($stam_tahun_1)." AND `matapelajaran`=".tosql($mp_old[$i]));
					if($rs->EOF){
						$stpm_id = date("YmdHisN").uniqid();
						$sql = "INSERT INTO $schema2.`calon_stp_stam`(`stp_id`, `id_pemohon`, `tahun`, `matapelajaran`, `jenis_sijil`, `gred`, `d_cipta`, `jenis_xm`)";
						$sql .= " VALUES('{$stpm_id}', ".tosql($id_pemohon).",".tosql($stam_tahun_1).",".tosql($mp[$i]).",".tosql($jsijil).",".tosql($gred[$i]).",".tosql($dt).", 'A')";
					} else {
						$sql = "UPDATE $schema2.`calon_stp_stam` SET `matapelajaran`=".tosql($mp[$i]).", `gred`=".tosql($gred[$i]).", d_kemaskini=".tosql($dt)." WHERE `jenis_xm`='A' AND `id_pemohon`=".tosql($id_pemohon)." AND `tahun`=".tosql($stam_tahun_1)." AND `matapelajaran`=".tosql($mp_old[$i]);
					}

					$conn->execute($sql);
				}
				$err='OK';
			}

		}

		// $subj = "'002'";
		if(!empty($actions) && $actions==2){
			$type='STAM2'; 
			$mp=isset($_REQUEST["mp_1"])?$_REQUEST["mp_1"]:"";
			$gred=isset($_REQUEST["gred_1"])?$_REQUEST["gred_1"]:"";
			$mp_old=isset($_REQUEST["mp_old"])?$_REQUEST["mp_old"]:"";
			//print $mp[0].':'.$gred[0];
			 //$conn->debug=true;
			for($i=0;$i<=7;$i++){
				$dt = date("Y-m-d H:i:s");
				if(!empty($mp[$i]) && !empty($gred[$i])){

					$rs = $conn->query("SELECT * FROM $schema2.`calon_stp_stam` WHERE `jenis_xm`='AT' AND `id_pemohon`=".tosql($id_pemohon)." AND `tahun`=".tosql($stam_tahun_1)." AND `matapelajaran`=".tosql($mp_old[$i]));
					if($rs->EOF){
						$stam_id = date("YmdHisN").uniqid();
						$sql = "INSERT INTO $schema2.`calon_stp_stam`(`stp_id`, `id_pemohon`, `tahun`, `matapelajaran`, `jenis_sijil`, `gred`, `d_cipta`, `jenis_xm`)";
						$sql .= " VALUES('{$stam_id}', ".tosql($id_pemohon).",".tosql($stam_tahun_1).",".tosql($mp[$i]).",".tosql($jsijil).",".tosql($gred[$i]).",".tosql($dt).", 'AT')";
					} else {
						$sql = "UPDATE $schema2.`calon_stp_stam` SET `matapelajaran`=".tosql($mp[$i]).", `gred`=".tosql($gred[$i]).", d_kemaskini=".tosql($dt)." WHERE `jenis_xm`='AT' AND `id_pemohon`=".tosql($id_pemohon)." AND `tahun`=".tosql($stam_tahun_1)." AND `matapelajaran`=".tosql($mp_old[$i]);
					}
					$conn->execute($sql);
				}
				$err='OK';
			}

		}

		// print "UPL:".$_FILES['file_pmr']['name'];
		//$sijil_pmr=isset($_REQUEST["sijil_pmr"])?$_REQUEST["sijil_pmr"]:"";
		if(!empty($_FILES['file_pmr']['name'])){ 
			// $conn->debug=true;
			// $type='PMR';
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif','pdf','JPEG', 'JPG', 'PNG', 'GIF','PDF'); // valid extensions
	        $path = '/var/www/upload/'.$id_pemohon.'/'; // upload directory
	        if (file_exists($path)) {
	            $path = $path;
	        } else {
	            mkdir($path);
	            $path = '/var/www/upload/'.$id_pemohon.'/';
	        }

	        $img = $_FILES['file_pmr']['name'];
	        $tmp = $_FILES['file_pmr']['tmp_name'];
	        
	        $ext = end((explode(".", $img))); 
	        // $fname = $img; //$id.".".$ext;
	        // $fname = str_replace(" ", "_", $fname);
	        // $fname = str_replace("-", "_", $fname);

	        // $final_image = "docSenaraiSemak_D3_1_".$appli_id2."_".$item_id.".".$ext;
	        // $final_image = rand(1000,1000000)."_".$fname;
	        $final_image = strtolower($rsIC->fields['ICNo']."_".$type.".".$ext);
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


				$rsu = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`=".tosql($type)." AND `id_pemohon`=".tosql($id_pemohon));
				if($rsu->EOF){ 
					$sqlu = "INSERT INTO $schema2.`calon_sijil`(`id_pemohon`, `jenis_sijil`, `sijil_nama`, `sijil_size`, `sijil_type`, `dt_create`) 
					VALUES('{$id_pemohon}', '{$type}', '{$final_image}', ".tosql($sijil_size).", '{$sijil_type}', '{$dt}')";
				} else {
					$sqlu = "UPDATE $schema2.`calon_sijil` SET `sijil_nama`='{$final_image}', `sijil_size`=".tosql($sijil_size).", 
					`sijil_type`=".tosql($sijil_type).", `dt_update`='{$dt}' WHERE `jenis_sijil`=".tosql($type)." AND `id_pemohon`=".tosql($id_pemohon);				
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
	} else if($pro=='STAM_DEL_REC'){

		// $conn->debug=true;
		$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
		$stpm_tahun_pilih=isset($_REQUEST["stpm_tahun_pilih"])?$_REQUEST["stpm_tahun_pilih"]:"";
		$mp=isset($_REQUEST["mpp"])?$_REQUEST["mpp"]:"";
		$sid=isset($_REQUEST["sid"])?$_REQUEST["sid"]:"";
		// $conn->debug=true;
		$sql = "DELETE FROM $schema2.`calon_stp_stam` WHERE `id_pemohon`=".tosql($id_pemohon)." AND `stp_id`=".tosql($sid);
		// print $sql; AND `tahun`=".tosql($stpm_tahun_pilih)."
		$rss = $conn->execute($sql);
		if($rss){ 	
		    $err='OK';
		    clear_jawatan($id_pemohon);
		} else {
			$err='ERR';
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

	} else if($pro=='UNIV_DEL'){

		$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
		$kep=isset($_REQUEST["kep"])?$_REQUEST["kep"]:"";

		$rss = $conn->execute("DELETE FROM $schema2.`calon_ipt` WHERE `id_pemohon`= ".tosql($id_pemohon)." AND `bil_keputusan`=".tosql($kep));

		if($kep==1){
			$jsijil1 = 'UNIV1A'; $jsijil2 = 'UNIV1B'; $jsijil3 = 'UNIV1C'; 
		} else if($kep==2){
			$jsijil1 = 'UNIV2A'; $jsijil2 = 'UNIV2B'; $jsijil3 = 'UNIV2C'; 
		} else if($kep==3){
			$jsijil1 = 'UNIV3A'; $jsijil2 = 'UNIV3B'; $jsijil3 = 'UNIV3C'; 
		}

		$rs = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='{$jsijil1}' AND `id_pemohon`='{$id_pemohon}'");
		if(!$rs->EOF){
			$sqld = "DELETE FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='{$jsijil1}' AND `id_pemohon`='{$id_pemohon}'";
			$path = '/var/www/upload/'.$id_pemohon.'/'.$rs->fields['sijil_nama']; // upload directory
			$conn->execute($sqld);
			unlink($path);
		}
		$rs = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='{$jsijil2}' AND `id_pemohon`='{$id_pemohon}'");
		if(!$rs->EOF){
			$sqld = "DELETE FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='$jsijil2' AND `id_pemohon`='{$id_pemohon}'";
			$path = '/var/www/upload/'.$id_pemohon.'/'.$rs->fields['sijil_nama']; // upload directory
			$conn->execute($sqld);
			unlink($path);
		}

		$rs = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='{$jsijil3}' AND `id_pemohon`='{$id_pemohon}'");
		if(!$rs->EOF){
			$sqld = "DELETE FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='$jsijil3' AND `id_pemohon`='{$id_pemohon}'";
			$path = '/var/www/upload/'.$id_pemohon.'/'.$rs->fields['sijil_nama']; // upload directory
			$conn->execute($sqld);
			unlink($path);
		}


		if($rss){
			$err='OK';
			//clear_jawatan($id_pemohon);

			//if($err=='OK'){
				//$sql = "$schema2.`calon_jawatan_dipohon` WHERE `id_pemohon`=".tosql($id_pemohon);
				//$conn->execute($sql);
			//}

		} else {
			$err='ERR';
		}

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
        $major1=isset($_REQUEST["major1"])?$_REQUEST["major1"]:"";
        $minor1=isset($_REQUEST["minor1"])?$_REQUEST["minor1"]:"";

        // --- TAMBAHAN: FLAG INTEGRASI ---
        // Default 'T' (Manual). Jika frontend hantar '1', set 'Y'.
        $is_api = (isset($_REQUEST["is_api_data_1"]) && $_REQUEST["is_api_data_1"] == '1') ? 'Y' : 'T';

        // Format Tarikh Senat (Jika format DD/MM/YYYY dari datepicker, tukar ke YYYY-MM-DD)
        // Jika dari API (YYYY-MM-DD), kekalkan.
        if (strpos($tkh_senate, '/') !== false) {
             $parts = explode('/', $tkh_senate);
             $tkh_senate = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
        }

        $rsIC = $conn->query("SELECT ICNo FROM $schema2.calon WHERE id_pemohon=$id_pemohon");

        if(!empty($bil_keputusan1)){ 
            $sql = "UPDATE $schema2.`calon_ipt` SET 
                `tahun`=".tosql($tahun1).", 
                `peringkat`=".tosql($peringkat1).", 
                `cgpa`=".tosql($cgpa1).", 
                `inst_keluar_sijil`=".tosql($inst_keluar_sijil1).", 
                `inst_francais`=".tosql($inst_francais1).", 
                `bidang`=".tosql($bidang1).", 
                `pengkhususan`=".tosql($pengkhususan1).", 
                `biasiswa`=".tosql($biasiswa1).", 
                `tkh_senate`=".tosql($tkh_senate).",  
                `muet`=".tosql($muet1).", 
                `muet_tahun`=".tosql($muet_tahun).", 
                `muet_gred`=".tosql($muet_gred).", 
                `major`=".tosql($major1).", 
                `minor`=".tosql($minor1).",
                `is_integrasi`=".tosql($is_api).",  
                `d_kemaskini`=".tosql(date("Y-m-d H:i:s"))." 
            WHERE `id_pemohon`=".tosql($id_pemohon)." AND `bil_keputusan`=1";
        } else {
            $sql = "INSERT INTO $schema2.`calon_ipt`(`id_pemohon`, `bil_keputusan`, `tahun`, `peringkat`, `cgpa`, `inst_keluar_sijil`, `inst_francais`, `bidang`, `pengkhususan`, `biasiswa`, `muet`, `muet_tahun`, `muet_gred`, `tkh_senate`, `major`, `minor`, `is_integrasi`, `d_cipta`) 
            VALUES(".tosql($id_pemohon).", '1', ".tosql($tahun1).", ".tosql($peringkat1).", ".tosql($cgpa1).", ".tosql($inst_keluar_sijil1).", 
                ".tosql($inst_francais1).", ".tosql($bidang1).", ".tosql($pengkhususan1).", ".tosql($biasiswa1).", 
                ".tosql($muet1).", ".tosql($muet_tahun).", ".tosql($muet_gred).", 
                ".tosql($tkh_senate).", ".tosql($major1).", ".tosql($minor1).", ".tosql($is_api).", ".tosql(date("Y-m-d H:i:s")).")";
        }

        $rss = $conn->execute($sql);
        if($rss){ $err = 'OK'; } else { $err='ERR'; }

// --- (Sambungan selepas SAVE1) ---

// ... (Selepas blok SAVE1) ...

    // --- SAVE 2 (KEPUTUSAN KE-2) ---
   } else if($pro=='SAVE2'){
        $id_pemohon = isset($_REQUEST["id_pemohon"]) ? $_REQUEST["id_pemohon"] : "";
        $bil_keputusan2 = 2; // Fixed

        // Ambil data (Variable name kekal tahun1, peringkat1 dsb kerana form guna name yang sama)
        $tahun1 = isset($_REQUEST["tahun1"]) ? $_REQUEST["tahun1"] : "";
        $peringkat1 = isset($_REQUEST["peringkat1"]) ? $_REQUEST["peringkat1"] : "";
        $cgpa1 = isset($_REQUEST["cgpa1"]) ? $_REQUEST["cgpa1"] : "";
        $inst_keluar_sijil1 = isset($_REQUEST["inst_keluar_sijil1"]) ? $_REQUEST["inst_keluar_sijil1"] : "";
        $inst_francais1 = isset($_REQUEST["inst_francais1"]) ? $_REQUEST["inst_francais1"] : "T";
        $bidang1 = isset($_REQUEST["bidang1"]) ? $_REQUEST["bidang1"] : "S";
        $pengkhususan1 = isset($_REQUEST["pengkhususan1"]) ? $_REQUEST["pengkhususan1"] : "";
        $muet1 = isset($_REQUEST["jenisMuetCefr1"]) ? $_REQUEST["jenisMuetCefr1"] : "";
        $muet_tahun = isset($_REQUEST["tahunMuetCefr1"]) ? $_REQUEST["tahunMuetCefr1"] : "";
        $muet_gred = isset($_REQUEST["keputusanMuetCefr1"]) ? $_REQUEST["keputusanMuetCefr1"] : "";
        $biasiswa1 = isset($_REQUEST["biasiswa1"]) ? $_REQUEST["biasiswa1"] : "";
        $tkh_senate = isset($_REQUEST["tkh_senate"]) ? $_REQUEST["tkh_senate"] : "";
        $major1 = isset($_REQUEST["major1"]) ? $_REQUEST["major1"] : "";
        $minor1 = isset($_REQUEST["minor1"]) ? $_REQUEST["minor1"] : "";
        
        // --- LOGIC INTEGRASI SAVE2 ---
        // Baca hidden input name="is_api_data_2"
        $is_api = (isset($_REQUEST["is_api_data_2"]) && $_REQUEST["is_api_data_2"] == '1') ? 'Y' : 'T';

        if (strpos($tkh_senate, '/') !== false) {
             $parts = explode('/', $tkh_senate);
             $tkh_senate_db = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
        } else {
             $tkh_senate_db = $tkh_senate;
        }

        $rsIC = $conn->query("SELECT ICNo FROM $schema2.calon WHERE id_pemohon=$id_pemohon");

        // Check Update or Insert
        $rsCheck = $conn->query("SELECT * FROM $schema2.`calon_ipt` WHERE `id_pemohon`=".tosql($id_pemohon)." AND `bil_keputusan`=2");

        if(!$rsCheck->EOF){ 
            $sql = "UPDATE $schema2.`calon_ipt` SET 
                `tahun`=".tosql($tahun1).", 
                `peringkat`=".tosql($peringkat1).", 
                `cgpa`=".tosql($cgpa1).", 
                `inst_keluar_sijil`=".tosql($inst_keluar_sijil1).", 
                `inst_francais`=".tosql($inst_francais1).", 
                `bidang`=".tosql($bidang1).", 
                `pengkhususan`=".tosql($pengkhususan1).", 
                `biasiswa`=".tosql($biasiswa1).", 
                `tkh_senate`=".tosql($tkh_senate_db).",  
                `muet`=".tosql($muet1).", 
                `muet_tahun`=".tosql($muet_tahun).", 
                `muet_gred`=".tosql($muet_gred).", 
                `major`=".tosql($major1).", 
                `minor`=".tosql($minor1).", 
                `is_integrasi`=".tosql($is_api).", 
                `d_kemaskini`=".tosql(date("Y-m-d H:i:s"))." 
            WHERE `id_pemohon`=".tosql($id_pemohon)." AND `bil_keputusan`=2";
        } else {
            $sql = "INSERT INTO $schema2.`calon_ipt`(`id_pemohon`, `bil_keputusan`, `tahun`, `peringkat`, `cgpa`, `inst_keluar_sijil`, `inst_francais`, `bidang`, `pengkhususan`, `biasiswa`, `muet`, `muet_tahun`, `muet_gred`, `tkh_senate`, `major`, `minor`, `is_integrasi`, `d_cipta`) 
            VALUES(".tosql($id_pemohon).", '2', ".tosql($tahun1).", ".tosql($peringkat1).", ".tosql($cgpa1).", ".tosql($inst_keluar_sijil1).", 
                ".tosql($inst_francais1).", ".tosql($bidang1).", ".tosql($pengkhususan1).", ".tosql($biasiswa1).", 
                ".tosql($muet1).", ".tosql($muet_tahun).", ".tosql($muet_gred).", 
                ".tosql($tkh_senate_db).", ".tosql($major1).", ".tosql($minor1).", ".tosql($is_api).", ".tosql(date("Y-m-d H:i:s")).")";
        }

        $rss = $conn->execute($sql);
        if($rss){ $err = 'OK'; } else { $err='ERR'; }

    } 
    
    // --- SAVE 3 (KEPUTUSAN KE-3) ---
    else if($pro=='SAVE3'){
        $id_pemohon = isset($_REQUEST["id_pemohon"]) ? $_REQUEST["id_pemohon"] : "";
        $bil_keputusan3 = 3; // Fixed

        $tahun1 = isset($_REQUEST["tahun1"]) ? $_REQUEST["tahun1"] : "";
        $peringkat1 = isset($_REQUEST["peringkat1"]) ? $_REQUEST["peringkat1"] : "";
        $cgpa1 = isset($_REQUEST["cgpa1"]) ? $_REQUEST["cgpa1"] : "";
        $inst_keluar_sijil1 = isset($_REQUEST["inst_keluar_sijil1"]) ? $_REQUEST["inst_keluar_sijil1"] : "";
        $inst_francais1 = isset($_REQUEST["inst_francais1"]) ? $_REQUEST["inst_francais1"] : "T";
        $bidang1 = isset($_REQUEST["bidang1"]) ? $_REQUEST["bidang1"] : "S";
        $pengkhususan1 = isset($_REQUEST["pengkhususan1"]) ? $_REQUEST["pengkhususan1"] : "";
        $muet1 = isset($_REQUEST["jenisMuetCefr1"]) ? $_REQUEST["jenisMuetCefr1"] : "";
        $muet_tahun = isset($_REQUEST["tahunMuetCefr1"]) ? $_REQUEST["tahunMuetCefr1"] : "";
        $muet_gred = isset($_REQUEST["keputusanMuetCefr1"]) ? $_REQUEST["keputusanMuetCefr1"] : "";
        $biasiswa1 = isset($_REQUEST["biasiswa1"]) ? $_REQUEST["biasiswa1"] : "";
        $tkh_senate = isset($_REQUEST["tkh_senate"]) ? $_REQUEST["tkh_senate"] : "";
        $major1 = isset($_REQUEST["major1"]) ? $_REQUEST["major1"] : "";
        $minor1 = isset($_REQUEST["minor1"]) ? $_REQUEST["minor1"] : "";

        // --- LOGIC INTEGRASI SAVE3 ---
        // Baca hidden input name="is_api_data_3"
        $is_api = (isset($_REQUEST["is_api_data_3"]) && $_REQUEST["is_api_data_3"] == '1') ? 'Y' : 'T';

        if (strpos($tkh_senate, '/') !== false) {
             $parts = explode('/', $tkh_senate);
             $tkh_senate_db = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
        } else {
             $tkh_senate_db = $tkh_senate;
        }

        $rsIC = $conn->query("SELECT ICNo FROM $schema2.calon WHERE id_pemohon=$id_pemohon");

        $rsCheck = $conn->query("SELECT * FROM $schema2.`calon_ipt` WHERE `id_pemohon`=".tosql($id_pemohon)." AND `bil_keputusan`=3");

        if(!$rsCheck->EOF){ 
            $sql = "UPDATE $schema2.`calon_ipt` SET 
                `tahun`=".tosql($tahun1).", 
                `peringkat`=".tosql($peringkat1).", 
                `cgpa`=".tosql($cgpa1).", 
                `inst_keluar_sijil`=".tosql($inst_keluar_sijil1).", 
                `inst_francais`=".tosql($inst_francais1).", 
                `bidang`=".tosql($bidang1).", 
                `pengkhususan`=".tosql($pengkhususan1).", 
                `biasiswa`=".tosql($biasiswa1).", 
                `tkh_senate`=".tosql($tkh_senate_db).",  
                `muet`=".tosql($muet1).", 
                `muet_tahun`=".tosql($muet_tahun).", 
                `muet_gred`=".tosql($muet_gred).", 
                `major`=".tosql($major1).", 
                `minor`=".tosql($minor1).", 
                `is_integrasi`=".tosql($is_api).",
                `d_kemaskini`=".tosql(date("Y-m-d H:i:s"))." 
            WHERE `id_pemohon`=".tosql($id_pemohon)." AND `bil_keputusan`=3";
        } else {
            $sql = "INSERT INTO $schema2.`calon_ipt`(`id_pemohon`, `bil_keputusan`, `tahun`, `peringkat`, `cgpa`, `inst_keluar_sijil`, `inst_francais`, `bidang`, `pengkhususan`, `biasiswa`, `muet`, `muet_tahun`, `muet_gred`, `tkh_senate`, `major`, `minor`, `is_integrasi`, `d_cipta`) 
            VALUES(".tosql($id_pemohon).", '3', ".tosql($tahun1).", ".tosql($peringkat1).", ".tosql($cgpa1).", ".tosql($inst_keluar_sijil1).", 
                ".tosql($inst_francais1).", ".tosql($bidang1).", ".tosql($pengkhususan1).", ".tosql($biasiswa1).", 
                ".tosql($muet1).", ".tosql($muet_tahun).", ".tosql($muet_gred).", 
                ".tosql($tkh_senate_db).", ".tosql($major1).", ".tosql($minor1).", ".tosql($is_api).", ".tosql(date("Y-m-d H:i:s")).")";
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
        $path = '/var/www/upload/'.$id_pemohon.'/'; // upload directory
        if (file_exists($path)) {
            $path = $path;
        } else {
            mkdir($path);
            $path = '/var/www/upload/'.$id_pemohon.'/';
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
        $path = '/var/www/upload/'.$id_pemohon.'/'; // upload directory
        if (file_exists($path)) {
            $path = $path;
        } else {
            mkdir($path);
            $path = '/var/www/upload/'.$id_pemohon.'/';
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
        $path = '/var/www/upload/'.$id_pemohon.'/'; // upload directory
        if (file_exists($path)) {
            $path = $path;
        } else {
            mkdir($path);
            $path = '/var/www/upload/'.$id_pemohon.'/';
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

	clear_jawatan($id_pemohon);

} else if($frm=='PROFESIONAL'){

	if($pro=='SAVE'){ 
		 //$conn->debug=true;
		$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
		$professional_1=isset($_REQUEST["professional_1"])?$_REQUEST["professional_1"]:"";
		$professional_d_1=isset($_REQUEST["professional_d_1"])?$_REQUEST["professional_d_1"]:"";
		$professional_no_ahli_1=isset($_REQUEST["professional_no_ahli_1"])?$_REQUEST["professional_no_ahli_1"]:"";
		$rsIC = $conn->query("SELECT ICNo FROM $schema2.calon WHERE id_pemohon=$id_pemohon");


		if(!empty($id_pemohon)){

			$sqlu = "UPDATE $schema2.`calon` SET `professional_1`=".tosql($professional_1).", `professional_d_1`=".tosql(DBDate($professional_d_1)).", 
			`professional_no_ahli_1`=".tosql($professional_no_ahli_1);
			$sqlu .= " WHERE `id_pemohon`=".tosql($id_pemohon);
			$rss = $conn->execute($sqlu);

		}

		if($rss){ $err = 'OK'; } else { $err='ERR'; }

		if(!empty($_FILES['file_profesional']['name'])){ 
			// $conn->debug=true;
			// $type='PMR';
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif','pdf','JPEG', 'JPG', 'PNG', 'GIF','PDF'); // valid extensions
	        $path = '/var/www/upload/'.$id_pemohon.'/'; // upload directory
	        if (file_exists($path)) {
	            $path = $path;
	        } else {
	            mkdir($path);
	            $path = '/var/www/upload/'.$id_pemohon.'/';
	        }

	        $img = $_FILES['file_profesional']['name'];
	        $tmp = $_FILES['file_profesional']['tmp_name'];
	        
	        $ext = end((explode(".", $img))); 
	        // $fname = $img; //$id.".".$ext;
	        // $fname = str_replace(" ", "_", $fname);
	        // $fname = str_replace("-", "_", $fname);

	        // $final_image = "docSenaraiSemak_D3_1_".$appli_id2."_".$item_id.".".$ext;
	        // $final_image = rand(1000,1000000)."_".$fname;
	        $final_image = strtolower($rsIC->fields['ICNo']."_SIJIL_PRO.".$ext);
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
				

				$rsu = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='PRO' AND `id_pemohon`=".tosql($id_pemohon));
				if($rsu->EOF){ 
					$sqlu = "INSERT INTO $schema2.`calon_sijil`(`id_pemohon`, `jenis_sijil`, `sijil_nama`, `sijil_size`, `sijil_type`, `dt_create`) 
					VALUES('{$id_pemohon}', 'PRO', '{$final_image}', ".tosql($sijil_size).", '{$sijil_type}', '{$dt}')";
				} else {
					$sqlu = "UPDATE $schema2.`calon_sijil` SET `sijil_nama`='{$final_image}', `sijil_size`=".tosql($sijil_size).", 
					`sijil_type`=".tosql($sijil_type).", `dt_update`='{$dt}' WHERE `jenis_sijil`='PRO' AND `id_pemohon`=".tosql($id_pemohon);				
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
	} else if($pro=='DEL'){

		$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
		if(!empty($id_pemohon)){

			$sqlu = "UPDATE $schema2.`calon` SET `professional_1`=NULL, `professional_d_1`=NULL, `professional_no_ahli_1`=NULL";
			$sqlu .= " WHERE `id_pemohon`=".tosql($id_pemohon);
			$rss = $conn->execute($sqlu);

			$rs = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='PRO' AND `id_pemohon`='{$id_pemohon}'");
			if(!$rs->EOF){
				$sqld = "DELETE FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='PRO' AND `id_pemohon`='{$id_pemohon}'";
				$path = '/var/www/upload/'.$id_pemohon.'/'.$rs->fields['sijil_nama']; // upload directory
				$conn->execute($sqld);
				unlink($path);
			}
		}

		if($rss){ 
			$err = 'OK'; 
			clear_jawatan($id_pemohon);
		} else { 
			$err='ERR'; 
		}
	}

} else if($frm=='ULANGAN'){

	if($pro=='SAVE'){ 
		//$conn->debug=true;
		$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
		$vals1=isset($_REQUEST["vals1"])?$_REQUEST["vals1"]:"";
		$vals2=isset($_REQUEST["vals2"])?$_REQUEST["vals2"]:"";
		$vals3=isset($_REQUEST["vals3"])?$_REQUEST["vals3"]:"";
		$vals4=isset($_REQUEST["vals4"])?$_REQUEST["vals4"]:"";

		$spm_id1=isset($_REQUEST["spm_id1"])?$_REQUEST["spm_id1"]:"";
		$tahun1=isset($_REQUEST["tahun1"])?$_REQUEST["tahun1"]:"";
		$mp1=isset($_REQUEST["mp1"])?$_REQUEST["mp1"]:"";
		$gred1=isset($_REQUEST["gred1"])?$_REQUEST["gred1"]:"";
		$bm1=isset($_REQUEST["bm1"])?$_REQUEST["bm1"]:"";
		$lisan1=isset($_REQUEST["lisan1"])?$_REQUEST["lisan1"]:"";

		$spm_id2=isset($_REQUEST["spm_id2"])?$_REQUEST["spm_id2"]:"";
		$tahun2=isset($_REQUEST["tahun2"])?$_REQUEST["tahun2"]:"";
		$mp2=isset($_REQUEST["mp2"])?$_REQUEST["mp2"]:"";
		$gred2=isset($_REQUEST["gred2"])?$_REQUEST["gred2"]:"";
		$bm2=isset($_REQUEST["bm2"])?$_REQUEST["bm2"]:"";
		$lisan2=isset($_REQUEST["lisan2"])?$_REQUEST["lisan2"]:"";


		$spm_id3=isset($_REQUEST["spm_id3"])?$_REQUEST["spm_id3"]:"";
		$tahun3=isset($_REQUEST["tahun3"])?$_REQUEST["tahun3"]:"";
		$mp3=isset($_REQUEST["mp3"])?$_REQUEST["mp3"]:"";
		$gred3=isset($_REQUEST["gred3"])?$_REQUEST["gred3"]:"";
		$bm3=isset($_REQUEST["bm3"])?$_REQUEST["bm3"]:"";
		$lisan3=isset($_REQUEST["lisan3"])?$_REQUEST["lisan3"]:"";


		$spm_id4=isset($_REQUEST["spm_id4"])?$_REQUEST["spm_id4"]:"";
		$tahun4=isset($_REQUEST["tahun4"])?$_REQUEST["tahun4"]:"";
		$mp4=isset($_REQUEST["mp4"])?$_REQUEST["mp4"]:"";
		$gred4=isset($_REQUEST["gred4"])?$_REQUEST["gred4"]:"";
		$bm4=isset($_REQUEST["bm4"])?$_REQUEST["bm4"]:"";
		$lisan4=isset($_REQUEST["lisan4"])?$_REQUEST["lisan4"]:"";

		$akg1 = isset($_REQUEST["akg1"]) ? $_REQUEST["akg1"] : "";
		$akg2 = isset($_REQUEST["akg2"]) ? $_REQUEST["akg2"] : "";
		$akg3 = isset($_REQUEST["akg3"]) ? $_REQUEST["akg3"] : "";
		$akg4 = isset($_REQUEST["akg4"]) ? $_REQUEST["akg4"] : "";

		$type="ULANG";

		$rsIC = $conn->query("SELECT ICNo FROM $schema2.calon WHERE id_pemohon=$id_pemohon");


		if(!empty($id_pemohon)){
			// Loop melalui 4 slot untuk penjimatan kod
			for($i=1; $i<=4; $i++){
				$sid = ${"spm_id$i"};
				$thn = ${"tahun$i"};
				$matap = ${"mp$i"};
				$grd = ${"gred$i"};
				$b_m = ${"bm$i"};
				$lsn = ${"lisan$i"};
				$akg = ${"akg$i"};

				if(!empty($thn) && !empty($matap) && !empty($grd)){
					if(!empty($sid)){ 
						// UPDATE berserta Angka Giliran
						$sql = "UPDATE $schema2.`calon_spm` SET 
								`tahun`=".tosql($thn).", 
								`matapelajaran`=".tosql($matap).", 
								`gred`=".tosql($grd).", 
								`jenis_sijil`=".tosql($b_m).", 
								`ujian_lisan`=".tosql($lsn).",
								`angka_giliran`=".tosql($akg).", 
								`d_kemaskini`='{$date}' 
								WHERE `spm_id`=".tosql($sid);
					} else {
						// INSERT berserta Angka Giliran
						$new_id = date("YmdHisN").uniqid();
						$sql = "INSERT INTO $schema2.`calon_spm`(`spm_id`, `id_pemohon`, `tahun`, `matapelajaran`, `gred`, `jenis_xm`, `jenis_sijil`, `ujian_lisan`, `angka_giliran`, `d_cipta`, `d_kemaskini`)
								VALUES('{$new_id}', '{$id_pemohon}', ".tosql($thn).", ".tosql($matap).", ".tosql($grd).", 'T', ".tosql($b_m).", ".tosql($lsn).", ".tosql($akg).", '{$date}', '{$date}')";
					}
					$rss = $conn->execute($sql);
				}
			}
		}

		if($rss){ $err = 'OK'; } else { $err='ERR'; }

		if(!empty($_FILES['file1']['name'])){ 
			// $conn->debug=true;
			// $type='PMR';
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif','JPEG', 'JPG', 'PNG', 'GIF','PDF'); // valid extensions
	        $path = '/var/www/upload/'.$id_pemohon.'/'; // upload directory
	        if (file_exists($path)) {
	            $path = $path;
	        } else {
	            mkdir($path);
	            $path = '/var/www/upload/'.$id_pemohon.'/';
	        }

	        $img = $_FILES['file1']['name'];
	        $tmp = $_FILES['file1']['tmp_name'];
		
	        
	        $ext = end((explode(".", $img))); 
	        // $fname = $img; //$id.".".$ext;
	        // $fname = str_replace(" ", "_", $fname);
	        // $fname = str_replace("-", "_", $fname);

	        // $final_image = "docSenaraiSemak_D3_1_".$appli_id2."_".$item_id.".".$ext;
	        // $final_image = rand(1000,1000000)."_".$fname;
	        $final_image = strtolower($rsIC->fields['ICNo']."_".$type.".".$ext);
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


				$rsu = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='ULANG' AND `id_pemohon`=".tosql($id_pemohon));
				if($rsu->EOF){ 
					$sqlu = "INSERT INTO $schema2.`calon_sijil`(`id_pemohon`, `jenis_sijil`, `sijil_nama`, `sijil_size`, `sijil_type`, `dt_create`) 
					VALUES('{$id_pemohon}', 'ULANG', '{$final_image}', ".tosql($sijil_size).", '{$sijil_type}', '{$dt}')";
				} else {
					$sqlu = "UPDATE $schema2.`calon_sijil` SET `sijil_nama`='{$final_image}', `sijil_size`=".tosql($sijil_size).", 
					`sijil_type`=".tosql($sijil_type).", `dt_update`='{$date}' WHERE `jenis_sijil`='ULANG' AND `id_pemohon`=".tosql($id_pemohon);				
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

	} else if($pro=='ULANGAN_DEL'){

		$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
		$sid=isset($_REQUEST["sid"])?$_REQUEST["sid"]:"";

		$rs = $conn->query("SELECT * FROM $schema2.`calon_spm` WHERE `jenis_xm`='T' AND `id_pemohon`='{$id_pemohon}' AND `spm_id`='{$sid}'");
		if(!$rs->EOF){
			$sqld = "DELETE FROM $schema2.`calon_spm` WHERE `jenis_xm`='T' AND `id_pemohon`='{$id_pemohon}' AND `spm_id`='{$sid}'";
			$rss = $conn->execute($sqld);		
			if($rss){ 	
			    $err='OK';
			    clear_jawatan($id_pemohon);
			} else { 
				$err = 'ERR'; 
			}
		}

	} else if($pro=='CLEAR'){

		$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
		$actions=isset($_REQUEST["actions"])?$_REQUEST["actions"]:"";
		if(!empty($id_pemohon)){

			$sqld = "DELETE FROM $schema2.`calon_spm` WHERE `jenis_xm`='T' AND `id_pemohon`='{$id_pemohon}'";
			$rss = $conn->execute($sqld);		

			$rs = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='ULANG' AND `id_pemohon`='{$id_pemohon}'");
			if(!$rs->EOF){
				$sqld = "DELETE FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='ULANG' AND `id_pemohon`='{$id_pemohon}'";
				$path = '/var/www/upload/'.$id_pemohon.'/'.$rs->fields['sijil_nama']; // upload directory
				$conn->execute($sqld);
				unlink($path);
			}
		}

		if($rss){ 
			$err = 'OK'; 
			clear_jawatan($id_pemohon);
		} else { 
			$err='ERR'; 
		}

	}


} else if($frm=='SVM'){
	// $conn->debug=true;
	if($pro=='SAVE'){
        $id_pemohon = isset($_REQUEST["id_pemohon"]) ? $_REQUEST["id_pemohon"] : "";
        $actions = isset($_REQUEST["actions"]) ? $_REQUEST["actions"] : "";
        
        // Ambil Data Form
        $svm_tahun_1 = isset($_REQUEST["spm_tahun_1"]) ? $_REQUEST["spm_tahun_1"] : "";
        $svm_jenis_sijil_1 = isset($_REQUEST["spm_jenis_sijil_1"]) ? $_REQUEST["spm_jenis_sijil_1"] : "";
        $svm_sijil_1 = isset($_REQUEST["svm_sijil_1"]) ? $_REQUEST["svm_sijil_1"] : "";
        $gred_bm_1 = isset($_REQUEST["gred_bm_1"]) ? $_REQUEST["gred_bm_1"] : "";
        $svm_pngk = isset($_REQUEST["svm_pngk"]) ? $_REQUEST["svm_pngk"] : "";
        $svm_pngkv = isset($_REQUEST["svm_pngkv"]) ? $_REQUEST["svm_pngkv"] : "";
        
        // Tambahan: Angka Giliran & Integrasi
        $svm_angka_giliran = isset($_REQUEST["svm_angka_giliran"]) ? $_REQUEST["svm_angka_giliran"] : "";
        // Default T jika tiada
        $is_integrasi = isset($_REQUEST["is_integrasi_svm"]) && $_REQUEST["is_integrasi_svm"] == '1' ? 'Y' : 'T';

        // Fallback value
        $spm_sijil_pilih = isset($_REQUEST["spm_sijil_pilih"]) ? $_REQUEST["spm_sijil_pilih"] : "";
        $spm_tahun_pilih = isset($_REQUEST["spm_tahun_pilih"]) ? $_REQUEST["spm_tahun_pilih"] : "";

        if(empty($svm_tahun_1)){ $svm_tahun_1=$spm_tahun_pilih; }
        if(empty($svm_jenis_sijil_1)){ $svm_jenis_sijil_1=$spm_sijil_pilih; }

        $rsIC = $conn->query("SELECT ICNo FROM $schema2.calon WHERE id_pemohon=$id_pemohon");

        // 1. UPDATE TABLE CALON (Maklumat Umum Sijil)
        if($actions==1){ 
            $type='SVM1';
            $sql = "UPDATE $schema2.calon  SET spm_tahun_1=".tosql($svm_tahun_1).", spm_jenis_sijil_1=".tosql($svm_jenis_sijil_1)." WHERE `id_pemohon`=".tosql($id_pemohon);
        } else { 
            $type='SVM2';
            $sql = "UPDATE $schema2.calon  SET spm_tahun_2=".tosql($svm_tahun_1).", spm_jenis_sijil_2=".tosql($svm_jenis_sijil_1)." WHERE `id_pemohon`=".tosql($id_pemohon);
        }
        $conn->execute($sql);

        // 2. UPDATE/INSERT TABLE CALON_SVM (Maklumat Terperinci)
        // Semak rekod wujud (boleh tambah check actions/bil_keputusan jika perlu, tapi nampak gaya table calon_svm guna tahun sebagai unique key bersama id)
        // Jika sistem benarkan 2 SVM pada tahun sama, logic 'check' ini perlu diperbaiki. 
        // Asumsi semasa: 1 tahun = 1 rekod SVM.
        
        $rs = $conn->query("SELECT * FROM $schema2.`calon_svm` WHERE `id_pemohon`=".tosql($id_pemohon)." AND `tahun`=".tosql($svm_tahun_1));
        
        if($rs->EOF){
            // INSERT
            $sql = "INSERT INTO $schema2.`calon_svm`(`id_pemohon`, `tahun`, `jenis_sijil`, `nama_sijil`, `gred_bm`, `svm_pngk`, `svm_pngkv`, `angka_giliran`, `is_integrasi`, `create_dt`, `updated_dt`)";
            $sql .= " VALUES(".tosql($id_pemohon).",".tosql($svm_tahun_1).",".tosql($svm_jenis_sijil_1).",".tosql($svm_sijil_1).",".tosql($gred_bm_1).",".tosql($svm_pngk).", ".tosql($svm_pngkv).", ".tosql($svm_angka_giliran).", ".tosql($is_integrasi).", ".tosql($date).", ".tosql($date).")";
        } else {
            // UPDATE
            $sql = "UPDATE $schema2.`calon_svm` SET 
                `jenis_sijil`=".tosql($svm_jenis_sijil_1).", 
                `nama_sijil`=".tosql($svm_sijil_1).", 
                `gred_bm`=".tosql($gred_bm_1).", 
                `svm_pngk`=".tosql($svm_pngk).", 
                `svm_pngkv`=".tosql($svm_pngkv).", 
                `angka_giliran`=".tosql($svm_angka_giliran).",
                `is_integrasi`=".tosql($is_integrasi).",
                `updated_dt`=".tosql($date)."    
                WHERE `id_pemohon`=".tosql($id_pemohon)." AND `tahun`=".tosql($svm_tahun_1);
        }
		$rsn = $conn->execute($sql);

		if($rsn){ 	
		    $err='OK';
		    clear_jawatan($id_pemohon);
		} else { 
			$err = 'ERR'; 
		}
		// print "UPL:".$_FILES['file_pmr']['name'];
		//$sijil_pmr=isset($_REQUEST["sijil_pmr"])?$_REQUEST["sijil_pmr"]:"";
		if(!empty($_FILES['file_pmr']['name'])){ 
			//$conn->debug=true;
			// $type='SVM';
			$valid_extensions = array('jpeg', 'jpg', 'png', 'gif','pdf','JPEG', 'JPG', 'PNG', 'GIF','PDF'); // valid extensions
	        $path = '/var/www/upload/'.$id_pemohon.'/'; // upload directory
	        if (file_exists($path)) {
	            $path = $path;
	        } else {
	            mkdir($path);
	            $path = '/var/www/upload/'.$id_pemohon.'/';
	        }

	        $img = $_FILES['file_pmr']['name'];
	        $tmp = $_FILES['file_pmr']['tmp_name'];
	        
	        $ext = end((explode(".", $img))); 
	        // $fname = $img; //$id.".".$ext;
	        // $fname = str_replace(" ", "_", $fname);
	        // $fname = str_replace("-", "_", $fname);

	        // $final_image = "docSenaraiSemak_D3_1_".$appli_id2."_".$item_id.".".$ext;
	        // $final_image = rand(1000,1000000)."_".$fname;
	        $final_image = strtolower($rsIC->fields['ICNo']."_".$type.".".$ext); 
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
				
				$rsu = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='{$type}' AND `id_pemohon`=".tosql($id_pemohon));
				if($rsu->EOF){ 
					$sqlu = "INSERT INTO $schema2.`calon_sijil`(`id_pemohon`, `jenis_sijil`, `sijil_nama`, `sijil_size`, `sijil_type`, `dt_create`) 
					VALUES('{$id_pemohon}', '{$type}', '{$final_image}', ".tosql($sijil_size).", '{$sijil_type}', '{$dt}')";
				} else {
					$sqlu = "UPDATE $schema2.`calon_sijil` SET `sijil_nama`='{$final_image}', `sijil_size`=".tosql($sijil_size).", 
					`sijil_type`=".tosql($sijil_type).", `dt_update`='{$date}' WHERE `jenis_sijil`='{$type}' AND `id_pemohon`=".tosql($id_pemohon);				
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
	} else if($pro=='SVM_DELALL'){
		$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
	 	//$conn->debug=true;
		//DELETE SEMUA MAKLUMAt KELULUSAN SVM
		$rss = $conn->execute("UPDATE $schema2.`calon` SET `spm_tahun_1`=NULL, `spm_jenis_sijil_1`=NULL, `spm_pangkat_1`=NULL,
			`spm_tahun_2`=NULL, `spm_jenis_sijil_2`=NULL, `spm_pangkat_2`=NULL  
			WHERE `id_pemohon`=".tosql($id_pemohon));

		if($rss){
			// $err='OK';
			$rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil` IN ('SPM1','SPM2','SVM1','SVM2') AND `id_pemohon`=".tosql($id_pemohon));
			if(!$rsSijil->EOF){
				while(!$rsSijil->EOF){
		        		$files = '/var/www/upload/'.$id_pemohon.'/'.$rsSijil->fields['sijil_nama']; // upload directory
					unlink($files);
					$rsSijil->movenext();
				}
				$conn->execute("DELETE FROM $schema2.`calon_sijil` WHERE `jenis_sijil` LIKE 'SVM%' AND `id_pemohon`=".tosql($id_pemohon));
			}
			$err='OK'; //;index.php?data='.base64_encode('akademik/spm;MAKLUMAT AKADEMIK;Maklumat SPM/SPVM/SPM(V);;1;;');
			$sqld = "DELETE FROM $schema2.`calon_svm` WHERE `id_pemohon`=".tosql($id_pemohon);
			$conn->execute($sqld);
			
			$_SESSION['SESS_SPMSIJIL']="";
			$_SESSION['SESS_SPMTAHUN']="";
			$_SESSION['SESS_SPMSIJIL2']="";
			$_SESSION['SESS_SPMTAHUN2']="";
			clear_jawatan($id_pemohon);

		} else {
			$err='ERR';
		}

	} else if($pro=='DEL'){

		// $conn->debug=true;
		$id_pemohon=isset($_REQUEST["id_pemohon"])?$_REQUEST["id_pemohon"]:"";
		$actions=isset($_REQUEST["actions"])?$_REQUEST["actions"]:"";
		$spm_tahun_1=isset($_REQUEST["spm_tahun_1"])?$_REQUEST["spm_tahun_1"]:"";
		if(!empty($id_pemohon)){

			// $subj = "'002'";
			if($actions==1){
				$data = $conn->query("SELECT `spm_tahun_1` FROM $schema2.`calon` WHERE `id_pemohon`=".tosql($id_pemohon));
				$tahuns = $data->fields['spm_tahun_1'];
				$rss = $conn->execute("UPDATE $schema2.`calon` SET `spm_tahun_1`=NULL, `spm_jenis_sijil_1`=NULL, `spm_pangkat_1`=NULL, `spm_lisan_1`=NULL 
					WHERE `id_pemohon`=".tosql($id_pemohon));
				$borang='SVM1';
			} else if($actions==2){
				$data = $conn->query("SELECT `spm_tahun_2` FROM $schema2.`calon` WHERE `id_pemohon`=".tosql($id_pemohon));
				$tahuns = $data->fields['spm_tahun_2'];
				$rss = $conn->execute("UPDATE $schema2.`calon` SET `spm_tahun_2`=NULL, `spm_jenis_sijil_2`=NULL, `spm_pangkat_2`=NULL, `spm_lisan_2`=NULL  
					WHERE `id_pemohon`=".tosql($id_pemohon));
				$borang='SVM2';
			}

			$sqlu = "DELETE FROM $schema2.`calon_svm` WHERE `id_pemohon`=".tosql($id_pemohon)." AND `tahun`=".tosql($tahuns);
			$rss = $conn->execute($sqlu);

			$rs = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='{$borang}' AND `id_pemohon`='{$id_pemohon}'");
			if(!$rs->EOF){
				$sqld = "DELETE FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='{$borang}' AND `id_pemohon`='{$id_pemohon}'";
				$path = '/var/www/upload/'.$id_pemohon.'/'.$rs->fields['sijil_nama']; // upload directory
				$conn->execute($sqld);
				unlink($path);
			}
		}

		if($rss){ $err = 'OK'; 
			clear_jawatan($id_pemohon);
			$_SESSION['SESS_SPMSIJIL']="";
			$_SESSION['SESS_SPMTAHUN']="";
			$_SESSION['SESS_SPMSIJIL2']="";
			$_SESSION['SESS_SPMTAHUN2']="";
			//if($err=='OK'){
				//$sql = "$schema2.`calon_jawatan_dipohon` WHERE `id_pemohon`=".tosql($id_pemohon);
				//$conn->execute($sql);
			//}
		} else { $err='ERR'; }
	}

}

if($frm=='SRP' || $frm=='SPM' || $frm=='STPM' || $frm=='STAM' || $frm=='UNIV' || $frm=='SVM'){
	set_tarikh($id_pemohon, "tkh_upd_akademik");


	//$sql = "$schema2.`calon_jawatan_dipohon` WHERE `id_pemohon`=".tosql($id_pemohon);
	//$conn->execute($sql);

}

// header("Content-Type: text/json");
// print json_encode($err); 
print $err;
?>
