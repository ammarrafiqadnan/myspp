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
	var href='maklumat/program_list_cetak.php?val='+val;
	document.jawi.action=href;
	document.jawi.target='_blank';
	document.jawi.submit();
}
</script>
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

    <div class="box-body">
    <div class="x_panel" style="background-color:#F2F2F2">
	<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
        <div class="panel-actions">
        <!--<a href="#" class="fa fa-caret-down"></a>
        <a href="#" class="fa fa-times"></a>-->
        </div>
        <h6 class="panel-title"><font color="#000000"><b>Maklumat Pemantauan - ULASAN KETUA BAHAGIAN</b></font></h6> 
    </header>
	</div>
    </div>            
    <br />
    <div class="box-body" style="background-color:#F2F2F2">
		<?php 
			$sqla = "SELECT * FROM `_ref_kategori_sub` WHERE is_deleted=0 AND subkat_status=0 AND kategori_id=1";
			$rsdata = $conn->query($sqla); 
		?>
        <div class="col-md-5" style="background-color:#F2F2F2">
            <select name="pemantauan_types" id="pemantauan_types"  class="form-control" onchange="do_page('<?=$url;?>&T=N')">
                <option value="-">-- Semua Kategori --</option>
                <?php while(!$rsdata->EOF){ ?>
                <option value="<?php print $rsdata->fields['subkat_id'];?>" <?php if($rsdata->fields['subkat_id']==$pemantauan_types){ 
                    print 'selected'; }?>><?php print $rsdata->fields['subkat_nama'];?></option>
                <?php $rsdata->movenext(); } ?>
            </select><br>
        </div>
       <!--  <div class="col-md-2" style="background-color:#F2F2F2">
            <a href="maklumat/pemantauan_tambah.php" data-toggle="modal" data-target="#myModal" title="Tambah Maklumat Pemantauan" class="fa" data-backdrop="">
                <button type="button" class="btn btn-primary">
                <i class=" fa fa-plus-square"></i> <font style="font-family:Verdana, Geneva, sans-serif"> Tambah Maklumat</font></button>
			</a>
        </div> -->
        <!-- <div class="col-md-2" style="background-color:#F2F2F2">
            <img src="images/printButton.png" title="Cetak" style="cursor:pointer" width="25" height="25" onclick="do_print('PRN')" />&nbsp;
            <img src="images/icon_office_excel.gif" title="Salin ke EXCEL" style="cursor:pointer" width="25" height="25" onclick="do_print('EXCEL')" />&nbsp;
            <img src="images/icon_office_word.gif" title="Salin ke MS Word" style="cursor:pointer" width="25" height="25" onclick="do_print('WORD')" />&nbsp;
        </div> -->
    </div> 
    
	<?php 
	// $conn->debug=true;
    $sql = "SELECT * FROM `tbl_pemantauan` A, `_ref_kategori_sub` B WHERE A.`pemantauan_type`=B.`subkat_id` AND A.`is_deleted`=0";
    if(!empty($pemantauan_types) && $pemantauan_types!='-'){ $sql .= " AND A.pemantauan_type='{$pemantauan_types}'"; }
	$sql .= " AND A.status_proses IN (3)";
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
			//$cnt = 1;
			$bil = 0; 
			while(!$rs->EOF){ 
				// $bil++; $kbil++;
				$bil = $cnt + ($PageNo-1)*$PageSize;
				$pemantauan_id=$rs->fields['pemantauan_id'];
				// $Nama = str_replace(strtoupper($carian),'<font color="#FF0000">'.strtoupper($carian).'</font>',strtoupper($rs->fields['nama']));
				$tarikh = DisplayDate($rs->fields['tarikh']);
				if(empty($tarikh)){ $tarikh = DisplayDate($rs->fields['create_dt']); }
				$status_proses = $rs->fields['status_proses'];
				$status = dlookup("_ref_status","status_nama","status_id=".tosql($status_proses));
				if(empty($status)){ $status='Draf'; }
				$status_ulasan = dlookup("tbl_pemantauan_ulasan","pid","jenis_ulasan=5 AND pemantauan_id=".tosql($pemantauan_id));
				$hrefs = "index.php?data=". base64_encode('maklumat/pemantauan_form;DATA;Maklumat Pemantauan;;;'.$pemantauan_id)
			?>
			<tr>
				<td align="center"><?=$bil;?></td>
				<td align="left"><?php print nl2br($rs->fields['subkat_nama']);?></td>
				<td align="left"><?php print nl2br($rs->fields['tajuk']);?></td>
				<td align="left"><?php print nl2br($rs->fields['tempat']);?></td>
				<td align="center"><?php print $tarikh;?></td>
				<td align="center">
					<?php print $status;?>
					<?php if(!empty($status_ulasan)){
						print '<br><i style="color:#f00">Kemaskini Laporan</i>';
					} ?>
				</td>
				<td class="actions" align="center">
					<a href="maklumat/ulasan_kb_form.php?id=<?=$pemantauan_id;?>" data-toggle="modal" data-target="#myModal-xl" title="Paparan Maklumat Pemantauan" class="fa" data-backdrop="">
		                <button type="button" class="btn btn-sm btn-success">
						<span style="cursor:pointer;color:red" title="Ulasan Ketua Bahagian">
							<i class="fa fa-edit" style="color: #FFFFFF;"></i>
						</span>
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
          