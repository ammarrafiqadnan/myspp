<?php include '../connection/common.php'; ?>
<script language="javascript">
function do_save(){
    var reg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
    var tarikh = $('#tarikh').val();
    var tajuk = $('#tajuk').val();
    var akhbar = $('#akhbar').val();
    var kategori = $('#kategori').val();
    
    if(tarikh.trim() == '' ){
        alert('Sila pilih tarikh.');
        $('#tarikh').focus(); return false;
	} else if(tajuk.trim() == '' && val2.trim()=='SEND'){
        alert('Sila masukkan maklumat tajuk.');
        $('#tajuk').focus(); return false;
	} else if(akhbar.trim() == '' && val2.trim()=='SEND'){
        alert('Sila pilih jenis akhbar.');
        $('#akhbar').focus(); return false;
	} else if(kategori.trim() == '' && val2.trim()=='SEND'){
        alert('Sila pilih kategori isu.');
        $('#kategori').focus(); return false;
	} else {
		do_send();
    }
}

function do_send(){
	$.ajax({
        url:'maklumat/sql_media.php?frm=ISU_AKHBAR&pro=SAVE',
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
			//window.location.reload();

		},
		//data: datas
    });
}

function get_dayname(dateString){
	// var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
	var days = ['Ahad', 'Isnin', 'Selasa', 'Rabu', 'Khamis', 'Jumaat', 'Sabtu'];
	var d = new Date(dateString);
	var dayName = days[d.getDay()];
	// alert(dayName);
	document.jawi.hari.value = dayName;
}

function do_close(){
	reload = window.location; 
	window.location = reload;
}
</script>
<?php
$_SESSION['page_name']="ISU AGAMA";
// $conn->debug=true;
$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
$read_only='';

$sql = "SELECT * FROM `tbl_isu_agama` WHERE `id`=".tosql($id);
$rs = $conn->query($sql);
// PRINT "DD:".$read_only;
$sqla = "SELECT * FROM `_ref_akhbar` WHERE is_deleted=0 AND akhbar_status=0";
$rsAkhbar = $conn->query($sqla); 
$sqla = "SELECT * FROM `_ref_isuagama` WHERE is_deleted=0 AND isuagama_status=0";
$rsIsu = $conn->query($sqla); 

if($_SESSION['SESS_ULEVEL']==2 || $_SESSION['SESS_ULEVEL']==3){ $disabled=''; }
else { $disabled='disabled'; }

?>
<div class="col-lg-12">
	<section class="panel">
		<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
			<h6 class="panel-title"><font color="#000000" size="3"><b>MAKLUMAT LAPORAN HARIAN PEMERHATIAN ISU AGAMA DI AKHBAR</b></font></h6>
		</header>
		<div class="panel-body">
			<div class="box-body">

			<input type="hidden" name="id" id="id" value="<?php print $id;?>" readonly="readonly"/>

				<div class="col-md-12">

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>TARIKH <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-3">
								<input type="date" name="tarikh" id="tarikh" class="form-control" value="<?=$rs->fields['tarikh'];?>" 
								onchange="get_dayname(this.value)" <?=$disabled;?>>
							</div>
							<div class="col-sm-1"></div>
							<label for="nama" class="col-sm-2 control-label"><b>HARI <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-2">
								<input type="text" name="hari" id="hari" class="form-control" value="<?=$hari;?>" readonly>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>TAJUK <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-9">
								<input type="text" name="tajuk" id="tajuk" class="form-control" value="<?=$rs->fields['tajuk'];?>" <?=$disabled;?>>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>AKHBAR <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-6">
								<select name="akhbar" id="akhbar"  class="form-control" <?=$disabled;?>>
					                <option value="-">-- Sila pilih jenis akhbar --</option>
					                <?php while(!$rsAkhbar->EOF){ ?>
					                <option value="<?php print $rsAkhbar->fields['akhbar_id'];?>" <?php if($rsAkhbar->fields['akhbar_id']==$rs->fields['akhbar_id']){ 
					                    print 'selected'; }?>><?php print $rsAkhbar->fields['akhbar_nama'];?></option>
					                <?php $rsAkhbar->movenext(); } ?>
					            </select>	
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>KATEGORI ISU <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-6">
								<select name="kategori" id="kategori"  class="form-control" <?=$disabled;?>>
					                <option value="-">-- Sila pilih kategori --</option>
					                <?php while(!$rsIsu->EOF){ ?>
					                <option value="<?php print $rsIsu->fields['isuagama_id'];?>" <?php if($rsIsu->fields['isuagama_id']==$rs->fields['kategori_id']){ 
					                    print 'selected'; }?>><?php print $rsIsu->fields['isuagama_nama'];?></option>
					                <?php $rsIsu->movenext(); } ?>
					            </select>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<label for="alamat_url" class="col-sm-2 control-label"><b>ALAMAT URL <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-9">
								<input type="text" name="alamat_url" id="alamat_url" class="form-control" value="<?=$rs->fields['alamat_url'];?>" <?=$disabled;?>>
							</div>
						</div>
					</div>


	

					<div class="modal-footer" style="padding:0px;">
						<?php if($_SESSION['SESS_ULEVEL']==2 || $_SESSION['SESS_ULEVEL']==3){ ?>
						<button type="button" class="btn btn-primary mt-sm mb-sm" onclick="do_save()"><i class="fa fa-save"></i> Simpan</button>
						&nbsp;
						<?php } ?>
						<button type="button" class="btn btn-default" onclick="do_close()"><i class="fa fa-spinner" style="margin:0px;"></i> Kembali</button>
					</div>
				</div>

			
			</div>
		</div>
	     
	</section>

</div> 
<script language="javascript" type="text/javascript">
document.jawi.tarikh.focus();
var dateString = '<?=$rs->fields['tarikh'];?>';
get_dayname(dateString);
</script>		 
