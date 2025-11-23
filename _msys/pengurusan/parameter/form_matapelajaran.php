<?php include '../../../connection/common.php'; ?>
<script>
	function do_save(){
		var matapelajaran = $('#matapelajaran').val();
		var status_matapelajaran = $('#status_matapelajaran').val();
		var tingkatan = $('#tingkatan').val();
		var kod = $('#kod').val();


		if(kod.trim() == '' ){
			alert_msg('Sila isi maklumat kod.');
			$('#matapelajaran').focus(); return true;
		} else if(matapelajaran.trim() == '' ){
			alert_msg('Sila isi maklumat matapelajaran.');
			$('#matapelajaran').focus(); return true;
		} else if(tingkatan.trim() == '' ){
			alert_msg('Sila isi maklumat tingkatan matapelajaran.');
			$('#tingkatan').focus(); return true;
		} else if(status_matapelajaran.trim() == '' ){
			alert_msg('Sila pilih maklumat status matapelajaran.');
			$('#status_matapelajaran').focus(); return true;
		} else { 
			$.ajax({
				url:'pengurusan/sql_pengurusan.php?frm=PARAMETER&jenis=MATAPELAJARAN&pro=SAVE',
				type:'POST',
				//dataType: 'json',
				// beforeSend: function () {
				// 	$('.btn-primary').attr("disabled","disabled");
				// 	$('.modal-body').css('opacity', '.5');
				// },
				data: $("form").serialize(),
				success: function(data){
					console.log(data);
					if(data=='OK'){
						swal({
							title: 'Berjaya',
							text: 'Maklumat telah berjaya disimpan',
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
			url:'pengurusan/sql_pengurusan.php?frm=PARAMETER&jenis=MATAPELAJARAN&pro=CHECK_KOD&kod='+kod,
			type:'POST',
			//dataType: 'json',
			data: $("form").serialize(),
			success: function(data){
				// console.log(data);
				if(data=='ERR'){
					swal({
						title: 'Amaran',
						text: 'Kod telah wujud. Sila masukkan kod lain.',
						type: 'error',
						confirmButtonClass: "btn-warning",
						confirmButtonText: "Ok",
						showConfirmButton: true,
					})
					// .then(function () {
					// 	document.getElementById("kod").value = "";
					// });
				}

				
			},
		});
	}
</script>
<?php
	// $conn->debug=true;
	$matapelajaran_kod=isset($_REQUEST["matapelajaran_kod"])?$_REQUEST["matapelajaran_kod"]:"";
	$sql3 = "SELECT * FROM $schema1.`ref_matapelajaran` WHERE kod='{$matapelajaran_kod}'";
	$rs = $conn->query($sql3);
?>
<div class="col-lg-12">
	<section class="panel">
		<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="do_close()">×</button>
			<h6 class="panel-title"><font color="#000000" size="3"><b><?php if(!empty($matapelajaran_kod)){ print 'KEMASKINI'; } else { print 'TAMBAH'; } ?> MAKLUMAT MATAPELAJARAN</b></font></h6>
		</header>
		<div class="panel-body">
			<div class="box-body">
            
				<!-- <input type="hidden" name="kod" id="kod" value="<?php if(!empty($matapelajaran_kod)){ print $rs->fields['kod']; }?>"/> -->

				<div class="col-md-12">
					<div class="form-group">
						<div class="row">
							<label for="kod" class="col-sm-3 control-label"><b>Kod <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-9">
								<input type="text" name="kod" id="kod" class="form-control" value="<?php if(!empty($matapelajaran_kod)){ print $rs->fields['kod']; } ?>" onchange="do_kod(this.value)" <?php if(!empty($matapelajaran_kod)){ print 'readonly';} ?>>
							</div>
						</div>
					</div>
                    <div class="form-group">
						<div class="row">
							<label for="matapelajaran" class="col-sm-3 control-label"><b>Matapelajaran <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-9">
								<input type="text" name="matapelajaran" id="matapelajaran" class="form-control" value="<?php if(!empty($matapelajaran_kod)){ print $rs->fields['DISKRIPSI']; } ?>">
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<label for="tingkatan" class="col-sm-3 control-label"><b>Tingkatan <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-9">
								<input type="text" name="tingkatan" id="tingkatan" class="form-control" value="<?php if(!empty($matapelajaran_kod)){ print $rs->fields['TKT']; } ?>">
							</div>
						</div>
					</div>
                    <div class="form-group">
						<div class="row">
							<label for="no_pemerolehan" class="col-sm-3 control-label"><b>No. Pemerolehan  : </b></label>
							<div class="col-sm-9">
								<input type="text" name="no_pemerolehan" id="no_pemerolehan" class="form-control" value="<?php if(!empty($matapelajaran_kod)){ print $rs->fields['NO_PEMEROLEHAN']; } ?>">
							</div>
						</div>
					</div>
					

					<div class="form-group">
						<div class="row">
                            <label for="tajuk" class="col-sm-3 control-label"><b>Status <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-3">
                                <select name="status_matapelajaran" id="status_matapelajaran" class="form-control">
                                    <option value="">Sila pilih status</option>
                                    <option value="0" <?php if(!empty($matapelajaran_kod)){ if($rs->fields['STATUS'] == 0){ print 'selected';}} ?>>Aktif</option>
                                    <option value="1" <?php if(!empty($matapelajaran_kod)){  if($rs->fields['STATUS'] == 1){ print 'selected';} } ?>>Tidak Aktif</option>
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