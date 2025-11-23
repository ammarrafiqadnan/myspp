<script language="javascript">
function do_close(){
	reload = window.location; 
	window.location = reload;
}

function do_simpan(){
    var reg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
	var ic = $('#ic').val();
	var emel = $('#emel').val();

	//alert("dd");
    if(ic.trim() == '' ){
		alert('Sila masukkan maklumat No. Pengenalan anda');
		$('#ic').focus(); return false;
	} else if(emel.trim() == '' ){
        alert('Sila masukkan alamat emel anda.');
        $('#emel').focus(); return false;
	} else {
		$.ajax({
			url:'utiliti/userlupa_form_sql.php?pro=SAVE', //&datas='+datas,
			type:'POST',
			//dataType: 'json',
			/*beforeSend: function () {
				$('#simpan').attr("disabled","disabled");
				$('.dispmodal').css('opacity', '.5');
			},*/
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
    }
}

</script>
<div class="col-md-12">
<section class="panel panel-featured panel-featured-info">
    <header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
        <h6 class="panel-title"><font color="#000000" size="3"><b>Lupa Katalaluan Pengguna</b></font></h6>
    </header>
    <div class="panel-body">
    
        <div class="col-md-12">
            <div class="form-group">
            	<div class="row">
                <label class="col-sm-3 control-label"><font color="#FF0000">*</font>No Kad Pengenalan : </label>
                <div class="col-sm-3">
                    <input type="text" name="ic" id="ic" class="form-control" placeholder="No Kad Pengenalan" value="" maxlength="12"> 
                </div>
				</div>
            </div>
            
            <div class="form-group">
            	<div class="row">
                <label class="col-sm-3 control-label"><font color="#FF0000">*</font>Emel Kakitangan : </label>
                <div class="col-sm-8">
                    <input type="text" name="emel" id="emel" class="form-control" value="">
                </div>
				</div>
            </div>
 
            
            <div class="form-group">
                <label class="col-md-3 control-label"></label>
                <div class="col-sm-8">
                    <button type="button" class="mt-sm mb-sm btn btn-success" onclick="do_simpan()" id="simpan">
                    	<i class="fa fa-save"></i> Hantar</button>
                    <button type="button" class="btn btn-default" onclick="do_close()"><i class="fa fa-spinner"></i> Kembali</button>
                </div>
                </div> 
            </div>
							 
		 
          </div>
     
</section>
</div> 
<script language="javascript">
$('#password1').focus(); 
</script>	