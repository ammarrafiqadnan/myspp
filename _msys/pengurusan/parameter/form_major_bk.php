<?php include '../../../connection/common.php'; ?>
<script>
	function do_save(){
		var major = $('#major').val();
		var status_major = $('#status_major').val();

		if(major.trim() == '' ){
			alert_msg('Sila isi maklumat major.');
			$('#major').focus(); return true;
		} else if(status_major.trim() == '' ){
			alert_msg('Sila pilih maklumat status major.');
			$('#status_major').focus(); return true;
		} else { 
			$.ajax({
				url:'pengurusan/sql_pengurusan.php?frm=PARAMETER&jenis=MAJOR&pro=SAVE',
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
</script>
<?php
	$major_kod=isset($_REQUEST["major_kod"])?$_REQUEST["major_kod"]:"";
	$sql3 = "SELECT * FROM $schema1.`ref_major` WHERE kod='{$major_kod}'";
	$rs = $conn->query($sql3);
?>
<div class="col-lg-12">
	<section class="panel">
		<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="do_close()">×</button>
			<h6 class="panel-title"><font color="#000000" size="3"><b><?php if(!empty($major_kod)){ print 'KEMASKINI'; } else { print 'TAMBAH'; } ?> MAKLUMAT MAJOR</b></font></h6>
		</header>
		<div class="panel-body">
			<div class="box-body">
            
			<input type="hidden" name="kod" id="kod" value="<?php if(!empty($major_kod)){ print $rs->fields['KOD']; }?>"/>

				<div class="col-md-12">
                    <div class="form-group">
						<div class="row">
							<label for="major" class="col-sm-3 control-label"><b>Diskripsi<font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-9">
								<input type="text" name="major" id="major" class="form-control" style="text-transform:uppercase" value="<?php if(!empty($major_kod)){ print $rs->fields['DISKRIPSI']; } ?>">
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
                            <label for="tajuk" class="col-sm-3 control-label"><b>Status <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-3">
                                <select name="status_major" id="status_major" class="form-control">
                                    <option value="">Sila pilih status</option>
                                    <option value="0" <?php if(!empty($major_kod)){ if($rs->fields['STATUS'] == 0){ print 'selected';}} ?>>Aktif</option>
                                    <option value="1" <?php if(!empty($major_kod)){  if($rs->fields['STATUS'] == 1){ print 'selected';} } ?>>Tidak Aktif</option>
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