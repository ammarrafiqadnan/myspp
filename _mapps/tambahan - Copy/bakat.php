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

// print "ST:".$list_status;
//$conn->debug=true;
?>

<input type="hidden" id="vals" name="vals" value=""  />
		<div class="box" style="background-color:#F2F2F2">
      <div class="box-body">
				<!-- <div class="x_panel" style="background-color:#F2F2F2">
					<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
						<div class="panel-actions"></div>
						<h6 class="panel-title"><font color="#000000"><b><?=$menu;?></b></font></h6> 
					</header>
				</div> -->
				<div class="form-group">
						<div class="row">
							<div class="col-sm-12">
							<label for="nama" class="col-sm-12 control-label"><b>ARAHAN : </b>
								<ul>
									<li>Ruangan ini hanya diisi oleh pemohon yang memohon jawatan di bawah Klasifikasi Perkhidmatan Bakat dan Seni.</li>
									<li>Sila pilih bakat yang paling mahir.</li>
								</ul>
							</label>
						</div>
						</div>
					</div>
      </div>            
		</div>
		<div class="box" style="background-color:#F2F2F2">
      <div class="box-body">
				<div class="x_panel" style="background-color:#F2F2F2">
					<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
						<div class="panel-actions"></div>
						<h6 class="panel-title"><font color="#000000"><b>Maklumat Bakat</b></font></h6> 
					</header>
				</div>
      </div>            
			<br />
            <div class="box-body" style="background-color:#F2F2F2">
              <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead  style="background-color:rgb(38, 167, 228)">
                  <th width="5%"><font color="#000000"><div align="center">Bil</div></font></th>
                  <th width="25%"><font color="#000000"><div align="center">Jenis Bakat</div></font></th>
                  <th width="50%"><font color="#000000"><div align="center">Kenyataan</div></font></th>
                  <!-- <th width="10%"><font color="#000000"><div align="center">Sijil</div></font></th> -->
                  <th width="10%"><font color="#000000"><div align="center">Tindakan</div></font></th>
                </thead>
                <tbody>
            
								  <tr>
									  <td align="center">1.</td>
									  <td align="left"><?php print $rs->fields['nama'];?>Lakonan</td>
									  <td align="left"><?php print $rs->fields['no_pengenalan'];?>Berlakon bersama Aaron Aziz</td>
									  <!-- <td align="center">

									  </td> -->
									  <td align="center">
												<a href="tambahan/bakat_form.php?id=<?=$id;?>" data-toggle="modal" data-target="#myModal" title="Paparan Maklumat Sijil Profesional" class="fa" data-backdrop="">
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
									  <td align="right" colspan="4">
												<a href="tambahan/bakat_form.php?id=<?=$id;?>" data-toggle="modal" data-target="#myModal" title="Tambah Maklumat Sijil" class="fa" data-backdrop="">
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
						<h6 class="panel-title"><font color="#000000"><b>Maklumat Kebolehan Bahasa / Dialek Selain Bahasa Melayu</b></font></h6> 
					</header>
				</div>
            </div>            
			<br />
            <div class="box-body" style="background-color:#F2F2F2">
              <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead  style="background-color:rgb(38, 167, 228)">
                  <th width="5%"><font color="#000000"><div align="center">Bil</div></font></th>
                  <th width="50%"><font color="#000000"><div align="center">Bahasa / Dialek</div></font></th>
                  <th width="15%"><font color="#000000"><div align="center">Penguasaan</div></font></th>
                  <th width="10%"><font color="#000000"><div align="center">Tindakan</div></font></th>
                </thead>
                <tbody>
            
								  <tr>
									  <td align="center">1.</td>
									  <td align="left"><?php print $rs->fields['nama'];?>Bahasa Jerman</td>
									  <td align="center"><?php print $rs->fields['no_pengenalan'];?>Bertutur & Menulis </td>
									  <td align="center">
												<a href="tambahan/bakat_bahasa_form.php?id=<?=$id;?>" data-toggle="modal" data-target="#myModal" title="Paparan Maklumat Sijil Profesional" class="fa" data-backdrop="">
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
									  <td align="right" colspan="4">
												<a href="tambahan/bakat_bahasa_form.php?id=<?=$id;?>" data-toggle="modal" data-target="#myModal" title="Tambah Maklumat Sijil" class="fa" data-backdrop="">
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
          