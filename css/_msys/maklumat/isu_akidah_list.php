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
    var minggu_list = $('#minggu_list').val();
    if(tahun_list=='-'){ tahun_list=''; }
    if(minggu_list=='-'){ minggu_list=''; }
    if(tahun_list.trim() == '' ){
        alert('Sila pilih tahun.');
        $('#tahun_list').focus(); return false;
	// } else if(minggu_list.trim() == ''){
 //        alert('Sila pilih minggu.');
 //        $('#minggu_list').focus(); return false;
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

$url = "index.php?data=".base64_encode('maklumat/isu_akidah_list;DATA_MEDIA;Pemerhatian Isu Akidah di Media Baru;;;;'); 
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
        <h6 class="panel-title"><font color="#000000"><b>Maklumat Laporan Pemerhatian Isu-Isu Akidah di Media Baharu</b></font></h6> 
    </header>
	</div>
    </div>            
    <br />
    <div class="box-body" style="background-color:#F2F2F2">
    	<div class="col-md-2">
    		<select name="tahun_list" id="tahun_list" class="form-control" onchange="do_page('<?=$url;?>&T=N')">
    			<?php for($t=date("Y");$t>=2021;$t--){ ?>
    				<option value="<?=$t;?>" <?php if($t==$tahun_list){ print 'selected'; } ?>><?=$t;?></option>
    			<?php } ?>
    		</select>
    	</div>
    	<div class="col-md-2">
    		<select name="minggu_list" id="minggu_list" class="form-control" onchange="do_page('<?=$url;?>&T=N')">
    			<option value="-">Semua minggu</option>
    			<?php for($m=1;$m<=52;$m++){ ?>
    				<option value="<?=$m;?>" <?php if($m==$minggu_list){ print 'selected'; } ?>><?=$m;?></option>
    			<?php } ?>
    		</select>
    	</div>

    	<?php 
			$sqla = "SELECT * FROM `_ref_topik` WHERE is_deleted=0 AND topik_status=0";
			$rsAkhbar = $conn->query($sqla); 
		?>
        <div class="col-md-2" style="background-color:#F2F2F2">
            <select name="topik_list" id="topik_list"  class="form-control" onchange="do_page('<?=$url;?>&T=N')">
                <option value="-">-- Semua jenis topik --</option>
                <?php while(!$rsAkhbar->EOF){ ?>
                <option value="<?php print $rsAkhbar->fields['topik_id'];?>" <?php if($rsAkhbar->fields['topik_id']==$topik_list){ 
                    print 'selected'; }?>><?php print $rsAkhbar->fields['topik_nama'];?></option>
                <?php $rsAkhbar->movenext(); } ?>
            </select>
        </div>
		
        <div class="col-md-2" style="background-color:#F2F2F2">
            <input type="text" name="carian" value="<?=$carian;?>" class="form-control">
        </div>
        <div class="col-md-4" style="background-color:#F2F2F2">
        	<button type="button" class="btn btn-primary" onclick="do_page('<?=$url;?>&T=N')">
                <i class=" fa fa-search"></i> <font style="font-family:Verdana, Geneva, sans-serif">Cari</font></button>
            <?php if($_SESSION['SESS_ULEVEL']==2 || $_SESSION['SESS_ULEVEL']==3){ ?>    
            	<a href="maklumat/isu_akidah_form.php" data-toggle="modal" data-target="#myModal" title="Tambah Maklumat Pemantauan" 
            	class="fa" data-backdrop="">
                <button type="button" class="btn btn-primary">
                	<i class=" fa fa-plus-square"></i> <font style="font-family:Verdana, Geneva, sans-serif"> Tambah Maklumat</font></button>
				</a>&nbsp;
			<?php } ?>
            <img src="images/printButton.png" title="Cetak" style="cursor:pointer" width="25" height="25" onclick="do_print('cetak.php?pages=maklumat/isu_akidah_list_cetak&prn=')" />&nbsp;
            <img src="images/icon_office_excel.gif" title="Salin ke EXCEL" style="cursor:pointer" width="25" height="25" onclick="do_print('cetak.php?pages=maklumat/isu_akidah_list_cetak&prn=EXCEL')" />&nbsp;
            <img src="images/icon_office_word.gif" title="Salin ke MS Word" style="cursor:pointer" width="25" height="25" onclick="do_print('cetak.php?pages=maklumat/isu_akidah_list_cetak&prn=WORD')" />&nbsp;
        </div>
        <!-- <div class="col-md-2" style="background-color:#F2F2F2">
        </div> -->
    </div> 
    
	<?php 
	// $conn->debug=true;
    $sql = "SELECT A.*, B.`topik_nama`, C.`subtopik_nama` FROM `tbl_isuakidah` A, `_ref_topik` B, `_ref_topik_sub` C 
    	WHERE A.`topik_id`=B.`topik_id` AND A.`subtopik_id`=C.`subtopik_id` AND A.`is_deleted`=0";
    if(!empty($tahun_list) && $tahun_list!='-'){ $sql .= " AND year(A.`tarikh`)='{$tahun_list}'"; }
    if(!empty($minggu_list) && $minggu_list!='-'){ $sql .= " AND A.`minggu`='{$minggu_list}'"; }
    if(!empty($topik_list) && $topik_list!='-'){ $sql .= " AND A.`topik_id`='{$topik_list}'"; }
    if(!empty($carian)){ $sql .= " AND (B.`topik_nama` LIKE '%$carian%' OR `carian_sumber` LIKE '%$carian%' OR `kenyataan` LIKE '%$carian%') "; }
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
	          <th width="10%"><font color="#000000"><div align="center">Tarikh / Minggu</div></font></th>
	          <th width="15%"><font color="#000000"><div align="center">Topik</div></font></th>
	          <th width="15%"><font color="#000000"><div align="center">Sub Topik</div></font></th>
	          <th width="15%"><font color="#000000"><div align="center">Carian Oleh</div></font></th>
	          <th width="15%"><font color="#000000"><div align="center">Sumber Carian</div></font></th>
	          <th width="10%" ><font color="#000000"><div align="center">Tindakan</div></font></th>
	        </tr>
	        </thead>
	        <tbody>
	        <?php
			if(!$rs->EOF) {
			$cnt = 1;
			// $conn->debug=true;
			$bil = 0; 
			$rsMedia = $conn->query("SELECT * FROM `_ref_medium_media` WHERE `is_deleted`=0 AND `medium_status`=0");
			while(!$rs->EOF){ 
				// $bil++; 
				$kbil++;
				$bil = $cnt + ($PageNo-1)*$PageSize;
				$id=$rs->fields['id'];
				$tarikh = DisplayDate($rs->fields['tarikh']);
				if(empty($tarikh)){ $tarikh = DisplayDate($rs->fields['tarikh']); }
				$hari = 'Ahad';
		?>
			<tr>
				<td align="center"><?=$bil;?></td>
				<td align="center"><?php print $tarikh;?><br>Minggu Ke:<?php print $rs->fields['minggu'];?></td>
				<td align="center"><?php print $rs->fields['topik_nama'];?></td>
				<td align="center"><?php print $rs->fields['subtopik_nama'];?></td>
				<td align="center"><?php print $rs->fields['carian_oleh'];?></td>
				<td align="center"><?php print $rs->fields['carian_sumber'];?></td>
				<td align="center" bgcolor="<?=$bg;?>">
					<a href="maklumat/isu_akidah_form.php?id=<?=$id;?>" data-toggle="modal" data-target="#myModal" title="Paparan Maklumat Pemantauan" class="fa" data-backdrop="">
		                <button type="button" class="btn btn-sm btn-success">
						<span style="cursor:pointer;color:red" title="Kemaskini Maklumat">
							<i class="fa fa-edit" style="color: #FFFFFF;"></i>
						</span>
					</button>
					</a>
					<?php if($_SESSION['SESS_ULEVEL']==2 || $_SESSION['SESS_ULEVEL']==3){ ?>							 
						<?php if($status_proses==0){ ?>
							<button type="button" class="btn btn-sm btn-danger" onclick="do_hapus('maklumat/sql_media.php?frm=ISU_AKIDAH&pro=DEL&ID=<?=$id;?>')">
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
          