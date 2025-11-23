<?php include '../../connection/common.php'; ?>
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
    var isuagama_nama = $('#isuagama_nama').val();
	
    if(isuagama_nama.trim() == '' ){
        alert('Sila masukkan nama isuagama.');
        $('#isuagama_nama').focus(); return false;
    } else {
        $.ajax({
            url:'utiliti/isuagama_form_sql.php?pro=SAVE',
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

</script>
<div class="col-lg-12">
<section class="panel">
    <header class="panel-heading"  style="background-color:rgb(209 29 29)">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="do_close()">×</button>
        <h6 class="panel-title"><font color="#000000" size="3"><b>MAKLUMAT LUPA KATA LALUAN PENGGUNA</b></font></h6>
    </header>
    <div class="panel-body">
        <div class="box-body">
        
            <input type="hidden" name="isuagama_id" id="isuagama_id" value="<?php print $rsk->fields['isuagama_id'];?>" readonly="readonly"/>
    
            <div class="col-md-12">
            

            <div class="form-group">
              <div class="row">
                <label for="agensi_nama" class="col-sm-4 control-label">No. Kad Pengenalan : </label>
                <div class="col-sm-8">
                    <input type="text" name="nokp" id="nokp" class="form-control" maxlength="12" />
                </div>
              </div>
            </div>

            <div class="form-group">
              <div class="row">
                <label for="agensi_nama" class="col-sm-4 control-label">Emel : </label>
                <div class="col-sm-8">
                    <input type="text" name="nokp" id="nokp" class="form-control" maxlength="12" />
                </div>
              </div>
            </div>
    
            <div class="modal-footer" style="padding:0px;">
                <button type="button" class="mt-sm mb-sm btn btn-primary" onclick="do_save()"><i class="fa fa-save"></i> Hantar</button>
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
document.myspp.nokp.focus();
</script>		 
