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

$carian=strtoupper(isset($_REQUEST["carian"])?$_REQUEST["carian"]:"");
$T=isset($_REQUEST["T"])?$_REQUEST["T"]:"";
$akhbar=isset($_REQUEST["akhbar"])?$_REQUEST["akhbar"]:"";
$kategori=isset($_REQUEST["kategori"])?$_REQUEST["kategori"]:"";
$bulan_list=isset($_REQUEST["bulan_list"])?$_REQUEST["bulan_list"]:"";
$tahun_list=isset($_REQUEST["tahun_list"])?$_REQUEST["tahun_list"]:"";


// $conn->debug=true;
$sql = "SELECT A.*, B.`isuagama_nama`, C.`akhbar_nama` FROM `tbl_isu_agama` A, `_ref_isuagama` B, `_ref_akhbar` C 
	WHERE A.`kategori_id`=B.`isuagama_id` AND A.`akhbar_id`=C.`akhbar_id` AND A.`is_deleted`=0";
if(!empty($tahun_list) && $tahun_list!='-'){ $sql .= " AND year(A.`tarikh`)='{$tahun_list}'"; }
if(!empty($bulan_list) && $bulan_list!='-'){ $sql .= " AND month(A.`tarikh`)='{$bulan_list}'"; }
if(!empty($akhbar) && $akhbar!='-'){ $sql .= " AND A.`akhbar_id`='{$akhbar}'"; }
if(!empty($kategori) && $kategori!='-'){ $sql .= " AND A.`kategori_id`='{$kategori}'"; }
if(!empty($carian)){ $sql .= " AND A.`tajuk` LIKE '%$carian%'"; }
$sql .= " ORDER BY `tarikh` DESC";
$rs = $conn->query($sql);

if($bulan_list!='-'){ $tit = " BULAN ".$bulan_list." / ".$tahun_list; }
else if($bulan_list=='-' && !empty($tahun_list)){ $tit = " TAHUN ".$tahun_list; }

?>    
<div align="center">
<b>LAPORAN BULANAN ISU AGAMA DI AKHBAR<br>LAPORAN BAGI <?=$tit;?></b>
</div>
<div class="box-body" style="background-color:#F2F2F2">
  	<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
        <thead  style="background-color:rgb(38, 167, 228)">
        <tr>
          <th width="5%"><font color="#000000"><div align="center">BIL</div></font></th>
          <th width="10%"><font color="#000000"><div align="center">TARIKH</div></font></th>
          <th width="10%"><font color="#000000"><div align="center">HARI</div></font></th>
          <th width="35%"><font color="#000000"><div align="center">TAJUK</div></font></th>
          <th width="15%"><font color="#000000"><div align="center">AKHBAR</div></font></th>
          <th width="15%"><font color="#000000"><div align="center">KATEGORI</div></font></th>
        </tr>
        </thead>
        <tbody>
        <?php
		if(!$rs->EOF) {
		//$cnt = 1;
		// $conn->debug=true;
		$colors = array("","#ccf002","#fff002","#00ffcc","#2200ff");
		$bil = 0; 
		while(!$rs->EOF){ 
			$bil++; $kbil++;
			//$bil = $cnt + ($PageNo-1)*$PageSize;
			$id=$rs->fields['id'];
			$kategori_id=$rs->fields['kategori_id'];
			$tarikh = DisplayDate($rs->fields['tarikh']);
			if(empty($tarikh)){ $tarikh = DisplayDate($rs->fields['tarikh']); }
			$timestamp = strtotime($rs->fields['tarikh']);
			$hari = get_hari(date('D', $timestamp));

			if(!empty($rs->fields['alamat_url'])){
				$tajuk = '<a href="'.$rs->fields['alamat_url'].'" target="_blank">'.$rs->fields['tajuk'].'</a>';
			} else {
				$tajuk = $rs->fields['tajuk'];
			}

			$bg = dlookup("_ref_isuagama","isuagama_bg","isuagama_id=".tosql($kategori_id));

			$minggu = weekOfMonth($rs->fields['tarikh']);
			$bgminggu = $colors[$minggu];

	?>
		<tr>
			<td align="center"><?=$bil;?></td>
			<td align="center" bgcolor="<?=$bgminggu;?>"><?php print $tarikh;?></td>
			<td align="center" bgcolor="<?=$bgminggu;?>"><?php print $hari;?></td>
			<td align="left"><?php print nl2br($tajuk);?></td>
			<td align="center"><?php print $rs->fields['akhbar_nama'];?></td>
			<td align="center" bgcolor="<?=$bg;?>"><?php print $rs->fields['isuagama_nama'];?></td>
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
<!-- DataTables -->
      