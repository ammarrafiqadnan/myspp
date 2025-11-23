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
		var status = $('#status').val();
		var id = $('#id').val();

            
		// var formData = new FormData($('#jawi')[0]);

		var fd = new FormData();
		fd.append('kod_noti',kod_noti);
		fd.append('tajuk',tajuk);
		fd.append('status',status);
		fd.append('id',id);


		var other_data = $('form').serializeArray();
		$.each(other_data,function(key,input){
			fd.append(input.name,input.value);
		});

		$.ajax({
			url:'pengurusan/sql_pengurusan.php?frm=PENGURUSAN&jenis=NOTIFIKASI&pro=SAVE',
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
	$sql3 = "SELECT * FROM $schema2.`kandungan_notifikasi` WHERE kod='{$id}'";
	$rs = $conn->query($sql3);
?>
<div class="col-lg-12">
	<section class="panel">
		<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="do_close()">×</button>
			<h6 class="panel-title"><font color="#000000" size="3"><b>TAMBAH MAKLUMAT NOTIFIKASI</b></font></h6>
		</header>
		<div class="panel-body">
			<div class="box-body">

			<input type="hidden" name="id" id="id" value="<?php print $id;?>" readonly="readonly"/>

				<div class="col-md-12">
                    

                    <div class="form-group">
						<div class="row">
							<label for="kod" class="col-sm-2 control-label"><b>Kod <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10">
								<input type="text" name="kod_noti" id="kod_noti" class="form-control" value="<?php if(!empty($id)){ print $rs->fields['kod_noti']; }?>">
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<div class="row">
							<label for="tajuk" class="col-sm-2 control-label"><b>Tajuk <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10">
								<input type="text" name="tajuk" id="tajuk" class="form-control" value="<?php if(!empty($id)){ print $rs->fields['tajuk']; }?>">
							</div>
						</div>
					</div>

                    <div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>Status <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-4">
                                <select name="status" id="status" class="form-control">
									<option value="">Sila pilih status</option>
									<option value="0" <?php if(!empty($id)){ if($rs->fields['status'] == 0){ print 'selected';}} ?>>Aktif</option>
									<option value="1" <?php if(!empty($id)){ if($rs->fields['status'] == 1){ print 'selected';}} ?>>Tidak Aktif</option>
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