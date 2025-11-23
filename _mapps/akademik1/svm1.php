<?php //include '../connection/common.php'; ?>
<script language="javascript">
function save_svm(val){
	// var svm_tahun_1 = $('#svm_tahun_1').val();
	// var svm_jenis_sijil_1 = $('#svm_jenis_sijil_1').val();
	var svm_sijil_1 = $('#svm_sijil_1').val();
	var gred_bm_1 = $('#gred_bm_1').val();
	var svm_pngk = $('#svm_pngk').val();
	var svm_pngkv = $('#svm_pngkv').val();
	var msg = '';

    // if(svm_tahun_1.trim()==''){
    //     msg = msg+'\n- Sila pilih tahun peperiksaan SVM.';
    //     $("#svm_tahun_1").css("border-color","#f00");
    // } 
    // if(svm_jenis_sijil_1.trim()==''){
    //     msg = msg+'\n- Sila pilih jenis sijil.';
    //     $("#svm_jenis_sijil_1").css("border-color","#f00");
    // } 
    if(svm_sijil_1.trim()==''){
        msg = msg+'\n- Sila pilih nama sijil.';
        $("#svm_sijil_1").css("border-color","#f00");
    }
    if(gred_bm_1.trim()==''){
        msg = msg+'\n- Sila pilih gred Bahasa Melayu.';
        $("#gred_bm_1").css("border-color","#f00");
    }
    if(svm_pngk.trim()=='' || svm_pngk.trim()=='0.00'){
        msg = msg+'\n- Sila masukkan maklumat PNGK peperiksaan..';
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

</script>
<?php
// include 'akademik/sql_akademik.php';
// $data = get_pmr($conn,$_SESSION['SESS_UID']);
// print_r($data);
// $conn->debug=true;
$uid = $data['id_pemohon'];
// $tahun = $data['svm_tahun_1'];


$rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='SVM1' AND `id_pemohon`=".tosql($uid));
if(empty($rsSijil->fields['sijil_nama'])){ $sijil="../upload_doc/PMR_Mock_Result_Statement_Certificate.png"; }
else { $sijil = "../uploads_doc/".$uid."/".$rsSijil->fields['sijil_nama']; }

// $rssijil = $conn->query("SELECT * FROM $schema1.`ref_sijil` WHERE `TKT`='5' AND kod=5 AND is_aktif=0");
$rssijil = $conn->query("SELECT * FROM $schema1.`ref_sijil` WHERE `TKT`='5' AND is_aktif=0");
$rspangkat = $conn->query("SELECT * FROM $schema1.`ref_sijil_pangkat` WHERE `TKT`=5 ORDER BY `DISKRIPSI`");

// $rsSRP = $conn->query("SELECT * FROM $schema1.`ref_matapelajaran` WHERE `TKT`='5' AND `SAH_YT`='Y' AND `GAB_YT`='T' AND `kod` NOT IN ('103')
// 	ORDER BY `DISKRIPSI`");
$rsGred = $conn->query("SELECT * FROM $schema1.`ref_gred_matapelajaran` WHERE `TKT`='5' 
ORDER BY `SUSUNAN`");

?>
	<hr>

	<div class="form-group">
		<div class="row">
			<div class="col-sm-8">

				<div class="form-group">
					<div class="row">
						<label for="nama" class="col-sm-2 control-label"><b>Jenis Sijil <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
						<div class="col-sm-4">
							<select class="form-control" id="spm_jenis_sijil_1" name="spm_jenis_sijil_1" onchange="set_spm('spm_jenis_sijil_1',this.value,'R')">
								<option value="">Sila pilih jenis sijil</option>
								<?php while(!$rssijil->EOF){ ?>
								<option value="<?=$rssijil->fields['KOD'];?>" 
								<?php if($rssijil->fields['KOD']==$s_sijil){ print 'selected';} ?>	
								><?=$rssijil->fields['DISKRIPSI'];?></option>
								<?php $rssijil->movenext(); } ?>
							</select>
						</div>
					</div>
				</div>

				<div class="form-group">
					<div class="row">
						<label for="nama" class="col-sm-2 control-label"><b>Tahun <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
						<div class="col-sm-4">
							<select name="spm_tahun_1" id="spm_tahun_1" class="form-control" onchange="set_spm('spm_tahun_1',this.value,'R')">
								<option value="">Sila pilih tahun</option>
								<?php for($t=date("Y");$t>=1985;$t--){
									print '<option value="'.$t.'"'; 
									if($s_tahun==$t){ print 'selected'; }
									print '>'.$t.'</option>';
								} ?>
							</select>
						</div>
					</div>
				</div>

				<BR><BR>
				<?php
				$rsData = $conn->query("SELECT * FROM $schema2.`calon_svm` WHERE `id_pemohon`=".tosql($uid));
				?>
				<div class="form-group">
					<div class="row">
						<label for="nama" class="col-sm-2 control-label"><b>Nama Sijil <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
						<div class="col-sm-10">
							<select class="form-control" name="svm_sijil_1" id="svm_sijil_1">
								<option value="">Sila pilih nama sijil</option>
								<option value="991" <?php if($rsData->fields['nama_sijil']=='991'){ print 'selected'; }?>>SIJIL VOKASIONAL MALAYSIA - PENGAJIAN AWAL KANAK-KANAK</option>
								<!-- <?php while(!$rspangkat->EOF){ ?>
								<option value="<?=$rspangkat->fields['KOD'];?>" 
								<?php if($rspangkat->fields['DISKRIPSI']==$rsData->fields['nama_sijil']){ print 'selected';} ?>
								><?=$rspangkat->fields['DISKRIPSI'];?></option>
								<?php $rspangkat->movenext(); } ?> -->
							</select>
						</div>
					</div>
				</div>

				<BR><BR>

				<div class="row">
					<div class="col-sm-3 col-xm-4" style="padding-bottom:5px"><b>BAHASA MELAYU SVM <div style="float:right">:</div></b></div>
					<div class="col-sm-3 col-xm-4" style="padding-bottom:5px">
						<!-- <input type="hidden" name="mp_1[]" id="mp_1[]" value="103"> -->
						<select class="form-control" name="gred_bm_1" id="gred_bm_1">
							<option value="">Sila pilih gred</option>
							<?php 
							// $result = get_spm_result($conn, $uid, "103", $tahun, "1");
							$rsGred->movefirst();
							while(!$rsGred->EOF){ ?>
							<option value="<?=$rsGred->fields['GRED'];?>" <?php if($rsData->fields['gred_bm']==$rsGred->fields['GRED']){ print 'selected'; } ?>><?=$rsGred->fields['GRED'];?></option>	
							<?php $rsGred->movenext(); } ?>
						</select>
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
								<td>PURATA NILAI GRED KUMULATIF AKADEMIK (PNGK)</td>
								<td>
									<input type="text" name="svm_pngk" id="svm_pngk" class="form-control" oninput="validate1(this)" 
									value="<?php print number_format($rsData->fields['svm_pngk'],2);?>">
								</td>
							</tr>
							<tr>
								<td>PURATA NILAI GRED KUMULATIF VOKASIONAL (PNGKV)</td>
								<td>
									<input type="text" name="svm_pngkv" id="svm_pngkv" class="form-control" oninput="validate2(this)" 
									value="<?php print number_format($rsData->fields['svm_pngkv'],2);?>">
								</td>
							</tr>
						</table>
						<i>Pointer PNGK @ PNGKV hanya 4.00 dan kebawah sahaja.</i>
					</div>
				</div>
			</div>


			<div class="col-sm-4" align="center">
				<img src="<?=$sijil;?>" width="300" height="400">
				<input type="file" name="file_pmr" id="file_pmr" class="form-control">
			</div>

		</div>
			<div class="modal-footer" style="padding:0px;">
				<button type="button" id="simpan" class="btn btn-primary mt-sm mb-sm" onclick="save_svm(1)"><i class="fa fa-save"></i> Simpan</button>
				<?php if(!empty($s_sijil)){ ?>
					<label class="btn btn-danger" onclick="do_hapus('akademik/sql_akademik.php?frm=SVM&pro=DEL&id_pemohon=<?=$uid;?>')">Hapus</label>
				<?php } ?>
				<input type="hidden" name="progid" id="progid" value="<?php print $progid;?>" />
				<input type="hidden" name="proses" value="<?php print $proses;?>" />
			</div>
		</div>
	<?php //} ?>


	     

<script language="javascript" type="text/javascript">
// var srp_tahun = document.getElementById('srp_tahun').value;
// var srp_pangkat = document.getElementById('srp_pangkat');
// // alert(srp_tahun);
// if(srp_tahun>='1993'){
// 	srp_pangkat.setAttribute('disabled', '');
// } else {
// 	srp_pangkat.removeAttribute('disabled');
// }
</script>		 
