<?php include '../../connection/common.php'; ?>

<script>
	$(document).ready(function () {
	    $('#myModal').on('show.bs.modal', function () {
	        $('#myModal-xl').css('z-index', 1039);

	    });

	    $('#myModal').on('hidden.bs.modal', function () {
	        $('#myModal-xl').css('z-index', 1041);
	        $('#myModal-xl').css('position', 'absolute');
	        $('#myModal-xl').css('height', 'fit-content');  


	    });
	});

	function do_save(){
		var jenis_hebahan = $('#jenis_hebahan').val();
		var tajuk = $('#tajuk').val();
		var keterangan = $('#keterangan').val();
		var tarikh_mula = $('#tarikh_mula').val();
		var tarikh_tamat = $('#tarikh_tamat').val();
		var status = $('#status').val();
		var id = $('#id').val();

            
		// var formData = new FormData($('#jawi')[0]);

		var fd = new FormData();
		var dokumen = $('#dokumen')[0].files[0];
		fd.append('dokumen',dokumen);
		fd.append('dokumen_ada',dokumen_ada);
		fd.append('jenis_hebahan',jenis_hebahan);
		fd.append('tajuk',tajuk);
		fd.append('keterangan',keterangan);
		fd.append('tarikh_mula',tarikh_mula);
		fd.append('tarikh_tamat',tarikh_tamat);
		fd.append('status',status);
		fd.append('id',id);


		var other_data = $('form').serializeArray();
		$.each(other_data,function(key,input){
			fd.append(input.name,input.value);
		});

		$.ajax({
			url:'pengurusan/sql_pengurusan.php?frm=PENGURUSAN&jenis=HEBAHAN_MAKLUMAN&pro=SAVE',
			type:'POST',
			//dataType: 'json',
			beforeSend: function () {
				// $('.btn-primary').attr("disabled","disabled");
				// $('.modal-body').css('opacity', '.5');
			},
			// data: $("form").serialize(),
			data:  fd,
			contentType: false,
			cache: false,
			processData:false,
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
</script>
<?php
	// $conn->debug=true;
	$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
	$jenis=isset($_REQUEST["jenis"])?$_REQUEST["jenis"]:"";

	$sql3 = "SELECT * FROM $schema2.`hebahan_makluman` WHERE kod='{$id}'";
	$rs = $conn->query($sql3);
?>
<div class="col-lg-12">
	<section class="panel">
		<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="do_close()">×</button>
			<h6 class="panel-title"><font color="#000000" size="3"><b>TAMBAH MAKLUMAT HEBAHAN</b></font></h6>
		</header>
		<div class="panel-body">
			<div class="box-body">

			<input type="hidden" name="id" id="id" value="<?php print $id;?>" readonly="readonly"/>

				<div class="col-md-12">
					<?php if($jenis == 'edit'){ ?>
                    <div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>Jenis Hebahan <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-3">
                                <select name="jenis_hebahan" id="jenis_hebahan" class="form-control" >
									<option value="">Sila pilih jenis hebahan</option>
									<option value="1" <?php if(!empty($id)){ if($rs->fields['jenis'] == 1){ print 'selected';}} ?>>Awam</option>
									<option value="2" <?php if(!empty($id)){ if($rs->fields['jenis'] == 2){ print 'selected';}} ?>>Dalaman</option>
								</select>
							</div>
						</div>
					</div>

                    <div class="form-group">
						<div class="row">
							<label for="tajuk" class="col-sm-2 control-label"><b>Tajuk <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10">
								<input type="text" name="tajuk" id="tajuk" class="form-control" value="<?php if(!empty($id)){ print $rs->fields['tajuk']; }?>" >
							</div>
						</div>
					</div>
					<?php } ?>
                    <div class="form-group">
						<div class="row">
							<label for="keterangan" class="col-sm-2 control-label"><b>Keterangan <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10">
								<textarea type="text" name="keterangan" id="keterangan" class="form-control" value="" <?php if($jenis == 'view'){ print 'readonly'; }?>><?php if(!empty($id)){ print $rs->fields['keterangan']; }?></textarea>
							</div>
						</div>
					</div>
					<?php if($jenis == 'edit'){ ?>
					<div class="form-group">
						<div class="row">
							<label for="tarikh_mula" class="col-sm-2 control-label"><b>Tarikh Mula <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-4">
								<input type="date" name="tarikh_mula" id="tarikh_mula" class="form-control" value="<?php if(!empty($id)){ print $rs->fields['tarikh_mula']; }?>" <?php if($jenis == 'view'){ print 'readonly'; }?>>
							</div>
							<label for="tarikh_tamat" class="col-sm-2 control-label"><b>Tarikh Tamat <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-4">
								<input type="date" name="tarikh_tamat" id="tarikh_tamat" class="form-control" value="<?php if(!empty($id)){ print $rs->fields['tarikh_tamat']; }?>" <?php if($jenis == 'view'){ print 'readonly'; }?>>
							</div>
						</div>
					</div>
					<?php } ?>
					
                    <div class="form-group">
						<div class="row">
							<?php if($jenis == 'edit'){ ?>

								<label for="nama" class="col-sm-2 control-label"><b>Status <font color="#FF0000">*</font> : </b></label>
								<div class="col-sm-4">
									<select name="status" id="status" class="form-control" <?php if($jenis == 'view'){ print 'readonly'; }?>>
										<option value="">Sila pilih status</option>
										<option value="0" <?php if(!empty($id)){ if($rs->fields['status'] == 0){ print 'selected';}} ?>>Aktif</option>
										<option value="1" <?php if(!empty($id)){ if($rs->fields['status'] == 1){ print 'selected';}} ?>>Tidak Aktif</option>
									</select>
								</div>
							<?php } ?>

							<label for="tajuk" class="col-sm-2 control-label"><b>Dokumen <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-3">
								<?php if($jenis == 'edit'){ ?>
								<input type="file" name="dokumen" id="dokumen" class="form-control" value="">
								<?php } ?>
								<input type="hidden" name="dokumen_ada" id="dokumen_ada" class="form-control" value="<?php print $rs->fields['dokumen']; ?>">
								

								<a href="../view_doc.php?doc=<?php if(!empty($id)){ print $rs->fields['dokumen'];}?>" data-toggle="modal" data-target="#myModal"><?php if(!empty($id)){ print $rs->fields['dokumen'];} ?></a>
							</div>
						</div>
					</div>
					
					<?php if($jenis == 'edit'){ ?>
					<div class="modal-footer" style="padding:0px;">
						<button type="button" class="btn btn-primary mt-sm mb-sm" onclick="do_save()"><i class="fa fa-save"></i> Simpan</button>
						&nbsp;
						<button type="button" class="btn btn-default" onclick="do_close()"><i class="fa fa-spinner" style="margin:0px;"></i> Kembali</button>
					</div>
					<?php } ?>
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