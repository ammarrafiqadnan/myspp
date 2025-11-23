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
    var tahun_list = $('#tahun_list').val();
    var bulan_list = $('#bulan_list').val();
    if(tahun_list=='-'){ tahun_list=''; }
    if(bulan_list=='-'){ bulan_list=''; }
    
    if(tahun_list.trim() == '' ){
        alert('Sila pilih tahun.');
        $('#tahun_list').focus(); return false;
	// } else if(bulan_list.trim() == ''){
 //        alert('Sila pilih bulan.');
 //        $('#bulan_list').focus(); return false;
	} else { 
		do_cetak(val);
	}
}

</script>
<?php
$JFORM='LIST';
$tkh=date("Y-m-d");
$upd_btn='';
//$conn->debug=true;

$url = "index.php?data=".base64_encode('maklumat/isu_agama_list;DATA_MEDIA;Pemerhatian Isu Agama Di Akhbar;;;;'); 
$carian=strtoupper(isset($_REQUEST["carian"])?$_REQUEST["carian"]:"");
$T=isset($_REQUEST["T"])?$_REQUEST["T"]:"";
$akhbar=isset($_REQUEST["akhbar"])?$_REQUEST["akhbar"]:"";
$kategori=isset($_REQUEST["kategori"])?$_REQUEST["kategori"]:"";
$bulan_list=isset($_REQUEST["bulan_list"])?$_REQUEST["bulan_list"]:"";
$tahun_list=isset($_REQUEST["tahun_list"])?$_REQUEST["tahun_list"]:"";

if($T=='N'){ $_SESSION['SESS_carian']=''; }

if(!empty($tahun_list) || !empty($tahun_list)){
	$_SESSION['SESS_tahun']=$tahun_list;
} else {
	$tahun_list=$_SESSION['SESS_tahun'];
}
if(!empty($bulan_list) || !empty($bulan_list)){
	$_SESSION['SESS_bulan']=$bulan_list;
} else {
	$bulan_list=$_SESSION['SESS_bulan'];
}
if(!empty($akhbar) || !empty($akhbar)){
	$_SESSION['SESS_akhbar']=$akhbar;
} else {
	$akhbar=$_SESSION['SESS_akhbar'];
}
if(!empty($kategori) || !empty($kategori)){
	$_SESSION['SESS_kategori']=$kategori;
} else {
	$kategori=$_SESSION['SESS_kategori'];
}
if(!empty($carian) || !empty($carian)){
	$_SESSION['SESS_carian']=$carian;
} else {
	$carian=$_SESSION['SESS_carian'];
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
		        <h6 class="panel-title"><font color="#000000"><b>Maklumat Pemerhatian Isu Agama Di Akhbar</b></font></h6> 
		    </header>
		</div>
    </div>            
    <br />
    <div class="box-body" style="height: 40px;background-color:#F2F2F2;">
    	<div class="col-md-2">
    		<select name="tahun_list" id="tahun_list" class="form-control" onchange="do_page('<?=$url;?>&T=N')">
    			<?php for($t=date("Y");$t>=2021;$t--){ ?>
    				<option value="<?=$t;?>" <?php if($t==$tahun_list){ print 'selected'; } ?>><?=$t;?></option>
    			<?php } ?>
    		</select>
    	</div>
    	<div class="col-md-2">
    		<select name="bulan_list" id="bulan_list" class="form-control" onchange="do_page('<?=$url;?>&T=N')">
    			<option value="-">Bulan</option>
    			<?php for($m=1;$m<=12;$m++){ ?>
    				<option value="<?=$m;?>" <?php if($m==$bulan_list){ print 'selected'; } ?>><?=$m;?></option>
    			<?php } ?>
    		</select>
    	</div>
		<?php 
			$sqla = "SELECT * FROM `_ref_akhbar` WHERE is_deleted=0 AND akhbar_status=0";
			$rsAkhbar = $conn->query($sqla); 
		?>
        <div class="col-md-2" style="background-color:#F2F2F2">
            <select name="akhbar" id="akhbar"  class="form-control" onchange="do_page('<?=$url;?>&T=N')">
                <option value="-">-- Semua jenis akhbar --</option>
                <?php while(!$rsAkhbar->EOF){ ?>
                <option value="<?php print $rsAkhbar->fields['akhbar_id'];?>" <?php if($rsAkhbar->fields['akhbar_id']==$akhbar){ 
                    print 'selected'; }?>><?php print $rsAkhbar->fields['akhbar_nama'];?></option>
                <?php $rsAkhbar->movenext(); } ?>
            </select>
        </div>
		<?php 
			$sqla = "SELECT * FROM `_ref_isuagama` WHERE is_deleted=0 AND isuagama_status=0";
			$rsIsu = $conn->query($sqla); 
		?>
        <div class="col-md-3" style="background-color:#F2F2F2">
            <select name="kategori" id="kategori"  class="form-control" onchange="do_page('<?=$url;?>&T=N')">
                <option value="-">-- Semua kategori --</option>
                <?php while(!$rsIsu->EOF){ ?>
                <option value="<?php print $rsIsu->fields['isuagama_id'];?>" <?php if($rsIsu->fields['isuagama_id']==$kategori){ 
                    print 'selected'; }?>><?php print $rsIsu->fields['isuagama_nama'];?></option>
                <?php $rsIsu->movenext(); } ?>
            </select>
        </div>
    </div>
    <div class="box-body" style="height: 60px;background-color:#F2F2F2;">
        <div class="col-md-2" style="background-color:#F2F2F2">
            <input type="text" name="carian" value="<?=$carian;?>" class="form-control">
        </div>
        <div class="col-md-4" style="background-color:#F2F2F2">
        	<button type="button" class="btn btn-primary" onclick="do_page('<?=$url;?>&T=N')">
                <i class=" fa fa-search"></i> <font style="font-family:Verdana, Geneva, sans-serif">Cari</font></button>
            <?php if($_SESSION['SESS_ULEVEL']==2 || $_SESSION['SESS_ULEVEL']==3){ ?>
	            <a href="maklumat/isu_agama_form.php" data-toggle="modal" data-target="#myModal" title="Tambah Maklumat Pemantauan" class="fa" data-backdrop="">
	                <button type="button" class="btn btn-primary">
	                <i class=" fa fa-plus-square"></i> <font style="font-family:Verdana, Geneva, sans-serif"> Tambah Maklumat</font></button>
				</a>&nbsp;
			<?php } ?>
			<img src="images/printButton.png" title="Cetak" style="cursor:pointer" width="25" height="25" onclick="do_print('cetak.php?pages=maklumat/isu_agama_list_cetak&prn=')" />&nbsp;
            <img src="images/icon_office_excel.gif" title="Salin ke EXCEL" style="cursor:pointer" width="25" height="25" onclick="do_print('cetak.php?pages=maklumat/isu_agama_list_cetak&prn=EXCEL')" />&nbsp;
            <img src="images/icon_office_word.gif" title="Salin ke MS Word" style="cursor:pointer" width="25" height="25" onclick="do_print('cetak.php?pages=maklumat/isu_agama_list_cetak&prn=WORD')" />&nbsp;
        </div>
        <!--  -->
    </div> 
    
	<?php 
	// $conn->debug=true;
    $sql = "SELECT A.*, B.`isuagama_nama`, C.`akhbar_nama` FROM `tbl_isu_agama` A, `_ref_isuagama` B, `_ref_akhbar` C 
    	WHERE A.`kategori_id`=B.`isuagama_id` AND A.`akhbar_id`=C.`akhbar_id` AND A.`is_deleted`=0";
    if(!empty($tahun_list) && $tahun_list!='-'){ $sql .= " AND year(A.`tarikh`)='{$tahun_list}'"; }
    if(!empty($bulan_list) && $bulan_list!='-'){ $sql .= " AND month(A.`tarikh`)='{$bulan_list}'"; }
    if(!empty($akhbar) && $akhbar!='-'){ $sql .= " AND A.`akhbar_id`='{$akhbar}'"; }
    if(!empty($kategori) && $kategori!='-'){ $sql .= " AND A.`kategori_id`='{$kategori}'"; }
    if(!empty($carian)){ $sql .= " AND A.`tajuk` LIKE '%$carian%'"; }
    $sql .= " ORDER BY `tarikh` DESC"
	// $rs = $conn->query($sql);
    ?>    
	<?php include_once 'include/list_head.php'; ?>
    <?php include_once 'include/page_list.php'; ?>
    <div class="box-body" style="background-color:#F2F2F2">
      	<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
	        <thead  style="background-color:rgb(38, 167, 228)">
	        <tr>
	          <th width="5%"><font color="#000000"><div align="center">Bil</div></font></th>
	          <th width="10%"><font color="#000000"><div align="center">Tarikh</div></font></th>
	          <th width="10%"><font color="#000000"><div align="center">Hari</div></font></th>
	          <th width="35%"><font color="#000000"><div align="center">Tajuk</div></font></th>
	          <th width="15%"><font color="#000000"><div align="center">Akhbar</div></font></th>
	          <th width="15%"><font color="#000000"><div align="center">Kategori</div></font></th>
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
				$id=$rs->fields['id'];
				$tarikh = DisplayDate($rs->fields['tarikh']);
				if(empty($tarikh)){ $tarikh = DisplayDate($rs->fields['tarikh']); }
				//$hari = 'Ahad';
				$timestamp = strtotime($rs->fields['tarikh']);
				$hari = get_hari(date('D', $timestamp));

				if(!empty($rs->fields['alamat_url'])){
					$tajuk = '<a href="'.$rs->fields['alamat_url'].'" target="_blank">'.$rs->fields['tajuk'].'</a>';
				} else {
					$tajuk = $rs->fields['tajuk'];
				}
			?>
			<tr>
				<td align="center"><?=$bil;?></td>
				<td align="center"><?php print $tarikh;?></td>
				<td align="center"><?php print $hari;?></td>
				<td align="left"><?php print nl2br($tajuk);?></td>
				<td align="center"><?php print $rs->fields['akhbar_nama'];?></td>
				<td align="center"><?php print $rs->fields['isuagama_nama'];?></td>
				<td class="actions" align="center" bgcolor="<?=$bg;?>">
					<a href="maklumat/isu_agama_form.php?id=<?=$id;?>" data-toggle="modal" data-target="#myModal" title="Paparan Maklumat Pemantauan" class="fa" data-backdrop="">
		                <button type="button" class="btn btn-sm btn-success">
						<span style="cursor:pointer;color:red" title="Kemaskini Maklumat">
							<i class="fa fa-edit" style="color: #FFFFFF;"></i>
						</span>
					</button>
					</a>
					<?php if($_SESSION['SESS_ULEVEL']==2 || $_SESSION['SESS_ULEVEL']==3){ ?> 
						<?php if($status_proses==0){ ?>
						<button type="button" class="btn btn-sm btn-danger" onclick="do_hapus('maklumat/sql_media.php?frm=ISU_AKHBAR&pro=DEL&ID=<?=$id;?>')">
							<span style="cursor:pointer;color:red" title="Hapus maklumat isu agama">
								<i class="fa fa-trash-o" style="color: #FFFFFF;"></i>
							</span>
						</button> 
						<?php } ?>    
					<?php } ?>
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
	<?php 
    $url = explode("&",$actual_link);
    $href_f=$url[0]."&table_search=".$table_search; ?>
    <?php include 'include/list_footer.php'; ?>  
</div>
<!-- DataTables -->
          