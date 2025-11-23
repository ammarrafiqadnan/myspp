<?php
namespace Dompdf;
require_once '../dompdf/autoload.inc.php';
include_once '../../connection/common.php';

ob_clean();
//$connOra = odbc_connect('oracle_dsn', 'esmsm_data', 'abc123');
//include '../../connection/common_oracle.php';

/*$connOra = odbc_connect('oracle_dsn', 'esmsm_data', 'abc123');
if ($connOra) {
    //echo "Oracle ODBC connection successful!";
    //odbc_close($connOra);
} else {
	//echo "Oracle ODBC connection failed!";
	print "Oracle ODBC connection failed!";
}
*/
//$conn->debug=true;
$pdro=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";
$pro=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";

//print "ID:".$id.":".$id2;

$sql = "SELECT * FROM $schema2.`calon` WHERE `id_pemohon`=".tosql($id);
//$rs = $conn->query($sql);


//$sqlD = "SELECT * FROM $schema2.`senarai_panggilan_temuduga` WHERE `noKP`=".tosql($rs->fields['ICNo'])." AND is_deleted=0";
$sqlD = "SELECT A.*, B.`file_lampiran` FROM $schema2.`senarai_keputusan_temuduga` A, $schema2.`keputusan_temuduga` B WHERE A.`kod_keputusan_temuduga`=B.`kod` AND A.`noKP`=".tosql($id)." AND A.is_deleted=0";
$rsD = $conn->query($sqlD);

$noKP = $rsD->fields['noKP'];

$no_pemerolehan = $rsD->fields['no_pemerolehan'];

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
            <hr>';

$html .= $rsD->fields['keputusan_surat'];
$lampiran = $rsD->fields['file_lampiran'];

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
//$existingPdfPath = '../upload_doc/berjaya-akp19.pdf';
$existingPdfPath = '../upload_doc/'.$lampiran;
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

