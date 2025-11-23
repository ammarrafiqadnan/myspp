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
$tempoh=isset($_REQUEST["tempoh"])?$_REQUEST["tempoh"]:"";
$list_status=isset($_REQUEST["list_status"])?$_REQUEST["list_status"]:"";
if($list_status=='-'){ $list_status=''; $_SESSION["SS_status"]=''; } 
else { 
	if($list_status<>"-"){ $_SESSION["SS_status"] = $list_status; }
	else { $list_status = $_SESSION["SS_status"]; }
}
if($tempoh=='-'){ $tempoh=''; $_SESSION["SS_tempoh"]=''; } 
else { 
	if($tempoh<>"-"){ $_SESSION["SS_tempoh"] = $tempoh; }
	else { $tempoh = $_SESSION["SS_tempoh"]; }
}

?>

<input type="hidden" id="vals" name="vals" value=""  />
		<!-- <div class="box" style="background-color:#F2F2F2">
      <div class="box-body">
				<div class="x_panel" style="background-color:#F2F2F2">
					<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
						<div class="panel-actions"></div>
						<h6 class="panel-title"><font color="#000000"><b><?=$menu;?></b></font></h6> 
					</header>
				</div>
      </div>            
		</div><br> -->
		<div class="box" style="background-color:#F2F2F2">
      <div class="box-body">
				<div class="x_panel" style="background-color:#F2F2F2">
					<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
						<div class="panel-actions"></div>
						<h6 class="panel-title"><font color="#000000"><b>Maklumat Sukan</b></font></h6> 
					</header>
				</div>
      </div>            
			<br />
            <div class="box-body" style="background-color:#F2F2F2">
              <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead  style="background-color:rgb(38, 167, 228)">
                  <th width="5%"><font color="#000000"><div align="center">Bil</div></font></th>
                  <th width="50%"><font color="#000000"><div align="center">Jenis Sukan</div></font></th>
                  <th width="15%"><font color="#000000"><div align="center">Tahun</div></font></th>
                  <th width="10%"><font color="#000000"><div align="center">Peringkat</div></font></th>
                  <th width="10%"><font color="#000000"><div align="center">Sijil</div></font></th>
                  <th width="10%"><font color="#000000"><div align="center">Tindakan</div></font></th>
                </thead>
                <tbody>
            
								  <tr>
									  <td align="center">1.</td>
									  <td align="left"><?php print $rs->fields['nama'];?>Bolasepak</td>
									  <td align="center"><?php print $rs->fields['no_pengenalan'];?>2020</td>
									  <td align="center"><?php print $warganegara;?>Kebangsaan</td>
									  <td align="center">

									  </td>
									  <td align="center">
												<a href="koku/sukan_form.php?id=<?=$id;?>" data-toggle="modal" data-target="#myModal" title="Paparan Maklumat Sijil Profesional" class="fa" data-backdrop="">
							          <button type="button" class="btn btn-sm btn-success">
												<span style="cursor:pointer;color:red" title="Kemaskini Maklumat">
													<i class="fa fa-edit" style="color: #FFFFFF;"></i>
												</span>
											</button>
											</a>
											<?php if($_SESSION['SESS_ULEVEL']==2 || $_SESSION['SESS_ULEVEL']==3){ ?>	 
												<?php if($status_proses==0){ ?>
													<button type="button" class="btn btn-sm btn-danger" onclick="do_hapus('maklumat/sql_media.php?frm=ISU_MEDIA&pro=DEL&ID=<?=$id;?>')">
														<span style="cursor:pointer;color:red" title="Hapus maklumat isu agama">
															<i class="fa fa-trash-o" style="color: #FFFFFF;"></i>
														</span>
													</button> 
												<?php } ?>
	                    <?php } ?>
				            </td>
								  </tr>

								  <tr>
									  <td align="right" colspan="6">
												<a href="koku/sukan_form.php?id=<?=$id;?>" data-toggle="modal" data-target="#myModal" title="Tambah Maklumat Sijil" class="fa" data-backdrop="">
							          <button type="button" class="btn btn-sm btn-primary">
												<span style="cursor:pointer;font-family: Arial;" title="Tambah Maklumat Sijil">
													Tambah Maklumat
												</span>
											</button>
											</a>
				            </td>
								  </tr>
                </tbody>
              </table>
            </div>
		</div>


		<div class="box" style="background-color:#F2F2F2">

            <div class="box-body">
				<div class="x_panel" style="background-color:#F2F2F2">
					<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
						<div class="panel-actions"></div>
						<h6 class="panel-title"><font color="#000000"><b>Maklumat Persatuan / Kepimpinan</b></font></h6> 
					</header>
				</div>
            </div>            
			<br />
            <div class="box-body" style="background-color:#F2F2F2">
              <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead  style="background-color:rgb(38, 167, 228)">
                  <th width="5%"><font color="#000000"><div align="center">Bil</div></font></th>
                  <th width="50%"><font color="#000000"><div align="center">Nama Persatuan</div></font></th>
                  <th width="15%"><font color="#000000"><div align="center">Jawatan</div></font></th>
                  <th width="10%"><font color="#000000"><div align="center">Peringkat</div></font></th>
                  <th width="10%"><font color="#000000"><div align="center">Sijil</div></font></th>
                  <th width="10%"><font color="#000000"><div align="center">Tindakan</div></font></th>
                </thead>
                <tbody>
            
								  <tr>
									  <td align="center">1.</td>
									  <td align="left"><?php print $rs->fields['nama'];?>Persatuan Bulan Sabil Merah</td>
									  <td align="center"><?php print $rs->fields['no_pengenalan'];?>Bendahari</td>
									  <td align="center"><?php print $warganegara;?>Negeri</td>
									  <td align="center">

									  </td>
									  <td align="center">
												<a href="koku/persatuan_form.php?id=<?=$id;?>" data-toggle="modal" data-target="#myModal" title="Paparan Maklumat Sijil Profesional" class="fa" data-backdrop="">
							          <button type="button" class="btn btn-sm btn-success">
												<span style="cursor:pointer;color:red" title="Kemaskini Maklumat">
													<i class="fa fa-edit" style="color: #FFFFFF;"></i>
												</span>
											</button>
											</a>
											<?php if($_SESSION['SESS_ULEVEL']==2 || $_SESSION['SESS_ULEVEL']==3){ ?>	 
												<?php if($status_proses==0){ ?>
													<button type="button" class="btn btn-sm btn-danger" onclick="do_hapus('maklumat/sql_media.php?frm=ISU_MEDIA&pro=DEL&ID=<?=$id;?>')">
														<span style="cursor:pointer;color:red" title="Hapus maklumat isu agama">
															<i class="fa fa-trash-o" style="color: #FFFFFF;"></i>
														</span>
													</button> 
												<?php } ?>
	                    <?php } ?>
				            </td>
								  </tr>

								  <tr>
									  <td align="right" colspan="6">
												<a href="koku/persatuan_form.php?id=<?=$id;?>" data-toggle="modal" data-target="#myModal" title="Tambah Maklumat Sijil" class="fa" data-backdrop="">
							          <button type="button" class="btn btn-sm btn-primary">
												<span style="cursor:pointer;font-family: Arial;" title="Tambah Maklumat Sijil">
													Tambah Maklumat
												</span>
											</button>
											</a>
				            </td>
								  </tr>
                </tbody>
              </table>
            </div>
		</div>
          