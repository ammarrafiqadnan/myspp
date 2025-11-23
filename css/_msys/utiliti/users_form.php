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
    var bahagian_id = $('#bahagian_id').val();
    var notel = $('#notel').val();
    var nohp = $('#nohp').val();
    var emel = $('#emel').val();
    var level = $('#level').val();
    var access = $('#access').val();
    //var Poskod = $('#Poskod').val();
    //var Negeri = $('#Negeri').val();

	//alert("dd");
    if(ic.trim() == '' ){
        alert('Sila masukkan maklumat No. Pengenalan.');
        $('#ic').focus(); return false;
	} else if(nama.trim() == '' ){
        alert('Sila masukkan maklumat nama.');
        $('#nama').focus(); return false;
	} else if(jawatan.trim() == '' ){
        alert('Sila masukkan maklumat jawatan.');
        $('#jawatan').focus(); return false;
	} else if(bahagian_id.trim() == '' ){
        alert('Sila pilih tempat bertugas.');
        $('#bahagian_id').focus(); return false;
	} else if(notel.trim() == '' ){
        alert('Sila masukkan maklumat no. telefon.');
        $('#notel').focus(); return false;
	} else if(nohp.trim() == '' ){
        alert('Sila masukkan maklumat no. telefon bimbit.');
        $('#nohp').focus(); return false;
	} else if(emel.trim() == '' ){
        alert('Sila masukkan maklumat emel.');
        $('#emel').focus(); return false;
	} else if(level.trim() == '' ){
        alert('Sila pilih peranan pengguna.');
        $('#level').focus(); return false;
	} else if(access.trim() == '' ){
        alert('Sila pilih status pengguna.');
        $('#access').focus(); return false;
	} else {
		$.ajax({
			url:'utiliti/users_form_sql.php?pro=SAVE', //&datas='+datas,
			type:'POST',
			//dataType: 'json',
			beforeSend: function () {
				$('#simpan').attr("disabled","disabled");
				$('.dispmodal').css('opacity', '.5');
			},
			data: $("form").serialize(),
			//data: datas,
			success: function(data){
				console.log(data);
				// alert(data);
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
function get_agensi(agid){
	//alert(kat);
	var sel="#agensi_id";
	//var sel_pej="#appl_pejabat";
	//$(sel_pej).empty();
	$.ajax({
		url: 'include/get_agensi.php?agid='+agid,
		type: 'post',
		data: {agid:agid},
		dataType: 'json',
		success:function(response){
			console.log(response);
			//alert(response);
			var len = response.length;
	
			$(sel).empty();
			for( var i = 0; i<len; i++){
				var id = response[i]['id'];
				var name = response[i]['name'];
				$(sel).append("<option value='"+id+"'>"+name+"</option>");
			}
		}
	});
	do_upd();
}
</script>
<?php
include '../connection/common.php';
$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
if(empty($id)){ $title = 'Tambah Pengguna Sistem'; }
else { $title = 'Kemaskini Pengguna Sistem'; }
$sql = "SELECT * FROM _tbl_users WHERE id=".tosql($id);
$rsData = $conn->query($sql);
?>
<div class="col-md-12">
<section class="panel">
    <header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
        <h6 class="panel-title"><font color="#000000" size="3"><b><?php print $title;?></b></font></h6>
    </header>
    <div class="panel-body">
    
        <input type="hidden" name="id" value="<?=$rsData->fields['id'];?>">
        <div class="col-md-12">
            <?php if(!empty($id)){ ?>
            <div class="form-group">
            	<div class="row">
                <label class="col-sm-3 control-label">ID Pengguna: </label>
                <div class="col-sm-3">
                    <input type="text" name="username" id="username" class="form-control" placeholder="ID Pengguna" disabled="disabled" 
                    value="<?php print $rsData->fields['username'];?>">
                </div>
                </div>
            </div>
            <?php } ?>
            
            <div class="form-group">
            	<div class="row">
                <label class="col-sm-3 control-label"><font color="#FF0000">*</font> No Kad Pengenalan: </label>
                <div class="col-sm-3">
                    <input type="text" name="ic" id="ic" class="form-control" placeholder="No Kad Pengenalan" 
                    value="<?php print $rsData->fields['ic'];?>" maxlength="12" 
                    onkeydown="return (event.ctrlKey || event.altKey 
                        || (47<event.keyCode && event.keyCode<58 && event.shiftKey==false) 
                        || (95<event.keyCode && event.keyCode<106)
                        || (event.keyCode==8) || (event.keyCode==9) 
                        || (event.keyCode>34 && event.keyCode<40) 
                        || (event.keyCode==46) )" > 
                </div>
                <div class="col-sm-5">&nbsp;<i>(Sila masukkan No. MyKAD tanpa tanda '-')</i>
				</div>
				</div>
            </div>
            
            <div class="form-group">
            	<div class="row">
                <label class="col-sm-3 control-label"><font color="#FF0000">*</font> Nama Penuh: </label>
                <div class="col-sm-8">
                    <input type="text" name="nama" id="nama" class="form-control" 
                    value="<?php print $rsData->fields['nama'];?>">
                </div>
				</div>
            </div>
 
            <div class="form-group">
            	<div class="row">
                <label class="col-sm-3 control-label"><font color="#FF0000">*</font> Jawatan: </label>
                <div class="col-sm-8">
                    <input type="text" name="jawatan" id="jawatan" class="form-control" 
                    value="<?php print $rsData->fields['jawatan'];?>">
                </div>
				</div>
            </div> 
            
			<?php $rsBgh = $conn->query("SELECT * FROM _ref_bahagian WHERE is_deleted=0 AND bhg_status=0 ORDER BY bhg_sort"); ?>
            <div class="form-group">
            	<div class="row">
                <label class="col-md-3 control-label" for="profileLastName"><font color="#FF0000">*</font> Jabatan :</label>
                <div class="col-md-8">
                <select name="bahagian_id" id="bahagian_id" class="form-control">
                    <option value="">Sila pilih bahagian</option>
                <?php while(!$rsBgh->EOF){ ?>
                    <option value="<?=$rsBgh->fields['bhg_id'];?>" <?php if($rsBgh->fields['bhg_id']==$rsData->fields['bahagian_id']){ 
					print 'selected'; }?>><?php print $rsBgh->fields['bhg_nama'];?></option>
                <?php $rsBgh->movenext(); } ?>    
                </select>
                </div>
				</div>
            </div> 

			<!-- <?php 
			$sqlA="SELECT * FROM _ref_agensi WHERE agensi_status=0 ";
			$sqlA.=" AND agensia_id=".tosql($rsData->fields['agansia_id']); 
			$sqlA.=" ORDER BY agensi_id";
			// $rsBgh = $conn->query($sqlA); ?>
            <div class="form-group">
            	<div class="row">
                <label class="col-md-3 control-label" for="profileLastName"> Bahagian :</label>
                <div class="col-md-8">
                <select name="agensi_id" id="agensi_id" class="form-control">
                    <option value="">Sila pilih agensi</option>
                <?php while(!$rsBgh->EOF){ ?>
                    <option value="<?=$rsBgh->fields['agensi_id'];?>" <?php if($rsBgh->fields['agensi_id']==$rsData->fields['agensi_id']){ 
					print 'selected'; }?>><?php print $rsBgh->fields['agensi_nama'];?></option>
                <?php $rsBgh->movenext(); } ?>    
                </select>
                </div>
				</div>
            </div> --> 
            
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
                <label class="col-md-3 control-label"><font color="#FF0000">*</font> No. Tel Bimbit:</label>
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
            
            <?php $rsA = $conn->query("SELECT * FROM _ref_level WHERE LvlStatus=0"); ?>  
        	<div class="form-group">
            	<div class="row">
                <label class="col-sm-3 control-label"><font color="#FF0000">*</font> Peranan: </label>
                <div class="col-sm-4">
                    <select class="form-control" id="level" name="level">
                        <option value="">Sila Pilih</option>
                        <?php while(!$rsA->EOF){ ?>
                        <option value="<?=$rsA->fields['LvlID'];?>" <?php if($rsData->fields['level']==$rsA->fields['LvlID']){ print 'selected'; }?>><?=$rsA->fields['LvlNama'];?></option>
                        <?php $rsA->movenext(); } ?>
                    </select>
                </div>
				</div>
            </div> 
            
            <div class="form-group">
            	<div class="row">
                <label class="col-md-3 control-label"><font color="#FF0000">*</font> Status Pengguna:</label>
                <div class="col-md-6 control-label">
                    <div class="input-group">
                        <select class="form-control" id="access" name="access">
                        <option value="">Sila Pilih</option>
                        <option value="0" <?php if(empty($rsData->fields['access'])){ print 'selected'; }?>>Aktif</option>
                        <option value="1" <?php if($rsData->fields['access']=='1'){ print 'selected'; }?>>Tidak Aktif</option>
                        </select>
                    </div>
				</div>
                </div>
            </div> 
            
            <div class="form-group" align="right" style="padding:0px;">
                <label class="col-md-3 control-label"></label>
                <div class="col-sm-8" style="padding:0px;">
                    <button type="button" class="mt-sm mb-sm btn btn-primary" onclick="do_simpan()" id="simpan">
                    	<i class="fa fa-save"></i> Simpan</button>
                    <button type="button" class="btn btn-default" onclick="do_close()"><i class="fa fa-spinner"></i> Kembali</button>
                </div>
                </div> 
            </div>
							 
		 
          </div>
     
</section>

</div> 