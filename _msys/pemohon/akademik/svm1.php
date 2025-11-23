<?php //include '../connection/common.php'; ?>
<script language="javascript">
function save_svm(val){
	// var svm_tahun_1 = $('#svm_tahun_1').val();
	var spm_jenis_sijil_1 = $('#spm_jenis_sijil_1').val();
	var svm_sijil_1 = $('#svm_sijil_1').val();
	var spm_tahun_1 = $('#spm_tahun_1').val();
	var gred_bm_1 = $('#gred_bm_1').val();
	var svm_pngk = $('#svm_pngk').val();
	var svm_pngkv = $('#svm_pngkv').val();
	var msg = '';

	// alert(spm_jenis_sijil_1);

    if(spm_jenis_sijil_1.trim()==''){
        msg = msg+'\n- Sila pilih jenis sijil.';
        $("#spm_jenis_sijil_1").css("border-color","#f00");
    } 
    if(spm_tahun_1.trim()==''){
        msg = msg+'\n- Sila pilih tahun peperiksaan.';
        $("#spm_tahun_1").css("border-color","#f00");
    }
    if(svm_sijil_1.trim()==''){
        msg = msg+'\n- Sila pilih nama sijil.';
        $("#svm_sijil_1").css("border-color","#f00");
    }
    if(gred_bm_1.trim()==''){
        msg = msg+'\n- Sila pilih gred Bahasa Melayu.';
        $("#gred_bm_1").css("border-color","#f00");
    }
    if(svm_pngk.trim()=='' || svm_pngk.trim()=='0.00'){
        msg = msg+'\n- Sila masukkan maklumat PNGK peperiksaan SVM.';
        $("#svm_pngk").css("border-color","#f00");
    }
    if(svm_pngkv.trim()=='' || svm_pngkv.trim()=='0.00'){
        msg = msg+'\n- Sila masukkan maklumat PNGKV peperiksaan SVM.';
        $("#svm_pngkv").css("border-color","#f00");
    }

	if(msg.trim() !=''){ 
		alert_msg_html(msg);
	} else { 
		var fd = new FormData();
        var files1 = $('#file_pmr')[0].files[0];
        // var files2 = $('#upload_id2')[0].files[0];
        fd.append('file_pmr',files1);
        // fd.append('upload_id2',files2);

        var other_data = $('form').serializeArray();
		$.each(other_data,function(key,input){
		    fd.append(input.name,input.value);
		});

        $.ajax({
	        url:'akademik/sql_akademik.php?frm=SVM&pro=SAVE',
			type:'POST',
	        //dataType: 'json',
	        beforeSend: function () {
	            // $('.btn-primary').attr("disabled","disabled");
	            // $('.modal-body').css('opacity', '.5');
	        },
			// data: $("form").serialize(),
			data:  fd,
            contentType: false,
            cache: false,
            processData:false,
			success: function(data){
				console.log(data);
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

var validate1 = function(e) {
 	var t = e.value;
  	if(t<=4){ 
  		e.value = (t.indexOf(".") >= 0) ? (t.substr(0, t.indexOf(".")) + t.substr(t.indexOf("."), 3)) : t;
	} else {
		document.myspp.svm_pngk.value='';
		//alert(t);
	}
}

var validate2 = function(e) {
 	var t = e.value;
  	if(t<=4){ 
  		e.value = (t.indexOf(".") >= 0) ? (t.substr(0, t.indexOf(".")) + t.substr(t.indexOf("."), 3)) : t;
	} else {
		document.myspp.svm_pngkv.value='';
		//alert(t);
	}
}

function do_input() { 

	var fileUpload = $("#file_pmr")[0];
	//alert(fileUpload);
	var regex = new RegExp("\.(jpe?g|png|jpg|gif)$");

    if (regex.test(fileUpload.value.toLowerCase())) {
        //Initiate the FileReader object.

	    if (!fileUpload.files) { // This is VERY unlikely, browser support is near-universal
	        console.error("This browser doesn't seem to support the `files` property of file inputs.");
	    } else if (!fileUpload.files[0]) {
	        console.log("Please select a file before clicking 'Load'");
	    } else {
	        var file = fileUpload.files[0];
			if(file.size > 307200){
				swal({
		    		title: 'Amaran',
		    		text: 'Saiz fail yang dimuatnaik melebihi daripada yang dibenarkan (300kb)',
		    		type: 'warning',
		    		confirmButtonClass: "btn-warning",
		    		confirmButtonText: "Ok",
		    		showConfirmButton: true,
		    	});
				return fileUpload.value = '';
			}
		        //console.log("File " + file.name + " is " + file.size + " bytes in size");
	    }
        
    } else {
        swal({
            title: 'Amaran',
            text: 'Kami hanya menerima format JPG, JPEG, GIF @ PNG sahaja.',
            type: 'warning',
            confirmButtonClass: "btn-warning",
            confirmButtonText: "Ok",
            showConfirmButton: true,
        });
        return fileUpload.value = '';
    }
}

</script>
<?php
 //$conn->debug=true;
$uid = $data->fields['id_pemohon'];



//if($actions==1){ 
	$rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='SVM1' AND `id_pemohon`=".tosql($uid));
//} else if($actions==2){
	//$rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='SVM2' AND `id_pemohon`=".tosql($uid));
//}
if(!empty($rsSijil->fields['sijil_nama'])){ 
	$sijil_pic = "/var/www/upload/".$uid."/".$rsSijil->fields['sijil_nama']; 
	//$sijil = "/upload/".$uid."/".$rsSijil->fields['sijil_nama']; 
}

if (file_exists($sijil_pic)){
     $b64image = base64_encode(file_get_contents($sijil_pic));
     $sijil = "data:image/png;base64,$b64image";
}




if($data->fields['spm_jenis_sijil_1']==5 && !empty($data->fields['spm_tahun_1'])){ $s = "SELECT * FROM $schema1.`ref_sijil` WHERE `TKT`='5' AND is_aktif=0 AND KOD=5"; }
else { $s = "SELECT * FROM $schema1.`ref_sijil` WHERE `TKT`='5' AND is_aktif=0"; }

$rssijil = $conn->query($s); // AND `DISKRIPSI`='SVM'
$rspangkat = $conn->query("SELECT * FROM $schema1.`ref_sijil_pangkat` WHERE `TKT`=5 ORDER BY `DISKRIPSI`");

$rsGred = $conn->query("SELECT * FROM $schema1.`ref_gred_matapelajaran` WHERE `TKT`='5' AND `GRED`>='A'
ORDER BY `SUSUNAN`");
$conn->debug=false;

$dty = date("Y")."-06";
$s_tahun='';
$s_sijil='';

$s_sijil = $data->fields['spm_jenis_sijil_1'];
$s_tahun = $data->fields['spm_tahun_1'];
$s_pangkat = $data->fields['spm_pangkat_1'];
$s_lisan = $data->fields['spm_lisan_1'];
$tahun_1 = "1990";
if(date("Y-m")<=$dty){ $tahun_2 = date("Y")-1; }
else { $tahun_2 = date("Y"); }

?>

<?php
$rsData = $conn->query("SELECT * FROM $schema2.`calon_svm` WHERE `id_pemohon`=".tosql($uid) ." AND `tahun`=".tosql($s_tahun));
?>

<small style="color: red;">
    Tarikh/masa kemas kini : 
    <?php 
    if(!empty($rsData->fields['updated_dt'])){ //print 'here';
        print DisplayDate($rsData->fields['updated_dt']);  print '&nbsp;&nbsp;'.DisplayMasa($rsData->fields['updated_dt']);
    } else {  //print 'here2';
        print $rsData->fields['create_dt'];
    }
     ?> 
</small>

	<hr>

	<div class="form-group">
		<div class="row">
			<div class="col-sm-8">

				<div class="form-group">
					<div class="row">
						<label for="nama" class="col-sm-2 control-label"><b>Jenis Sijil <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
						<div class="col-sm-4">
								<?php while(!$rssijil->EOF){ ?>
								<?php if($rssijil->fields['KOD']==$s_sijil){ print $rssijil->fields['DISKRIPSI'];} ?>	
								<?php $rssijil->movenext(); } ?>
							<input type="hidden" name="spm_sijil_pilih" value="<?=$s_sijil;?>">
						</div>
					</div>
				</div>

				<div class="form-group">
					<div class="row">
						<label for="nama" class="col-sm-2 control-label"><b>Tahun <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
						<div class="col-sm-4">

								<?php for($t=date("Y");$t>=2012;$t--){
									if($s_tahun==$t){ print $t; }
								} ?>
							<input type="hidden" name="spm_tahun_pilih" value="<?=$s_tahun;?>">
						</div>
					</div>
				</div>

				<BR><BR>
				
				<div class="form-group">
					<div class="row">
						<label for="nama" class="col-sm-2 control-label"><b>Nama Sijil <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
						<div class="col-sm-10">
							<?php //if($rsData->fields['nama_sijil']=='991'){ print 'SIJIL VOKASIONAL MALAYSIA - PENGAJIAN AWAL KANAK-KANAK'; }?>
							<?php if($rsData->fields['nama_sijil']=='99'){ print 'LAIN-LAIN BIDANG';
							} else { print dlookup("$schema1.`ref_kursus_svm`","DISKRIPSI","KOD=".tosql($rsData->fields['nama_sijil'])); }?>
						</div>
					</div>
				</div>

				<BR><BR>

				<div class="row">
					<div class="col-sm-4 col-xm-4" style="padding-bottom:5px"><b>BAHASA MELAYU SVM <font color="#FF0000">*</font><div style="float:right">:</div></b></div>
					<div class="col-sm-3 col-xm-4" style="padding-bottom:5px">
							<?php 
							$rsGred->movefirst();
							while(!$rsGred->EOF){ ?>
							<?php if($rsData->fields['gred_bm']==$rsGred->fields['GRED']){ print $rsGred->fields['GRED']; } ?>	
							<?php $rsGred->movenext(); } ?>

					</div>
				</div>

				<div class="row"><br><br></div>
								

				<div class="row">
					<div class="col-sm-12" style="padding-bottom:5px">
						<table width="100%" class="table" cellpadding="5" cellspacing="0" border="1">
							<tr>
								<td width="80%"><b>Kompeten Semua Modul</b></td>
								<td width="20%"><b>Mata Gred</b></td>
							</tr>
							<tr>
								<td>PURATA NILAI GRED KUMULATIF AKADEMIK (PNGK)<font color="#FF0000">*</font></td>
								<td>
									<input type="text" name="svm_pngk" id="svm_pngk" class="form-control" oninput="validate1(this)" 
									value="<?php print number_format($rsData->fields['svm_pngk'],2);?>">
								</td>
							</tr>
							<tr>
								<td>PURATA NILAI GRED KUMULATIF VOKASIONAL (PNGKV)<font color="#FF0000">*</font></td>
								<td>
									<input type="text" name="svm_pngkv" id="svm_pngkv" class="form-control" oninput="validate2(this)" 
									value="<?php print number_format($rsData->fields['svm_pngkv'],2);?>">
								</td>
							</tr>
						</table>
					</div>
				</div>
			</div>


			<div class="col-sm-4" align="center">
				<h6><b>Sijil SPM/SPM(V)/SVM</b></h6>
				<img src="<?=$sijil;?>" width="300" height="400">
			</div>

		</div>
		</div>
	<?php //} ?>


		 
