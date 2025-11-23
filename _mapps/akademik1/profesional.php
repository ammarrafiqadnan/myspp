<!-- <link href="vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
<link href="vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet"> -->
<script language="javascript">
function do_click_btn(vals){
	//alert("hai");
	var href='index.php?data=bWFrbHVtYXQvdGluZGFrYW5fbGlzdDtEQVRBO01ha2x1bWF0IFRpbmRha2FuOzs7Ow==&#'+vals;
	document.jawi.action=href;
	document.jawi.target='_self';
	document.jawi.submit();
}
function do_save(){
    var reg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
    var professional_1 = $('#professional_1').val();
    var professional_d_1 = $('#professional_d_1').val();
    var professional_no_ahli_1 = $('#professional_no_ahli_1').val();
	var msg = '';
    
    if(professional_1.trim() == '' ){
        msg = msg+"\n- Sila pilih maklumat sijil professional.";
        $('#professional_1').css("border-color","#f00");
    } 
    if(professional_d_1.trim() == '' ){
        msg = msg+"\n- Sila masukkan maklumat tarikh.";
        $('#professional_d_1').css("border-color","#f00");
    } 
    if(professional_no_ahli_1.trim() == '' ){
        msg = msg+"\n- Sila masukkan maklumat nombor keahlian.";
        $('#professional_no_ahli_1').css("border-color","#f00");
    }
	if(msg.trim() !=''){ 
		alert_msg_html(msg);
	} else {
		var fd = new FormData();
        var files1 = $('#file_profesional')[0].files[0];
        // var files2 = $('#upload_id2')[0].files[0];
        fd.append('file_profesional',files1);
        // fd.append('upload_id2',files2);

        var other_data = $('form').serializeArray();
		$.each(other_data,function(key,input){
		    fd.append(input.name,input.value);
		});

        $.ajax({
	        url:'akademik/sql_akademik.php?frm=PROFESIONAL&pro=SAVE',
            type:'POST',
            //dataType: 'json',
            beforeSend: function () {
                //$('.btn-primary').attr("disabled","disabled");
                //$('.modal-body').css('opacity', '.5');
            },
			data:  fd,
            contentType: false,
            cache: false,
            processData:false,
            success: function(data){
                console.log(data);
                // alert(data);
                if(data=='OK'){
                    swal({
                      title: 'Berjaya',
                      text: 'Maklumat telah berjaya disimpan',
                      type: 'success',
                      confirmButtonClass: "btn-success",
                      confirmButtonText: "Ok",
                      showConfirmButton: true,
                    }).then(function () {
						reload = window.location; 
						window.location = reload;
                    });
                } else if(data=='ERR'){
                    swal({
                      title: 'Amaran',
                      text: 'Terdapat ralat sistem.\nMaklumat anda tidak berjaya dikemaskini.',
                      type: 'error',
                      confirmButtonClass: "btn-warning",
                      confirmButtonText: "Ok",
                      showConfirmButton: true,
                    });
                }
                //window.location.reload();

            },
            //data: datas
        });
    }
}
</script>
<?php
$JFORM='LIST';
$user = get_user($conn,$_SESSION['SESS_UID']);
$data = get_profesional($conn,$_SESSION['SESS_UID']);
$uid=$_SESSION['SESS_UID'];
// print_r($data);
// $conn->debug=true;
$rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='PRO' AND `id_pemohon`=".tosql($uid));
if(empty($rsSijil->fields['sijil_nama'])){ $sijil="../upload_doc/PMR_Mock_Result_Statement_Certificate.png"; }
else { $sijil = "../uploads_doc/".$uid."/".$rsSijil->fields['sijil_nama']; }
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
			<div class="panel-body">
			<div class="box-body">

			<input type="hidden" name="id_pemohon" id="id_pemohon" value="<?php print $data['id_pemohon'];?>" readonly="readonly"/>

				<div class="col-md-12">

					<?php include 'biodata/biodata_view.php'; ?>

					<div class="form-group">
						<div class="row">
							<p>
							  <button class="btn btn-primary form-control" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" title="Sila klik untuk membaca arahan berkaitan kemasukan data akademik SPM">
							    ARAHAN:
							  </button>
							</p>
							<!-- <div class="collapse" id="collapseExample"> -->
							  <div class="card card-body">
									<label for="nama" class="col-sm-12 control-label"><b>ARAHAN :</b>
										<ul>
											<li>Ruangan ini perlu diisi oleh pemohon yang memiliki sijil daripada badan-badan profesional yang diiktiraf oleh Kerajaan selain daripada butiran Kelulusan Pengajian Tinggi ATAU salah satu daripada syarat-syarat kelayakan masuk ke jawatan berkenaan.</li>
										</ul>
									</label>

							  </div>
							<!-- </div> -->
						</div>
					</div>
					<hr>

					<div class="form-group">
						<div class="row">
							<div class="col-sm-8">
								<div class="form-group">
                <div class="row">
                    <label for="professional_1" class="col-sm-3 control-label"><b>Nama Sijil</b><font color="#FF0000">*</font> : </label>
                    <div class="col-sm-9">
						<select name="professional_1" id="professional_1" class="form-control select2 select2-accessible" style="width: 100%;" aria-hidden="true">
							<option value="">Sila pilih</option>
							<<?php print get_sijil_pro($conn, $data['professional_1']); ?>
						</select>
                        <!-- <input type="text" name="info_tarikh" id="info_tarikh" class="form-control modal-input" value="" /> -->
                    </div>
                </div>
            </div>
                <?php //print substr($data['professional_d_1'],0,10);?>
            <div class="form-group">
                <div class="row">
                    <label for="professional_d_1" class="col-sm-3 control-label"><b>Tarikh Keahlian</b><font color="#FF0000">*</font> : </label>
                    <div class="col-sm-3">
                        <input type="date" name="professional_d_1" id="professional_d_1" class="form-control modal-input" 
                        value="<?php print substr($data['professional_d_1'],0,10);?>" />
                    </div><!-- 
                    <div class="col-sm-3">
                        <input type="date" name="info_tarikh" id="info_tarikh" class="form-control modal-input" value="<?php print $tarikh;?>" />
                    </div> -->
                </div>
            </div>
            
            <div class="form-group">
                <div class="row">
                    <label for="professional_no_ahli_1" class="col-sm-3 control-label"><b>No. Keahlian</b><font color="#FF0000">*</font> : </label>
                   
                    <div class="col-sm-9">
                        <input type="text" name="professional_no_ahli_1" id="professional_no_ahli_1" class="form-control modal-input" 
                        value="<?php print $data['professional_no_ahli_1'];?>" maxlength="20" />
                    </div>
                </div>
            </div>
                        
            
					</div>

					<div class="col-sm-4" align="center">
						<img src="<?=$sijil;?>" width="300" height="400">
						<input type="file" name="file_profesional" id="file_profesional" class="form-control">
					</div>

				</div>
			</div>

			<div class="modal-footer" style="padding:0px;">
				<button type="button" id="simpan" class="btn btn-primary mt-sm mb-sm" onclick="do_save()"><i class="fa fa-save"></i> Simpan</button>
				<?php if(!empty($data['professional_1'])){ ?>
					<label class="btn btn-danger" onclick="do_hapus('akademik/sql_akademik.php?frm=PROFESIONAL&pro=DEL&id_pemohon=<?=$uid;?>')">Hapus</label>
				<?php } ?>
			</div>
		</div>

	
	</div>
</div>
            <!-- <div class="box-body" style="background-color:#F2F2F2">
              <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead  style="background-color:rgb(209 29 29)">
                  <th width="5%"><font color="#000000"><div align="center">Bil</div></font></th>
                  <th width="50%"><font color="#000000"><div align="center">Nama Sijil</div></font></th>
                  <th width="15%"><font color="#000000"><div align="center">Tarikh Keahlian</div></font></th>
                  <th width="10%"><font color="#000000"><div align="center">No. Keahlian</div></font></th>
                  <th width="10%"><font color="#000000"><div align="center">Sijil</div></font></th>
                  <th width="10%"><font color="#000000"><div align="center">Tindakan</div></font></th>
                </thead>
                <tbody>
            
								  <tr>
									  <td align="center">1.</td>
									  <td align="left"><?php print $rs->fields['nama'];?>SIJIL ACCA</td>
									  <td align="center"><?php print $rs->fields['no_pengenalan'];?>10/10/2022 - 09/10/2025</td>
									  <td align="center"><?php print $warganegara;?>AZ011923</td>
									  <td align="center">

									  </td>
									  <td align="center">
												<a href="akademik/profesional_form.php?id=<?=$id;?>" data-toggle="modal" data-target="#myModal" title="Paparan Maklumat Sijil Profesional" class="fa" data-backdrop="">
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
									  <td align="center">2.</td>
									  <td align="left"></td>
									  <td align="center"></td>
									  <td align="center"></td>
									  <td align="right" colspan="2">
												<a href="akademik/profesional_form.php?id=<?=$id;?>" data-toggle="modal" data-target="#myModal" title="Tambah Maklumat Sijil" class="fa" data-backdrop="">
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
            </div> -->
		</div>
          