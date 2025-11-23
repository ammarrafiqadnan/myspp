<script language="javascript">
function do_close(){
	reload = window.location; 
	window.location = reload;
}

function do_simpan(){
    var reg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
	var ic = $('#ic').val();
	var nama = $('#nama').val();
    var jawatan = $('#jawatan').val();
    var stesen_id = $('#stesen_id').val();
    var notel = $('#notel').val();
    var nohp = $('#nohp').val();
    var emel = $('#emel').val();
    var gred = $('#gred').val();

	//alert("dd");
    if(ic.trim() == '' ){
        alert('Sila masukkan maklumat No. Pengenalan.');
        $('#ic').focus(); return false;
	} else if(nama.trim() == '' ){
        alert('Sila masukkan maklumat nama.');
        $('#nama').focus(); return false;
	} else if(gred.trim() == '' ){
        alert('Sila masukkan maklumat gred jawatan.');
        $('#gred').focus(); return false;
	} else if(jawatan.trim() == '' ){
        alert('Sila masukkan maklumat jawatan.');
        $('#jawatan').focus(); return false;
	} else if(notel.trim() == '' ){
        alert('Sila masukkan maklumat no. telefon.');
        $('#notel').focus(); return false;
	} else if(nohp.trim() == '' ){
        alert('Sila masukkan maklumat no. telefon bimbit.');
        $('#nohp').focus(); return false;
	} else if(emel.trim() == '' ){
        alert('Sila masukkan maklumat emel.');
        $('#emel').focus(); return false;
	} else {
		$.ajax({
			url:'utiliti/profile_form_sql.php?pro=SAVE', //&datas='+datas,
			type:'POST',
			//dataType: 'json',
			beforeSend: function () {
				$('#simpan').attr("disabled","disabled");
				$('.dispmodal').css('opacity', '.5');
			},
			data: $("form").serialize(),
			//data: datas,
			success: function(data){
				//console.log(data);
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
include '../connection/common.php';
$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
if(empty($id)){ $title = 'Tambah Pengguna Sistem'; }
else { $title = 'Kemaskini Pengguna Sistem'; }
// $conn->debug=true;
$sql = "SELECT * FROM _tbl_users WHERE id=".tosql($id);
$rsData = $conn->query($sql);
?>
<div class="col-md-12">
<section class="panel panel-featured panel-featured-info">
    <header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
        <h6 class="panel-title"><font color="#000000" size="3"><b>Kemaskini Profile Pengguna</b></font></h6>
    </header>
    <div class="panel-body">
    
        <input type="hidden" name="id" value="<?=$rsData->fields['id'];?>">
        <div class="col-md-12">
            <?php if(!empty($id)){ ?>
            <div class="form-group">
            	<div class="row">
                <label class="col-sm-3 control-label">ID Pengguna : </label>
                <div class="col-sm-3">
                    <input type="text" name="username" id="username" class="form-control" placeholder="ID Pengguna" disabled="disabled" 
                    value="<?php print $rsData->fields['username'];?>">
                </div>
                </div>
            </div>
            <?php } ?>
            
            <div class="form-group">
            	<div class="row">
                <label class="col-sm-3 control-label"><font color="#FF0000">*</font>No Kad Pengenalan : </label>
                <div class="col-sm-3">
                    <input type="text" name="ic" id="ic" class="form-control" placeholder="No Kad Pengenalan" 
                    value="<?php print $rsData->fields['ic'];?>" maxlength="12" readonly="readonly"> 
                </div>
				</div>
            </div>
            
            <div class="form-group">
            	<div class="row">
                <label class="col-sm-3 control-label"><font color="#FF0000">*</font>Nama Penuh : </label>
                <div class="col-sm-8">
                    <input type="text" name="nama" id="nama" class="form-control" readonly="readonly" 
                    value="<?php print $rsData->fields['nama'];?>">
                </div>
				</div>
            </div>
 
            <div class="form-group">
            	<div class="row">
                <label class="col-sm-3 control-label"><font color="#FF0000">*</font>Jabatan : </label>
                <div class="col-sm-8">
                    <input type="text" name="nama" id="nama" class="form-control" readonly="readonly" 
                    value="<?php print dlookup("_ref_bahagian","bhg_nama","bhg_id=".tosql($rsData->fields['bahagian_id'])); //$rsData->fields['nama'];?>">
                </div>
				</div>
            </div>
 
            <div class="form-group">
            	<div class="row">
                <label class="col-sm-3 control-label"><font color="#FF0000">*</font> Gred Jawatan : </label>
                <div class="col-sm-8">
                    <input type="text" name="gred" id="gred" class="form-control" 
                    value="<?php print $rsData->fields['gred'];?>">
                </div>
				</div>
            </div> 

            <div class="form-group">
            	<div class="row">
                <label class="col-sm-3 control-label"><font color="#FF0000">*</font> Jawatan : </label>
                <div class="col-sm-8">
                    <input type="text" name="jawatan" id="jawatan" class="form-control" 
                    value="<?php print $rsData->fields['jawatan'];?>">
                </div>
				</div>
            </div> 
            
            <div class="form-group">
            	<div class="row">
                <label class="col-md-3 control-label"><font color="#FF0000">*</font> No Tel Pejabat :</label>
                <div class="col-md-6 control-label">
                    <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-fax"></i></span>
                        <input id="notel" name="notel" data-plugin-masked-input data-input-mask="" placeholder="(03) 123-1234" class="form-control"  
                        value="<?php print $rsData->fields['notel'];?>" required >
                    </div>
                </div>
				</div>
            </div>
            
            <div class="form-group">
            	<div class="row">
                <label class="col-md-3 control-label"><font color="#FF0000">*</font> No Tel Bimbit :</label>
                <div class="col-md-6 control-label">
                    <div class="input-group">
                    <span class="input-group-addon"><i class="fa  fa-phone"></i></span>
                        <input id="nohp" name="nohp" data-plugin-masked-input data-input-mask="" placeholder="(013) 123-1234" class="form-control" 
                        value="<?php print $rsData->fields['nohp'];?>" required >
                    </div>
				</div>
                </div>
            </div>
            
            <div class="form-group">
            	<div class="row">
                <label class="col-md-3 control-label"><font color="#FF0000">*</font> E-mel:</label>
                <div class="col-md-6 control-label">
                    <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                        <input id="emel" name="emel" data-plugin-masked-input data-input-mask="" placeholder="abc@gmail.com" class="form-control" 
                        value="<?php print $rsData->fields['emel'];?>">
                    </div>
				</div>
                </div>
            </div> 
            
            
            <div class="form-group">
                <label class="col-md-3 control-label"></label>
                <div class="col-sm-8">
                    <button type="button" class="mt-sm mb-sm btn btn-success" onclick="do_simpan()" id="simpan">
                    	<i class="fa fa-save"></i> Simpan</button>
                    <button type="button" class="btn btn-default" onclick="do_close()"><i class="fa fa-spinner"></i> Kembali</button>
                </div>
                </div> 
            </div>
							 
		 
          </div>
     
</section>

</div> 