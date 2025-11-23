<?php include '../../../connection/common.php'; ?>
<script>
	function do_save(){
		var kod = $('#kod').val();
		var pengkhususan = $('#pengkhususan').val();
		var status_pengkhususan = $('#status_pengkhususan').val();

		// alert(status_pengkhususan);

		if(kod.trim() == '' ){
			alert_msg('Sila pilih maklumat kod.');
			$('#kod').focus(); return true;
		} else if(pengkhususan.trim() == '' ){
			alert_msg('Sila pilih maklumat pengkhususan.');
			$('#pengkhususan').focus(); return true;
		} else if(status_pengkhususan.trim() == '' ){
			alert_msg('Sila pilih maklumat status_pengkhususan.');
			$('#status_pengkhususan').focus(); return true;
		} else { 
			$.ajax({
				url:'pengurusan/sql_pengurusan.php?frm=PARAMETER&jenis=PENGKHUSUSAN&pro=SAVE',
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
		// alert('sini');
		$.ajax({
				url:'pengurusan/sql_pengurusan.php?frm=PARAMETER&jenis=PENGKHUSUSAN&pro=CHECK_KOD&kod='+kod,
				type:'POST',
				//dataType: 'json',
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
						}).then(function () {
							document.getElementById("kod").value = "";
						});
					}

					
				},
			});
	}
</script>
<?php
	//$conn->debug=true;
	$pengkhususan_kod=isset($_REQUEST["pengkhususan_kod"])?$_REQUEST["pengkhususan_kod"]:"";
	//print $pengkhususan_kod;
	$sql3 = "SELECT * FROM $schema1.`ref_pengkhususan` WHERE kod='{$pengkhususan_kod}'";
	$rs = $conn->query($sql3);
?>
<div class="col-lg-12">
	<section class="panel">
		<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="do_close()">×</button>
			<h6 class="panel-title"><font color="#000000" size="3"><b>TAMBAH MAKLUMAT PENGKHUSUSAN</b></font></h6>
		</header>
		<div class="panel-body">
			<div class="box-body">

			<!-- <input type="hidden" name="kod" id="kod" value="<?=$rs->fields['kod'];?>" readonly="readonly"/> -->

				<div class="col-md-12">
                    <div class="form-group">
						<div class="row">
							<label for="kod" class="col-sm-2 control-label"><b>Kod <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10">
								<input type="text" name="kod" id="kod" class="form-control" value="<?php if(!empty($pengkhususan_kod)){ print $rs->fields['kod'];} ?>" onkeyup="do_kod(this.value)">
							</div>
						</div>
					</div>
                    <div class="form-group">
						<div class="row">
							<label for="pengkhususan" class="col-sm-2 control-label"><b>Pengkhususan <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10">
								<input type="text" name="pengkhususan" id="pengkhususan" class="form-control" value="<?php if(!empty($pengkhususan_kod)){ print $rs->fields['DISKRIPSI']; } ?>">
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
                            <label for="tajuk" class="col-sm-2 control-label"><b>No. Pemerolehan : </b></label>
							<div class="col-sm-10">
								<input type="text" name="no_pemerolehan" id="no_pemerolehan" class="form-control" value="<?php if(!empty($pengkhususan_kod)){ print $rs->fields['NO_PEMEROLEHAN']; }?>">
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
                            <label for="tajuk" class="col-sm-2 control-label"><b>Status <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-3">
                                <select name="status_pengkhususan" id="status_pengkhususan" class="form-control">
                                    <option value="">Sila pilih status</option>
                                    <option value="0" <?php if(!empty($pengkhususan_kod)){ if($rs->fields['STATUS'] == 0){ print 'selected';}} ?>>Aktif</option>
                                    <option value="1" <?php if(!empty($pengkhususan_kod)){  if($rs->fields['STATUS'] == 1){ print 'selected';} } ?>>Tidak Aktif</option>
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