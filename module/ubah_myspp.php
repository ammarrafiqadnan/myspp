<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<style>
.css-tooltip{
  position: relative;
  
}
.css-tooltip:hover:after{
  content:attr(data-tooltip);
  background:#000;
  padding:5px;
  border-radius:3px; 
  display: inline-block;
  position: absolute;
  transform: translate(-50%,-100%); 
  margin:0 auto;
  color:#FFF;
  min-width:500px;
  min-width:450px;
  top:-5px;
  left: 50%;
  text-align:left;
white-space: pre-line;
}
.css-tooltip:hover:before {
  top:-5px;
  left: 50%;
  border: solid transparent;
  content: " ";
  height: 0;
  width: 0;
  position: absolute;
  pointer-events: none;
  border-color: rgba(0, 0, 0, 0);
  border-top-color: #000;
  border-width: 5px;
  margin-left: -5px;
       transform: translate(0,0px); 
white-space: pre-line;
}

.hover {
    position:relative;
    top:50px;
    left:50px;
}

.tooltip {
  top:-10px;
  background-color:blue;
  color:white;
  border-radius:5px;
  opacity:0;
  position:absolute;
  -webkit-transition: opacity 0.5s;
  -moz-transition:  opacity 0.5s;
  -ms-transition: opacity 0.5s;
  -o-transition:  opacity 0.5s;
  transition:  opacity 0.5s;
}

.hover:hover .tooltip {
    opacity:1;
}
</style>
<script>
function contains(password, allowedChars) {
 
    for (i = 0; i < password.length; i++) {
        var char = password.charAt(i);
        if (allowedChars.indexOf(char) >= 0) { return true; }
    }
     return false;
}
function do_register1(URL){
    var reg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
    var emel = $('#emel').val();
    var ICNo = $('#ICNo').val();
    var nama = $('#nama').val();
    var notel = $('#notel').val();
    var pass1 = $('#pass1').val();
    var pass2 = $('#pass2').val();
    var keselamatan = $('#keselamatan_daftar').val();
    var NONO = $('#NONO').val();
    var msg = '';

     var uppercase = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
     var lowercase = "abcdefghijklmnopqrstuvwxyz";
     var digits = "0123456789";
     var splChars ="!@#$%&*()";
     var ucaseFlag = contains(pass1, uppercase);
     var lcaseFlag = contains(pass1, lowercase);
     var digitsFlag = contains(pass1, digits);
     var splCharsFlag = contains(pass1, splChars);

    //alert("dd");
    //if(emel.trim() == '' ){
       // msg = msg+'- Sila masukkan alamat e-mel anda.';
        //$("#emel").css("border-color","#f00");
    //} 
    //if(ICNo.trim() == '' ){
        //msg = msg+'\n- Sila masukkan maklumat No. Kad Pengenalan anda.';
        //$("#ICNo").css("border-color","#f00");
    //}
    //if(nama.trim() == '' ){
        //msg = msg+'\n- Sila masukkan maklumat nama anda.';
        //$("#nama").css("border-color","#f00");
    //}
    //if(notel.trim() == '' ){
        //msg = msg+'\n- Sila masukkan maklumat no. telefon bimbit anda.';
        //$("#notel").css("border-color","#f00");
    //} 
    if(pass1.trim() == '' ){
        msg = msg+'\n- Sila masukkan maklumat kata laluan.';
        $("#pass1").css("border-color","#f00");
    }
    if(pass2.trim() == '' ){
        msg = msg+'\n- Sila masukkan maklumat ulang kata laluan.';
        $("#pass2").css("border-color","#f00");
    }
    if(pass1!=pass2){
        msg = msg+'\n- Maklumat kata laluan tidak sama. Sila masukkan semula.';
        document.myspp.pass1.value='';
        document.myspp.pass2.value='';
        $("#pass1").css("border-color","#f00");
    }
    if(keselamatan.trim() == '' ){
        msg = msg+'\n- Sila masukkan maklumat kod keselamatan.';
        $("#keselamatan").css("border-color","#f00");
    } else {
        if(keselamatan!=NONO){
            msg = msg+'\n- Kod keselamatan yang dimasukkan tidak sepadan.';
            $("#keselamatan").css("border-color","#f00");
        }
    }
    if(pass1.length <= 7){
        msg = msg+'\n- Kata laluan anda terlalu pendek, perlu lebih 8 aksara.';
        $("#pass1").css("border-color","#f00");
    }

    // if(pass1.length <= 7){
    //     msg = msg+'\n- Kata laluan anda terlalu pendek, perlu lebih 8 aksara.';
    //     $('#pass1').focus(); return false;
    // } else {
    //     if(pass1.length>=8 && ucaseFlag && lcaseFlag && digitsFlag && splCharsFlag){
    //       msg = msg+'\n Kata laluan yang dimasukkan tidak menepati keperluan keselamatan sistem.'
    //       +'<br>- perlu lebih daripada 8 aksara'
    //       +'<br>- perlu mempunyai 1 aksara khas'
    //       +'<br>- perlu mempunyai 1 huruf kecil'
    //       +'<br>- perlu mempunyai 1 huruf besar'
    //       +'<br>- perlu mempunyai 1 nombor';
    //     }
    // }
    
    if(msg.trim() !=''){ 
        alert_msg_html(msg);
    } else { 
        // alert(pass1.length+":"+ucaseFlag+":"+lcaseFlag+":"+digitsFlag+":"+splCharsFlag);
        if(pass1.length>=8 && ucaseFlag && lcaseFlag && digitsFlag && splCharsFlag){
            var fd = new FormData();
            var other_data = $('form').serializeArray();
            $.each(other_data,function(key,input){
                fd.append(input.name,input.value);
            });

            $.ajax({
                url:URL,
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
                          text: 'Maklumat kata laluan baru anda telah berjaya dikemaskini.',
                          type: 'success',
                          confirmButtonClass: "btn-success",
                          confirmButtonText: "Ok",
                          showConfirmButton: true,
                        }).then(function () {
                            // reload = window.location; 
                            // window.location = reload;
                            window.location.href = "index.php";
                        });
                    } else if(data=='ERR'){
                        swal({
                          title: 'Amaran',
                          text: 'Terdapat ralat sistem.\nMaklumat lupa kata laluan tidak berjaya diproses.',
                          type: 'error',
                          confirmButtonClass: "btn-warning",
                          confirmButtonText: "Ok",
                          showConfirmButton: true,
                        });
                    } 
                }
                //data: datas
            });
        } else {
            swal({
              title: 'Amaran',
              html: 'Kata laluan yang dimasukkan tidak menepati keperluan keselamatan sistem.'
              +'<br>- perlu lebih daripada 8 aksara'
              +'<br>- perlu mempunyai 1 aksara khas'
              +'<br>- perlu mempunyai 1 huruf kecil'
              +'<br>- perlu mempunyai 1 huruf besar'
              +'<br>- perlu mempunyai 1 nombor',
              type: 'error',
              confirmButtonClass: "btn-warning",
              confirmButtonText: "Ok",
              showConfirmButton: true,
            });
        }
    }
}


</script>
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
//$conn->debug=true;
$currDate = date('Y-m-d');

$sql = "SELECT *, DATEDIFF(CURDATE(), tkh_lupa) AS date_difference, tkh_lupa FROM $schema2.myid WHERE `ICNo`=".tosql($submenu)." AND `emel`=".tosqln($module). " AND ic_ind='A'";
$rs = $conn->query($sql);

$dateLupa = $rs->fields['date_difference'];

//print $dateLupa;
if($dateLupa <= 3){
?>
<div class="col-md-12">
    <section class="bg-white big-banner panel panel-featured panel-featured-info" style="min-height: 630px;">
        
        <div class="container pt-5" style="opacity: 0.9;">
            
            <div class="card p-5 text-md-left">
                <h1 class="card-title text-center">LUPA KATA LALUAN</h1>

                <div class="modal-body">
                    <div class="col-md-12">    
                        <div class="form-group my-3">
                            <div class="row">
                                <label class="col-md-3"><b>Alamat E-mel : <font color="#f00">*</font></b></label>
                                <div class="col-md-9"><input type="text" name="emel" id="emel" class="form-control" value="<?=$module;?>" readonly></div>
                            </div>
                        </div>    

                        <div class="form-group my-3">
                            <div class="row">
                                <label class="col-md-3"><b>No. Kad Pengenalan : <font color="#f00">*</font></b></label>
                                <div class="col-md-4"><input type="text" id="ICNo" name="ICNo" class="form-control" maxlength="12" value="<?=strtoupper($submenu);?>" readonly>(contoh: 760910015001)</div>
                            </div>
                        </div>    
                        <div class="form-group my-3">
                            <div class="row">
                                <label class="col-md-3"><b>Nama Penuh : <font color="#f00">*</font></b></label>
                                <div class="col-md-9"><input type="text" id="nama" name="nama" class="form-control" value="<?=strtoupper($menu);?>" readonly>(seperti dalam kad pengenalan) </div>
                            </div>
                        </div>    
                        <!--<div class="form-group my-3">
                            <div class="row">
                                <label class="col-md-3"><b>Kata Laluan Baru : <font color="#f00">*</font></b>
					  <a class="css-tooltip" data-tooltip="Kata laluan yang dimasukkan perlu menepati keperluan keselamatan sistem seperti :
							- lebih daripada 8 hingga 12 
					  		- mempunyai 1 aksara khas (cth: @#.$) &#013;
				  		- mempunyai 1 huruf kecil &#013; 
				  		- mempunyai 1 huruf besar &#013; 
				  		- mempunyai 1 nombor &#013;
						">
     						<i class="fa fa-info-circle" aria-hidden="true" data-html="true"></i>
   					</a>
				</label>
                                <div class="col-md-4"><input type="password" id="pass1" name="pass1" class="form-control" value="" maxlength="15" required>
					<input type="checkbox" id="pwcheck" /> Lihat Kata Laluan</div>
				<div align="right">
                                    <input type="checkbox" id="pwcheck" /> Lihat Kata Laluan
                                </div>

			    </div>
                        </div> -->

			<div class="form-group my-3">
                            <div class="row">
                                <label class="col-md-3"><b>Kata Laluan Baru : <font color="#f00">*</font></b>
					<a class="css-tooltip" data-tooltip="Kata laluan yang dimasukkan perlu menepati keperluan keselamatan sistem seperti :
							- aksara 8 hingga 12 
					  		- mempunyai 1 aksara khas (cth: @#!&) &#013; 
				  		- mempunyai 1 huruf kecil &#013; 
				  		- mempunyai 1 huruf besar &#013; 
				  		- mempunyai 1 nombor &#013;
						">
     						<i class="fa fa-info-circle" aria-hidden="true" data-html="true"></i>
   					</a>

				</label>
                                <div class="col-md-4"><input type="password" id="pass1" name="pass1" class="form-control" value="" maxlength="12" required></div>	
				<div class="col-md-2" align="right">

                                    <input type="checkbox" id="pwcheck" /> Lihat Kata Laluan
                                </div>
                            </div>
                        </div>       
                        <!--<div class="form-group my-3">
                            <div class="row">
                                <label class="col-md-3"><b>Ulang Kata Laluan : <font color="#f00">*</font></b></label>
                                <div class="col-md-4"><input type="password" id="pass2" name="pass2" class="form-control" value="" maxlength="15" required></div>
                            </div>
                        </div>-->
			<div class="form-group my-3">
                            <div class="row">
                                <label class="col-md-3"><b>Ulang Kata Laluan : <font color="#f00">*</font></b>
					<a class="css-tooltip" data-tooltip="Kata laluan yang dimasukkan perlu menepati keperluan keselamatan sistem seperti :
							- aksara 8 hingga 12 
					  		- mempunyai 1 aksara khas (cth: @#!&) &#013; 
				  		- mempunyai 1 huruf kecil &#013; 
				  		- mempunyai 1 huruf besar &#013; 
				  		- mempunyai 1 nombor &#013;
						">
     						<i class="fa fa-info-circle" aria-hidden="true" data-html="true"></i>
   					</a>

				</label>
                                <div class="col-md-4"><input type="password" id="pass2" name="pass2" class="form-control" value="" maxlength="12" required></div>	
				<div class="col-md-2" align="right">

                                    <input type="checkbox" id="pwcheck2" /> Lihat Kata Laluan
                                </div>
                            </div>
                        </div>      
                        <div class="form-group my-3">
                            <div class="row">
                                <label class="col-md-3"><b>Captcha : <font color="#f00">*</font></b></label>
                                <div class="col-lg-4 col-sm-6">
                                    <div class="input-group input-group-icon">
                                        <input name="keselamatan_daftar" id="keselamatan_daftar" type="text" class="form-control input-lg" placeholder="Kod Keselamatan Sistem" maxlength="5" value="" />
                                    </div>
                                </div>
                                <div class="col-md-5 col-sm-6" align="center">
                                    <label style="text-decoration:line-through;font-size:22px" id="NONO1"><b><?=$uniq;?></b></label>
                                    <input type="hidden" class="form-control input-lg" name="NONO" id="NONO" style="text-decoration:line-through;" value="<?=$uniq;?>" />
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <!--Footer-->
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-outline-info btn-md" onclick="do_register1('module/daftar_proses.php?pro=RESET')">Hantar <i class="fas fa-save ml-1"></i></button>
                    <button type="button" class="btn btn-outline-info btn-md" onclick="do_page('index.php')">Tutup <i class="fas fa-times ml-1"></i></button>
                </div>
            </div>
            
        </div>
    </section>
    </div>
<?php } else { ?>
<div class="col-md-12">
    <section class="bg-white big-banner panel panel-featured panel-featured-info" style="min-height: 630px;">
        
        <div class="container pt-5" style="opacity: 0.9;">
            
            <div class="card p-5 text-md-left">
                <h1 class="card-title text-center">LUPA KATA LALUAN</h1>

                <div class="modal-body">
                    <div class="col-md-12" align="center">    
                        <div class="form-group my-3">
                            <div class="row">
                                <label class="col-md-12"><h5>Sila buat permohonan lupa katalaluan semula. Anda telah melebihi tempoh 3 hari.</h5></label>
				<label class="btn btn-block mb-2 btn-info" style="text-decoration: none;" onclick="open_lupa('#modalLupa')">Lupa Kata Laluan?</label>
                            </div>
                        </div> 
		    </div>
		</div> 
 	    </div>    
       </div>  
    </section>
 </div>  
<?php include 'module/forgot_password.php'; ?>


<?php } ?>
<script type="text/javascript">
    $(document).ready(function(){
        $("#pwcheck").click(function(){
            var x = document.getElementById("pass1");
            if ($("#pwcheck").is(":checked")) {
                if (x.type === "password") {
                    x.type = "text";
                } 
                // else {
                //     x.type = "password";
                // }
            } else {
                x.type = "password";
            }
        });

	
        $("#pwcheck2").click(function(){
            var xx = document.getElementById("pass2");
            if ($("#pwcheck2").is(":checked")) {
                if (xx.type === "password") {
                    xx.type = "text";
                } 
                // else {
                //     xx.type = "password";
                // }
            } else {
                xx.type = "password";
            }
        });

        
    });

	function open_lupa(vars){
    		$('#modalLupa').modal('show');
	};

</script>

<!-- <script src="include/PassRequirements.js"></script>
<script language="javascript">
$('#pass1').focus(); 
</script>   
<script>
    $('#pass1').PassRequirements({
    });
</script> -->
