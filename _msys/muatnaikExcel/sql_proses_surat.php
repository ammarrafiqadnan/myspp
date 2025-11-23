<?php
include_once '../../connection/common.php';

$frm=isset($_GET["frm"])?$_GET["frm"]:"";
$pro=isset($_GET["pro"])?$_GET["pro"]:"";
$jenis=isset($_GET["jenis"])?$_GET["jenis"]:"";
$date=date("Y-m-d H:i:s");
$oleh=$_SESSION['SESSADM_UID'];
$kod=isset($_REQUEST["kod"])?$_REQUEST["kod"]:"";


//$conn->debug=true;
$err='ERR';

// print "PRO: ".$frm.":".$jenis.":".$pro;
$bil=0;

if($frm=='SURAT'){
	//$conn->debug=true;
	if($pro == 'PROSES'){
$kod_surat=isset($_REQUEST["kod_surat"])?$_REQUEST["kod_surat"]:"";
		$sqls = "SELECT * FROM $schema2.`kandungan_surat` WHERE `kod`='{$kod_surat}'"; 
		$rsSurat = $conn->query($sqls);

		$kandungan = $rsSurat->fields['keterangan'];


		$sql = "SELECT * FROM $schema2.`senarai_keputusan_temuduga` WHERE is_deleted=0 AND `kod_keputusan_temuduga`='{$kod}'"; 
		$rss = $conn->query($sql);
		
		while(!$rss->EOF){
			$bil++;
			//print $bil;
			$kod = $rss->fields['kod'];
			$noKP = $rss->fields['noKP'];
			$no_pemerolehan = $rss->fields['no_pemerolehan'];
			$surat = $kandungan;

//getdata from eSPP
//$conn_ora->debug=true;

$tarikh_lantik = "TARIKH MELAPORKAN DIRI BERTUGAS SEPERTI MANA YANG DITETAPKAN OLEH KEMENTERIAN PENDIDIKAN MALAYSIA (KPM)";

$alamat=$alamat1;
if(!empty($alamat2)){ $alamat.="<br>".$alamat2; }
if(!empty($alamat3)){ $alamat.="<br>".$alamat3; }
if(!empty($poskod)){ $alamat.="<br>".$poskod; }
if(!empty($bandar)){ $alamat.=" ".$bandar; }
if(!empty($negeri)){ $alamat.="<br>".$negeri; }

$surat =  str_replace("<strong>NO_RUJUKAN</strong>", "<strong>AKP".$noKp."</strong>", $surat);
/*$surat =  str_replace("<strong>TARIKH</strong>", "<strong>".DisplayDateF($tkhSurat)."</strong>", $surat);
$surat =  str_replace("<strong>NAMA</strong>", "<strong>".$nama."</strong>", $surat);
$surat =  str_replace("<strong>NO_KP</strong>", "<strong>".$noKp."</strong>", $surat);
$surat =  str_replace("<strong>ALAMAT</strong>", "<strong>".$alamat."</strong>", $surat);
$surat =  str_replace("<strong>GAJI</strong>", "<strong>".$amaun3."</strong>", $surat);
$surat =  str_replace("<strong>NAMA_PEGAWAI</strong>", "<strong>".$nama_pegawai."</strong>", $surat);
$surat =  str_replace("<strong>TARIKH_LANTIK</strong>", "<strong>".$tarikh_lantik."</strong>", $surat);

//&lt;NAME_CALON&gt;

$surat =  str_replace("&lt;Ref_No&gt;", "AKP".$noKp, $surat);
$surat =  str_replace("&lt;Date&gt;", DisplayDateF($tkhSurat), $surat);
$surat =  str_replace("&lt;Name_Calon&gt;", $nama, $surat);
$surat =  str_replace("&lt;Id_No&gt;", $noKp, $surat);
$surat =  str_replace("&lt;Address&gt;", $alamat, $surat);
$surat =  str_replace("&lt;gaji&gt;", $amaun3, $surat);
$surat =  str_replace("&LT;Nama_Pegawai&GT;", $nama_pegawai, $surat);
//$surat =  str_replace("&lt;JADUAL&gt;", $amaun, $surat);
*/

/*	$head_surat = '<table width="100%" cellpading="5" cellspacing="0" border="0" style="font-size: 14px;">
	<tr>
		<td width="60%" align="right" style="font-size: 14px;">Ruj. Kami</td>
		<td width="1%" style="font-size: 14px;">:</td>
		<td width="29%" style="font-size: 14px;"> <b>AKP'.$noKp.'</b></td>
	</tr>
	<tr>
		<td width="60%" align="right" style="font-size: 14px;">Tarikh</td>
		<td width="1%" style="font-size: 14px;">:</td>
		<td width="29%" style="font-size: 14px;"><b>'.DisplayDateF($tkhSurat).'</b></td>
	</tr>
</table>

<table width="100%" cellpading="5" cellspacing="0" border="0" style="font-size: 14px;">
	<tr>
		<td width="20%" style="font-size: 14px;">Nama</td>
		<td width="1%" style="font-size: 14px;">:</td>
		<td width="79%" style="font-size: 14px;"><b>'.$nama.'</b></td>
	</tr>
	<tr>
		<td width="20%" style="font-size: 14px;">No. Kad Pengnalan</td>
		<td width="1%" style="font-size: 14px;">:</td>
		<td width="79%" style="font-size: 14px;"><b>'.$noKp.'</b></td>
	</tr>
	<tr>
		<td width="20%" valign="top" style="font-size: 14px;">Alamat</td>
		<td width="1%" valign="top" style="font-size: 14px;">:</td>
		<td width="79%" style="font-size: 14px;"><b>'.$alamat.'</b></td>
	</tr>
</tr>
</table><br><br>';
		
		$surat = $head_surat.$surat;
*/
$surat =  str_replace('border="1"', 'boeder="0"', $surat);

			$sqli = "UPDATE $schema2.`senarai_keputusan_temuduga` SET keputusan_surat=".tosqln($surat).", surat_jana_dt=".tosql(date("Y-m-d H:i:s")).", 
				surat_jana_by=".tosql($oleh)." WHERE kod=".tosql($kod). " AND `noKP`=".tosql($noKP);
			//print "<br>".$sqli;
			$conn->execute($sqli);
			$rss->movenext();
		}
		
	} 
}
$err='OK';
header("Content-Type: text/json");
print json_encode($err); 
//print "OK"; //$err;
?>

