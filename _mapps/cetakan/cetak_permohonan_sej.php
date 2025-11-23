<?php
namespace Dompdf;
require_once 'dompdf/autoload.inc.php';
ob_clean();
// $conn->debug=true;
//if($_SESSION['SESS_UIC']=='840414145982'){ $conn->debug=true; }
$pro=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";
$tkh=isset($_REQUEST["tkh"])?$_REQUEST["tkh"]:"";

//$conn->debug=true;
$sql = "SELECT A.*, B.`tarikh_akuan` AS takuan FROM $schema2.`calon` A, $schema2.`calon_tarikh_sejarah` B WHERE A.`id_pemohon`=B.`id_pemohon` 
AND A.`id_pemohon`=".tosql($id)." AND B.`tarikh_akuan`=".tosql($tkh);
$sql .= " ORDER BY B.`tarikh_akuan` DESC";
$rs = $conn->query($sql);
$negeri = dlookup("$schema2.`ref_negeri`","diskripsi","kod=".tosql($rs->fields['negeri']));


//$sqlJ = "SELECT * FROM $schema2.`calon_jawatan_dipohon` A, $schema1.`ref_skim` B WHERE A.`kod_jawatan`=B.`KOD`";
$sqlJ = "SELECT * FROM $schema2.`calon_tarikh_sejarah` A WHERE A.`jawatan1` IS NOT NULL";
$sqlJ .= " AND A.`id_pemohon`=".tosql($_SESSION['SESS_UID']);  
$sqlJ .= " ORDER BY A.`tkh_espp` DESC";
$rsJawatan1 = $conn->query($sqlJ); $bil=0;

$bl=0; $J1=''; $J2=''; $J3=''; 
if(!$rsJawatan1->EOF){
	
	if(!empty($rsJawatan1->fields['jawatan1'])){  $J1 = dlookup("$schema1.`ref_skim`","DISKRIPSI","`KOD`='".$rsJawatan1->fields['jawatan1']."'"); }
	if(!empty($rsJawatan1->fields['jawatan2'])){  $J2 = dlookup("$schema1.`ref_skim`","DISKRIPSI","`KOD`='".$rsJawatan1->fields['jawatan2']."'"); }
	if(!empty($rsJawatan1->fields['jawatan3'])){  $J3 = dlookup("$schema1.`ref_skim`","DISKRIPSI","`KOD`='".$rsJawatan1->fields['jawatan3']."'"); }
}
// $data = file_get_contents('../images/Logo_Simpeni.png');
$data = file_get_contents('../images/top_jata_negara.png');
$base64 = 'data:image/png;base64,' . base64_encode($data);

// $dataB = file_get_contents('../images/blur_jakim_logo.png');
$dataB = file_get_contents('../images/blur_jata_negara.png');
$base64B = 'data:image/png;base64,' . base64_encode($dataB);

$html ='
<style>
table, tr, td, p, div{
    font-family: Arial, Helvetica, sans-serif;
    font-size: 12px;
}
.footer {
   position: fixed;
   left: 0;
   bottom: 0;
   width: 100%;
   color: #000;
   text-align: center;
}
</style>
<body style="background-image: url('.$base64B.'); background-position: center; background-repeat: no-repeat;
  background-attachment: fixed;  
  background-size: 48%;">
  <br><br><br>
<table width="90%" cellpadding="5" cellspacing="0" border="1" align="center" style="border-style: solid;">
		<tr>
        	<td width="100%" valign="top" align="center" style="padding-left:30px; padding-right:30px; padding-top:20px;">
                <table width="100%" cellpadding="3" cellspacing="0" border="0" align="center">
                    <tr>
                        <td width="25%">&nbsp;</td>
                        <td align="center" width="50%"><br>
                            <img src="'.$base64.'" style="width:100px;"  alt="base" />
                        </td>
                        <td width="25%" valign="top">
                            
                        </td>
                    </tr>                    
                    <tr>
                        <td align="center" colspan="3" width="100%">
                            <font style="font-size:14px"><b>
                            SURUHANJAYA PERKHIDMATAN PENDIDIKAN<br>
                            SLIP AKUAN PENDAFTARAN PERMOHONAN JAWATAN SPP</b><br><br>
                            </font>
                            </td>
                    </tr>
                </table>
				<br />
                <div align="left">
                Terima kasih.<br>
                Borang permohonan telah diterima. Ringkasan permohonan anda adalah seperti
                </div>
                <br><br>
                <table width="100%" cellpadding="2" cellspacing="0" border="0" style="font-size:12px">
                    <tr>
                        <td valign="top">No. KP Baru</td>
                        <td valign="top">:</td>
                        <td valign="top">'.strtoupper($rs->fields['ICNo']).'&nbsp;</td>
                    </tr>
                    <tr>
                        <td valign="top">Nama Penuh</td>
                        <td valign="top">:</td>
                        <td valign="top">'.strtoupper($rs->fields['nama_penuh']).'&nbsp;</td>
                    </tr>
                    <tr>
                        <td valign="top">Alamat Surat Menyurat</td>
                        <td valign="top">:</td>
                        <td valign="top">'.strtoupper($rs->fields['addr1']).'<br>'.strtoupper($rs->fields['addr2']).'<br>'.strtoupper($rs->fields['addr3']).'</td>
                    </tr>
                    <tr>
                        <td width="25%" valign="top">Poskod</td>
                        <td width="1%" valign="top">:</td>
                        <td width="74%" valign="top">'.$rs->fields['poskod'].'&nbsp;</td>
                    </tr>
                    <tr>
                        <td width="25%" valign="top">Bandar</td>
                        <td width="1%" valign="top">:</td>
                        <td width="74%" valign="top">'.$rs->fields['bandar'].'&nbsp;</td>
                    </tr>
                    <tr>
                        <td width="25%" valign="top">Negeri</td>
                        <td width="1%" valign="top">:</td>
                        <td width="74%" valign="top">'.$negeri.'&nbsp;</td>
                    </tr>
                    <tr>
                        <td width="25%" valign="top">Tarikh Perakuan & Hantar</td>
                        <td width="1%" valign="top">:</td>
                        <td width="74%" valign="top">'.DisplayDate($rs->fields['takuan']).' '.DisplayTime($rs->fields['takuan']).'&nbsp;</td>
                    </tr>
                </table>
                <br /><br />
        		<table width="92%" align="center" cellpadding="5" cellspacing="0" border="0" style="font-size:12px">
                	<tr>
                		<td width="100%" align="left" style="border-bottom:thin;border-bottom-style:solid;border-bottom-color:#000" colspan="3"><b>JAWATAN YANG DIMOHON</b></td>
                	</tr>
                    <tr>
                        <td align="left" width="25%"><b>Pilihan Pertama</b></td>
                        <td align="left" width="2%"><b>:</b></td>
                        <td align="left" width="73%">'.$J1.'</td>
                    </tr>
                    <tr>
                    	<td align="left"><b>Pilihan Kedua</b></td>
                    	<td align="left"><b>:</b></td>
                    	<td align="left">'.$J2.'</td>
                    </tr>
                    <tr>
                    	<td align="left"><b>Pilihan Ketiga</b></td>
                    	<td align="left"><b>:</b></td>
                    	<td align="left">'.$J3.'</td>
                    </tr>
                </table>

                <br /><br /><br />
                <div align="left" style="font-size:12px; border-style:solid;border: thin;padding:5px">
                    <font color="red"><b>PERHATIAN :</b></font> Pastikan semua maklumat adalah sama seperti maklumat yang didaftarkan.
                </div>

                <br /><br /><br />

				<div align="center" style="font-size:12px">
                    *SLIP INI ADALAH CETAKAN KOMPUTER.TIDAK MEMERLUKAN TANDATANGAN*
				</div>
                <br /><br /><br />
				<div align="center">
                    <font style="font-size:12px"><b>SURUHANJAYA PERKHIDMATAN PENDIDIKAN</b></font>
				</div>
                <br />
        	</td>
        </tr>
	</table>
    <div class="footer" align="right">
    <p>Tarikh Cetakan : '.date("d/m/Y H:i:s").'</p>
    </div>
    </body>';
	// $rs->movenext();
// }
// $html = '<table>Hello World</table>';

// print $html; exit;
// $rssekolah->close();
$rs->close();
$conn->close();


$dompdf = new Dompdf(); 
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'potrait');
$dompdf->render();
$dompdf->stream("keputusan_".$ic.".pdf",array("Attachment" => false));
exit(0);
?>
