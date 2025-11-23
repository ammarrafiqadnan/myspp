<script language="javascript">
function rep_val(vals){
	var val='';
	val = vals.replace("&", "@@");
	return val;
}

function do_save(){
    var reg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
    var setup_id = $('#setup_id').val();
    var setup_name = rep_val($('#setup_name').val());
    // var mymonitor_startdt = rep_val($('#mymonitor_startdt').val());
	// var mymonitor_enddt = rep_val($('#mymonitor_enddt').val());
	
    if(setup_name.trim() == '' ){
        alert('Sila masukkan maklumat tajuk sistem.');
        $('#setup_name').focus();
        return false;
    
    } else {

		//var fd = new FormData();
    	//var files = $('#uploadfile')[0].files[0];
    	//fd.append('uploadfile',files);
	
        $.ajax({
            url:'utiliti/setup_sql.php?pro=SAVE',
            type:'POST',
            //dataType: 'json',
		    //contentType: false,
            //cache: false,
   			//processData:false,
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
<?php
$sql = "SELECT * FROM tbl_setup WHERE setup_id=1";
$rsk = $conn->query($sql);
?>
<div class="col-lg-12">
<section class="panel">
    <header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
        <h6 class="panel-title"><font color="#000000" size="3"><b>MAKLUMAT SISTEM</b></font></h6>
    </header>
    <div class="panel-body">
        <div class="box-body">
        
            <div class="col-md-12">
            
            <div class="form-group">
              <div class="row">
                <label for="agensi_id" class="col-sm-3 control-label"><b>SISTEM ID: </b></label>
                <div class="col-sm-2">
                    <input type="text" name="setup_id" id="setup_id" class="form-control" 
                        value="<?php print $rsk->fields['setup_id'];?>" readonly="readonly"/>
                </div>
              </div>
            </div>
    
    
            <div class="form-group">
              <div class="row">
                <label for="agensi_nama" class="col-sm-3 control-label"><b>NAMA SISTEM : </b></label>
                <div class="col-sm-9">
                    <input type="text" name="setup_name" id="setup_name" class="form-control" value="<?php print $rsk->fields['setup_name'];?>" />
                </div>
              </div>
            </div>
        
            <div class="form-group">
              <div class="row">
                <label for="agensi_nama" class="col-sm-3 control-label"><b>NAMA TIMBALAN PENGARAH (OPERASI) : </b></label>
                <div class="col-sm-9">
                    <input type="text" name="nama_tpo" id="nama_tpo" class="form-control" value="<?php print $rsk->fields['nama_tpo'];?>" />
                </div>
              </div>
            </div>
        
            <div class="form-group">
              <div class="row">
                <label for="agensi_nama" class="col-sm-3 control-label"><b>NAMA PENGARAH : </b></label>
                <div class="col-sm-9">
                    <input type="text" name="nama_pengarah" id="nama_pengarah" class="form-control" value="<?php print $rsk->fields['nama_pengarah'];?>" />
                </div>
              </div>
            </div>
        
            <!-- <div class="form-group">
              <div class="row">
                <label for="agensi_shoty" class="col-sm-3 control-label"><b>Tarikh Kemaskini Data : </b></label>
                <div class="col-sm-3">
                    <input type="date" name="setup_startdt" id="setup_startdt" class="form-control" 
                    style="height:50px" value="<?php print $rsk->fields['setup_startdt'];?>" />
                </div>
                <label for="agensi_shoty" class="col-sm-1 control-label"><b>Hingga</b></label>
                <div class="col-sm-3">
                    <input type="date" name="update_dt" id="update_dt" class="form-control" 
                    style="height:50px" value="<?php print $rsk->fields['update_dt'];?>" />
                </div>
              </div>
            </div> -->
            
    
            <div class="modal-footer" style="padding:0px;">
                <button type="button" class="mt-sm mb-sm btn btn-primary" onclick="do_save()"><i class="fa fa-save"></i> Simpan</button>
                &nbsp;
                <!--<?php if(!empty($ids)){ ?>
                <input type="button" value="Hapus" onclick="do_del('<?//=$id;?>')" class="btn btn-danger"/>&nbsp;
                <?php } ?>-->
                <!-- <button type="button" class="btn btn-default" onclick="do_close()"><i class="fa fa-spinner" style="margin:0px;"></i> Kembali</button> -->
                <input type="hidden" name="proses" value="<?php print $proses;?>" />
            </div>
        </div>
		</div>
  </div>
     
</section>

</div> 
