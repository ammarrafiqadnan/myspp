<style type="text/css">
FONT{FONT-SIZE: 13px;FONT-FAMILY: Arial;COLOR: #000000}
TABLE{FONT-SIZE: 13px;FONT-FAMILY: Arial;COLOR: #000000}
TH{FONT-SIZE: 13px;FONT-FAMILY: Arial;COLOR: #000000}
TD{FONT-SIZE: 13px;FONT-FAMILY: Arial;COLOR: #000000}
BODY{FONT-SIZE: 13px;FONT-FAMILY: Arial;COLOR: #000000}
P{FONT-SIZE: 13px;FONT-FAMILY: Arial;COLOR: #000000}
DIV{FONT-SIZE: 13px;FONT-FAMILY: Arial;COLOR: #000000}
</style>
<?php
$JFORM='LIST';
$tkh=date("Y-m-d");
$upd_btn='';
//$conn->debug=true;

$url = "index.php?data=".base64_encode('maklumat/isu_mediamassa_list;DATA_MEDIA;Pemerhatian Isu Agama Di Media Massa;;;;'); 
$carian=strtoupper(isset($_REQUEST["carian"])?$_REQUEST["carian"]:"");
$T=isset($_REQUEST["T"])?$_REQUEST["T"]:"";
$topik_list=isset($_REQUEST["topik_list"])?$_REQUEST["topik_list"]:"";
$minggu_list=isset($_REQUEST["minggu_list"])?$_REQUEST["minggu_list"]:"";
$tahun_list=isset($_REQUEST["tahun_list"])?$_REQUEST["tahun_list"]:"";

if($T=='N'){ $_SESSION['SESS_carian']=''; }

if(!empty($tahun_list) || !empty($tahun_list)){
	$_SESSION['SESS_tahun']=$tahun_list;
} else {
	$tahun_list=$_SESSION['SESS_tahun'];
}
if(!empty($minggu_list) || !empty($minggu_list)){
	$_SESSION['SESS_minggu']=$minggu_list;
} else {
	$minggu_list=$_SESSION['SESS_minggu'];
}
if(!empty($topik_list) || !empty($topik_list)){
	$_SESSION['SESS_topik']=$topik_list;
} else {
	$topik_list=$_SESSION['SESS_topik'];
}
if(!empty($carian) || !empty($carian)){
	$_SESSION['SESS_carian']=$carian;
} else {
	$carian=$_SESSION['SESS_carian'];
}


if($minggu_list!='-'){ $tit = " MINGGU KE ".$minggu_list." TAHUN ".$tahun_list; }
else if($minggu_list=='-' && !empty($tahun_list)){ $tit = " TAHUN ".$tahun_list; }

?>

<input type="hidden" id="vals" name="vals" value=""  />
<div class="box" style="background-color:#F2F2F2">

       
	<div align="center">
		<b>LAPORAN ISU PENGHINAAN AGAMA DI MEDIA MASSA <br>  <?=$tit;?></b>
	</div>
    
	<?php 
	// $conn->debug=true;
    $sql = "SELECT A.*, B.`kluster_nama` FROM `tbl_hinaagama` A, `_ref_kluster` B 
    	WHERE A.`kluster_id`=B.`kluster_id` AND A.`is_deleted`=0";
    if(!empty($tahun_list) && $tahun_list!='-'){ $sql .= " AND year(A.`tarikh`)='{$tahun_list}'"; }
    if(!empty($minggu_list) && $minggu_list!='-'){ $sql .= " AND A.`minggu`='{$minggu_list}'"; }
    if(!empty($topik_list) && $topik_list!='-'){ $sql .= " AND A.`kluster_id`='{$topik_list}'"; }
    if(!empty($carian)){ $sql .= " AND A.`isu` LIKE '%$carian%'"; }
    $sql .= " ORDER BY `tarikh` DESC";
	// $rs = $conn->query($sql);
	$rs = $conn->query($sql);
    ?>    
    <div class="box-body" style="background-color:#F2F2F2">
      	<table cellpadding="5" cellspacing="0" style="width:100%" border="1">
	        <thead  style="background-color:rgb(38, 167, 228)">
	        <tr>
	          <th width="5%"><font color="#000000"><div align="center">Bil</div></font></th>
	          <th width="10%"><font color="#000000"><div align="center">Tarikh</div></font></th>
	          <th width="5%"><font color="#000000"><div align="center">Minggu</div></font></th>
	          <th width="10%"><font color="#000000"><div align="center">Kluster/Bidang</div></font></th>
	          <th width="15%"><font color="#000000"><div align="center">Isu</div></font></th>
	          <th width="45%"><font color="#000000"><div align="center">Paparan Media</div></font></th>
	        </tr>
	        </thead>
	        <tbody>
	        <?php
			if(!$rs->EOF) {
			//$cnt = 1;
			// $conn->debug=true;
			$bil = 0; 
			$rsMedia = $conn->query("SELECT * FROM `_ref_medium_media` WHERE `is_deleted`=0 AND `medium_status`=0");
			while(!$rs->EOF){ 
				$bil++; $kbil++;
				//$bil = $cnt + ($PageNo-1)*$PageSize;
				$id=$rs->fields['id'];
				$tarikh = DisplayDate($rs->fields['tarikh']);
				if(empty($tarikh)){ $tarikh = DisplayDate($rs->fields['tarikh']); }
				$hari = 'Ahad';
		?>
			<tr>
				<td align="center"><?=$bil;?></td>
				<td align="center"><?php print $tarikh;?></td>
				<td align="center"><?php print $rs->fields['minggu'];?></td>
				<td align="left"><?php print $rs->fields['kluster_nama'];?></td>
				<td align="center"><?php print nl2br($rs->fields['isu']);?></td>
				<td align="center">
					<table width="100%" cellpadding="5" cellspacing="0" border="1" class="table">
						<tr>
							<td width="20%"><b>MEDIUM</b></td>
							<td width="70%"><b>NAMA LINK (jika berkaitan)</b></td>
							<td width="10%"><b>KEKERAPAN</b></td>
						</tr>
						<?php
						$rsMedia->movefirst();
						while(!$rsMedia->EOF){ 
							$med_id = $rsMedia->fields['medium_id'];
							$rsDM = $conn->query("SELECT * FROM `tbl_hinaagama_media` WHERE `id_hinaagama`='{$id}' AND `id_media`='{$med_id}'");
							$links = $rsDM->fields['links'];
							$kekerapan = $rsDM->fields['kekerapan'];
							if(!empty($links) || !empty($kekerapan)){ 
						?>
						<tr>
							<td><?php print $rsMedia->fields['medium_name'];?></td>
							<td><?=$links;?></td>
							<td align="center"><?=$kekerapan;?></td>
						</tr>
						<?php } 
						$rsMedia->movenext(); } ?>
					</table>
				</td>
			</tr>
			<?php 
					$cnt = $cnt + 1;
					// $bil = $bil + 1;
					$rs->movenext(); 
				} 
			}
			?>
			</tbody>
    	</table>
	</div>
</div>
<!-- DataTables -->
          