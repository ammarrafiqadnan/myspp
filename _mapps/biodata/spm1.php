<script>
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

function do_tahun(tahun){
	var sijil = document.getElementById('spm_jenis_sijil_1').value;
	var spm_tahun_1 = document.getElementById('spm_tahun_1').value;
	if(spm_tahun_1.trim()>='2000'){
		document.getElementById('spm_lisan_1').disabled = true;
		document.getElementById('spm_pangkat_1').disabled = true;
	} else {
		document.getElementById('spm_lisan_1').disabled = false;
		document.getElementById('spm_pangkat_1').disabled = false;
	}

	if(spm_tahun_1.trim()>='2013'){
		document.getElementById("sejarah").style.display = "block";
	} else {
		document.getElementById("sejarah").style.display = "none";
	}
	
	if(sijil.trim()==5){
		//alert(tahun);
		var sel="#spm_tahun_1";
		$(sel).empty();
		for( var i = tahun; i>=2012; i--){
			$(sel).append("<option value='"+i+"'>"+i+"</option>");
		}
	}
}


</script>

<?php
// include 'akademik/sql_akademik.php';
// $data = get_pmr($conn,$_SESSION['SESS_UID']);
// print_r($data);
$uid = $data['id_pemohon'];
// $tahun = $data['spm_tahun_1'];
//print $s_tahun;
//$conn->debug=true;
if($actions==1){ 
	$rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='SPM1' AND `id_pemohon`=".tosql($uid));
	$get_sijil=$rsSijil->fields['sijil_nama'];
} else if($actions==2){
	$rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='SPM2' AND `id_pemohon`=".tosql($uid));
	$get_sijil=$rsSijil->fields['sijil_nama'];
} else {
	$get_sijil='';
}
if(empty($get_sijil)){ $sijil="../upload_doc/PMR_Mock_Result_Statement_Certificate.png"; }
else { $sijil = "../uploads_doc/".$uid."/".$get_sijil; }

// print "<br><br>SIJIL:".$rsSijil->fields['sijil_nama'];

//print "S:".
?>

	<?php
	// print "DATA:".$data['spm_jenis_sijil_1'];
	// $conn->debug=true;
	if($data['spm_jenis_sijil_1']=='1' || $data['spm_jenis_sijil_1']=='3'){	
		$rssijil = $conn->query("SELECT * FROM $schema1.`ref_sijil` WHERE `TKT`='5' AND KOD IN (1,3,5) AND is_aktif=0");
	} else if($data['spm_jenis_sijil_1']=='5'){	
		$rssijil = $conn->query("SELECT * FROM $schema1.`ref_sijil` WHERE `TKT`='5' AND KOD=5 AND is_aktif=0");
	} else if($data['spm_jenis_sijil_2']=='5'){	
		$rssijil = $conn->query("SELECT * FROM $schema1.`ref_sijil` WHERE `TKT`='5' AND KOD=5 AND is_aktif=0");
	} else {
		$rssijil = $conn->query("SELECT * FROM $schema1.`ref_sijil` WHERE `TKT`='5' AND is_aktif=0");
	}
	$rspangkat = $conn->query("SELECT * FROM $schema1.`ref_sijil_pangkat` WHERE `TKT`=5 ORDER BY `DISKRIPSI`");
	$conn->debug=false;

	// print $s_tahun.":".$s_sijil;
	?>
	<div class="form-group">
		<div class="row">
			<label for="nama" class="col-sm-2 control-label"><b>Jenis Sijil <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
			<div class="col-sm-4">
				<select class="form-control" id="spm_jenis_sijil_1" name="spm_jenis_sijil_1" onchange="do_tahun('<?=date("Y");?>')" 
					<?php if(!empty($s_tahun) && !empty($s_sijil)){ print 'disabled'; }?>>
					 <!-- onchange="set_spm('spm_jenis_sijil_1',this.value,'R')" -->
					<option value="0">Sila pilih jenis sijil</option>
					<?php while(!$rssijil->EOF){ ?>
					<option value="<?=$rssijil->fields['KOD'];?>" 
					<?php if($rssijil->fields['KOD']==$s_sijil){ print 'selected';} ?>	
					><?=$rssijil->fields['DISKRIPSI'];?></option>
					<?php $rssijil->movenext(); } ?>
				</select>
				<input type="hidden" name="spm_sijil_pilih" value="<?=$s_sijil;?>">
			</div>
		</div>
	</div>
	<div class="form-group">
		<div class="row">
			<label for="nama" class="col-sm-2 control-label"><b>Tahun <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
			<div class="col-sm-3">
				<select name="spm_tahun_1" id="spm_tahun_1" class="form-control" onchange="do_tahun('<?=date("Y");?>')" 
					<?php if(!empty($s_tahun) && !empty($s_sijil)){ print 'disabled'; }?>>
					 <!-- onchange="set_spm('spm_tahun_1',this.value,'R')" -->
					<option value="0">Sila pilih tahun</option>
					<?php for($t=$tahun_2;$t>=$tahun_1;$t--){
						print '<option value="'.$t.'"'; 
						if($s_tahun==$t){ print 'selected'; }
						print '>'.$t.'</option>';
					} ?>
				</select>
				<input type="hidden" name="spm_tahun_pilih" value="<?=$s_tahun;?>">
			</div>
			<?php if($actions==1){ ?>
			<div class="col-sm-1"></div>
			<label for="nama" class="col-sm-2 control-label"><b>Pangkat <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
			<div class="col-sm-3">
				<select class="form-control" name="spm_pangkat_1" id="spm_pangkat_1" onchange="set_spm('spm_pangkat_1',this.value,'')" <?php if($s_tahun >= 2000 && $s_tahun <= 2022){ print 'readonly'; } ?>>
					<option value="0">Sila pilih pangkat</option>
					<?php while(!$rspangkat->EOF){ ?>
					<option value="<?=$rspangkat->fields['KOD'];?>" 
					<?php if($rspangkat->fields['DISKRIPSI']==$s_pangkat){ print 'selected';} ?>
					><?=$rspangkat->fields['DISKRIPSI'];?></option>
					<?php $rspangkat->movenext(); } ?>
				</select>
			</div>
			<?php } ?>
		</div>
	</div>
	<?php if($actions==1){ ?>
	<div class="form-group">
		<div class="row">
			<label for="nama" class="col-sm-4 control-label"><b>Ujian Lisan Bahasa Melayu/Bahasa Malaysia <div style="float:right">:</div></b></label>
			<div class="col-sm-3">
				<select class="form-control" id="spm_lisan_1" name="spm_lisan_1" onchange="set_spm('spm_lisan_1',this.value,'')" <?php if($s_tahun >= 2000 && $s_tahun <= 2022){ print 'readonly'; } ?>>
					<option value="">Sila pilih </option>
					<option value="L" <?php if($s_lisan=='L'){ print 'selected';} ?>>Lulus</option>
					<option value="G" <?php if($s_lisan=='G'){ print 'selected';} ?>>Gagal</option>
				</select>
			</div>
		</div>
	</div>
	<?php } ?>




	<?php //if(!empty($s_tahun)){ 
		$rsSRP = $conn->query("SELECT * FROM $schema1.`ref_matapelajaran` WHERE `TKT`='5' AND `SAH_YT`='Y' AND `GAB_YT`='T' AND `kod` NOT IN ('103')
			ORDER BY `DISKRIPSI`");
		if($s_tahun >= 1975 && $s_tahun <= 2008){
			$rsGred = $conn->query("SELECT * FROM $schema1.`ref_gred_matapelajaran` WHERE GRED BETWEEN 1 AND 9 AND `TKT`='5' ORDER BY `SUSUNAN`");
		} else {
			$rsGred = $conn->query("SELECT * FROM $schema1.`ref_gred_matapelajaran` WHERE GRED NOT BETWEEN 1 AND 9 AND `TKT`='5' ORDER BY `SUSUNAN`");
		}
	?>
	<hr>

	<div class="form-group">
		<div class="row">
			<div class="col-sm-8">
				<div class="row">
					<div class="col-sm-8 col-xs-8" style="padding-bottom:5px;text-align: center;"><b>MATAPELAJARAN</b></div>
					<div class="col-sm-4 col-xs-3" style="padding-bottom:5px;text-align: center;"><b>GRED</b></div>
					<div class="col-sm-4 col-xs-1" style="padding-bottom:5px;text-align: center;"><b></b></div>
				</div>
				<div class="row">
					<div class="col-sm-8 col-xs-8" style="padding-bottom:5px"><b>BAHASA MELAYU/BAHASA MALAYSIA <font color="#FF0000">*</font></b></div>
					<div class="col-sm-3 col-xs-3" style="padding-bottom:5px">
						<input type="hidden" name="mp_old[]" value="103">
						<input type="hidden" name="mp_1[]" id="mp_10" value="103">
						<select class="form-control" name="gred_1[]" id="gred_10">
							<option value="">Sila pilih gred</option>
							<?php 
							$result = get_spm_result($conn, $uid, "103", $s_tahun, "1");
							$datas='103';
							$rsGred->movefirst();
							while(!$rsGred->EOF){ ?>
							<option value="<?=$rsGred->fields['GRED'];?>" <?php if($result['gred']==$rsGred->fields['GRED']){ print 'selected'; } ?>><?=$rsGred->fields['GRED'];?></option>	
							<?php $rsGred->movenext(); } ?>
						</select>
					</div>
				</div>

				<?php 
				$bilr=1;
				if(!empty($s_tahun) && $s_tahun>=2013){ $bilr++;?>
				<div class="row" id=sejarah>
					<div class="col-sm-8 col-xs-8" style="padding-bottom:5px"><b>SEJARAH <font color="#FF0000">*</font></b></div>
					<div class="col-sm-3 col-xs-3" style="padding-bottom:5px">
						<input type="hidden" name="mp_old[]" value="249">
						<input type="hidden" name="mp_1[]" id="mp_1<?=$bilr;?>" value="249">
						<select class="form-control" name="gred_1[]" id="gred_11">
							<option value="">Sila pilih gred</option>
							<?php 
							$result = get_spm_result($conn, $uid, "249", $s_tahun, "1");
							$datas='249';
							$rsGred->movefirst();
							while(!$rsGred->EOF){ ?>
							<option value="<?=$rsGred->fields['GRED'];?>" <?php if($result['gred']==$rsGred->fields['GRED']){ print 'selected'; } ?>><?=$rsGred->fields['GRED'];?></option>	
							<?php $rsGred->movenext(); } ?>
						</select>
					</div>
				</div>
				<?php } else if(empty($s_tahun)){ ?>
				<div class="row" id=sejarah>
					<div class="col-sm-8 col-xs-8" style="padding-bottom:5px"><b>SEJARAH <font color="#FF0000">*</font></b></div>
					<div class="col-sm-3 col-xs-3" style="padding-bottom:5px">
						<input type="hidden" name="mp_old[]" value="249">
						<input type="hidden" name="mp_1[]" id="mp_1<?=$bilr;?>" value="249">
						<select class="form-control" name="gred_1[]" id="gred_11">
							<option value="">Sila pilih gred</option>
							<?php 
							$result = get_spm_result($conn, $uid, "249", $s_tahun, "1");
							$datas='249';
							$rsGred->movefirst();
							while(!$rsGred->EOF){ ?>
							<option value="<?=$rsGred->fields['GRED'];?>" <?php if($result['gred']==$rsGred->fields['GRED']){ print 'selected'; } ?>><?=$rsGred->fields['GRED'];?></option>	
							<?php $rsGred->movenext(); } ?>
						</select>
					</div>
				</div>
			<?php } ?>


				<?php  
				// $conn->debug=true;
				// print date("YmdHisN");
				if($s_tahun>=2013){
					$rsResult = $conn->query("SELECT * FROM $schema2.`calon_spm` WHERE `jenis_xm`='1' AND `id_pemohon`=".tosql($uid). " AND tahun=".tosql($s_tahun). " AND matapelajaran NOT IN ('103','249') ORDER BY `spm_id`");
				} else { 
					$rsResult = $conn->query("SELECT * FROM $schema2.`calon_spm` WHERE `jenis_xm`='1' AND `id_pemohon`=".tosql($uid). " AND tahun=".tosql($s_tahun). " AND matapelajaran NOT IN ('103') ORDER BY `spm_id`");
				}
				$conn->debug=false;
				while(!$rsResult->EOF){ 
					$datas.=",".$rsResult->fields['matapelajaran']; $bilr++; 
				?>								
				<div class="row">
					<div class="col-sm-8 col-xs-7" style="padding-bottom:5px">
						<input type="hidden" name="mp_old[]" value="<?=$rsResult->fields['matapelajaran'];?>">
						<select name="mp_1[]" id="mp_1<?=$bilr;?>" class="form-control select2 select2-accessible mps<?=$bilr;?>" style="width: 100%;" aria-hidden="true" 
							onchange="Geeks(this.value,<?=$bilr;?>)">
							<option value="">Sila pilih matapelajaran</option>
							<?php $rsSRP->movefirst();
							while(!$rsSRP->EOF){ ?>
							<option value="<?=$rsSRP->fields['kod'];?>"<?php if($rsSRP->fields['kod']==$rsResult->fields['matapelajaran']){ print ' selected'; } ?>><?=$rsSRP->fields['DISKRIPSI'];?></option>	
							<?php $rsSRP->movenext(); } ?>
						</select>
					</div>
					<div class="col-sm-3 col-xs-3" style="padding-bottom:5px">
						<select class="form-control" name="gred_1[]" id="gred_1<?=$bilr;?>">
							<option value="">Sila pilih gred</option>
							<?php $rsGred->movefirst();
							while(!$rsGred->EOF){ ?>
							<option value="<?=$rsGred->fields['GRED'];?>"<?php if($rsGred->fields['GRED']==$rsResult->fields['gred']){ print ' selected'; } ?>><?=$rsGred->fields['GRED'];?></option>	
							<?php $rsGred->movenext(); } ?>
						</select>
					</div>
					<div class="col-sm-1">
						<img src="../images/trash.png" title="Hapus maklumat matapelajaran & gred" style="cursor: pointer;" class="btn btn-danger" 
						height="35" onclick="do_hapus('akademik/sql_akademik.php?frm=SPM&pro=SPM_DEL_REC&sid=<?=$rsResult->fields['spm_id'];?>')">
						
					</div>
				</div>
				<?php $rsResult->movenext(); } ?>

				<?php for($i=$bilr+1;$i<=12;$i++){ ?>
				<div class="row">
					<div class="col-sm-8 col-xs-7" style="padding-bottom:5px">
						<input type="hidden" name="mp_old[]" value="">
						<select name="mp_1[]" id="mp_1<?=$i;?>" class="form-control select2 select2-accessible mps<?=$i;?>" style="width: 100%;" aria-hidden="true" 
							onchange="Geeks(this.value,<?=$i;?>)">
							<option value="">Sila pilih matapelajaran</option>
							<?php $rsSRP->movefirst();
							while(!$rsSRP->EOF){ ?>
							<option value="<?=$rsSRP->fields['kod'];?>"><?=$rsSRP->fields['DISKRIPSI'];?></option>	
							<?php $rsSRP->movenext(); } ?>
						</select>
					</div>
					<div class="col-sm-3 col-xs-3" style="padding-bottom:5px">
						<select class="form-control" name="gred_1[]" id="gred_1<?=$i;?>">
							<option value="">Sila pilih gred</option>
							<?php $rsGred->movefirst();
							while(!$rsGred->EOF){ ?>
							<option value="<?=$rsGred->fields['GRED'];?>"><?=$rsGred->fields['GRED'];?></option>	
							<?php $rsGred->movenext(); } ?>
						</select>
					</div>
				</div>
			<?php } ?>
			</div>
			<div class="col-sm-4" align="center">
				<h6><b>Sijil SPM/SPM(V)/SVM</b></h6>
				<img src="<?=$sijil;?>" width="300" height="400">
				<input type="file" name="file_pmr" id="file_pmr" class="form-control" value="" onchange="do_input()">
				<small style="color: red;">Hanya menerima format png,jpg,jpeg @ gif dan tidak melebihi 300kb</small>

			</div>

		</div>
			<div class="modal-footer" style="padding:0px;">
				<button type="button" id="simpan" class="btn btn-primary mt-sm mb-sm" onclick="save_spm(1)"><i class="fa fa-save"></i> Simpan</button>
				<?php if($actions==2){ ?>
				<?php	if(!empty($data['spm_tahun_1']) && !empty($data['spm_tahun_2'])){ ?>
						<label class="btn btn-danger" onclick="do_hapus_url('akademik/sql_akademik.php?frm=SPM&pro=SPM_DEL&tahun=<?=$s_tahun;?>&actions=<?=$actions;?>&id_pemohon=<?=$_SESSION['SESS_UID'];?>')">Hapus</label>
				<?php 	} ?>
				<?php } else if($actions==1 && empty($data['spm_tahun_2'])){ ?>
						<label class="btn btn-danger" onclick="do_hapus_url('akademik/sql_akademik.php?frm=SPM&pro=SPM_DEL&tahun=<?=$s_tahun;?>&actions=<?=$actions;?>&id_pemohon=<?=$_SESSION['SESS_UID'];?>')">Hapus</label>
				<?php } ?>
				<input type="hidden" name="progid" id="progid" value="<?php print $progid;?>" />
				<input type="hidden" name="proses" value="<?php print $proses;?>" />
				<input type="hidden" name="chk" id="chk" value="<?=$datas;?>">
			</div>
		</div>
	<?php //} ?>


	     

<script language="javascript" type="text/javascript">
var spm_tahun_1 = document.getElementById('spm_tahun_1').value;
// var srp_pangkat = document.getElementById('srp_pangkat');
// alert(spm_tahun_1);
if(spm_tahun_1>='2000'){
	spm_lisan_1.setAttribute('disabled', '');
	spm_pangkat_1.setAttribute('disabled', '');
} else {
	spm_lisan_1.removeAttribute('disabled');
	spm_pangkat_1.removeAttribute('disabled');
	// sejarah.removeAttribute('disabled');
}
</script>		 
