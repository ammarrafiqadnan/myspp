<link href="vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
<script language="javascript">
function do_click_btn(vals){
	//alert("hai");
	//var vals = document.jawi.vals.valus;
	var href='index.php?data=bWFrbHVtYXQvdGluZGFrYW5fbGlzdDtEQVRBO01ha2x1bWF0IFRpbmRha2FuOzs7Ow==&#'+vals;
	document.jawi.action=href;
	document.jawi.target='_self';
	document.jawi.submit();
}
function do_print(val){
   	do_cetak(val);
}
</script>
<?php
$_SESSION['SESS_data']=$data;
$JFORM='LIST';
$tkh=date("Y-m-d");
$upd_btn='';
//$conn->debug=true;

$url = "index.php?data=".base64_encode('maklumat/barang_gunaan_list;DATA;Laporan Kajian Bahan Gunaan;;;;'); 
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

$pemantauan_types='12';
$href = "index.php?data=". base64_encode('maklumat/barang_gunaan_form;DATA;'.$menu.';;;');
?>

<input type="hidden" id="vals" name="vals" value=""  />
<div class="box" style="background-color:#F2F2F2">

    <div class="box-body">
    <div class="x_panel" style="background-color:#F2F2F2">
	<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
        <div class="panel-actions">
        <!--<a href="#" class="fa fa-caret-down"></a>
        <a href="#" class="fa fa-times"></a>-->
        </div>
        <h6 class="panel-title"><font color="#000000"><b>Maklumat Laporan Kajian Barang Gunaan Islam Meragukan</b></font></h6> 
    </header>
	</div>
    </div>            
    <br />
    <div class="box-body" style="background-color:#F2F2F2">
        <div class="col-md-3" style="background-color:#F2F2F2">
            <select name="status" id="status"  class="form-control" onchange="do_page('<?=$url;?>&T=N')">
                <option value="-">-- Semua status --</option>
                <option value="1" <?php if($status==1){ print 'selected'; }?>>DRAF</option>
                <option value="2" <?php if($status==2){ print 'selected'; }?>>DALAM PROSES</option>
                <option value="3" <?php if($status==3){ print 'selected'; }?>>SELESAI</option>
            </select><br>
        </div>
        <?php if($_SESSION['SESS_ULEVEL']==2 || $_SESSION['SESS_ULEVEL']==3){ ?>
        <div class="col-md-2" style="background-color:#F2F2F2">
            <a href="<?=$href;?>"title="Kemaskini Maklumat Laporan Kajian"><button type="button" class="btn btn-primary">
                <i class=" fa fa-plus-square"></i> <font style="font-family:Verdana, Geneva, sans-serif"> Tambah Maklumat</font></button>
			</a>
        </div>
    <?php } ?>
        <div class="col-md-2" style="background-color:#F2F2F2">
            <img src="images/printButton.png" title="Cetak" style="cursor:pointer" width="25" height="25" onclick="do_print('cetak.php?pages=maklumat/barang_gunaan_cetak&prn=')" />&nbsp;
            <img src="images/icon_office_excel.gif" title="Salin ke EXCEL" style="cursor:pointer" width="25" height="25" onclick="do_print('cetak.php?pages=maklumat/barang_gunaan_cetak&prn=EXCEL')" />&nbsp;
            <img src="images/icon_office_word.gif" title="Salin ke MS Word" style="cursor:pointer" width="25" height="25" onclick="do_print('cetak.php?pages=maklumat/barang_gunaan_cetak&prn=WORD')" />&nbsp;
        </div>
    </div> 
    
	<?php 
	// $conn->debug=true;
    $sql = "SELECT * FROM `tbl_pemantauan` A, `_ref_kategori_sub` B WHERE A.`pemantauan_type`=B.`subkat_id` AND A.`is_deleted`=0";
    if(!empty($pemantauan_types) && $pemantauan_types!='-'){ $sql .= " AND A.pemantauan_type='{$pemantauan_types}'"; }
	if($status==1){ $sql .= " AND A.status_proses IN(0)"; }
	else if($status==2){ $sql .= " AND A.status_proses IN (3,4,5)"; }
	else if($status==3){ $sql .= " AND A.status_proses IN (9)"; }
	// $rs = $conn->query($sql);
    ?>    
	<?php include_once 'include/list_head.php'; ?>
    <?php include_once 'include/page_list.php'; ?>
    <div class="box-body" style="background-color:#F2F2F2">
      	<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
	        <thead  style="background-color:rgb(38, 167, 228)">
	        <tr>
	          <th width="5%"><font color="#000000"><div align="center">Bil</div></font></th>
	          <th width="15%"><font color="#000000"><div align="center">Kategori</div></font></th>
	          <th width="20%"><font color="#000000"><div align="center">Tajuk</div></font></th>
	          <th width="25%"><font color="#000000"><div align="center">Lokasi</div></font></th>
	          <th width="10%"><font color="#000000"><div align="center">Tarikh</div></font></th>
	          <th width="15%"><font color="#000000"><div align="center">Status</div></font></th>
	          <th width="10%" ><font color="#000000"><div align="center">Tindakan</div></font></th>
	        </tr>
	        </thead>
	        <tbody>
	        <?php
			if(!$rs->EOF) {
			$cnt = 1;
			// $conn->debug=true;
			$bil = 0; 
			while(!$rs->EOF){ 
				// $bil++; 
				$kbil++;
				$bil = $cnt + ($PageNo-1)*$PageSize;
				$pemantauan_id=$rs->fields['pemantauan_id'];
				// $Nama = str_replace(strtoupper($carian),'<font color="#FF0000">'.strtoupper($carian).'</font>',strtoupper($rs->fields['nama']));
				$tarikh = DisplayDate($rs->fields['tarikh']);
				if(empty($tarikh)){ $tarikh = DisplayDate($rs->fields['create_dt']); }
				$status_proses = $rs->fields['status_proses'];
				$status = dlookup("_ref_status","status_nama","status_id=".tosql($status_proses));
				if(empty($status)){ $status='Draf'; }
				$hrefs = "index.php?data=". base64_encode('maklumat/barang_gunaan_form;DATA;'.$menu.';;;'.$pemantauan_id);
				// if($rs->fields['pemantauan_jenis']=='A'){ $bg='#a2cae8'; } else { $bg='#14ada6'; }
			?>
			<tr>
				<td align="center"><?=$bil;?></td>
				<td align="left"><?php print nl2br($rs->fields['subkat_nama']);?></td>
				<td align="left"><?php print nl2br($rs->fields['tajuk']);?></td>
				<td align="left"><?php print nl2br($rs->fields['tempat']);?></td>
				<td align="center"><?php print $tarikh;?></td>
				<td align="center"><?php print $status;?><br><?=$status_proses;?></td>
				<td class="actions" align="center" bgcolor="<?=$bg;?>">
					<?php if($_SESSION['SESS_ULEVEL']==2 || $_SESSION['SESS_ULEVEL']==3){ ?>
						<?php if($status_proses==0 || $status_proses==1){ ?>
					  		<a href="<?=$hrefs;?>"title="Kemaskini Maklumat Laporan Kajian"><label class="btn btn-sm btn-success"><i class="fa fa-edit" style="color:white;"></i></label></a>
					  		<?php if($status_proses==0){ ?>
								<button type="button" class="btn btn-sm btn-danger"  title="Hapus maklumat kajian barang gunaan"
									onclick="do_hapus('maklumat/sql_maklumat.php?frm=BGUNAAN&pro=DEL&ID=<?=$pemantauan_id;?>')">
									<span style="cursor:pointer;color:red" title="Hapus maklumat laporan kajian barang gunaan">
										<i class="fa fa-trash-o" style="color: #FFFFFF;"></i>
									</span>
								</button>
							<?php } ?>
						<?php } ?>&nbsp;
					<?php } ?>

					<a href="maklumat/view_bahan_gunaan.php?id=<?=$pemantauan_id;?>" data-toggle="modal" data-target="#myModal-xl"
						title="Paparan Maklumat Pemantauan" class="fa" data-backdrop="">
		                <button type="button" class="btn btn-sm btn-info">
						<span style="cursor:pointer;color:red" title="Paparan maklumat laporan kajian"><i class="fa fa-eye" style="color: #FFFFFF;"></i></span>
						</button>
					</a>	 
                    
			  </td>
			</tr>
			<?php 
					$cnt = $cnt + 1;
					$bil = $bil + 1;
					$rs->movenext(); 
				} 
			}
			?>
			</tbody>
    	</table>
	</div>
	<?php 
    $url = explode("&",$actual_link);
    $href_f=$url[0]."&table_search=".$table_search; ?>
    <?php include 'include/list_footer.php'; ?>  
</div>
<!-- DataTables -->
          