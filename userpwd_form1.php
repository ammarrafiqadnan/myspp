<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">

<script language="javascript">
function do_close(){
	reload = window.location; 
	window.location = reload;
}
function contains(password, allowedChars) {
 
    for (i = 0; i < password.length; i++) {
        var char = password.charAt(i);
        if (allowedChars.indexOf(char) >= 0) { return true; }
    }
     return false;
}

function do_simpan(){
    var reg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
	var password1 = $('#password1').val();
	var password2 = $('#password2').val();

     var uppercase = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
     var lowercase = "abcdefghijklmnopqrstuvwxyz";
     var digits = "0123456789";
     var splChars ="!@#$%&*()";
     var ucaseFlag = contains(password1, uppercase);
     var lcaseFlag = contains(password1, lowercase);
     var digitsFlag = contains(password1, digits);
     var splCharsFlag = contains(password1, splChars);

	//alert("dd");
    if(password1.trim() == '' ){
		alert('Sila masukkan maklumat kata laluan baru anda');
		$('#password1').focus(); return false;
	} else if(password2.trim() == '' ){
        alert('Sila ulang kata laluan baru anda.');
        $('#password2').focus(); return false;
	} else if(password1.trim() != password2.trim()){
        alert('Kata laluan anda tidak sama. Sila isi maklumat katalaluan semula.');
        $('#password2').focus(); return false;
	} else {
		if(password1.length <= 7){
			alert('Kata laluan anda terlalu pendek, perlu lebih 8 aksara');
			$('#password1').focus(); return false;
		} else {
			
			if(password1.length>=8 && ucaseFlag && lcaseFlag && digitsFlag && splCharsFlag){

				$.ajax({
					url:'userpwd_form_sql.php?pro=SAVE', //&datas='+datas,
					type:'POST',
					//dataType: 'json',
					// beforeSend: function () {
					// 	$('#simpan').attr("disabled","disabled");
					// 	$('.dispmodal').css('opacity', '.5');
					// },
					data: $("form").serialize(),
					//data: datas,
					success: function(data){
						console.log(data);
						//alert(data);
						if(data=='OK'){
							swal({
							  title: 'Berjaya',
							  text: 'Maklumat telah berjaya dikemaskini',
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
					}
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
}

</script>
<?php
include 'connection/common.php';
?>
<div class="col-md-12">
    <div class="panel-body">
    
        <input type="hidden" name="id" value="<?=$rsData->fields['id'];?>">
        <div class="col-md-12">
            
            <div class="form-group">
            	<div class="row">
                <label class="col-sm-3 control-label" style="color: #000;"><font color="#FF0000">*</font>No Kad Pengenalan: </label>
                <div class="col-sm-3">
                    <input type="text" name="noKP" id="noKP" class="form-control" placeholder="" 
                    value="" maxlength="12"> 
                </div>
				</div>
            </div><br>
 
			<div class="form-group">
            	<div class="row">
                <label class="col-sm-3 control-label" style="color: #000;"><font color="#FF0000">*</font>Alamat Emel : </label>
                <div class="col-sm-8">
                    <input type="email" name="email" id="email" class="form-control" 
                    value="">
                </div>
				</div>
            </div><br>

            <div class="form-group">
            	<div class="row">
                <label class="col-md-3 control-label" style="color: #000;"><font color="#FF0000">*</font> Katalaluan Baru :</label>
                <div class="col-md-4 control-label">
	                <input id="password1" name="password1" type="password" class="form-control" value="" required maxlength="15" >
                </div>
				</div>
            </div><br>
            
            <div class="form-group">
            	<div class="row">
                <label class="col-md-3 control-label" style="color: #000;"><font color="#FF0000">*</font> Ulang Katalaluan Baru :</label>
                <div class="col-md-4 control-label">
                    <input id="password2" name="password2" type="password" class="form-control" value="" required >
				</div>
                </div>
            </div><br>
            
            
            <div class="form-group">
                <label class="col-md-3 control-label"></label>
                <div class="col-sm-8" align="right">
                    <button type="button" class="mt-sm mb-sm btn btn-primary" onclick="do_simpan()" id="simpan">
                    	<i class="fa fa-save"></i> Simpan</button>
                    <button type="button" class="btn btn-outline-info " onclick="do_close()"><i class="fa fa-spinner"></i> Kembali</button>
                </div>
                </div> 
            </div>
							 
		 
          </div>
</div> 
<script language="javascript">
$('#password1').focus(); 
</script>	

<script>
    $('#password1').PassRequirements({
        /*rules: {
            containSpecialChars: {
                text: "Your input should contain at least minLength special character(s)",
                minLength: 1,
                regex: new RegExp('([^!,%,&,@,#,$,^,*,?,_,~])', 'g')
            },
            containNumbers: {
                text: "Your input should contain at least minLength number(s)",
                minLength: 2,
                regex: new RegExp('[^0-9]', 'g')
            }
        }*/
    });
</script>

<script>
    function do_close(){
        reload = window.location; 
        window.location = reload;
    }
</script>
<script src="include/PassRequirements.js"></script>
