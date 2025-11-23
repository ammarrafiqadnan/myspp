<?php 
session_start();
include '../connection/common.php';
//$conn->debug=true;
$_SESSION['page_name']="MUATNAIK GAMBAR";
$pemantauan_id=isset($_REQUEST["pemantauan_id"])?$_REQUEST["pemantauan_id"]:"";
$doc_id=isset($_REQUEST["doc_id"])?$_REQUEST["doc_id"]:"";
$type=isset($_REQUEST["type"])?$_REQUEST["type"]:"";
$rsData = $conn->query("SELECT * FROM appli_doc WHERE id=".tosql($doc_id));
?>
<script language="javascript">
function do_save(){
	var reg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
    var doc_id = $('#doc_id').val();
    var pemantauan_id = $('#pemantauan_id').val();
    // var title = $('#title').val();
    var type = $('#type').val();

	var fd = new FormData();
    var files = $('#file1')[0].files[0];
    fd.append('file1',files);

    // alert(files);

 //    if(title.trim() == '' ){
 //        alert_msg('Sila masukkan maklumat tajuk dokumen.');
 //        $('#title').focus(); return true;
	// } else {
    	$.ajax({ //+'&title='+title
            url:'maklumat/sql_maklumat.php?frm=UPLOAD_DOC&pro=SAVE&type='+type+'&pemantauan_id='+pemantauan_id,
			type:'POST',
            //dataType: 'json',
            beforeSend: function () {
                $('.btn-primary').attr("disabled","disabled");
                $('.modal-body').css('opacity', '.5');
            },
			data: $("form").serialize(),
			//data: datas,
			data: fd,
			contentType: false,
			processData: false,
			success: function(data){
				console.log(data);
				// alert(data);
				// display_msg(data);
				if(data=='OK'){
					swal({
					  title: 'Berjaya',
					  text: 'Maklumat telah berjaya disimpan',
					  type: 'success',
					  confirmButtonClass: "btn-success",
					  confirmButtonText: "Ok",
					  showConfirmButton: true,
					}).then(function () {
						// alert("rel");
						location.reload();
						// reload = window.location; 
						// window.location = reload;
					});
				} else if(data=='ERR'){
					swal({
					  title: 'Amaran',
					  text: 'Terdapat ralat sistem.\nMaklumat anda tidak berjaya dikemaskini.',
					  type: 'error',
					  confirmButtonClass: "btn-warning",
					  confirmButtonText: "Ok",
					  showConfirmButton: true,
					});
				}	
			},
			//data: datas
        });
    // }
}
</script>

<div class="modal-header bg-primary">
	<h5 class="modal-title"><i class="icon-pen"></i> Kemaskini Maklumat Lampiran Pemantauan</h5>
	<div style="float:right"><button type="button" class="close" data-dismiss="modal">&times;</button></div>
</div>
<input type="hidden" name="pemantauan_id" value="<?=$pemantauan_id;?>">
<input type="hidden" name="doc_id" value="<?=$doc_id;?>">
<input type="hidden" name="type" id="type" value="<?=$type;?>">
<div class="modal-body">
	<!-- <div class="form-group row">
		<label class="col-lg-2 control-label">Tajuk :</label>
		<div class="col-lg-10">
			<input type="text" name="title" id="title" class="form-control" placeholder="Maklumat kategori" value="<?=$rsData->fields['title'];?>" maxlength="128">
		</div>
	</div> -->
	<div class="form-group row">
		<label class="col-lg-2 control-label">Muat Naik Gambar :</label>
		<div class="col-lg-10">
			<input type="hidden" name="MAX_FILE_SIZE" value="10000000">
            <input type="hidden" name="action1" value="1">
            <input type="file" name="file1" id="file1" class="form-control">
            <!--<br />
            <input type="radio" name="img_baru" value="Y" />Muatnaik Imej Baru &nbsp;&nbsp;&nbsp;
            <input type="radio" name="img_baru" value="N" checked="checked" />Kekalkan imej-->
            <br />
            <?php if(!empty($rsData->fields['file_name'])){ 
           		print "<br>".$rsData->fields['file_name'];
             } ?>
		</div>
	</div>
</div>

<div class="modal-footer">
	<button type="button" class="btn btn-success btn-labeled btn-xlg" onclick="do_save()"><b><i class="icon-checkmark"></i></b> Simpan Maklumat</button>
	<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
</div>
