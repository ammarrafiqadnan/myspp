<?php include '../../../connection/common.php'; ?>
<script>
	function do_save(){
		var pusatTemuduga = $('#pusatTemuduga').val();
		var status_pusatTemuduga = $('#status_pusatTemuduga').val();

		if(pusatTemuduga.trim() == '' ){
			alert_msg('Sila pilih maklumat peringkat kelulusan.');
			$('#pusatTemuduga').focus(); return true;
		} else if(status_pusatTemuduga.trim() == '' ){
			alert_msg('Sila pilih maklumat status peringkat kelulusan.');
			$('#status_pusatTemuduga').focus(); return true;
		} else { 
			$.ajax({
				url:'pengurusan/sql_pengurusan.php?frm=PARAMETER&jenis=PUSAT_TEMUDUGA&pro=SAVE',
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
	$pusatTemuduga_kod=isset($_REQUEST["pusatTemuduga_kod"])?$_REQUEST["pusatTemuduga_kod"]:"";
	$sql3 = "SELECT * FROM $schema1.`ref_jenis_pusatTemuduga` WHERE kod='{$pusatTemuduga_kod}'";
	$rs = $conn->query($sql3);
?>
<div class="col-lg-12">
	<section class="panel">
		<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="do_close()">×</button>
			<h6 class="panel-title"><font color="#000000" size="3"><b>TAMBAH MAKLUMAT PUSAT TEMU DUGA</b></font></h6>
		</header>
		<div class="panel-body">
			<div class="box-body">
            
				<input type="hidden" name="kod" id="kod" value="<?php if(!empty($pusatTemuduga_kod)){ print $rs->fields['kod']; }?>"/>

				<div class="col-md-12">
                    <div class="form-group">
						<div class="row">
							<label for="pusatTemuduga" class="col-sm-3 control-label"><b>Pusat Temuduga <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-9">
								<input type="text" name="pusatTemuduga" id="pusatTemuduga" class="form-control" value="<?php if(!empty($pusatTemuduga_kod)){ print $rs->fields['diskripsi']; } ?>">
							</div>
						</div>
					</div>

                    <!-- <?php 
                    $rsState = $conn->query("SELECT * FROM $schema2.`ref_negeri`"); ?>
                    <div class="form-group row">
                        <label class="col-lg-3 control-label"><b> Negeri :</b><font color="red">*</font></label>
                        <div class="col-lg-4">
                            <select class="form-control" name="com_state" id="com_state">
                                <option value="">-- Sila pilih --</option>
                                <?php while(!$rsState->EOF){ ?>
                                <option value="<?php print $rsState->fields['kod'];?>"><?php print $rsState->fields['diskripsi2'];?></option>
                                <?php $rsState->movenext(); } ?>
                            </select>
                        </div>
                    </div> -->

					<div class="form-group">
						<div class="row">
                            <label for="tajuk" class="col-sm-3 control-label"><b>Status <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-3">
                                <select name="status_pusatTemuduga" id="status_pusatTemuduga" class="form-control">
                                    <option value="">Sila pilih status</option>
                                    <option value="0" <?php if(!empty($pusatTemuduga_kod)){ if($rs->fields['status'] == 0){ print 'selected';}} ?>>Aktif</option>
                                    <option value="1" <?php if(!empty($pusatTemuduga_kod)){  if($rs->fields['status'] == 1){ print 'selected';} } ?>>Tidak Aktif</option>
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