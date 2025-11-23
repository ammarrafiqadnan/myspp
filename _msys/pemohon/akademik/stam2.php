<?php if(!empty($tahun_stam2)){ ?>
<?php
// include 'akademik/sql_akademik.php';
// $data = get_pmr($conn,$_SESSION['SESSADM_UID']);
// print_r($data);
$uid = $data->fields['id_pemohon'];
$tahun = $data->fields['stam_tahun_2'];
$rssijil = $conn->query("SELECT * FROM $schema1.`ref_sijil` WHERE `TKT`='6' AND `kod` IN (5) ");
$rspangkat = $conn->query("SELECT * FROM $schema1.`ref_sijil_pangkat` WHERE `TKT`=6 ORDER BY `DISKRIPSI`");
$rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='STAM1' AND `id_pemohon`=".tosql($uid));
if(!empty($rsSijil->fields['sijil_nama'])){ $sijil = "/upload/".$uid."/".$rsSijil->fields['sijil_nama']; }

$rsResult = $conn->query("SELECT * FROM $schema2.`calon_stp_stam` WHERE `jenis_xm`='AT' AND `id_pemohon`=".tosql($uid). " AND tahun=".tosql($tahun));
?>
<small style="color: red;">
        Tarikh/masa kemas kini : 
        <?php
        if(!empty($rsResult->fields['d_kemaskini'])){
            print DisplayDate($rsResult->fields['d_kemaskini']);  print '&nbsp;&nbsp;'.DisplayMasa($rsResult->fields['d_kemaskini']);
        } else {
            print DisplayDate($rsResult->fields['d_cipta']);  print '&nbsp;&nbsp;'.DisplayMasa($rsResult->fields['d_cipta']);
        }
        ?>  <br>
    </small>

	<div class="form-group">
		<div class="row">
			<label for="nama" class="col-sm-1 control-label"><b>Tahun <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
			<div class="col-sm-2">
					<?php for($t=date("Y");$t>=1985;$t--){
						if($data->fields['stam_tahun_2']==$t){ print $t; }

					} ?>

			</div>
			<label for="nama" class="col-sm-1 control-label">&nbsp;</label>
			<label for="nama" class="col-sm-1 control-label"><b>Jenis Sijil <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
			<div class="col-sm-2">
					STAM
			</div>
			<div class="col-sm-1"></div>
			<label for="nama" class="col-sm-1 control-label"><b>Pangkat <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
			<div class="col-sm-2">
					<?php while(!$rspangkat->EOF){ ?>
					<?php if($rspangkat->fields['KOD']==$data->fields['stam_pangkat_2']){ print $rspangkat->fields['DISKRIPSI'];} ?>
					<?php $rspangkat->movenext(); } ?>
			</div>
		</div>
	</div>




	<?php 
	// $conn->debug=true;
	if(!empty($data->fields['stam_tahun_2'])){ 
	$rsSRP = $conn->query("SELECT * FROM $schema1.`ref_matapelajaran` WHERE `TKT`='6' AND `SAH_YT`='Y' AND `GAB_YT`='T'  
		ORDER BY `DISKRIPSI`");
	$rsGred = $conn->query("SELECT * FROM $schema1.`ref_gred_matapelajaran` WHERE `TKT`='6' AND `JENIS`='U' ORDER BY `SUSUNAN`");
	?>
	<hr>

	<div class="form-group">
		<div class="row">
			<div class="col-sm-8">
				
				<?php $bilr=0; //$conn->debug=true;
				
				//while(!$rsResult->EOF){  
					//$datas.=",".$rsResult->fields['matapelajaran']; $bilr++; 
				?>								
				<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                <thead  style="background-color:rgb(38, 167, 228)">
                    <th width="80%"><font color="#000000"><div>Matapelajaran</div></font></th>
                    <th width="20%"><font color="#000000"><div align="center">Gred</div></font></th>
                </thead>
                <tbody>
                    <?php 

                        while(!$rsResult->EOF){
			//$conn->debug=true;
                        $rsSTPM = $conn->query("SELECT DISKRIPSI FROM $schema1.`ref_matapelajaran` WHERE `TKT`='6' AND `SAH_YT`='Y' AND `GAB_YT`='T' AND kod=".tosql($rsResult->fields['matapelajaran'])." ORDER BY `DISKRIPSI`");
                    	//$rsSTPM = $conn->query("SELECT * FROM $schema1.`ref_gred_matapelajaran` WHERE `TKT`='6' AND `JENIS`='D' ORDER BY `SUSUNAN`");

			?>
                    <tr>
                        <td><?=$rsSTPM->fields['DISKRIPSI']?></td>
                        <td align="center"><?=$rsResult->fields['gred']?></td>
                    </tr>
                    <?php $rsResult->movenext(); } ?>
                </tbody>
            </table>

			<?php //} ?>
			</div>
			<div class="col-sm-4" align="center">
				<?php
				if(!empty($rsSijil->fields['sijil_nama'])){
					print '<h6><b>Sijil STAM</b></h6>';
					$sijil_pic = "/var/www/upload/".$uid."/".$rsSijil->fields['sijil_nama']; 

					if (file_exists($sijil_pic)){
     						$b64image = base64_encode(file_get_contents($sijil_pic));
     						$sijil = "data:image/png;base64,$b64image";
					}

				?>
				<img src="<?=$sijil;?>" width="300" height="400">
				<?php } ?>
			</div>

		</div>

		<!--<div class="modal-footer" style="padding:0px;">
			<button type="button" id="simpan" class="btn btn-primary mt-sm mb-sm" onclick="save_stpm(1)"><i class="fa fa-save"></i> Simpan</button>
			<input type="hidden" name="progid" id="progid" value="<?php print $progid;?>" />
			<input type="hidden" name="proses" value="<?php print $proses;?>" />
			<input type="hidden" name="chk" id="chk" value="<?=$datas;?>">
		</div>-->

	</div>
	<?php } ?>

<?php } else {
                        print '-- Tiada Maklumat --';
                }?>

	     

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
