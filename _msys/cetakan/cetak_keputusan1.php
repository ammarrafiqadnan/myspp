<?php
namespace Dompdf;
require_once '../dompdf/autoload.inc.php';
include_once '../../connection/common.php';

ob_clean();
//$connOra = odbc_connect('oracle_dsn', 'esmsm_data', 'abc123');
//include '../../connection/common_oracle.php';

$connOra = odbc_connect('oracle_dsn', 'esmsm_data', 'abc123');
if ($connOra) {
    //echo "Oracle ODBC connection successful!";
    //odbc_close($connOra);
} else {
	//echo "Oracle ODBC connection failed!";
	print "Oracle ODBC connection failed!";
}

//$conn->debug=true;
$pdro=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";
$pro=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";

//print "ID:".$id.":".$id2;

$sql = "SELECT * FROM $schema2.`calon` WHERE `id_pemohon`=".tosql($id);
//$rs = $conn->query($sql);


//$sqlD = "SELECT * FROM $schema2.`senarai_panggilan_temuduga` WHERE `noKP`=".tosql($rs->fields['ICNo'])." AND is_deleted=0";
$sqlD = "SELECT * FROM $schema2.`senarai_keputusan_temuduga` WHERE `noKP`=".tosql($id)." AND is_deleted=0";
$rsD = $conn->query($sqlD);

$noKP = $rsD->fields['noKP'];

$no_pemerolehan = $rsD->fields['no_pemerolehan'];

//$linkpdf = include '/var/www/html/myspp/upload_doc/berjaya-akp19.pdf';


//getdata from eSPP
//$connOra->debug=true;
$sqlOracle = "SELECT
    P.RUJUKAN_KAMI AS RUJUKAN,
    TL.TARIKH_SURAT AS TKH_SURAT,
    to_char (TL.TARIKH_LANTIKAN, 'dd/mm/rrrr') AS TKH_LANTIK, 
    TL.SD_PER_NO_PEMEROLEHAN AS pemerolehan,
    C.NAMA_PENUH AS NAMA,
    C.NO_KP_BARU AS NO_KP,
    C.ALAMAT_1 AS ALAMAT1,
    C.ALAMAT_2 AS ALAMAT2,
    C.ALAMAT_3 AS ALAMAT3,
    C.POSKOD AS POSKOD,
    C.BANDAR AS BANDAR,
    (SELECT DISKRIPSI FROM negeri WHERE KOD=C.TEMPAT_TINGGAL) AS negeri,
    TL.GRED_GAJI_MULA AS GAJI,
    (SELECT GGT.AMAUN FROM gred_gaji_det GGT WHERE  GGT.GGH_KOD = TL.GRED_GAJI_MULA AND GGT.PERINGKAT = TL.PERINGKAT AND GGT.TAHUN = TL.TAHUN) AS AMAUN_MATRIKS,
    (SELECT GGM.GAJI_MINIMUM FROM gred_gaji_min_mak GGM WHERE TL.GRED_GAJI_MULA = GGM.GRED_GAJI AND TL.TAHAP_GAJI_MIN = GGM.TAHAP_GAJI_MIN AND TL.GAJI_MINIMUM = GGM.GAJI_MINIMUM) AS AMAUN_MINMAX,
    TL.SD_SD1_SKI_KOD AS JAWATAN,
    TL.GAJI_MINIMUM AS AMAUN_SB,
    PEG.NAMA AS NAMA_PEGAWAI,
	S.DISKRIPSI AS SKIM,
	SP.DISKRIPSI AS SKIM_PKHIDMAT ,
	SSM.DISKRIPSI AS KUMP_PKHIDMAT,
	K.DISKRIPSI AS KLASIFIKASI
FROM 
    calon C,
    tawaran_lantik TL,
    pemerolehan P,
    pgspa_det det,
    pgspa pg,
    pegawai PEG,
    skim s,
    skim_pkhidmat sp,
    kump_ssm ssm,
    klasifikasi K
WHERE 
    C.NO_PENGENALAN = TL.SD_SD1_CAL_NO_PENGENALAN
	AND TL.SD_PER_NO_PEMEROLEHAN = '{$no_pemerolehan}'
    AND TL.SD_PER_NO_PEMEROLEHAN = P.NO_PEMEROLEHAN
    AND PEG.KOD = TL.PEG_KOD  
    AND TL.SD_SD1_SKI_KOD = S.KOD
    AND S.SKIM_PKHIDMAT = SP.KOD
    AND S.KUMP_PKHIDMAT_SSB = SSM.KOD
    AND P.NO_PEMEROLEHAN = DET.PER_NO_PEMEROLEHAN
    AND DET.PGS_KOD = PG.KOD
    AND PG.KLA_KOD = K.KOD
	AND C.NO_KP_BARU=".tosql($noKP);

$result = odbc_exec($connOra,$sqlOracle);
print $sqlOracle;
print_r($result);
exit;
if ($result) {
	//print "DATA";
	while($row = odbc_fetch_array( $result )){
		//print "DATA2";
		$rujukan = $row['RUJUKAN'];
		$tkhSurat = $row['TKH_SURAT'];
		$tkhLantik = $row['TKH_LANTIK'];
		$nama = $row['NAMA'];
		$noKp = $row['NO_KP'];
		$alamat1 = $row['ALAMAT1'];
		$alamat2 = $row['ALAMAT2'];
		$alamat3 = $row['ALAMAT3'];
		$poskod = $row['POSKOD'];
		$bandar = $row['BANDAR'];
		$negeri = $row['NEGERI'];
		$skim = $row['JAWATAN'];
		$gaji = $row['GAJI'];
		$amaun = $row['AMAUN_MATRIKS'];
		$amaun2 = $row['AMAUN_MINMAX'];
		$amaun3 = $row['AMAUN_SB'];
		$stat_skim = $row['STATUS_SKIM'];
		$nama_pegawai = $row['NAMA_PEGAWAI'];
		$pemerolehan = $row['PEMEROLEHAN'];	
		$jawatanb = $row['SKIM'];
		$skimPerkhidmatan = $row['SKIM_PKHIDMAT'];
		$klasifikasi = "PERKHIDMATAN " . $row['KLASIFIKASI'];
		$kumpulan = $row['KUMP_PKHIDMAT'];
	}

}

if ($amaun <> NULL && $amaun <> '-' && $amaun2 == NULL && $amaun3 == NULL)
{
	$jum = 'RM '.$amaun. ' : JADUAL GAJI MINIMUM-MAKSIMUM GRED ' .$gaji;
}

// paparan gaji min-max
if ($amaun2 <> NULL && $amaun2 <> '-' && $amaun == NULL && $amaun3 == NULL)
{
	$jum = 'RM '.$amaun2. ' : JADUAL GAJI MINIMUM-MAKSIMUM GRED ' .$gaji;
}

// paparan gaji sedang berkhidmat free text
if ($amaun3 <> NULL && $amaun3 <> '-')
{
	$jum = 'RM '.$amaun3. ' : JADUAL GAJI MINIMUM-MAKSIMUM GRED ' .$gaji;
}

if(!empty($tkhLantik)){
	$tL = date('d-m-Y',strtotime($tkhLantik));
} else {
	$tL = '';
}


/*
//$conn->debug=true;
$sqlJ = "SELECT * FROM $schema2.`calon_jawatan_dipohon` A, $schema1.`ref_skim` B WHERE A.`kod_jawatan`=B.`KOD`";
//$sqlJ .= " AND A.`id_pemohon`=".tosql($id);  
$sqlJ .= " ORDER BY A.`seq_no` ASC";
$rsJawatan1 = $conn->query($sqlJ); $bil=0;
$conn->debug=false;

$bl=0; $J1=''; $J2=''; $J3=''; 
if(!$rsJawatan1->EOF){
    while(!$rsJawatan1->EOF){
        if($bl==0){
            $J1 = $rsJawatan1->fields['DISKRIPSI'];
        } else if($bl==1){ 
            $J2 = $rsJawatan1->fields['DISKRIPSI'];
        } else {
            $J3 = $rsJawatan1->fields['DISKRIPSI'];
        }
        $bl++; $Jawatan='Lengkap';
        $rsJawatan1->movenext();
    }
}
*/
// $data = file_get_contents('../images/Logo_Simpeni.png');
$data = file_get_contents('../images/top_jata_negara.png');
$base64 = 'data:image/png;base64,' . base64_encode($data);

// $dataB = file_get_contents('../images/blur_jakim_logo.png');
$dataB = file_get_contents('../images/blur_jata_negara.png');
$base64B = 'data:image/png;base64,' . base64_encode($dataB);

$pages = '../upload_doc/berjaya-akp19.pdf'; 

if(empty($tL)){
	$tL = 'TARIKH MELAPORKAN DIRI BERTUGAS SEPERTIMANA YANG DITETAPKAN OLEH KEMENTERIAN PENDIDIKAN MALAYSIA.';
}

$html ='
<style>
table, tr, td, p, div{
    font-family: Arial, Helvetica, sans-serif;
    font-size: 11px;
}
.footer {
   position: fixed;
   left: 0;
   bottom: 0;
   width: 100%;
   color: #000;
   text-align: center;
}

@media print {
    .pagebreak {
        clear: both;
        page-break-after: always;
    }
}
</style>
<body style="background-image: url('.$base64B.'); background-position: center; background-repeat: no-repeat;
  background-attachment: fixed;  
  background-size: 48%;">
<!--<table width="90%" cellpadding="5" cellspacing="0" align="center">
    <tr>
        <td width="100%" valign="top" align="center">-->
            <table width="100%" cellpadding="0" cellspacing="0" border="0">                  
                <tr>
                    <td width="10%" valign="top">
                        <img src="../assets/images/jata_negara.png" style="width:87px;" height="77px"  alt="base"  />
                    <td>
                    <td width="90%">
                        <font style="font-size:14px">
                            <b>SURUHANJAYA PERKHIDMATAN PENDIDIKAN MALAYSIA</b><br>
                            <table width="100%" cellpadding="3" cellspacing="0" border="0">     
                                <tr>
                                    <td width="100%">
                                                    ARAS 1-4, BLOK F9, KOMPLEKS F, <br>
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0"> 
                                        <tr>
                                            <td width="60%">LEBUH PERDANA TIMUR,</td> 
                                            <td width="40%">Telefon : 03-8000 8000</td>
                                        </tr>
                                        <tr>
                                            <td>PRESINT 1, 62000 PUTRAJAYA.</td> 
                                            <td>Faks : 03-8871 7499 (Khidmat Pengurusan)/</td>
                                        </tr>
                                        <tr>
                                            <td></td> 
                                            <td>03-8871 7492 (Perkhidmatan)/</td>
                                        </tr>
                                        <tr>
                                            <td></td> 
                                            <td>03-8871 7493 (Naik Pangkat Dan Tatatertib)/</td>
                                        </tr>
                                        <tr>
                                            <td></td> 
                                            <td>03-8871 7494 (Pengambilan Guru)/</td>
                                        </tr>
                                        <tr>
                                            <td></td> 
                                            <td>03-8871 7485 (Pengambilan Bukan Guru)/</td>
                                        </tr>
                                        <tr>
                                            <td></td> 
                                            <td>03-8871 7463 (Dasar/Keurusetiaan)</td>
                                        </tr>
                                        <tr>
                                            <td></td> 
                                            <td>Web : http://www.spp.gov.my</td>
                                        </tr>

                                    </table>
                                </tr>
                            </table>
                        </font>
                    </td>
                </tr>
            </table>
            <hr>
            <table width="100%" cellpadding="3" cellspacing="0" border="0" align="center">
                <tr>
                    <td width="100%" align="right">Ruj. Kami : <b>AKP'.$rsD->fields['noKP'].'</b></td>
                </tr>
                <tr>
                    <td width="100%" align="right">Tarikh : <b>'.DisplayDateF(date('Y-m-d',strtotime($tkhSurat))).'</b></td>
                </tr>

            </table> 
            <br>
            <table width="100%" cellpadding="2" cellspacing="0" border="0" style="font-size:12px">
                
                <tr>
                    <td valign="top" width="30%">NAMA</td>
                    <td valign="top" width="2%">:</td>
                    <td valign="top" width="68%">'.strtoupper($rsD->fields['nama_penuh']).'&nbsp;</td>
                </tr>
                <tr>
                    <td valign="top">NO. KAD PENGENALAN</td>
                    <td valign="top">:</td>
                    <td valign="top">'.strtoupper($rsD->fields['noKP']).'&nbsp;</td>
                </tr>
                <tr>
                    <td valign="top">ALAMAT</td>
                    <td valign="top">:</td>
                    <td valign="top">'.strtoupper($rsD->fields['tempat']).'&nbsp;</td>
                </tr>
            </table>
            <table width="100%" cellpadding="3" cellspacing="0" border="0" align="center">
                <tr>
                    <td width="100%">Tuan/ Puan,</td>
                </tr>

            </table>
            <br>
            <table width="100%" cellpadding="3" cellspacing="0" border="0" align="center">
                <tr>
                    <td width="100%"><b>TAWARAN PELANTIKAN TETAP JAWATAN '.$jawatanb.'</b></td>
                </tr>

            </table>
            <br>
            <table width="100%" cellpadding="3" cellspacing="0" border="0" align="center">
                <tr>
                    <td width="100%">Sukacitanya Suruhanjaya ini menawarkan kepada tuan/puan pelantikan ke jawatan seperti berikut:</td>
                </tr>
            </table>
            <table width="100%" cellpadding="3" cellspacing="0" border="0" align="center">
                <tr>
                    <td valign="top"></td>
                                <td valign="top">(a) (i) Jawatan <br></td>
                                <td valign="top">:</td>
                                <td valign="top">'.$jawatanb.'</td>
                            </tr>
                <tr>
                    <td valign="top"></td>
                                <td valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(ii) Skim Perkhidmatan  <br></td>
                                <td valign="top">:</td>
                                <td valign="top">'.$skimPerkhidmatan.'</td>
                            </tr>
                <tr>
                    <td valign="top"></td>
                                <td valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(iii) Klasifikasi  <br></td>
                                <td valign="top">:</td>
                                <td valign="top">'.$klasifikasi.'</td>
                            </tr>
                <tr>
                    <td valign="top"></td>
                                <td valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(iv) Kumpulan Perkhidmatan <br></td>
                                <td valign="top">:</td>
                                <td valign="top">'.$kumpulan.'</td>
                            </tr>
                <tr>
                    <td valign="top"></td>
                                <td valign="top">(b) Tarikh Lantikan  <br></td>
                                <td valign="top">:</td>
                                <td valign="top">'.$tL.'</td>
                            </tr>
                <tr>
                    <td valign="top"></td>
                                <td valign="top">(c) Gaji Permulaan  <br></td>
                                <td valign="top">:</td>
                                <td valign="top">'.$jum.'</td>
                            </tr>

            </table>
            <br>
            <table width="100%" cellpadding="3" cellspacing="0" border="0" align="center">
                <tr><td></td>
                    <td width="100%">
                        <b>Syarat-syarat Tawaran</b>
                    </td>
                </tr>
                <tr><td></td>
                    <td width="100%">
                        2. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Tawaran ini adalah tertakluk kepada syarat-syarat berikut dan tuan/puan dikehendaki :<br>

                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td width="100%">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>Sebelum melapor diri :</u>

                    </td>
                </tr>


            </table>

            <table width="100%" cellpadding="3" cellspacing="0" border="0" align="center">
                <tr>
                    <td valign="top"></td>
                                <td valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(a) melengkapkan dan menandatangani Surat Setuju Terima Tawaran Pelantikan;<br></td>
                            </tr>
                <tr>
                    <td valign="top"></td>
                                <td valign="top">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(b) menjalani pemeriksaan kesihatan dan diperakui sihat oleh pengamal perubatan berdaftar (pegawai <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; perubatan  kerajaan/swasta) dengan menggunakan Borang Permohonan Pemeriksaan Perubatan Untuk <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Pelantikan Ke Dalam Perkhidmatan Awam;
                    </td>
                            </tr>
                <tr>
                    <td valign="top"></td>
                                <td valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(c) membuat Akuan Berkanun di hadapan Hakim Mahkamah Seksyen/Majistret/Pesuruhjaya Sumpah <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  dengan menggunakan Surat Akuan Berkanun (Akta Berkanun 1960);</td>
                            </tr>
                <tr>
                    <td valign="top"></td>
                    <td valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>Semasa/Selepas melapor diri:</u></td>
                            </tr>
                <tr>
                    <td valign="top"></td>
                                <td valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(d) melengkapkan dan menandatangani Surat Aku Janji di hadapan Ketua Jabatan dengan menggunakan <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  Surat Aku Janji</td>
                            </tr>

            </table>
            <br>
            <table width="100%" cellpadding="3" cellspacing="0" border="0" align="center">
                <tr><td></td>
                    <td width="100%">
                        <b>Syarat-syarat Setuju Terima Tawaran Pelantikan</b>
                    </td>
                </tr>
                <tr><td></td>
                    <td width="100%">
                        3. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Syarat-syarat setuju terima tawaran pelantikan adalah seperti berikut:<br>

                    </td>
                </tr>

            </table>
            <table width="100%" cellpadding="3" cellspacing="0" border="0" align="center">
                <tr>
                    <td valign="top"></td>
                                <td valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(a) melaporkan diri bertugas pada tarikh yang ditetapkan oleh Ketua Jabatan; dan<br></td>
                            </tr>
                <tr>
                    <td valign="top"></td>
                                <td valign="top">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(b) mengemukakan semua dokumen yang telah dilengkapkan seperti yang dinyatakan di perenggan 2 <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; kepada Ketua Jabatan pada tarikh lapor diri bertugas.
                    </td>
                            </tr>
            </table>
	    <br>
             <table width="100%" cellpadding="3" cellspacing="0" border="0" align="center">
                <tr>
                   
                    <td valign="top"><b>*Peringatan:</b><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(a) Surat tawaran ini terbatal sekiranya tuan/puan tidak melapor diri BERTUGAS dalam tempoh 30 hari dari tarikh arahan <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; penempatan.<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(b) Tuan/Puan dinasihatkan untuk menyimpan satu salinan semua dokumen seperti di perenggan 2 bagi tujuan rekod <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; kepada Ketua Jabatan pada tarikh lapor diri bertugas.
				</td>
                 </tr>
            </table>
		 <table width="100%" cellpadding="3" cellspacing="0" border="0" align="center">
                <tr>
                   
                    <td valign="top"></td>
                 </tr>
            </table>
		</table>
		 <table width="100%" cellpadding="3" cellspacing="0" border="0" align="center">
                <tr>
                   
                    <td valign="top"></td>
                 </tr>
            </table>



            <br>
        
                <!--<br /><br /><br />
		
				<div align="center" style="font-size:12px">
                    <b><i>(SLIP INI ADALAH CETAKAN KOMPUTER.TIADA TANDATANGAN DIPERLUKAN)</i></b>
				</div>
                <br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
        	</td>
	<td>
        </tr>
	</table>-->
	<div style="page-break-after: always;"></div>
    <table width="100%" cellpadding="3" cellspacing="0" border="0" align="center">
        <tr><td></td>
            <td width="100%">
                <b>Syarat-syarat Perkhidmatan Yang Ditetapkan</b>
            </td>
        </tr>
        <tr><td></td>
            <td width="100%">
                4. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Syarat-syarat perkhidmatan berikut perlu dipatuhi bagi pelantikan tuan/puan:<br>

            </td>
        </tr>
    </table>
    <table width="100%" cellpadding="3" cellspacing="0" border="0" align="center">
        <tr>
            <td valign="top"></td>
                        <td valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(a) berkhidmat dalam percubaan bagi tempoh 1 hingga 3 tahun. Dalam tempoh percubaan ini, tuan/puan
                dikehendaki <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; hadir dengan jayanya Program Tranformasi Minda dan lulus peperiksaan perkhidmatan yang
                ditetapkan oleh Ketua <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Jabatan/Perkhidmatan sebelum diperaku untuk disahkan dalam perkhidmatan;</td>
                    </tr>
        <tr>
            <td valign="top"></td>
                        <td valign="top">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(b) tertakluk kepada perakuan oleh Ketua Jabatan, tuan/puan yang telah memenuhi syarat dalam tempoh
                percubaan <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; boleh diperakukan kepada Suruhanjaya untuk pengesahan dalam perkhidmatan;
            </td>
                    </tr>
        <tr>
            <td valign="top"></td>
                        <td valign="top">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(c) sebelum tuan/puan disahkan dalam perkhidmatan, tuan/puan akan diberikan opsyen oleh Ketua Jabatan untuk
                 <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; memilih Skim Kumpulan Wang Simpanan Pekerja (KWSP);
            </td>
                    </tr>
        <tr>
            <td valign="top"></td>
                        <td valign="top">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(d) sekiranya tuan/puan menolak Skim KWSP, Ketua Jabatan akan memperakukan tuan/puan untuk pemberian
                taraf <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; berpencen kepada Suruhanjaya setelah genap 3 (tiga) tahun tempoh perkhidmatan yang dimasuk kira;
            </td>
                    </tr>
        <tr>
            <td valign="top"></td>
                        <td valign="top">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(e) perkhidmatan tuan/puan boleh ditamatkan sekiranya gagal disahkan dalam perkhidmatan mengikut peraturan-<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; peraturan yang sedang berkuat kuasa;
            </td>
                    </tr>
        <tr>
            <td valign="top"></td>
                        <td valign="top">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(f) tuan/puan boleh diarahkan untuk berkhidmat di mana-mana tempat oleh Kerajaan; dan;
            </td>
                    </tr>
        <tr>
            <td valign="top"></td>
                        <td valign="top">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(g) tuan/puan adalah tertakluk kepada Perintah Am Kerajaan, Peraturan Perkhidmatan Awam, Skim Perkhidmatan,
                <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Pekeliling, Surat  Pekeliling dan peraturan-peraturan serta arahan-arahan lain yang berkuat kuasa dari semasa ke <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; semasa.
            </td>
                    </tr>

    </table>
	<br>
    <table width="100%" cellpadding="3" cellspacing="0" border="0" align="center">
        <tr>
	    <td></td>
            <td width="100%">
                5. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Sebarang permohonan penetapan gaji permulaan yang lebih tinggi berdasarkan pengalaman terdahulu hanya akan <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; dipertimbangkan sekiranya dikemukakan dalam tempoh tiga (3) tahun dari tarikh lantikan

            </td>
        </tr>
    </table>
	<br>
	<table width="100%" cellpadding="3" cellspacing="0" border="0" align="center">
	<tr>
	    <td></td>
            <td width="100%">
                6. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Suruhanjaya ini boleh meminda tawaran pelantikan ini sekiranya maklumat lantikan yang tidak tepat atau membatalkan <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; tawaran pelantikan ini jika didapati maklumat yang dikemukakan adalah palsu.
            </td>
        </tr>
    </table>
	<br>
	<table width="100%" cellpadding="3" cellspacing="0" border="0" align="center">
	<tr>
	    <td></td>
            <td width="100%">
                7. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Tawaran pelantikan tuan/puan ini adalah tertakluk kepada apa-apa semakan oleh Kerajaan kepada terma dan syarat <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; perkhidmatan dari semasa ke semasa.

            </td>
        </tr>
    </table>
	<br>
	<table width="100%" cellpadding="3" cellspacing="0" border="0" align="center">
	<tr>
	    <td></td>
            <td width="100%">
                <b>Tindakan Ketua Jabatan</b>
            </td>
        </tr>
	<tr>
	    <td></td>
            <td width="100%">
                8. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Ketua Jabatan adalah diminta mengemukakan:
            </td>
        </tr>
    </table>
	<table width="100%" cellpadding="3" cellspacing="0" border="0" align="center">
                <tr>
                    <td valign="top"></td>
                                <td valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(a) Penyata Kewangan 8 (Kew.8); dan</td>
                            </tr>
                <tr>
                    <td valign="top"></td>
                                <td valign="top">
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(b) dokumen di perenggan 2 secara dalam talian melalui Sistem Proses Perkhidmatan (ePROPER) dalam tempoh 30 hari <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   dari tarikh pegawai melapor diri bertugas.
                    </td>
                            </tr>
            </table>
<br>
<table width="100%" cellpadding="3" cellspacing="0" border="0" align="center">
	<tr>
            <td width="100%">
                Sekian, terima kasih
            </td>
	</tr>
    </table>
<br>
<table width="100%" cellpadding="3" cellspacing="0" border="0" align="center">
	<tr>
            <td width="100%">
                <b>"BERKHIDMAT UNTUK NEGARA"</b>
            </td>
        </tr>
    </table>
<br><br>
<table width="100%" cellpadding="3" cellspacing="0" border="0" align="center">
	<tr>
            <td width="100%">
                <b>(MD RADZI BIN HASHIM)</b>
            </td>
        </tr>
	<tr>
            <td width="100%">
                Setiausaha
            </td>
        </tr>
	<tr>
            <td width="100%">
                Suruhanjaya Perkhidmatan Pendidikan
            </td>
        </tr>
	<tr>
            <td width="100%">
                Malaysia
            </td>
        </tr>
</table>


	
<br>
<div align="center" style="font-size:11px">
                    <i>(SURAT INI ADALAH CETAKAN KOMPUTER. TIADA TANDATANGAN DIPERLUKAN)</i>
				</div>



    <!--<br>
    <div class="footer" align="right">
    <p>Tarikh Cetakan : '.date("d/m/Y H:i:s").'</p>
    </div>-->
    </body>';
	// $rs->movenext();
// }


// $html = '<table>Hello World</table>';
$ic=$rsD->fields['noKP'];
//print $html;exit;
//$rs->close();
$conn->close();
//$connOra->close();

$dompdf = new Dompdf(); 
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'potrait');
$dompdf->render();
//$dompdf->stream("keputusan_".$ic,array("Attachment" => false));
//exit(0);

file_put_contents('/var/www/html/upload/keputusan_'.$ic.'.pdf', $dompdf->output());

require_once '../FPDF/fpdf.php';
require_once '../FPDI/src/autoload.php';

use setasign\Fpdi\Fpdi;

// Define the path to the existing PDF and generated PDF
$generatedPdfPath = '/var/www/html/upload/keputusan_'.$ic.'.pdf';
$existingPdfPath = '../upload_doc/berjaya-akp19.pdf';
$outputPdfPath = '/var/www/html/upload/surat_keputusan_'.$ic.'.pdf';

// Create a new FPDI instance
$pdf = new fpdi();

// Add a page from the existing PDF
$pageCount = $pdf->setSourceFile($generatedPdfPath);
for ($i = 1; $i <= $pageCount; $i++) {
    $template = $pdf->importPage($i);
    $pdf->AddPage();
    $pdf->useTemplate($template);
}

// Add a page from the generated PDF
$pageCount = $pdf->setSourceFile($existingPdfPath);
for ($i = 1; $i <= $pageCount; $i++) {
    $template = $pdf->importPage($i);
    $pdf->AddPage();
    $pdf->useTemplate($template);
}

// Save the combined PDF to a file
$pdf->Output($outputPdfPath, 'F');
?>

<embed src="../../upload/surat_keputusan_<?=$ic;?>.pdf" type='application/pdf' width='100%' height='800px' />

