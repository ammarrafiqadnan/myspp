<link href="vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
<script language="javascript">
function do_click_btn(vals){
	//alert("hai");
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
$JFORM='LIST';
$tkh=date("Y-m-d");
$upd_btn='';
//$conn->debug=true;

//$conn->debug=false;
$dt = date("Y-m-d");

$carian=isset($_REQUEST["carian"])?$_REQUEST["carian"]:"";
$list_status=isset($_REQUEST["list_status"])?$_REQUEST["list_status"]:"";
if($list_status=='-'){ $list_status=''; $_SESSION["SS_status"]=''; } 
else { 
	if(!empty($list_status)){ $_SESSION["SS_status"] = $list_status; }
	else { $list_status = $_SESSION["SS_status"]; }
}
// print "ST:".$list_status;
//$conn->debug=true;
$dt = date("Y-m-d");
$rss = $conn->query("SELECT * FROM `tbl_penyembelih_detail` WHERE `tarikh_sah_akhir`<'{$dt}' AND `status`=0 AND `is_deleted`=0");
while(!$rss->EOF){
	$id_det = $rss->fields['id_det'];
	$id_penyembelih = $rss->fields['id_penyembelih'];
	
	$sql = "UPDATE `tbl_penyembelih_detail` SET `status`=1 WHERE `id_det`='{$id_det}' AND `status`=0 AND `is_deleted`=0 ";
	$conn->query($sql);

	$sql = "UPDATE `tbl_penyembelih` SET `status`=1 WHERE `id`='{$id_penyembelih}' AND `plik_status`=0 AND `is_deleted`=0 ";
	$conn->query($sql);

	$rss->movenext();
}
?>

<input type="hidden" id="vals" name="vals" value=""  />
		<div class="box" style="background-color:#F2F2F2">

            <div class="box-body">
				<div class="x_panel" style="background-color:#F2F2F2">
					<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
						<div class="panel-actions"></div>
						<h6 class="panel-title"><font color="#000000"><b><?=$menu;?></b></font></h6> 
					</header>
				</div>
            </div>            
			<br />
            <div class="form-group">
                <div class="col-md-2" style="background-color:#F2F2F2">
                	<select name="list_status" id="list_status" class="form-control">
                		<option value="-">Semua Status</option>
                		<option value="A"<?php if($list_status=="A"){ print 'selected';}?>>Rekod Aktif</option>
                        <!-- <option value="1"<?php if($rsk->fields['status']==1){ print 'selected';}?>>Rekod Tidak Aktif</option> -->
                        <option value="2"<?php if($list_status=="2"){ print 'selected';}?>>Pembatalan</option>
                        <option value="3"<?php if($list_status=="3"){ print 'selected';}?>>Berhenti</option>
                        <option value="4"<?php if($list_status=="4"){ print 'selected';}?>>Pengantungan Sementara</option>
                		<option value="9"<?php if($list_status=="9"){ print 'selected'; }?>>Tiada Sijil</option>
                	</select>
                </div>
                <div class="col-md-3" style="background-color:#F2F2F2">
                	<input type="text" name="carian" id="carian" value="<?=$carian;?>" class="form-control">
                </div>
                <div class="col-md-6 col-sm-4 col-xm-4">
                    <button type="button" class="btn btn-success" 
                      	onclick="do_page('index.php?data=<?php print base64_encode($pages.";".$module.";".$menu);?>')">
                    	<i class="fa fa-search"></i> Carian
                    </button>

                    <?php if($_SESSION['SESS_ULEVEL']==2 || $_SESSION['SESS_ULEVEL']==3){ ?>    	
	                     <a href="maklumat_data/pass_tambah.php" 
	                        data-toggle="modal" data-target="#myModal"  
	                        title="Tambah Maklumat Pemegang Tauliah Sembelihan" class="fa" data-backdrop="static">
	                        <button type="button" class="btn btn-primary">
	                        <i class=" fa fa-plus-square"></i> <font style="font-family:Verdana, Geneva, sans-serif"> Tambah Pemegang Pas</font></button>
						</a>
					<?php } ?>
					&nbsp;
		            <img src="images/printButton.png" title="Cetak" style="cursor:pointer" width="25" height="25" onclick="do_print('cetak.php?pages=maklumat_data/pass_list_cetak&prn=')" />&nbsp;
		            <img src="images/icon_office_excel.gif" title="Salin ke EXCEL" style="cursor:pointer" width="25" height="25" onclick="do_print('cetak.php?pages=maklumat_data/pass_list_cetak&prn=EXCEL')" />&nbsp;
		            <img src="images/icon_office_word.gif" title="Salin ke MS Word" style="cursor:pointer" width="25" height="25" onclick="do_print('cetak.php?pages=maklumat_data/pass_list_cetak&prn=WORD')" />&nbsp;
		        </div>
	        </div> 
            
            

			<?php 
			// $conn->debug=true;
			// $rss = $conn->query("SELECT `status` FROM `tbl_penyembelih_detail` WHERE `id_penyembelih`='{$id}' AND `is_deleted`=0 ORDER BY `tarikh_sah_akhir` DESC");

			$sql = "SELECT * FROM `tbl_penyembelih` WHERE is_deleted=0 "; 
			if(!empty($carian)){ $sql .= " AND (nama LIKE '%{$carian}%' OR no_pengenalan LIKE '%{$carian}%')"; }
			if(!empty($list_status) && $list_status<>"-"){ 
				if($list_status=='A'){ $sql .= " AND status='0'"; }
				else { $sql .= " AND status='{$list_status}'"; }
			}
			$sql .= " ORDER BY `nama` DESC";
			$kbil=0; $tbil=0;
            ?>    
			<?php include_once 'include/list_head.php'; ?>
            <?php include_once 'include/page_list.php'; $conn->debug=true; ?>
            <div class="box-body" style="background-color:#F2F2F2">
              <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead  style="background-color:rgb(38, 167, 228)">
                  <th width="5%"><font color="#000000"><div align="center">Bil</div></font></th>
                  <th width="20%"><font color="#000000"><div align="center">Nama</div></font></th>
                  <th width="10%"><font color="#000000"><div align="center">No. Pengenalan</div></font></th>
                  <th width="10%"><font color="#000000"><div align="center">Warganegara</div></font></th>
                  <th width="10%"><font color="#000000"><div align="center">No. Tel</div></font></th>
                  <th width="25%"><font color="#000000"><div align="center">Majikan</div></font></th>
                  <th width="10%"><font color="#000000"><div align="center">Tarikh</div></font></th>
                  <th width="5%"><font color="#000000"><div align="center">Status</div></font></th>
                  <th width="5%"><font color="#000000"><div align="center">Tindakan</div></font></th>
                </thead>
                <tbody>
            <?php 
            	$conn->debug=false;
				$cnt = 1; 
				$bil = $StartRec;
				while(!$rs->EOF){ $kbil++; $tbil++;
					$bil = $cnt + ($PageNo-1)*$PageSize;
					$id = $rs->fields['id'];
					$data = $conn->query("SELECT `majikan_nama`, `tarikh_sah_mula`, `tarikh_sah_akhir` FROM `tbl_penyembelih_detail` WHERE id_penyembelih='{$id}' ORDER BY `tarikh_sah_mula` DESC");
					$hrefs = "index.php?data=". base64_encode('maklumat_data/pass_form;DATA;Maklumat Pemegang Surat Kebenaran Sembelihan;;;'.$id);

					$status=''; $tarikh='';
					$rss = $conn->query("SELECT `status` FROM `tbl_penyembelih_detail` WHERE `id_penyembelih`='{$id}' AND `is_deleted`=0 ORDER BY `tarikh_sah_akhir` DESC");
					if(!$rss->EOF){ $rss->fields['status'];
						if($rss->fields['status']=='1'){ 
							$status = '<font color="black">Sijil Tamat Tempoh</font>';
							$tarikh = '<font style="color:red">'.DisplayDate($data->fields['tarikh_sah_mula']).' -<br>'.DisplayDate($data->fields['tarikh_sah_akhir']).'&nbsp;&nbsp;</font>'; 
						} else if($rss->fields['status']=='2'){ 
							$status = '<font color="red">Dibatalkan</font>'; 
							$tarikh = '<font style="color:red">'.DisplayDate($data->fields['tarikh_sah_mula']).' -<br>'.DisplayDate($data->fields['tarikh_sah_akhir']).'&nbsp;&nbsp;</font>';
						} else if($rss->fields['status']=='3'){ 
							$status = '<font color="red">Berhenti</font>'; 
							$tarikh = '<font style="color:red">'.DisplayDate($data->fields['tarikh_sah_mula']).' -<br>'.DisplayDate($data->fields['tarikh_sah_akhir']).'&nbsp;&nbsp;</font>';
						} else if($rss->fields['status']=='4'){ 
							$status = '<font color="red">Gantung Sementara</font>'; 
							$tarikh = '<font style="color:red">'.DisplayDate($data->fields['tarikh_sah_mula']).' -<br>'.DisplayDate($data->fields['tarikh_sah_akhir']).'&nbsp;&nbsp;</font>';
						} else { 
							$status = '<font color="green">Sijil Aktif</font>'; 
							$tarikh = DisplayDate($data->fields['tarikh_sah_mula']).' -<br>'.DisplayDate($data->fields['tarikh_sah_akhir'])."&nbsp;&nbsp;";
						}
					} else { 
						$status = '<font color="red">Tiada Sijil</font>';
					}
				?>
				  <tr>
					  <td align="center"><?=$bil;?>.</td>
					  <td align="left"><?php print $rs->fields['nama'];?><br /></td>
					  <td align="center"><?php print $rs->fields['no_pengenalan'];?></td>
					  <td align="center"><?php print $rs->fields['fldcountry'];?></td>
					  <td align="center"><?php print $rs->fields['no_tel'];?></td>
					  <td align="center"><?php print $data->fields['majikan_nama'];?></td>
					  <td align="center"><?php print$tarikh;?></td>
					  <td align="center"><?php print $status; ?></td>
					  <td align="center">
						<a href="<?=$hrefs;?>"title="Kemaskini Maklumat Pemegang kad Sembelihan"><label class="btn btn-sm btn-success"><i class="fa fa-edit" style="color:white;"></i></label></a>
						<?php if($_SESSION['SESS_ULEVEL']==2 || $_SESSION['SESS_ULEVEL']==3){ ?>
							<button type="button" class="btn btn-sm btn-danger" title="Hapus maklumat pemegang kad sembelihan"
								onclick="do_hapus('maklumat_data/sql_maklumat_data.php?frm=PASS&pro=DEL&ID=<?=$id;?>')" >
								<span style="cursor:pointer;color:red" title="Hapus maklumat pemegang kad sembelihan">
									<i class="fa fa-trash-o" style="color: #FFFFFF;"></i>
								</span>
							</button>
						<?php } ?>
                      </td>
				  </tr>
				<?php 
					$cnt = $cnt + 1;
					$bil = $bil + 1;
					$rs->movenext();
			}
			
			?>
                </tbody>
              </table>
            </div>
		</div>
		<?php 
        $url = explode("&",$actual_link);
        $href_f=$url[0]."&table_search=".$table_search; ?>
        <?php include 'include/list_footer.php'; ?>  
     </div>
<!-- DataTables -->
          