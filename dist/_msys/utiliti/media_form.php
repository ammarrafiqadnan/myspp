<?php include '../connection/common.php'; ?>
<script language="javascript">
function do_close(){
	reload = window.location; 
	window.location = reload;
}

function rep_val(vals){
	var val='';
	val = vals.replace("&", "@@");
	return val;
}

function do_save(){
    var reg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
    var medium_code = $('#medium_code').val();
    var medium_name = $('#medium_name').val();
	
    if(medium_code.trim() == '' ){
        alert('Sila masukkan kod medium media.');
        $('#medium_code').focus(); return false;
    } else if(medium_name.trim() == '' ){
        alert('Sila masukkan maklumat medium media.');
        $('#medium_name').focus(); return false;
    } else {
        $.ajax({
            url:'utiliti/media_form_sql.php?pro=SAVE',
			type:'POST',
            //dataType: 'json',
            beforeSend: function () {
                //$('.btn-primary').attr("disabled","disabled");
                //$('.modal-body').css('opacity', '.5');
            },
			data: $("form").serialize(),
			//data: datas,
			success: function(data){
				console.log(data);
				//alert(data);
				if(data=='OK'){
					swal({
					  title: 'Berjaya',
					  text: 'Maklumat telah berjaya disimpan',
					  type: 'success',
					  confirmButtonClass: "btn-success",
					  confirmButtonText: "Ok",
					  showConfirmButton: true,
					}).then(function () {
						reload = window.location; 
						window.location = reload;
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
				//window.location.reload();

			},
			//data: datas
        });
    }
}

function do_del(id){
	swal({
		title: 'Adakah anda pasti untuk menghapuskan data ini?',
		//text: "You won't be able to revert this!",
		type: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Ya, Teruskan',
		cancelButtonText: 'Tidak, Batal!',
		reverseButtons: true
	}).then(function(e) {
		e.preventDefault();
		$.ajax({
			url:'utiliti/media_form_sql.php?pro=DEL&agid='+id, //&datas='+datas,
			type:'POST',
			//dataType: 'json',
			beforeSend: function () {
				$('.btn-primary').attr("disabled","disabled");
				$('.modal-body').css('opacity', '.5');
			},
			data: $("form").serialize(),
			//data: datas,
			success: function(data){
				console.log(data);
				//alert(data);
				if(data=='OK'){
					swal({
					  title: 'Berjaya',
					  text: 'Maklumat telah berjaya dihapuskan',
					  type: 'success',
					  confirmButtonClass: "btn-success",
					  confirmButtonText: "Ok",
					  showConfirmButton: true,
					}).then(function () {
						reload = window.location; 
						window.location = reload;
					});
				} else if(data=='ERR'){
					swal({
					  title: 'Amaran',
					  text: 'Terdapat ralat sistem.\nMaklumat anda tidak berjaya dihapuskan.',
					  type: 'error',
					  confirmButtonClass: "btn-warning",
					  confirmButtonText: "Ok",
					  showConfirmButton: true,
					});
				}
			}
			//data: datas
		});
	});		
}

</script>
<?php
$ids=isset($_REQUEST["ids"])?$_REQUEST["ids"]:"";
//print "ID:".$ids;
$sql = "SELECT * FROM `_ref_medium_media` WHERE `medium_id`=".tosql($ids);
$rsk = $conn->query($sql);
?>
<div class="col-lg-12">
<section class="panel">
    <header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="do_close()">×</button>
        <h6 class="panel-title"><font color="#000000" size="3"><b>MAKLUMAT RUJUKAN MEDIUM MEDIA</b></font></h6>
    </header>
    <div class="panel-body">
        <div class="box-body">
        
            <input type="hidden" name="medium_id" id="medium_id" value="<?php print $rsk->fields['medium_id'];?>" readonly="readonly"/>
    
            <div class="col-md-11">
            

            <div class="form-group">
              <div class="row">
                <label for="agensi_nama" class="col-sm-3 control-label">MAKLUMAT RUJUKAN : </label>
                <div class="col-sm-9">
                    <input type="text" name="medium_name" id="medium_name" class="form-control" value="<?php print $rsk->fields['medium_name'];?>" />
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <label for="agensi_nama" class="col-sm-3 control-label">MAKLUMAT RUJUKAN KOD : </label>
                <div class="col-sm-9">
                    <input type="text" name="medium_code" id="medium_code" class="form-control" value="<?php print $rsk->fields['medium_code'];?>" />
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="row">
                <label for="agensi_status" class="col-sm-3 control-label">STATUS : </label>
                <div class="col-sm-6">
                    <select class="form-control" name="medium_status" id="medium_status" required="required">
                        <option value="0"<?php if($rsk->fields['medium_status']==0){ print 'selected';}?>>Rekod Aktif</option>
                        <option value="1"<?php if($rsk->fields['medium_status']==1){ print 'selected';}?>>Rekod Tidak Aktif</option>
                    </select>
                </div>
               </div>
            </div>

    
            <div class="modal-footer" style="padding:0px;">
                <button type="button" class="mt-sm mb-sm btn btn-primary" onclick="do_save()"><i class="fa fa-save"></i> Simpan</button>
                &nbsp;
                <!--<?php if(!empty($ids)){ ?>
                <input type="button" value="Hapus" onclick="do_del('<?=$id;?>')" class="btn btn-danger"/>&nbsp;
                <?php } ?>-->
                <button type="button" class="btn btn-default" onclick="do_close()" style="margin:0px;"><i class="fa fa-spinner"></i> Kembali</button>
                <input type="hidden" name="proses" value="<?php print $proses;?>" />
            </div>
        </div>
		</div>
  </div>
     
</section>

</div> 
<script language="javascript" type="text/javascript">
document.frm.akhbar_nama.focus();
</script>		 
