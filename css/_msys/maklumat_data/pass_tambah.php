<?php include '../connection/common.php'; ?>
<script language="javascript">
function do_close(){
	reload = window.location; 
	window.location = reload;	
}
function do_save(){
    var reg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
    var no_id = $('#no_id').val();
	
    if(no_id.trim() == '' ){
        alert('Sila masukkan nombor pengenalan diri pemegang pas.');
        $('#no_id').focus(); return false;
    } else {
        $.ajax({
            url:'maklumat_data/sql_maklumat_data.php?frm=PASS_ADD',
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
				// alert(data);
				myArray = data.split(":");
				var dat = myArray[0];
				var href = myArray[1];
				// alert(myArray[1]);
				if(dat=='OK'){
					swal({
					  title: 'Berjaya',
					  text: 'Maklumat telah ada dalam sistem. Sila kemaskini maklumat jika berkenaan',
					  type: 'success',
					  confirmButtonClass: "btn-success",
					  confirmButtonText: "Ok",
					  showConfirmButton: true,
					}).then(function () {
						// reload = window.location; 
						// window.location = reload;
						window.location.href = href;
					});
				} else if(dat=='ERR'){
					swal({
					  title: 'Berjaya',
					  text: 'Maklumat baru telah berjaya disimpan. Sila lengkapkan pendaftaran maklumat ini',
					  type: 'success',
					  confirmButtonClass: "btn-success",
					  confirmButtonText: "Ok",
					  showConfirmButton: true,
					}).then(function () {
						// reload = window.location; 
						// window.location = reload;
						window.location.href = href;
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
    <header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="do_close()">×</button>
        <h6 class="panel-title"><font color="#000000" size="3"><b>TAMBAH MAKLUMAT PEMEGANG KAD TAULIAH</b></font></h6>
    </header>
    <div class="panel-body">
        <div class="box-body">
        
            <div class="col-md-12">
            

            <div class="form-group">
              <div class="row">
                <label for="agensi_nama" class="col-sm-3 control-label"><b>NO. PENGENALAN DIRI : </b></label>
                <div class="col-sm-4">
                    <input type="text" name="no_id" id="no_id" class="form-control" />
                </div>
              </div>
            </div>

    
            <div class="modal-footer" style="padding:0px;">
                <button type="button" class="mt-sm mb-sm btn btn-primary" onclick="do_save()"><i class="fa fa-save"></i> Tambah</button>
                &nbsp;
                <button type="button" class="btn btn-default" onclick="do_close()" style="margin:0px;"><i class="fa fa-spinner"></i> Kembali</button>
                <input type="hidden" name="proses" value="<?php print $proses;?>" />
            </div>
        </div>
		</div>
  </div>
     
</section>

</div> 
<script language="javascript" type="text/javascript">
document.jawi.no_id.focus();
</script>		 
