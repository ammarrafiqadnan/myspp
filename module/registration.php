<script type="text/javascript">
//header("Access-Control-Allow-Origin: *");
//header("Access-Control-Allow-Credentials: true ");
//header("Access-Control-Allow-Methods: OPTIONS, GET, POST");
//header("Access-Control-Allow-Headers: Content-Type, Depth, User-Agent, X-File-Size, X-Requested-With, If-Modified-Since, X-File-Name, Cache-Control");

function do_semak(nokp){
	$.ajax({
        url:'include/get_block_kp.php?nokp='+nokp,
	type:'POST',
        dataType: 'json',
         	//beforeSend: function () {
            		//$('.btn-primary').attr("disabled","disabled"); 
			//$('.form-control').attr("disabled","disabled");
            		//$('.modal-body').css('opacity', '.5');
         	//},
		data: $("form").serialize(), 
		contentType: false,
            	cache: false,
            	processData:false,
		success: function(data){
			//console.log(data);
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
			} 
		}
	});

}
</script>
<!-- <link rel="stylesheet" type="text/css" href="scripts/styles.css"> -->

<!-- START Modal: Registration-->
<?php
function generateRandomString($length = 6) {
    $characters = '123456789abcdefghjkmnpqrstuvwxyz';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
$uniq = substr(generateRandomString(),0,5);
?>
<div class="modal fade static" id="modalReg" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg static" role="document">
        <!--Content-->
        <div class="modal-content static" >
            <div class="modal-header static">
                <h4 class="modal-title" id="pengumuman">Maklumat Pra Pendaftaran Baru Pemohon</h4>
                <button type="button" class="btn btn-outline-info btn-md" onclick="do_page('index.php')"><i class="fas fa-times ml-1"></i></button>
            </div>

            <!--Body-->
            <div class="modal-body">
                <div class="col-md-12">
		    <div class="form-group">
                        <div class="row" align="text-center">
                            <!--<div style="text-align: justify;">-->
                            Lengkapkan maklumat di bawah. Anda perlu melengkapkan pendaftaran dengan klik pada URL yang diberi pada emel, setelah butang Hantar ditekan. Sila semak Inbox/Spam emel anda.
                            <!--</div>-->
                        </div>
                    </div><br>
		    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4"><b>No Kad Pengenalan <font color="#f00">*</font><div style="float:right">:</div></b></label>
                            <div class="col-md-8"><input type="text" name="nokp_daftar" id="nokp_daftar" class="form-control" value="" maxlength="12" onChange="do_semak(this.value)">
				<small style="color: red;">Masukkan nombor kad pengenalan tanpa '-' (Contoh : xxxxxxXXxxxx)</small></div>
                        </div>
                    </div>  
		    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4"><b>Nama <font color="#f00">*</font><div style="float:right">:</div></b></label>
                            <div class="col-md-8"><input type="text" name="nama_daftar" id="nama_daftar" class="form-control text-uppercase" value=""><small style="color: red;">Nama pemohon seperti yang tertera di atas kad pengenalan</small></div>
                        </div>
                    </div>   
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4"><b>Alamat E-mel<font color="#f00">*</font><div style="float:right">:</div></b></label>
                            <div class="col-md-8"><input type="text" name="emel_daftar" id="emel_daftar" class="form-control" value="">
                            <small style="color: red;">Emel dibenarkan : gmail.com | yahoo.com | hotmail.com | ymail.com</small></div>
                        </div>
                    </div>    
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4"><b>Captcha<font color="#f00">*</font><div style="float:right">:</div></b></label>
                            <div class="col-lg-4 col-sm-6">
                                <div class="input-group input-group-icon">
                                    <input name="keselamatan_daftar" id="keselamatan_daftar" type="text" class="form-control input-lg" placeholder="Kod Keselamatan Sistem" maxlength="5" value="" />
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6" align="center">
                                <label style="text-decoration:line-through;font-size:22px" id="NONO1"><b><?=$uniq;?></b></label>
                                <input type="hidden" class="form-control input-lg" name="NONOD" id="NONOD" style="text-decoration:line-through;" value="<?=$uniq;?>" />
                            </div>
                        </div>
                    </div>    
                </div>


            </div>
            <!--Footer-->
            <div class="modal-footer justify-content-center">
                <button type="button" id="HANTAR" class="btn btn-primary btn-md" onclick="do_daftar('module/daftar_proses.php?pro=DAFTAR')">Hantar <i class="fas fa-save ml-1"></i></button>
                <button type="button" class="btn btn-outline-info btn-md" onclick="do_page('index.php')">Tutup <i class="fas fa-times ml-1"></i></button>
            </div>

        </div>
        <!--/.Content-->
    </div>
</div>
<!--END Modal: Registration-->

<!-- <script src="scripts/script.js"></script> -->
