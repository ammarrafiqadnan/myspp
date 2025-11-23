<style type="text/css">
FONT{FONT-SIZE: 13px;FONT-FAMILY: Arial;COLOR: #000000}
TABLE{FONT-SIZE: 13px;FONT-FAMILY: Arial;COLOR: #000000}
TH{FONT-SIZE: 13px;FONT-FAMILY: Arial;COLOR: #000000}
TD{FONT-SIZE: 13px;FONT-FAMILY: Arial;COLOR: #000000}
BODY{FONT-SIZE: 13px;FONT-FAMILY: Arial;COLOR: #000000}
P{FONT-SIZE: 13px;FONT-FAMILY: Arial;COLOR: #000000}
DIV{FONT-SIZE: 13px;FONT-FAMILY: Arial;COLOR: #000000}
</style><?php
$tkh=date("Y-m-d");
$upd_btn='';
//$conn->debug=true;
$carian=strtoupper(isset($_REQUEST["carian"])?$_REQUEST["carian"]:"");
$T=isset($_REQUEST["T"])?$_REQUEST["T"]:"";
$topik_list=isset($_REQUEST["topik_list"])?$_REQUEST["topik_list"]:"";
$minggu_list=isset($_REQUEST["minggu_list"])?$_REQUEST["minggu_list"]:"";
$tahun_list=isset($_REQUEST["tahun_list"])?$_REQUEST["tahun_list"]:"";

// $conn->debug=true;
$sql = "SELECT A.*, B.`topik_nama`, C.`subtopik_nama` FROM `tbl_isuakidah` A, `_ref_topik` B, `_ref_topik_sub` C 
	WHERE A.`topik_id`=B.`topik_id` AND A.`subtopik_id`=C.`subtopik_id` AND A.`is_deleted`=0";
if(!empty($tahun_list) && $tahun_list!='-'){ $sql .= " AND year(A.`tarikh`)='{$tahun_list}'"; }
if(!empty($minggu_list) && $minggu_list!='-'){ $sql .= " AND A.`minggu`='{$minggu_list}'"; }
if(!empty($topik_list) && $topik_list!='-'){ $sql .= " AND A.`topik_id`='{$topik_list}'"; }
if(!empty($carian)){ $sql .= " AND (B.`topik_nama` LIKE '%$carian%' OR `carian_sumber` LIKE '%$carian%' OR `kenyataan` LIKE '%$carian%') "; }

// $sql .= " GROUP BY A.`topik_id`, A.`subtopik_id`";
$sql .= " ORDER BY A.`topik_id`, A.`subtopik_id`";

$rs = $conn->query($sql);
$conn->debug=false;

if($minggu_list!='-'){ $tit = " MINGGU KE ".$minggu_list." TAHUN ".$tahun_list; }
else if($minggu_list=='-' && !empty($tahun_list)){ $tit = " TAHUN ".$tahun_list; }

?>    

	<div align="center">
		<b>LAPORAN MINGGUAN PEMERHATIAN ISU-ISU AKIDAH DI MEDIA BAHARU <br>  <?=$tit;?></b>
	</div>
      	<table cellpadding="5" cellspacing="0" style="width:100%" border="1">
	        <thead style="background-color: #ccc;">
	        	<tr>
	        		<th colspan="4" width="30%">Kategori</th>
	        		<th rowspan="2" width="10%">Sumber Carian</th>
	        		<th colspan="2" width="60%">Maklumat Carian</th>
	        	</tr>
	        	<tr>
		          <th width="20%" colspan="2">Topik</th>
		          <th width="10%">Sub Topik</th>
		          <th width="10%">Carian Oleh</th>
		          <th width="40%">Kenyataan / Aktiviti / Perancangan</th>
		          <th width="20%">Ulasan</th>
		      	</tr>
	        </thead>
	        <tbody>
	        <?php
			if(!$rs->EOF) {
			$bil = 0; 
			while(!$rs->EOF){ 
				$bil++; $kbil++;
				$topik_nama=$rs->fields['topik_nama'];
				$subtopik_nama=$rs->fields['subtopik_nama'];
				if($topik_nama!=$topik_disp){ $topik_papar=$topik_nama; } else { $topik_papar=''; }
				if($subtopik_nama!=$subtopik_disp){ $subtopik_papar=$subtopik_nama; } else { $subtopik_papar=''; }
				
			?>
			<tr>
				<td align="left"><?php print $topik_papar;?></td>
				<td align="left"><?php print $subtopik_papar;?></td>
				<td align="left"><?php print $rs->fields['sub_topik'];?></td>
				<td align="left"><?php print $rs->fields['carian_oleh'];?></td>
				<td align="left"><?php print $rs->fields['carian_sumber'];?></td>
				<td align="left"><?php print $rs->fields['kenyataan'];?></td>
				<td align="left"><?php print $rs->fields['ulasan'];?></td>
			  </td>
			</tr>
			<?php 	
					$topik_disp=$topik_nama;
					$subtopik_disp=$subtopik_nama;
					$rs->movenext(); 
				} 
			}
			?>
			</tbody>
    	</table>
