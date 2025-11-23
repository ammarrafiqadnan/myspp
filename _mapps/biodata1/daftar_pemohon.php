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
<?php
function generateRandomString($length = 6) {
	$characters = '123456789abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
}
$uniq = substr(generateRandomString(),0,5);
?>
<div class="col-lg-12">
<section class="panel">
    <header class="panel-heading"  style="background-color:rgb(209 29 29)">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="do_close()">×</button>
        <h6 class="panel-title"><font color="#000000" size="3"><b>MAKLUMAT DAFTAR PEMOHON</b></font></h6>
    </header>
    <div class="panel-body">
        <div class="box-body">
        
            <input type="hidden" name="isuagama_id" id="isuagama_id" value="<?php print $rsk->fields['isuagama_id'];?>" readonly="readonly"/>
    
            

            <div class="form-group">
              <div class="row">

                <div class="col-sm-6">
                	<label for="agensi_nama" class="control-label">No. Kad Pengenalan (contoh: 760910015001)</label>
                    <input type="text" name="nokp" id="nokp" class="form-control" maxlength="12" />
                </div>

                <div class="col-sm-6">
                	<label for="agensi_nama" class="control-label">Nama Penuh (seperti dalam kad pengenalan)</label>
                    <input type="text" name="nokp" id="nokp" class="form-control" maxlength="12" />
                </div>

              </div>
            </div>

            <div class="form-group">
              <div class="row">

                <div class="col-sm-6">
                	<label for="agensi_nama" class="control-label">No. Telefon Bimbit</label>
                    <input type="text" name="nokp" id="nokp" class="form-control" maxlength="12" />
                </div>

                <div class="col-sm-6">
                	<label for="agensi_nama" class="control-label">Alamat E-mel</label>
                    <input type="text" name="nokp" id="nokp" class="form-control" maxlength="12" />
                </div>

              </div>
            </div>

            <div class="form-group">
              <div class="row">
              	<div class="col-sm-12"><b>Soalan Keselamatan (untuk tujuan reset kata laluan)</b></div>
                <div class="col-sm-6">
                	<label for="agensi_nama" class="control-label">Siapakah Nama Ibu (First Name) Pemohon?</label>
                    <input type="text" name="nokp" id="nokp" class="form-control" maxlength="12" />
                </div>

                <div class="col-sm-6">
                	<label for="agensi_nama" class="control-label">Sahkan Nama Ibu (First Name) Pemohon?</label>
                    <input type="text" name="nokp" id="nokp" class="form-control" maxlength="12" />
                </div>

              </div>
            </div>

            <div class="form-group">
              <div class="row">

                <div class="col-sm-6">
                	<label for="agensi_nama" class="control-label">Di manakah Negeri Kelahiran Pemohon?</label>
                    <input type="text" name="nokp" id="nokp" class="form-control" maxlength="12" />
                </div>

                <div class="col-sm-6">
                	<label for="agensi_nama" class="control-label">Sahkan Negeri Kelahiran Pemohon?</label>
                    <input type="text" name="nokp" id="nokp" class="form-control" maxlength="12" />
                </div>

              </div>
            </div>

            <div class="form-group">
              <div class="row">
              	<div class="col-sm-12"><b>Maklumat Kata Laluan</b></div>
                <div class="col-sm-6">
                	<label for="agensi_nama" class="control-label">Masukkan Kata Laluan</label>
                    <input type="text" name="nokp" id="nokp" class="form-control" maxlength="12" />
                </div>

                <div class="col-sm-6">
                	<label for="agensi_nama" class="control-label">Masukkan Kata Laluan</label>
                    <input type="text" name="nokp" id="nokp" class="form-control" maxlength="12" />
                </div>

              </div>
            </div>

            <div class="form-group">
              <div class="row">
              	<div class="col-sm-12"><b>Kod Keselamatan</b></div>
                <div class="col-sm-6">
                	<input name="keselamatan" id="keselamatan" type="text" class="form-control input-lg" maxlength="5" />
                </div>

                <div class="col-sm-6">
                	<label style="text-decoration:line-through;font-size:22px" id="NONO1"><b><?=$uniq;?></b></label>
                	<input type="hidden" class="form-control input-lg" name="NONO" id="NONO" style="text-decoration:line-through;" value="<?=$uniq;?>" />
                </div>

              </div>
            </div>  
    
            <div class="modal-footer" style="padding:0px;">
                <button type="button" class="mt-sm mb-sm btn btn-primary" onclick="do_save()"><i class="fa fa-save"></i> Daftar</button>
                &nbsp;
                <button type="button" class="btn btn-default" onclick="do_close()" style="margin:0px;"><i class="fa fa-spinner"></i> Kembali</button>
                <input type="hidden" name="proses" value="<?php print $proses;?>" />
            </div>

		</div>

  	</div>
     
</section>

</div> 
<script language="javascript" type="text/javascript">
document.myspp.nokp.focus();
</script>		 
