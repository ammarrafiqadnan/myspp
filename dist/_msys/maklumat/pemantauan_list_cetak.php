<?php
$JFORM='LIST';
$tkh=date("Y-m-d");
$upd_btn='';
//$conn->debug=true;

$url = "index.php?data=".base64_encode('maklumat/pemantauan_list;DATA;Maklumat Pemantauan;;;;'); 
$carian=strtoupper(isset($_REQUEST["carian"])?$_REQUEST["carian"]:"");
$T=isset($_REQUEST["T"])?$_REQUEST["T"]:"";
$pemantauan_types=isset($_REQUEST["pemantauan_types"])?$_REQUEST["pemantauan_types"]:"";
$status=isset($_REQUEST["status"])?$_REQUEST["status"]:"";
$tahun=isset($_REQUEST["tahun"])?$_REQUEST["tahun"]:"";
if(!empty($pemantauan_types) || !empty($pemantauan_types)){
	$_SESSION['SESS_type']=$pemantauan_types;
} else {
	$pemantauan_types=$_SESSION['SESS_type'];
}
if(!empty($status) || !empty($status)){
	$_SESSION['SESS_status']=$status;
} else {
	$status=$_SESSION['SESS_status'];
}

?>

<input type="hidden" id="vals" name="vals" value=""  />
<div class="box" style="background-color:#F2F2F2">

	<div align="center">
		<b>LAPORAN ISU PENGHINAAN AGAMA DI MEDIA MASSA <br>  <?=$tit;?></b>
	</div>
       
	<?php 
	// $conn->debug=true;
    $sql = "SELECT * FROM `tbl_pemantauan` A, `_ref_kategori_sub` B WHERE A.`pemantauan_type`=B.`subkat_id` AND A.`is_deleted`=0";
    if(!empty($pemantauan_types) && $pemantauan_types!='-'){ $sql .= " AND A.pemantauan_type='{$pemantauan_types}'"; }
	if($status==1){ $sql .= " AND A.status_proses IN(0)"; }
	else if($status==2){ $sql .= " AND A.status_proses IN (3,4,5)"; }
	else if($status==3){ $sql .= " AND A.status_proses IN (9)"; }
	$rs = $conn->query($sql);
    ?>    
	<?php //include_once 'include/list_head.php'; ?>
    <?php //include_once 'include/page_list.php'; ?>
    <div class="box-body" style="background-color:#F2F2F2">
      	<table cellpadding="5" cellspacing="0" style="width:100%" border="1">
	        <thead  style="background-color:rgb(38, 167, 228)">
	        <tr>
	          <th width="5%"><font color="#000000"><div align="center">Bil</div></font></th>
	          <th width="15%"><font color="#000000"><div align="center">Kategori</div></font></th>
	          <th width="20%"><font color="#000000"><div align="center">Tajuk</div></font></th>
	          <th width="25%"><font color="#000000"><div align="center">Lokasi</div></font></th>
	          <th width="10%"><font color="#000000"><div align="center">Tarikh</div></font></th>
	          <th width="15%"><font color="#000000"><div align="center">Status</div></font></th>
	        </tr>
	        </thead>
	        <tbody>
	        <?php
			if(!$rs->EOF) {
			//$cnt = 1;
			// $conn->debug=true;
			$bil = 0; 
			while(!$rs->EOF){ 
				$bil++; $kbil++;
				//$bil = $cnt + ($PageNo-1)*$PageSize;
				$pemantauan_id=$rs->fields['pemantauan_id'];
				// $Nama = str_replace(strtoupper($carian),'<font color="#FF0000">'.strtoupper($carian).'</font>',strtoupper($rs->fields['nama']));
				$tarikh = DisplayDate($rs->fields['tarikh']);
				if(empty($tarikh)){ $tarikh = DisplayDate($rs->fields['create_dt']); }
				$status_proses = $rs->fields['status_proses'];
				$status = dlookup("_ref_status","status_nama","status_id=".tosql($status_proses));
				if(empty($status)){ $status='Draf'; }
				$hrefs = "index.php?data=". base64_encode('maklumat/pemantauan_form;DATA;Maklumat Pemantauan;;;'.$pemantauan_id);
				if($rs->fields['pemantauan_jenis']=='A'){ $bg='#a2cae8'; } else { $bg='#14ada6'; }
			?>
			<tr>
				<td align="center"><?=$bil;?></td>
				<td align="left"><?php print nl2br($rs->fields['subkat_nama']);?></td>
				<td align="left"><?php print nl2br($rs->fields['tajuk']);?></td>
				<td align="left"><?php print nl2br($rs->fields['tempat']);?></td>
				<td align="center"><?php print $tarikh;?></td>
				<td align="center"><?php print $status;?><br><?//=$status_proses;?></td>
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
          