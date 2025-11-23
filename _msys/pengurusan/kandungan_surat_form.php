<?php include '../../connection/common.php'; ?>
<!-- include summernote css/js-->
<link href="../assets/notes/summernote.css" rel="stylesheet">
<script src="../assets/notes/summernote.js"></script>

<script>
	// var quill = new Quill('#editor', {
	// theme: 'snow'
	// });
function do_close(){
        reload = window.location; 
        window.location = reload;
    }
	function do_save(){
		var jenis_surat = $('#jenis_surat').val();
		var tajuk = $('#tajuk').val();
		//var keterangan = $('#keterangan').val();
		var status2 = $('#status2').val();
		var id = $('#id').val();
		var html = $('#summernote1').summernote('code');
		
		// var html = quill.root.innerHTML;

		// // Copy HTML content in hidden form
		// var keterangan_detail = $('#keterangan_detail').val( html );

		//var myEditor = document.querySelector('#keterangan')
		//var keterangan_detail = myEditor.children[0].innerHTML
			
            
		// var formData = new FormData($('#jawi')[0]);

		var fd = new FormData();
		fd.append('jenis_surat',jenis_surat);
		fd.append('tajuk',tajuk);
		fd.append('keterangan',html);
		fd.append('status2',status2);
		fd.append('id',id);


		var other_data = $('form').serializeArray();
		$.each(other_data,function(key,input){
			fd.append(input.name,input.value);
		});

		if(jenis_surat.trim() == '' ){
			alert_msg('Sila sila pilih jenis surat.');
			$('#jenis_surat').focus(); return true;
		} else if(tajuk.trim() == '' ){
			alert_msg('Sila isi maklumat tajuk.');
			$('#tajuk').focus(); return true;
		} else if(status2.trim() == '' ){
			alert_msg('Sila pilih maklumat maklumat status.');
			$('#status2').focus(); return true;
		} else {
			$.ajax({
				url:'pengurusan/sql_pengurusan.php?frm=PENGURUSAN&jenis=KANDUNGAN_SURAT&pro=SAVE',
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
	
</script>
<?php
	// $conn->debug=true;
	$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
	$sql3 = "SELECT * FROM $schema2.`kandungan_surat` WHERE kod='{$id}'";
	$rs = $conn->query($sql3);
?>
<div class="col-lg-12">
	<section class="panel">
		<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="do_close()">×</button>
			<h6 class="panel-title"><font color="#000000" size="3"><b><?php if(!empty($id)){ print 'KEMASKINI'; } else { print 'TAMBAH'; } ?> MAKLUMAT SURAT</b></font></h6>
		</header>
		<div class="panel-body">
			<div class="box-body">

			<input type="hidden" name="id" id="id" value="<?php print $id;?>" readonly="readonly"/>

				<div class="col-md-12">
                    <div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>Jenis Surat <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-3">
                                <select name="jenis_surat" id="jenis_surat" class="form-control">
									<option value="">Sila pilih jenis surat</option>
									<option value="1" <?php if(!empty($id)){ if($rs->fields['jenis'] == 1){ print 'selected';}} ?>>Panggilan Temuduga</option>
                                    <option value="2" <?php if(!empty($id)){ if($rs->fields['jenis'] == 2){ print 'selected';}} ?>>Keputusan Temuduga</option>
                                    <!-- <option value="3" <?php if(!empty($id)){ if($rs->fields['jenis'] == 3){ print 'selected';}} ?>>Tawaran Jawatan</option> -->
								</select>
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
							<label for="tajuk" class="col-sm-2 control-label"><b>Keterangan : </b></label>
							<div class="col-sm-10">
								<div id="summernote1" class="col-lg-12"><?php if(!empty($id)){ print $rs->fields['keterangan']; }?></div>
							</div>
						</div>
					</div>

                    <div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>Status <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-4">
                                <select name="status2" id="status2" class="form-control">
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

<script type="text/javascript">
$(document).ready(function() {
  // $('#summernote1').summernote();
  $('#summernote1').summernote({
	 height: 350,   //set editable area's height
	  toolbar: [
	    // [groupName, [list of button]]
	    ['height', ['height']],
	    ['fontname', ['fontname']],
		['style', ['style']],
		['style', ['bold', 'italic', 'underline', 'clear']],
	    ['font', ['strikethrough', 'superscript', 'subscript']],
	    ['fontsize', ['fontsize']],
	    ['color', ['color']],
	    ['para', ['ul', 'ol', 'paragraph']],
	    ['table', ['table']],
		['insert', ['link', 'picture', 'video']],
		['view', ['fullscreen', 'codeview', 'help']],
	  ]
	});

});
</script>