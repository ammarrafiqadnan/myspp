<?php include '../../../connection/common.php'; ?>
<script>
	function do_save(){
		var peringkat_kelulusan = $('#peringkat_kelulusan').val();
		var status_peringkat_kelulusan = $('#status_peringkat_kelulusan').val();

		if(peringkat_kelulusan.trim() == '' ){
			alert_msg('Sila isi maklumat peringkat kelulusan.');
			$('#peringkat_kelulusan').focus(); return true;
		} else if(status_peringkat_kelulusan.trim() == '' ){
			alert_msg('Sila pilih maklumat status peringkat kelulusan.');
			$('#status_peringkat_kelulusan').focus(); return true;
		} else { 
			$.ajax({
				url:'pengurusan/sql_pengurusan.php?frm=PARAMETER&jenis=PERINGKAT_KELULUSAN&pro=SAVE',
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
	$peringkat_kelulusan_kod=isset($_REQUEST["peringkat_kelulusan_kod"])?$_REQUEST["peringkat_kelulusan_kod"]:"";
	$sql3 = "SELECT * FROM $schema1.`ref_peringkat_kelulusan` WHERE kod='{$peringkat_kelulusan_kod}'";
	$rs = $conn->query($sql3);
?>
<div class="col-lg-12">
	<section class="panel">
		<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="do_close()">×</button>
			<h6 class="panel-title"><font color="#000000" size="3"><b><?php if(!empty($peringkat_kelulusan_kod)){ print 'KEMASKINI'; } else { print 'TAMBAH'; } ?> MAKLUMAT peringkat_kelulusan</b></font></h6>
		</header>
		<div class="panel-body">
			<div class="box-body">
            
			<input type="hidden" name="kod" id="kod" value="<?php if(!empty($peringkat_kelulusan_kod)){ print $rs->fields['kod']; }?>"/>

				<div class="col-md-12">
                    <div class="form-group">
						<div class="row">
							<label for="peringkat_kelulusan" class="col-sm-3 control-label"><b>Peringkat Kelulusan <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-9">
								<input type="text" name="peringkat_kelulusan" id="peringkat_kelulusan" class="form-control" value="<?php if(!empty($peringkat_kelulusan_kod)){ print $rs->fields['diskripsi']; } ?>">
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
                            <label for="tajuk" class="col-sm-3 control-label"><b>Status <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-3">
                                <select name="status_peringkat_kelulusan" id="status_peringkat_kelulusan" class="form-control">
                                    <option value="">Sila pilih status</option>
                                    <option value="0" <?php if(!empty($peringkat_kelulusan_kod)){ if($rs->fields['status'] == 0){ print 'selected';}} ?>>Aktif</option>
                                    <option value="1" <?php if(!empty($peringkat_kelulusan_kod)){  if($rs->fields['status'] == 1){ print 'selected';} } ?>>Tidak Aktif</option>
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