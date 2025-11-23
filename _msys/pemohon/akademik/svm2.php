<?php //include '../connection/common.php'; ?>
<?php
 //$conn->debug=true;
$uid = $data->fields['id_pemohon'];


$rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='SVM2' AND `id_pemohon`=".tosql($uid));
//if(empty($rsSijil->fields['sijil_nama'])){ $sijil="../upload_doc/svm.jpg"; }
//else { $sijil = "/upload/".$uid."/".$rsSijil->fields['sijil_nama']; }

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

$s_sijil = $data->fields['spm_jenis_sijil_2'];
$s_tahun = $data->fields['spm_tahun_2'];
$s_pangkat = $data->fields['spm_pangkat_2'];
$s_lisan = $data->fields['spm_lisan_2'];
$tahun_1 = $data->fields['spm_tahun_1']+1;
$tahun_2 = $data->fields['spm_tahun_1']+3;

if($tahun_1==date("Y")){
	$tahun_2=$tahun_1;
}


?>
<?php
	$rsData = $conn->query("SELECT * FROM $schema2.`calon_svm` WHERE `id_pemohon`=".tosql($uid) ." AND `tahun`=".tosql($s_tahun));
?>
	
<small style="color: red;">
    Tarikh/masa kemas kini : 
    <?php 
    if(!empty($rsData->fields['updated_dt'])){ //print 'here';
        print DisplayDate($rsData->fields['create_dt']);  print '&nbsp;&nbsp;'.DisplayMasa($rsData->fields['updated_dt']);
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
							} else { print dlookup("$schema1.`ref_sijil_svm`","DISKRIPSI","KOD=".tosql($rsData->fields['nama_sijil'])); }?>

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


		 
