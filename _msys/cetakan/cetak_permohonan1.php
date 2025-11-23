<?php
namespace Dompdf;
require_once '../dompdf/autoload.inc.php';
include_once '../../connection/common.php';
ob_clean();
//$conn->debug=true;
//$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
$pdro=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";
$pro=isset($_REQUEST["pro"])?$_REQUEST["pro"]:"";

//print "ID:".$id.":".$id2;


$sql = "SELECT * FROM $schema2.`calon` WHERE `id_pemohon`=".tosql($id);
$rs = $conn->query($sql);


//$sqlD = "SELECT * FROM $schema2.`senarai_panggilan_temuduga` WHERE `noKP`=".tosql($rs->fields['ICNo'])." AND is_deleted=0";
$sqlD = "SELECT * FROM $schema2.`senarai_panggilan_temuduga` WHERE `noKP`=".tosql($id2)." AND is_deleted=0";
$rsD = $conn->query($sqlD);

/*
//$conn->debug=true;
$sqlJ = "SELECT * FROM $schema2.`calon_jawatan_dipohon` A, $schema1.`ref_skim` B WHERE A.`kod_jawatan`=B.`KOD`";
$sqlJ .= " AND A.`id_pemohon`=".tosql($id);  
$sqlJ .= " ORDER BY A.`seq_no` ASC";
$rsJawatan1 = $conn->query($sqlJ); $bil=0;
//$conn->debug=false;

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
  <br>
<table width="90%" cellpadding="5" cellspacing="0" border="1" align="center" style="border-style: solid;">
		<tr>
        	<td width="100%" valign="top" align="center" style="padding-left:30px; padding-right:30px; padding-top:20px;">
                <table width="100%" cellpadding="3" cellspacing="0" border="0" align="center">
                    <!--<tr>
                        <td width="25%">&nbsp;</td>
                        <td align="center" width="50%"><br>
                            <img src="'.$base64.'" style="width:100px;"  alt="base" />
                        </td>
                        <td width="25%" valign="top">
                            
                        </td>
                    </tr>-->                    
                    <tr>
			<td width="20%">
				<img src="../assets/images/logoSPP.png" style="width:130px;" height="95px"  alt="base" />
			<td>
                        <td width="80%">
                            <font style="font-size:14px">
                            <b>SURUHANJAYA PERKHIDMATAN PENDIDIKAN MALAYSIA</b><br>
                            ARAS 1-4, BLOK F9, KOMPLEKS F, <br>
				LEBUH PERDANA TIMUR, PRESINT 1, <br>
				62000 PUTRAJAYA. <br>
				TALIAN MyGCC : +603 8000 600<br>
                            </font>
                            </td>
                    </tr>
                </table>
		<br>
		<table width="100%" cellpadding="3" cellspacing="0" border="0" align="center">
			<tr>
				<td width="100%" align="center" style="background-color: rgb(155, 184, 198)"><h3>SLIP PANGGILAN TEMU DUGA</h3></td>
			</tr>
		</table> 


				<br />
                <div align="left">
                Sukacita dimaklumkan bahawa tuan/puan telah layak untuk ditemu duga bagi jawatan.
                </div>
                <br><br>

		<table width="100%" cellpadding="3" cellspacing="0" border="0" align="center">
			<tr style="height: 10px;">
				<th width="100%" align="center" style="background-color: rgb(155, 184, 198)"><h3>MAKLUMAT CALON</h3></th>
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
                    
                </table>
                <br /><br />
		<table width="100%" cellpadding="3" cellspacing="0" border="0" align="center">
			<tr style="height: 10px;">
				<th width="100%" align="center" style="background-color: rgb(155, 184, 198)"><h3>MAKLUMAT TEMU DUGA</h3></th>
			</tr>
		</table>
		<br>
        	<table width="92%" align="center" cellpadding="5" cellspacing="0" border="0" style="font-size:12px">                     
		<tr>
                        <td align="left" width="100px"><b>JAWATAN</b></td>
                        <td align="left" width="5px"><b>:</b></td>
                        <td align="left" width="400px">'.$rsD->fields['skim_jawatan'].'&nbsp;</td>
                    </tr>
                    <tr>
                    	<td align="left"><b>TARIKH</b></td>
                    	<td align="left"><b>:</b></td>
                    	<td align="left">'.DisplayDate($rsD->fields['tarikh']).'&nbsp;</td>
                    </tr>
                    <tr>
                    	<td align="left"><b>MASA</b></td>
                    	<td align="left"><b>:</b></td>
                    	<td align="left">'.$rsD->fields['masa'].'&nbsp;</td>
                    </tr>
			<tr>
                    	<td align="left"><b>TEMPAT</b></td>
                    	<td align="left"><b>:</b></td>
                    	<td align="left">'.$rsD->fields['tempat'].'&nbsp;</td>
                    </tr>

                </table>


                <br /><br /><br />

				<div align="center" style="font-size:12px">
                    <b><i>(SLIP INI ADALAH CETAKAN KOMPUTER. TIADA TANDATANGAN DIPERLUKAN)</i></b>
				</div>
                <br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
        	</td>
        </tr>
	</table>
    <div class="footer" align="right">
    <p>Tarikh Cetakan : '.date("d/m/Y H:i:s").'</p>
    </div>
    </body>';
	// $rs->movenext();
//}

//$html = '<table>Hello World</table>';
$ic=$rsD->fields['noKP'];
//print $html;exit;
$rs->close();
$conn->close();


$dompdf = new Dompdf(); 
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'potrait');
$dompdf->render();
$dompdf->stream("panggilan_".$ic,array("Attachment" => false));
//exit(0);
?>
