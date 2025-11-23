<?php include '../../../connection/common.php'; ?>
<script>
	function do_save(){
    var kod = $('#kod').val();
    var universiti = $('#universiti').val();
    var status_universiti = $('#status_universiti').val();

	// alert(status_universiti);

    if(kod.trim() == '' ){
        alert_msg('Sila pilih maklumat kod.');
        $('#kod').focus(); return true;
    } else if(universiti.trim() == '' ){
        alert_msg('Sila pilih maklumat universiti.');
        $('#universiti').focus(); return true;
    } else if(status_universiti.trim() == '' ){
        alert_msg('Sila pilih maklumat status_universiti.');
        $('#status_universiti').focus(); return true;
    } else { 
		$.ajax({
			url:'pengurusan/sql_pengurusan.php?frm=PARAMETER&jenis=UNIVERSITI&pro=SAVE',
			type:'POST',
			//dataType: 'json',
			beforeSend: function () {
				$('.btn-primary').attr("disabled","disabled");
				$('.modal-body').css('opacity', '.5');
			},
			data: $("form").serialize(),
			success: function(data){
				console.log(data);
				if(data=='OK'){
					swal({
						title: 'Berjaya',
						text: 'Maklumat telah berjaya dikemaskini',
						type: 'success',
						confirmButtonClass: "btn-success",
						confirmButtonText: "Ok",
						showConfirmButton: true,
					}).then(function () {
						// window.location.href = url;
						reload = window.location; 
						window.location = reload;
					});
				} else if(data=='ERR'){
					swal({
						title: 'Amaran',
						text: 'Terdapat ralat sistem.\nMaklumat anda tidak berjaya diproses.',
						type: 'error',
						confirmButtonClass: "btn-warning",
						confirmButtonText: "Ok",
						showConfirmButton: true,
					});
				}
			},
		});   
    }
}

function do_kod(kod) {
	$.ajax({
			url:'pengurusan/sql_pengurusan.php?frm=PARAMETER&jenis=UNIVERSITI&pro=CHECK_KOD&kod='+kod,
			type:'POST',
			//dataType: 'json',
			beforeSend: function () {
				$('.btn-primary').attr("disabled","disabled");
				$('.modal-body').css('opacity', '.5');
			},
			data: $("form").serialize(),
			success: function(data){
				console.log(data);
				if(data=='ERR'){
					swal({
						title: 'Amaran',
						text: 'Kod telah wujud. Sila masukkan kod lain.',
						type: 'error',
						confirmButtonClass: "btn-warning",
						confirmButtonText: "Ok",
						showConfirmButton: true,
					});
				}
			},
		});
}
</script>
<?php
	$universiti_kod=isset($_REQUEST["universiti_kod"])?$_REQUEST["universiti_kod"]:"";
	//print $universiti_kod;
	$sql3 = "SELECT * FROM $schema1.`ref_institusi` WHERE KOD='{$universiti_kod}'";
	$rs = $conn->query($sql3);
?>
<div class="col-lg-12">
	<section class="panel">
		<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="do_close()">×</button>
			<h6 class="panel-title"><font color="#000000" size="3"><b>TAMBAH MAKLUMAT UNIVERSITI</b></font></h6>
		</header>
		<div class="panel-body">
			<div class="box-body">

				<div class="col-md-12">
                    <div class="form-group">
						<div class="row">
							<label for="kod" class="col-sm-2 control-label"><b>Kod <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10">
								<input type="text" name="kod" id="kod" class="form-control" value="<?php if(!empty($universiti_kod)){ print $rs->fields['KOD']; }?>" onkeyup="do_kod(this.value)">
							</div>
						</div>
					</div>
                    <div class="form-group">
						<div class="row">
							<label for="universiti" class="col-sm-2 control-label"><b>Universiti <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10">
								<input type="text" name="universiti" id="universiti" class="form-control" value="<?php if(!empty($universiti_kod)){ print $rs->fields['DISKRIPSI']; } ?>">
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
                            <label for="tajuk" class="col-sm-2 control-label"><b>Negara <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-5">
                                <?php
									//$conn->debug=true;
									$sql3 = "SELECT * FROM $schema1.`ref_negara`";
									$rsCountry = $conn->query($sql3);
								?>
								<select name="negara_universiti" id="negara_universiti" class="form-control">
									<option value="">Sila pilih negara</option>
									<?php while(!$rsCountry->EOF){ ?>    
										<option value="<?=$rsCountry->fields['KOD'];?>" <?php if(!empty($universiti_kod)){ if($rs->fields['NEGARA'] == $rsCountry->fields['KOD']){ print 'selected';} }?>><?php print $rsCountry->fields['DISKRIPSI'];?></option>
									<?php $rsCountry->movenext(); } ?>
								</select>
                            </div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
                            <label for="tajuk" class="col-sm-2 control-label"><b>Jenis Institusi <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-3">
                                <select name="jenis_institusi" id="jenis_institusi" class="form-control">
                                    <option value="">Sila pilih jenis institusi</option>
                                    <option value="1" <?php if(!empty($universiti_kod)){ if($rs->fields['JENIS_INSTITUSI'] == 1){ print 'selected';}} ?>>Awam</option>
                                    <option value="2" <?php if(!empty($universiti_kod)){ if($rs->fields['JENIS_INSTITUSI'] == 2){ print 'selected';}} ?>>Swasta</option>
                                </select>
                            </div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
                            <label for="tajuk" class="col-sm-2 control-label"><b>Status <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-3">
                                <select name="status_universiti" id="status_universiti" class="form-control">
                                    <option value="">Sila pilih status</option>
                                    <option value="0" <?php if(!empty($universiti_kod)){ if($rs->fields['STATUS'] == 0){ print 'selected';} } ?>>Aktif</option>
                                    <option value="1" <?php if(!empty($universiti_kod)){ if($rs->fields['STATUS'] == 1){ print 'selected';} } ?>>Tidak Aktif</option>
                                </select>
                            </div>
						</div>
					</div>

					<div class="modal-footer" style="padding:0px;">
						<button type="button" class="btn btn-primary mt-sm mb-sm" onclick="do_save()"><i class="fa fa-save"></i> Simpan</button>
						&nbsp;
						<button type="button" class="btn btn-default" onclick="do_close()"><i class="fa fa-spinner" style="margin:0px;"></i> Kembali</button>
					</div>
				</div>

			
			</div>
		</div>
	     
	</section>

</div> 

<script>
    function do_close(){
        reload = window.location; 
        window.location = reload;
    }
</script>