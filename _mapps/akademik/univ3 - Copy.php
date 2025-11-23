<div class="form-group">
	<div class="row">
		<div class="col-sm-8">
			<div class="form-group">
				<div class="row">
					<label for="nama" class="col-sm-4 control-label"><b>Tahun Graduasi<font color="#FF0000">*</font><div style="float:right">:</div></b></label>
					<div class="col-sm-3">
						<select class="form-control" name="tahun3" id="tahun3">
							<option value="">Sila pilih tahun</option>
							<?php for($t1=date("Y");$t1>=1978;$t1--){ ?>
							<option value="<?=$t1;?>" <?php if($rsUniv3->fields['tahun']==$t1){ print 'selected'; }?>><?=$t1;?></option>	
							<?php } ?>
						</select>
					</div>
				</div>
			</div>
			<?php $rfKelulusan = $conn->query("SELECT * FROM `ref_sijil_universiti` WHERE `sijil_YT`='Y' ORDER BY `sijil_susun`"); ?>
			<div class="form-group">
				<div class="row">
					<label for="nama" class="col-sm-4 control-label"><b>Peringkat Kelulusan <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
					<div class="col-sm-8">
						<select name="peringkat3" id="peringkat3" class="form-control">
							<option>Sila pilih peringkat kelulusan</option>
							<?php while(!$rfKelulusan->EOF){ ?>
							<option value="<?=$rfKelulusan->fields['sijil_kod'];?>" <?php if($rsUniv->fields['peringkat']==$rfKelulusan->fields['sijil_kod']){ print 'selected'; }?>><?php print $rfKelulusan->fields['sijil_nama'];?></option>	
							<?php $rfKelulusan->movenext(); } ?>
						</select>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<label for="nama" class="col-sm-4 control-label"><b>CGPA (PNGK) <div style="float:right">:</div></b></label>
					<div class="col-sm-2">
						<input type="text" name="cgpa3" id="cgpa32" class="form-control" value="<?=$rsUniv3->fields['cgpa'];?>">
					</div>
					<label for="nama" class="col-sm-6 control-label">Masukkan 0.00 jika tiada CGPA/ tidak berkenaan. <br>
					Pemohon tidak dibenarkan untuk membundarkan CGPA(PNGK).</label>
				</div>
			</div>

			<?php $rsInstitusi = $conn->query("SELECT * FROM `ref_institusi` WHERE `JENIS_INSTITUSI` IN (1,2) AND `SAH_YT`='Y' ORDER BY `DISKRIPSI` ASC "); ?>
			<div class="form-group">
				<div class="row">
					<label for="nama" class="col-sm-4 control-label"><b>Institusi yang mengeluarkan sijil <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
					<div class="col-sm-8">
						<select name="inst_keluar_sijil3" id="inst_keluar_sijil3" class="form-control select2 select2-accessible" style="width: 100%;" aria-hidden="true">
							<option value="">Sila pilih institusi</option>
							<?php while(!$rsInstitusi->EOF){ ?>
							<option value="<?=$rsInstitusi->fields['KOD'];?>" <?php if($rsUniv3->fields['inst_keluar_sijil']==$rsInstitusi->fields['KOD']){ print 'selected'; }?>><?php print $rsInstitusi->fields['DISKRIPSI'];?></option>	
							<?php $rsInstitusi->movenext(); } ?>
						</select>
					</div>
				</div>
			</div>

			<?php if(empty($rsUniv3->fields['inst_francais'])){ $inst_francais3='T'; } else { $inst_francais3 = $rsUniv3->fields['inst_francais']; } ?>
			<div class="form-group">
				<div class="row">
					<label for="nama" class="col-sm-4 control-label"><b>Institusi Francais Luar Negara <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
					<div class="col-sm-8">
						<input type="radio" name="inst_francais3" value="Y" <?php if($inst_francais3=='Y'){ print 'checked'; }?>> YA &nbsp; 
						<input type="radio" name="inst_francais3" value="T" <?php if($inst_francais3=='T'){ print 'checked'; }?>> TIDAK 
					</div>
				</div>
			</div>
			<?php if(empty($rsUniv3->fields['bidang'])){ $bidang3='S'; } else { $bidang3 = $rsUniv3->fields['bidang']; } ?>
			<div class="form-group">
				<div class="row">
					<label for="nama" class="col-sm-4 control-label"><b>Bidang pengkhususan <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
					<div class="col-sm-8">
						<input type="radio" name="bidang3" value="P" <?php if($bidang3=='P'){ print 'checked'; }?>> Pendidikan &nbsp; 
						<input type="radio" name="bidang3" value="B" <?php if($bidang3=='B'){ print 'checked'; }?>> Bukan Pendidikan &nbsp;
						<input type="radio" name="bidang3" value="S" <?php if($bidang3=='S'){ print 'checked'; }?>> Semua &nbsp; 
					</div>
				</div>
			</div>

			<?php $rsKhusus = $conn->query("SELECT * FROM `ref_pengkhususan` WHERE `JENIS` IN (1,2,3) ORDER BY `DISKRIPSI` ASC "); ?>
			<div class="form-group">
				<div class="row">
					<label for="nama" class="col-sm-4 control-label"><b>Pengkhususan  <font color="#FF0000">*</font><div style="float:right">:</div></b></label>
					<div class="col-sm-8">
						<select name="pengkhususan3" id="pengkhususan3" class="form-control select2 select2-accessible" style="width: 100%;" aria-hidden="true">
							<option value="">Sila pilih pengkhususan </option>
							<?php while(!$rsKhusus->EOF){ ?>
							<option value="<?=$rsKhusus->fields['kod'];?>" <?php if($rsUniv3->fields['pengkhususan']==$rsKhusus->fields['kod']){ print 'selected'; }?>><?php print $rsKhusus->fields['DISKRIPSI'];?></option>	
							<?php $rsKhusus->movenext(); } ?>
						</select>
					</div>
				</div>
			</div>
            <div class="form-group">
				<div class="row">
					<label for="nama" class="col-sm-4 control-label"><b>Keputusan MUET  <div style="float:right">:</div></b></label>
					<div class="col-sm-8">
						<select name="muet3" id="muet3" class="form-control">
							<option value="">Sila pilih </option>
							<option value="Band 1" <?php if($rsUniv3->fields['muet']=='Band 1'){ print 'selected'; }?>>Band 1</option>
							<option value="Band 2" <?php if($rsUniv3->fields['muet']=='Band 2'){ print 'selected'; }?>>Band 2</option>
							<option value="Band 3" <?php if($rsUniv3->fields['muet']=='Band 3'){ print 'selected'; }?>>Band 3</option>
							<option value="Band 4" <?php if($rsUniv3->fields['muet']=='Band 4'){ print 'selected'; }?>>Band 4</option>
						</select>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<label for="nama" class="col-sm-12 control-label"><b>Salah satu biasiswa yang diperolehi bagi salah satu pengajian di atas:</b></label>
				</div>
			</div>

			<?php $rsBiasiswa = $conn->query("SELECT * FROM `ref_biasiswa` WHERE 1 ORDER BY `kod_biasiswa` ASC "); ?>
			<div class="form-group">
				<div class="row">
					<label for="nama" class="col-sm-4 control-label"><b>Biasiswa Pengajian  <div style="float:right">:</div></b></label>
					<div class="col-sm-8">
						<select name="biasiswa3" id="biasiswa3" class="form-control">
							<option value="">Sila pilih biasiswa</option>
							<?php while(!$rsBiasiswa->EOF){ ?>
							<option value="<?=$rsBiasiswa->fields['kod_biasiswa'];?>" <?php if($rsUniv3->fields['biasiswa']==$rsBiasiswa->fields['kod_biasiswa']){ print 'selected'; }?>><?php print $rsBiasiswa->fields['biasiswa'];?></option>	
							<?php $rsBiasiswa->movenext(); } ?>
						</select>
						</select>
					</div>
				</div>
			</div>
		</div>

		<div class="col-sm-4" align="center">
			<img src="../upload_doc/PMR_Mock_Result_Statement_Certificate.png" width="300" height="400">
			<input type="file" name="" class="form-control">
		</div>

	</div>
</div>

