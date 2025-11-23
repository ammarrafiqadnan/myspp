<?php include '../connection/common.php'; ?>
<script language="javascript">
function do_save(){
    var reg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
    var tarikh = $('#tarikh').val();
    var subtopik_id = $('#subtopik_id').val();
    var sub_topik = $('#sub_topik').val();
    var kenyataan = $('#kenyataan').val();
    var carian_oleh = $('#carian_oleh').val();
    // alert();
    if(tarikh.trim() == '' ){
        alert('Sila pilih tarikh.');
        $('#tarikh').focus(); return false;
	} else if(subtopik_id.trim()==''){
        alert('Sila pilih maklumat topik.');
        $('#subtopik_id').focus(); return false;
	} else if(sub_topik.trim()==''){
        alert('Sila masukkan maklumat sub-topik.');
        $('#sub_topik').focus(); return false;
	} else if(kenyataan.trim() == ''){
        alert('Sila masukkan maklumat kenyataan.');
        $('#kenyataan').focus(); return false;
	} else if(carian_oleh.trim() == ''){
        alert('Sila masukkan maklumat carian oleh.');
        $('#carian_oleh').focus(); return false;
	} else {
		do_send();
    }
}

function do_send(){
	$.ajax({
        url:'maklumat/sql_media.php?frm=ISU_AKIDAH&pro=SAVE',
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
	var numberOfDays = Math.floor((currentdate - oneJan) / (24 * 60 * 60 * 1000));
	var result = Math.ceil(( currentdate.getDay() + 1 + numberOfDays) / 7);
	document.jawi.minggu.value = result;
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
$_SESSION['page_name']="ISU AKIDAH";
// $conn->debug=true;
$id=isset($_REQUEST["id"])?$_REQUEST["id"]:"";
$read_only='';

$sql = "SELECT * FROM `tbl_isuakidah` WHERE `id`=".tosql($id);
$rs = $conn->query($sql);

$rsSubTopik = $conn->query("SELECT A.*, B.`topik_nama` FROM `_ref_topik_sub` A, `_ref_topik` B WHERE A.`topik_id`=B.`topik_id` AND A.`is_deleted`=0 
	AND A.`subtopik_status`=0 ORDER BY A.`topik_id`");

if($_SESSION['SESS_ULEVEL']==2 || $_SESSION['SESS_ULEVEL']==3){ $disabled=''; }
else { $disabled='disabled'; }
?>
<div class="col-lg-12">
	<section class="panel">
		<header class="panel-heading"  style="background-color:rgb(38, 167, 228)">
			<h6 class="panel-title"><font color="#000000" size="3"><b>MAKLUMAT LAPORAN PEMERHATIAN ISU-ISU AKIDAH DI MEDIA BAHARU</b></font></h6>
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
								onchange="get_weeknum(this.value)" <?=$disabled;?>>
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
							<label for="nama" class="col-sm-2 control-label"><b>TOPIK <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10">
								<select name="subtopik_id" id="subtopik_id" class="form-control" <?=$disabled;?>>
					                <option value="-">-- Sila pilih Topik & Sub-Topik --</option>
					                <?php while(!$rsSubTopik->EOF){ ?>
					                <option value="<?php print $rsSubTopik->fields['subtopik_id'];?>" <?php if($rsSubTopik->fields['subtopik_id']==$rs->fields['subtopik_id']){ 
					                    print 'selected'; }?>><?php print "[".$rsSubTopik->fields['topik_nama'] ."] - ". $rsSubTopik->fields['subtopik_nama'];?></option>
					                <?php $rsSubTopik->movenext(); } ?>
					            </select>
							</div>
						</div>
					</div>
					

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>SUB-TOPIK <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10">
								<input type="text" name="sub_topik" id="sub_topik" class="form-control" value="<?=$rs->fields['sub_topik'];?>" <?=$disabled;?>>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>CARIAN OLEH <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10">
								<input type="text" name="carian_oleh" id="carian_oleh" class="form-control" value="<?=$rs->fields['carian_oleh'];?>" <?=$disabled;?>>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>SUMBER CARIAN <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10">
								<input type="text" name="carian_sumber" id="carian_sumber" class="form-control" value="<?=$rs->fields['carian_sumber'];?>" <?=$disabled;?>>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>KENYATAAN / <font color="#FF0000">*</font> : 
								<br>AKTIVITI /<br>PERANCANGAN</b></label>
							<div class="col-sm-10">
								<textarea class="form-control" name="kenyataan" id="kenyataan" rows="4" <?=$disabled;?>><?php print $rs->fields['kenyataan'];?></textarea>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label for="nama" class="col-sm-2 control-label"><b>ULASAN <font color="#FF0000">*</font> : </b></label>
							<div class="col-sm-10">
								<textarea class="form-control" name="ulasan" id="ulasan" rows="4" <?=$disabled;?>><?php print $rs->fields['ulasan'];?></textarea>
							</div>
						</div>
					</div>
					
	

					<div class="modal-footer" style="padding:0px;">
						<?php if($_SESSION['SESS_ULEVEL']==2 || $_SESSION['SESS_ULEVEL']==3){ ?>
						<button type="button" class="btn btn-primary mt-sm mb-sm" onclick="do_save()"><i class="fa fa-save"></i> Simpan</button>
						&nbsp;
						<?php }?>
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
