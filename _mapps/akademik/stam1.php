<?php
// include 'akademik/sql_akademik.php';
// $data = get_pmr($conn,$_SESSION['SESS_UID']);
// print_r($data);
$uid = $data['id_pemohon'];
$tahun = $data['stam_tahun_1'];
$tahun2 = $data['stam_tahun_2'];
$rssijil = $conn->query("SELECT * FROM $schema1.`ref_sijil` WHERE `TKT`='6' AND `kod` IN (5) ");
$rspangkat = $conn->query("SELECT * FROM $schema1.`ref_sijil_pangkat` WHERE `TKT`=6 ORDER BY `DISKRIPSI`");

// $rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='STAM1' AND `id_pemohon`=".tosql($uid));
// if(empty($rsSijil->fields['sijil_nama'])){ $sijil="../upload_doc/PMR_Mock_Result_Statement_Certificate.png"; }
// else { $sijil = "../uploads_doc/".$uid."/".$rsSijil->fields['sijil_nama']; }

if($actions==1){ 
	$rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='STAM1' AND `id_pemohon`=".tosql($uid));
	$ins_tahun = 'stam_tahun_1';
	$ins_sijil = 'stAm_jenis_1';
	$jxm='A';
} else if($actions==2){
	$rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='STAM2' AND `id_pemohon`=".tosql($uid));
	$ins_tahun = 'stam_tahun_2';
	$ins_sijil = 'stam_jenis_2';
	$jxm='AT';
}
// if(empty($rsSijil->fields['sijil_nama'])){ $sijil="../upload_doc/stam.png"; }
// else { $sijil = "/upload/".$uid."/".$rsSijil->fields['sijil_nama']; }

if(empty($rsSijil->fields['sijil_nama'])){ $sijil_pic1 ="/var/www/html/myspp/upload_doc/stam.png"; }
else { $sijil_pic1 = "/var/www/upload/".$uid."/".$rsSijil->fields['sijil_nama']; }
	//print $sijil;
if (file_exists($sijil_pic1)){
		$b64image = base64_encode(file_get_contents($sijil_pic1));
		$sijil = "data:image/png;base64,$b64image";
}

?>

	<input type="hidden" name="stam_tahun_pilih" value="<?=$s_tahun;?>">
	<input type="hidden" name="stam_sijil_pilih" value="<?=$s_sijil;?>">
	<input type="hidden" name="stam_pangkat_pilih" value="<?=$s_pangkat;?>">
	<div class="form-group">
		<div class="row">
			<label for="nama" class="col-sm-1 control-label"><b>Tahun <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
			<div class="col-sm-2">
				<select name="stam_tahun_1" id="stam_tahun_1" class="form-control" onchange="set_stpm('','','')"
					<?php if(!empty($s_tahun) && !empty($s_sijil) && !empty($s_pangkat)){ print 'disabled'; }?>>
					<option value="">Sila pilih tahun</option>
					<?php for($t=$tahun_2;$t>=$tahun_1;$t--){
						print '<option value="'.$t.'"'; 
						if($s_tahun==$t){ print 'selected'; }
						print '>'.$t.'</option>';
					} ?>
				</select>
			</div>
			<label for="nama" class="col-sm-1 control-label">&nbsp;</label>
			<label for="nama" class="col-sm-1 control-label"><b>Jenis Sijil <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
			<div class="col-sm-2">
				<select class="form-control" id="stam_jenis_1" name="stam_jenis_1" onchange="set_stpm('','','')"
					<?php if(!empty($s_tahun) && !empty($s_sijil) && !empty($s_pangkat)){ print 'disabled'; }?>>
					<!-- <option value="">Sila pilih jenis sijil</option> -->
					<?php while(!$rssijil->EOF){ ?>
					<option value="<?=$rssijil->fields['KOD'];?>" 
					<?php if($rssijil->fields['KOD']==$s_sijil){ print 'selected';} ?>	
					><?=$rssijil->fields['DISKRIPSI'];?></option>
					<?php $rssijil->movenext(); } ?>
				</select>
			</div>
			<div class="col-sm-1"></div>
			<label for="nama" class="col-sm-1 control-label"><b>Pangkat <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
			<div class="col-sm-2">
				<select class="form-control" name="stam_pangkat_1" id="stam_pangkat_1" onchange="set_stpm('','','')"
					<?php if(!empty($s_tahun) && !empty($s_sijil) && !empty($s_pangkat)){ print 'disabled'; }?>>
					<option value="">Sila pilih pangkat</option>
					<?php while(!$rspangkat->EOF){ ?>
					<option value="<?=$rspangkat->fields['KOD'];?>" 
					<?php if($rspangkat->fields['KOD']==$s_pangkat){ print 'selected';} ?>
					><?=$rspangkat->fields['DISKRIPSI'];?></option>
					<?php $rspangkat->movenext(); } ?>
				</select>
			</div>
		</div>
		<!-- <?php if(empty($data['stam_tahun_1'])){ ?>
		<div class="row">
			<div class="col-sm-12">
				<i style="color: #f00;">Maklumat pengajian akan dipaparkan setelah pengguna memilih tahun peperiksaan.</i>
			</div>
		</div>
		<?php } ?> -->
	</div>




	<?php 
	// $conn->debug=true;
	//if(!empty($data['stam_tahun_1'])){ 
	$rsSRP = $conn->query("SELECT * FROM $schema1.`ref_matapelajaran` WHERE `TKT`='6' AND `SAH_YT`='Y' AND `GAB_YT`='T'  
		ORDER BY `DISKRIPSI`");
	$rsGred = $conn->query("SELECT * FROM $schema1.`ref_gred_matapelajaran` WHERE `TKT`='6' AND `JENIS`='U' ORDER BY `SUSUNAN`");
	?>
	<hr>

	<div class="form-group">
		<div class="row">
			<div class="col-sm-8">
				<div class="row">
					<div class="col-sm-7 col-xs-7" style="padding-bottom:5px;text-align: center;"><b>MATAPELAJARAN</b></div>
					<div class="col-sm-3 col-xs-3" style="padding-bottom:5px;text-align: center;"><b>GRED</b></div>
					<div class="col-sm-1 col-xs-1" style="padding-bottom:5px;text-align: center;"><b></b></div>
				</div>

				
				<?php $bilr=0; //$conn->debug=true;
				if($actions==1){
					$rsResult = $conn->query("SELECT * FROM $schema2.`calon_stp_stam` WHERE `jenis_xm`='A' AND `id_pemohon`=".tosql($uid). " AND tahun=".tosql($tahun)." ORDER BY stp_id");
				} else {
					$rsResult = $conn->query("SELECT * FROM $schema2.`calon_stp_stam` WHERE `jenis_xm`='AT' AND `id_pemohon`=".tosql($uid). " AND tahun=".tosql($tahun2)." ORDER BY stp_id");
				}
				while(!$rsResult->EOF){  
					if($bilr==0){ $datas=$rsResult->fields['matapelajaran']; }
					else { $datas.=",".$rsResult->fields['matapelajaran']; }
					$bilr++; 
				?>								
				<div class="row">
					<div class="col-sm-7" style="padding-bottom:5px">
						<input type="hidden" name="mp_old[]" value="<?=$rsResult->fields['matapelajaran'];?>">
						<select name="mp_1[]" id="mp_1<?=$bilr;?>" class="form-control select2 select2-accessible mps<?=$bilr;?>" style="width: 100%;" aria-hidden="true" 
							onchange="Geeks(this.value,<?=$i;?>)">
							<option value="">Sila pilih matapelajaran</option>
							<?php $rsSRP->movefirst();
							while(!$rsSRP->EOF){ ?>
							<option value="<?=$rsSRP->fields['kod'];?>"<?php if($rsSRP->fields['kod']==$rsResult->fields['matapelajaran']){ print ' selected'; } ?>><?=$rsSRP->fields['DISKRIPSI'];?></option>	
							<?php $rsSRP->movenext(); } ?>
						</select>
					</div>
					<div class="col-sm-4" style="padding-bottom:5px">
						<select class="form-control" name="gred_1[]" id="gred_1<?=$bilr;?>">
							<option value="">Sila pilih gred</option>
							<?php $rsGred->movefirst();
							while(!$rsGred->EOF){ ?>
							<option value="<?=$rsGred->fields['GRED'];?>"<?php if(strtoupper($rsGred->fields['GRED'])==$rsResult->fields['gred']){ print ' selected'; } ?>><?=strtoupper($rsGred->fields['GRED']);?></option>	
							<?php $rsGred->movenext(); } ?>
						</select>
					</div>
					<div class="col-sm-1">
						<img src="../images/trash.png" title="Hapus maklumat matapelajaran & gred" style="cursor: pointer;"  
						height="30" onclick="do_hapus('akademik/sql_akademik.php?frm=STAM&pro=STAM_DEL_REC&sid=<?=$rsResult->fields['stp_id'];?>&id_pemohon=<?=$_SESSION['SESS_UID'];?>')">
						
					</div>
	
				</div>
				<?php $rsResult->movenext(); } ?>

				<?php for($i=$bilr+1;$i<=6;$i++){ ?>
				<div class="row">
					<div class="col-sm-7" style="padding-bottom:5px">
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
					<div class="col-sm-4" style="padding-bottom:5px">
						<select class="form-control" name="gred_1[]" id="gred_1<?=$i;?>">
							<option value="">Sila pilih gred</option>
							<?php $rsGred->movefirst();
							while(!$rsGred->EOF){ ?>
							<option value="<?=$rsGred->fields['GRED'];?>"><?=strtoupper($rsGred->fields['GRED']);?></option>	
							<?php $rsGred->movenext(); } ?>
						</select>
					</div>
				</div>
			<?php } ?>
			</div>
			<?php
				$sql = "SELECT COUNT(*) as total FROM $schema2.`kawalan_muatnaik_dokumen` WHERE is_deleted=0 AND `status`=0"; 
				$sql .=" AND tajuk_dokumen LIKE '%KEPUTUSAN STAM%'" ;
				$rsDoc = $conn->query($sql);
			?>
			<?php if($rsDoc->fields['total'] > 0){ ?>

			<div class="col-sm-4" align="center" style="border: 2px solid black; padding: 10px; border-radius: 25px;">
				<h6><b>Sijil STAM</b></h6>
				<img src="<?=$sijil;?>" width="100%" height="400">
				<?php print $rsSijil->fields['sijil_nama'];?><br>
				<input type="file" name="file_pmr" id="file_pmr" class="form-control" onchange="do_input()" value="">
				<small style="color: red;">Hanya menerima format png,jpg,jpeg @ gif dan tidak melebihi 300kb</small>
			</div>
			<?php } ?>

		</div>

		<div class="modal-footer" style="padding:0px;">
			<button type="button" id="simpan" class="btn btn-primary mt-sm mb-sm" onclick="save_stpm(1)"><i class="fa fa-save"></i> Simpan</button>
				<?php if($actions==2){ ?>
				<?php	if(!empty($data['stam_tahun_1']) && !empty($data['stam_tahun_2'])){ ?>
						<label class="btn btn-danger" onclick="do_hapus_url('akademik/sql_akademik.php?frm=STAM&pro=STAM_DEL&tahun=<?=$s_tahun;?>&actions=<?=$actions;?>&id_pemohon=<?=$_SESSION['SESS_UID'];?>')">Hapus</label>
				<?php 	} ?>
				<?php } else if($actions==1 && empty($data['stam_tahun_2'])){ ?>
						<label class="btn btn-danger" onclick="do_hapus_url('akademik/sql_akademik.php?frm=STAM&pro=STAM_DEL&tahun=<?=$s_tahun;?>&actions=<?=$actions;?>&id_pemohon=<?=$_SESSION['SESS_UID'];?>')">Hapus</label>
				<?php } ?>
			<input type="hidden" name="progid" id="progid" value="<?php print $progid;?>" />
			<input type="hidden" name="proses" value="<?php print $proses;?>" />
			<input type="hidden" name="chk" id="chk" value="<?=$datas;?>">
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
