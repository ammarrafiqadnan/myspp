<?php
$rsSijil = $conn->query("SELECT * FROM $schema2.`calon_sijil` WHERE `jenis_sijil`='EXT' AND `id_pemohon`=".tosql($uid));
if(empty($rsSijil->fields['sijil_nama'])){ $sijil="../upload_doc/PMR_Mock_Result_Statement_Certificate.png"; }
else { $sijil = "../uploads_doc/".$uid."/".$rsSijil->fields['sijil_nama']; }
?>

		<header class="panel-heading"  style="background-color:rgb(209 29 29)">
			<h6 class="panel-title"><font color="#000000" size="3"><b><?php print strtoupper($menu);?></b></font></h6>
		</header>
		<div class="panel-body">
			<div class="box-body">

			<input type="hidden" name="pemantauan_id" id="pemantauan_id" value="<?php print $id;?>" readonly="readonly"/>

				<div class="col-md-12">

					<?php include 'biodata/biodata_view.php'; ?>

					<div class="form-group">
						<div class="row">
							<p>
							  <button class="btn btn-primary form-control" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" title="Sila klik untuk membaca arahan berkaitan kemasukan data akademik SPM">
							    ARAHAN:
							  </button>
							</p>
						<div class="collapse" id="collapseExample">
						  <div class="card card-body">
								<label for="nama" class="col-sm-12 control-label"><b>ARAHAN : Sila Masukkan maklumat pepriksaan tambahan</b>
									<ul>
									<li>Peperiksaan Bahasa Melayu, Matematik, Sejarah bagi Peperiksaan Julai sahaja</li>
									</ul>
								</label>

						  </div>
						</div>

					</div>
					<hr>
					<?php 
					$rssijil = $conn->query("SELECT * FROM $schema1.`ref_matapelajaran` WHERE `TKT`='5' AND `kod` IN ('103','249','T02')");
	
					?>
					<div class="form-group">
						<div class="row">
							<div class="col-sm-8">
								
								<div class="row">
									<div class="col-sm-2" style="padding-bottom:5px">
										<select class="form-control" name="tahun1" id="tahun1">
											<option>Sila pilih tahun</option>
											<?php for($tahun=date("Y");$tahun>=1985;$tahun--){ ?>
											<option value="<?=$tahun;?>" <?php if($tahun1==$tahun){ print 'selected'; }?>><?=$tahun;?></option>
											<?php } ?>
										</select>
									</div>
									<div class="col-sm-6" style="padding-bottom:5px">
										<select class="form-control" name="mp1" id="mp1">
											<option>Sila pilih matapelajaran</option>
											<?php $rssijil->movefirst();
											while(!$rssijil->EOF){ ?>
											<option value="<?=$rssijil->fields['kod'];?>" <?php if($mp1==$rssijil->fields['kod']){ print 'selected'; }?>><?=$rssijil->fields['DISKRIPSI'];?></option>
											<?php $rssijil->movenext(); } ?>
										</select>
									</div>
									<div class="col-sm-4" style="padding-bottom:5px">
										<select class="form-control" name="gred1" id="gred1">
											<option>Sila pilih gred</option>
											<?php for($bil=1;$bil<=9;$bil++){ ?>
											<option value="<?=$bil;?>" <?php if($gred1==$bil){ print 'selected'; }?>><?=$bil;?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								
								<div class="row">
									<div class="col-sm-2" style="padding-bottom:5px">
										<select class="form-control" name="tahun1" id="tahun1">
											<option>Sila pilih tahun</option>
											<?php for($tahun=date("Y");$tahun>=1985;$tahun--){ ?>
											<option value="<?=$tahun;?>" <?php if($tahun1==$tahun){ print 'selected'; }?>><?=$tahun;?></option>
											<?php } ?>
										</select>
									</div>
									<div class="col-sm-6" style="padding-bottom:5px">
										<select class="form-control" name="mp1" id="mp1">
											<option>Sila pilih matapelajaran</option>
											<?php $rssijil->movefirst();
											while(!$rssijil->EOF){ ?>
											<option value="<?=$rssijil->fields['kod'];?>" <?php if($mp1==$rssijil->fields['kod']){ print 'selected'; }?>><?=$rssijil->fields['DISKRIPSI'];?></option>
											<?php $rssijil->movenext(); } ?>
										</select>
									</div>
									<div class="col-sm-4" style="padding-bottom:5px">
										<select class="form-control" name="gred1" id="gred1">
											<option>Sila pilih gred</option>
											<?php for($bil=1;$bil<=9;$bil++){ ?>
											<option value="<?=$bil;?>" <?php if($gred1==$bil){ print 'selected'; }?>><?=$bil;?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								
								<div class="row">
									<div class="col-sm-2" style="padding-bottom:5px">
										<select class="form-control" name="tahun1" id="tahun1">
											<option>Sila pilih tahun</option>
											<?php for($tahun=date("Y");$tahun>=1985;$tahun--){ ?>
											<option value="<?=$tahun;?>" <?php if($tahun1==$tahun){ print 'selected'; }?>><?=$tahun;?></option>
											<?php } ?>
										</select>
									</div>
									<div class="col-sm-6" style="padding-bottom:5px">
										<select class="form-control" name="mp1" id="mp1">
											<option>Sila pilih matapelajaran</option>
											<?php $rssijil->movefirst();
											while(!$rssijil->EOF){ ?>
											<option value="<?=$rssijil->fields['kod'];?>" <?php if($mp1==$rssijil->fields['kod']){ print 'selected'; }?>><?=$rssijil->fields['DISKRIPSI'];?></option>
											<?php $rssijil->movenext(); } ?>
										</select>
									</div>
									<div class="col-sm-4" style="padding-bottom:5px">
										<select class="form-control" name="gred1" id="gred1">
											<option>Sila pilih gred</option>
											<?php for($bil=1;$bil<=9;$bil++){ ?>
											<option value="<?=$bil;?>" <?php if($gred1==$bil){ print 'selected'; }?>><?=$bil;?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								
								<div class="row">
									<div class="col-sm-2" style="padding-bottom:5px">
										<select class="form-control" name="tahun1" id="tahun1">
											<option>Sila pilih tahun</option>
											<?php for($tahun=date("Y");$tahun>=1985;$tahun--){ ?>
											<option value="<?=$tahun;?>" <?php if($tahun1==$tahun){ print 'selected'; }?>><?=$tahun;?></option>
											<?php } ?>
										</select>
									</div>
									<div class="col-sm-6" style="padding-bottom:5px">
										<select class="form-control" name="mp1" id="mp1">
											<option>Sila pilih matapelajaran</option>
											<?php $rssijil->movefirst();
											while(!$rssijil->EOF){ ?>
											<option value="<?=$rssijil->fields['kod'];?>" <?php if($mp1==$rssijil->fields['kod']){ print 'selected'; }?>><?=$rssijil->fields['DISKRIPSI'];?></option>
											<?php $rssijil->movenext(); } ?>
										</select>
									</div>
									<div class="col-sm-4" style="padding-bottom:5px">
										<select class="form-control" name="gred1" id="gred1">
											<option>Sila pilih gred</option>
											<?php for($bil=1;$bil<=9;$bil++){ ?>
											<option value="<?=$bil;?>" <?php if($gred1==$bil){ print 'selected'; }?>><?=$bil;?></option>
											<?php } ?>
										</select>
									</div>
								</div>



							</div>
							<div class="col-sm-4" align="center">
								<img src="<?=$sijil;?>" width="300" height="400">
								<input type="file" name="" class="form-control">
							</div>

						</div>
					</div>
					
					<div class="modal-footer" style="padding:0px;">
						<button type="button" id="simpan" class="btn btn-primary mt-sm mb-sm" onclick="do_save('SAVE','')"><i class="fa fa-save"></i> Simpan</button>
						&nbsp;
						<button type="button" class="btn btn-default" onclick="do_page('index.php?data=<?php print base64_encode('maklumat/pemantauan_list;DATA;Maklumat Pemantauan;;;;'); ?>')">
							<i class="fa fa-spinner" style="margin:0px;"></i> Kembali</button>
						<input type="hidden" name="progid" id="progid" value="<?php print $progid;?>" />
						<input type="hidden" name="proses" value="<?php print $proses;?>" />
					</div>
				</div>

			
			</div>
		</div>
	     

<script language="javascript" type="text/javascript">
//document.frm.gsasar_nama.focus();
</script>		 
