<script>
function do_semaks(nokp){
	$.ajax({
        url:'include/get_kp.php?nokp='+nokp,
	type:'POST',
        dataType: 'json',
        // beforeSend: function () {
            //$('.btn-primary').attr("disabled","disabled");
            //$('.modal-body').css('opacity', '.5');
        // },
		data: $("form").serialize(),
		contentType: false,
            	cache: false,
            	processData:false,
		success: function(data){
			console.log(data);
			//alert(data);
			if(data=='ADA'){
				swal({
					title: 'Makluman',
					text: 'Bagi pemohon jawatan Pegawai Perkhidmatan Pendidikan (PPP) Gred DG41'+ 
					'yang telah mendaftar jawatan sebelum atau pada 21 April 2023, tidak perlu mendaftar akaun baharu sehingga diberitahu kelak.',
					type: 'info',
					confirmButtonClass: "btn-info",
					confirmButtonText: "Ok",
					showConfirmButton: true,
				}).then(function () {
					document.getElementById("HANTAR").disabled = true;
					$('.form-control').attr("disabled","disabled");
				});
			} else if(data=='SEMULA'){
				swal({
					title: 'Makluman',
					text: 'Anda perlu membuat pendaftaran akaun baharu semula.',
					type: 'info',
					confirmButtonClass: "btn-info",
					confirmButtonText: "Ok",
					showConfirmButton: true,
				}).then(function () {
					document.getElementById("HANTAR").disabled = true;
					$('.form-control').attr("disabled","disabled");
				});
			}

		}
	});

}

function do_close(){
        reload = window.location; 
        window.location = reload;
    }


</script>
<?php
function generateRandomLupa($length = 6) {
    $characters = '123456789abcdefghjkmnpqrstuvwxyz';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
$uniq_lupa = substr(generateRandomLupa(),0,5);
?>
<!-- START Modal: Registration-->
<div class="modal fade static" id="modalLupa" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg static" role="document">
        <!--Content-->
        <div class="modal-content static" >
            <div class="modal-header static">
                <h4 class="modal-title" id="pengumuman">Lupa Kata Laluan</h4>
                <button type="button" class="btn btn-outline-info btn-md" onclick="do_close()"><i class="fas fa-times ml-1"></i></button>
            </div>

            <!--Body-->
            <div class="modal-body">
                <div class="col-md-12">    
                    <div class="form-group my-2">
                        <div class="row">
                            <label class="col-md-4"><b>No. Kad Pengenalan <font color="#f00">*</font> : </b></label>
                            <div class="col-md-8"><input type="text" name="ICNo" id="ICNo" onchange="do_semaks(this.value)" class="form-control" maxlength="12"><i>(contoh: 760910015001)</i></div>
                        </div>
                    </div>    
                    <div class="form-group my-2">
                        <div class="row">
                            <label class="col-md-4"><b>E-mel Pengguna <font color="#f00">*</font> : </b></label>
                            <div class="col-md-8"><input type="text" name="emel" id="emel" class="form-control"><i>(alamat e-mel peribadi yang telah didaftarkan)</i></div>
                        </div>
                    </div>
                </div>

                <div class="form-group my-2">
                    <div class="row">
                        <label class="col-md-4"><b>Captcha <font color="#f00">*</font> : </b></label>
                        <div class="col-lg-4 col-sm-6">
                            <div class="input-group input-group-icon">
                                <input name="keselamatan_lupa" id="keselamatan_lupa" type="text" class="form-control input-lg" placeholder="Kod Keselamatan Sistem" maxlength="5" value="" />
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4" align="center">
                            <label style="text-decoration:line-through;font-size:22px" id="NONO"><b><?=$uniq_lupa;?></b></label>
                            <input type="hidden" class="form-control input-lg" name="NONO2" id="NONO2" style="text-decoration:line-through;" 
                                value="<?=$uniq_lupa;?>" />
                        </div>
                    </div>
                </div>
            </div>
            <!--Footer-->
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-outline-info btn-md" onclick="do_lupa('module/daftar_proses.php?pro=LUPA')">Hantar <i class="fas fa-save ml-1"></i></button>
                <button type="button" class="btn btn-outline-info btn-md" onclick="do_close()">Tutup <i class="fas fa-times ml-1"></i></button>
            </div>

        </div>
        <!--/.Content-->
    </div>
</div>
<!--END Modal: Registration-->
</div>