<?php //include '../connection/common.php'; ?>
<?php
// include 'akademik/sql_akademik.php';
// $data = get_pmr($conn,$_SESSION['SESS_UID']);
// print_r($data);
$uid = $data['id_pemohon'];
$tahun = $data['spm_tahun_1'];
$rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='SPM1' AND `id_pemohon`=".tosql($uid));
if(empty($rsSijil->fields['sijil_nama'])){ $sijil="../upload_doc/PMR_Mock_Result_Statement_Certificate.png"; }
else { $sijil = "../uploads_doc/".$uid."/".$rsSijil->fields['sijil_nama']; }
?>

	<div class="form-group">
		<div class="row">
			<label for="nama" class="col-sm-2 control-label"><b>Tahun <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
			<div class="col-sm-3">
				<select name="spm_tahun_1" id="spm_tahun_1" class="form-control" onchange="set_spm('spm_tahun_1',this.value,'R')">
					<option value="">Sila pilih tahun</option>
					<?php for($t=date("Y");$t>=1985;$t--){
						print '<option value="'.$t.'"'; 
						if($data['spm_tahun_1']==$t){ print 'selected'; }
						print '>'.$t.'</option>';
					} ?>
				</select>
			</div>
		</div>
	</div>
	<?php 
	$rssijil = $conn->query("SELECT * FROM $schema1.`ref_sijil` WHERE `TKT`='5'");
	$rspangkat = $conn->query("SELECT * FROM $schema1.`ref_sijil_pangkat` WHERE `TKT`=5 ORDER BY `DISKRIPSI`");
	?>
	<div class="form-group">
		<div class="row">
			<label for="nama" class="col-sm-2 control-label"><b>Jenis Sijil <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
			<div class="col-sm-4">
				<select class="form-control" id="spm_jenis_sijil_1" name="spm_jenis_sijil_1" onchange="set_spm('spm_jenis_sijil_1',this.value,'')">
					<option value="">Sila pilih jenis sijil</option>
					<?php while(!$rssijil->EOF){ ?>
					<option value="<?=$rssijil->fields['KOD'];?>" 
					<?php if($rssijil->fields['KOD']==$data['spm_jenis_sijil_1']){ print 'selected';} ?>	
					><?=$rssijil->fields['DISKRIPSI'];?></option>
					<?php $rssijil->movenext(); } ?>
				</select>
			</div>
			<div class="col-sm-1"></div>
			<label for="nama" class="col-sm-2 control-label"><b>Pangkat <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
			<div class="col-sm-3">
				<select class="form-control" name="spm_pangkat_1" id="spm_pangkat_1" onchange="set_spm('spm_pangkat_1',this.value,'')">
					<option value="">Sila pilih pangkat</option>
					<?php while(!$rspangkat->EOF){ ?>
					<option value="<?=$rspangkat->fields['KOD'];?>" 
					<?php if($rspangkat->fields['DISKRIPSI']==$data['spm_pangkat_1']){ print 'selected';} ?>
					><?=$rspangkat->fields['DISKRIPSI'];?></option>
					<?php $rspangkat->movenext(); } ?>
				</select>
			</div>
		</div>
	</div>

	<div class="form-group">
		<div class="row">
			<label for="nama" class="col-sm-4 control-label"><b>Ujian Lisan Bahasa Melayu/Bahasa Malaysia <div style="float:right">:</div></b></label>
			<div class="col-sm-3">
				<select class="form-control" id="spm_lisan_1" name="spm_lisan_1" onchange="set_spm('spm_lisan_1',this.value,'')">
					<option value="">Sila pilih </option>
					<option value="L" <?php if($data['spm_lisan_1']=='L'){ print 'selected';} ?>>Lulus</option>
					<option value="G" <?php if($data['spm_lisan_1']=='G'){ print 'selected';} ?>>Gagal</option>
				</select>
			</div>
		</div>
	</div>




	<?php if(!empty($data['spm_tahun_1'])){ 
		$rsSRP = $conn->query("SELECT * FROM $schema1.`ref_matapelajaran` WHERE `TKT`='5' AND `SAH_YT`='Y' AND `GAB_YT`='T' AND `kod` NOT IN ('103')
			ORDER BY `DISKRIPSI`");
		$rsGred = $conn->query("SELECT * FROM $schema1.`ref_gred_matapelajaran` WHERE `TKT`='5' 
			ORDER BY `SUSUNAN`");
	?>
	<hr>

	<div class="form-group">
		<div class="row">
			<div class="col-sm-8">
				<div class="row">
					<div class="col-sm-8 col-xm-8" style="padding-bottom:5px"><b>BAHASA MELAYU/BAHASA MALAYSIA</b></div>
					<div class="col-sm-4 col-xm-4" style="padding-bottom:5px">
						<input type="hidden" name="mp_1[]" id="mp_1[]" value="103">
						<select class="form-control" name="gred_1[]">
							<option value="">Sila pilih gred</option>
							<?php 
							$result = get_spm_result($conn, $uid, "103", $tahun, "1");
							$rsGred->movefirst();
							while(!$rsGred->EOF){ ?>
							<option value="<?=$rsGred->fields['GRED'];?>" <?php if($result['gred']==$rsGred->fields['GRED']){ print 'selected'; } ?>><?=$rsGred->fields['GRED'];?></option>	
							<?php $rsGred->movenext(); } ?>
						</select>
					</div>
				</div>

				<?php $bilr=0; //$conn->debug=true;
				$rsResult = $conn->query("SELECT * FROM $schema2.`calon_spm` WHERE `jenis_xm`='1' AND `id_pemohon`=".tosql($uid). " AND tahun=".tosql($tahun). " AND matapelajaran NOT IN ('002')");
				while(!$rsResult->EOF){ $bilr++; ?>								
				<div class="row">
					<div class="col-sm-8" style="padding-bottom:5px">
						<select class="form-control" name="mp_1[]" id="mp_1[]">
							<option value="">Sila pilih matapelajaran</option>
							<?php $rsSRP->movefirst();
							while(!$rsSRP->EOF){ ?>
							<option value="<?=$rsSRP->fields['kod'];?>"<?php if($rsSRP->fields['kod']==$rsResult->fields['matapelajaran']){ print ' selected'; } ?>><?=$rsSRP->fields['DISKRIPSI'];?></option>	
							<?php $rsSRP->movenext(); } ?>
						</select>
					</div>
					<div class="col-sm-4" style="padding-bottom:5px">
						<select class="form-control" name="gred_1[]" id="gred_1[]">
							<option value="">Sila pilih gred</option>
							<?php $rsGred->movefirst();
							while(!$rsGred->EOF){ ?>
							<option value="<?=$rsGred->fields['GRED'];?>"<?php if($rsGred->fields['GRED']==$rsResult->fields['gred']){ print ' selected'; } ?>><?=$rsGred->fields['GRED'];?></option>	
							<?php $rsGred->movenext(); } ?>
						</select>
					</div>
				</div>
				<?php $rsResult->movenext(); } ?>

				<?php for($i=$bilr;$i<=9;$i++){ ?>
				<div class="row">
					<div class="col-sm-8" style="padding-bottom:5px">
						<select class="form-control" name="mp_1[]" id="mp_1[]">
							<option value="">Sila pilih matapelajaran</option>
							<?php $rsSRP->movefirst();
							while(!$rsSRP->EOF){ ?>
							<option value="<?=$rsSRP->fields['kod'];?>"><?=$rsSRP->fields['DISKRIPSI'];?></option>	
							<?php $rsSRP->movenext(); } ?>
						</select>
					</div>
					<div class="col-sm-4" style="padding-bottom:5px">
						<select class="form-control" name="gred_1[]" id="gred_1[]">
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
				<img src="<?=$sijil;?>" width="300" height="400">
				<input type="file" name="file_pmr" id="file_pmr" class="form-control">
			</div>

		</div>
			<div class="modal-footer" style="padding:0px;">
				<button type="button" id="simpan" class="btn btn-primary mt-sm mb-sm" onclick="save_spm(1)"><i class="fa fa-save"></i> Simpan</button>
				<input type="hidden" name="progid" id="progid" value="<?php print $progid;?>" />
				<input type="hidden" name="proses" value="<?php print $proses;?>" />
			</div>
		</div>
	<?php } ?>


	     

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
