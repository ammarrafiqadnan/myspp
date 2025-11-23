<?php
//$conn->debug=true;
//include '../_mapps/akademik/sql_akademik.php';
//$data = get_exam($conn,$data->fields['id_pemohon']);
$sql = "SELECT id_pemohon, spm_tahun_1, spm_jenis_sijil_1, spm_pangkat_1, spm_tahun_2, spm_jenis_sijil_2, spm_pangkat_2, spm_lisan_1, 
	stp_tahun_1, stp_jenis_1, stp_pangkat_1, stp_tahun_2, stp_jenis_2, stp_pangkat_2,   
	stam_tahun_1, stam_jenis_1, stam_pangkat_1, stam_tahun_2, stam_jenis_2, stam_pangkat_2    
	FROM $schema2.calon WHERE `id_pemohon`=".tosql($data->fields['id_pemohon']);
$dataExam = $conn->query($sql);

$uid=$data->fields['id_pemohon'];
// print_r($data);
$tahun_u = $dataExam->fields['spm_tahun_1'];

$rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='EXT' AND `id_pemohon`=".tosql($uid));
//if(empty($rsSijil->fields['sijil_nama'])){ $sijil="../upload_doc/PMR_Mock_Result_Statement_Certificate.png"; }
//else { $sijil = "/upload/".$uid."/".$rsSijil->fields['sijil_nama']; }

if(!empty($rsSijil->fields['sijil_nama'])){
	$sijil_pic = "/var/www/upload/".$uid."/".$rsSijil->fields['sijil_nama']; 
	if (file_exists($sijil_pic)){
		$b64image = base64_encode(file_get_contents($sijil_pic));
		$sijil = "data:image/png;base64,$b64image";
	}
}

//$conn->debug=true;

//$tahun = $data->fields['stp_tahun_1'];
//$rsSPMtambahan = get_spm_result($conn, $id_pemohon, $tahun_u);
//print $SPM_tambahan;

$conn->debug=false;
if($SPM_tambahan == ''){
	print 'Tiada maklumat yang disimpan';
} 

$rssijil = $conn->query("SELECT descripsi FROM $schema1.`ref_paper_julai` WHERE `sah_yt`='Y'");
$rsGred = $conn->query("SELECT * FROM $schema1.`ref_gred_matapelajaran` WHERE `TKT`='5' ORDER BY `SUSUNAN`");

$rsDatas = $conn->query("SELECT * FROM $schema2.`calon_spm` WHERE `jenis_xm`='T' AND `id_pemohon`=".tosql($uid));
?>
<br>
<small style="color: red;">
    <?php
    if(!empty($rsDatas->fields['d_kemaskini'])){
        print 'Tarikh/masa kemas kini : '.DisplayDate($rsDatas->fields['d_kemaskini']);  print '&nbsp;&nbsp;'.DisplayMasa($rsDatas->fields['d_kemaskini']);
    } else if(!empty($rsPMR->fields['d_cipta'])) {
        print 'Tarikh/masa kemas kini : '.DisplayDate($rsDatas->fields['d_cipta']);  print '&nbsp;&nbsp;'.DisplayMasa($rsDatas->fields['d_cipta']);
    } 
     if(!empty($rsSPMtambahan->fields['d_kemaskini'])){
  ?> <br> <?php } ?>
</small>


		<header class="panel-heading" style="background-color:rgb(38, 167, 228);">
			<h6 class="panel-title"><font color="#000000" size="3"><b>Maklumat Peperiksaan SPM Ulangan</b></font></h6>
		</header>
		<div class="panel-body">
			<div class="box-body">

			<input type="hidden" name="id_pemohon" id="id_pemohon" value="<?php print $uid;?>" readonly="readonly"/>

				<div class="col-md-12">
					<?php //$conn->debug=true;
					
					
					$cntt = 0;
					while(!$rsDatas->EOF){
						if($cntt==0){
							//print 'here';
							$mid1 = $rsDatas->fields['id_pemohon'];
							$tahun1 = $rsDatas->fields['tahun'];
							$mp1 = $rsDatas->fields['matapelajaran'];
							$gred1 = $rsDatas->fields['gred'];
							$bm1 = $rsDatas->fields['jenis_sijil'];
							$lisan1 = $rsDatas->fields['ujian_lisan'];

							$rssijil2 = $conn->query("SELECT descripsi FROM $schema1.`ref_paper_julai` WHERE `sah_yt`='Y' AND mpel_kod=$mp1");

							$subjek1 = $rssijil2->fields['descripsi'];
						} else if($cntt==1){
							$mid2 = $rsDatas->fields['id_pemohon'];
							$tahun2 = $rsDatas->fields['tahun'];
							$mp2 = $rsDatas->fields['matapelajaran'];
							$gred2 = $rsDatas->fields['gred'];
							$bm2 = $rsDatas->fields['jenis_sijil'];
							$lisan2 = $rsDatas->fields['ujian_lisan'];

							$rssijil2 = $conn->query("SELECT descripsi FROM $schema1.`ref_paper_julai` WHERE `sah_yt`='Y' AND mpel_kod=$mp2");

							$subjek2 = $rssijil2->fields['descripsi'];

						} else if($cntt==2){
							$mid3 = $rsDatas->fields['id_pemohon'];
							$tahun3 = $rsDatas->fields['tahun'];
							$mp3 = $rsDatas->fields['matapelajaran'];
							$gred3 = $rsDatas->fields['gred'];
							$bm3 = $rsDatas->fields['jenis_sijil'];
							$lisan3 = $rsDatas->fields['ujian_lisan'];

							$rssijil2 = $conn->query("SELECT descripsi FROM $schema1.`ref_paper_julai` WHERE `sah_yt`='Y' AND mpel_kod=$mp3");

							$subjek3 = $rssijil2->fields['descripsi'];

						} else if($cntt==3){
							$mid4 = $rsDatas->fields['id_pemohon'];
							$tahun4 = $rsDatas->fields['tahun'];
							$mp4 = $rsDatas->fields['matapelajaran'];
							$gred4 = $rsDatas->fields['gred'];
							$bm4 = $rsDatas->fields['jenis_sijil'];
							$lisan4 = $rsDatas->fields['ujian_lisan'];

							$rssijil2 = $conn->query("SELECT descripsi FROM $schema1.`ref_paper_julai` WHERE `sah_yt`='Y' AND mpel_kod=$mp4");

							$subjek4 = $rssijil2->fields['descripsi'];

						}
						$cntt++;
						$rsDatas->movenext();
					}
					//print 'here'.$tahun1.'//'.$mp1;
					if(!empty($tahun1) && !empty($gred1)){
					?>
					<div class="form-group">
						<div class="row">
							<div class="col-sm-8">
								<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
									<thead  style="background-color:rgb(38, 167, 228)">
										<tr>
											<th width="10%">TAHUN</th>
											<th width="80%">MATAPELAJARAN</th>
											<th width="10%">GRED</th>
										</tr>
									</thead>
									<tbody>

										<?//=$tahun1;?>
										<?php if(!empty($tahun1)){ //print 'aaaa'.$mp1.'bbbbb'.$rssijil->fields['mpel_kod']; ?>
										<tr>
											<td><?=$tahun1;?></td>
											<td><?php if($mp1==$rssijil->fields['mpel_kod']){ print $rssijil->fields['descripsi']; } else { print $subjek1;} ?><br>
												<?php if($bm1=='1'){ print '<b>Jenis :</b> Bahasa Melayu Kertas Julai / SPM Ulangan'; } ?>
													<?php if($bm1=='3'){ print 'Bahasa Melayu di Peringkat STPM/STAM'; } ?><br>
												<?php if($lisan1=='L'){ print '<b>Ujian Lisan :</b> Lulus'; } ?>
														<?php if($lisan1=='G'){ print 'Gagal'; } ?>

											</td>
											<td align="center"><?php print $gred1; ?></td>
										</tr>
										<?php } 
										if(!empty($tahun2) && !empty($gred2)){ ?>
										<tr>
											<td>
												<?php for($tahun=date("Y");$tahun>$tahun_u;$tahun--){ ?>
													<?php if($tahun2==$tahun){ print $tahun; } ?>
												<?php } ?>

											</td>
											<td><?php
												$rssijil2 = $conn->query("SELECT * FROM $schema1.`ref_paper_julai` WHERE `sah_yt`='Y' AND mpel_kod=".$mp2.""); 
												print $rssijil2->fields['descripsi']; ?><br>
												 <?php if($bm2=='1'){ print '<b>Jenis :</b> Bahasa Melayu Kertas Julai / SPM Ulangan'; } ?>
													<?php if($bm2=='3'){ print '<b>Jenis :</b> Bahasa Melayu di Peringkat STPM/STAM'; } ?><br>
												 <?php if($lisan2=='L'){ print '<b>Ujian Lisan :</b> Lulus'; } ?>
														<?php if($lisan2=='G'){ print '<b>Ujian Lisan :</b> Gagal'; } ?>

											</td>
											<td align="center"><?php print $gred2; ?></td>
										</tr>
										<?php }
										if(!empty($tahun3)){ ?>
										<tr>
											<td><?=$tahun3;?></td>
											<td><?php $rssijil3 = $conn->query("SELECT * FROM $schema1.`ref_paper_julai` WHERE `sah_yt`='Y' AND mpel_kod=".$mp3.""); 
												print $rssijil3->fields['descripsi']; ?><br>
												<?php if($bm3=='1'){ print '<b>Jenis :</b> Bahasa Melayu Kertas Julai / SPM Ulangan'; } ?>
													<?php if($bm3=='3'){ print '<b>Jenis :</b> Bahasa Melayu di Peringkat STPM/STAM'; } ?><br>
												 <?php if($lisan3=='L'){ print '<b>Ujian Lisan :</b> Lulus'; } ?>
														<?php if($lisan3=='G'){ print '<b>Ujian Lisan :</b> Gagal'; } ?>

											</td>
											<td align="center"><?php print $gred3; ?></td>
										</tr>
										<?php } 
										if(!empty($tahun4)){ ?>
										<tr>
											<td><?=$tahun4;?></td>
											<td><?php $rssijil4 = $conn->query("SELECT * FROM $schema1.`ref_paper_julai` WHERE `sah_yt`='Y' AND mpel_kod=".$mp4.""); 
												print $rssijil4->fields['descripsi']; ?><br>
												?><br>
												<?php if($bm4=='1'){ print '<b>Jenis :</b> Bahasa Melayu Kertas Julai / SPM Ulangan'; } ?>
													<?php if($bm4=='3'){ print '<b>Jenis :</b> Bahasa Melayu di Peringkat STPM/STAM'; } ?><br>
												 <?php if($lisan4=='L'){ print '<b>Ujian Lisan :</b> Lulus'; } ?>
														<?php if($lisan4=='G'){ print '<b>Ujian Lisan :</b> Gagal'; } ?>

											</td>
											<td align="center"><?php print $gred4; ?></td>
										</tr>
										<?php } 
										 ?>
									</tbody>

								</table>
							</div>
							<?php
							// $conn->debug=true;
							$rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='ULANG' AND `id_pemohon`=".tosql($uid));
							if(!empty($rsSijil->fields['sijil_nama'])){
								print '<h6><b>Sijil SPM Ulangan</b></h6>'; 
								$sijil1 = "/upload/".$uid."/".$rsSijil->fields['sijil_nama']; }


							// print $sijil1;
							?>
							<div class="col-sm-4" align="center">
								<?php if(!empty($rsSijil->fields['sijil_nama'])){  ?>
								<img src="<?=$sijil1;?>" width="300" height="350">
								<?php } ?>
							</div>
						</div>
					</div>
				<?php
					 } else {
                        		print '-- Tiada Maklumat --';
                    			} 

				?>
				</div>

			
			</div>
		</div>
	     
	     
<!--<div class="form-group">
	    	<div class="row">
                	<div class="col-md-12">
                    		<a type="button" class="btn btn-success" href="index.php?data=<?php print base64_encode('pemohon/senarai_pemohon;Senarai Pemohon;;;;;'); ?>"><i class="fa fa-arrow-left" style="margin:0px;"></i> Kembali</a>
                	</div>
		</div>
            </div>-->
<?php if($mp1=="101"){ ?>
<script language="javascript" type="text/javascript">
	document.getElementById("tambahan1").style.display = "block";
</script>
<?php } else { ?>
<script language="javascript" type="text/javascript">
	document.getElementById("tambahan1").style.display = "none";
</script>
<?php } ?>

<?php if($mp2=="101"){ ?>
<script language="javascript" type="text/javascript">
	document.getElementById("tambahan2").style.display = "block";
</script>
<?php } else { ?>
<script language="javascript" type="text/javascript">
	document.getElementById("tambahan2").style.display = "none";
</script>
<?php } ?>

<?php if($mp3=="101"){ ?>
<script language="javascript" type="text/javascript">
	document.getElementById("tambahan3").style.display = "block";
</script>
<?php } else { ?>
<script language="javascript" type="text/javascript">
	document.getElementById("tambahan3").style.display = "none";
</script>
<?php } ?>

<?php if($mp4=="101"){ ?>
<script language="javascript" type="text/javascript">
	document.getElementById("tambahan4").style.display = "block";
</script>
<?php } else { ?>
<script language="javascript" type="text/javascript">
	document.getElementById("tambahan4").style.display = "none";
</script>
<?php } ?>

