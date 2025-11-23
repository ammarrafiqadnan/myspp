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
//$conn->debug=true;
$tahun_list=isset($_REQUEST["tahun_list"])?$_REQUEST["tahun_list"]:"";
if(empty($tahun_list)){ $tahun_list=date("Y"); }


$sql = "SELECT * FROM `_ref_topik` WHERE `is_deleted`=0 AND `topik_status`=0 ORDER BY `topik_nama`";
$rs = $conn->query($sql);
$cols = $rs->recordcount();
$jcols=$cols+2;


function get_data($tahun,$bulan,$kategori){
	global $conn;
	$sqls = "SELECT count(*) AS jum FROM `tbl_isuakidah` WHERE is_deleted=0 AND `topik_id`='{$kategori}' AND year(tarikh)='{$tahun}'";
	if(!empty($bulan)){ $sqls .= " AND month(tarikh)='{$bulan}'"; }
	$rsData = $conn->query($sqls);
	$jumlah = $rsData->fields['jum'];

	return $jumlah;
}

?>    
<div align="center">
STATISTIK PEMANTAUAN ISU-ISU AKIDAH DI MEDIA BARU BAGI TAHUN <?=$tahun_list;?>
</div>
<div class="box-body" style="background-color:#F2F2F2">
  	<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
        <thead  style="background-color:rgb(38, 167, 228)">
        <tr>
          <th width="8%"><font color="#000000"><div align="center">BULAN/KATEGORI</div></font></th>
          <?php while(!$rs->EOF){ ?>
          <th width="8%"><font color="#000000"><div align="center"><?=$rs->fields['topik_nama'];?></div></font></th>
          <?php $rs->movenext(); } ?>
          <th width="8%"><font color="#000000"><div align="center">JUMLAH</div></font></th>
        </tr>
        </thead>
        <tbody>
        <?php for($m=1;$m<=12;$m++){ ?>
        <tr>
        	<td><?php print month($m);?></td>
        	<?php $jumlah=0;
        	$rs->movefirst();
        	while(!$rs->EOF){ 
        		$kat = $rs->fields['topik_id'];
        		$jumlah += $data = get_data($tahun_list, $m, $kat);
        		// $jumlah += $data;
        		if(!empty($data)){ print '<td align="center">'.$data.'</td>'; }
        		else { print '<td align="center">-</td>'; }
        		$rs->movenext(); 
        	}
        	?>
        	<td align="center">
        		<?php if(!empty($jumlah)){ print $jumlah; } else { print '-'; }?>		
        	</td>
        </tr>
        <?php } ?>	

        <tr>
        	<td align="center"><b>JUMLAH</b></td>
        	<?php $jumlah=0;
        	$rs->movefirst();
        	while(!$rs->EOF){ 
        		$kat = $rs->fields['topik_id'];
        		$jumlah += $data = get_data($tahun_list, 0, $kat);
        		// $jumlah += $data;
        		if(!empty($data)){ print '<td align="center">'.$data.'</td>'; }
        		else { print '<td align="center">-</td>'; }
        		$rs->movenext(); 
        	}
        	?>
        	<td align="center">
        		<?php if(!empty($jumlah)){ print $jumlah; } else { print '-'; }?>		
        	</td>
        </tr>

		</tbody>
	</table>
</div>
<!-- DataTables -->
      