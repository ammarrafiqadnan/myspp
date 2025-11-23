<?php include '../../../connection/common.php'; ?>
<script>
	function do_save(){
		var kursus_svm_kod = $('#kursus_svm_kod').val();
		var kursus_svm = $('#kursus_svm').val();
		var status_kursus_svm = $('#status_kursus_svm').val();

		if(kursus_svm_kod.trim() == '' ){
			alert_msg('Sila isi maklumat kod skim.');
			$('#kursus_svm_kod').focus(); return true;
		} else if(kursus_svm.trim() == '' ){
			alert_msg('Sila isi maklumat kursus SVM.');
			$('#kursus_svm').focus(); return true;
		} else if(status_kursus_svm.trim() == '' ){
			alert_msg('Sila pilih maklumat status kursus SVM.');
			$('#status_kursus_svm').focus(); return true;
		} else { 
			$.ajax({
				url:'pengurusan/sql_pengurusan.php?frm=PARAMETER&jenis=KURSUS_SVM&pro=SAVE',
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
	function do_kod(kursus_svm_kod) {
		$.ajax({
			url:'pengurusan/sql_pengurusan.php?frm=PARAMETER&jenis=KURSUS_SVM&pro=CHECK_KOD&kod='+kursus_svm_kod,
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
	$kursus_svm_kod=isset($_REQUEST["kursus_svm_kod"])?$_REQUEST["kursus_svm_kod"]:"";
	$sql3 = "SELECT * FROM $schema1.`ref_kursus_svm` WHERE KOD='{$kursus_svm_kod}'";
	$rs = $conn->query($sql3);
	//print $rs;
?>
<div class="col-lg-12">
	<section class="panel">
		<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="do_close()">×</button>
			<h6 class="panel-title"><font color="#000000" size="3"><b><?php if(!empty($kursus_svm_kod)){ print 'KEMASKINI'; } else { print 'TAMBAH'; } ?> MAKLUMAT KURSUS SVM</b></font></h6>
		</header>
		<div class="panel-body">
			<div class="box-body">

				<div class="col-md-12">
					<div class="form-group">
						<div class="row">
							<label for="kursus_svm_kod" class="col-sm-3 control-label"><b>Kod <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-9">
								<input type="text" name="kursus_svm_kod" id="kursus_svm_kod" class="form-control" maxlength=5 value="<?php if(!empty($kursus_svm_kod)){ print $rs->fields['KOD'];} ?>" onchange="do_kod(this.value)" <?php if(!empty($kursus_svm_kod)){ print 'readonly';} ?>>
							</div>
						</div>
					</div>
                    <div class="form-group">
						<div class="row">
							<label for="kursus_svm" class="col-sm-3 control-label"><b>Kursus SVM <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-9">
								<input type="text" name="kursus_svm" id="kursus_svm" class="form-control" value="<?php if(!empty($kursus_svm_kod)){ print $rs->fields['DISKRIPSI']; } ?>">
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
                            <label for="tajuk" class="col-sm-3 control-label"><b>Status <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-3">
                                <select name="status_kursus_svm" id="status_kursus_svm" class="form-control">
                                    <option value="">Sila pilih status</option>
                                    <option value="0" <?php if(!empty($kursus_svm_kod)){ if($rs->fields['STATUS'] == 0){ print 'selected';}} ?>>Aktif</option>
                                    <option value="1" <?php if(!empty($kursus_svm_kod)){  if($rs->fields['STATUS'] == 1){ print 'selected';} } ?>>Tidak Aktif</option>
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