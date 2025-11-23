<?php include '../../../connection/common.php'; ?>
<script>
	function do_save(){
    var kod = $('#kod').val();
    var negeri = $('#negeri').val();
    var status_negeri = $('#status_negeri').val();

	// alert(status_negeri);

    if(kod.trim() == '' ){
        alert_msg('Sila isi maklumat kod.');
        $('#kod').focus(); return true;
    } else if(negeri.trim() == '' ){
        alert_msg('Sila isi maklumat negeri.');
        $('#negeri').focus(); return true;
    } else if(status_negeri.trim() == '' ){
        alert_msg('Sila pilih maklumat status negeri.');
        $('#status_negeri').focus(); return true;
    } else { 
		$.ajax({
			url:'pengurusan/sql_pengurusan.php?frm=NEGERI&pro=SAVE',
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
	$negeri_kod=isset($_REQUEST["negeri_kod"])?$_REQUEST["negeri_kod"]:"";
	//print $negeri_kod;
	$sql3 = "SELECT * FROM $schema2.`ref_negeri` WHERE kod='{$negeri_kod}'";
	$rsState = $conn->query($sql3);
?>
<div class="col-lg-12">
	<section class="panel">
		<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="do_close()">×</button>
			<h6 class="panel-title"><font color="#000000" size="3"><b>KEMASKINI MAKLUMAT NEGERI</b></font></h6>
		</header>
		<div class="panel-body">
			<div class="box-body">

			<!-- <input type="hidden" name="kod" id="kod" value="<?=$rsState->fields['kod'];?>" readonly="readonly"/> -->

				<div class="col-md-12">
                    <div class="form-group">
						<div class="row">
							<label for="kod" class="col-sm-2 control-label"><b>Kod <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10">
								<input type="text" name="kod" id="kod" class="form-control" value="<?=$rsState->fields['kod'];?>" readonly>
							</div>
						</div>
					</div>
                    <div class="form-group">
						<div class="row">
							<label for="negeri" class="col-sm-2 control-label"><b>Negeri <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10">
								<input type="text" name="negeri" id="negeri" class="form-control" value="<?=$rsState->fields['diskripsi2'];?>">
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
                            <label for="tajuk" class="col-sm-2 control-label"><b>Status <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-3">
                                <select name="status_negeri" id="status_negeri" class="form-control">
                                    <option value="">Sila pilih status</option>
                                    <option value="0" <?php if($rsState->fields['status'] == 0){ print 'selected';} ?>>Aktif</option>
                                    <option value="1" <?php if($rsState->fields['status'] == 1){ print 'selected';} ?>>Tidak Aktif</option>
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