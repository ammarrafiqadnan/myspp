<?php include '../connection/common.php'; ?>
<script language="javascript">
function do_save(){
    var reg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
    var tarikh = $('#tarikh').val();
    var kluster_id = $('#kluster_id').val();
    var isu = $('#isu').val();
    var syor = $('#syor').val();
    // alert(kluster_id);
    if(tarikh.trim() == '' ){
        alert('Sila pilih tarikh.');
        $('#tarikh').focus(); return false;
	} else if(kluster_id.trim()==''){
        alert('Sila pilih maklumat kluster/bahagian.');
        $('#kluster_id').focus(); return false;
	} else if(isu.trim() == ''){
        alert('Sila masukkan maklumat isu.');
        $('#isu').focus(); return false;
	} else if(syor.trim() == ''){
        alert('Sila masukkan maklumat syor/cadangan.');
        $('#syor').focus(); return false;
	} else {
		do_send();
    }
}

function do_send(){
	$.ajax({
        url:'maklumat/sql_media.php?frm=ISU_MEDIA&pro=SAVE',
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

function get_weeknum1(dateString){
	// var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
	// var days = ['Ahad', 'Isnin', 'Selasa', 'Rabu', 'Khamis', 'Jumaat', 'Sabtu'];
	// var d = new Date(dateString);
	// var dayName = d.getWeek();
	// alert(d.getWeek());
	// alert(dayName);
	currentdate = new Date(dateString);
	var oneJan = new Date(currentdate.getFullYear(),0,1);
	var numberOfDays = Math.floor((currentdate - oneJan) / (24 * 60 * 60 * 1000))-4;
	var result = Math.ceil(( currentdate.getDay() + 1 + numberOfDays) / 7);
	document.jawi.minggu.value = result;
	alert(numberOfDays)
}

function get_weeknum(dateString) {
	 const today = new Date(dateString);
    const firstDayOfYear = new Date(today.getFullYear(), 0, 1);
    const pastDaysOfYear = (today - firstDayOfYear) / 86400000;
    var dt= Math.ceil((pastDaysOfYear + firstDayOfYear.getDay()) / 7);
  	// alert(dt);
  	document.jawi.minggu.value = dt;
}

function do_close(){
	reload = window.location; 
	window.location = reload;
}

function doChk(val){
	var checkBox = document.getElementById("medium"+val);
	// alert(checkBox);
  	// var text = document.getElementById("text");
  	if (checkBox.checked == true){
  		// alert("DISP");
    	//text.style.display = "block";
  	} else {
  		// alert("NONE");
  		document.getElementById("links"+val).value='';
  		document.getElementById("kekerapan"+val).value='';
    	//text.style.display = "none";
  	}
}
</script>
<?php
// $conn->debug=true;
$_SESSION['page_name']="MEDIA MASSA";
$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
$read_only='';

$sql = "SELECT * FROM `tbl_hinaagama` WHERE `id`=".tosql($id);
$rs = $conn->query($sql);

$rsKluster = $conn->query("SELECT * FROM `_ref_kluster` WHERE `is_deleted`=0 AND `kluster_status`=0");
$rsMedia = $conn->query("SELECT * FROM `_ref_medium_media` WHERE `is_deleted`=0 AND `medium_status`=0");

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
								<input type="date" name="tarikh" id="tarikh" class="form-control" <?=$disabled;?>
								value="<?=$rs->fields['tarikh'];?>" onchange="get_weeknum(this.value)">
							</div>
							<div class="col-sm-1"></div>
							<label for="nama" class="col-sm-2 control-label"><b>MINGGU KE <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-2">
								<input type="text" name="minggu" id="minggu" class="form-control" value="<?=$rs->fields['minggu'];?>" readonly>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>KLUSTER / BIDANG <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10">
								<select name="kluster_id" id="kluster_id" class="form-control" <?=$disabled;?>>
					                <option value="-">-- Sila pilih kluster --</option>
					                <?php while(!$rsKluster->EOF){ ?>
					                <option value="<?php print $rsKluster->fields['kluster_id'];?>" <?php if($rsKluster->fields['kluster_id']==$rs->fields['kluster_id']){ 
					                    print 'selected'; }?>><?php print $rsKluster->fields['kluster_nama'];?></option>
					                <?php $rsKluster->movenext(); } ?>
					            </select>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>ISU <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10">
								<input type="text" name="isu" id="isu" class="form-control" value="<?=$rs->fields['isu'];?>" <?=$disabled;?>>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>PAPARAN MEDIA <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10">
								<table width="100%" cellpadding="5" cellspacing="1">
									<tr>
										<td width="20%"><b>MEDIUM</b></td>
										<td width="60%"><b>NAMA LINK (jika berkaitan)</b></td>
										<td width="20%"><b>KEKERAPAN</b></td>
									</tr>
									<?php while(!$rsMedia->EOF){ 
										$med_id = $rsMedia->fields['medium_id'];
										if(!empty($id) && !empty($med_id)){ 
											$rsDM = $conn->query("SELECT * FROM `tbl_hinaagama_media` WHERE `id_hinaagama`='{$id}' AND `id_media`='{$med_id}'");
											$links = $rsDM->fields['links'];
											$kekerapan = $rsDM->fields['kekerapan'];
											$chk=1;
										} else {
											$chk=0;
										}
									?>
									<tr>
										<td>
											<input type="checkbox" name="medium[]" id="medium<?=$med_id;?>" value="<?=$med_id;?>" 
											<?php if(!empty($chk)){ print 'checked'; } ?> onclick="doChk(this.value)" <?=$disabled;?>> 
											<?php print $rsMedia->fields['medium_name'];?>
											<input type="hidden" name="massa[]" value="<?=$med_id;?>" <?=$disabled;?>>
										</td>
										<td><input type="text" name="links[]"class="form-control" value="<?=$links;?>" id="links<?=$med_id;?>" <?=$disabled;?>></td>
										<td><input type="text" name="kekerapan[]"class="form-control" value="<?=$kekerapan;?>" id="kekerapan<?=$med_id;?>" <?=$disabled;?>></td>
									</tr>
									<?php $rsMedia->movenext(); } ?>
								</table>
									
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>SYOR/CADANGAN <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10">
								<textarea class="form-control" name="syor" id="syor" rows="4" <?=$disabled;?>><?php print $rs->fields['syor'];?></textarea>
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
</script>		 
